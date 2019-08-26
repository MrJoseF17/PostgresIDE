@extends('layouts.app')

@section('navbar')
@include('layouts.navbar')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                @foreach ($constraint as $item)
                    @if ($item->constraint_type == "PRIMARY KEY")
                        <form method="post" action="{{ route('post_edit_primary') }}">
                            @csrf
                            <input type="hidden" name="primary_name" value="{{ $item->constraint_name }}">
                            <div class="card-header text-center font-weight-bold">
                                <h3>Editor de Llave Primaria</h3>
                                <small>
                                    Editar Constraint De Base de Datos PostgresSQL
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
                                        <label>Tabla</label>
                                        <input type="text" value="{{ $item->table_name }}" name="primary_table"
                                            class="form-control" readonly="readonly">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Campo Llave Primaria</label>
                                        <input type="text" placeholder="Ingresar Campo Llave Primaria" name="primary_key" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <input type="submit" class="btn btn-dark btn-block" value="Editar Constraint">
                            </div>
                        </form>                        
                    @else
                        <form method="post" action="{{ route('post_edit_foreign') }}">
                            @csrf
                            <input type="hidden" name="foreign_name" value="{{ $item->constraint_name }}">
                            <div class="card-header text-center font-weight-bold">
                                <h3>Editor de Llave Foranea</h3>
                                <small>
                                    Editar Constraint De Base de Datos PostgresSQL
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
                                        <label>Tabla</label>
                                        <input type="text" value="{{ $item->table_name }}" name="foreign_table" class="form-control"
                                            readonly="readonly">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Campo Llave Foranea</label>
                                        <input type="text" placeholder="Ingresar Campo Llave Foranea" name="foreign_key" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
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
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Llave Primaria de Tabla Referencia</label>
                                        <input type="text" placeholder="Ingresar el campo foraneo" name="ref_field" class="form-control">
                                        @if ($errors->has('ref_field'))
                                        <p class="alert text-danger">{{ $errors->first('ref_field') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <input type="submit" class="btn btn-dark btn-block" value="Editar Constraint">
                            </div>
                        </form>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
