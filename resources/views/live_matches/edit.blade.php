@extends('layouts.app')

@section('page_title', '| Edit Live Match')

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class='fas fa-home text-muted'></i></a></li>
        <li class="breadcrumb-item"> <a class="text-muted" href="{{ route('live_matches.index') }}">Live Matches</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit</li>
    </ol>
</nav>
<form action="{{ route('live_matches.update', $live_match->id) }}" method="POST" enctype="multipart/form-data" autocomplete="off">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow-1">
                <div class="col-md-12 stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="mb-3">Edit <span style="color: #0C32DC;">Live Match</span></h3>
                            <hr>
                            <div class="row">

                                @php
                                    $checked = '';
                                    if(counter('live_match_apps', ['match_id' => $live_match->id]) == counter('apps', ['status' => 1])){
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
                                                if(App\Models\LiveMatchApp::where('app_id', $app->id)->where('match_id', $live_match->id)->exists()){
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
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Sports Type') }}</label>
                                        <select class="form-control select2" name="sports_type_id" required>
                                            <option value="">{{ _lang('Select One') }}</option>
                                            @foreach ($sports_types as $type)
                                                <option value="{{ $type->id }}" {{ $type->id === $live_match->sports_type_id ? "selected": "" }}>{{ _lang($type->sports_name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Match Title') }}</label>
                                        <input type="text" name="match_title" class="form-control" value="{{ $live_match->match_title }}" required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Match Time') }}</label>
                                        <input id="datepicker" type="text" name="match_time" class="form-control" value="{{ $live_match->match_time2 }}" required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Image Type') }}</label>
                                        <select class="form-control select2" name="cover_image_type" data-selected="{{ $live_match->cover_image_type }}">
                                            <option value="none">{{ _lang('None') }}</option>
                                            <option value="url">{{ _lang('Url') }}</option>
                                            <option value="image">{{ _lang('Image') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 d-none">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Image Url') }}</label>
                                        <input type="text" class="form-control" name="cover_url" value="{{ $live_match->cover_url }}" >
                                    </div>
                                </div>
                                <div class="col-sm-12 {{ ($live_match->cover_image_type == 'image') ? '' : ' d-none'}}">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Image') }}</label>
                                        <input type="file" class="form-control dropify" name="cover_image" data-allowed-file-extensions="png jpg jpeg PNG JPG JPEG" data-default-file="{{ $live_match->cover_image ? asset($live_match->cover_image) : '' }}">
                                    </div>
                                </div>
                                <div class="col-sm-12 d-none">
                                    <div class="form-group cover_image mb-3"></div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Status') }}</label>
                                        <select class="form-control select2" name="status" required data-selected="{{ $live_match->status }}">
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
                                        <input type="text" name="team_one_name" class="form-control" value="{{ $live_match->team_one_name }}" required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Image Type') }}</label>
                                        <select class="form-control select2" name="team_one_image_type" data-selected="{{ $live_match->team_one_image_type }}">
                                            <option value="none">{{ _lang('None') }}</option>
                                            <option value="url">{{ _lang('Url') }}</option>
                                            <option value="image">{{ _lang('Image') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 d-none">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Image Url') }}</label>
                                        <input type="text" class="form-control" name="team_one_url" value="{{ $live_match->team_one_url }}" >
                                    </div>
                                </div>
                                <div class="col-sm-12 d-none">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Image') }}</label>
                                        <input type="file" class="form-control dropify" name="team_one_image" data-allowed-file-extensions="png jpg jpeg PNG JPG JPEG" data-default-file="{{ $live_match->team_one_image ? asset($live_match->team_one_image) : '' }}">
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
                                        <input type="text" name="team_two_name" class="form-control" value="{{ $live_match->team_two_name }}" required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Image Type') }}</label>
                                        <select class="form-control select2" name="team_two_image_type" data-selected="{{ $live_match->team_two_image_type }}">
                                            <option value="none">{{ _lang('None') }}</option>
                                            <option value="url">{{ _lang('Url') }}</option>
                                            <option value="image">{{ _lang('Image') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 d-none">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Image Url') }}</label>
                                        <input type="text" class="form-control" name="team_two_url" value="{{ $live_match->team_two_url }}" >
                                    </div>
                                </div>
                                <div class="col-sm-12 d-none">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Image') }}</label>
                                        <input type="file" class="form-control dropify" name="team_two_image" data-allowed-file-extensions="png jpg jpeg PNG JPG JPEG" data-default-file="{{ $live_match->team_two_image ? asset($live_match->team_two_image) : '' }}">
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

                            @foreach (App\Models\StreamingSource::where('match_id', $live_match->id)->get() as $key => $streaming_source)
                                <div class="row field-group mb-4">
                                    <input type="hidden" value="no" name="is_deleted[{{ $key }}]" class="is_deleted" />
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
                                                            <input type="text" class="form-control" name="stream_title[{{ $key }}]" value="{{ $streaming_source->stream_title }}" required>
                                                        </div>
                                                    </div>
                
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">{{ _lang('Resulation') }}</label>
                                                            <select class="form-control select2" name="resulation[{{ $key }}]" data-selected="{{ $streaming_source->resulation }}" required>
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
                                                            <select class="form-control select2 stream_type" name="stream_type[{{ $key }}]" data-selected="{{ $streaming_source->stream_type }}" required>
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
                                                            <input type="url" class="form-control" name="stream_url[{{ $key }}]" value="{{ $streaming_source->stream_url }}" required>
                                                        </div>
                                                    </div>
            
                                                    <div class="col-md-6 root_stream {{ ($streaming_source->stream_type == 'root_stream') ? '' : ' d-none'}}"">
                                                        <div class="mb-3">
                                                            <label class="form-label">
                                                                {{ _lang('Stream Key') }}
                                                                <span class="text-danger"> *</span>
                                                            </label>
                                                            <input type="text" class="form-control" name="stream_key[{{ $key }}]" value="{{ $streaming_source->stream_key }}">
                                                        </div>
                                                    </div>
            
                                                    <!-- Nested Form Fields (Start) -->
                                                    @if ( $streaming_source->stream_type == 'restricted')

                                                    @foreach (json_decode($streaming_source->headers) as $key2 => $value)
                                                        <div class="row field-group2 restricted mb-3 m-auto w-100 {{ $streaming_source->stream_type != 'restricted' ? 'd-none' : '' }}">
                
                                                            <div class="card" style="background: #F5F7FF">
                                                                <div class="card-body">
                                                                    <div class="text-end">
                                                                        <button style="padding: 1px 8px;" type="button" class="btn btn-danger btn-xs">-</button>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-6 restricted d-none">
                                                                            <div class="mb-3">
                                                                                <label class="form-label">{{ _lang('Name') }}</label>
                                                                                <input type="text" class="form-control" name="name[{{ $key }}][]" value="{{ $key2 }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 restricted d-none">
                                                                            <div class="mb-3">
                                                                                <label class="form-label">{{ _lang('Value') }}</label>
                                                                                <input type="text" class="form-control" name="value[{{ $key }}][]" value="{{ $value }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                
                                                        </div>
                                                    @endforeach
                                                    
                                                    @else
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
                                                                                <input type="text" class="form-control" name="name[{{ $key }}][]" value="Content-Type">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 restricted d-none">
                                                                            <div class="mb-3">
                                                                                <label class="form-label">{{ _lang('Value') }}</label>
                                                                                <input type="text" class="form-control" name="value[{{ $key }}][]" value="application/json; charset=UTF-8">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                
                                                        </div>
                                                    @endif
                                                    
                                                    <!-- Nested Form Fields (End) -->
            
                                                    <div class="col-md-11 text-end restricted m-auto {{ $streaming_source->stream_type != 'restricted' ? 'd-none' : '' }}">
                                                        <div class="mb-3">
                                                            <button type="button" class="btn btn-primary btn-sm add-more2">{{ _lang('Add More') }}</button>
                                                        </div>
                                                    </div>
            
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" id="block__country__label">{{ _lang('Block/Unblock Countries') }}</label>
                                                            <select class="form-control select2 countries" data-selected="{{ json_encode(explode(',', $streaming_source->block_country)) }}" multiple name="enable_countries[]">
                                                                {{ get_country_list() }}
                                                            </select>
                                                            <input class="block_country" type="hidden" name="block_country[]" value="{{ $streaming_source->block_country }}">
                                                        </div>
                                                    </div>
            
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <div class="form-check form-switch">
                                                                <input type="hidden" name="is_block_them[{{ $key }}]" value="{{ $streaming_source->is_block_them }}" class="block_them">
                                                                <input type="checkbox" class="form-check-input custom-control-input" id="customSwitch{{ $key }}" {{ $streaming_source->is_block_them == '1' ? "checked" : "" }}>
                                                                <label class="form-check-label" for="customSwitch{{ $key }}"><b>{{ $streaming_source->is_block_them == '1' ? "Block" : "Unblock" }}</b></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

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
                <button type="submit" class="btn btn-primary btn-md">{{ _lang('Update') }}</button>
            </div>
        </div>

    </div>
    <!-- row -->
</form>

<div class="d-none">

    <div class="row field-group mb-4 repeat">
        <input type="hidden" value="no" name="is_deleted" class="is_deleted" />
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

    // Show Image/URL
    @if($live_match->cover_image_type == 'url')
        $('[name=cover_url]').parent().parent().removeClass('d-none');
        $('.cover_image').html('<img src="{{ $live_match->cover_url }}" style="width: 150px; border-radius: 10px;">');
    @elseif($live_match->cover_image_type == 'image')
        $('[name=cover_image]').closest('.col-sm-12').removeClass('d-none');
    @else
        $('[name=cover_image]').closest('.col-sm-12').addClass('d-none');
        $('[name=cover_url]').parent().parent().addClass('d-none');
    @endif

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

    @if($live_match->team_one_image_type == 'url')
        $('[name=team_one_url]').parent().parent().removeClass('d-none');
        $('.team_one_image_show').parent().removeClass('d-none');
        $('.team_one_image_show').html('<img src="{{ $live_match->team_one_url }}" style="width: 150px; border-radius: 10px;">');
    @elseif($live_match->team_one_image_type == 'image')
        $('[name=team_one_image]').closest('.col-sm-12').removeClass('d-none');
    @else
        $('[name=team_one_image]').closest('.col-sm-12').addClass('d-none');
        $('[name=team_one_url]').parent().parent().addClass('d-none');
    @endif

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

    @if($live_match->team_two_image_type == 'url')
        $('[name=team_two_url]').parent().parent().removeClass('d-none');
        $('.team_two_image_show').parent().removeClass('d-none');
        $('.team_two_image_show').html('<img src="{{ $live_match->team_two_url }}" style="width: 150px; border-radius: 10px;">');
    @elseif($live_match->team_two_image_type == 'image')
        $('[name=team_two_image]').closest('.col-sm-12').removeClass('d-none');
    @else
        $('[name=team_two_image]').closest('.col-sm-12').addClass('d-none');
        $('[name=team_two_url]').parent().parent().addClass('d-none');
    @endif

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
    // var i = 1;
    var i = +'{{ $key + 1 }}';

    $('.add-more').on('click',function(){
        var form = $('.repeat').clone().removeClass('repeat');
        form.find('.remove').addClass('remove-row');
        form.find('.countries').select2();
        form.find('[name=resulation]').select2();
        form.find('[name=stream_type]').select2();
        form.find('.custom-control-input').attr('id', 'customSwitch' + i);
        form.find('.custom-form-label').attr('for', 'customSwitch' + i);

        form.find('[name=is_deleted]').attr('name', 'is_deleted[' + i + ']');
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
        // $(this).closest('.field-group').remove();

        var outerContainer = $(this).closest('.field-group').closest('.outerContainer');
        var remainChild = outerContainer.find('.field-group').length;
        var remainChild2 = outerContainer.find('.field-group.d-none').length;

        console.log(remainChild)
        console.log(remainChild2)

        if(remainChild != remainChild2 + 1)
        {
            $(this).closest('.field-group').addClass('d-none').find('.is_deleted').val('yes');
            $(this).closest('.field-group').find('input, select').attr('required', false);
        } 
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
        var innerContainer = $(this).closest('.field-group2').closest('.innerContainer');
        var remainChild = innerContainer.find('.field-group2').length;
        if(remainChild == 1)
        {
            innerContainer.find('.stream_type').prop('selectedIndex',0);
            console.log(innerContainer.find('.stream_type'));
            innerContainer.find('.add-more2').closest('.col-md-11').addClass('d-none');
            $(this).closest('.field-group2').addClass('d-none');
        }
        else{
            $(this).closest('.field-group2').remove();
        }
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