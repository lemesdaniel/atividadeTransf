<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'=> 'Leticia Y Almeida',
            'email' => 'leticiayoussef.si@gmail.com',
            'cpf'=>'123.456.789-00',
            'password'=>bcrypt('123456')
        ]);

        User::create([
            'name'=> 'Usuario 1',
            'email' => 'contato1@gmail.com',
            'cpf'=>'001.234.567.89',
            'password'=>bcrypt('123456')
        ]);
    }
}
