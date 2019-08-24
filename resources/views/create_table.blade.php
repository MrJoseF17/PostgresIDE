@extends('layouts.app')

@section('navbar')
@include('layouts.navbar')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <form method="post" action="{{ route('post_create_table') }}" id="create_table_form">
                    @csrf
                    <input type="hidden" id="array_fields" name="array_fields">
                    <input type="hidden" id="array_types" name="array_types">

                    <div class="card-header text-center font-weight-bold">
                        <h3>Gestor de Tablas</h3>
                        <small>
                            Crear Nueva Tabla De Base de Datos PostgresSQL
                        </small>
                    </div>
                    <div class="card-body">
                        <div class="form-group col-md-6">
                            <label>Nombre de Tabla</label>
                            <input type="text" name="table_name" class="form-control" placeholder="Ingresar texto...">
                            @if ($errors->has('table_name'))
                                <p class="alert text-danger">{{ $errors->first('table_name') }}</p>
                            @endif
                        </div>
                        <br>
                        <table id="new_table" class="table order-list ">
                            <tbody>
                                <tr style="display:block; width:100%;">
                                    <h5>Campos de Tabla</h5>
                                    @if ($errors->has('array_fields'))
                                        <p class="alert text-danger">{{ $errors->first('array_fields') }}</p>
                                    @endif
                                    @if ($errors->has('array_types'))
                                        <p class="alert text-danger">{{ $errors->first('array_types') }}</p>
                                    @endif
                                </tr>
                                <tr>
                                    <td width="50%">
                                        <input type="text" name="field_name0" class="form-control" placeholder="Nombre">
                                    </td>
                                    <td width="25%">
                                        <select class="form-control custom-select" name="field_type0">
                                            <option value="varchar" selected>Varchar</option>
                                            <option value="int">Number</option>
                                            <option value="date">Date</option>
                                            <option value="char">Char</option>
                                        </select>
                                    </td>
                                    {{--  <td width="25%">
                                        <input type="text" name="field_limit0" class="form-control" placeholder="Limite">
                                    </td>  --}}
                                    <td width="25%">
                                        <input type="button" class="deleteRow btn btn-md btn-danger " value="Eliminar"></td>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" style="text-align: left;">
                                        <a href="#" id="addColumn">
                                            <i class="fas fa-plus-circle"></i>
                                            Crear Campo
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="card-footer">
                        <input type="button" id="send_create_table" class="btn btn-dark btn-block" value="Crear Tabla">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
