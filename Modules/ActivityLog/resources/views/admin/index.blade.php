@extends('core::layouts.master')

@section('content')
    <br>
    <div class="card">
        <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
                <h4 class="card-title mg-b-0">سجل النشاطات</h4>
                <i class="mdi mdi-dots-horizontal text-gray"></i>
            </div>
            <p class="tx-12 tx-gray-500 mb-2">هنا يمكنك عرض وتتبع جميع نشاطات النظام.</p>

            {{-- Filters --}}
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">من تاريخ</label>
                    <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">إلى تاريخ</label>
                    <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">بحث عام</label>
                    <input type="text" name="search" class="form-control"
                        placeholder="ابحث في الأحداث أو الوصف أو المعرّف" value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">تصفية</button>
                </div>
            </form>
        </div>

        <div class="card-body">
            <div class="table-responsive-md">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الوصف</th>
                            <th>الحدث</th>
                            <th>المستخدم</th>
                            <th>التاريخ</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($activities as $activity)
                            <tr>
                                <td>{{ $activity->id }}</td>
                                <td>{{ $activity->description }}</td>
                                <td>{{ $activity->event }}</td>
                                <td>{{ optional($activity->causer)->name ?? 'غير معروف' }}</td>
                                <td>{{ $activity->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <a href="{{ route('activitylog.show', $activity->id) }}" class="btn btn-info btn-sm">
                                        <i class="mdi mdi-eye"></i> تفاصيل
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">لا توجد نشاطات حالياً</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                 <div class="d-flex justify-content-center mt-4">
                    {{ $activities->links() }}
                </div>
            </div>

            
        </div>
    </div>
@endsection
