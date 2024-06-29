$(document).ready(function() {
    donutChart();
});

const lineChart = () => {
    console.log("chart get");
    $.ajax({
        url: '/sample-datas',
        type: 'GET',
        success: function(data) {
        
            const labels = data.map(item => item.month_name);
            const counts = data.map(item => item.request_count);
            var ctx = document.getElementById('lineChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: '# of Votess',
                        data: counts,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        title: {
                            display: true,
                            text: 'Sample Line Chart'
                        },
                        legend: {
                            display: true,
                            position: 'bottom'
                        }
                    }
                },
                
            });
        },
        error: function(xhr, status){
            console.log(xhr);
            console.log(status);
        },
       
    })
};

const donutChart = () => {
    
    console.log("chart get");
    $.ajax({
        url: '/sample-data',
        type: 'GET',
        success: function(data) {
            console.log("request_count", data[0].department_name);
            const labels = data[0].monthly_data.map(item => item.month_name);
            const counts = data[0].monthly_data.map(item => item.request_count);
            $('.department').html(data[0].department_name + ' ' + "Purchase Request Report" + ' (' + data[0].year + ')');
            // const department = 
            var ctx = document.getElementById('barChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: '# Request Counts',
                        data: counts,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        title: {
                            display: true,
                            text: ''
                        },
                        legend: {
                            display: true,
                            position: 'bottom'
                        }
                    }
                }
            });
        },
        error: function(xhr, status){
            console.log(xhr);
            console.log(status);
        },
    })
};