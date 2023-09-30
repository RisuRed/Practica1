<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistroRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class user_controller extends Controller
{
     /*
    *
    *
    */
    public function store(RegistroRequest $request){
        // Valida los datos
        $data = $request->validated();
        $user = User::create(['name' => $data['name'], 'email' => $data['email'], 'password' => $data['password']]);
        if(is_null($user)){
            return response()->json(["Message"=>"Somthing wrong with create new user"], 400);
        }
        $role = Role::findByName($request->role);
        $role->users()->attach($user);
        return response()->json($user,200);    
    }
    
     /*
    *
    *
    */
    public function show($id){
        $user=User::find($id);
        if(is_null($user)){
            return response()->json(["Message"=>"User Not Found"], 400);
        }
        return response()->json($user,200); 
    }

     /*
    *
    *
    */
    public function index(){
        return response()->json(User::paginate(5),200); 
    }

     /*
    *
    *
    */
    public function update(RegistroRequest $request, $id){
        $data = $request->validated();

        $user=User::find($id);
        if(is_null($user)){
            return response()->json(["Error"=>"User Not Found"], 404);
        }
        //validar contraseña
        if(!Hash::check($data['password'], $user->password)){
            return response()->json(["Error"=>"Incorrect password"], 400);
        }
        //actualiza los datos del usuario
        //$user->update($request->all());
        $user -> name = $data['name'];
        $user -> email = $data['email'];
        $user -> password = Hash::make($request->new_password);
        $role = Role::findByName($request->role,'web');
        $user->syncRoles($role);
        $user->save();
        return response()->json($user,200);
    }
     /*
    *
    *
    */
    public function destroy($id){
        $user=User::find($id);
        if(is_null($user)){
            return response()->json(["Message"=>"User Not Found"], 400);
        }
        $user->delete($user);
        return response()->json(["Message"=>"User deleted"], 200);
    }
    
}
