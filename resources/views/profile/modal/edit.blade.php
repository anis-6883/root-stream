<form action="{{ route('profile.update') }}" class="ajax-submit" autocomplete="off" enctype="multipart/form-data" method="post">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <label class="form-label">{{ _lang('Name') }}</label>
                <input type="text" class="form-control" name="name" value="{{ $profile->name }}" required>
            </div>
        </div>
        <div class="col-md-12">
            <div class="mb-3">
                <label class="form-label">{{ _lang('Email') }}</label>
                <input type="email" class="form-control" name="email" value="{{ $profile->email }}" required>
            </div>
        </div>
        <div class="col-md-12">
            <div class="mb-3">
                <label class="form-label">{{ _lang('Image') }}</label>
                <input type="file" class="form-control dropify" name="image" data-allowed-file-extensions="png jpg jpeg PNG JPG JPEG" data-default-file="{{ $profile->image }}">
            </div>
        </div>
        <div class="col-md-12">
            <div class="mb-3">
                <button type="submit" class="btn btn-primary btn-sm">{{ _lang('Update') }}</button>
            </div>
        </div>
    </div>
</form>
