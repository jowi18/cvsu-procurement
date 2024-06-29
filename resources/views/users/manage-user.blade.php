@extends('layouts.app')

@section('content')

    <div class="border rounded bg-white shadow-sm p-4 mt-2 position-relative">
        <button type="button" class="btn btn-sm btn-outline-info" id="add_department">
            ADD DEPARTMENT
        </button>
        <div class="row mt-3">
            <div class="col">
                <form id="add_user_form" enctype="multipart/form-data">
                    @csrf
                    <select class="form-control" id="department" name="department">
                        <option value="" selected>Select Department</option>
                        @foreach ($departments as $item)
                            <option value="{{ $item->id }}">{{ $item->department }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col">
                    <input type="text" id="firstname" name="firstname" class="form-control" placeholder="First Name" aria-label="Procurement Project">
                </div>

                <div class="col">
                    <input type="text" id="lastname" name="lastname" class="form-control" placeholder="Last Name" aria-label="Procurement Project">
                </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <input type="email" id="email" name="email" class="form-control" placeholder="Email" aria-label="Procurement Project">
            </div>
            <div class="col">
                <select class="form-control" id="position" name="position">
                    <option value="" selected>Select Position</option>
                    @foreach ($positions as $item)
                        <option value="{{ $item->id }}">{{ $item->position }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <input type="file" id="image_signature" name="image_signature" class="form-control" aria-label="Procurement Project">
            </div>
            {{-- 
            <div class="col">
                <input type="number" id="price" class="form-control" placeholder="Price" aria-label="Last name">
            </div>
            --}}
        </div>
    </form>
    <div class="mt-4">
        <button type="button" id="submit-user-btn" class="btn btn-primary btn-sm px-3">Add</button>
    </div>

</div>


<div class="border rounded bg-white shadow-sm p-4 mt-4 position-relative">
    <div id="manage-user-table"></div>
</div>

@include('layouts.modals.manage_user_modals')
<script src="{{ asset('js/manage_user.js') }} "></script>
@endsection
