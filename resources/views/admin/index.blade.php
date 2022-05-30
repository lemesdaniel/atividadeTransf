@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-2 flex-center position-ref full-height">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <br>
                    <div class="content">
                        <div class="title text-center" style="text:center; color:black; background:rgb(207, 206, 206); font-family:Times New Roman">
                            <h1><i>Sejam bem-vindos ao sistema <br><b>Atividade Transferência</b></i></h1>
                        </div>

                    </div>
                </div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                <br>
                </div>
                <h6><center>Leticia Youssef Almeida 2022</center></h6>
            </div>
        </div>
    </div>
</div>
@endsection
