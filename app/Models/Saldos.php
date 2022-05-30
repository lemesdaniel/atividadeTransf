<?php

namespace App\Models;

use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Saldos extends Model
{
    protected $fillable = [
        'id', 'user_id', 'total'
    ];


    public function deposito($value){

        DB::beginTransaction();

        $totalAntes =  $this->total ? $this->total : 0;
        $this->total += $value;
        $deposito = $this->save();

        $transferencia = Auth::user()->transferencia()->create([
            'type' => 'R',
            'total_movimentacao' => $value,
            'total_antes' => $totalAntes,
            'total_depois' => $this->total,
            'data' => date('Y-m-d')
        ]);

        if($deposito && $transferencia){

            DB::commit();
            return[
                'success' => true,
                'message' => 'Recarga realizada com sucesso!!',
            ];

        }else{

            DB::rollback();
            return[
                'error' => false,
                'message' => 'Erro! Verifique novamente!',
            ];
        }
    }


    public function saque(float $value) : Array{
        if($this->total < $value){
            return [
                'success' => false,
                'message' => 'Saldo insuficiente! Tente outro valor.'
            ];
        }
        DB::beginTransaction();

        $totalAntes =  $this->total ? $this->total : 0;
        $this->total -= $value;
        $saque = $this->save();

        $transferencia = Auth::user()->transferencia()->create([
            'type' => 'S',
            'total_movimentacao' => $value,
            'total_antes' => $totalAntes,
            'total_depois' => $this->total,
            'data' => date('Y-m-d')
        ]);

        if($saque && $transferencia){

            DB::commit();
            return[
                'success' => true,
                'message' => 'Saque realizada com sucesso!!',
            ];

        }else{

            DB::rollback();
            return[
                'error' => false,
                'message' => 'Erro! Verifique novamente!',
            ];
        }
    }

    public function transferencia(float $value, User $sender) : Array{
        if($this->total < $value){
            return [
                'success' => false,
                'message' => 'Saldo insuficiente! Tente outro valor.'
            ];
        }
        DB::beginTransaction();

        /**Atualiza proprio saldo */
        $totalAntes =  $this->total ? $this->total : 0;
        $this->total -= $value;
        $transfer = $this->save();

        $transferencia = Auth::user()->transferencia()->create([
            'type' => 'T',
            'total_movimentacao' => $value,
            'total_antes' => $totalAntes,
            'total_depois' => $this->total,
            'user_id_transacao' => $sender->id,
            'data' => date('Y-m-d')
        ]);

        /**Atualiza saldo recebedor */
        $saldoUsuario = $sender->saldo()->firstOrCreate([]);
        $totalAntesUsuario =  $saldoUsuario->total ? $saldoUsuario->total : 0;
        $saldoUsuario->total += $value;
        $transferenciaUsuario = $saldoUsuario->save();

        $usuarioTransferencia = $sender->transferencia()->create([
            'type' => 'R',
            'total_movimentacao' => $value,
            'total_antes' => $totalAntesUsuario,
            'total_depois' => $saldoUsuario->total,
            'user_id_transacao' => Auth::user()->id,
            'data' => date('Y-m-d')
        ]);

        if($transfer && $transferencia && $transferenciaUsuario && $usuarioTransferencia){

            DB::commit();
            return[
                'success' => true,
                'message' => 'Transferencia realizada com sucesso!!',
            ];

        }

        DB::rollback();
        return[
            'error' => false,
            'message' => 'Erro! Verifique novamente!',
        ];

    }
}
