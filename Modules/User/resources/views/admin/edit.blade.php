@extends('core::layouts.master')

@section('css')
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <br>
    <div class="card">
        <div class="card-header pb-0">
            <h4 class="card-title">تعديل المطور</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Name + Email --}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>الاسم:</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label>البريد الإلكتروني:</label>
                        <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}">
                    </div>
                </div>

                {{-- Phone + Specialization --}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>الهاتف:</label>
                        <input type="text" class="form-control" name="phone" value="{{ old('phone', $user->phone) }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label>الاختصاص:</label>
                        <input type="text" class="form-control" name="specialization" value="{{ old('specialization', $user->specialization) }}">
                    </div>
                </div>

                {{-- Framework + is_blocked --}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Framework:</label>
                        <input type="text" class="form-control" name="framework" value="{{ old('framework', $user->framework) }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label>محظور؟</label><br>
                        <input type="checkbox" name="is_blocked" value="1" {{ $user->is_blocked ? 'checked' : '' }}>
                        <label for="is_blocked">نعم</label>
                    </div>
                </div>

                {{-- CV + صورة شخصية --}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>السيرة الذاتية:</label>
                        <input type="file" class="form-control-file" name="cv" accept=".pdf">
                    </div>
                    <div class="form-group col-md-6">
                        <label>الصورة الشخصية:</label>
                        <input type="file" class="form-control-file" name="personal_photo" accept="image/*">
                    </div>
                </div>

                <button type="submit" class="btn btn-success mt-3">تحديث</button>
                <a href="{{ route('user.index') }}" class="btn btn-secondary mt-3">إلغاء</a>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
@endsection
