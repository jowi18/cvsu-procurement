<div class="modal fade" id="AddCategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Request Details</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add_category_form">
                    <input type="text" class="form-control" placeholder="Item Category" id="category" name="category" >
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning btn-sm px-3" id="submit-category-btn">Add</button>
                <button type="button" class="btn btn-secondary btn-sm px-3" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="UpdateItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Update Item</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="update_item_form">
                    @csrf
                    <div class="row">
                    <div class="col">
                        <select class="form-control" id="update_category" name="update_category">
                            <option value="" selected>Select Category</option>
                            @foreach ($category as $value)
                                <option value="{{ $value->id }}">{{ $value->category }}</option>
                            @endforeach
                        </select>
                    </div>
            
                    <div class="col">
                        <input type="text" id="update_item" name="update_item" class="form-control" placeholder="Item Name" aria-label="Procurement Project">
                    </div>
                   
                    
                    <div class="col">
                        <input type="number" id="update_item_price" name="update_item_price" class="form-control" placeholder="Item Price" aria-label="Procurement Project">
                    </div>
                    <div class="col">
                        <select class="form-control" id="update_unit_of_measurement" name="update_unit_of_measurement">
                            <option value="" selected>Select Unit Of Measurement</option>
                            @foreach ($uom as $value)
                                <option value="{{ $value->id }}">{{ $value->uom }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning btn-sm px-3" id="update-item-btn">Update</button>
                <button type="button" class="btn btn-secondary btn-sm px-3" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

