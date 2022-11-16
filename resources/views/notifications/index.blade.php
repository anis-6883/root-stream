@extends('layouts.app')

@section('page_title', '| Notification List')

@section('content')
<nav class="page-breadcrumb">
   <ol class="breadcrumb">
       <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class='fas fa-home text-muted'></i></a></li>
       <li class="breadcrumb-item active" aria-current="page">Notifications</li>
   </ol>
</nav>

<div class="row">
   <div class="col-12 col-xl-12 stretch-card">
      <div class="card">
         <div class="card-body">
            <h3 class="mb-3">Notification <span style="color: #0C32DC;">List</span></h3>
            <div class="d-flex justify-content-end">
               <a class="btn btn-outline-danger btn-sm me-2 btn-remove" href="{{ url('notifications/deleteall') }}">
                  <i class="fas fa-minus mr-1" style="font-size: 13px"></i> Delete All
               </a>
               <a class="btn btn-outline-primary btn-sm" href="{{ route('notifications.create') }}">
                  <i class="fas fa-plus mr-1" style="font-size: 13px"></i> Add Notification
               </a>
            </div>
            <hr>

            <div class="table-responsive">
                  <table id="data-table" class="table table-bordered table-striped" style="width:100%">
                     <thead>
                         <tr>
                            <th style=" white-space: nowrap; width: 5%;">
                                <div class="form-check">
                                    <label class="form-check-label d-flex justify-content-center align-items-center">
                                        <input class="form-check-input" type="checkbox" name="main_checkbox">
                                        <span class="form-check-sign b h4"></span>
                                    </label>
                                </div>
                                <button class="btn btn-xs btn-danger" id="delete-by-checkbox-btn" disabled>Delete</button>
                            </th>
                            <th style=" white-space: nowrap; width: 30%;">{{ _lang('Title') }}</th>
                            <th style=" white-space: nowrap; width: 30%;">{{ _lang('Body') }}</th>
                            <th style=" white-space: nowrap;">{{ _lang('Created At') }}</th>
                            <th class="text-center">{{ _lang('Action') }}</th>
                         </tr>
                     </thead>
                 </table>
            </div>
            
         </div>
      </div>
   </div>
</div>
<!-- row -->
@endsection

@section('js-script')
<script>
   var _url = "{{ url('/') }}";

   $('#data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: _url + "/notifications",
        "columns" : [

            { data : "checkbox", name : "checkbox", orderable : false, searchable : false },
            { data : "title", name : "title", className: 'details-control', responsivePriority: 1, className : "text-center" },
            { data : "message", name : "message", className : "message", className : "text-center" },
            { data : "created_at", name : "created_at", className : "created_at", className : "text-center" },
            { data : "action", name : "action", orderable : false, searchable : false, className : "text-center" }

        ],
        responsive: true,
        "bStateSave": true,
        "bAutoWidth":false, 
        "ordering": false,
        "drawCallback": function() {
            document.querySelector('input[name="main_checkbox"]').checked = false;
            document.querySelector('#delete-by-checkbox-btn').disabled = true;
            document.querySelector('#delete-by-checkbox-btn').innerText = "Delete";
        },
    });

    // Check All Notification Checkbox
    $(document).on('click', 'input[name="main_checkbox"]', function()
    {
        if(this.checked){
            $('input[name="notify_checkbox"]').each(function(){
                this.checked = true;
            });
        }else{
            $('input[name="notify_checkbox"]').each(function(){
                this.checked = false;
            });
        }
        toggleCheckboxInfo();
    });

    $(document).on('change', 'input[name="notify_checkbox"]', function()
    {
        if($('input[name="notify_checkbox"]').length == $('input[name="notify_checkbox"]:checked').length){
            $('input[name="main_checkbox"]').prop('checked', true);
        }else{
            $('input[name="main_checkbox"]').prop('checked', false);
        }
        toggleCheckboxInfo();
    })

    function toggleCheckboxInfo(){
        if($('input[name="notify_checkbox"]:checked').length > 0){
            $("#delete-by-checkbox-btn").text("Delete (" + $('input[name="notify_checkbox"]:checked').length + ")").prop("disabled", false);
        }else{
            $("#delete-by-checkbox-btn").text("Delete").prop("disabled", true);
        }
    }

    // delete selected notification
    $(document).on("click", "#delete-by-checkbox-btn", function (e) {
        e.preventDefault();
        Swal.fire({
            title: `Do you want to delete selected notification(${$('input[name="notify_checkbox"]:checked').length})?`,
            icon: "warning",
			iconHtml: '🛎️',
            showCancelButton: true,
            confirmButtonColor: "#1bcfb4",
            cancelButtonColor: "#fe7c96",
            confirmButtonText: "Yes, Delete!",
        }).then((result) => {
            if (result.value) {
                
				let checkedNotifications = [];
                $('input[name="notify_checkbox"]:checked').each(function(){
                    checkedNotifications.push($(this).data('id'));
                });

				$.ajax({
					method: "POST",
					url: "{{ route('delete.selected.notification') }}",
					data: {
						notification_ids: checkedNotifications,
						_token: "{{ csrf_token() }}"
					},
                    beforeSend: function () {
                        $("#preloader").css("display", "block");
                    },
					success: function(data){
                        $("#preloader").css("display", "none");
						if(data.result == "success"){
                            $("#data-table").DataTable().ajax.reload(null, false);
							toast("success", data.message);
						}
					}
				})
            }
        });
    });
</script>
@endsection