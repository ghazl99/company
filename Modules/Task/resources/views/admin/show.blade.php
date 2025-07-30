@extends('core::layouts.master')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>تفاصيل المهمة: {{ $task->title }}</h4>
        </div>
        <div class="card-body">
            <h5>المطورين المرشحين:</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>الاسم</th>
                        <th>الحالة</th>
                        <th>سبب الرفض</th> {{-- نعرض العمود دائمًا لسهولة العرض --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach($task->developers as $developer)
                        <tr>
                            <td>{{ $developer->name }}</td>
                            <td><b>{{ $developer->pivot->status }}</b></td>
                            <td>
                                @if ($developer->pivot->status === 'rejected')
                                    {{ $developer->pivot->reject_reason ?? '—' }}
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <hr>

            <h5>الصور المرفقة:</h5>
            <div class="row">
                @forelse ($task->getMedia('tasks') as $image)
                    <div class="col-md-3 mb-3">
                        <img src="{{ route('task.image', $image) }}" class="img-fluid rounded shadow">
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-muted">لا توجد صور مرفقة.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
