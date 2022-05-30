<?php



Auth::routes();

Route::group(['middleware' => ['auth'], 'namespace' => 'Admin'], function () {
    Route::get('admin', 'AdminController@index')->name('admin');

    Route::get('saldo', 'SaldosController@index')->name('saldo');

    Route::get('saldo/deposito', 'SaldosController@deposito')->name('saldo.deposito');
    Route::post('saldo/deposito', 'SaldosController@depositoStore')->name('deposito.store');

    Route::get('saldo/saque', 'SaldosController@saque')->name('saldo.saque');
    Route::post('saldo/saque', 'SaldosController@saqueStore')->name('saque.store');

    Route::get('saldo/transferencia', 'SaldosController@transferencia')->name('saldo.transferencia');
    Route::post('confirmar/transferencia', 'SaldosController@transferenciaConfirmar')->name('transferencia.confirmar');
    Route::post('saldo/transferencia', 'SaldosController@transferenciaStore')->name('transferencia.store');

    Route::get('historico', 'SaldosController@historico')->name('historico');

});

Route::get('meu_perfil', 'Admin\UserController@meuperfil')->name('meuperfil')->middleware('auth');
Route::post('atualizar-perfil', 'Admin\UserController@meuPerfilUpdate')->name('meuperfil.update')->middleware('auth');
Route::post('meu_perfil/checar-cpf', 'Admin\UserController@checarCpf');

Route::group(['middleware' => ['auth'], 'namespace' => 'Site'], function () {
    Route::get('/', 'SiteController@index')->name('home');
});
