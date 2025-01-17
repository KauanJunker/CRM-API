<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\InteractionRecorded;
use App\Http\Controllers\Controller;
use App\Models\Interaction;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function __construct(Request $request) {
        if($request->user()->cannot('admin-equipe-vendas')) {
            abort(401);
        }
    }

    public function index()
    {
        return Task::with(['contact', 'lead'])->get();
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            "title" => "required",
            "description" => "required|string",
            "user_id" => "required",
            "contact_id" => "nullable|exists:contacts,id",
            "lead_id" => "nullable|exists:leads,id",
            "due_at" => "required|date_format:Y-m-d H:i:s"
        ]);

        if($validated->fails()) {
            return response()->json(["message" => "Não foi possível criar o task."]);
        }

        $lead = Task::create($request->all());
        return response()->json(["created" => true, $lead]);
    }

    public function show(string $id)
    {
        $task = Task::with(['contact', 'lead'])->find($id);

        if(!$task) {
           return response()->json("Contato não encontrado.", 404);
        }

        return $task;
    }

    public function update(Request $request, string $id)
    {
        $task = $this->show($id);

        if($task) {
            $task->update($request->all());
            return response()->json(['Contato atualizado com sucesso.', $task]);
        }
        
        return response()->json('Contato não encontrado.', 404);
    }
 
    public function destroy(string $id)
    {
        $task = $this->show($id);

        if($task) {
            $task->delete();
            return response()->json('Contato deletado com sucesso.');
        }
        
        return response()->json('Contato não encotrado.'); 
    }

    public function completeTask(Request $request, $taskId) 
    {
        $task = Task::findOrFail($taskId);
        $task->update(['done' => true]);

        Interaction::create([
            'lead_id' => $task->lead_id,
            'type' => 'task_completed',
            'details' => 'Tarefa completada' . $task->title,
        ]);

        event(new InteractionRecorded($task->lead, 'task_completed'));

        return response()->json(['message' => 'Tarefa finalizada.']);
    }
}
