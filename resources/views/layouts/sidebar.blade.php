<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">

            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}"><i class="icon-speedometer"></i>dashboard</a>
            </li>



                @foreach(getModuleRoutes() as $route)

                    @if(isEnableModules(strtoupper($route->uri)))

                        <li class="nav-item nav-dropdown">
                            <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-puzzle"></i>{{ $route->uri }}</a>
                            <ul class="nav-dropdown-items">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route($route->action['as']) }}"><i class="icon-puzzle"></i>list category</a>
                                </li>
                            </ul>
                        </li>

                    @endif

                @endforeach



            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-puzzle"></i>استور ماژول</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link"><i class="icon-puzzle"></i>نصب ماژول 🥹 </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('module.upload') }}"><i class="icon-puzzle"></i>اپلود ماژول 🙃 </a>
                    </li>
                </ul>
            </li>

        </ul>
    </nav>
</div>
