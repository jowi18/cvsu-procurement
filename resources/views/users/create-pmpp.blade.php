@extends('layouts.app')

@section('content')


        <div class="border rounded bg-white shadow-sm p-4 mt-2 position-relative">
            <div class="row">
                <div class="col text-right" >
                    <button type="button" id="download-btn" class="btn btn-warning btn-sm px-3">DOWNLOAD PMPP</button>
                </div>
            </div>
    @if(Auth::user()->position_dtls->user_level == 2)
            <div class="row mt-3">
                <div class="col">
                    <form id="pmpp_form">
                        @csrf
                        <select class="form-control" id="year-plan" name="year">
                            <option value="" selected>Select Year Plan</option>
                            {{-- @foreach ($department as $value)
                                <option value="{{ $value->id }}">{{ $value->department }}</option>
                            @endforeach --}}
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                            <option value="2027">2027</option>
                            <option value="2028">2028</option>
                            <option value="2029">2029</option>
                            <option value="2030">2030</option>
                            <option value="2031">2031</option>
                            <option value="2032">2032</option>
                            <option value="2033">2033</option>
                            <option value="2034">2034</option>
                            <option value="2035">2035</option>
                            <option value="2036">2036</option>
                            <option value="2037">2037</option>
                        </select>
                    </div>
                    <div class="col">
                        <input type="text" id="project" name="project" class="form-control" placeholder="Procurement Project" aria-label="Procurement Project">
                    </div>
            </div>
            {{-- <div class="row mt-2">
                <div class="col">
                    <select class="form-control" id="fund" name="fund">
                        <option value="" selected>Fund Source</option>
                        <option value="1">Main</option>
                    </select>
                </div>
                <div class="col">
                    <input type="number" id="budget" name="budget" class="form-control" placeholder="Estimated Budget" aria-label="Estimated Budget">
                </div>
            </div> --}}
            <div class="row mt-2">
                <div class="col">
                    <select class="form-control" id="main-category" name="main_category">
                        <option value="" selected>Main Category</option>
                        @foreach ($pmpp_category as $items)
                            @if($items->category_type == 1)
                                <option value="{{ $items->id }}">{{ strtoupper($items->category) }}</option>
                            @endif
                        @endforeach 
                    </select>
                </div>

                <div class="col">
                    <select class="form-control" id="sub-category-a" name="sub_category_a">
                        <option value="" selected>Sub Category A</option>
                        @foreach ($pmpp_category as $items)
                        @if($items->category_type == 2)
                            <option value="{{ $items->id }}">{{ strtoupper($items->category) }}</option>
                        @endif
                    @endforeach 
                    </select>
                </div>

                <div class="col">
                    <select class="form-control" id="sub-category-b" name="sub_category_b">
                        <option value="" selected>Sub Category B</option>
                        @foreach ($pmpp_category as $items)
                        @if($items->category_type == 3)
                            <option value="{{ $items->id }}">{{ strtoupper($items->category) }}</option>
                        @endif
                    @endforeach 
                    </select>
                </div>

                <div class="col">
                    <select class="form-control" id="sub-category-c" name="sub_category_c">
                        <option value="" selected>Sub Category C</option>
                        @foreach ($pmpp_category as $items)
                        @if($items->category_type == 4)
                            <option value="{{ $items->id }}">{{ strtoupper($items->category) }}</option>
                        @endif
                    @endforeach 
                    </select>
                </div>
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
        @endif
    </div>


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
