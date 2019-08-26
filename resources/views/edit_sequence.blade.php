@extends('layouts.app')

@section('navbar')
@include('layouts.navbar')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <form method="post" action="{{ route('post_edit_sequence') }}">
                    @csrf
                    <input type="hidden" name="old_sequence_name" value="{{ $sequence[0]->sequence_name }}">
                
                    <div class="card-header text-center font-weight-bold">
                        <h3>Gestor de Secuencias</h3>
                        <small>
                            Editar Secuencia De Base de Datos PostgresSQL
                        </small>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" placeholder="Ingresar Nuevo Nombre de la secuencia" value="{{ $sequence[0]->sequence_name }}" name="sequence_name"
                                    class="form-control">
                                @if ($errors->has('sequence_name'))
                                <p class="alert text-danger">{{ $errors->first('sequence_name') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Sentecia SQL</label>
                                <textarea class="form-control" name="sequence_query" cols="30" rows="10">start with {{ $sequence[0]->start_value }} increment by {{ $sequence[0]->increment }} minvalue {{ $sequence[0]->minimum_value }} maxvalue {{ $sequence[0]->maximum_value }} cycle;</textarea>
                                @if ($errors->has('sequence_query'))
                                <p class="alert text-danger">{{ $errors->first('sequence_query') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <input type="submit" class="btn btn-dark btn-block" value="Crear Secuencia">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
