@include('layouts.header')
@include('layouts.sidebar')
<main class="main">
    <div class="container-fluid">
        @yield('content')
    </div>
</main>
@include('layouts.footer')