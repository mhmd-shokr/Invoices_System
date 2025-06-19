@extends('layouts.master')
@section('css')
<style>
    @media print {
        #btnPrint {
            display: none;
        }
    }
</style>
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"></span> طباعة الفافتورة</span>
						</div>
					</div>
					
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row row-sm">
					<div class="col-md-12 col-xl-12">
						<div class=" main-content-body-invoice" id="print">
							<div class="card card-invoice">
								<div class="card-body">
									<div class="invoice-header">
										<h1 class="invoice-title">فاتورة التحصيل</h1>
										
									
										<div class="col-md">
											<label class="tx-gray-600">معلومات الفاتوره </label>
											<p class="invoice-info-row"><span>رقم الفاتورة</span> <span>{{ $invoices->invoice_number }}</span></p>
											<p class="invoice-info-row"><span>تاريخ الاستحقاق:</span> <span>{{ $invoices->due_date }}</span></p>
											<p class="invoice-info-row"><span>تاريخ الاصدار:</span> <span>{{ $invoices->invoices_date }}</span></p>
											<p class="invoice-info-row"><span> القسم:</span> <span>{{ $invoices->section->section_name }}</span></p>

										</div>
									</div>
									<div class="table-responsive mg-t-40">
										<table class="table table-invoice border text-md-nowrap mb-0">
											<thead>
												<tr>
													<th class="wd-20p">#</th>
													<th class="wd-20p">المنتج</th>
													<th class="tx-center">مبلغ التحصيل</th>
													<th class="tx-right">مبلغ العموله</th>
													<th class="tx-right">الاجمالي</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td></td>
													<td class="tx-center">{{ $invoices->product }}</td>
													<td class="tx-right">{{ number_format($invoices->Ammount_collection, 2) }}</td>
													<td class="tx-right">{{ number_format($invoices->Ammount_commission, 2) }}</td>
                                                    @php
                                                    $total=$invoices->Ammount_collection+$invoices->Ammount_commission;
                                                    @endphp
                                                    <td class="tx-right">{{ number_format($total, 2) }}</td>
                                                    
                                                </tr>
												
												<tr>
													<td class="valign-middle" colspan="2" rowspan="4">
                                                        <label for="inputName" class="main-content-label">#</label>
													</td>
												</tr>
                                                
												<tr>
													<td class="tx-right">نسبة الضريبه</td>
													<td class="tx-right" colspan="2">{{ $invoices->rat_vat }}</td>
												</tr>
												<tr>
													<td class="tx-right">الخصم</td>
													<td class="tx-right" colspan="2">{{ $invoices->discount }}</td>
												</tr>
												<tr>
                                                    <td class="tx-right tx-uppercase tx-bold tx-inverse">الاجمالي شامل الضريبه</td>
                                                    <td class="tx-right" colspan="2">
                                                        <h4 class="tx-primary tx-bold">{{ number_format($invoices->total, 2) }}</h4>
                                                    </td>
                                                </tr>
											</tbody>
										</table>
									</div>
									<hr class="mg-b-40">
									@can('طباعةالفاتورة')
									<button class="btn btn-danger float-left after:mt-3 mr-2" id="btnPrint"  onclick="window.printDiv()" >طباعه
                                        <i class="mdi mdi-printer ml-1"></i>
                                    </button>
									@endcan

								</div>
							</div>
						</div>
					</div><!-- COL-END -->
				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<!--Internal  Chart.bundle js -->
<script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
<script>
    function printDiv(){
        var printContent=document.getElementById("print").innerHTML;
        var originalContent=document.body.innerHTML;
        document.body.innerHTML=printContent;
        window.print();
        document.body.innerHTML=originalContent;
        location.reload();
    }
</script>
@endsection