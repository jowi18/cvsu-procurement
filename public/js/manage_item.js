$(document).ready(function(){
    manageItemTable();
    getItem();
    manageCategoryTable();
    getCategoryList();
});

const manageItemTable = () =>{
    item_table = new Tabulator("#manage-item-table", {
        dataTree:true,
        dataTreeSelectPropagate:true,
        layout:"fitColumns",
        maxHeight: "1000px",
        scrollToColumnPosition: "center",
        pagination:"local",
        paginationSize:10,
        paginationSizeSelector:[10,50,100],
        placeholder:"No Data Set",
        selectable:1,
        rowFormatter:function(dom){
            var selectedRow = dom.getData();
            if(true)
            {
                dom.getElement().classList.add("table-primary");
            }
            else if (selectedRow.status == "Approved")
            {
                dom.getElement().classList.add("table-success");
            }
            else
            {
                dom.getElement().classList.add("table-danger");
            }
        },
        columns:[
            {title:"NO", field:"no", hozAlign:"center",width:75, vertAlign:"middle"},
            {title:"ITEM CODE", field:"item_code", hozAlign:"left", vertAlign:"middle"},
            {title:"CATEGORY", field:"category", hozAlign:"left", vertAlign:"middle"},
            {title:"ITEM NAME", field:"item", hozAlign:"left", vertAlign:"middle", headerWordWrap:true},
            {title:"UNIT", field:"uom", hozAlign:"left", vertAlign:"middle", headerWordWrap:true},
            {title:"PRICE", field:"item_price", hozAlign:"left", vertAlign:"middle"},
            {title:"ACTION", field:"action", hozAlign:"left", formatter: "html", vertAlign:"middle"},
        
        ]
    });
}

const manageCategoryTable = () =>{
    category_table = new Tabulator("#manage-category-table", {
        dataTree:true,
        dataTreeSelectPropagate:true,
        layout:"fitColumns",
        maxHeight: "1000px",
        scrollToColumnPosition: "center",
        pagination:"local",
        paginationSize:5,
        paginationSizeSelector:[5,50,100],
        placeholder:"No Data Set",
        selectable:1,
        rowFormatter:function(dom){
            var selectedRow = dom.getData();
            if(true)
            {
                dom.getElement().classList.add("table-primary");
            }
            else if (selectedRow.status == "Approved")
            {
                dom.getElement().classList.add("table-success");
            }
            else
            {
                dom.getElement().classList.add("table-danger");
            }
        },
        columns:[
            {title:"NO", field:"no", hozAlign:"left", width: 75, vertAlign:"middle"},
            {title:"CATEGORY", field:"category", hozAlign:"left", vertAlign:"middle"},
            {title:"CREATED AT", field:"created_at", hozAlign:"left", vertAlign:"middle", headerWordWrap:true},
            {title:"STATUS", field:"status", hozAlign:"left", formatter: "html", vertAlign:"middle"},
            {title:"ACTION", field:"action", hozAlign:"left", formatter: "html", vertAlign:"middle"},
        
        ]
    });
}

$('#submit-item-btn').click(function () {
    console.log("Button clicked");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/add-item",
            type: 'POST',
            data: $('#add_item_form').serialize(),
            dataType: 'json', 
            success: function (response) {
                console.log('Success:', response);
                Swal.fire({
                    title: "Success!",
                    text: response.message,
                    icon: "success"
                  });
                getItem();
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

const getItem = () =>{
    $.ajax({
        url: '/get-item-list',
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            console.log(response);
            item_table.setData(response);
        },
        error: function (xhr, status, errors) {
            console.log("XHR:", xhr);
            console.log("Status:", status);
            console.log("Error:", errors);
            iziToast.error({
                title: 'Error',
                message: errors,
                position: 'topRight'
            });
        }
    });

}

$(document).on('click', '#delete-item-btn', function () {
    var id = $(this).attr('data-id');
    // alert(id);
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Delete it!"
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'delete-item/' + id,
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    console.log('Success:', response.item);
                    getItem();
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

$(document).on('click', '#add_category', function () {
    $('#AddCategoryModal').modal('show');
});

$(document).on('click', '#submit-category-btn', function () {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "/add-category",
        type: 'POST',
        data: $('#add_category_form').serialize(),
        dataType: 'json', 
        success: function (response) {
            console.log('Success:', response);
            Swal.fire({
                title: "Success!",
                text: response.message,
                icon: "success"
              });
            getCategoryList();
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

$(document).on('click','#view-item-modal', function(){
    let id = $(this).attr('data-id');
    $('#UpdateItemModal').attr('data-id',id);
    $('#UpdateItemModal').modal('show');

    $.ajax({
        url: 'view-item/' + id,
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            console.log('Success:', response);
            $('#update_item').val(response.item);
            $('#update_item_price').val(response.item_price);
            $('#update_category').val(response.category);
            $('#update_unit_of_measurement').val(response.unit_of_measurement);
        },
        error: function (xhr, status, errors) {
            var response = JSON.parse(xhr.responseText);
            console.log("errors", response.errors);
            console.log("XHR:", xhr);
            console.log("Status:", status);
        }
    });
});

$(document).on('click','#update-item-btn', function(){
    let id = $('#UpdateItemModal').attr('data-id');

   $.ajax({
        url: 'update-item/' + id,
        method: 'GET',
        dataType: 'json',
        data: $('#update_item_form').serialize(),
        dataType: 'json',
        success: function (response) {
            console.log('Success:', response.item);
            getItem();
            Swal.fire({
                title: "Success!",
                text: response.message,
                icon: "success"
            });
            $('#UpdateItemModal').modal('hide');
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

const getCategoryList = () =>{
    $.ajax({
        url: '/get-category-list',
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            console.log("categories", response);
            category_table.setData(response);
        },
        error: function (xhr, status, errors) {
            console.log("XHR:", xhr);
            console.log("Status:", status);
            console.log("Error:", errors);
        }
    });
}

$(document).on('click', '#update-category-modal', function () {
    $('#UpdateCategoryModal').modal('show');
    let id = $(this).attr('data-id');
    $.ajax({
        url: 'view-category/' + id,
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            console.log('Success:', response);
            $('#update_category_val').val(response.category);
        },
        error: function (xhr, status, errors) {
            var response = JSON.parse(xhr.responseText);
            console.log("errors", response.errors);
            console.log("XHR:", xhr);
            console.log("Status:", status);
        }
    });
    $('#UpdateCategoryModal').attr('data-id', id);
});

$('#update-category-btn').click(function (){
    var id = $('#UpdateCategoryModal').attr('data-id');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: 'update-category/' + id,
        type: 'POST',
        data: $('#update_category_form').serialize(),
        dataType: 'json',
        success: function (response) {
            console.log('Success:', response);
            Swal.fire({
                title: "Success!",
                text: response.message,
                icon: "success"
            });
            getCategoryList();
            $('#UpdateCategoryModal').modal('hide');
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
$(document).on('click', '#activate-category-btn', function () {
    var id = $(this).attr('data-id');
    // alert(id);
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Activate it!"
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'activate-category/' + id,
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    console.log('Success:', response.item);
                    getCategoryList();
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

$(document).on('click', '#deactivate-category-btn', function () {
    var id = $(this).attr('data-id');
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Deactivate it!"
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'deactivate-category/' + id,
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    console.log('Success:', response.item);
                    getCategoryList();
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