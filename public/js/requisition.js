var itemRequest = [], item_no = 0;

$(document).ready(function(){
    requisitionTable();

    $('#selectOption').change(function(){
        
        var selectedOption = $(this).val();
        $('#item').val(selectedOption);
    });
    
});

const requisitionTable = () =>{
    requisition = new Tabulator("#requisition-table", {
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
            }else if(selectedRow.safety_stock == selectedRow.qty)
            {
                dom.getElement().classList.add("table-warning");
            }
        },
        columns:[
            {formatter:"rowSelection", titleFormatter:"rowSelection",vertAlign:"center", hozAlign:"center", headerHozAlign:'center',resizable:true, headerSort:false, width: 50, cellClick:function(e, cell){
                cell.getRow().toggleSelect();
            }}, 
            {title:"NO", field:"id", hozAlign:"center",width:75, vertAlign:"middle"},
            {title:"ITEM DESCRIPTION", field:"itemName", hozAlign:"left", vertAlign:"middle"},
            {title:"QUANTITY", field:"quantity", hozAlign:"left", vertAlign:"middle"},
            {title:"AMOUNT", field:"price", hozAlign:"left", vertAlign:"middle"},
            {title:"TOTAL", field:"total_amount", hozAlign:"left", vertAlign:"middle", bottomCalc: "sum"},
        
        ]
    });
}

$('#add-request-btn').click(function () {
  
    var itemNames = $('#item').val().trim();
    var item_id = $('#item option:selected').data("item");
    var itemQuantity = $('#quantity').val().trim();
    // var itemPrice = $('#price').val().trim();
    var itemPrice = $('#item option:selected').data("price");

    console.log("quantity", itemQuantity);
    if (itemNames === '' || itemQuantity === '') {
        iziToast.error({
            title: 'Error',
            message: 'Item name and quantity cannot be empty',
            position: 'topRight'
    });
        return; 
    }
    var newItem = {
        id: ++item_no,
        itemName: itemNames,
        itemId: item_id,
        quantity: itemQuantity,
        price: itemPrice,
        total_amount: itemQuantity * itemPrice
    };

    itemRequest.push(newItem);
    requisition.setData(itemRequest);
    $('#quantity').val(" ");
    $('#price').val(" ");

    console.log("button click", itemRequest);
   
});

$('#submit-request-btn').click(function () {
    console.log("button submit");
    let purpose = $('#purpose').val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/insert-purchase-request',
        method: 'POST',
        dataType: 'json',
        data: { itemRequest: itemRequest,  purpose : purpose},
        success: function (response) {
            itemRequest = [];
            requisition.setData(itemRequest);
            Swal.fire({
                title: "Success!",
                text: response.message,
                icon: "success"
              });
            console.log(itemRequest);
            console.log('Success:', response);
        },
        error: function (xhr, error) {
            var response = JSON.parse(xhr.responseText);
            console.log("XHR:", xhr);
            console.error('Ajax request failed: ' + response);
            iziToast.error({
                title: 'Error',
                message: response.errors.itemRequest,
                position: 'topRight'
            });
        }
    });
});

var removeSelectedButton = document.getElementById("removeSelectedButton");
    removeSelectedButton.addEventListener("click", function() {
        var selectedRows = requisition.getSelectedRows();
    
        selectedRows.forEach(function(row) {
            requisition.deleteRow(row);
        var rowData = row.getData();
        var index = itemRequest.findIndex(function(item) {
            return item.id === rowData.id;
        });
        
        console.log("index", index);
        if (index !== -1) {
            itemRequest.splice(index, 1);
        }
    
    });
    if (itemRequest.length === 0) {
        // Reset the item_no counter to zero
        item_no = 0;
    }
    
});

