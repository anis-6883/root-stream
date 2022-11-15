@extends('layouts.app')

@section('page_title', '| Edit Popular Series')

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class='fas fa-home text-muted'></i></a></li>
        <li class="breadcrumb-item"> <a class="text-muted" href="{{ route('popular_series.index') }}">Popular Series</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit</li>
    </ol>
</nav>
<div class="row">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="row flex-grow-1">
            <div class="col-md-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h3 class="mb-3">Edit <span style="color: #0C32DC;">Popular Series</span></h3>
                        <hr>
                        <form action="{{ route('popular_series.update', $series->id) }}" method="POST" autocomplete="off">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                @php
                                    $apps = json_decode($series->apps);
                                    $checked = '';

                                    if(count($apps) == counter('apps', ['status' => 1])){
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

                                            if(in_array($app->id, $apps)){
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
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Title') }}</label>
                                        <input type="text" class="form-control" name="title" value="{{ $series->title }}" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Description') }}</label>
                                        <textarea rows="4"  class="form-control" name="description">{{ $series->description }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Action Url') }}</label>
                                        <input type="text" class="form-control" name="action_url" value="{{ $series->action_url }}" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Status') }}</label>
                                        <select class="form-control select2" name="status" data-selected="{{ $series->status }}" required>
                                            <option value="1">{{ _lang('Active') }}</option>
                                            <option value="0">{{ _lang('In-Active') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-4">
                                    <div class="mt-2">
                                        <button type="submit" class="btn btn-primary submit">Update</button>
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
</script>
@endsection