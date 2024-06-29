<div class="modal fade" id="SelectApproverModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                @if(auth()->user()->position_dtls->user_level > 2)
                    <h1 class="modal-title fs-3" id="exampleModalLabel">Select Approver</h1>
                @else
                    <h3 class="modal-title fs-3" id="exampleModalLabel">Are you sure you want to submit</h3>
                @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    @if(auth()->user()->position_dtls->user_level > 2)
                        <select class="form-control" id="approver">
                            <option value="" selected>Select Approver</option>
                                @foreach ($approver_list as $user)
                                <option value="{{ $user->id }}">{{ $user->firstname.' '.$user->lastname }}</option>
                                @endforeach
                        </select>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm px-3" id="submit-request-btn">Submit</button>
                <button type="button" class="btn btn-secondary btn-sm px-3" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="AddDepartmentItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-3" id="exampleModalLabel">Add Items</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="department_item_form" method="post">
                    <div class="row">
                    <div class="col">
                        <input type="text" id="item-val" name="item" class="form-control" placeholder="Item Description" aria-label="Last name">
                    </div>
                    <div class="col">
                        <select class="form-control" id="category-val" name="category">
                            <option value="" selected>Select Category</option>
                            @foreach ($category as $item)
                            <option value="{{ $item->id }}">{{ $item->category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <select class="form-control" id="uom" name="unit_of_measurement">
                        <option value="" selected>Select Uom</option>
                        @foreach ($uom as $item)
                            <option value="{{ $item->id }}">{{ $item->uom }}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <input type="number" id="price" name="item_price" class="form-control" placeholder="Price" aria-label="Last name">
                    </div>
                    </div>
              </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm px-3" id="submit-item-btn">Submit</button>
                <button type="button" class="btn btn-secondary btn-sm px-3" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>






