<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\LeadCreated;
use App\Events\LeadStatusChanged;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\UpdateLeadRequest;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    public function __construct(Request $request) 
    {
        if($request->user()->cannot('admin-equipe-vendas')) {
            abort(401, 'Acesso não autorizado. Apenas administradores ou membros da equipe de vendas podem acessar esta funcionalidade.');
        }
    }

    public function index(Request $request): Collection
    {
        return Lead::all();
    }

   
    public function store(Request $request): JsonResponse
    {
        $validated = Validator::make($request->all(), [
            "name" => "required",
            "email" => "required|email",
            "user_id" => "required"
        ]);

        if($validated->fails()) {
            return response()->json(["message" => "Não foi possível criar o lead."]);
        }

        $lead = Lead::create($request->all());
        event(new LeadCreated($lead));
        return response()->json(['Lead cadastrado com sucesso.', $lead], 201);
    }

    public function show(string $id): Lead
    {
        $lead = Lead::with('tasks')->find($id);

        if(!$lead) {
            return response()->json("Lead não encontrado.", 404);
         }

        return $lead;
    }

    public function update(UpdateLeadRequest $request, string $id): JsonResponse
    {
        $lead = Lead::findOrFail($id);

        if(!$lead) {
            return response()->json('Lead não encontrado.', 404); 
        }

        if($lead->status !== $request->input('status')) {
         $user = User::find($lead->user_id);   
         event(new LeadStatusChanged($user, $lead));
        }

        $lead->update($request->all());
        return response()->json(['Lead atualizado com sucesso.', $lead], 200);

    }

    public function destroy(string $id): JsonResponse
    {
        $lead = Lead::findOrFail($id);

        if(!$lead) {
            return response()->json('Lead não encotrado.', 404); 
        }
        
        $lead->delete();
        return response()->json('Lead deletado com sucesso.', 204);
    }
}
