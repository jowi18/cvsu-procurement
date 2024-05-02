@extends('layouts.app')

@section('content')
<style>
  /* Custom CSS to style input field as single line */
  #item {
    border: none;
    border-bottom: 1px solid #ced4da;
    border-radius: 0;
  }
</style>
<div class="border rounded bg-white shadow-sm p-4 mt-2 position-relative">
  <div class="row">
    <div class="col">
      <textarea class="form-control" id="purpose" name="purpose" placeholder="purpose"></textarea>
    </div>
  </div>
    <div class="row mt-3">
      <div class="col">
        <select class="form-control" id="item">
          <option value="" selected>Select Item</option>
          @foreach ($items as $item)
            <option value="{{ $item->item }}"  data-price="{{ $item->item_price }}" data-item="{{ $item->id }}">{{ $item->item }}</option>
          @endforeach
        </select>
          {{-- <select id="selectOption" class="form-control">
              <option value="">Select Item</option>
                @foreach ($items as $item)
                  <option value="{{ $item->item }}" data-item="{{ $item->id }}">{{ $item->item }}</option>
                @endforeach

          </select>
          <input type="text" id="item" class="form-control" placeholder="Selected option will appear here"> --}}
      </div>
        <div class="col">
          <input type="number" id="quantity" class="form-control" placeholder="Quantity" aria-label="Last name">
        </div>

        {{-- <div class="col">
          <input type="number"  id="price" class="form-control" placeholder="Price" aria-label="Last name">
        </div> --}}
       
      </div>
      <div class="mt-4">
        <button type="button" id="add-request-btn" class="btn btn-primary btn-sm px-3">Add</button>
      </div>
</div>

<div class="border rounded bg-white shadow-sm p-4 mt-4 position-relative">
    <div class="text-start mb-1">
        <button class="btn btn-danger btn-sm px-3 py-1 shadow-sm fw-bolder" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Remove" id="removeSelectedButton"><i class="fa fa-times" aria-hidden="true"></i></button>   
    </div>
    <div id="requisition-table"></div>
    <div class="mt-4">
        <button type="button" id="submit-request-btn" class="btn btn-primary btn-sm px-3">Submit</button>
    </div>
</div>

<script src="{{ asset('js/requisition.js') }} "></script>
@endsection