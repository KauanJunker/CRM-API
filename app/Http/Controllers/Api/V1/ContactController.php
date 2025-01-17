<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\UpdateContactRequest;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function __construct(Request $request) {
        if($request->user()->cannot('admin-equipe-vendas')) {
            abort(401);
        }
    }

    public function index()
    {
        return Contact::with('tasks')->get();
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            "name" => "required", 
            "email" => "email"
        ]);
        
        if($validated->fails()) {
            return response()->json(["message" => "Não foi possível criar o contato."]);
        }

        $contact = Contact::create($request->all());
        return response()->json(["created" => true, $contact]);
        
    }

    public function show(string $id)
    {
        $contact = Contact::with('tasks')->find($id);

        if(!$contact) {
           return response()->json("Contato não encontrado.", 404);
        }

        return $contact;
   }

    public function update(UpdateContactRequest $request, string $id)
    {
        $contact = $this->show($id);

        if($contact) {
            $contact->update($request->all());
            return response()->json(['Contato atualizado com sucesso.', $contact]);
        }
        
        return response()->json('Contato não encontrado.', 404);
    }
    
    public function destroy(string $id)
    {
        $contact = $this->show($id);

        if($contact) {
            $contact->delete();
            return response()->json('Contato deletado com sucesso.');
        }
        
        return response()->json('Contato não encotrado.');                          
    }
}
