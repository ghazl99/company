@extends('core::layouts.master')

@section('css')
    <link href="{{ URL::asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/jqvmap/jqvmap.min.css') }}" rel="stylesheet">
    {{-- <link href="{{ URL::asset('build/assets/css/custom.css') }}" rel="stylesheet" /> Add this line --}}
@endsection

@section('content')
<br>
<div class="row row-sm">

    {{-- عدد المطورين (لـ superAdmin فقط) --}}
    @role('superAdmin')
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">عدد المطورين</h5>
                    <p class="card-text">{{ $developersCount }}</p>
                </div>
            </div>
        </div>
    @endrole

    {{-- المهام العامة --}}
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">عدد المهام المخصصة</h5>
                <p class="card-text">{{ $assignedCount }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title">مهام مقبولة</h5>
                <p class="card-text">{{ $acceptedCount }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">مهام مكتملة</h5>
                <p class="card-text">{{ $completedCount }}</p>
            </div>
        </div>
    </div>

    {{-- فقط للمطور --}}
    @role('developer')
        <div class="col-md-3">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h5 class="card-title">مهام مرفوضة</h5>
                    <p class="card-text">{{ $rejectedCount }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-secondary">
                <div class="card-body">
                    <h5 class="card-title">مهام منتهية الصلاحية</h5>
                    <p class="card-text">{{ $expiredCount }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-dark">
                <div class="card-body">
                    <h5 class="card-title">ساعات اليوم</h5>
                    <p class="card-text">{{ $todayHours }} ساعة</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">ساعات الشهر</h5>
                    <p class="card-text">{{ $monthHours }} ساعة</p>
                </div>
            </div>
        </div>
    @endrole

</div>
@endsection
