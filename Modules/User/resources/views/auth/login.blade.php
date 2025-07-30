<!DOCTYPE html>
<html lang="en" dir="rtl" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login-Dashboard</title>
    <link rel="icon" href="{{ asset('assets/img/bros-cash.png') }}" type="image/png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('build/assets/css/main.css') }}">
    <style>
        body {
            font-family: 'value', sans-serif !important;
        }
    </style>
</head>

<body>
    <section id="hero" class="hero section">

        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="border-0 px-4 py-5">
                        <div class="theme-switch-wrapper">
                            <span>الوضع الليلي</span>
                            <label class="theme-switch" for="checkbox">
                                <input type="checkbox" id="checkbox" />
                                <div class="slider round"></div>
                            </label>
                        </div>
                        <form method="POST" action="{{ route('login') }}">
                            {{-- CSRF Token: Essential for Laravel security, protects against Cross-Site Request Forgery attacks. --}}
                            @csrf

                            <div class="row mb-4 px-3">
                                <h3 class="mb-0 mr-4 mt-2">تسجيل الدخول</h3>
                            </div>

                            <div class="form-group row px-3">
                                <label for="emailInput" class="mb-1">
                                    <h6 class="mb-0 text-sm">عنوان البريد الإلكتروني</h6>
                                </label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="emailInput" name="email" value="{{ old('email') }}"
                                    placeholder="أدخل عنوان بريد إلكتروني صالح" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group row px-3">
                                <label for="passwordInput" class="mb-1">
                                    <h6 class="mb-0 text-sm">كلمة المرور</h6>
                                </label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="passwordInput" name="password" placeholder="أدخل كلمة المرور" required
                                    autocomplete="current-password">

                                {{-- Error message display for the password field. --}}
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="row mb-3 px-3">
                                <button type="submit" class="btn btn-primary text-center btn-block">تسجيل
                                    الدخول</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-image">
                        <img src="{{ asset('assets/img/illustration-28.webp') }}" class="img-fluid floating"
                            alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // JavaScript for Dark Mode Toggle
        const toggleSwitch = document.querySelector('#checkbox');
        const htmlElement = document.querySelector('html');

        // Function to set the theme
        function setTheme(theme) {
            htmlElement.setAttribute('data-bs-theme', theme);
            localStorage.setItem('theme', theme); // Save theme preference
            toggleSwitch.checked = (theme === 'dark'); // Update toggle switch
        }

        // Check for saved theme preference on page load
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            setTheme(savedTheme);
        } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            // Check for user's system preference if no saved theme
            setTheme('dark');
        } else {
            setTheme('light'); // Default to light if no preference
        }

        // Listen for changes on the toggle switch
        toggleSwitch.addEventListener('change', function() {
            if (this.checked) {
                setTheme('dark');
            } else {
                setTheme('light');
            }
        });
    </script>
</body>

</html>
