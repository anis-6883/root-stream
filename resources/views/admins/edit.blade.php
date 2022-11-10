@extends('layouts.app')

@section('page_title', '| Edit Admin')

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class='fas fa-home text-muted'></i></a></li>
        <li class="breadcrumb-item"> <a class="text-muted" href="{{ route('admins.index') }}">Admin</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit</li>
    </ol>
</nav>
<div class="row">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="row flex-grow-1">
            <div class="col-md-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h3 class="mb-3">Edit <span style="color: #0C32DC;">Admin</span></h3>
                        <hr>
                        <form action="{{ route('admins.update', $admin->id) }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Role</label>
                                        <select class="form-select select2" name="role_id[]" required data-selected="{{ $admin->roles->pluck('id') }}" multiple>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">First Name</label>
                                        <input type="text" class="form-control" name="first_name" value="{{ $admin->first_name }}" required>
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" class="form-control" name="last_name" value="{{ $admin->last_name }}" required>
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $admin->email }}" required>
                                        @error('hotel_email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select class="form-select select2" name="status" required data-selected="{{ $admin->status }}">
                                            <option value="1">Active</option>
                                            <option value="0">In-Active</option>
                                        </select>
                                    </div>
                                </div><!-- Col -->
                            </div><!-- Row -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Image</label>
                                        <input type="file" class="form-control dropify" name="image" data-allowed-file-extensions="png jpg jpeg PNG JPG JPEG" data-default-file="{{ asset($admin->image) }}">
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-12 mb-2">
                                    <div class="mt-2 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary submit">Update</button>
                                    </div>
                                </div><!-- Col -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- row -->
@endsection