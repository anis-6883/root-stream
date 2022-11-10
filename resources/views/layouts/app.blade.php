<!DOCTYPE html>
<html lang="en">
    <!-- Head -->
    @include('layouts.includes._head')

    <body class="sidebar-dark">
        <div class="main-wrapper">
            <!-- Sidebar -->
            @include('layouts.includes._sidebar')
            @include('layouts.includes._settings-sidebar')

            <div class="page-wrapper">
            <!-- Navbar -->
                @include('layouts.includes._navbar')

                <div class="page-content">
                    @yield('content')
                </div>

                <!-- Footer -->
                @include('layouts.includes._footer')
            </div>
            
            @include('layouts.includes._main-modal')
        </div>
        <!-- Scripts -->
        @include('layouts.includes._script')
    </body>
</html>
