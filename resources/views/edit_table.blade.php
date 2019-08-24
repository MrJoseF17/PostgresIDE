@extends('layouts.app')

@section('navbar')
@include('layouts.navbar')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <form method="post" action="{{ route('post_edit_table') }}" id="edit_table_form">
                    @csrf
                    <input type="hidden" value="{{ $name }}" name="old_table_name">
                    <input type="hidden" id="new_cols" name="new_cols">
                    <input type="hidden" id="new_types" name="new_types">

                    <div class="card-header text-center font-weight-bold">
                        <h3>Editanto Tabla {{ $name }}</h3>
                        <small>
                            A continuacion esta la estructura de la tabla {{ $name }}
                        </small>
                    </div>
                    <div class="card-body">
                        <div class="form-group col-md-8 offset-2">
                            <label>Nombre de Tabla</label>
                            <input type="text" value="{{ $name }}" class="form-control" name="table_name">
                        </div>

                        @foreach ($cols as $col => $name)
                            <div class="form-group col-md-8 offset-md-2">
                                <label>Campo {{ $name }}</label>
                                <input class="form-control table_item" type="text" name="{{ $name }}" value="{{ $name }}">
                            </div>
                            <div class="form-group col-md-8 offset-md-2">
                                <select class="form-control custom-select new_type" name="field_type_{{$name}}">
                                    <option value="varchar" selected>Varchar</option>
                                    <option value="int">Number</option>
                                    <option value="date">Date</option>
                                    <option value="char">Char</option>
                                </select>
                            </div>
                        @endforeach
                    </div>
                    <div class="card-footer">
                        <input type="button" id="send_edit_table" class="btn btn-dark btn-block" style="max-width:300px; margin:auto;" value="Editar Tabla">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
