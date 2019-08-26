@extends('layouts.app')

@section('navbar')
@include('layouts.navbar')
@endsection

@section('content')
<div class="container">
    <div class="row">
        @if (session()->has('new_view'))
        <div class="card-body">
            <p class="text-primary text-center">{{ session('new_view') }}</p>
        </div>
        @endif
        
        @if (session()->has('new_index'))
        <div class="card-body">
            <p class="text-primary text-center">{{ session('new_index') }}</p>
        </div>
        @endif

        @if (session()->has('new_primary'))
        <div class="card-body">
            <p class="text-primary text-center">{{ session('new_primary') }}</p>
        </div>
        @endif
        
        @if (session()->has('new_foreign'))
        <div class="card-body">
            <p class="text-primary text-center">{{ session('new_foreign') }}</p>
        </div>
        @endif

        @if (session()->has('new_trigger'))
        <div class="card-body">
            <p class="text-primary text-center">{{ session('new_trigger') }}</p>
        </div>
        @endif

        @if (session()->has('new_sequence'))
        <div class="card-body">
            <p class="text-primary text-center">{{ session('new_sequence') }}</p>
        </div>
        @endif
        
        @if (session()->has('new_procedure'))
        <div class="card-body">
            <p class="text-primary text-center">{{ session('new_procedure') }}</p>
        </div>
        @endif
    </div>
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-center font-weight-bold">Resumen de Bases de Datos</div>
                <div class="card-body">
                    <a href="#" id="btn_show_dbs">
                        <h5>Bases de Datos <span style="float:right;">({{ $quant_dbs }} )</span></h5>
                    </a>
                    <a href="#" id="btn_show_tables">
                        <h5>Tablas <span style="float:right;">({{ $quant_tables }} )</span></h5>
                    </a>
                    <a href="#" id="btn_show_views">
                        <h5>Vistas <span style="float:right;">({{ $quant_views }} )</span></h5>
                    </a>
                    <a href="#" id="btn_show_index">
                        <h5>Indices <span style="float:right;">({{ $quant_indexes }} )</span></h5>
                    </a>
                    <a href="#" id="btn_show_constraints">
                        <h5>Constraints <span style="float:right;">({{ $quant_constraints }} )</span></h5>
                    </a>
                    <a href="#" id="btn_show_triggers">
                        <h5>Triggers <span style="float:right;">({{ $quant_triggers }} )</span></h5>
                    </a>
                    <a href="#" id="btn_show_sequences">
                        <h5>Sequences <span style="float:right;">({{ $quant_sequences }} )</span></h5>
                    </a>
                    <a href="#" id="btn_show_stored_procedures">
                        <h5>Stored Procedures <span style="float:right;">( {{ $quant_procedures }} )</span></h5>
                    </a>
                </div>
            </div>
        </div>

        {{-- DBS --}}
        <div class="col-md-8 hide_information" id="dbs_information">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="display:inline-block;">
                        <b>Bases de Datos</b> Existentes Postgres
                        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal">
                            Crear DB <i class="fas fa-plus-circle"></i>
                        </button>
                    </h4>
                </div>
                <div class="card-body">
                    @foreach ($dbs as $item)
                    <div class="row p-2 mb-2" style="background:#fafafa;">
                        <div class="col-md-8">
                            <h5> {{$item->datname}}</h5>
                        </div>
                        <div class="col-md-4">
                            <form method="POST" action="{{ route('post_delete_database') }}" id="delete_database"
                                style="display:inline-block; float:right;">
                                @csrf
                                <input type="hidden" name="db_name" value="{{ $item->datname }}">
                                <input type="submit" class="btn btn-sm btn-danger" value="Eliminar">
                            </form>
                        </div>
                
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- TABLAS --}}
        <div class="col-md-8 hide_information" id="tables_information" style="display:none;">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="display:inline-block;">
                        <b>Tablas</b> Existentes de la Base de Datos
                        <a href="{{ route('create_table') }}" class="btn btn-sm btn-primary float-right">
                            Crear Tabla <i class="fas fa-plus-circle"></i>
                        </a>
                    </h4>
                </div>

                <div class="card-body">
                    @foreach ($tables as $item)
                        <div class="row p-2 mb-2" style="background:#fafafa;">
                            <div class="col-md-8">
                                <h5> {{$item}}</h5>
                            </div>
                            <div class="col-md-4">
                                <form method="POST" action="{{ route('post_delete_table') }}" style="display:inline-block; float:right;">
                                    @csrf
                                    <input type="hidden" name="table_name" value="{{ $item }}">
                                    <input type="submit" class="btn btn-sm btn-danger" value="Eliminar" >
                                </form>
                                <a href="{{ route('edit_table', [ 'name' => $item ]) }}" class="btn btn-sm btn-primary float-right" style="margin-right:10px;">Editar</a>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- VISTAS --}}
        <div class="col-md-8 hide_information" id="views_information" style="display:none;">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="display:inline-block;">
                        <b>Vistas</b> Existentes de la Base de Datos
                        <a href="{{ route('create_view') }}" class="btn btn-sm btn-primary float-right">
                            Crear Vista <i class="fas fa-plus-circle"></i>
                        </a>
                    </h4>
                </div>

                <div class="card-body">
                    @foreach ($views as $item)
                    <div class="row p-2 mb-2" style="background:#fafafa;">
                        <div class="col-md-8">
                            <h5>{{ $item->table_name }}</h5>
                            <small>{{ $item->view_definition }}</small>
                        </div>
                        <div class="col-md-4">
                            <form method="POST" action="{{ route('post_delete_view') }}" style="display:inline-block; float:right;">
                                @csrf
                                <input type="hidden" name="view_name" value="{{ $item->table_name }}">
                                <input type="submit" class="btn btn-sm btn-danger" value="Eliminar">
                            </form>
                            <a href="{{ route('edit_view', [ 'name' => $item->table_name ]) }}" class="btn btn-sm btn-primary float-right"
                                style="margin-right:10px;">Editar</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- INDICES --}}
        <div class="col-md-8 hide_information" id="index_information" style="display:none;">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="display:inline-block;">
                        <b>Indices</b> Existentes de la Base de Datos
                        <a href="{{ route('create_index') }}" class="btn btn-sm btn-primary float-right">
                            Crear Indice <i class="fas fa-plus-circle"></i>
                        </a>
                    </h4>
                </div>

                <div class="card-body">
                    @foreach ($indexes as $item)
                    <div class="row p-2 mb-2" style="background:#fafafa;">
                        <div class="col-md-8">
                            <h5> {{ $item->indexname }}</h5>
                            <small>{{ $item->tablename }} -> {{ $item->indexdef }}</small>
                        </div>
                        <div class="col-md-4">
                            <form method="POST" action="{{ route('post_delete_index') }}"
                                style="display:inline-block; float:right;">
                                @csrf
                                <input type="hidden" name="index_name" value="{{ $item->indexname }}">
                                <input type="hidden" name="index_table" value="{{ $item->tablename }}">
                                <input type="submit" class="btn btn-sm btn-danger" value="Eliminar">
                            </form>
                            <a href="{{ route('edit_index', [ 'name' => $item->indexname ]) }}" class="btn btn-sm btn-primary float-right"
                                style="margin-right:10px;">Editar</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Constraints --}}
        <div class="col-md-8 hide_information" id="constraints_information" style="display:none;">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="display:inline-block;">
                        <b>Constraints</b> Existentes de la Base de Datos
                        <a href="{{ route('create_constraint') }}" class="btn btn-sm btn-primary float-right">
                            Crear Constraint <i class="fas fa-plus-circle"></i>
                        </a>
                    </h4>
                </div>

                <div class="card-body">
                    @foreach ($primary as $item)
                    <div class="row p-2 mb-2" style="background:#fafafa;">
                        <div class="col-md-8">
                            <h5>{{ $item->table_name }}</h5>
                            <small>{{ $item->constraint_type }}</small>
                        </div>
                        <div class="col-md-4">
                            <form method="POST" action="{{ route('post_delete_primary_key') }}" style="display:inline-block; float:right;">
                            @csrf
                            <input type="hidden" name="primary_table" value="{{ $item->table_name }}">
                            <input type="hidden" name="primary_name" value="{{ $item->constraint_name }}">
                            <input type="submit" class="btn btn-sm btn-danger" value="Eliminar">
                            </form>
                            <a href="{{ route('edit_constraint', [ 'name' => $item->constraint_name ]) }}" class="btn btn-sm btn-primary float-right"
                                style="margin-right:10px;">Editar</a>
                        </div>
                    </div>
                    @endforeach
                    @foreach ($foreign as $item)
                    <div class="row p-2 mb-2" style="background:#fafafa;">
                        <div class="col-md-8">
                            <h5>{{ $item->constraint_name }}</h5>
                            <small>{{ $item->table_name }} -> {{ $item->constraint_type }}</small>
                        </div>
                        <div class="col-md-4">
                            <form method="POST" action="{{ route('post_delete_foreign_key') }}"
                            style="display:inline-block; float:right;">
                            @csrf
                            <input type="hidden" name="foreign_table" value="{{ $item->table_name }}">
                            <input type="hidden" name="foreign_name" value="{{ $item->constraint_name }}">
                            <input type="submit" class="btn btn-sm btn-danger" value="Eliminar">
                            </form>
                            <a href="{{ route('edit_constraint', [ 'name' => $item->constraint_name ]) }}" class="btn btn-sm btn-primary float-right"
                                style="margin-right:10px;">Editar</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Triggers --}}
        <div class="col-md-8 hide_information" id="triggers_information" style="display:none;">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="display:inline-block;">
                        <b>Triggers</b> Existentes de la Base de Datos
                        <a href="{{ route('create_trigger') }}" class="btn btn-sm btn-primary float-right">
                            Crear Trigger <i class="fas fa-plus-circle"></i>
                        </a>
                    </h4>
                </div>

                <div class="card-body">
                    @foreach ($triggers as $item)
                    <div class="row p-2 mb-2" style="background:#fafafa;">
                        <div class="col-md-8">
                            <h5>{{$item}}</h5>
                        </div>
                        <div class="col-md-4">
                            {{--  <form method="POST" action="{{ route('post_delete_table') }}"
                                style="display:inline-block; float:right;">
                                @csrf
                                <input type="hidden" name="table_name" value="{{ $item }}">
                                <input type="submit" class="btn btn-sm btn-danger" value="Eliminar">
                            </form>
                            <a href="{{ route('edit_table', [ 'name' => $item ]) }}" class="btn btn-sm btn-primary float-right"
                                style="margin-right:10px;">Editar</a>  --}}
                        </div>
                    
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Sequences --}}
        <div class="col-md-8 hide_information" id="sequences_information" style="display:none;">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="display:inline-block;">
                        <b>Sequencias</b> Existentes de la Base de Datos
                        <a href="{{ route('create_sequence') }}" class="btn btn-sm btn-primary float-right">
                            Crear Sequencia <i class="fas fa-plus-circle"></i>
                        </a>
                    </h4>
                </div>

                <div class="card-body">
                    @foreach ($sequences as $item)
                    <div class="row p-2 mb-2" style="background:#fafafa;">
                        <div class="col-md-8">
                            <h5> {{$item->sequence_name}} </h5>
                        </div>
                        <div class="col-md-4">
                            <form method="POST" action="{{ route('post_delete_sequence') }}"
                                style="display:inline-block; float:right;">
                                @csrf
                                <input type="hidden" name="sequence_name" value="{{ $item->sequence_name }}">
                                <input type="submit" class="btn btn-sm btn-danger" value="Eliminar">
                            </form>
                            <a href="{{ route('edit_sequence', [ 'name' => $item->sequence_name ]) }}" class="btn btn-sm btn-primary float-right"
                                style="margin-right:10px;">Editar</a>
                        </div>
                    
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Stored Procedures --}}
        <div class="col-md-8 hide_information" id="stored_procedures_information" style="display:none;">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="display:inline-block;">
                        <b>Procedimientos Almacenados</b> Existentes de la Base de Datos
                        <a href="{{ route('create_procedure') }}" class="btn btn-sm btn-primary float-right">
                            Crear Procedimiento <i class="fas fa-plus-circle"></i>
                        </a>
                    </h4>
                </div>

                <div class="card-body">
                    @foreach ($procedures as $item)
                    <div class="row p-2 mb-2" style="background:#fafafa;">
                        <div class="col-md-8">
                            <h5> {{$item->proname}} </h5>
                        </div>
                        <div class="col-md-4">
                            <form method="POST" action="{{ route('post_delete_procedure') }}"
                                style="display:inline-block; float:right;">
                                @csrf
                                <input type="hidden" name="procedure_name" value="{{ $item->proname }}">
                                <input type="submit" class="btn btn-sm btn-danger" value="Eliminar">
                            </form>
                            <a href="{{ route('edit_procedure', [ 'name' => $item->proname ]) }}"
                                class="btn btn-sm btn-primary float-right" style="margin-right:10px;">Editar</a>
                        </div>
                    
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>


<!-- CREATE DB MODAL -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('post_create_database') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">CREAR BASE DE DATOS POSTGRES</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" name="db_name" placeholder="Ingrese el nombre de su Base de Datos" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <input type="submit" class="btn btn-primary" value="Crear">
                </div>
            </div>
        </form>
    </div>
</div>


@endsection
