@extends('layouts.app')

@section('navbar')
@include('layouts.navbar')
@endsection

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">CONSOLA DE BASE DE DATOS POSTGRES SQL</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('post_sql_console') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Sentecia SQL</label>
                            <textarea class="form-control" name="sql_query" cols="30" rows="10" placeholder="Escriba su Query SQl...">

                            </textarea>
                            @if ($errors->has('sql_query'))
                                <p class="alert text-danger">{{ $errors->first('sql_query') }}</p>
                            @endif
                        </div>
                        <div class="form-group float-right">
                            <input type="reset" class="btn btn-danger" value="Limpiar">
                            <input type="submit" class="btn btn-secondary" value="Procesar Query">
                        </div>
                    </form>
                </div>

                @if (session()->has('query_error'))
                <div class="card-body">
                    <p class="text-danger text-center">{{ session('query_error') }}</p>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>

@endsection
