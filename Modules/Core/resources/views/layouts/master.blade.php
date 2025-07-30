<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="Keywords"
        content="admin,admin dashboard,admin dashboard template,admin panel template,admin template,admin theme,bootstrap 4 admin template,bootstrap 4 dashboard,bootstrap admin,bootstrap admin dashboard,bootstrap admin panel,bootstrap admin template,bootstrap admin theme,bootstrap dashboard,bootstrap form template,bootstrap panel,bootstrap ui kit,dashboard bootstrap 4,dashboard design,dashboard html,dashboard template,dashboard ui kit,envato templates,flat ui,html,html and css templates,html dashboard template,html5,jquery html,premium,premium quality,sidebar bootstrap 4,template admin bootstrap 4" />
    @include('core::layouts.head')
    <style>
        body {
            font-family: 'value', sans-serif !important;
        }
    </style>

</head>

<body class="main-body app sidebar-mini">
    <!-- Loader -->
    <div id="global-loader">
        <img src="{{ URL::asset('assets/img/loader.svg') }}" class="loader-img" alt="Loader">
    </div>
    <!-- /Loader -->
    @include('core::layouts.main-sidebar')
    <!-- main-content -->
    <div class="main-content app-content">
        @include('core::layouts.main-header')
        <!-- container -->
        <div class="container-fluid">
            @yield('page-header')

            @yield('content')
            @include('core::layouts.sidebar')
            @include('core::layouts.models')
            @include('core::layouts.footer-scripts')
        </div>
    </div>
    {{-- dark/light mode  --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const body = document.body;
            const toggleBtn = document.getElementById('themeToggle');
            const themeIcon = document.getElementById('theme-icon');

            // تحميل الوضع المحفوظ
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                body.classList.add('dark-theme');
                body.classList.remove('light-theme');
                themeIcon.classList.replace('bi-moon-stars', 'bi-sun-fill');
            } else {
                body.classList.add('light-theme');
            }

            // تبديل الوضع عند الضغط
            toggleBtn.addEventListener('click', function() {
                body.classList.toggle('dark-theme');
                body.classList.toggle('light-theme');

                // تبديل الأيقونة
                if (body.classList.contains('dark-theme')) {
                    themeIcon.classList.replace('bi-moon-stars', 'bi-sun-fill');
                    localStorage.setItem('theme', 'dark');
                } else {
                    themeIcon.classList.replace('bi-sun-fill', 'bi-moon-stars');
                    localStorage.setItem('theme', 'light');
                }
            });
        });
    </script>

    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- رسائل الجلسة باستخدام Swal --}}
    <script>
        function getSwalThemeOptions() {
            const isDark = document.body.classList.contains('dark-theme');
            return isDark ?
                {
                    background: '#141b2d',
                    color: '#ffffff'
                } :
                {
                    background: '#ffffff',
                    color: '#000000'
                };
        }

        window.addEventListener('load', function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'نجاح',
                    text: @json(session('success')),
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    ...getSwalThemeOptions()
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'خطأ',
                    text: @json(session('error')),
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    ...getSwalThemeOptions()
                });
            @endif
        });
    </script>



</body>

</html>
