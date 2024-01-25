// Assuming you are using jQuery for simplicity

$(document).ready(function() {
    // AJAX request to get announcements from the server
    $.ajax({
        url: 'announcements/get_announcements.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            // Iterate through each announcement
            data.forEach(function(announcement) {
                // Create a new announcement card
                var announcementCard = $('<div class="announcement-card"></div>');

                // Populate the announcement card with data
                announcementCard.append('<h2>' + announcement.description + '</h2>');
                announcementCard.append('<p>Date: <span class="date">' + announcement.date + '</span></p>');

                // Announcement body
                var announcementBody = $('<div class="announcement-body"></div>');
                announcementBody.append('<p>' + announcement.description + '</p>');
                announcementCard.append(announcementBody);

                // Displaying products for the announcement
                if (announcement.products) {
                    var productList = $('<ul class="product-list"></ul>');
                    var products = announcement.products.split(', ');

                    products.forEach(function(product) {
                        productList.append('<li><label><input type="checkbox" class="announcement-products" name="products[]" value="' + product + '">' + product + '</label></li>');
                    });

                    announcementCard.append(productList);
                }

                // Button to select products for donation
                announcementCard.append('<button class="donate-button">Donate</button>');

                // Append the announcement card to the document
                $('#announcements').append(announcementCard);
            });
        },
        error: function(error) {
            console.error('Error fetching announcements:', error);
        }
    });
});

