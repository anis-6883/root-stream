@extends('layouts.app')

@section('page_title', '| Resend Notification')

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class='fas fa-home text-muted'></i></a></li>
        <li class="breadcrumb-item"> <a class="text-muted" href="{{ route('notifications.index') }}">Notifications</a></li>
        <li class="breadcrumb-item active" aria-current="page">Resend</li>
    </ol>
</nav>
<div class="row">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="row flex-grow-1">
            <div class="col-md-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h3 class="mb-3">Resend <span style="color: #0C32DC;">Notification</span></h3>
                        <hr>
                        <form action="{{ route('notifications.update', $notification->id) }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                @php
                                    $notification_apps = json_decode($notification->apps);
                                    $checked = '';

                                    if(count($notification_apps) == counter('apps', ['status' => 1])){
                                        $checked = 'checked';
                                    }
                                @endphp
                                <div class="col-sm-12">
                                    <div style="margin-bottom: 0px;">
                                        <label class="form-label">Select App</label>
                                        <span class="required text-danger"> *</span>
                                    </div>
                                    <div class="d-flex flex-wrap mb-3">
                                        <div class="form-check flex-shrink-0" style="width: 150px">
                                            <label class="form-check-label">
                                                <span class="form-check-sign">Select All</span>
                                                <input class="form-check-input" type="checkbox" value="" id="checkAll" {{ $checked }}>
                                            </label>
                                        </div>

                                        @foreach (App\Models\AppModel::where('status', 1)->get() as $app)
                                        @php
                                            $checked = '';

                                            if(in_array($app->id, $notification_apps)){
                                                $checked = 'checked';
                                            }
                                        @endphp
                                            <div class="form-check flex-shrink-0" style="width: 150px">
                                                <label class="form-check-label">
                                                    <span class="form-check-sign">
                                                        <img src="{{ asset($app->app_logo) }}" width="20px" height="20px" style="margin-right: 5px; border-radius: 10px;margin-bottom: 5px;">
                                                        {{ $app->app_name }}
                                                    </span>
                                                    <input class="form-check-input appbox" type="checkbox" name="apps[]" value="{{ $app->id }}" {{ $checked }}>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Title') }}</label>
                                        <input type="text" class="form-control" name="title" value="{{ $notification->title }}" required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Body') }}</label>
                                        <textarea rows="4"  class="form-control" name="body" required>{{ $notification->message }}</textarea>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Image Type') }}</label>
                                        <select class="form-control select2" name="image_type" data-selected="{{ $notification->image_type }}">
                                            <option value="none">{{ _lang('None') }}</option>
                                            <option value="url">{{ _lang('Url') }}</option>
                                            <option value="image">{{ _lang('Image') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 d-none">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Image Url') }}</label>
                                        <input type="text" class="form-control" name="image_url" value="{{ $notification->image_url }}">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-3 image">
                                        @if ($notification->image_type == 'url')
                                            <img src="{{ $notification->image_url }}" style="width: 150px; border-radius: 10px;">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 d-none">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Image') }}</label>
                                        <input type="file" class="form-control dropify" name="image" data-allowed-file-extensions="png jpg jpeg PNG JPG JPEG" data-default-file="{{ $notification->image ? asset($notification->image) : '' }}">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Notification Type') }}</label>
                                        <select class="form-control select2" name="notification_type" data-selected="{{ $notification->notification_type }}">
                                            <option value="in_app">{{ _lang('inApp') }}</option>
                                            <option value="url">{{ _lang('Url') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 d-none{{ $notification->notification_type != 'url' ? 'd-none' : '' }}"">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Action Url') }}</label>
                                        <input type="text" class="form-control" name="action_url" value="{{ $notification->action_url }}" >
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-4">
                                    <div class="mt-2">
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
<script type="text/javascript">

    $("#checkAll").click(function(){

        if(this.checked){
            $(this).parent().find('span').text('Unselect All');
        }else{
            $(this).parent().find('span').text('Select All');
        }
        $('.appbox').not(this).prop('checked', this.checked);
    });

    $(".appbox").change(function(){
        if ($('.appbox:checked').length == $('.appbox').length) {
            $("#checkAll").prop('checked', true).parent().find('span').text('Unselect All');
        }else{
            $("#checkAll").prop('checked',false).parent().find('span').text('Select All');
        }
    });

	@if ($notification->image_type == 'image')
	$('[name=image]').closest('.col-sm-12').removeClass('d-none');
	@elseif ($notification->image_type == 'url')
	$('[name=image_url]').parent().parent().removeClass('d-none');
	@else
	$('[name=image]').closest('.col-sm-12').addClass('d-none');
    $('[name=image_url]').parent().parent().addClass('d-none');
	@endif
    $('[name=image_type]').on('change', function() {
        $('[name=image]').closest('.col-sm-12').addClass('d-none');
        $('[name=image_url]').parent().parent().addClass('d-none');
        
        if($(this).val() == 'url'){
            $('[name=image_url]').parent().parent().removeClass('d-none');
            $('.image img').show();
            
        }else if($(this).val() == 'image'){
            $('.image img').hide();
            $('[name=image]').closest('.col-sm-12').removeClass('d-none');
        }else{
            $('.image img').hide();
            $('[name=image]').closest('.col-sm-12').addClass('d-none');
            $('[name=image_url]').parent().parent().addClass('d-none');
        }
    });

    $('[name=notification_type]').on('change', function() {
        $('[name=action_url]').closest('.col-sm-12').addClass('d-none');
        if($(this).val() == 'url'){
            $('[name=action_url]').closest('.col-sm-12').removeClass('d-none');
        }else{
            $('[name=action_url]').closest('.col-sm-12').addClass('d-none');
        }
    });

    $('[name=image_url]').on('keyup', function() {
        $('.image').html('<img src="' + $(this).val() + '" style="width: 150px; border-radius: 10px;">');
    });
</script>
@endsection
