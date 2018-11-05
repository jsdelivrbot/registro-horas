<header class="navbar">
    <div class="container-fluid">
        <button class="navbar-toggler mobile-toggler hidden-lg-up" style="outline: none;" type="button">Menú</button>
    <!-- <a class="navbar-brand" href="{{url('dashboard')}}"></a> -->
        <ul class="nav navbar-nav hidden-md-down">
            <li class="nav-item">
                <a class="nav-link navbar-toggler layout-toggler" href="#">☰</a>
            </li>
        </ul>
        <ul class="nav navbar-nav float-xs-right">
            @if(session("type") == "user")
                <li class="nav-item">
                    <img src="{{(\App\Models\User::find(session("id"))->profile_image) ? \App\Models\User::find(session("id"))->profile_image : "/images/demo_image_uploader.png"}}"
                         style="border-radius: 50px;margin-top: -5px;margin-right: 5px;" width="50" alt="">
                </li>
            @endif
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button"
                   aria-haspopup="true" aria-expanded="false">
                    Ajustes
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item"
                       href="{{session("type") == "admin" ? route('settings') : route("settings-user")}}"><i
                                class="fa fa-user"></i> Cambiar el usuario</a>
                    <a class="dropdown-item"
                       href="{{session("type") == 'admin' ?  route('change-password') : route("change-password-user")}}"><i
                                class="fa fa-user"></i> Cambiar el password</a>
                    @if(session("type") == "user")
                        <a class="dropdown-item" href="{{route('change-avatar')}}"><i class="fa fa-photo"></i> Cambiar
                            imagen de perfil</a>
                    @endif
                    <a class="dropdown-item" href="{{url('logout')}}"><i class="fa fa-lock"></i> Cerrar sesión</a>
                </div>
            </li>
        </ul>
    </div>
</header>
