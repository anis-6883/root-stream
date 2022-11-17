@extends('layouts.app')

@section('page_title', '| Payment List')

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class='fas fa-home text-muted'></i></a></li>
        <li class="breadcrumb-item active" aria-current="page">Payments</li>
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

<div class="row mt-3">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="row flex-grow-1">
            <div class="col-md-12 stretch-card">
                <div class="card">
                    <div class="card-body">
						<table class="table table-bordered" id="data-table">
							<thead>
								<tr>
									
									<th>{{ _lang('User') }}</th>
									<th>{{ _lang('Subscription') }}</th>
									<th>{{ _lang('Amount') }}</th>
									<th>{{ _lang('Platform') }}</th>
									<th>{{ _lang('Date') }}</th>

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
			window.location.href = _url + "/payments?id=" + app_unique_id;
		}else{
			window.location.href = _url + "/payments";
		}
	});

	$('#data-table').DataTable({
		processing: true,
		serverSide: true,
		ajax: _url + "/payments?id={{ $app_unique_id }}",
		"columns" : [
			
        	{ data : "user.name", name : "user.name", className : "name text-center" },
        	{ data : "subscription.name", name : "subscription.name", className : "name text-center" },
        	{ data : "amount", name : "amount", className : "amount text-center" },
        	{ data : "platform", name : "platform", className : "platform text-center" },
        	{ data : "created_at", name : "created_at", className : "created_at text-center" },
			// { data : "action", name : "action", orderable : false, searchable : false, className : "text-center" }
			
		],
		responsive: true,
		"bStateSave": true,
		"bAutoWidth":false,	
		"ordering": false
	});
</script>
@endsection