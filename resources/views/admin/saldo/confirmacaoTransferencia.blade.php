@extends('adminlte::page')

@section('content')
<div class="card card-dark">
    <div class="card-header">
      <h3 class="card-title ">Confirmar Transferência de Saldo</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
            @include('includes.alerts')

            <p><strong>Recebedor: </strong>{{ $sender->name }} - {{ $sender->email }} </p>
            <form method="POST" action="{{ route('transferencia.store') }}">
                {!! csrf_field() !!}
                <input type="hidden" name="sender_id" value="{{ $sender->id }}">
                <p><strong>Saldo Atual: </strong>{{$saldo_total }}</p>
                <div class="col-md-12 form-group">
                    <input type="text" name="value" placeholder="Digite o valor a transferir" class="form-control">
                </div>
                <div class="form-group text-right">
                    <a href="{{ route('saldo') }}"">
                        <button type="button" class="btn btn-secondary">Voltar</button>
                    </a>
                    <button type="submit"  class="btn btn-md btn-primary">Transferir</button>
                </div>
            </form>
    </div>
</div>
@endsection
