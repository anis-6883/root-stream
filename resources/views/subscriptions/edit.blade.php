@extends('layouts.app')

@section('page_title', '| Edit Subscription')

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class='fas fa-home text-muted'></i></a></li>
        <li class="breadcrumb-item"> <a class="text-muted" href="{{ route('subscriptions.index') }}">Subscriptions</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit</li>
    </ol>
</nav>
<form action="{{ route('subscriptions.update', $subscription->id) }}" method="POST" autocomplete="off">
	@csrf
	@method('PUT')

	<div class="row">
		<div class="col-12 col-xl-12 stretch-card">
			<div class="row flex-grow-1">
				<div class="col-md-6 mb-3">
					<div class="card">
						<div class="card-body">
							<h3 class="mb-3">Edit <span style="color: #0C32DC;">Subscription</span></h3>
							<hr>
							<div class="row">
								<div class="col-md-12">
									<div class="mb-3">
										<label class="form-label">{{ _lang('Name') }}</label>
										<input type="text" class="form-control" name="name" value="{{ $subscription->name }}" required>
									</div>
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">{{ _lang('Duration Type') }}</label>
										<select class="form-control select2" name="duration_type" data-selected="{{ $subscription->duration_type }}" required>
											<option value="day">{{ _lang('Daily') }}</option>
											<option value="month">{{ _lang('Monthly') }}</option>
											<option value="year">{{ _lang('Yearly') }}</option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">{{ _lang('Duration') }}</label>
										<input type="number" class="form-control" name="duration" value="{{ $subscription->duration }}" required>
									</div>
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">{{ _lang('Platform') }}</label>
										<select class="form-control select2" name="platform" data-selected="{{ $subscription->platform }}" required>
											<option value="">{{ _lang('Select One') }}</option>
											<option value="android">{{ _lang('Android') }}</option>
											<option value="ios">{{ _lang('IOS') }}</option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">{{ _lang('Product Id') }}</label>
										<input type="text" class="form-control" name="product_id" value="{{ $subscription->product_id }}" required>
									</div>
								</div>
								<div class="col-md-12">
									<div class="mb-3">
										<label class="form-label">{{ _lang('App') }}</label>
										<select class="form-control select2" name="app_id" required data-selected="{{ $subscription->app_id }}">
											<option value="">{{ _lang('Select One') }}</option>
											@foreach($apps AS $app)
												<option value="{{ $app->id }}">{{ $app->app_name }} - {{ $app->app_unique_id }}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-md-12">
									<div class="mb-3">
										<label class="form-label">{{ _lang('Status') }}</label>
										<select class="form-control select2" name="status" required data-selected="{{ $subscription->status }}">
											<option value="1">{{ _lang('Active') }}</option>
											<option value="0">{{ _lang('In-Active') }}</option>
										</select>
									</div>
								</div>
		
								<div class="col-md-12">
									<div class="mb-3">
										<button type="reset" class="btn btn-danger btn-sm">{{ _lang('Reset') }}</button>
										<button type="submit" class="btn btn-primary btn-sm">{{ _lang('Save') }}</button>
									</div>
								</div>
							</div><!-- Row -->
						</div>
					</div>
				</div>

				<div class="col-md-6">
					<div class="card">
						<div class="card-body">
							<h3 class="mb-3">Add <span style="color: #0C32DC;">Description</span></h3>
							<hr>
							<div class="row">
								<div class="col-md-12">
									@forelse(json_decode($subscription->description) AS $data)
										<div class="row field_group my-2">
											<div class="col-md-12">
												<div class="form-group text-right">
													<button style="padding: 0px 8px;" class="btn btn-danger remove-row btn-xs text-white">-</button>
												</div>
											</div>

											<div class="col-md-12">
												<div class="mb-3">
													<label class="form-label">Description</label>
													<input type="text" class="form-control" name="description[]" value="{{ $data->description }}" required="">
												</div>
											</div>

										</div>
									@empty
										<div class="row field_group my-2">
											<div class="col-md-12">
												<div class="form-group text-right">
													<button class="btn btn-danger remove-row btn-sm text-white mt-1">-</button>
												</div>
											</div>

											<div class="col-md-12">
												<div class="mb-3">
													<label class="form-label">Description</label>
													<input type="text" class="form-control" name="description[]" value="" required="">
												</div>
											</div>

										</div>
									@endforelse
								</div>
								<div class="col-md-12 ml-1">
									<div class="form-group text-end">
										<button type="button" class="btn btn-primary add-more btn-sm" data-team="LR56SVES0">
											Add New
										</button>
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
</form>

<div class="d-none">
	<div class="field_group repeat col-md-12">
		<div class="row my-2">
			<div class="col-md-12">
				<div class="form-group text-right">
					<button style="padding: 0px 8px;" class="btn btn-danger remove-row btn-xs text-white">-</button>
				</div>
			</div>
			<div class="col-md-12">
				<div class="mb-3">
					<label class="form-label">Description</label>
					<input type="text" class="form-control" name="description[]" value="" required="">
				</div>
			</div>

		</div>
	</div>
</div>
@endsection

@section('js-script')
<script>
	$(document).on('click', '.add-more', function(){
		var form = $('.repeat').clone().removeClass('repeat');
		form.find('.image').dropify();
		$(this).closest('.col-md-12').before(form);
	});

	$(document).on('click','.remove-row',function(){
		$(this).closest('.field_group').remove();
	});
</script>
@endsection	

