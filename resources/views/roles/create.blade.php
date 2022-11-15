@extends('layouts.app')

@section('page_title', '| Add Role')

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class='fas fa-home text-muted'></i></a></li>
        <li class="breadcrumb-item"> <a class="text-muted" href="{{ route('roles.index') }}">Roles</a></li>
        <li class="breadcrumb-item active" aria-current="page">Create</li>
    </ol>
</nav>
<div class="row">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="row flex-grow-1">
            <div class="col-md-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h3 class="mb-3">Add New <span style="color: #0C32DC;">Role</span></h3>
                        <hr>
                        <form action="{{ route('roles.store') }}" method="POST" autocomplete="off">
                            @csrf
                            @method('POST')

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Role Name</label>
                                        <input type="text" class="form-control @error('role_name') is-invalid @enderror" name="role_name" value="{{ old('role_name') }}" required>
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
                                        <input type="checkbox" class="form-check-input" id="checkPermissionAll">
                                            <label class="form-check-label" for="checkPermissionAll">
                                                Give All Permissions
                                            </label>
                                    </div>
                                    <hr>
                                    @php $i = 1; @endphp
                                    @foreach ($permission_groups as $group)
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-check mb-3">
                                                    <input type="checkbox" class="form-check-input" id="{{ $i }}Management" value="{{ $group->group_name }}" onclick="checkPermissionByGroup('role-{{ $i }}-management-checkbox', this)">
                                                        <label class="form-check-label" for="groupPermission{{ $i }}">{{ $group->group_name }}</label>
                                                </div>
                                            </div>
                                            <div class="col-md-9 role-{{ $i }}-management-checkbox">
                                                @php
                                                    $permissions = DB::table('permissions')->where('group_name', $group->group_name)->get();
                                                    $j = 1;
                                                @endphp
                                                @foreach ($permissions as $permission)
                                                <div class="form-check mb-3">
                                                    <input name="permissions[]" type="checkbox" class="form-check-input" id="checkPermission{{ $permission->id }}" value="{{ $permission->id }}" onclick="checkSinglePermission('role-{{ $i }}-management-checkbox', '{{ $i }}Management', {{ count($permissions) }})">
                                                        <label class="form-check-label" for="checkPermission{{ $permission->id }}">
                                                            {{ $permission->name }}
                                                        </label>
                                                </div>
                                                @php  $j++; @endphp
                                                @endforeach
                                            </div>
                                        </div>
                                        <hr>
                                        @php  $i++; @endphp
                                    @endforeach
                                </div><!-- Col -->

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