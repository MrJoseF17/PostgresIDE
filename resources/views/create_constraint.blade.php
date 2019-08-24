@extends('layouts.app')

@section('navbar')
@include('layouts.navbar')
@endsection

@section('content')
<div class="container">
    <div class="row">
        @if (session()->has('query_error'))
        <div class="card-body">
            <p class="text-danger text-center">{{ session('query_error') }}</p>
        </div>
        @endif
    </div>
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <form method="post" action="{{ route('post_primary_key') }}">
                    @csrf

                    <div class="card-header text-center font-weight-bold">
                        <h3>Gestor de Llaves Primarias</h3>
                        <small>
                            Asignar Nueva Llave primaria De Base de Datos PostgresSQL
                        </small>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Seleccionar Tabla</label>
                            <select class="form-control custom-select" name="constraint_table">
                                @foreach ($table as $item)
                                <option value="{{ $item }}">{{$item}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('constraint_table'))
                            <p class="alert text-danger">{{ $errors->first('constraint_table') }}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Campo de Tabla</label>
                            <input type="text" placeholder="Ingresar el campo a hacer llave primaria" name="constraint_field" class="form-control">
                            @if ($errors->has('constraint_field'))
                            <p class="alert text-danger">{{ $errors->first('constraint_field') }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer">
                        <input type="submit" class="btn btn-dark btn-block" value="Asignar Llave">
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <form method="post" action="{{ route('post_foreign_key') }}">
                    @csrf
                    <div class="card-header text-center font-weight-bold">
                        <h3>Gestor de LLaves Foraneas</h3>
                        <small>
                            Crear Nueva Llave foranea en la Base de Datos PostgresSQL
                        </small>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Seleccionar Tabla para llave foranea</label>
                            <select class="form-control custom-select" name="table_foreign">
                                @foreach ($table as $item)
                                <option value="{{ $item }}">{{$item}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('table_foreign'))
                            <p class="alert text-danger">{{ $errors->first('table_foreign') }}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Llave foranea</label>
                            <input type="text" placeholder="Ingresar el campo foraneo" name="foreign_key" class="form-control">
                            @if ($errors->has('foreign_key'))
                            <p class="alert text-danger">{{ $errors->first('foreign_key') }}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Seleccionar Tabla Referencia</label>
                            <select class="form-control custom-select" name="ref_table">
                                @foreach ($table as $item)
                                <option value="{{ $item }}">{{$item}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('ref_table'))
                            <p class="alert text-danger">{{ $errors->first('ref_table') }}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Llave Primaria de Tabla Referencia</label>
                            <input type="text" placeholder="Ingresar el campo foraneo" name="ref_id" class="form-control">
                            @if ($errors->has('ref_id'))
                            <p class="alert text-danger">{{ $errors->first('ref_id') }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer">
                        <input type="submit" class="btn btn-dark btn-block" value="Asignar Llave Foranea">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
