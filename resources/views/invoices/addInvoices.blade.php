@extends('layouts.master')
@section('css')
    <!-- Internal Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

    <!-- Internal Fileupload css -->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />

    <!-- Internal Fancy uploader css -->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />

    <!-- Internal Sumoselect css -->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">

    <!-- Internal TelephoneInput css -->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">

    <!-- ✅ إضافة Bootstrap DateTimePicker CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

@endsection
@section('title')
    اضافة فاتورة
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            @can( 'اضافة فاتورة')
            <div class="d-flex">                    
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    اضافة فاتورة</span>
            </div>
            @endcan
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    

    <!-- row -->
    <div class="row">
            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>❌ حدثت الأخطاء التالية:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session('success') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
    </div>
    
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('invoices.store') }}" method="post" enctype="multipart/form-data"
                        autocomplete="off">
                    @csrf
                        {{-- 1 --}}

                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">رقم الفاتورة</label>
                                <input type="text" class="form-control" id="inputName" name="invoice_number"
                                    title="يرجي ادخال رقم الفاتورة" required>
                            </div>

                            <div class="col">
                                <label>تاريخ الفاتورة</label>
                                <input class="form-control fc-datepicker" name="invoice_Date" placeholder="YYYY-MM-DD"
                                    type="text" value="{{ date('Y-m-d') }}" required>
                            </div>

                            <div class="col">
                                <label>تاريخ الاستحقاق</label>
                                <input class="form-control fc-datepicker" name="Due_date" placeholder="YYYY-MM-DD"
                                    type="text" required>
                            </div>

                        </div>

                        {{-- 2 --}}
                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">القسم</label>
                                <select name="section" class="form-control SlectBox" onclick="console.log($(this).val())"
                                    onchange="console.log('change is firing')">
                                    <!--placeholder-->
                                    <option value="" selected disabled>حدد القسم</option>
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}"> {{ $section->section_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col">
                                <label for="product" class="control-label">المنتج</label>
								<select id="product" name="product" class="form-control">
								</select>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">مبلغ التحصيل</label>
                                <input type="text" class="form-control" id="inputName" name="Amount_collection"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            </div>
                        </div>


                        {{-- 3 --}}
                        <div class="row">
                            <div class="col">
                                <label for="Amount_Commission" class="control-label">مبلغ العمولة</label>
                                <input type="text" class="form-control form-control-lg" id="Amount_Commission"
                                    name="Amount_Commission" title="يرجي ادخال مبلغ العمولة "
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    required>
                            </div>

                            <div class="col">
                                <label for="Discount" class="control-label">الخصم</label>
                                <input type="text" class="form-control form-control-lg" id="Discount" name="Discount"
                                    title="يرجي ادخال مبلغ الخصم "
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    value=0 required>
                            </div>

                            <div class="col">
                                <label for="Rate_VAT" class="control-label">نسبة ضريبة القيمة المضافة</label>
                                <select name="Rate_VAT" id="Rate_VAT" class="form-control" onchange="myFunction()">
                                    <!--placeholder-->
                                    <option value="" selected disabled>حدد نسبة الضريبة</option>
                                    <option value=" 5%">5%</option>
                                    <option value="10%">10%</option>
                                    <option value="15%">15%</option>
                                    <option value="20%">20%</option>
                                </select>
                            </div>
                        </div>

                        {{-- 4 --}}
                        <div class="row">
                            <div class="col">
                                <label for="Value_VAT" class="control-label">قيمة ضريبة القيمة المضافة</label>
                                <input type="text" class="form-control" id="Value_VAT" name="Value_VAT" readonly>
                            </div>

                            <div class="col">
                                <label for="Total" class="control-label">الاجمالي شامل الضريبة</label>
                                <input type="text" class="form-control" id="Total" name="Total" readonly>
                            </div>
                        </div>

                        {{-- 5 --}}
                        <div class="row">
                            <div class="col">
                                <label for="exampleTextarea">ملاحظات</label>
                                <textarea class="form-control" id="exampleTextarea" name="note" rows="3"></textarea>
                            </div>
                        </div><br>

                        <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                        <h5 class="card-title">المرفقات</h5>

                        <div class="col-sm-12 col-md-12">
                            <input type="file" name="pic" class="dropify" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                                data-height="70" />
                        </div><br>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">حفظ البيانات</button>
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
    <!-- Internal Select2 js -->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>

    <!-- Internal Fileuploads js -->
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>

    <!-- Internal Fancy uploader js -->
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>

    <!-- Internal Sumoselect js -->
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>

    <!-- Internal Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>

    <!-- Internal jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>

    <!-- Internal spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>

    <!-- ✅ إضافة Moment.js (ضروري لـ datetimepicker) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <!-- ✅ إضافة Bootstrap DateTimePicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script>
        var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();

    </script>

<script>
		$(document).ready(function() {
            $('select[name="section"]').on('change', function() {
                var SectionId = $(this).val();
                if (SectionId) {
                    $.ajax({
                        url: "{{ URL::to('invoices/sections') }}/" + SectionId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="product"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="product"]').append('<option value="' +
                                    value + '">' + value + '</option>');
                            });
                        },
                    });
                } else {
                    console.log('AJAX load did not work');
                }
            });

        });

</script>



<script>
	function myFunction() {
    // Get values from input fields and convert them to numbers
    var Amount_Commission = parseFloat(document.getElementById("Amount_Commission").value) || 0;
    var Discount = parseFloat(document.getElementById("Discount").value) || 0;
    var Rate_VAT = parseFloat(document.getElementById("Rate_VAT").value) || 0;

    // Check if the commission amount is entered
    if (Amount_Commission === 0) {
        alert('أدخل مبلغ العمولة');
        return; // Stop execution if the commission is not entered
    }

    // Calculate the amount after discount
    var amount_after_discount = Amount_Commission - Discount;

    // Calculate the VAT amount
    var vat_amount = (amount_after_discount * Rate_VAT) / 100;

    // Calculate the total amount after VAT
    var total_amount = amount_after_discount + vat_amount;

    // Update the input fields with the calculated values
    document.getElementById("Value_VAT").value = vat_amount.toFixed(2); // VAT amount
    document.getElementById("Total").value = total_amount.toFixed(2); // Total amount after VAT
}




</script>


@endsection