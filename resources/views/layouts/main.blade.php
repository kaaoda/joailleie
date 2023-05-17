<!DOCTYPE html>
<html lang="en">

@include("components.head")

<body>
    <div class="loader"></div>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            @include('components.navbar')
            @include('components.sidebar')
            <!-- Main Content -->
            <div class="main-content">
                @yield('mainContent')
            </div>
            @include('components.footer')
        </div>
    </div>
    <!-- General JS Scripts -->
    <script src="{{asset('assets/js/app.min.js')}}"></script>
    @stack("pageScripts")
    <!-- Template JS File -->
    <script src="{{asset('assets/js/scripts.js')}}"></script>
    <!-- Custom JS File -->
    <script src="{{asset('assets/js/custom.js')}}"></script>
    @stack("extraScripts")
</body>


<!-- index.html  21 Nov 2019 03:47:04 GMT -->

</html>
