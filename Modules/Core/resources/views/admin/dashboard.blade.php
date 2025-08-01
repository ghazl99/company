@extends('core::layouts.master')

@section('css')
    <link href="{{ URL::asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/jqvmap/jqvmap.min.css') }}" rel="stylesheet">

    {{-- Assuming Font Awesome is available, otherwise you'd link it here --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
@endsection

@section('content')
<br>
<div class="row row-sm">

    {{-- عدد المطورين (لـ superAdmin فقط) --}}
    @role('superAdmin')
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body d-flex align-items-center justify-content-between"> {{-- Added d-flex for icon alignment --}}
                    <div>
                        <h5 class="card-title">عدد المطورين</h5>
                        <p class="card-text">{{ $developersCount }}</p>
                    </div>
                    <i class="fas fa-users fa-3x"></i> {{-- Icon for developers count --}}
                </div>
            </div>
        </div>
    @endrole

    {{-- المهام العامة --}}
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="card-title">عدد المهام المخصصة</h5>
                    <p class="card-text">{{ $assignedCount }}</p>
                </div>
                <i class="fas fa-tasks fa-3x"></i> {{-- Icon for assigned tasks --}}
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="card-title">مهام مقبولة</h5>
                    <p class="card-text">{{ $acceptedCount }}</p>
                </div>
                <i class="fas fa-check-circle fa-3x"></i> {{-- Icon for accepted tasks --}}
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="card-title">مهام مكتملة</h5>
                    <p class="card-text">{{ $completedCount }}</p>
                </div>
                <i class="fas fa-clipboard-check fa-3x"></i> {{-- Icon for completed tasks --}}
            </div>
        </div>
    </div>

    {{-- فقط للمطور --}}
    @role('developer')
        <div class="col-md-3">
            <div class="card text-white bg-danger">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title">مهام مرفوضة</h5>
                        <p class="card-text">{{ $rejectedCount }}</p>
                    </div>
                    <i class="fas fa-times-circle fa-3x"></i> {{-- Icon for rejected tasks --}}
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-secondary">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title">مهام منتهية الصلاحية</h5>
                        <p class="card-text">{{ $expiredCount }}</p>
                    </div>
                    <i class="fas fa-hourglass-end fa-3x"></i> {{-- Icon for expired tasks --}}
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-dark">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title">ساعات اليوم</h5>
                        <p class="card-text">{{ $todayHours }} ساعة</p>
                    </div>
                    <i class="fas fa-clock fa-3x"></i> {{-- Icon for today's hours --}}
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title">ساعات الشهر</h5>
                        <p class="card-text">{{ $monthHours }} ساعة</p>
                    </div>
                    <i class="fas fa-calendar-alt fa-3x"></i> {{-- Icon for month's hours --}}
                </div>
            </div>
        </div>
    @endrole

</div>
@endsection

@section('js')
    {{-- Any existing JS for this page --}}
@endsection
