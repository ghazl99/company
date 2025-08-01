<style>
    .custom-span {
        color: #2f97c9;
        text-shadow: -1px 0 #031b4e, 0 1px #031b4e, 1px 0 #031b4e, 0 -1px #031b4e;

    }

    .custom-title {
        color: #ff4d4c;
        text-shadow: -1px 0 #031b4e, 0 1px #031b4e, 1px 0 #031b4e, 0 -1px #031b4e;

    }
</style>
<!-- main-sidebar -->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar ps sidebar-scroll">
    <div class="main-sidebar-header active">
        <a class="desktop-logo logo-light active" href="{{ url('/' . ($page = 'index')) }}"><img
                src="{{ asset('assets/img/bros-cash.png') }}" class="main-logo" alt="logo"></a>
        <a class="desktop-logo logo-dark active" href="{{ url('/' . ($page = 'index')) }}"><img
                src="{{ asset('assets/img/bros-cash.png') }}" class="main-logo dark-theme" alt="logo"></a>
        <a class="logo-icon mobile-logo icon-light active" href="{{ url('/' . ($page = 'index')) }}"><img
                src="{{ asset('assets/img/bros-cash.png') }}" class="logo-icon" alt="logo"></a>
        <a class="logo-icon mobile-logo icon-dark active" href="{{ url('/' . ($page = 'index')) }}"><img
                src="{{ asset('assets/img/bros-cash.png') }}" class="logo-icon dark-theme" alt="logo"></a>
    </div>
    <div class="main-sidemenu">
        <div class="app-sidebar__user clearfix">
            <div class="dropdown user-pro-body">

                <div class="user-info">
                    <h3 class="custom-title"><span class="custom-span">B</span>ros <span class="custom-span">C</span>ash
                    </h3>
                </div>
            </div>
        </div>
        <ul class="side-menu">
            @hasanyrole('superAdmin|developer')
                <li class="side-item side-item-category">الأساسية</li>
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('dashboard') }}">
                        <i class="mdi mdi-home-variant side-menu__icon"></i>
                        <span class="side-menu__label">الرئيسية</span></a>
                </li>

                <li class="slide">
                    <a class="side-menu__item" href="{{ route('work.session') }}">
                        <i class="side-menu__icon mdi mdi-calendar-clock"></i>
                        <span class="side-menu__label">تسجيل الدوام</span>
                    </a>
                </li>

                <li class="side-item side-item-category">المهام</li>
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('task.index') }}">
                        <i class="mdi mdi-clipboard-text side-menu__icon "></i>
                        <span class="side-menu__label">إدارة المهام</span>
                        @role('developer')<span
                            class="badge badge-success side-badge">{{ auth()->user()->todayCandidateTasksCount() }}</span>@endrole</a>
                </li>
            @endhasanyrole
            @role('superAdmin')
                <li class="side-item side-item-category">المستخدمين</li>
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('user.index') }}">
                        <i class="mdi mdi-account-multiple side-menu__icon "></i>
                        <span class="side-menu__label">إدارة المستخدمين</span></a>
                </li>

                <li class="side-item side-item-category">النشاطات</li>
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('activitylog.index') }}">
                        <i class="mdi mdi-history  side-menu__icon "></i>
                        <span class="side-menu__label">جميع النشاطات</span></a>
                </li>
            @endrole

        </ul>
    </div>
</aside>
<!-- main-sidebar -->
