<div class="sidebar">

    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="{{url('dashboard')}}"><i class="icon-speedometer"></i> Dashboard </a>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="fa fa-list-alt"></i>Trabajadores</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('users')}}">
                        <i class="nav-icon icon-puzzle"></i> Lista</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('users/add')}}">
                        <i class="fa fa-plus"></i> Agregar</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="fa fa-list-alt"></i>Proyectos</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('projects')}}">
                        <i class="nav-icon icon-puzzle"></i> Lista</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('projects/add')}}">
                        <i class="fa fa-plus"></i> Agregar</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="fa fa-list-alt"></i> Registro de hora</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('hour-registration')}}">
                        <i class="nav-icon icon-puzzle"></i> Lista</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('hour-registration/add')}}">
                        <i class="fa fa-plus"></i> Agregar</a>
                    </li>
                </ul>
            </li>
            
        </ul>
    </nav>
</div>
