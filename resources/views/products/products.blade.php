@extends('layouts.master')
@section('css')
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ المنتجات</span>
						</div>
					</div>
					
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row">
				<div class="col-xl-12">
					<div class="card mg-b20">
						<div class="card-header pb-0">
							@if(session()->has('success'))
							<div class="alert alert-success alert-dismissible fade show" role="alert" aria-label="close">
								{{ session('success') }}
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
									<span aria-hidden="true">&times;</span>
				</div>
						@endif
						@if($errors->any())
							<div class="alert alert-danger">
								<ul>
									@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
						@endif
					</div>
						<div class="card mg-b-20">
							@can( 'اضافة منتج')
							<div class="d-flex justify-content-between">
								<a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale" data-toggle="modal" href="#modaldemo8">اضافة منتج</a>
								</div>
							@endcan
							<div class="card-body">
								<div class="table-responsive">
									<table id="example" class="table key-buttons text-md-nowrap">
										<thead>
											<tr>
												<th class="border-bottom-0">#</th>
												<th class="border-bottom-0"> اسم المنتج</th>
												<th class="border-bottom-0"> اسم القسم</th>
												<th class="border-bottom-0">  الملاحظات</th>
												<th class="border-bottom-0"> العمليات</th>
												
											</tr>
										</thead>
										<tbody>
										<?php $i = 0; ?>
										@foreach ($products as $product)
										<?php $i++; ?>
											<tr>
												<td>{{$i}}</td>
												<td>{{ $product->product_name }}</td>
												<td>{{ $product->section->section_name??'غير محدد'}}</td>
												<td>{{ $product->description }}</td>
												<td>
												<!-- button edit -->
												@can( 'تعديل منتج')
													
												<button class="btn btn-success btn-sm edit-btn"
													data-name="{{ $product->product_name }}" 
													data-pro_id="{{ $product->id }}"
													data-section_id="{{ $product->section->id ?? '' }}"
													data-description="{{ $product->description }}"
													data-toggle="modal" 
													data-target="#edit_Product">
													تعديل
												</button>
												@endcan
												@can( 'حذف منتج')

												<!-- button delete -->
												<button class="btn btn-danger btn-sm"
													data-name="{{ $product->product_name }}" 
													data-pro_id="{{ $product->id }}"
													data-section_name="{{ $product->section->section_name ?? 'غير محدد' }}"
													data-description="{{ $product->description }}"
													data-toggle="modal" 
													data-target="#delete_Product">
													حذف
												</button>
												@endcan
												</td>
											</tr>
										@endforeach
									</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- row closed -->
			 <!-- Add Product -->
				<div class="modal" id="modaldemo8">
			<div class="modal-dialog" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">أضافة منتج</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
				<form action="{{ route('products.store') }}" method="POST" autocomplete="off" id="editForm">
				
					@csrf
					<input type="hidden" name="id" id="id">
					<div class="form-group">
						<label for="product_name" class="col-form-label">اسم المنتج:</label>
						<input class="form-control" name="product_name" id="product_name" type="text" required>
					</div>
					<div class="form-group">
						<label for="section_id" class="col-form-label">القسم:</label>
						<select name="section_id" id="section_id" class="custom-select my-1 mr-sm-2" required>
							@foreach ($sections as $section)
								<option value="{{ $section->id }}">{{ $section->section_name }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label for="description" class="col-form-label">ملاحظات:</label>
						<textarea class="form-control" id="description" name="description"></textarea>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">تأكيد</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
					</div>
				</form>
				</div>
			</div>
		</div>
				<!-- row closed -->
			</div>
						
						<!-- Edit Product Modal -->
			<div class="modal fade" id="edit_Product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">تعديل المنتج</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form action="{{ route('products.update', 'id') }}" method="post" autocomplete="off" id="editForm">
								@method('PATCH')
								@csrf
								<input type="hidden" name="id" id="id">
								<div class="form-group">
									<label for="product_name" class="col-form-label">اسم المنتج:</label>
									<input class="form-control" name="product_name" id="product_name" type="text" required>
								</div>
								<div class="form-group">
									<label for="edit_section_id" class="col-form-label">القسم:</label>
									<select name="section_id" id="edit_section_id" class="custom-select my-1 mr-sm-2" required>
										@foreach ($sections as $section)
											<option value="{{ $section->id }}">{{ $section->section_name }}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group">
									<label for="edit_description" class="col-form-label">ملاحظات:</label>
									<textarea class="form-control" id="edit_description" name="description"></textarea>
								</div>
								<div class="modal-footer">
									<button type="submit" class="btn btn-primary">تأكيد</button>
									<button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- delete Product Modal -->
			<div class="modal" id="delete_Product">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content tx-size-sm">
						<div class="modal-header">
							<h6 class="tx-14 mg-b-10 tx-uppercase tx-inverse tx-bold">حذف المنتج</h6>
							<button aria-label="Close" class="close" data-dismiss="modal" type="button">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form action="{{ route('products.destroy', 'id') }}" id="deleteForm" method="post">
                @method('DELETE')
                @csrf
						<div class="modal-body">
							<p>هل انت متاكد من حذف المنتج؟</p>
							<input type="hidden" name="id" id="delete_id" >
							<input class="form-control" name="product_name" id="delete_product_name" type="text" readonly>
						</div>
						<div class="modal-footer"></div>
							<button type="button" class="btn btn-info pd-x-20" data-dismiss="modal">الغاء</button>
							<button type="submit" class="btn btn-danger pd-x-20">تاكيد</button>
						</div>
					</div>
					</form>
                    </div>
				</div>
					<!-- Container closed -->
				</div>
				<!-- main-content closed -->
		@endsection
		@section('js')
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
		<script src="{{URL::asset('assets/js/modal.js')}}"></script>
	
	
	
		<script>
			
		$('#edit_Product').on('show.bs.modal', function(event) {
			// button that triggered the modal
        var button = $(event.relatedTarget);

        // extract info from data-* attributes
		// get from button
        var productName = button.data('name');
        var sectionId = button.data('section_id');
        var proId = button.data('pro_id');
        var description = button.data('description');
		
		//refer to model that open
		var modal = $(this);
        // Update the modal's content.
		//modal edit 
        modal.find('#product_name').val(productName);
        modal.find('#edit_section_id').val(sectionId);
        modal.find('#edit_description').val(description);
        modal.find('#id').val(proId);
        //update action 
        modal.find('#editForm').attr('action', '/products/' + proId);
    });

	//delete
	$('#delete_Product').on('show.bs.modal', function(event) {
		// button that triggered the modal
		var button = $(event.relatedTarget);
		// extract info from data-* attributes
		var productName = button.data('name');
		var proId = button.data('pro_id');
		//refer to model that open
		var modal = $(this);
		// Update the modal's content.
		modal.find('#delete_product_name').val(productName);
		modal.find('#id').val(proId);
		//update action 
		modal.find('#deleteForm').attr('action', '/products/' + proId);
	})
		</script>


		@endsection