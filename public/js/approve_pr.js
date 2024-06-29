$(document).ready(function() {
    manageApprovePr();
    getApprovePrList();
});


const manageApprovePr= () =>{
    approve_pr_table = new Tabulator("#manage-approve-pr-table", {
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
            {title:"REQUESTED BY", field:"created_by", hozAlign:"left", vertAlign:"middle"},
            {title:"PR CODE", field:"pr_code", hozAlign:"left", vertAlign:"middle"},
            {title:"ACTION", field:"action", hozAlign:"left", formatter: "html", vertAlign:"middle"},
        
        ]
    });
}

function searchPr(value){
    approve_pr_table.setFilter([
        [
            {field:'NO', field: 'no'},
            {field:"pr_code", type:"like", value:value.trim()}, 
            {field:"created_by", type:"like", value:value.trim()},   
        ]
    ]);
}

const getApprovePrList = () => {
    $.ajax({
        url: '/get-approve-pr-list',
        method: 'GET',
        dataType: 'json',
        success: function (response) { 
            console.log(response);
            approve_pr_table.setData(response);
        }
    });
}

$(document).on('click', '.add-attachment', function (){
    let id = $(this).attr('data-item-id')
    $('#AddPrAttachmentModal').modal('show');
    $('#AddPrAttachmentModal').attr('data-id', id);
});

$('#submit-attachment-btn').on('click', function(){
    let id = $('#AddPrAttachmentModal').attr('data-id');
    var formData = new FormData($('#add_attachment_form')[0]);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/add-pr-attachment/' + id,
        method: 'POST',
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function (response) {
            console.log(response);
            Swal.fire({
                title: "Success!",
                text: response.message,
                icon: "success"
              });
            $('#AddPrAttachmentModal').modal('hide');
            getApprovePrList();
        },
        error: function (xhr, status, errors) {
            console.log("XHR:", xhr);
            console.log("Status:", status);
            console.log("Error:", errors);
        }
    });
});

$(document).on('click', '.view-attachment', function (){
    $('#PrAttachmentrModal').modal('show');
    let id = $(this).attr('data-item-id')
    let btn = $(this);
    $.ajax({
        url: '/view-pr-attachment/' + id,
        method: 'GET',
        dataType: 'json',
        contentType: false,
        processData: false,
        beforeSend: function() {
            $(btn).html("Loading")
            $(btn).prop("disabled", true)
            $('#attachment_drop').html("Loading...");
        },
        success: function (response) {
            console.log("attach", response);
          
            const html_content = $('#attachment_drop'); 
            let htmlContent = '';
            for (let i = 0; i < response.length; i++) {
                const item = response[i];
                console.log(item);
                htmlContent += `
                            ${item.attachment}
                    `;
                }
            html_content.html(htmlContent);
            $(btn).html(`<i class="fas fa-file-pdf"></i>`)
            $(btn).prop("disabled", false)
            
        },
        error: function (xhr, status, errors) {
            console.log("XHR:", xhr);
            console.log("Status:", status);
            console.log("Error:", errors);
        }
    });
});

