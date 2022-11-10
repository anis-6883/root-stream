@extends('layouts.app')

@section('page_title', '| Edit Sports Type')

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class='fas fa-home text-muted'></i></a></li>
        <li class="breadcrumb-item"> <a class="text-muted" href="{{ route('sports_types.index') }}">Sports Type</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit</li>
    </ol>
</nav>
<div class="row">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="row flex-grow-1">
            <div class="col-md-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h3 class="mb-3">Edit <span style="color: #0C32DC;">Sports Type</span></h3>
                        <hr>
                        <form action="{{ route('sports_types.update', $sports_type->id) }}" enctype="multipart/form-data" method="POST" autocomplete="off">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Sports Name</label>
                                        <input type="text" class="form-control @error('sports_name') is-invalid @enderror" name="sports_name" value="{{ $sports_type->sports_name }}" required>
                                        @error('sports_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Sports SKQ</label>
                                        <input type="text" class="form-control" name="sports_skq" value="{{ $sports_type->sports_skq }}" data-random="{{ Str::random(8) }}" required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select class="form-control select2" name="status" required data-selected="{{ $sports_type->status }}">
                                            <option value="1">Active</option>
                                            <option value="0">In-Active</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <button type="reset" class="btn btn-danger btn-sm">Reset</button>
                                        <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                    </div>
                                </div>
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
    $('[name=sports_name]').on('keyup', function() {
        $('[name=sports_skq]').val($(this).val().replace(/\s/g, '') + '_' + $('[name=sports_skq]').data('random'))
    });
</script>
@endsection

