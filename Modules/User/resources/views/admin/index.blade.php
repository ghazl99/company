@extends('core::layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

    {{-- imageModal css --}}
    <link rel="stylesheet" href="{{ URL::asset('build/assets/css/imageModal.css') }}">
@endsection
@section('content')
    <br>
    <div class="card">
        <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
                <h4 class="card-title mg-b-0">قائمة المطورين</h4> {{-- Changed title for clarity --}}
                <i class="mdi mdi-dots-horizontal text-gray"></i>
            </div>
            <p class="tx-12 tx-gray-500 mb-2">إدارة المطورين في نظامك.</p>
            {{-- ADD BUTTON HERE --}}
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> إضافة مطور جديد
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive-md">
                <table class="table " id="users">
                    <thead>
                        <tr>
                            <th>الاسم</th>
                            <th>الحالة</th>
                            <th>الصورة الشخصية</th>
                            <th>البريد الإلكتروني</th>
                            <th>الهاتف</th>
                            <th>الاختصاص</th>
                            <th>Framework</th>
                            <th>محظور</th>
                            <th>السيرة الذاتية</th>
                            <th>الإجراءات</th> {{-- Added for edit/delete --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($developers as $dev)
                            <tr>
                                <td>{{ $dev->name }}</td>
                                <td>
                                    @if ($dev->activeWorkSession)
                                        <span class="badge bg-success"><i class="mdi mdi-calendar-clock"></i> نشط</span>
                                    @else
                                        <span class="badge bg-secondary"><i class="mdi mdi-clock-outline"></i> غير
                                            نشط</span>
                                    @endif
                                </td>

                                <td>
                                    @if ($dev->getFirstMedia('personal_photo'))
                                        <img src="{{ route('user.image', $dev->getFirstMedia('personal_photo')->id) }}"
                                            class="myImg" alt="صورة الشخصية"
                                            style="width: 80px; height: 70px; border-radius: 6px; cursor:zoom-in;">
                                    @else
                                        <img src="{{ $dev->profile_photo_url }}" alt="صورة الشخصية"
                                            style="width: 80px; height: 70px; border-radius: 6px; cursor:zoom-in;">
                                    @endif
                                <td>{{ $dev->email }}</td>
                                <td>{{ $dev->phone }}</td>
                                <td>{{ $dev->specialization }}</td>
                                <td>{{ $dev->framework }}</td>
                                <td>
                                    @if ($dev->is_blocked)
                                        <span class="badge bg-danger">محظور</span>
                                    @else
                                        <span class="badge bg-success">فعال</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($dev->hasMedia('cv'))
                                        <a href="{{ route('user.cv', $dev->getFirstMedia('cv')->id) }}" target="_blank"
                                            class="btn btn-outline-primary btn-sm">
                                            عرض CV
                                        </a>
                                    @else
                                        <span class="text-muted">لا يوجد</span>
                                    @endif

                                </td>
                                <td>
                                    <a href="{{ route('user.edit', $dev->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-edit"></i> تعديل
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <!-- Trigger the Modal -->
    <img id="myImg">

    <!-- The Modal -->
    <div id="myModal" class="modal">

        <!-- The Close Button -->
        <span class="close">&times;</span>

        <!-- Modal Content (The Image) -->
        <img class="modal-content" id="img01">

        <!-- Modal Caption (Image Text) -->
        <div id="caption"></div>
    </div>
@endsection
@section('js')
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
   
    <script>
        $(document).ready(function() {
            $('#users').DataTable({
                paging: false,
                searching: true,
                ordering: true,
                info: false,
                pageLength: 10,
            });

            // جلب عناصر الصور
            const modal = document.getElementById("myModal");
            const modalImg = document.getElementById("img01");
            const captionText = document.getElementById("caption");
            const closeBtn = document.getElementsByClassName("close")[0];

            // تحديد كل الصور ذات الكلاس myImg
            const images = document.querySelectorAll('.myImg');

            images.forEach(img => {
                img.onclick = function() {
                    modal.style.display = "block";
                    modalImg.src = this.src;
                    captionText.innerHTML = this.alt || "";
                }
            });

            // زر الإغلاق
            closeBtn.onclick = function() {
                modal.style.display = "none";
            }

            // إغلاق المودال إذا ضغط المستخدم خارج الصورة
            modal.onclick = function(event) {
                if (event.target === modal) {
                    modal.style.display = "none";
                }
            }
        });
    </script>
@endsection
