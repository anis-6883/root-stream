@extends('layouts.app')

@section('page_title', '| Edit Role')

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class='fas fa-home text-muted'></i></a></li>
        <li class="breadcrumb-item"> <a class="text-muted" href="{{ route('roles.index') }}">Role</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit</li>
    </ol>
</nav>
<div class="row">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="row flex-grow-1">
            <div class="col-md-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h3 class="mb-3">Edit <span style="color: #0C32DC;">Role</span></h3>
                        <hr>
                        <form action="{{ route('roles.update', $role->id) }}" method="POST" autocomplete="off">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Role Name</label>
                                        <input type="text" class="form-control @error('role_name') is-invalid @enderror" name="role_name" value="{{ $role->name }}" required>
                                        @error('role_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div><!-- Col -->

                                <div class="col-sm-12">
                                    <label for="" class="mb-3">Permissions</label>
                                    <div class="form-check mb-3">
                                        <input type="checkbox" class="form-check-input" id="checkPermissionAll" {{ App\Models\User::roleHasPermissions($role, $all_permissions) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="checkPermissionAll">
                                                Give All Permissions
                                            </label>
                                    </div>
                                    <hr>
                                    @php $i = 1; @endphp
                                    @foreach ($permission_groups as $group)
                                        <div class="row">
                                            @php
                                                $permissions = DB::table('permissions')->where('group_name', $group->group_name)->get();
                                            @endphp
                                            <div class="col-md-3">
                                                <div class="form-check mb-3">
                                                    <input type="checkbox" class="form-check-input" id="{{ $i }}Management" onclick="checkPermissionByGroup('role-{{ $i }}-management-checkbox', this)" {{ App\Models\User::roleHasPermissions($role, $permissions) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="groupPermission{{ $i }}">{{ $group->group_name }}</label>
                                                </div>
                                            </div>
                                            <div class="col-md-9 role-{{ $i }}-management-checkbox">
                                                @foreach ($permissions as $permission)
                                                <div class="form-check mb-3">
                                                    <input name="permissions[]" type="checkbox" class="form-check-input" {{ $role->hasPermissionTo($permission->name) ? 'checked' : ''  }} id="checkPermission{{ $permission->id }}" value="{{ $permission->id }}" onclick="checkSinglePermission('role-{{ $i }}-management-checkbox', '{{ $i }}Management', {{ count($permissions) }})">
                                                        <label class="form-check-label" for="checkPermission{{ $permission->id }}">
                                                            {{ $permission->name }}
                                                        </label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <hr>
                                        @php  $i++; @endphp
                                    @endforeach
                                </div><!-- Col -->
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
<script>
    $('#checkPermissionAll').on('click', function(){
        if($(this).is(':checked')){
            $('input[type=checkbox]').prop('checked', true);
        }else{
            $('input[type=checkbox]').prop('checked', false);
        }
    });

    function implementAllChecked(){

        const countPermission = {{ count($all_permissions) }};
        const countPermissionGroup = {{ count($permission_groups) }};
        const totalChecked = $('input[type=checkbox]:checked').length;

        if(totalChecked >= (countPermission + countPermissionGroup)){
            $('#checkPermissionAll').prop('checked', true);
        }else{
            $('#checkPermissionAll').prop('checked', false);
        }
        }

    function checkPermissionByGroup(className, checkThis){

        const groupIdName = $("#" + checkThis.id);
        const classCheckBox = $('.' + className + ' input[type=checkbox]');

        if(groupIdName.is(':checked')){
                classCheckBox.prop('checked', true);
            }else{
                classCheckBox.prop('checked', false);
            }

            implementAllChecked();
        }

        function checkSinglePermission(groupClassName, groupId, countTotalPermission){

        const checkedCheckbox = $('.' + groupClassName + ' input[type=checkbox]:checked');
        const groupIdCheckbox = $('#' + groupId);

        if(checkedCheckbox.length === countTotalPermission){
            groupIdCheckbox.prop('checked', true);
        }else{
            groupIdCheckbox.prop('checked', false);
        }

        implementAllChecked();
        }
</script>
@endsection