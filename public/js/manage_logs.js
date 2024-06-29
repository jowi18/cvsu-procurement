$(document).ready(function(){
    manageLogsTable();
    getLogsHistory();
});

const manageLogsTable = () =>{
    LogsHistory = new Tabulator("#manage-logs-table", {
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
            {title:"FULL NAME", field:"name", hozAlign:"left", vertAlign:"middle"},
            {title:"DEPARTMENT", field:"department", hozAlign:"left", formatter:"html", vertAlign:"middle"},
            {title:"ACTION", field:"action", hozAlign:"left", vertAlign:"middle"},
            {title:"DATE", field:"date", hozAlign:"left", vertAlign:"middle"},
        
        ]
    });
}

const getLogsHistory = () => {
    $.ajax({    
        url: '/get-logs-history',
        method: 'GET',
        dataType: 'json',
        success: function (response) { 
            console.log(response);
            LogsHistory.setData(response);
            // $('[data-toggle="tooltip"]').tooltip()
        },
    });
};

function searchLogs(value){
    LogsHistory.setFilter([
        [
            {field:'NO', field: 'no'},
            {field:"action", type:"like", value:value.trim()},
            {field:"department", type:"like", value:value.trim()},
            {field:"date", type:"like", value:value.trim()},
            {field:"name", type:"like", value:value.trim()},         
        ]
    ]);
}