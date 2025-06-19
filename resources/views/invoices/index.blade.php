@extends('layouts.master')
@section('css')

@section('title')
قائمة الفواتير
@stop
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto"> الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة الفواتير</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')

			@if (session()->has('delete_invoice'))
			<script>
				window.onload = function e(){
					notif({
						text: "{{ session('delete_invoice') }}",
						type: "success",
					})
				}
			</script>
			@endif

				<!-- row -->
			<div class="row">
					<!--div-->
					<!--link add new bill -->

					<div class="d-flex justify-content-between" style="width: 100%;">
						@can('اضافة فاتورة')

						<a href="{{ route('invoices.create') }}" class="btn btn-outline-primary w-100" style="width: 100%;">
							إضافة فاتورة
						</a>
						@endcan
						@can('تصدير EXCEL')
						<a class="btn btn-outline-primary w-100"  href="{{ route('export') }}" style="width: 100%;">تصدير الفواتير <i class="fa fa-file-excel"></i></a>
						@endcan
					</div>
				
							<div class="card-body">
								<div class="table-responsive">
									<table id="example" class="table key-buttons text-md-nowrap">
										<thead>
											<tr>
												<th class="border-bottom-0">#</th>
												<th class="border-bottom-0">تاريخ الفاتوره</th>
												<th class="border-bottom-0">تاريخ الاستحقاق</th>
												<th class="border-bottom-0">المنتج</th>
												<th class="border-bottom-0">القسم</th>
												<th class="border-bottom-0">الخصم</th>
												<th class="border-bottom-0">قيمة الضريبه</th>
												<th class="border-bottom-0">نسبة الضريبه</th>
												<th class="border-bottom-0"> الاجمالي</th>
												<th class="border-bottom-0"> الحاله</th>
												<th class="border-bottom-0"> ملاحظات</th>
												<th class="border-bottom-0"> العمليات</th>
											</tr>
										</thead>
										<tbody>
											<?php $i=0; ?>
											@foreach ( $invoices as $invoice )
											<?php $i++ ?>
											<tr>
												<td>{{ $i }}</td>
												<td>{{$invoice-> invoices_date}}</td>
												<td>{{$invoice->due_date}}</td>
												<td> {{$invoice->product}}</td>
												<td><a href="{{url('invoices_deatailes') }}/{{$invoice->id}}">{{ $invoice->section->section_name }}</a></td>

												<td>{{$invoice->discount}}</td>
												<td>{{$invoice->rat_vat}}</td>
												<td>{{$invoice->value_vat}}</td>
												<td>{{$invoice->total}}</td>
												<td>
													@php
														$color = [
															1 => 'text-success',
															2 => 'text-danger',
															3 => 'text-warning',
														][$invoice->value_status] ?? 'text-secondary';
													@endphp
													<span class="{{ $color }}">{{ $invoice->status }}</span>
												</td>
												<td>{{$invoice->note}}</td>
												<td>
													<div class="dropdown ">
														<button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-success" data-toggle="dropdown" id="dropdownMenuButton" type="button">العمليات<i class="fas fa-caret-down ml-1"></i></button>
														<div aria-labelledby="dropdownMenuButton" class="dropdown-menu">
															<!-- edit -->
    													@can('تعديل الفاتورة')
															<a class="dropdown-item" href="{{ route('invoices.edit', $invoice->id) }}">
																<i class="fas fa-edit"></i>  تعديل الفاتوره</a>
														@endcan
															<!-- delete -->
															@can('حذف الفاتورة')
															<a  class="dropdown-item"  data-invoice_id="{{ $invoice->id }}" data-toggle="modal" data-target="#delete_invoice">
																<i class="fas fa-trash-alt"></i> حذف الفاتوره</a>
														@endcan
															@can( 'تغير حالة الدفع')
																
															<a  class="dropdown-item" 
															href="{{ url::route('Status_show',[$invoice->id]) }}" >
																<i class="fas fa-exchange-alt"></i>  تغير حالة الدفع</a>
														@endcan
														@can( 'ارشفة الفاتورة')

															<!-- Archive -->
															<a class="dropdown-item" href="#" data-invoice_id="{{ $invoice->id }}"
                                                        data-toggle="modal" data-target="#Transfer_invoice"><i
                                                            class="text-warning fas fa-exchange-alt"></i>&nbsp;&nbsp;نقل الي
                                                        الارشيف</a>
														@endcan
														@can( 'طباعةالفاتورة')
														<a class="dropdown-item" href="print_invoice/{{$invoice->id}}" 
														target="_blank"><i class="fas fa-print"></i>طباعة</a>
														@endcan

														</div>
													</div>
												</td>
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<!--/div-->
			</div>
</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->

	<div class="modal fade" id="delete_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        
            <!-- Modal Header -->
			@can( 'حذف المرفق')
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">حذف الملف</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
			@endcan
            
            <!-- Modal Form -->
            <form action="{{ route('invoices.destroy', 'id') }}"  method="post" enctype="multipart/form-data">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p class="text-danger">هل انت متأكد من حذف الملف؟</p>
                    <input type="hidden" name="id_invoice" id="idelete_invoice_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-danger pd-x-20">تأكيد</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="Transfer_invoice" tabindex="-1" role="dialog" arisa-labelledby="exampleModalLabel" arisa-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">نقل الي الارشيف</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <form action="{{ route('invoices.destroy', 'test') }}" method="post">
                            @method('delete')
                            @csrf
                    </div>
                    <div class="modal-body">
                        هل انت متاكد من عملية الارشفه ؟
						<input type="hidden" name="id_invoice" id="invoice_id" value="">
                        <input type="hidden" name="id_page" id="id_page" value="2">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-success">تاكيد</button>
                    </div>
                    </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
<!--Internal  Notify js -->
<script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
<script src="{{URL::asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>
<script>
	$('#delete_invoice').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);
    var id_invoice = button.data('invoice_id');
    var modal = $(this);

    modal.find('.modal-body #idelete_invoice_id').val(id_invoice);

    var url = "{{ url('invoices') }}/" + id_invoice;
    modal.find('#deleteForm').attr('action', url);
});

	
</script>
<script>
        $('#Transfer_invoice').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var modal = $(this)
            modal.find('.modal-body #invoice_id').val(invoice_id);
        })

    </script>
@endsection