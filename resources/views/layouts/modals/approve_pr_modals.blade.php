<div class="modal fade" id="PrAttachmentrModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-3" id="exampleModalLabel">Attachments</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="attachment_drop">
              
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-primary btn-sm px-3" id="submit-request-btn">Submit</button> --}}
                <button type="button" class="btn btn-secondary btn-sm px-3" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="AddPrAttachmentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-3" id="exampleModalLabel">Add Attachments</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <form id="add_attachment_form">
                            <input type="file" class="form-control" id="pr-attachment" name="attachment" style="width: 100%">
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm px-3" id="submit-attachment-btn">Submit</button>
                <button type="button" class="btn btn-secondary btn-sm px-3" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>






