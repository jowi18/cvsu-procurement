let unreadMessageCount = 0;
let level;

$(document).ready(function(){
    getUserData();
    setInterval(() => {
        countNotification();
    }, 2000);
});

function showNotification(){
    console.log("sdsd",level);
    notificationList();
}

const notificationList = () => {
    $.ajax({
        url: '/show-notification',
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            console.log("notif", response);
            const dropdownMenu = $('#notif'); // Select the dropdown menu
            let htmlContent = ''; // Variable to store HTML content
            for (let i = 0; i < response.length; i++) {
                const notification = response[i];
                var formattedDateTime = new Date(notification.created_at);
                formattedDateTime = formattedDateTime.toLocaleDateString("en-US", { month: "long", day: "numeric", year: "numeric", hour: "numeric", minute: "numeric", hour12: true });
                var read_icon = notification['read_at'] ? '' : '<i class="fas fa-star"></i>';
                htmlContent += `
                    <a href="#" class="dropdown-item" onclick="readNotification(${notification.id})">
                    <div class="media">
                    ${notification.image}
                    <div class="media-body">
                    <h3 class="dropdown-item-title font-weight-bold">
                    ${notification.transact_by}
                    <span class="float-right text-sm text-primary">${read_icon}</span>
                    </h3>
                    <p class="text-sm">${notification.message}</p>
                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>${formattedDateTime}</p>
                    </div>
                    </div>
                    </a>
                    <div class="dropdown-divider"></div>`;
            }

                 dropdownMenu.html(htmlContent);

            if (response.length === 0) {
                console.log("No new messages");
            }
        },
        error: function (error) {
            console.error('Ajax request failed: ' + error.responseText);
        }
    });
}

const updateUnreadCount = () => {
    // Update the display of unread message count
    $('.unread-count').text(unreadMessageCount);
}

const readNotification = (id) => {
    console.log("read");
    $.ajax({
        url: '/read-notification/' + id,
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            console.log('Success:', response.status);
        },
        error: function (error) {
            // Handle errors
            console.error('Ajax request failed: ' + error.responseText);
        }
    });
};

const countNotification = () => {
    console.log("count");
    $.ajax({
        url: '/count-notification',
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            console.log('Success:', response);
            $('.unread-count').text(response);
        },
        error: function (error) {
            // Handle errors
            console.error('Ajax request failed: ' + error.responseText);
        }
    });
};

const getUserData = () => {
    $.ajax({
        url: 'get-user-data',   
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            console.log("user_level", response[0].user_level);
            level = response[0].user_level;
        },
        error: function (xhr, status, errors) {
            var response = JSON.parse(xhr.responseText);
            console.log("XHR:", xhr);
            console.log("Status:", status);
            console.log("Error:", response.errors);
        }
    });
}


