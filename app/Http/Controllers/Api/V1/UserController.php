<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function register(Request $request) 
    {
        $validated = Validator::make($request->all(), [
            'name' =>  'required',
            'email' =>  'email|required',
            'password' =>  'required',
            'c_password' => 'required|same:password',
            'role_id' => ['required', Rule::in(Role::ROLE_EQUIPE_VENDAS, Role::ROLE_CLIENTE)],
        ]);

        if($validated->fails()) {
            return response()->json(['Registro não aprovado', $validated->errors()]);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('myApp')->plainTextToken;
        $success['name'] = $user['name'];   
        return response()->json(['Usuário cadastrado com sucesso', $success]);
    }

    public function login(Request $request) 
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] = $user->createToken('myApp')->plainTextToken;
            $success['name'] = $user['name'];
            return response()->json(['Logado com sucesso', $success]);
        } else {
            return response()->json(['Sem autorização']);
        }
    }
}
