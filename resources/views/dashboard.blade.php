@extends('layouts.master')
@section('title')
الصفحة الرئيسية
@stop
@section('css')
<!--  Owl-carousel css-->
<link href="{{URL::asset('assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet" />
<!-- Maps css -->
<link href="{{URL::asset('assets/plugins/jqvmap/jqvmap.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="left-content">
						<div>
						  <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Hi, welcome back  {{ Auth::user()->name }} </h2>
						  <p class="mg-b-0"> Control dashboard </p>
						</div>
					</div>
					
				</div>
				<!-- /breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row row-sm">
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-primary-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2">
								<div class="">
									<h6 class="mb-3 tx-12 text-white">اجمالي الفواتير</h6>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div class="">
											<h4 class="tx-20 font-weight-bold mb-1 text-white">
												{{number_format(\App\Models\invoices::sum('total'),2) }}
											</h4>
											<p class="mb-0 tx-12 text-white op-7">{{ \App\Models\invoices::count() }}</p>
										</div>
										<span class="float-right my-auto mr-auto">
											<i class="fas fa-arrow-circle-up text-white"></i>
											<span class="text-white op-7">100%</span>
										</span>
									</div>
								</div>
							</div>
							<span id="compositeline" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-danger-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2">
								<div class="">
									<h6 class="mb-3 tx-12 text-white">اجمالي الفواتير الغير المدفوعه</h6>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div class="">
											<h4 class="tx-20 font-weight-bold mb-1 text-white">	
												{{number_format(\App\Models\invoices::where('status','غير مدفوعة')->sum('total'),2) }}
											</h4>
											<p class="mb-0 tx-12 text-white op-7">{{ \App\Models\invoices::where('status','غير مدفوعة')->count() }}</p>
										</div>
										<span class="float-right my-auto mr-auto">
											<i class="fas fa-arrow-circle-down text-white"></i>
										@php
											$total = \App\Models\invoices::sum('total'); 
											$unpaid = \App\Models\invoices::where('status', 'غير مدفوعة')->sum('total'); 
											$percentage = $total > 0 ? ($unpaid / $total) * 100 : 0;
									    @endphp
										
											<span class="text-white op-7">
												{{ round($percentage) }}%
											</span>
											</span>
									</div>
								</div>
							</div>
							<span id="compositeline2" class="pt-1">3,2,4,6,12,14,8,7,14,16,12,7,8,4,3,2,2,5,6,7</span>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-success-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 ">
								<div class="">
									<h6 class="mb-3 tx-12 text-white">اجمالي الفواتير  مدفوعه</h6>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div class="">
											<h4 class="tx-20 font-weight-bold mb-1 text-white">	
												{{number_format(\App\Models\invoices::where('status','مدفوعة')->sum('total'),2) }}
											</h4>
											<p class="mb-0 tx-12 text-white op-7">
												{{ \App\Models\invoices::where('status','مدفوعة')->count() }}
											</p>
										</div>
										@php
											$total=$total = \App\Models\invoices::sum('total'); 
											$paid = \App\Models\invoices::where('status', 'مدفوعة')->sum('total'); 
											$percentage = $total > 0 ? ($paid / $total) * 100 : 0;
										@endphp
										<span class="float-right my-auto mr-auto">
											<i class="fas fa-arrow-circle-up text-white"></i>
											<span class="text-white op-7"> 
												{{ round($percentage) }}%
											</span>
										</span>
									</div>
								</div>
							</div>
							<span id="compositeline3" class="pt-1">5,10,5,20,22,12,15,18,20,15,8,12,22,5,10,12,22,15,16,10</span>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-warning-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 ">
								<div class="">
									<h6 class="mb-3 tx-12 text-white">اجمالي الفواتير الدفوعه جزئيا </h6>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div class="">
											<h4 class="tx-20 font-weight-bold mb-1 text-white">
												{{ \App\Models\invoices::where('status','مدفوعة جزئياً')->sum('total') }}
											</h4>
											<p class="mb-0 tx-12 text-white op-7">
												{{ \App\Models\invoices::where('status','مدفوعة جزئياً')->count()}}
											</p>
										</div>
										@php
											$total=$total = \App\Models\invoices::sum('total'); 
											$partial = \App\Models\invoices::where('status', 'مدفوعة جزئياً')->sum('total'); 
											$percentage = $total > 0 ? ($partial / $total) * 100 : 0;
										@endphp
										<span class="float-right my-auto mr-auto">
											<i class="fas fa-arrow-circle-down text-white"></i>
											<span class="text-white op-7">
												{{ round($percentage) }}%

											</span>
										</span>
									</div>
								</div>
							</div>
							<span id="compositeline4" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
						</div>
					</div>
				</div>
				<!-- row closed -->

			<!-- row opened -->
<div class="row row-sm">

    <div class="col-md-6 col-lg-6 col-xl-6">
        <div class="card">
            <div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
                <h4 class="card-title mb-0" >عدد الفواتير حسب كل حالة</h4>
            </div>
            <div class="card-body">
                {!! $chart1->renderHtml() !!}
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-6 col-xl-6">
        <div class="card">
            <div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
                <h4 class="card-title mb-0">نسبة مبالغ الفواتير حسب كل حالة</h4>
            </div>
            <div class="card-body" style="width:100%">
                {!! $chart2->renderHtml() !!}
            </div>
        </div>
    </div>

</div>
<!-- row closed -->

<div class="row row-sm">

    <div class="col-md-6 col-lg-6 col-xl-6">
        <div class="card">
            <div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
                <h4 class="card-title mb-0">عدد الفواتير حسب كل حالة</h4>
            </div>
            <div class="card-body">
                {!! $chart3->renderHtml() !!}
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-6 col-xl-6">
        <div class="card">
            <div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
                <h4 class="card-title mb-0">اجمالي المبالغ لكل شهر</h4>
            </div>
            <div class="card-body">
                {!! $chart4->renderHtml() !!}
            </div>
        </div>
    </div>

</div>


			</div>
		</div>
		<!-- Container closed -->
@endsection
@section('js')
<!--Internal  Chart.bundle js -->
<script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
<!-- Moment js -->
<script src="{{URL::asset('assets/plugins/raphael/raphael.min.js')}}"></script>
<!--Internal  Flot js-->
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.pie.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.resize.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.categories.js')}}"></script>
<script src="{{URL::asset('assets/js/dashboard.sampledata.js')}}"></script>
<script src="{{URL::asset('assets/js/chart.flot.sampledata.js')}}"></script>
<!--Internal Apexchart js-->
<script src="{{URL::asset('assets/js/apexcharts.js')}}"></script>
<!-- Internal Map -->
<script src="{{URL::asset('assets/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<script src="{{URL::asset('assets/js/modal-popup.js')}}"></script>
<!--Internal  index js -->
<script src="{{URL::asset('assets/js/index.js')}}"></script>
<script src="{{URL::asset('assets/js/jquery.vmap.sampledata.js')}}"></script>
<script src="{{URL::asset('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js')}}"></script>
{!! $chart1->renderJs() !!}
{!! $chart2->renderJs() !!}
{!! $chart3->renderJs() !!}
{!! $chart4->renderJs() !!}

@endsection