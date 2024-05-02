<div class="modal fade" id="AddPmppItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">ADD ITEM</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="border rounded bg-white shadow-sm p-4 mt-2 position-relative">
                    <form id="PmppAddItemForm">
                        <div class="row">
                            <div class="col">
                                <select id="item_category" name="item_category" class="form-control">
                                    <option value="" selected>Select Category</option>
                                    @foreach ($category as $value)
                                        <option value="{{ $value->id }}">{{ $value->category }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col">
                                <select id="item_name" name="item_name" class="form-control">
                                    <option value="" selected>Select Item</option>
                                    @foreach ($item as $value)
                                        <option value="{{ $value->id }}">{{ $value->item }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col">
                                <select id="unit_of_measurement" name="unit_of_measurement" class="form-control">
                                    <option value="" selected>Select Unit Of Measurement</option>
                                    @foreach ($uom as $value)
                                        <option value="{{ $value->id }}">{{ $value->uom }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col">
                                <input type="number" id="item_quantity" name="item_quantity" class="form-control" placeholder="Item Quantity" aria-label="Last name">
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col">
                                <input type="text" id="item_description" class="form-control" name="item_description" placeholder="Item Description" aria-label="Item Category">
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col">
                                <button type="button" id="submit-item-btn" class="btn btn-primary btn-sm px-3">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
               <div id="view-pmpp-table" style="width: 100%"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm px-3" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="DownloadPmppModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Select Year</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <select id="year" name="year" class="form-control">
                            <option value="" selected>Select Year</option>
                            @foreach ($year as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                            
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm px-3" id="download-submit-btn" data-dismiss="modal">Submit</button>
                <button type="button" class="btn btn-secondary btn-sm px-3" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
