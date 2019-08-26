@extends('layouts.app')

@section('navbar')
@include('layouts.navbar')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <form method="post" action="{{ route('post_edit_view') }}">
                    @csrf                 
                    <div class="card-header text-center font-weight-bold">
                        <h3>Gestor de Vistas</h3>
                        <small>
                            Editar Vista De Base de Datos PostgresSQL
                        </small>
                    </div>
                    <div class="card-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nombre</label>
                                @foreach ($view as $item)
                                <input type="hidden" name="old_view_name" value="{{ $item->table_name }}">
                                <input type="text" name="new_view_name" class="form-control" value="{{ $item->table_name }}">
                                @endforeach
                                @if ($errors->has('old_view_name'))
                                <p class="alert text-danger">{{ $errors->first('old_view_name') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea class="form-control" name="new_view_query"
                                    placeholder="Ingrese la Query de su Vista aquí..."></textarea>
                                @if ($errors->has('new_view_query'))
                                <p class="alert text-danger">{{ $errors->first('new_view_query') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <input type="submit" class="btn btn-dark" value="Editar Vista">
                        <input type="reset" class="btn btn-danger" value="Limpiar">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
