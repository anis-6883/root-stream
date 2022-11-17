@extends('layouts.app')

@section('page_title', '| User List')

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class='fas fa-home text-muted'></i></a></li>
        <li class="breadcrumb-item active" aria-current="page">Users</li>
    </ol>
</nav>
<div class="row">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="row flex-grow-1">
            <div class="col-md-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 m-auto">
                                <div class="mb-3">
                                    <label class="form-label">{{ _lang('App') }}</label>
                                    <select class="form-control select2" name="app_unique_id" required>
                                        <option value="">{{ _lang('Select One') }}</option>
                                        @foreach (App\Models\AppModel::where('status', 1)->get() as $data)
                                            <option value="{{ $data->app_unique_id }}" {{ $data->app_unique_id == $app_unique_id ? 'selected' : '' }}>
                                                {{ $data->app_name }} - {{ $data->app_unique_id }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- row -->

<div class="d-flex justify-content-end mt-3">
	<a class="btn btn-outline-primary btn-sm ajax-modal" href="{{ route('users.create') }}" data-title="Add New User">
	   <i class="fas fa-plus mr-1" style="font-size: 13px"></i> Add User
	</a>
 </div>

<div class="row mt-3">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="row flex-grow-1">
            <div class="col-md-12 stretch-card">
                <div class="card">
                    <div class="card-body">
						<table class="table table-bordered" id="data-table">
							<thead>
								<tr>
									
									<th>{{ _lang('Image') }}</th>
									<th>{{ _lang('Name') }}</th>
									<th>{{ _lang('Email') }}</th>
									<th>{{ _lang('Subscription') }}</th>
									<th>{{ _lang('Status') }}</th>
									<th>{{ _lang('Action') }}</th>

								</tr>
							</thead>
						</table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- row -->
@endsection

@section('js-script')
<script>

	var _url = "{{ url('/') }}";
	$(document).on("change", "select[name='app_unique_id']", function () {
		var app_unique_id = $(this).val();
		if (app_unique_id != '') {
			window.location.href = _url + "/users?id=" + app_unique_id;
		}else{
			window.location.href = _url + "/users";
		}
	});

	$('#data-table').DataTable({
		processing: true,
		serverSide: true,
		ajax: _url + "/users?id={{ $app_unique_id }}",
		"columns" : [
			
			{ data : "image", name : "image", className : "image" },
        	{ data : "name", name : "name", className : "name" },
        	{ data : "email", name : "email", className : "email" },
        	{ data : "subscription", name : "subscription", className : "subscription" },
        	{ data : "status", name : "status", className : "status text-center" },
			{ data : "action", name : "action", orderable : false, searchable : false, className : "text-center" }
			
		],
		responsive: true,
		"bStateSave": true,
		"bAutoWidth":false,	
		"ordering": false
	});
</script>
@endsection