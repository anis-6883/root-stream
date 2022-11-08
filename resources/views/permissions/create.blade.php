@extends('layouts.app')

@section('page_title', '| Add Permission')

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class='fas fa-home text-muted'></i></a></li>
        <li class="breadcrumb-item"> <a class="text-muted" href="{{ route('permissions.index') }}">Permission</a></li>
        <li class="breadcrumb-item active" aria-current="page">Create</li>
    </ol>
</nav>
<div class="row">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="row flex-grow-1">
            <div class="col-md-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h3 class="mb-3">Add New <span style="color: #0C32DC;">Permission</span></h3>
                        <hr>
                        <form action="{{ route('permissions.store') }}" method="POST" autocomplete="off">
                            @csrf
                            @method('POST')

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Group Name</label>
                                        <input type="text" class="form-control" name="group_name" value="{{ old('group_name') }}" required>
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Permission Name</label>
                                        <input type="text" class="form-control @error('permission_name') is-invalid @enderror" name="permission_name" value="{{ old('permission_name') }}" required>
                                        @error('permission_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-12 mb-4">
                                    <div class="mt-2 d-flex justify-content-start">
                                        <button type="submit" class="btn btn-primary submit">Submit <i class="fas fa-angle-double-right"></i></button>
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