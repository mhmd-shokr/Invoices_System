@extends('layouts.master')
@section('css')
<!---Internal  Prism css-->
<link href="{{URL::asset('assets/plugins/prism/prism.css')}}" rel="stylesheet">
<!---Internal Input tags css-->
<link href="{{URL::asset('assets/plugins/inputtags/inputtags.css')}}" rel="stylesheet">
<!--- Custom-scroll -->
<link href="{{URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css')}}" rel="stylesheet">
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row opened -->
<div class="row row-sm">
    <div class="col-lg-12 col-md-12">
        <div class="card" id="basic-alert">
            <div class="card-body">
                <div>
                    <h6 class="card-title mb-1">قائمة الفواتير</h6>
                    <p class="text-muted card-sub-title">تفاصيل الفاتوره</p>
                </div>
                <div class="text-wrap">
                    <div class="example">
                        <div class="panel panel-primary tabs-style-1">
                            <div class="tab-menu-heading">
                                <div class="tabs-menu1">
                                    
                                @if(session()->has('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>{{ session('success') }}</strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                                    <!-- Tabs -->
                                    <ul class="nav panel-tabs main-nav-line">
                                        <li class="nav-item"><a href="#tab1" class="nav-link active" data-toggle="tab">معلومات الفاتوره </a></li>
                                        <li class="nav-item"><a href="#tab2" class="nav-link" data-toggle="tab">حالات الدفع</a></li>
                                        <li class="nav-item"><a href="#tab3" class="nav-link" data-toggle="tab">المرفقات</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body tabs-menu-body main-content-body-right border-top-0 border">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">
                                        <div class="table-responsive mt-15">
                                            <table class="table table-striped" style="text-align:center">
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">رقم الفاتورة</th>
                                                        <td>{{ $invoices->invoice_number }}</td>
                                                        <th scope="row">تاريخ الاصدار</th>
                                                        <td>{{ $invoices->invoices_date}}</td>
                                                        <th scope="row">تاريخ الاستحقاق</th>
                                                        <td>{{ $invoices->due_date }}</td>
                                                        <th scope="row">القسم</th>
                                                        <td>{{ $invoices->Section->section_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">المنتج</th>
                                                        <td>{{ $invoices->product }}</td>
                                                        <th scope="row">مبلغ التحصيل</th>
                                                        <td>{{ $invoices->Ammount_collection }}</td>
                                                        <th scope="row">مبلغ العمولة</th>
                                                        <td>{{ $invoices->Ammount_commission }}</td>
                                                        <th scope="row">الخصم</th>
                                                        <td>{{ $invoices->discount }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">نسبة الضريبة</th>
                                                        <td>{{ $invoices->rat_vat }}</td>
                                                        <th scope="row">قيمة الضريبة</th>
                                                        <td>{{ $invoices->value_vat}}</td>
                                                        <th scope="row">الاجمالي مع الضريبة</th>
                                                        <td>{{ $invoices->total }}</td>
                                                        <th scope="row">الحالة الحالية</th>
                                                        @if ($invoices->vlue_Status == 1)
                                                            <td><span class="badge badge-pill badge-success">{{ $invoices->status }}</span></td>
                                                        @elseif($invoices->value_status == 2)
                                                            <td><span class="badge badge-pill badge-danger">{{ $invoices->status }}</span></td>
                                                        @else
                                                            <td><span class="badge badge-pill badge-warning">{{ $invoices->status }}</span></td>
                                                        @endif
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                    <div class="tab-pane" id="tab2">
                                        <div class="table-responsive mt-15">
                                            <table class="table center-aligned-table mb-0 table-hover" style="text-align:center">
                                                <thead>
                                                    <tr class="text-dark">
                                                        <th>#</th>
                                                        <th>رقم الفاتورة</th>
                                                        <th> القسم</th>
                                                        <th>نوع القسم</th>
                                                        <th>حالة الدفع</th>
                                                        <th>تاريخ الدفع </th>
                                                        <th>ملاحظات</th>
                                                        <th>تاريخ الاضافة </th>
                                                        <th>المستخدم</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i=0 ?>
                                                    @foreach ($deatailes as $deatil )
                                                    <tr>
                                                        <?php $i++ ?>
                                                        <td>{{ $i }}</td>
                                                        <td>{{ $deatil->invoice_number }}</td>
                                                        <td>{{ $deatil->product }}</td>
                                                        <td>{{ $invoices->Section->section_name }}</td>
                                                        @if ($deatil->value_status == '3')
                                                            <td><span class="badge badge-pill badge-success">{{ $deatil->status }}</span></td> 
                                                        @elseif($deatil->value_status == '2')
                                                            <td><span class="badge badge-pill badge-danger">{{ $deatil->status }}</span></td> 
                                                        @elseif($deatil->value_status == '1')
                                                            <td><span class="badge badge-pill badge-warning">{{ $deatil->status }}</span></td> 
                                                        @else
                                                            <td><span class="badge badge-pill badge-secondary">غير معروف</span></td> 
                                                        @endif

                                                        <td>{{ $deatil->payment_date}}</td>
                                                        <td>{{ $deatil->note }}</td>
                                                        <td>{{ $deatil->created_at }}</td>
                                                        <td>{{ $deatil->user }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="tab3">
                                    <div class="card card-statistics mb-4">
                                        <div class="card-body p-0">
                                            <p class="text-danger">صيغة المرفق: pdf, jpeg, jpg, png</p>
                                            <h5 class="card-title">إضافة مرفقات</h5>
                                            <form action="{{ route('attachments.store') }}" method="post" enctype="multipart/form-data" class="px-3 pb-3">
                                                @csrf
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="customFile" name="file_name" required>
                                                    <label class="custom-file-label" for="customFile">اختر ملف</label>
                                                </div>
                                                <input type="hidden" name="invoice_number" value="{{ $invoices->invoice_number }}">
                                                <input type="hidden" name="invoice_id" value="{{ $invoices->id }}">
                                                <button type="submit" class="btn btn-primary btn-block mt-3" name="upload">إرسال</button>
                                            </form>
                                        </div>
                                    </div>
                                        <div class="card-body">
                                            <h5 class="card-title">المرفقات السابقة</h5>
                                            <p class="text-muted">هنا يتم عرض المرفقات المتعلقة بالفاتورة.</p>
                                            <div class="table-responsive">
                                                <table class="table table-bordered mb-0">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th>#</th>
                                                            <th>اسم الملف</th>
                                                            <th>تم رفع بواسطة</th>
                                                            <th>تاريخ الرفع</th>
                                                            <th>العمليات</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i=0 ?>
                                                        @foreach ($attachements as $attachment)
                                                            <tr class="text-center">
                                                                <?php $i++ ?>
                                                                <td>{{ $i }}</td>
                                                                <td>{{ $attachment->file_name }}</td>
                                                                <td>{{ $attachment->Created_by }}</td>
                                                                <td>{{ $attachment->created_at->format('Y-m-d') }}</td>
                                                                <td>
                                                                    <a class="btn btn-outline-success btn-sm"
                                                                    href="{{ url('View_file/'.$invoices->invoice_number.'/'.$attachment->file_name) }}"
                                                                    target="_blank">
                                                                        <i class="fas fa-eye"></i> عرض
                                                                    </a>
                                                                    <a class="btn btn-outline-primary btn-sm"
                                                                    href="{{ url('download_file/'.$invoices->invoice_number.'/'.$attachment->file_name) }}">
                                                                        <i class="fas fa-download"></i> تحميل
                                                                    </a>
                                                                    <button class="btn btn-outline-danger btn-sm"
                                                                            data-file-name="{{ $attachment->file_name }}"
                                                                            data-invoice-number="{{ $attachment->invoice_number }}"
                                                                            data-id_file="{{ $attachment->id }}"
                                                                            data-toggle="modal" data-target="#delete_file">
                                                                        <i class="fas fa-trash-alt"></i> حذف
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        @if($attachements->isEmpty())
                                                            <tr>
                                                                <td colspan="5" class="text-center">لا توجد مرفقات بعد.</td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /row -->
                
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->

<!-- Modal -->
<div class="modal fade" id="delete_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">حذف الملف</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <!-- Modal Form -->
            <form id="deleteForm"  method="post" enctype="multipart/form-data">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p class="text-danger">هل انت متأكد من حذف الملف؟</p>
                    <input type="hidden" name="id_file" id="id_file">
                    <input type="hidden" name="invoice_number" id="invoice_number">
                    <input class="form-control" name="file_name" id="file_name" type="text" readonly>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-danger pd-x-20">تأكيد</button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
@section('js')
<!--Internal  Datepicker js -->
<script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!-- Internal Select2 js-->
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<!-- Internal Jquery.mCustomScrollbar js-->
<script src="{{URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<!-- Internal Input tags js-->
<script src="{{URL::asset('assets/plugins/inputtags/inputtags.js')}}"></script>
<!--- Tabs JS-->
<script src="{{URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js')}}"></script>
<script src="{{URL::asset('assets/js/tabs.js')}}"></script>
<!--Internal  Clipboard js-->
<script src="{{URL::asset('assets/plugins/clipboard/clipboard.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/clipboard/clipboard.js')}}"></script>
<!-- Internal Prism js-->
<script src="{{URL::asset('assets/plugins/prism/prism.js')}}"></script>
<!-- Script to Pass Data -->
<script>
    $('#delete_file').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id_file = button.data('id_file')
        var invoice_number = button.data('invoice_number')
        var file_name = button.data('file_name')
        var modal = $(this)

        modal.find('.modal-body #id_file').val(id_file);
        modal.find('.modal-body #invoice_number').val(invoice_number);  
        modal.find('.modal-body #file_name').val(file_name)

        $('#deleteForm').attr('action', '/delete_file/' + id_file)
    })
</script>

@endsection