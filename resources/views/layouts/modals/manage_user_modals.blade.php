<div class="modal fade" id="UpdateUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Profile</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="update_user_form">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <label for="update_department">Department</label>
                            <select class="form-control" id="update_department" name="update_department">
                                <option value="" selected>Select Department</option>
                                @foreach ($departments as $item)
                                    <option value="{{ $item->id }}">{{ $item->department }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col">
                            <label for="update_firstname">First Name</label>
                            <input type="text" id="update_firstname" name="update_firstname" class="form-control" placeholder="First Name" aria-label="Procurement Project">
                        </div>
                        <div class="col">
                            <label for="update_lastname">Last Name</label>
                            <input type="text" id="update_lastname" name="update_lastname" class="form-control" placeholder="Last Name" aria-label="Procurement Project">
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col">
                            <label for="update_email">Email</label>
                            <input type="email" id="update_email" name="update_email" class="form-control" placeholder="Email" aria-label="Procurement Project">
                        </div>
                        <div class="col">
                            <label for="update_position">Position</label>
                            <select class="form-control" id="update_position" name="update_position">
                                <option value="" selected>Select Position</option>
                                @foreach ($positions as $item)
                                    <option value="{{ $item->id }}">{{ $item->position }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- 
                    <div class="row mt-2">
                        <div class="col">
                            <input type="number" id="price" class="form-control" placeholder="Price" aria-label="Last name">
                        </div>
                    </div>
                    --}}
                </form>
                
            </div>
            <div class="modal-footer">
                <button type="button" id="update-user-btn" class="btn btn-primary btn-sm px-3">Update</button>
                <button type="button" class="btn btn-secondary btn-sm px-3" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
