<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\Saldos;
use Illuminate\Http\Request;
use App\Models\Transferencias;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ValidacaoSaldoRequest;

class SaldosController extends Controller
{
    private $totalPage = 5;

    public function index(){

        $saldo = Auth::user()->saldo;
        $saldoFinal = $saldo ? $saldo->total : 0;


        return view('admin.saldo.index', compact('saldoFinal'));
    }

    public function deposito(){

        return view('admin.saldo.deposito');
    }

    public function depositoStore(ValidacaoSaldoRequest $request){

        $saldo = Auth::user()->saldo()->firstOrCreate([]);
        $response = $saldo->deposito($request->value);

        if($response['success']){
            return redirect()->route('saldo')->with('success', $response['message']);
        }else{
            return redirect()->back()->with('error', $response['message']);
        }

    }

    public function saque(){

        return view('admin.saldo.saque');
    }

    public function saqueStore(Request $request){

        $saldo = Auth::user()->saldo()->firstOrCreate([]);
        $response = $saldo->saque($request->value);

        if($response['success']){
            return redirect()->route('saldo')->with('success', $response['message']);
        }else{
            return redirect()->back()->with('error', $response['message']);
        }

    }

    public function transferencia(){

        return view('admin.saldo.transferencia');
    }

    public function transferenciaConfirmar(Request $request, User $user){
        if(!$sender = $user->getTransferencia($request->sender)){
            return redirect()->back()->with('error', 'Usuário não encontrado!');
        }

        if($sender->id === Auth::user()->id){
            return redirect()->back()->with('error', 'Não pode transferir para você mesmo!');
        }

        $saldo_total = Auth::user()->saldo->total;

            return view('admin.saldo.confirmacaoTransferencia', compact('sender','saldo_total'));
    }

    public function transferenciaStore(ValidacaoSaldoRequest $request, User $user){
        if(!$sender = $user->find($request->sender_id)){
            return redirect()->route('admin.saldo.transferencia')->with('success', 'Recebedor não encontrado!');
        }
            $saldo = Auth::user()->saldo()->firstOrCreate([]);
            $response = $saldo->transferencia($request->value, $sender);

            if($response['success']){
                return redirect()->route('saldo')->with('success', $response['message']);
            }else{
                return redirect()->route('saldo')->with('error', $response['message']);
            }


    }

    public function historico(Transferencias $transferencia){
        $historico = Auth::user()->historico()->with(['userSender'])->paginate($this->totalPage);

        $types = $transferencia->type();

        return view('admin.saldo.historico', compact('historico', 'types'));
    }
}
