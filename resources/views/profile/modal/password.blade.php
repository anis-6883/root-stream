<form action="{{ route('password.update') }}" class="ajax-submit" method="post" autocomplete="off">
    @csrf
	<div class="row">
		<div class="col-md-12">
			<div class="mb-3">
				<label class="form-label">{{ _lang('Old Password') }}</label>
				<input type="password" class="form-control" name="oldpassword" required>
			</div>
		</div>
		<div class="col-md-12">
			<div class="mb-3">
				<label class="form-label">{{ _lang('New Password') }}</label>
				<input type="password" class="form-control" name="password" required>
			</div>
		</div>
		<div class="col-md-12">
			<div class="mb-3">
				<label class="form-label">{{ _lang('Confirm Password') }}</label>
				<input type="password" id="password-confirm" class="form-control" name="password_confirmation" required>
			</div>
		</div>
		<div class="col-md-12">
			<div class="mb-3">
				<button type="reset" class="btn btn-danger btn-sm">{{ _lang('Reset') }}</button>
				<button type="submit" class="btn btn-primary btn-sm">{{ _lang('Update') }}</button>
			</div>
		</div>
	</div>
</form>
