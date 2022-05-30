<?php

namespace App;

use App\Models\Saldos;
use App\Models\Transferencias;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function saldo(){
        return $this->hasOne(Saldos::class);
    }

    public function transferencia(){
        return $this->hasMany(Transferencias::class);
    }

    public function historico(){
        return $this->hasMany(Transferencias::class);
    }

    public function getTransferencia($sender){
        return $this->where('name', 'LIKE', "%$sender%")
        ->orWhere('email', $sender)
        ->get()
        ->first();
    }
}
