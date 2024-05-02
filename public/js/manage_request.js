$(document).ready(function(){
    manageRequestTable(); 
    getRequestList();
    //data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View Request"
  
});

let item_qty = 0;

const manageRequestTable = () =>{
    purchaseRequest = new Tabulator("#manage-request-table", {
        dataTree:true,
        dataTreeSelectPropagate:true,
        layout:"fitColumns",
        maxHeight: "1000px",
        scrollToColumnPosition: "center",
        pagination:"local",
        paginationSize:10,
        placeholder:"No Data Set",
        paginationSizeSelector:[10,50,100],
        selectable:1,
        rowFormatter:function(dom){
            var selectedRow = dom.getData();
            if(true)
            {
                dom.getElement().classList.add("table-primary");
            }
            else if(selectedRow.safety_stock == selectedRow.qty)
            {
                dom.getElement().classList.add("table-warning");
            }
        },
        columns:[
            {title:"NO", field:"no", hozAlign:"center",width:75, vertAlign:"middle"},
            {title:"PR CODE", field:"pr_code", hozAlign:"left", vertAlign:"middle"},
            {title:"CREATED BY", field:"created_by", hozAlign:"left", vertAlign:"middle"},
            {title:"DEPARTMENT", field:"department", hozAlign:"left", vertAlign:"middle"},
            {title:"STATUS", field:"status_badge", hozAlign:"left", formatter:"html", vertAlign:"middle"},
            {title:"STATUS TEXT", field:"status", hozAlign:"left", vertAlign:"middle", visible: false},
            {title:"ACTION", field:"action", hozAlign:"left", formatter:"html", vertAlign:"middle"},
        
        ]
    });
}

function searchPr(value){
    purchaseRequest.setFilter([
        [
            {field:'NO', field: 'no'},
            {field:"pr_code", type:"like", value:value.trim()},
            {field:"created_by", type:"like", value:value.trim()},
            {field:"department", type:"like", value:value.trim()},
            {field:"status", type:"like", value:value.trim()},         
        ]
    ]);
}

$('#filter-status').change(function(){
    var value = $('#filter-status').val();
    purchaseRequest.setFilter([
        [
            {field:"status", type:"like", value:value.trim()},
        ]
    ]);
});

const viewRequestTable = (setData) =>{
   new Tabulator("#view-request-table", {
        data:setData,
        dataTree:true,
        dataTreeSelectPropagate:true,
        layout:"fitColumns",
        maxHeight: "1000px",
        scrollToColumnPosition: "center",
        placeholder:"No Data Set",
        pagination:"local",
        paginationSize:10,
        paginationSizeSelector:[10,50,100],
        selectable:1,
        rowFormatter:function(dom){
            var selectedRow = dom.getData();
            if(true)
            {
                dom.getElement().classList.add("table-primary");
            }else if(selectedRow.safety_stock == selectedRow.qty)
            {
                dom.getElement().classList.add("table-warning");
            }
        },
        columns:[
            {title:"NO", field:"no", hozAlign:"center",width:75, vertAlign:"middle"},
            {title:"ITEM", field:"item", hozAlign:"left", vertAlign:"middle"},
            {title:"QUANTITY", field:"quantity", hozAlign:"left", vertAlign:"middle"},
            {title:"AMOUNT", field:"price", hozAlign:"left", vertAlign:"middle"},
            {title:"TOTAL AMOUNT", field:"total", hozAlign:"left", vertAlign:"middle"},
            {title:"ACTION", field:"action", hozAlign:"left", formatter:"html", vertAlign:"middle"},
        ],
        
    });
}

getRequestList = () => {
    $.ajax({    
        url: '/get-request-list',
        method: 'GET',
        dataType: 'json',
        success: function (response) { 
            console.log(response);
            purchaseRequest.setData(response);
        },
    });
};

const loadRequestTable = (response) =>{
    const html_content = $('#table_request'); 
    let htmlContent = '';
    for (let i = 0; i < response.purchase_request.length; i++) {
        const item = response.purchase_request[i];
        console.log(response.items);
        htmlContent += `
            <tr>
                <th scope="row">${item.no}</th>
                <td>
                    <select class="form-control" id="item">
                        <option value="${item.item_id}">${item.item}</option>
                        ${generateOptions(response.items, item.item_id)}
                    </select>
                </td>
                <td>
                    <input type="number" class="form-control" value="${item.quantity}" id="quantity">
                </td>
                <td>
                    <input disabled  type="number" class="form-control" value="${item.price}" id="price">
                </td>
                <td>
                    <input disabled type="number" class="form-control" value="${item.price * item.quantity}" id="total_amount">
                </td>
                <td>
                    <div class="btn-group" id="action" role="group" aria-label="Basic mixed styles example">
                    ${item.action}
                    </div>
                </td>
            </tr>`;
        }
    html_content.html(htmlContent);
}

$(document).on('click', '#edit-btn', function () {
    let id = $(this).data('itemId');
    $('#ViewRequestModal').modal('show');

    $('#ViewRequestModal').attr('data-id', id);
    let btn = $(this);
    $.ajax({    
        url: '/view-purchase-request/' + id,
        method: 'GET',
        dataType: 'json',
        beforeSend: function() {
            $(btn).html("Loading")
            $(btn).prop("disabled", true)
        },
        success: function (response) { 
            console.log(response.purchase_request);
            loadRequestTable(response);
            $(btn).html(`<i class="fa fa-edit"></i>`)
            $(btn).prop("disabled", false)
        },
    });
});

function generateOptions(items, selectedItem) {
    let options = '';
    items.forEach(item => {
        options += `<option value="${item.id}" ${item.id === selectedItem ? 'selected' : ''}>${item.item}</option>`;
    });
    return options;
}
$(document).on('click', '#remove-request-btn', function (){ 
    var id = $(this).attr('data-id');
    // alert(id);
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Remove it!"
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: 'remove-request/' + id,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                console.log('Success:', response.item);
                
                Swal.fire({
                    title: "Success!",
                    text: response.message,
                    icon: "success"
                });
                $('#ViewRequestModal').modal('hide');
            },
            error: function (xhr, status, errors) {
                var response = JSON.parse(xhr.responseText);
                console.log("errors", response.errors);
                console.log("XHR:", xhr);
                console.log("Status:", status);
            }
        });
        }
    });
    
    
}); 

$(document).on('click', '#update-request-btn', function (){
    var id = $(this).attr('data-id');
    var item_id = $(this).attr('data-item');
    let row = $(this).closest('tr');
    
    // Find the quantity input field within this row
    let quantityValue = row.find('#quantity').val();
    let itemidValue = row.find('#item').val();
    // alert(itemidValue);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: 'update-request/' + item_id,
        method: 'POST',
        dataType: 'json',
        data: {quantity: quantityValue, id: id, itemid: itemidValue},
        success: function (response) {
            console.log('Success:', response);
            Swal.fire({
                title: "Success!",
                text: response.message,
                icon: "success"
            });
            $('#ViewRequestModal').modal('hide');
        },
        error: function (xhr, status, errors) {
            var response = JSON.parse(xhr.responseText);
            console.log("errors", response.errors);
            console.log("XHR:", xhr);
            console.log("Status:", status);
        }
    });
}); 
$(document).on('click', '#pdf-btn', function () {
    var id = $(this).attr('data-item-id');
    var url = 'purchase-report/' + id ;
    window.open(url, "_blank");
});

$(document).on('click', '#approve-request-btn', function () {
    id = $(this).attr('data-item-id');
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Approve it!"
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: 'approve-request/' + id,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                console.log('Success:', response.item);
                
                Swal.fire({
                    title: "Success!",
                    text: response.message,
                    icon: "success"
                });
                getRequestList();
                // $('#edit-item-image').val(response.image);
            },
            error: function (xhr, status, errors) {
                var response = JSON.parse(xhr.responseText);
                console.log("errors", response.errors);
                console.log("XHR:", xhr);
                console.log("Status:", status);
            }
        });
        }
    });
});

$(document).on('click', '#reject-request-btn', function () {
    id = $(this).attr('data-item-id');
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Reject it!"
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: 'reject-request/' + id,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                console.log('Success:', response.item);
                
                Swal.fire({
                    title: "Success!",
                    text: response.message,
                    icon: "success"
                });
                getRequestList();
                // $('#edit-item-image').val(response.image);
            },
            error: function (xhr, status, errors) {
                var response = JSON.parse(xhr.responseText);
                console.log("errors", response.errors);
                console.log("XHR:", xhr);
                console.log("Status:", status);
            }
        });
        }
    });
});

$(document).on('click', '#add-item-modal', function () {
    let id = $('#ViewRequestModal').attr('data-id');
    $('#AddRequestModal').attr('data-id', id);
    $('#AddRequestModal').modal('show');

});

$(document).on('click', '#submit-item-btn', function () {
    let id = $('#AddRequestModal').attr('data-id');

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: 'add-item/' + id,
        method: 'POST',
        dataType: 'json',
        data: $('#add_request_form').serialize(),
        success: function (response) {
            console.log('Success:', response);
            Swal.fire({
                title: "Success!",
                text: response.message,
                icon: "success"
            });
            $('#ViewRequestModal').modal('hide');
        },
        error: function (xhr, status, errors) {
            var response = JSON.parse(xhr.responseText);
            console.log("XHR:", xhr);
            console.log("Status:", status);
            console.log("Error:", response.errors);
            if (response.errors) {
                Object.keys(response.errors).forEach(key => {
                    iziToast.error({
                        title: 'Error',
                        message: response.errors[key],
                        position: 'topRight'
                    });
                    console.log("Error key:", key);
                    console.log("Error message:", response.errors[key]);
                });
            }
        }
    });

});

