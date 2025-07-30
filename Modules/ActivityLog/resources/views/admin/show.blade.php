@extends('core::layouts.master')

@section('content')
    <br>
    <div class="card">
        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
            <h4 class="card-title mg-b-0">تفاصيل النشاط #{{ $activity->id }}</h4>
            <a href="{{ route('activitylog.index') }}" class="btn btn-secondary btn-sm">رجوع</a>
        </div>
        <div class="card-body">
            {{-- عرض تفاصيل الخصائص properties --}}
            @if($activity->event == "Update" && is_iterable($activity->properties))
                @foreach($activity->properties as $section => $details)
                    @if(is_iterable($details))
                        <div class="card card-primary mb-3">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    {{ $section == 'attributes' ? 'القيم الجديدة' : ($section == 'old' ? 'القيم القديمة' : $section) }}
                                </h5>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>الحقل</th>
                                            <th>المحتوى</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $counter = 1; @endphp
                                        @foreach($details as $key => $value)
                                            <tr>
                                                <td>{{ $counter++ }}</td>
                                                <td>{{ $key }}</td>
                                                <td>
                                                    @if(is_iterable($value))
                                                        @foreach($value as $k2 => $v2)
                                                            {{ $k2 }} : {{ $v2 }}<br>
                                                        @endforeach
                                                    @elseif(filter_var($value, FILTER_VALIDATE_URL))
                                                        <a href="{{ $value }}" target="_blank">عرض الرابط</a>
                                                    @else
                                                        {{ $value }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <p><strong>{{ $section }}:</strong> {{ $details }}</p>
                    @endif
                @endforeach
            @else
                <h5>تفاصيل الخصائص (Properties):</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الحقل</th>
                            <th>القيمة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach($activity->properties->toArray() as $key => $value)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $key }}</td>
                                <td>
                                    @if(is_iterable($value))
                                        <pre>{{ json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                    @elseif(filter_var($value, FILTER_VALIDATE_URL))
                                        <a href="{{ $value }}" target="_blank">عرض الرابط</a>
                                    @else
                                        {{ $value }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

        </div>
    </div>
@endsection
