<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Lead::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            "name" => "required",
            "email" => "required|email",
        ]);

        if($validated->fails()) {
            return response()->json(["message" => "Não foi possível criar o lead."]);
        }

        $lead = Lead::create($request->all());
        return response()->json(['Lead cadastrado com sucesso.', $lead],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $lead = Lead::find($id);

        if(!$lead) {
            return response()->json("Lead não encontrado.", 404);
         }

        return $lead;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $lead = $this->show($id);

        if($lead) {
            $lead->update($request->all());
            return response()->json(['Lead atualizado com sucesso.', $lead]);
        }

        return response()->json('Lead não encontrado.', 404); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lead = $this->show($id);

        if($lead) {
            $lead->delete();
            return response()->json('Lead deletado com sucesso.');
        }
        
        return response()->json('Lead não encotrado.'); 
    }
}
