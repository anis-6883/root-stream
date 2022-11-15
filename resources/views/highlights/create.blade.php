@extends('layouts.app')

@section('page_title', '| Add Highlight')

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class='fas fa-home text-muted'></i></a></li>
        <li class="breadcrumb-item"> <a class="text-muted" href="{{ route('highlights.index') }}">Highlightes</a></li>
        <li class="breadcrumb-item active" aria-current="page">Create</li>
    </ol>
</nav>
<form action="{{ route('highlights.store') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
    @csrf
    @method('POST')

    <div class="row">
        <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow-1">
                <div class="col-md-12 stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="mb-3">Add New <span style="color: #0C32DC;">Highlight</span></h3>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div style="margin-bottom: 0px;">
                                        <label class="form-label">Select App</label>
                                        <span class="required text-danger"> *</span>
                                    </div>
                                    <div class="d-flex flex-wrap mb-3">
                                        <div class="form-check flex-shrink-0" style="width: 150px">
                                            <label class="form-check-label">
                                                <span class="form-check-sign">Select All</span>
                                                <input class="form-check-input" type="checkbox" value="" id="checkAll">
                                            </label>
                                        </div>

                                        @foreach ($apps as $app)
                                            <div class="form-check flex-shrink-0" style="width: 150px">
                                                <label class="form-check-label">
                                                    <span class="form-check-sign">
                                                        <img src="{{ asset($app->app_logo) }}" width="20px" height="20px" style="margin-right: 5px; border-radius: 10px;margin-bottom: 5px;">
                                                        {{ $app->app_name }}
                                                    </span>
                                                    <input class="form-check-input appbox" type="checkbox" name="apps[]" value="{{ $app->id }}">
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Sports Type') }}</label>
                                        <select class="form-control select2" name="sports_type_id" required>
                                            <option value="">{{ _lang('Select One') }}</option>
                                            @foreach ($sports_types as $type)
                                                <option value="{{ $type->id }}">{{ _lang($type->sports_name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Match Title') }}</label>
                                        <input type="text" name="match_title" class="form-control" value="{{ old('match_title') }}" required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Image Type') }}</label>
                                        <select class="form-control select2" name="cover_image_type" data-selected="{{ old('cover_image_type', 'none') }}">
                                            <option value="none">{{ _lang('None') }}</option>
                                            <option value="url">{{ _lang('Url') }}</option>
                                            <option value="image">{{ _lang('Image') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 d-none">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Image Url') }}</label>
                                        <input type="text" class="form-control" name="cover_url" value="{{ old('cover_url') }}" >
                                    </div>
                                </div>
                                <div class="col-sm-12 d-none">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Image') }}</label>
                                        <input type="file" class="form-control dropify" name="cover_image" data-allowed-file-extensions="png jpg jpeg PNG JPG JPEG">
                                    </div>
                                </div>
                                <div class="col-sm-12 d-none">
                                    <div class="form-group cover_image mb-3"></div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Status') }}</label>
                                        <select class="form-control select2" name="status" required>
                                            <option value="1">{{ _lang('Active') }}</option>
                                            <option value="0">{{ _lang('In-Active') }}</option>
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

    <div class="row">
        <div class="col-12 col-xl-6 mt-3">
            <div class="row flex-grow-1">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="mb-3">Team One <span style="color: #0C32DC;">Information</span></h3>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Name') }}</label>
                                        <input type="text" name="team_one_name" class="form-control" value="{{ old('team_one_name') }}" required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Image Type') }}</label>
                                        <select class="form-control select2" name="team_one_image_type" data-selected="{{ old('team_one_image_type', 'none') }}">
                                            <option value="none">{{ _lang('None') }}</option>
                                            <option value="url">{{ _lang('Url') }}</option>
                                            <option value="image">{{ _lang('Image') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 d-none">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Image Url') }}</label>
                                        <input type="text" class="form-control" name="team_one_url" value="{{ old('team_one_url') }}" >
                                    </div>
                                </div>
                                <div class="col-sm-12 d-none">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Image') }}</label>
                                        <input type="file" class="form-control dropify" name="team_one_image" data-allowed-file-extensions="png jpg jpeg PNG JPG JPEG">
                                    </div>
                                </div>
                                <div class="col-sm-12 d-none">
                                    <div class="form-group team_one_image_show"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-6 mt-3">
            <div class="row flex-grow-1">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="mb-3">Team Two <span style="color: #0C32DC;">Information</span></h3>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Name') }}</label>
                                        <input type="text" name="team_two_name" class="form-control" value="{{ old('team_two_name') }}" required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Image Type') }}</label>
                                        <select class="form-control select2" name="team_two_image_type" data-selected="{{ old('team_two_image_type', 'none') }}">
                                            <option value="none">{{ _lang('None') }}</option>
                                            <option value="url">{{ _lang('Url') }}</option>
                                            <option value="image">{{ _lang('Image') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 d-none">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Image Url') }}</label>
                                        <input type="text" class="form-control" name="team_two_url" value="{{ old('team_two_url') }}" >
                                    </div>
                                </div>
                                <div class="col-sm-12 d-none">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Image') }}</label>
                                        <input type="file" class="form-control dropify" name="team_two_image" data-allowed-file-extensions="png jpg jpeg PNG JPG JPEG">
                                    </div>
                                </div>
                                <div class="col-sm-12 d-none">
                                    <div class="form-group team_two_image_show"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row -->

    <div class="row">
        <div class="col-12 col-xl-12 mt-3 stretch-card">
            <div class="row flex-grow-1">
                <div class="col-md-12 stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="mb-3">Streaming <span style="color: #0C32DC;">Sources</span></h3>
                            <hr>
                            <div class="row field-group mb-4">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
        
                                            <div class="text-end">
                                                <button style="padding: 1px 8px;" type="button" class="btn btn-danger btn-sm">-</button>
                                            </div>
            
                                            <div class="row">
            
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">{{ _lang('Stream Title') }}</label>
                                                        <input type="text" class="form-control" name="stream_title[0]" required>
                                                    </div>
                                                </div>
            
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">{{ _lang('Resulation') }}</label>
                                                        <select class="form-control select2" name="resulation[0]" required>
                                                            <option value="">{{ _lang('Select One') }}</option>
                                                            <option value="1080p">{{ _lang('1080p') }}</option>
                                                            <option value="720p">{{ _lang('720p') }}</option>
                                                            <option value="480p">{{ _lang('480p') }}</option>
                                                            <option value="360p">{{ _lang('360p') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
            
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">{{ _lang('Stream Type') }}</label>
                                                        <select class="form-control select2 stream_type" name="stream_type[0]" required>
                                                            <option value="">{{ _lang('Select One') }}</option>
                                                            <option value="restricted">{{ _lang('Restricted') }}</option>
                                                            <option value="root_stream">{{ _lang('RootStream') }}</option>
                                                            <option value="m3u8">{{ _lang('M3u8') }}</option>
                                                            <option value="web">{{ _lang('Web') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
            
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">{{ _lang('Stream Url') }}</label>
                                                        <input type="url" class="form-control" name="stream_url[0]" required>
                                                    </div>
                                                </div>
        
                                                <div class="col-md-6 root_stream d-none">
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            {{ _lang('Stream Key') }}
                                                            <span class="text-danger"> *</span>
                                                        </label>
                                                        <input type="text" class="form-control" name="stream_key[0]">
                                                    </div>
                                                </div>
        
                                                <!-- Nested Form Fields (Start) -->
                                                <div class="row field-group2 restricted d-none mb-3 m-auto w-100">
        
                                                    <div class="card" style="background: #F5F7FF">
                                                        <div class="card-body">
                                                            <div class="text-end">
                                                                <button style="padding: 1px 8px;" type="button" class="btn btn-danger btn-xs">-</button>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6 restricted d-none">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">{{ _lang('Name') }}</label>
                                                                        <input type="text" class="form-control" name="name[0][]" value="Content-Type">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 restricted d-none">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">{{ _lang('Value') }}</label>
                                                                        <input type="text" class="form-control" name="value[0][]" value="application/json; charset=UTF-8">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
        
                                                </div>
                                                <!-- Nested Form Fields (End) -->
        
                                                <div class="col-md-11 text-end restricted d-none m-auto">
                                                    <div class="mb-3">
                                                        <button type="button" class="btn btn-primary btn-sm add-more2">{{ _lang('Add More') }}</button>
                                                    </div>
                                                </div>
        
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label class="form-label" id="block__country__label">{{ _lang('Block/Unblock Countries') }}</label>
                                                        <select class="form-control select2 countries" data-selected="{{ json_encode(old('enable_countries')) }}" multiple>
                                                            {{ get_country_list() }}
                                                        </select>
                                                        <input class="block_country" type="hidden" name="block_country[]">
                                                    </div>
                                                </div>
        
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <div class="form-check form-switch">
                                                            <input type="hidden" name="is_block_them[0]" value="0" class="block_them">
                                                            <input type="checkbox" class="form-check-input custom-control-input" id="customSwitch">
                                                            <label class="form-check-label" for="customSwitch"><b>Unblock</b></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 text-end mt-4">
                                <div class="mb-3">
                                    <button type="button" class="btn btn-primary btn-sm add-more">{{ _lang('Add More') }}</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="mb-3 mt-3 text-end">
                <button type="reset" class="btn btn-danger btn-md">{{ _lang('Reset') }}</button>
                <button type="submit" class="btn btn-primary btn-md">{{ _lang('Save') }}</button>
            </div>
        </div>

    </div>
    <!-- row -->
</form>

<div class="d-none">

    <div class="row field-group mb-4 repeat">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-end">
                        <button style="padding: 1px 8px;" type="button" class="btn btn-danger btn-sm remove">-</button>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">{{ _lang('Stream Title') }}</label>
                                <input type="text" class="form-control" name="stream_title" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">{{ _lang('Resulation') }}</label>
                                <select class="form-control" name="resulation" required>
                                    <option value="">{{ _lang('Select One') }}</option>
                                    <option value="1080p">{{ _lang('1080p') }}</option>
                                    <option value="720p">{{ _lang('720p') }}</option>
                                    <option value="480p">{{ _lang('480p') }}</option>
                                    <option value="360p">{{ _lang('360p') }}</option>
                                </select>
                            </div>
                        </div>       
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">{{ _lang('Stream Type') }}</label>
                                <select class="form-control stream_type" name="stream_type" required>
                                    <option value="">{{ _lang('Select One') }}</option>
                                    <option value="restricted">{{ _lang('Restricted') }}</option>
                                    <option value="root_stream">{{ _lang('RootStream') }}</option>
                                    <option value="m3u8">{{ _lang('M3u8') }}</option>
                                    <option value="web">{{ _lang('Web') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">{{ _lang('Stream Url') }}</label>
                                <input type="url" class="form-control" name="stream_url" required>
                            </div>
                        </div>
                        <div class="col-md-6 root_stream d-none">
                            <div class="mb-3">
                                <label class="form-label">
                                    {{ _lang('Stream Key') }}
                                    <span class="text-danger"> *</span>
                                </label>
                                <input type="text" class="form-control" name="stream_key">
                            </div>
                        </div>

                        <!-- Nested Form Fields (Start) -->
                        <div class="row field-group2 restricted d-none mb-3 m-auto w-100">
                            <div class="card" style="background: #F5F7FF">
                                <div class="card-body">
                                    <div class="text-end">
                                        <button style="padding: 1px 8px;" type="button" class="btn btn-danger btn-xs">-</button>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 restricted d-none">
                                            <div class="mb-3">
                                                <label class="form-label">{{ _lang('Name') }}</label>
                                                <input type="text" class="form-control" name="name" value="Content-Type">
                                            </div>
                                        </div>
                                        <div class="col-md-6 restricted d-none">
                                            <div class="mb-3">
                                                <label class="form-label">{{ _lang('Value') }}</label>
                                                <input type="text" class="form-control" name="value" value="application/json; charset=UTF-8">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Nested Form Fields (End) -->

                        <div class="col-md-11 text-end restricted d-none m-auto">
                            <div class="mb-3">
                                <button type="button" class="btn btn-primary btn-sm add-more2">{{ _lang('Add More') }}</button>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label" id="block__country__label">{{ _lang('Block/Unblock Countries') }}</label>
                                <select class="form-control countries w-100" data-selected="{{ json_encode(old('enable_countries')) }}" multiple>
                                    {{ get_country_list() }}
                                </select>
                                <input class="block_country" type="hidden" name="block_country[]">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="is_block_them" value="0" class="block_them">
                                    <input type="checkbox" class="form-check-input custom-control-input" id="customSwitch">
                                    <label class="form-check-label" for="customSwitch"><b>Unblock</b></label>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row field-group2 restricted repeat2 mb-3 m-auto w-100">
        <div class="card" style="background: #F5F7FF">
            <div class="card-body">
                <div class="text-end">
                    <button style="padding: 1px 8px;" type="button" class="btn btn-danger btn-xs remove-row2">-</button>
                </div>
                <div class="row">
                    <div class="col-md-6 restricted">
                        <div class="mb-3">
                            <label class="form-label">{{ _lang('Name') }}</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                    </div>
                    <div class="col-md-6 restricted">
                        <div class="mb-3">
                            <label class="form-label">{{ _lang('Value') }}</label>
                            <input type="text" class="form-control" name="value">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('js-script')
<script>
    // Check All Apps
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

    // Handle Cover Image/URL
    $('[name=cover_image_type]').on('change', function() {
        $('[name=cover_image]').closest('.col-sm-12').addClass('d-none');
        $('[name=cover_url]').parent().parent().addClass('d-none');
        
        if($(this).val() == 'url'){
            $('[name=cover_url]').parent().parent().removeClass('d-none');
            $('.cover_image').parent().removeClass('d-none');
            
        }else if($(this).val() == 'image'){
            $('[name=cover_image]').closest('.col-sm-12').removeClass('d-none');
            $('.cover_image').parent().addClass('d-none');
        }else{
            $('[name=cover_image]').closest('.col-sm-12').addClass('d-none');
            $('[name=cover_url]').parent().parent().addClass('d-none');
            $('.cover_image').parent().addClass('d-none');
        }
    });

    $('[name=cover_url]').on('keyup', function() {
        $('.cover_image').html('<img src="' + $(this).val() + '" style="width: 150px; border-radius: 10px;">');
    });

    // Handle Team One Image/URL
    $('[name=team_one_image_type]').on('change', function() {
        $('[name=team_one_image]').closest('.col-sm-12').addClass('d-none');
        $('[name=team_one_url]').parent().parent().addClass('d-none');
        
        if($(this).val() == 'url'){
            $('[name=team_one_url]').parent().parent().removeClass('d-none');
            $('.team_one_image_show').parent().removeClass('d-none');
            
        }else if($(this).val() == 'image'){
            $('[name=team_one_image]').closest('.col-sm-12').removeClass('d-none');
            $('.team_one_image_show').parent().addClass('d-none');
        }else{
            $('[name=team_one_image]').closest('.col-sm-12').addClass('d-none');
            $('[name=team_one_url]').parent().parent().addClass('d-none');
            $('.team_one_image_show').parent().addClass('d-none');
        }
    });

    $('[name=team_one_url]').on('keyup', function() {
        $('.team_one_image_show').html('<img src="' + $(this).val() + '" style="width: 150px; border-radius: 10px;">');
    });

    // Handle Team Two Image/URL
    $('[name=team_two_image_type]').on('change', function() {
    $('[name=team_two_image]').closest('.col-sm-12').addClass('d-none');
    $('[name=team_two_url]').parent().parent().addClass('d-none');
    
    if($(this).val() == 'url'){
        $('[name=team_two_url]').parent().parent().removeClass('d-none');
        $('.team_two_image_show').parent().removeClass('d-none');
        
    }else if($(this).val() == 'image'){
        $('[name=team_two_image]').closest('.col-sm-12').removeClass('d-none');
        $('.team_two_image_show').parent().addClass('d-none');
    }else{
        $('[name=team_two_image]').closest('.col-sm-12').addClass('d-none');
        $('[name=team_two_url]').parent().parent().addClass('d-none');
        $('.team_two_image_show').parent().addClass('d-none');
    }
    });

    $('[name=team_two_url]').on('keyup', function() {
        $('.team_two_image_show').html('<img src="' + $(this).val() + '" style="width: 150px; border-radius: 10px;">');
    });

    // Handle Restricted Stream and Headers
    $(document).on('change', '.stream_type', function() {

    $dis = $(this).closest('.field-group');

    if($(this).val() == 'root_stream'){
        $dis.find('.root_stream').removeClass('d-none').find('input, select').attr('required', true);
        $dis.find('.restricted').addClass('d-none').find('input, select').attr('required', false);
    }else if($(this).val() == 'restricted'){
        $dis.find('.restricted').removeClass('d-none').find('input, select').attr('required', true);
    }else{
        $dis.find('.restricted').addClass('d-none').find('input, select').attr('required', false);
        $dis.find('.root_stream').addClass('d-none').find('input, select').attr('required', false);
    }
    });

    // Add More Stream
    var i = 1;
    $('.add-more').on('click',function(){
        var form = $('.repeat').clone().removeClass('repeat');
        form.find('.remove').addClass('remove-row');
        form.find('.countries').select2();
        form.find('[name=resulation]').select2();
        form.find('[name=stream_type]').select2();
        form.find('.custom-control-input').attr('id', 'customSwitch' + i);
        form.find('.custom-form-label').attr('for', 'customSwitch' + i);

        form.find('[name=stream_title]').attr('name', 'stream_title[' + i + ']');
        form.find('[name=resulation]').attr('name', 'resulation[' + i + ']');
        form.find('[name=stream_type]').attr('name', 'stream_type[' + i + ']');
        form.find('[name=stream_url]').attr('name', 'stream_url[' + i + ']');
        form.find('[name=stream_key]').attr('name', 'stream_key[' + i + ']');
        form.find('[name=is_block_them]').attr('name', 'is_block_them[' + i + ']');
        form.find('[name=name]').attr('name', 'name[' + i + '][]');
        form.find('[name=value]').attr('name', 'value[' + i + '][]');

        i++;
        $(this).closest('.col-md-12').before(form);
    });

    // Delete Stream Card
    $(document).on('click','.remove-row',function(){
        $(this).closest('.field-group').remove();
    });

    // Add More Restricted Stream Headers
    $(document).on('click', '.add-more2', function(){
        var form = $('.repeat2').clone().removeClass('repeat2');
        var name = $(this).closest('.field-group').find('[name^="name"]:first').attr('name');
        var value = $(this).closest('.field-group').find('[name^="value"]:first').attr('name');

        form.find('[name=name]').attr('name', name);
        form.find('[name=value]').attr('name', value);

        $(this).closest('.col-md-11').before(form);
    });

    // Delete Restricted Stream Headers
    $(document).on('click','.remove-row2',function(){
        $(this).closest('.field-group2').remove();
    });

    // Block Country List
    $(document).on('change', '.countries', function() {
        // console.log($(this).val())
        $(this).parent().find('.block_country').val($(this).val());
        /* Act on the event */
    });

    // Handle Block
    $(document).on('click', '.form-check-input', function() {

        var is_block_them = $(this).parent().find('.block_them').val();

        if(is_block_them == 0){
            $(this).parent().find('.block_them').val(1);
            $(this).parent().find('.form-check-label').html("<b>Block</b>");
        }else{
            $(this).parent().find('.block_them').val(0);
            $(this).parent().find('.form-check-label').html("<b>Unblock</b>");
        }
    });
</script>
@endsection