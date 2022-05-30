@extends('site.layout.app')
@section('title', 'Meu Perfil')
@section('content')
    <div class="col-md-12 text-center">
        <h3><i>Meu Perfil</i></h3>
    </div>
    <hr>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        @include('includes.alerts')
                        <form action="{{ route('meuperfil.update') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row card-selected p-3 mb-2 ">
                                <div class="card-header col-md-12">
                                    <div class="form-group">
                                        <label for="name"><b>Nome:</b></label>
                                        <input class="form-control" type="text" name="name" placeholder="Nome" value="{{ auth()->user()->name }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="email"><b>E-mail:</b></label>
                                        <input class="form-control" type="text" name="email" placeholder="E-mail" value="{{ auth()->user()->email }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="cpf"><b>CPF:</b></label>
                                        <input class="form-control" type="text" name="cpf" placeholder="CPF" value="{{ auth()->user()->cpf }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="password"><b>Senha:</b></label>
                                            <input class="form-control" type="password" name="password" placeholder="Senha">
                                    </div>
                                    <div class="form-group text-right">
                                        <a href="{{ route('admin') }}"">
                                            <button type="button" class="btn btn-secondary">Voltar</button>
                                        </a>
                                        <button type="submit" class="btn btn-md btn-primary">Atualizar Cadastro</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
<script type="text/javascript">
    $("#cpf").mask("999.999.999-99");

    $("#cpf").blur(function () {
        var _this = this;
        var id = $("#id").val();

        if ($(_this).val().length > 0) {
            $.ajax({
                url: BASE_URL + 'funcionario/checar-cpf',
                type: 'POST',
                data: {
                    cpf: $(_this).val(),
                    id: id
                },
                dataType: 'JSON',
                success: function (result) {
                    if (result == 0) {
                        $(_this).closest('.form-group').removeClass('has-error');
                    }
                    else if (result == 2) {
                        swal({
                            icon: 'error',
                            title: 'O CPF dado é inválido'
                        });

                        $(_this).closest('.form-group').addClass('has-error');
                        $(_this).closest('#cpf').val("");
                    }
                    else {
                        swal({
                            icon: 'error',
                            title: 'O CPF dado já está em uso pelo sistema'
                        });

                        $(_this).closest('.form-group').addClass('has-error');
                        $(_this).closest('#cpf').val("");
                    }
                }
            });
        }
    });
</script>
@endsection
