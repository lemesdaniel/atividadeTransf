@extends('adminlte::page')

@section('content')
<div class="card card-dark">
    <div class="card-header">
      <h3 class="card-title ">Histórico Transações</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Valor Anterior</th>
                    <th>Valor Atual</th>
                    <th>Tipo</th>
                    <th>Data</th>
                    <th>Usuario</th>
                </tr>
            </thead>
            <tbody>
                @forelse($historico as $hist)
                <tr>
                    <td class="text-center">{{ $hist->id }}</td>
                    <td class="text-center">R$ {{ number_format($hist->total_antes, 2,',','') }}</td>
                    <td class="text-center">R$ {{ number_format($hist->total_movimentacao, 2,',','') }}</td>
                    <td class="text-center">{{ $hist->type($hist->type) }}</td>
                    <td class="text-center">{{ $hist->data }}</td>
                    <td class="text-center">@if ($hist->user_id_transacao)
                        {{ $hist->userSender->name }}
                        @else
                         -
                        @endif
                    </td>
                </tr>
                @empty
                @endforelse
            </tbody>
        </table>
        <div class="paginate">
            {!! $historico->links() !!}
        </div>
    </div>
</div>
@endsection
@section('css')
<style>
    .paginate {
        float: right;
        padding: 15px;
    }
    </style>
@endsection
