<header class="navbar">
    <div class="container-fluid">
        <button class="navbar-toggler mobile-toggler hidden-lg-up" type="button">☰</button>
        <!-- <a class="navbar-brand" href="{{url('dashboard')}}"></a> -->
        <ul class="nav navbar-nav hidden-md-down">
            <li class="nav-item">
                <a class="nav-link navbar-toggler layout-toggler" href="#">☰</a>
            </li>
        </ul>
        <ul class="nav navbar-nav float-xs-right hidden-md-down">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <span class="hidden-md-down">@if( Session::has('admin_user') ) {{ ucfirst(Session::get('admin_user')->username) }} @endif</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{url('settings')}}"><i class="fa fa-user"></i> Ajustes</a>
                    <a class="dropdown-item" href="{{url('change-password')}}"><i class="fa fa-user"></i> Cambiar el password</a>
                    <a class="dropdown-item" href="{{url('logout')}}"><i class="fa fa-lock"></i> Cerrar Sesión</a>
                </div>
            </li>
        </ul>
    </div>
</header>
