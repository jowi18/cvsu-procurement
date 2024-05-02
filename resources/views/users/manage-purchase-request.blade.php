@extends('layouts.app')

@section('content')

<div class="border rounded bg-white shadow-sm p-4 mt-4">
    <div class="d-flex flex-row-reverse text-right mb-2">
        <div class="col-md-3 text-right">
            <input type="text" class="form-control" id="search" name="search" oninput="searchPr(value)" placeholder="Search">
        </div>
        <div class="col-md-3 mb-2">
            <select class="form-control" id="filter-status" aria-label="Default select example">
              <option value="" selected>Filter Status</option>
              <option value="Pending">Pending</option>
              <option value="Approved">Approved</option>
              <option value="Rejected">Rejected</option>
            </select>          
          </div>
        
    </div>
    <div class="row">
        <div id="manage-request-table" style="width: 100%"></div>
    </div>
</div>

@include('layouts.modals.view_request_modals')
<script src="{{ asset('js/manage_request.js') }} "></script>
@endsection