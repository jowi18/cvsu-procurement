$(document).ready(function(){
    manageUser();
    getUserList();
    manageDepartment();
    getDepartmentTable();

});

const manageUser = () =>{
    manage_user = new Tabulator("#manage-user-table", {
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
            {title:"NAME", field:"name", hozAlign:"left", vertAlign:"middle"},
            {title:"DEPARTMENT", field:"department", hozAlign:"left", vertAlign:"middle"},
            {title:"EMAIL", field:"email", hozAlign:"left", vertAlign:"middle"},
            {title:"DATE CREATED", field:"created_at", hozAlign:"left", vertAlign:"middle"},
            {title:"STATUS", field:"status", hozAlign:"left", formatter: "html", vertAlign:"middle"},
            {title:"ACTION", field:"action", hozAlign:"left", formatter: "html", vertAlign:"middle"},
        
        ]
    });
}

const manageDepartment = () =>{
    departmentTable = new Tabulator("#manage-department-table", {
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
            {title:"NO", field:"no", hozAlign:"center",width:75, vertAlign:"middle"},
            {title:"DEPARTMENT", field:"department", hozAlign:"left", vertAlign:"middle"},
            {title:"DATE CREATED", field:"created_at", hozAlign:"left", vertAlign:"middle"},
            {title:"STATUS", field:"status", hozAlign:"left", formatter: "html", vertAlign:"middle"},
            {title:"ACTION", field:"action", hozAlign:"left", formatter: "html", vertAlign:"middle"},
        
        ]
    });
}
$('#submit-user-btn').click(function () {
    console.log("Button clicked");
    var formData = new FormData($('#add_user_form')[0]);
    console.log(formData);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/add-user",
            type: 'POST',
            data: formData,
            processData: false, // Prevent jQuery from automatically transforming the data into a query string
            contentType: false, // Ensure that the correct content type is used for the FormData object
            dataType: 'json', 
            success: function (response) {
                console.log('Success:', response);
                Swal.fire({
                    title: "Success!",
                    text: response.message,
                    icon: "success"
                  });
                  getUserList();
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

const getUserList = () => {
    $.ajax({    
        url: '/get-user-list',
        method: 'GET',
        dataType: 'json',
        success: function (response) { 
            console.log(response);
            manage_user.setData(response);
            $('[data-toggle="tooltip"]').tooltip()
        },
    });
};

const getDepartmentTable = () => {
    $.ajax({    
        url: '/get-department-list',
        method: 'GET',
        dataType: 'json',
        success: function (response) { 
            console.log("dept", response);
            departmentTable.setData(response);
        },
    });
}

$(document).on('click', '#activate-user-btn', function () {
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
                url: 'activate-user/' + id,
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    console.log('Success:', response.item);
                    getUserList();
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

$(document).on('click', '#deactivate-user-btn', function () {
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
                url: 'deactivate-user/' + id,
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    console.log('Success:', response.item);
                    getUserList();
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

$(document).on('click', '#update-user-modal', function () {
    $('#UpdateUserModal').modal('show');
    var id = $(this).attr('data-id');
    $('#UpdateUserModal').attr('data-id', id);

    // alert(id);
    $.ajax({    
        url: '/view-user/' + id,
        method: 'GET',
        dataType: 'json',
        success: function (response) { 
            console.log(response);
            $('#update_department').val(response.department);
            $('#update_firstname').val(response.firstname);
            $('#update_lastname').val(response.lastname);
            $('#update_email').val(response.email);
            $('#update_position').val(response.position);
        },
    });
});


$('#update-user-btn').click(function () {
    var id = $('#UpdateUserModal').attr('data-id');
    var formData = new FormData($('#update_user_form')[0]);
    // alert(id);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/update-user/" + id,
            type: 'POST',
            data: formData,
            processData: false, // Prevent jQuery from automatically transforming the data into a query string
            contentType: false, // Ensure that the correct content type is used for the FormData object
            dataType: 'json', 
            success: function (response) {
                $('#UpdateUserModal').modal('hide');
                console.log('Success:', response);
                Swal.fire({
                    title: "Success!",
                    text: response.message,
                    icon: "success"
                  });
                  getUserList();
                  
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

$('#add_department').click(function (){
    $('#AddDepartmentModal').modal('show');
});

$('#submit-department-btn').click(function () {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "/add-department",
        type: 'POST',
        data: $('#add_department_form').serialize(),
        dataType: 'json', 
        success: function (response) {
            console.log('Success:', response);
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
        }
    })
});

$(document).on('click', '#activate-department-btn', function () {
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
                url: 'activate-department/' + id,
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    console.log('Success:', response.item);
                    getDepartmentTable();
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

$(document).on('click', '#deactivate-department-btn', function () {
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
                url: 'deactivate-department/' + id,
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    console.log('Success:', response.item);
                    getDepartmentTable();
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

$(document).on('click', '#update-department-modal', function () {
    $('#UpdateDepartmentModal').modal('show');
    var id = $(this).attr('data-id');
    $('#UpdateDepartmentModal').attr('data-id', id);
    $.ajax({
        url: '/view-department/' + id,
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            console.log(response.department);
            $('#update_department_val').val(response.department);
        },
    });

});

$('#update-department-btn').click(function () {
    var id = $('#UpdateDepartmentModal').attr('data-id');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "/update-department/" + id,
        type: 'POST',
        data: $('#update_department_form').serialize(),
        dataType: 'json', 
        success: function (response) {
            console.log('Success:', response);
            Swal.fire({
                title: "Success!",
                text: response.message,
                icon: "success"
            });
            getDepartmentTable();
            $('#UpdateDepartmentModal').modal('hide');
        },
        error: function (xhr, status, errors) {
            var response = JSON.parse(xhr.responseText);
            console.log("XHR:", xhr);
            console.log("Status:", status);
            console.log("Error:", response.errors);
        }
    })
});