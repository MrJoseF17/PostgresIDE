@extends('layouts.app')

@section('navbar')
@include('layouts.navbar')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <form method="post" action="{{ route('post_edit_procedure') }}">
                    @csrf
                    
                    @foreach ($procedure as $item)
                        <input type="hidden" name="old_procedure_name" value="{{ $item->proname }}">
                        <div class="card-header text-center font-weight-bold">
                            <h3>Editor de Funciones</h3>
                            <small>
                                Editar Función De Base de Datos PostgresSQL
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
                                    <label>Nuevo Nombre</label>
                                    <input type="text" placeholder="Ingresar Nombre de la funcion" name="procedure_name" value="{{ $item->proname }}" class="form-control">
                                    @if ($errors->has('procedure_name'))
                                    <p class="alert text-danger">{{ $errors->first('procedure_name') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea class="form-control" rows="15" name="procedure_query">
RETURNS void AS $helloWorld$
DECLARE
BEGIN
RAISE LOG 'Hello, %', name;
END;
$helloWorld$ LANGUAGE plpgsql;    
                                                                        </textarea>
                                    @if ($errors->has('procedure_query'))
                                    <p class="alert text-danger">{{ $errors->first('procedure_query') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <input type="submit" class="btn btn-dark btn-block" value="Editar Funcion">
                        </div>
                    @endforeach
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
