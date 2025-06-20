@extends('layouts.master')
@section('title')
الأقسام
@endsection
@section('css')
<!-- Internal Data table css -->
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
							<h4 class="content-title mb-0 my-auto">الأعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ الأقسام</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row">
	<!--div-->
	<div class="col-xl-12">
						<div class="card mg-b-20">
							<div class="card-header pb-0">
							@if (session()->has('success'))
								<div class="alert alert-success alert-dismissible fade show" role="alert">
									{{ session('success') }}
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
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
								@can( 'اضافة قسم')
								<div class="d-flex justify-content-between">
										
								<a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale" data-toggle="modal" href="#modaldemo8">اضافة قسم</a>
								
							</div>
							@endcan

							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table id="example" class="table key-buttons text-md-nowrap">
										<thead>
											<tr>
												<th class="border-bottom-0">#</th>
												<th class="border-bottom-0"> اسم القسم</th>
												<th class="border-bottom-0"> الوصف</th>
												<th class="border-bottom-0"> اضافة من</th>
												<th class="border-bottom-0"> العمليات</th>
											</tr>
										</thead>
										<tbody>
											<?php $i = 0; ?>
											@foreach ($sections as $section)
											<?php $i++; ?>
											<tr>
												<td>{{$i}}</td>
												<td>{{$section->section_name}}</td>
												<td>{{$section->description}}</td>
												<td>{{$section->Created_by  }}</td> 
												<td>
												@can('تعديل قسم')
														
												<a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
												data-id="{{ $section->id }}" data-section_name="{{ $section->section_name }}"
												data-description="{{ $section->description }}" data-toggle="modal" href="#exampleModal2"
												title="تعديل"><i class="las la-pen"></i></a>
												@endcan
												@can( 'حذف قسم')
													
												<a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
												data-id="{{ $section->id }}" data-section_name="{{ $section->section_name }}" data-toggle="modal"
												href="#modaldemo9" title="حذف"><i class="las la-trash"></i></a>
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
					<!--/div-->
					<div class="modal" id="modaldemo8">
			<div class="modal-dialog" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">أضافة قسم</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<form action="{{ route('sections.store') }}" method="post" autocomplete="off">
						@csrf
					<div class="modal-body">
						<div class="form-group">
								<label for="inputName" class="form-label">أضافة القسم</label>
								<input type="text" class="form-control" id="inputName" name="section_name">
						</div>
						<div class="form-group">
								<label for="inputdescription" class="form-label"> الوصف</label>
								<textarea name="description" class="form-control"  id="inputdescription" rows="3" ></textarea>
						</div>
						
					</div>
					<div class="modal-footer">
						<button class="btn ripple btn-success" type="submit">تاكيد </button>
						<button class="btn ripple btn-secondary" data-dismiss="modal" type="submit">اغلاق</button>
					</div>
					</form>
				</div>
			</div>
		</div>
		<!-- End Basic modal -->
				<!-- row closed -->
			<!-- edit -->
			<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">تعديل القسم</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

									<form action="" method="post" autocomplete="off" id="editForm">
									@method('PATCH')
									
									@csrf
										<div class="form-group">
											<input type="hidden" name="id" id="id" value="{{ $section->id ?? '' }}">
											<label for="recipient-name" class="col-form-label">اسم القسم:</label>
											<input class="form-control" name="section_name" id="section_name" type="text" 
												value="{{ old('section_name', $section->section_name ?? '') }}">
										</div>

										<div class="form-group">
											<label for="message-text" class="col-form-label">ملاحظات:</label>
											<textarea class="form-control" id="description" name="description">{{ old('description', $section->description ?? '') }}</textarea>
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

			<!-- delete -->
			<div class="modal" id="modaldemo9">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content tx-size-sm">
						<div class="modal-header">
							<h6 class="tx-14 mg-b-10 tx-uppercase tx-inverse tx-bold">حذف القسم</h6>
							<button aria-label="Close" class="close" data-dismiss="modal" type="button">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form action="" id="deleteForm" method="post">
                @method('DELETE')
                @csrf
						<div class="modal-body">
							<p>هل انت متاكد من حذف القسم؟</p>
							<input type="hidden" name="id" id="delete_id" >
							<input class="form-control" name="section_name" id="delete_section_name" type="text" readonly>
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
<script src="{{URL::asset('assets/js/modal.js')}}"></script>

<script>
        $('#exampleModal2').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var section_name = button.data('section_name')
            var description = button.data('description')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #section_name').val(section_name);
            modal.find('.modal-body #description').val(description);
			$('#editForm').attr('action', '/sections/' + id);
        })
    </script>
	<script>
    $(document).ready(function() {
        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var section_name = button.data('section_name'); 

            $('#delete_id').val(id);
            $('#delete_section_name').val(section_name);

            $('#deleteForm').attr('action', '/sections/' + id);
        });
    });
</script>
@endsection