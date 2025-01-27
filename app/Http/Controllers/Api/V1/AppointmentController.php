<?php

namespace App\Http\Controllers\Api\V1; 

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function __construct(Request $request) 
    {
        if($request->user()->cannot('admin-equipe-vendas')) {
            abort(401, 'Acesso não autorizado. Apenas administradores ou membros da equipe de vendas podem acessar esta funcionalidade.');
        }
    }

    public function index(): Collection
    {
        return Appointment::with('lead')->get();
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'appointment_date' => 'required|date|after:now',
            'notes' => 'nullable|string',
        ]);
    
        $appointment = Appointment::create([
            'user_id' => $request->user()->id,
            'lead_id' => $validated['lead_id'],
            'appointment_date' => $validated['appointment_date'],
            'notes' => $validated['notes'] ?? null,
        ]);
    
        return response()->json(['message' => 'Compromisso agendado com sucesso', 'compromisso' => $appointment], 201);
    }

    public function show(string $id): Appointment
    {
        $appointment = Appointment::with('leads')->find($id);

        if(!$appointment) {
            return response()->json("Compromisso não encontrado.", 404);
         }

        return $appointment;
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $appointment = Appointment::findOrFail($id);

        if(!$appointment) {
            return response()->json('Compromisso não encontrado.', 404); 
        }

        $appointment->update($request->all());
        return response()->json(['Compromisso atualizado com sucesso.', $appointment], 200);
    }

    public function destroy(string $id): JsonResponse
    {
        $appointment = Appointment::findOrFail($id);

        if(!$appointment) {
            return response()->json('Compromisso não encotrado.', 404); 
        }
        
        $appointment->delete();
        return response()->json('Compromisso deletado com sucesso.', 204);
    }
}
