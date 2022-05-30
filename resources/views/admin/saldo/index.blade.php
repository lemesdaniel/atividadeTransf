@extends('adminlte::page')

@section('content')
<div class="card card-dark">
    <div class="card-header">
      <h3 class="card-title ">Saldos</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="card-footer">
            <a href="{{ route('saldo.deposito') }}" class="btn btn-md btn-primary">
                Recarregar
            </a>
            @if($saldoFinal >= 0)
                <a href="{{ route('saldo.saque') }}" class="btn btn-md btn-danger">
                    Sacar
                </a>
                <a href="{{ route('saldo.transferencia') }}" class="btn btn-md btn-info">
                    Transferência
                </a>
            @endif
        </div>
        @include('includes.alerts')
        <div class="small-box bg-success">
          <div class="inner">
            <h3>R$ {{ number_format($saldoFinal, 2,',','') }}</h3>
          </div>
          <div class="icon">
            <i class="ion ion-cash"></i>
          </div>
          <a href="{{ route('historico') }}" class="small-box-footer">
            Histórico
          </a>
        </div>
    </div>
@endsection
