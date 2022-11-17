@extends('layouts.app')

@section('page_title', '| Admin Profile')

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class='fas fa-home text-muted'></i></a></li>
        <li class="breadcrumb-item active" aria-current="page">Profile</li>
    </ol>
</nav>
<div class="row">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="row flex-grow-1">
            <div class="col-md-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td colspan="2" class="text-center">
                                        <img src="{{ asset($profile->image) }}" class="img-lg img-thumbnail">
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ _lang('Name') }}</td>
                                    <td>{{ $profile->first_name . ' ' . $profile->last_name }}</td>
                                </tr>
                                <tr>
                                    <td>{{ _lang('Email') }}</td>
                                    <td>{{ $profile->email }}</td>
                                </tr>
                                <tr>
                                    <td>{{ _lang('Status') }}</td>
                                    <td>
                                        @if($profile->status)
                                        <span class="badge badge-success">{{ _lang('Active') }}</span>
                                        @else
                                        <span class="badge badge-danger">{{ _lang('In-Active') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- row -->
@endsection