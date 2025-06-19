@extends('layouts.master')
@section('css')
    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    <!--Internal  TelephoneInput css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="{{ URL::asset('https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css') }} ">
@endsection

@section('title')
    تعديل فاتورة
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    تعديل فاتورة</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
@if (session()->has('success'))
    <script>
        window.onload = function(){
            notif({
                text: "{{ session('success') }}",
                type: "success",
            });
        }
    </script>
@endif

    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('Status.update', ['id'=>$invoices->id]) }}" method="post" autocomplete="off">
                        @method('PUT')
                        @csrf
                        {{-- 1 --}}
                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">رقم الفاتورة</label>
                                <input  type="hidden" name="invoice_id" value="{{ $invoices->id }}">
                                <input readonly type="text" class="form-control" id="inputName" name="invoice_number"
                                    title="يرجي ادخال رقم الفاتورة" value="{{ $invoices->invoice_number }}" required>
                            </div>

                            <div class="col">
                                <label>تاريخ الفاتورة</label>
                                <input disabled class="form-control fc-datepicker" name="invoice_Date" placeholder="YYYY-MM-DD"
                                    type="text" value="{{ $invoices->invoices_date }}" required>
                            </div>

                            <div class="col">
                                <label>تاريخ الاستحقاق</label>
                                <input disabled class="form-control fc-datepicker" name="Due_date" placeholder="YYYY-MM-DD"
                                    type="text" value="{{ $invoices->due_date }}" required>
                            </div>
                        </div>

                        {{-- 2 --}}
                        <div class="row">
                        <div class="row">
                        <div class="col">
                            <label for="inputName" class="control-label">القسم</label>
                            <select class="form-control SlectBox"  style="pointer-events:none; background-color: #eee;">
                                @foreach ($sections as $section)
                                    <option value="{{ $section->id }}" {{ $section->id == $invoices->section_id ? 'selected' : '' }}>
                                        {{ $section->section_name }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="section" value="{{ $invoices->section_id }}">
                        </div>
                    </div>

                            <div class="col">
                                <label for="inputName" class="control-label">المنتج</label>
                                <select  style="pointer-events:none; background-color: #eee;" id="product" name="product" class="form-control">
                                    <option aria-readonly="" value="{{ $invoices->product }}"> {{ $invoices->product }}</option>
                                </select>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">مبلغ التحصيل</label>
                                <input disabled type="text" class="form-control" id="inputName" name="Amount_collection"
                                    value="{{ $invoices->Ammount_collection }}">
                            </div>
                        </div>

                        {{-- 3 --}}
                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">مبلغ العمولة</label>
                                <input readonly type="text" class="form-control form-control-lg" id="Amount_Commission"
                                    name="Amount_Commission" title="يرجي ادخال مبلغ العمولة "
                                    value="{{ $invoices->Ammount_commission }}" required>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">الخصم</label>
                                <input readonly type="text" class="form-control form-control-lg" id="Discount" name="Discount"
                                    title="يرجي ادخال مبلغ الخصم "
                                    value="{{ $invoices->discount }}" required>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">نسبة ضريبة القيمة المضافة</label>
                                <select style="pointer-events:none; background-color: #eee;" name="Rate_VAT" id="Rate_VAT" class="form-control" >
                                    <!--placeholder-->
                                    <option  value=" {{ $invoices->rat_vat }}">
                                        {{ $invoices->rat_vat }}
                                    </option>
                                    <option value="5%">5%</option>
                                    <option value="10%">10%</option>
                                </select>
                            </div>
                        </div>

                        {{-- 4 --}}
                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">قيمة ضريبة القيمة المضافة</label>
                                <input  type="text" class="form-control" id="Value_VAT" name="Value_VAT"
                                    value="{{ $invoices->value_vat }}" readonly>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">الاجمالي شامل الضريبة</label>
                                <input type="text" class="form-control" id="Total" name="Total" readonly
                                    value="{{ $invoices->total }}">
                            </div>
                        </div>

                        {{-- 5 --}}
                        <div class="row">
                            <div class="col">
                                <label for="exampleTextarea">ملاحظات</label>
                                <textarea readonly class="form-control" id="exampleTextarea" name="note" rows="3">
                                {{ $invoices->note }}</textarea>
                            </div>
                        </div> 

                        <div class="row">
                            <div class="col">
                                <label for="Status">حالة الدفع</label>
                                <select class="form-control" name="Status" id="Status" required>
                                    <option selected disabled>....حدد حالة الدفع....</option>
                                    <option value="مدفوعة">مدفوعة</option>
                                    <option value="مدفوعة جزئياً">مدفوعة جزئياً</option>
                                    <option value="غير مدفوعة">غير مدفوعة</option>
                                </select>
                            </div>
                        </div>


                        <div class="col">
                            <label> تارخ الدفع</label>
                            <input class="form-control fc-datepicker" type="text" name="payment_date"  placeholder="yy-mm-dd">
                        </div>
                    </div>
                            <br><br>
                    <div class="col">
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary"> تحديث حالة الدفع</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection

@section('js')
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Fileuploads js-->
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <!--Internal Fancy uploader js-->
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
    <!--Internal  Form-elements js-->
    <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <!--Internal Sumoselect js-->
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
    <script src="{{ URL::asset('https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js') }}"></script>

</script>
<script>
       $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();

    </script>
@endsection
