<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\InteractionRecorded;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\UpdateTaskRequest;
use App\Models\Interaction;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function __construct(Request $request) 
    {
        if($request->user()->cannot('admin-equipe-vendas')) {
            abort(401, 'Acesso não autorizado. Apenas administradores ou membros da equipe de vendas podem acessar esta funcionalidade.');
        }
    }

    public function index(): Collection
    {
        return Task::with(['contact', 'lead'])->get();
    }

    public function store(Request $request): JsonResponse
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
            return response()->json(["message" => "Não foi possível criar a task."]);
        }

        $lead = Task::create($request->all());
        return response()->json(["created" => true, $lead], 201);
    }

    public function show(string $id): Task
    {
        $task = Task::with(['contact', 'lead'])->find($id);

        if(!$task) {
           return response()->json("Task não encontrado.", 404);
        }

        return $task;
    }

    public function update(UpdateTaskRequest $request, string $id): JsonResponse
    {
        $task = Task::findOrFail($id);

        if(!$task) {
            return response()->json('Task não encontrada.', 404);
        }
        
        $task->update($request->all());
        return response()->json(['Task atualizado com sucesso.', $task], 200);
    }
 
    public function destroy(string $id): JsonResponse
    {
        $task = Task::findOrFail($id);

        if(!$task) {
            return response()->json('Task não encotrada.', 404); 
        }
        
        $task->delete();
        return response()->json('Task deletado com sucesso.', 204);
    }

    public function completeTask(Request $request, $taskId): JsonResponse 
    {
        $task = Task::findOrFail($taskId);

        if(!$task) {
            return response()->json('Task não encotrada.', 404); 
        }

        $task->update(['done' => true]);

        Interaction::create([
            'lead_id' => $task->lead_id,
            'type' => 'task_completed',
            'details' => 'Tarefa completada' . $task->title,
        ]);
        ds($task->lead);
        event(new InteractionRecorded($task->lead, 'task_completed'));

        return response()->json(['message' => 'Tarefa finalizada.'], 200);
    }
}
