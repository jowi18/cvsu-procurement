@extends('layouts.app')

@section('content')

<div class="border rounded bg-white shadow-sm p-4 mt-2 position-relative">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h4 class="mb-0">Add Item</h4>
        <button type="button" class="btn btn-sm btn-outline-info" id="add_category">
            ADD CATEGORY
        </button>
    </div>
    
    <form id="add_item_form">
        @csrf
        <div class="row">
        <div class="col">
            <select class="form-control" id="category" name="category">
                <option value="" selected>Select Category</option>
                @foreach ($category as $value)
                    <option value="{{ $value->id }}">{{ $value->category }}</option>
                @endforeach
            </select>
        </div>

        <div class="col">
            <input type="text" id="item" name="item" class="form-control" placeholder="Item Name" aria-label="Procurement Project">
        </div>
       
        
        <div class="col">
            <input type="number" id="item_price" name="item_price" class="form-control" placeholder="Item Price" aria-label="Procurement Project">
        </div>
        <div class="col">
            <select class="form-control" id="unit_of_measurement" name="unit_of_measurement">
                <option value="" selected>Select Unit Of Measurement</option>
                @foreach ($uom as $value)
                    <option value="{{ $value->id }}">{{ $value->uom }}</option>
                @endforeach
            </select>
        </div>
    </div>
    
    </form>
      <div class="mt-4">
        <button type="button" id="submit-item-btn" class="btn btn-primary btn-sm px-3">Submit</button>
      </div>
</div>


<div class="border rounded bg-white shadow-sm p-4 mt-4 position-relative">
    <div id="manage-item-table"></div>
</div>


@include('layouts.modals.manage_item_modals')
<script src="{{ asset('js/manage_item.js') }} "></script>
@endsection