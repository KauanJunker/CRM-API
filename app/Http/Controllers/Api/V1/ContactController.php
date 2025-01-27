<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\UpdateContactRequest;
use App\Models\Contact;
use App\Utils\Message;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function __construct(Request $request) 
    {
        if($request->user()->cannot('admin-equipe-vendas')) {
            abort(401, Message::AUTHORIZATION);
        }
    }

    public function index(): Collection
    {
        return Contact::with('tasks')->get();
    }

    public function store(Request $request): JsonResponse
    {
        $validated = Validator::make($request->all(), [
            "name" => "required", 
            "email" => "email|required|unique",
            "user_id" => "required"
        ]);
        
        if($validated->fails()) {
            return response()->json(["message" => "Não foi possível criar o contato."]);
        }

        $contact = Contact::create($request->all());
        return response()->json(['Contact cadastrado com sucesso.', $contact], 201);
    }

    public function show(string $id): Contact
    {
        $contact = Contact::with('tasks')->find($id);

        if(!$contact) {
           return response()->json("Contato não encontrado.", 404);
        }

        return $contact;
   }

    public function update(UpdateContactRequest $request, string $id): JsonResponse
    {
        $contact = Contact::findOrFail($id);

        if(!$contact) {
            return response()->json('Contato não encontrado.', 404);
        }
        
        $contact->update($request->all());
        return response()->json(['Contato atualizado com sucesso.', $contact], 200);
    }
    
    public function destroy(string $id): JsonResponse
    {
        $contact = Contact::findOrFail($id);

        if(!$contact) {
            return response()->json('Contato não encotrado.', 404);                          
        }
        
        $contact->delete();
        return response()->json('Contato deletado com sucesso.', 204);
    }
}
