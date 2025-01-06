<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Task::with(['contact', 'lead'])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            "title" => "required",
            "description" => "required|string",
            "contact_id" => "nullable|exists:contacts,id",
            "lead_id" => "nullable|exists:leads,id",
        ]);

        if($validated->fails()) {
            return response()->json(["message" => "Não foi possível criar o task."]);
        }

        $lead = Task::create($request->all());
        return response()->json(["created" => true, $lead]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::with(['contact', 'lead'])->find($id);

        if(!$task) {
           return response()->json("Contato não encontrado.", 404);
        }

        return $task;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task = $this->show($id);

        if($task) {
            $task->update($request->all());
            return response()->json(['Contato atualizado com sucesso.', $task]);
        }
        
        return response()->json('Contato não encontrado.', 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = $this->show($id);

        if($task) {
            $task->delete();
            return response()->json('Contato deletado com sucesso.');
        }
        
        return response()->json('Contato não encotrado.'); 
    }
}
