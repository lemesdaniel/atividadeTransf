<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Utils;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateMeuPerfilRequest;

class UserController extends Controller
{
    public function meuperfil(){
        return view('site.meuperfil');
    }

    public function meuPerfilUpdate(UpdateMeuPerfilRequest $request){
        $user = Auth::user();
        $update = $request->all();

        if($update['password'] != null){
            $update['password'] = bcrypt($update['password']);
        }else{
            unset($update['password']);
        }

       $updateUser = $user->update($update);

       if($updateUser){
           return redirect()->route('meuperfil')->with('success', 'Cadastro atualizado com sucesso!');
       }

       return redirect()->back()->with('error', 'Erro ao atualizar cadastro!');
    }

    public function checarCpf(Request $request)
    {
        if (User::where([
                    ['cpf', $request->post('cpf')],
                    ['id', '<>', $request->post('id')],
                ])->count() > 0) {
            echo json_encode(1);
        } else if (Utils::validarCPF($request->post('cpf'))) {
            echo json_encode(2);
        } else {
            echo json_encode(0);
        }
    }
}
