@extends('layouts.app')

@section('page_title', '| Subscription List')

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class='fas fa-home text-muted'></i></a></li>
        <li class="breadcrumb-item active" aria-current="page">Subscriptions</li>
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
	<a class="btn btn-outline-primary btn-sm" href="{{ route('subscriptions.create') }}">
	   <i class="fas fa-plus mr-1" style="font-size: 13px"></i> Add Subscription
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
									
									<th>{{ _lang('Name') }}</th>
									<th>{{ _lang('Duration') }}</th>
									<th>{{ _lang('Platform') }}</th>
									<th>{{ _lang('Status') }}</th>
		
									<th class="text-center">{{ _lang('Action') }}</th>
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
			window.location.href = _url + "/subscriptions?id=" + app_unique_id;
		}else{
			window.location.href = _url + "/subscriptions";
		}
	});

	$('#data-table').DataTable({
		processing: true,
		serverSide: true,
		ajax: _url + "/subscriptions?id={{ $app_unique_id }}",
		"columns" : [
			
        	{ data : "name", name : "name", className : "name" },
        	{ data : "duration", name : "duration", className : "duration" },
        	{ data : "platform", name : "platform", className : "platform" },
        	{ data : "status", name : "status", className : "status text-center" },
			{ data : "action", name : "action", orderable : false, searchable : false, className : "text-center" }
			
		],
		responsive: true,
		"bStateSave": true,
		"bAutoWidth":false,	
		"ordering": false
	});
</script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script type="text/javascript">
	$(function() {
      $("#data-table tbody").sortable({
          update: function(event, ui)
            {
                var subscriptions = [];
                var subscriptionOrder = 1;
                $("#data-table tbody > tr").each(function(){
                    var id = $(this).data('id');
                    subscriptions.push( { id: id, position: subscriptionOrder });
                    subscriptionOrder++;
                });
                
                var subscriptions = JSON.stringify( subscriptions );

                $.ajax({
                    method: "POST",
                    url: '{{ url("subscriptions/reorder") }}',
                    data:  { _token: "{{ csrf_token() }}", subscriptions},
                    cache: false,
                    success: function(data){
                       
						Toast.fire({
							icon: "success",
							title: data["message"],
						});
                        
                    }
                });
            }
      	});
    });
</script>
@endsection