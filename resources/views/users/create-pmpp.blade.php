@extends('layouts.app')

@section('content')

@if(Auth::user()->position_dtls->user_level == 2)
        <div class="border rounded bg-white shadow-sm p-4 mt-2 position-relative">
            <div class="row">
                <div class="col text-right" >
                    <button type="button" id="download-btn" class="btn btn-warning btn-sm px-3">DOWNLOAD PMPP</button>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <form id="pmpp_form">
                        @csrf
                        <select class="form-control" id="department" name="department">
                            <option value="" selected>Select Department</option>
                            @foreach ($department as $value)
                                <option value="{{ $value->id }}">{{ $value->department }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col">
                        <input type="text" id="project" name="project" class="form-control" placeholder="Procurement Project" aria-label="Procurement Project">
                    </div>
            </div>
            <div class="row mt-2">
                <div class="col">
                    <select class="form-control" id="fund" name="fund">
                        <option value="" selected>Fund Source</option>
                        <option value="1">Main</option>
                    </select>
                </div>
                <div class="col">
                    <input type="number" id="budget" name="budget" class="form-control" placeholder="Estimated Budget" aria-label="Estimated Budget">
                </div>
                {{-- 
                <div class="col">
                    <input type="number" id="price" class="form-control" placeholder="Price" aria-label="Last name">
                </div>
                --}}
            </div>
            <div class="row mt-2">
                <div class="col">
                    <textarea id="remark" name="remark" class="form-control" placeholder="Remarks (Brief Desccription of the Project)"></textarea>
                </div>
            </div>
        </form>
        <div class="mt-4">
            <button type="button" id="submit-pmpp-btn" class="btn btn-primary btn-sm px-3">Submit</button>
        </div>
    </div>
@endif

<div class="border rounded bg-white shadow-sm p-4 mt-4">
    <div class="d-flex flex-row-reverse text-right mb-2">
        <div class="col-md-3 text-right">
            <input type="text" class="form-control" id="search" name="search" oninput="searchPmpp(value)" placeholder="Search">
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
    <div id="pmpp-table" style="width: 100%"></div>
</div>

@include('layouts.modals.pmpp_modals')
<script src="{{ asset('js/pmpp.js') }} "></script>
@endsection
