@extends('layouts.app')

@section('page_title', '| Add User')

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class='fas fa-home text-muted'></i></a></li>
        <li class="breadcrumb-item"> <a class="text-muted" href="{{ route('users.index') }}">Users</a></li>
        <li class="breadcrumb-item active" aria-current="page">Create</li>
    </ol>
</nav>
<div class="row">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="row flex-grow-1">
            <div class="col-md-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h3 class="mb-3">Add New <span style="color: #0C32DC;">User</span></h3>
                        <hr>
                        <form action="{{ route('users.store') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @method('POST')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Name') }}</label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Email') }}</label>
                                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Password') }}</label>
                                        <input type="password" class="form-control" name="password" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Confirm Password') }}</label>
                                        <input type="password" class="form-control" name="password_confirmation" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('App') }}</label>
                                        <select class="form-control select2 app_id" name="app_id" required>
                                            <option value="">{{ _lang('Select One') }}</option>
                                            @foreach(App\Models\AppModel::where('status', 1)->get() AS $app)
                                            <option value="{{ $app->id }}">{{ $app->app_name }} - {{ $app->app_unique_id }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Subscription') }}</label>
                                        <select class="form-control select2 subscription_id" name="subscription_id" required>
                                            <option value="">{{ _lang('Select One') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Image') }}</label>
                                        <input type="file" class="form-control dropify" name="image" data-allowed-file-extensions="png jpg jpeg PNG JPG JPEG">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">{{ _lang('Status') }}</label>
                                        <select class="form-control select2" name="status" required>
                                            <option value="1">{{ _lang('Active') }}</option>
                                            <option value="0">{{ _lang('In-Active') }}</option>
                                        </select>
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
    
    $('select.app_id').on('change', function(){
        $.ajax({
            type: "GET",
            contentType: false,
            cache: false,
            processData: false,
            url: "{{ url('subscriptions/get_subscriptions') }}/" + $(this).val(),
            success: function (data) {
                $('select.subscription_id').html(data).trigger('change');
            }
        }).done(function() {
            console.log("success");
        });
    });
</script>
@endsection