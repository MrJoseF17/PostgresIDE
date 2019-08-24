<nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
    <div class="container">

        <a class="navbar-brand" href="{{ route('home') }}">
            Postgres IDE
        </a>

        <button aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"
            class="navbar-toggler" data-target="#navbarResponsive" data-toggle="collapse" type="button">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('sql_console') }}">
                        Consola SQL
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a aria-expanded="false" aria-haspopup="true" class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"
                        id="navbarDropdown" role="button">
                        Gestor
                    </a>
                    <div aria-labelledby="navbarDropdown" class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('create_table') }}">
                            Crear Tabla
                        </a>
                        <a class="dropdown-item" href="{{ route('create_view') }}">
                            Crear Vista
                        </a>
                        <a class="dropdown-item" href="{{ route('create_index') }}">
                            Crear Indice
                        </a>
                        <a class="dropdown-item" href="{{ route('create_constraint') }}">
                            Crear Constraints
                        </a>
                        <a class="dropdown-item" href="{{ route('create_trigger') }}">
                            Crear Trigger
                        </a>
                        <a class="dropdown-item" href="{{ route('create_sequence') }}">
                            Crear Sequence
                        </a>
                        <a class="dropdown-item" href="{{ route('create_procedure') }}">
                            Crear Stored Procedures
                        </a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a aria-expanded="false" aria-haspopup="true" class="nav-link dropdown-toggle"
                        data-toggle="dropdown" href="#" id="navbarDropdown" role="button">
                            {{ Auth::user()->name }}
                    </a>
                    <div aria-labelledby="navbarDropdown" class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i>
                            Cerrar Sesion
                        </a>
                    </div>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>
