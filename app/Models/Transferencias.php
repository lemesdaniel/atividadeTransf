<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Transferencias extends Model
{
    protected $fillable = [
        'type','total_movimentacao','total_antes','total_depois','user_id_transacao','data'
    ];

    public function getDataAttribute($data){
        return Carbon::parse($data)->format('d/m/Y');
    }

    public function type($type = null){
        $types = [
            'R' => 'Depósito',
            'S' => 'Saque',
            'T' => 'Transferencia'
        ];

        if(!$type){
            return $types;
        }

        if($this->user_id_transacao != null && $type == 'R'){
            return 'Recarga';
        }

        if($this->user_id_transacao != null && $type == 'S'){
            return 'Saque';
        }

        return $types[$type];
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function userSender(){
        return $this->belongsTo(User::class, 'user_id_transacao');
    }
    
}
