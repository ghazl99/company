@extends('core::layouts.master')
<link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
{{-- imageModal css --}}
<link rel="stylesheet" href="{{ URL::asset('build/assets/css/imageModal.css') }}">
@section('content')
    <br>
    @role('superAdmin')
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0">قائمة المهام</h4>
                    <i class="mdi mdi-dots-horizontal text-gray"></i>
                </div>
                <p class="tx-12 tx-gray-500 mb-2">إدارة المهام في نظامك.</p>
                {{-- ADD BUTTON HERE --}}
                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('task.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> إضافة مهمة جديدة
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive-md">
                    <table class="table table-bordered" id="tasks-table">
                        <thead>
                            <tr>
                                <th>العنوان</th>
                                <th>الساعات المقدرة</th>
                                <th>الحالة</th>
                                <th>الوصف</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td>{{ $task->title }}</td>
                                    <td>{{ $task->estimated_hours }}</td>
                                    <td>{{ $task->status }}</td>
                                    <td>{{ $task->description }}</td>
                                    <td>
                                        <a href="{{ route('task.show', $task->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> تفاصيل
                                        </a>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center mt-4">
                        {{ $tasks->links() }}
                    </div>


                </div>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0">قائمة المهام</h4>
                    <i class="mdi mdi-dots-horizontal text-gray"></i>
                </div>
                <p class="tx-12 tx-gray-500 mb-2">إدارة المهام في نظامك.</p>
            </div>
            <div class="card-body">
                <div class="table-responsive-md">
                    <table class="table table-bordered" id="tasks-table">
                        <thead>
                            <tr>
                                <th>العنوان</th>
                                <th>الساعات المقدرة</th>
                                <th>الحالة</th>
                                <th>الوصف</th>
                                <th>المرفقات</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td>{{ $task->title }}</td>
                                    <td>{{ $task->estimated_hours }}</td>
                                    <td>
                                        @if ($task->pivot->status === 'candidate')
                                            <span class="badge bg-warning" style="font-size: 75% !important;">مرشح</span>
                                        @elseif ($task->pivot->status === 'in_progress')
                                            <span class="badge bg-success" style="font-size: 75% !important;">قيد التنفيذ</span>
                                        @elseif ($task->pivot->status === 'rejected')
                                            <span class="badge bg-danger" style="font-size: 75% !important;">مرفوض</span>
                                        @endif
                                    </td>

                                    <td>{{ $task->description }}</td>
                                    <td>
                                        <div class="d-flex flex-wrap" style="gap: 10px;">
                                            @forelse ($task->getMedia('tasks') as $image)
                                                <div>
                                                    <img src="{{ route('task.image', $image) }}"
                                                        class="img-fluid rounded shadow myImg"
                                                        style="width: 90px; height: 70px; border-radius: 6px; cursor: zoom-in;">
                                                </div>
                                            @empty
                                                <p class="text-muted">لا توجد صور مرفقة.</p>
                                            @endforelse
                                        </div>
                                    </td>

                                    <td>
                                        @if ($task->pivot->status === 'candidate')
                                            <form action="{{ route('task.changeStatus', [$task->id, Auth::user()->id]) }}"
                                                method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="btn btn-sm btn-danger">رفض</button>
                                            </form>

                                            <form action="{{ route('task.changeStatus', [$task->id, Auth::user()->id]) }}"
                                                method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="in_progress">
                                                <button type="submit" class="btn btn-sm btn-success">قبول</button>
                                            </form>
                                        @elseif ($task->pivot->status === 'in_progress')
                                            <form action="{{ route('task.changeStatus', [$task->id, Auth::user()->id]) }}"
                                                method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="done">
                                                <button type="submit" class="btn btn-sm btn-secondary">إنهاء</button>
                                            </form>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center mt-4">
                        {{ $tasks->links() }}
                    </div>


                </div>
            </div>
        </div>
        <!-- Zoom Modal -->
        <div id="myModal" class="modal">
            <span class="close">&times;</span>
            <img class="modal-content" id="img01">
            <div id="caption"></div>
        </div>
    @endrole
@endsection
@section('js')
    {{-- سكربتات DataTables --}}
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#tasks-table').DataTable({
                paging: false,
                searching: false,
                ordering: true,
                info: false,
            });

            // image modal setup
            const modal = document.getElementById("myModal");
            const modalImg = document.getElementById("img01");
            const captionText = document.getElementById("caption");
            const closeBtn = document.getElementsByClassName("close")[0];
            const images = document.querySelectorAll('.myImg');

            images.forEach(img => {
                img.addEventListener("click", function() {
                    modal.style.display = "block";
                    modalImg.src = this.src;
                    captionText.innerHTML = this.alt || "";
                });
            });

            closeBtn.onclick = function() {
                modal.style.display = "none";
            };

            modal.onclick = function(event) {
                if (event.target === modal) {
                    modal.style.display = "none";
                }
            };
        });
    </script>
@endsection
