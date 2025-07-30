@extends('core::layouts.master')

@section('css')
    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    <!--Internal  TelephoneInput css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
@endsection

@section('content')
<br>
    <div class="card">
        <div class="card-header">
            <h4>إضافة مهمة جديدة</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('task.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="title">عنوان المهمة</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                            required value="{{ old('title') }}">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="estimated_hours">عدد الساعات المقدّرة</label>
                        <input type="number" name="estimated_hours"
                            class="form-control @error('estimated_hours') is-invalid @enderror"
                            value="{{ old('estimated_hours') }}">
                        @error('estimated_hours')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="developers">المطورين</label>
                        <select name="developers[]" multiple="multiple"
                            class="testselect2 form-control @error('developers') is-invalid @enderror" required>
                            @foreach ($developers as $developer)
                                <option value="{{ $developer->id }}"
                                    {{ collect(old('developers'))->contains($developer->id) ? 'selected' : '' }}>
                                    {{ $developer->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('developers')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="images">رفع صور (أكثر من صورة)</label>
                        <input type="file" name="images[]" multiple class="form-control">
                        <small class="text-muted">يمكنك رفع أكثر من صورة معًا.</small>
                    </div>


                    <div class="col-md-12 form-group">
                        <label for="description">وصف المهمة</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">حفظ المهمة</button>
            </form>
        </div>
    </div>
@endsection

@section('js')

    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>


    <!--Internal  Form-elements js-->
    <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <!--Internal Sumoselect js-->
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>

@endsection
