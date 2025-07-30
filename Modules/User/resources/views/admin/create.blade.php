@extends('core::layouts.master')
@section('css')
<style>
    body.dark-theme .form-control {
        background-color: #1b2438;
        color: #fff;
        border: 1px solid #555;
    }

    body.dark-theme .form-control::placeholder {
        color: #aaa;
    }
</style>

@endsection

@section('content')
    <br>
    <div class="card">
        <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
                <h4 class="card-title mg-b-0">إضافة مطور جديد</h4>
                <i class="mdi mdi-dots-horizontal text-gray"></i>
            </div>
            <p class="tx-12 tx-gray-500 mb-2">أدخل تفاصيل المطور الجديد.</p>
        </div>
        <div class="card-body">
            <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Row 1: Name and Email --}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name">الاسم:</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">البريد الإلكتروني:</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Row 2: Phone and Specialization --}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="phone">الهاتف:</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                            name="phone" value="{{ old('phone') }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="specialization">الاختصاص:</label>
                        <input type="text" class="form-control @error('specialization') is-invalid @enderror"
                            id="specialization" name="specialization" value="{{ old('specialization') }}">
                        @error('specialization')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Row 3: Framework and Is Blocked --}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="framework">Framework:</label>
                        <input type="text" class="form-control @error('framework') is-invalid @enderror" id="framework"
                            name="framework" value="{{ old('framework') }}">
                        @error('framework')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                {{-- Row 4: Password and Confirm Password --}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="password">كلمة المرور:</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                            name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="password_confirmation">تأكيد كلمة المرور:</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                            required>
                    </div>
                </div>

                {{-- Row 5: CV Upload and Personal Photo --}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="cv">السيرة الذاتية (ملف PDF):</label>
                        <input type="file" class="form-control-file @error('cv') is-invalid @enderror" id="cv"
                            name="cv" accept=".pdf">
                        @error('cv')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="personal_photo">الصورة الشخصية (صور):</label>
                        <input type="file" class="form-control-file @error('personal_photo') is-invalid @enderror"
                            id="personal_photo" name="personal_photo" accept="image/*">
                        @error('personal_photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                {{-- End of new fields --}}

                <button type="submit" class="btn btn-success mt-3">حفظ </button>
                <a href="{{ route('user.index') }}" class="btn btn-secondary mt-3">إلغاء</a>
            </form>
        </div>
    </div>
@endsection


