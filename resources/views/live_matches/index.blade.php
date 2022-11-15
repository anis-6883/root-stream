@extends('layouts.app')

@section('page_title', '| Live Match List')

@section('content')
<nav class="page-breadcrumb">
   <ol class="breadcrumb">
       <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class='fas fa-home text-muted'></i></a></li>
       <li class="breadcrumb-item active" aria-current="page">Live Matches</li>
   </ol>
</nav>

<div class="row">
   <div class="col-12 col-xl-12 stretch-card">
      <div class="card">
         <div class="card-body">
            <h3 class="mb-3">Live Match <span style="color: #0C32DC;">List</span></h3>
            <div class="d-flex justify-content-end">
               <a class="btn btn-outline-primary btn-sm" href="{{ route("live_matches.create") }}">
                  <i class="fas fa-plus mr-1" style="font-size: 13px"></i> Add Live Match
               </a>
            </div>
            <hr>

            <div class="table-responsive">
                  <table id="data-table" class="table table-bordered table-striped" style="width:100%">
                     <thead>
                         <tr>
                              <th style=" white-space: nowrap;">Team One</th>
                              <th style=" white-space: nowrap;">Team Two</th>
                              <th style=" white-space: nowrap; width: 15%;">Title & Time</th>
                              <th style=" white-space: nowrap; width: 35%;">Apps</th>
                              <th style=" white-space: nowrap; width: 5%;" class="text-center">Action</th>
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
        ajax: _url + "/live_matches",
        "columns" : [

        { data : "team_one", name : "team_one", className: 'details-control', responsivePriority: 1 },
		{ data : "team_two", name : "team_two", className : "team_two" },
		{ data : "match_time", name : "match_time", className : "match_time text-center" },
		{ data : "apps", name : "apps", className : "apps" },
		{ data : "action", name : "action", orderable : false, searchable : false, className : "text-center" }

        ],
        responsive: true,
        "bStateSave": true,
        "bAutoWidth":false, 
        "ordering": false
    });
</script>
@endsection