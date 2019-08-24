@extends('layouts.app')

@section('navbar')
@include('layouts.navbar')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <form method="post" action="{{ route('post_create_index') }}">
                    @csrf
                    <div class="card-header text-center font-weight-bold">
                        <h3>Gestor de Indices</h3>
                        <small>
                            Crear Nuevo Indice De Base de Datos PostgresSQL
                        </small>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            @if ($errors->has('query_error'))
                            <p class="alert text-danger">{{ $errors->first('query_error') }}</p>
                            @endif
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" placeholder="Ingresar Nombre de indice" name="index_name" class="form-control">
                                @if ($errors->has('index_name'))
                                <p class="alert text-danger">{{ $errors->first('index_name') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Seleccionar Tabla</label>
                                <select class="form-control custom-select" name="index_table">
                                    @foreach ($table as $item)
                                        <option value="{{ $item }}">{{$item}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('table_index'))
                                <p class="alert text-danger">{{ $errors->first('table_index') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Campo de Tabla</label>
                                <br><small><i class="fas fa-info-circle"></i> Si es mas de un campo, separarlos con comas</small>
                                <input type="text" placeholder="Ingresar el campo de su tabla" name="index_fields" class="form-control">
                                @if ($errors->has('index_fields'))
                                <p class="alert text-danger">{{ $errors->first('index_fields') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <input type="submit" class="btn btn-dark" value="Crear Index">
                        <input type="reset" class="btn btn-danger" value="Limpiar">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
