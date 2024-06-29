$(document).ready(function(){
    pmppTable();
    getPmppList();

});

const pmppTable = () =>{
    pmpp = new Tabulator("#pmpp-table", {
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
            if(selectedRow.status == "Pending")
            {
                dom.getElement().classList.add("table-primary");
            }
            else if (selectedRow.status == "Approved")
            {
                dom.getElement().classList.add("table-success");
            }
            else if (selectedRow.status == "For Approval")
            {
                dom.getElement().classList.add("table-info");
            }
            else
            {
                dom.getElement().classList.add("table-danger");
            }
        },
        columns:[
            {title:"NO", field:"no", hozAlign:"center",width:75, vertAlign:"middle"},
            {title:"CREATED BY", field:"prepared_by", hozAlign:"left", vertAlign:"middle"},
            {title:"PROCUREMENT PROJECT", field:"project", hozAlign:"left", vertAlign:"middle"},
            {title:"DATE CREATED", field:"created_at", hozAlign:"left", vertAlign:"middle"},
            {title:"YEAR PLAN", field:"year", hozAlign:"left", vertAlign:"middle"},
            {title:"STATUS", field:"status_badge", hozAlign:"left", formatter: "html", vertAlign:"middle"},
            {title:"STATUS TEXT", field:"status", hozAlign:"left", vertAlign:"middle", visible: false},
            {title:"ACTION", field:"action", hozAlign:"left", formatter: "html", vertAlign:"middle"},
        
        ]
    });
}

function searchPmpp(value){
    pmpp.setFilter([
        [
            {field:'NO', field: 'no'},
            {field:"project", type:"like", value:value.trim()},
            {field:"prepared_by", type:"like", value:value.trim()},
            {field:"budget", type:"like", value:value.trim()},
            {field:"status_badge", type:"like", value:value.trim()},         
        ]
    ]);
}

$('#filter-status').change(function(){
    var value = $('#filter-status').val();
    pmpp.setFilter([
        [
            {field:"status", type:"like", value:value.trim()},
        ]
    ]);
});

const viewPmppItemTable = (setData) =>{
    pmppItem = new Tabulator("#view-pmpp-table", {
         data:setData,
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
             {title:"NO", field:"no", hozAlign:"center",width:75, vertAlign:"middle"},
             {title:"ITEM", field:"item_name", hozAlign:"left", vertAlign:"middle"},
             {title:"UNIT OF MEASUREMENT", field:"unit_of_measurement", hozAlign:"left", vertAlign:"middle"},
             {title:"ITEM DESCRIPTION", field:"item_description", hozAlign:"left", vertAlign:"middle"},
             {title:"QUANTITY", field:"item_quantity", hozAlign:"left", vertAlign:"middle"},
             {title:"PRICE", field:"price", hozAlign:"left", vertAlign:"middle"},
             {title:"TOTAL", field:"total", hozAlign:"left", vertAlign:"middle", bottomCalc:"sum", topCalcParams:{
                precision:1,
            }},
            {title:"ACTION", field:"action", hozAlign:"left", formatter:"html", vertAlign:"middle"},
         
         ]
     });
 }

const getPmppList = () => {
    $.ajax({    
        url: '/get-pmpp-list',
        method: 'GET',
        dataType: 'json',
        success: function (response) { 
            pmpp.setData(response);
        },
    });
};

$('#submit-pmpp-btn').click(function () {
    console.log("Button clicked");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/submit-pmpp",
            type: 'POST',
            data: $('#pmpp_form').serialize(),
            dataType: 'json', 
            success: function (response) {
                console.log('Success:', response);
                getPmppList();
                Swal.fire({
                    title: "Success!",
                    text: response.message,
                    icon: "success"
                  });
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
$(document).on('click', '.add-item-btn-class', function () {
    $('#AddPmppItemModal').modal('show');
    var id = $(this).attr('data-id');
    $('#AddPmppItemModal').attr('data', id);
    // alert(id);
    let btn = $(this);
    $.ajax({    
        url: '/view-pmpp-list/' + id,
        method: 'GET',
        dataType: 'json',
        beforeSend: function() {
            $(btn).html("Loading")
            $(btn).prop("disabled", true)
        },
        success: function (response) { 
            console.log(response);
            viewPmppItemTable(response);
            // viewRequest.setData(response);
            $('#ViewRequestModal').modal('show');
            $(btn).html(`<i class="fa fa-plus"></i>`)
            $(btn).prop("disabled", false)
        },
    });
});

$('#submit-item-btn').click(function () {
    var id = $('#AddPmppItemModal').attr('data');
    var item = $('#item-name').val();  
    var category = $('#item-name option:selected').attr('data-category');
    var item_description = $('#item-description').val();
    var quantity = $('#item-quantity').val();
    var uom = $('#item-name option:selected').attr('data-uom');
    // alert(item);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/submit-pmpp-item/" + id,
            type: 'POST',
            // data: $('#PmppAddItemForm').serialize(),
            data: {item: item, uom: uom, category: category, quantity: quantity, item_description: item_description},
            dataType: 'json', 
            success: function (response) {
                console.log('Success:', response);
                $('#AddPmppItemModal').modal('hide');
                Swal.fire({
                    title: "Success!",
                    text: response.message,
                    icon: "success"
                });
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


$(document).on('click', '#approved-btn', function () {
    id = $(this).attr('data-id');

    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Approved it!"
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'approved-pmpp/' + id,
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    console.log('Success:', response.item);
                    getPmppList();
                    Swal.fire({
                        title: "Success!",
                        text: response.message,
                        icon: "success"
                    });
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


$(document).on('click', '#rejected-btn', function () {
    id = $(this).attr('data-id');
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
            url: 'rejected-pmpp/' + id,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                console.log('Success:', response.item);
                getPmppList();
                Swal.fire({
                    title: "Success!",
                    text: response.message,
                    icon: "success"
                });
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


$(document).on('click', '#forward-btn', function () {
    id = $(this).attr('data-id');

    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Forward it!"
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'forward-pmpp/' + id,
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    console.log('Success:', response.item);
                    getPmppList();
                    Swal.fire({
                        title: "Success!",
                        text: response.message,
                        icon: "success"
                    });
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

$(document).on('click', '#review-btn', function () {
    id = $(this).attr('data-id');
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Pass it!"
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: 'reviewed-pmpp/' + id,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                console.log('Success:', response.item);
                getPmppList();
                Swal.fire({
                    title: "Success!",
                    text: response.message,
                    icon: "success"
                });
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

$('#download-btn').click(function (){
    $('#DownloadPmppModal').modal('show');
});
$('#download-submit-btn').click(function (){
    var url = 'pmpp-report/' + $('#year').val();
    window.open(url, "_blank");
});

$(document).on('click','.remove-item', function (){
    var id = $(this).attr('data-id');
    // alert(id);
    $.ajax({
        url: 'remove-item/' + id,
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            console.log('Success:', response.item);
            getPmppList();
            Swal.fire({
                title: "Success!",
                text: response.message,
                icon: "success"
            });
            $('#AddPmppItemModal').modal('hide');
            getPmppList();
            // $('#edit-item-image').val(response.image);
        },
        error: function (xhr, status, errors) {
            var response = JSON.parse(xhr.responseText);
            console.log("errors", response.errors);
            console.log("XHR:", xhr);
            console.log("Status:", status);
        }
    });
});