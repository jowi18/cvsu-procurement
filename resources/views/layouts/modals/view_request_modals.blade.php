<div class="modal fade" id="ViewRequestModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Request Details</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               {{-- <div id="view-request-table"></div> --}}
               <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">ITEM</th>
                    <th scope="col">QUANTITY</th>
                    <th scope="col">AMOUNT</th>
                    <th scope="col">TOTAL AMOUNT</th>
                    <th scope="col">ACTION</th>
                  </tr>
                </thead>
                <tbody id="table_request">
                  
                
                </tbody>
              </table>
                <div class="text-center">
                  <button type="button" class="btn btn-warning btn-sm px-3" id="add-item-modal" ><i class="fa fa-plus"></i></button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm px-3" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="AddRequestModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Add Item</h1>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <form id="add_request_form">
                <div class="row">
                  <div class="col">
                    <select name="item" class="form-control" id="item">
                      <option value="" selected>Select Item</option>
                      @foreach ($items as $item)
                        <option value="{{ $item->id }}">{{ $item->item }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col">
                    <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Quantity">
                  </div>
                </div>
              </form>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-warning btn-sm px-3" id="submit-item-btn">Submit</button>
              <button type="button" class="btn btn-secondary btn-sm px-3" data-dismiss="modal">Close</button>
          </div>
      </div>
  </div>
</div>
