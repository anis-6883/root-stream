@extends('layouts.app')

@section('page_title', '| Add App')

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class='fas fa-home text-muted'></i></a></li>
        <li class="breadcrumb-item"> <a class="text-muted" href="{{ route('apps.index') }}">Apps</a></li>
        <li class="breadcrumb-item active" aria-current="page">Create</li>
    </ol>
</nav>
<div class="row">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="row flex-grow-1">
            <div class="col-md-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h3 class="mb-3">Add New <span style="color: #0C32DC;">App</span></h3>
                        <hr>
                        <form action="{{ route('apps.store') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            @method('POST')

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">App Name</label>
                                        <input type="text" class="form-control @error('app_name') is-invalid @enderror" name="app_name" value="{{ old('app_name') }}" required>
                                        @error('app_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">App Unique Id</label>
                                        <input type="text" class="form-control @error('app_unique_id') is-invalid @enderror" name="app_unique_id" value="{{ time() }}_{{ rand() }}" readonly required>
                                        @error('app_unique_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">App Logo Type</label>
                                        <select class="form-control select2" name="app_logo_type" required>
                                            <option value="">None</option>
                                            <option value="url">Url</option>
                                            <option value="image">Image</option>
                                        </select>
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-12 d-none">
                                    <div class="mb-3">
                                        <label class="form-label">Image Url</label>
                                        <input type="url" class="form-control" name="app_logo_url" value="{{ old('app_logo_url') }}">
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-12 d-none">
                                    <div class="mb-3">
                                        <label class="form-label">Image</label>
                                        <input type="file" class="form-control dropify" name="app_logo" data-allowed-file-extensions="png jpg jpeg PNG JPG JPEG">
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-12 d-none">
                                    <div class="mb-3" id="app_logo_show"></div>
                                </div><!-- Col -->
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Notification Type</label>
                                        <select class="form-control select2" name="notification_type" required>
                                            <option value="onesignal">One Signal</option>
                                            <option value="fcm">FCM</option>
                                        </select>
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6 onesignal">
                                    <div class="mb-3">
                                        <label class="form-label">One Signal App ID</label>
                                        <input type="text" name="onesignal_app_id" class="form-control" value="{{ old('onesignal_app_id') }}" required>
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6 onesignal">
                                    <div class="mb-3">
                                        <label class="form-label">One Signal Api Key</label>
                                        <input type="text" name="onesignal_api_key" class="form-control" value="{{ old('onesignal_api_key') }}" required>
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6 fcm d-none">
                                    <div class="mb-3">
                                        <label class="form-label">Firebase Server Key</label>
                                        <input type="text" name="firebase_server_key" class="form-control" value="{{ old('firebase_server_key') }}" disabled required>
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6 fcm d-none">
                                    <div class="mb-3">
                                        <label class="form-label">Firebase Topics</label>
                                        <input type="text" name="firebase_topics" class="form-control" value="{{ old('firebase_topics') }}" disabled required>
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Support Mail</label>
                                        <input type="email" class="form-control" name="support_mail" value="{{ old('support_mail') }}">
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">From Mail</label>
                                        <input type="email" class="form-control" name="from_mail" value="{{ old('from_mail') }}">
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">From Name</label>
                                        <input type="text" class="form-control" name="from_name" value="{{ old('from_name') }}">
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">SMTP Host</label>
                                        <input type="text" class="form-control smtp" name="smtp_host" value="{{ old('smtp_host') }}">
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">SMTP Port</label>
                                        <input type="text" class="form-control smtp" name="smtp_port" value="{{ old('smtp_port') }}">
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">SMTP Username</label>
                                        <input type="text" class="form-control smtp" autocomplete="off" name="smtp_username" value="{{ old('smtp_username') }}">
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">SMTP Password</label>
                                        <input type="password" class="form-control smtp" autocomplete="off" name="smtp_password" value="{{ old('smtp_password') }}">
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">SMTP Encryption</label>
                                        <select class="form-control smtp select2" name="smtp_encryption" data-selected="{{ old('smtp_encryption', 'ssl') }}">
                                            <option value="ssl">SSL</option>
                                            <option value="tls">TLS</option>
                                        </select>
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select class="form-select select2" name="status" required data-selected="{{ old('status', "1") }}">
                                            <option value="1">Active</option>
                                            <option value="0">In-Active</option>
                                        </select>
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-12 mb-4">
                                    <div class="mt-2 d-flex justify-content-end" id="submit-trigger">
                                        <button type="reset" class="btn btn-danger me-2">Reset</button>
                                        <button type="submit" class="btn btn-primary submit">Submit</button>
                                    </div>
                                </div><!-- Col -->
                            </div><!-- Row -->
                        </form>
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
    // Handle App Logo Image/URL
    $('[name=app_logo_type]').on('change', function() {
        $('[name=app_logo]').closest('.col-sm-12').addClass('d-none');
        $('[name=app_logo_url]').closest('.col-sm-12').addClass('d-none');
        
        if($(this).val() == 'url'){
            $('[name=app_logo]').removeAttr('required').val("");
            $('[name=app_logo_url]').attr("required", true).closest('.col-sm-12').removeClass('d-none');
        }else if($(this).val() == 'image'){
            $('[name=app_logo_url]').removeAttr('required').val("");
            $('[name=app_logo]').attr("required", true).closest('.col-sm-12').removeClass('d-none');
            $('#app_logo_show').parent().addClass('d-none');
        }else{
            $('[name=app_logo]').removeAttr('required').val("").closest('.col-sm-12').addClass('d-none');
            $('[name=app_logo_url]').removeAttr('required').val("").closest('.col-sm-12').addClass('d-none');
            $('#app_logo_show').parent().addClass('d-none');
        }
    });

    $('[name=app_logo_url]').on('keyup', function() {
		$('#app_logo_show').parent().removeClass('d-none');
        $('#app_logo_show').html('<img src="' + $(this).val() + '" style="width: 150px; border-radius: 10px;">');
    });

    // Handle Notification Type
    $('[name=notification_type]').on('change', function() {
		if($(this).val() == 'onesignal'){
			$('.onesignal').removeClass('d-none').find('input').attr('disabled', false);
            $('[name=onesignal_app_id]').attr("required", true);
			$('[name=onesignal_api_key]').attr("required", true);
            $('[name=firebase_server_key]').removeAttr('required').val('');
            $('[name=firebase_topics]').removeAttr('required').val('');
			$('.fcm').addClass('d-none').find('input').attr('disabled', true);
		}else{
			$('.fcm').removeClass('d-none').find('input').attr('disabled', false);
            $('[name=firebase_server_key]').attr("required", true);
			$('[name=firebase_topics]').attr("required", true);
            $('[name=onesignal_app_id]').removeAttr('required').val('');
            $('[name=onesignal_api_key]').removeAttr('required').val('');
			$('.onesignal').addClass('d-none').find('input').attr('disabled', true);
		}
	});
	$('[name=app_name]').on('keyup', function() {
		$('[name=firebase_topics]').val($(this).val().replace(/\s/g, ''));
	});
</script>
@endsection