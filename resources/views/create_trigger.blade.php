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
        <div class="col-md-6">
            <div class="card">
                <form method="post" action="{{ route('post_create_trigger') }}">
                    @csrf

                    <div class="card-header text-center font-weight-bold">
                        <h3>Gestor de Triggers</h3>
                        <small>
                            Crear Nuevo Trigger De Base de Datos PostgresSQL
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
                                <input type="text" placeholder="Ingresar Nombre del Trigger" name="trigger_name" class="form-control">
                                @if ($errors->has('trigger_name'))
                                <p class="alert text-danger">{{ $errors->first('trigger_name') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Seleccionar Tiempo de Ejecucion del Trigger</label>
                                <select class="form-control custom-select" name="trigger_time">
                                    <option value="before">Before (Antes)</option>
                                    <option value="after">After (Despues)</option>
                                </select>
                                @if ($errors->has('trigger_time'))
                                <p class="alert text-danger">{{ $errors->first('trigger_time') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Seleccionar Evento</label>
                                <select class="form-control custom-select" name="trigger_event">
                                    <option value="insert">Insert</option>
                                    <option value="Update">Update</option>
                                    <option value="delete">Delete</option>
                                </select>
                                @if ($errors->has('trigger_event'))
                                <p class="alert text-danger">{{ $errors->first('trigger_event') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Seleccionar Tabla</label>
                                <select class="form-control custom-select" name="trigger_table">
                                    @foreach ($table as $item)
                                    <option value="{{ $item }}">{{$item}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('trigger_table'))
                                <p class="alert text-danger">{{ $errors->first('trigger_table') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea class="form-control" name="trigger_query" placeholder="Ingrese la Query de su Trigger aquí..."></textarea>
                                @if ($errors->has('trigger_query'))
                                <p class="alert text-danger">{{ $errors->first('trigger_query') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <input type="submit" class="btn btn-dark btn-block" value="Crear Trigger">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
