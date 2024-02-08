$(document).ready(function() {
    //AJAX request to get announcements from the server
    $.ajax({
        url: 'announcements/get_announcements.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            //pass through each announcement
            data.forEach(function (announcement) {
                var announcementCard = $('<div class="announcement-card"></div>');
                announcementCard.append('<h2>Announcement</h2>');
                announcementCard.append('<p>Date: <span class="date">' + announcement.date + '</span></p>');

                var announcementBody = $('<div class="announcement-body"></div>');
                announcementBody.append('<p>' + announcement.description + '</p>');
                announcementCard.append(announcementBody);

                if (announcement.products) {
                    var form = $('<form action="announcements/create_donation.php" method="post"></form>'); 
                    var productList = $('<ul class="product-list"></ul>');
                    var products = announcement.products.split(', ');
                    var pro_id = announcement.pro_id.split(', ');

                    productList.append('<p>Select the products and insert the desired quantity for instant donation:</p>');



                    for (var i = 0; i < products.length; i++) {
                        var product = products[i];
                        var pro_ids = pro_id[i];  

                        productList.append('<li><input type="checkbox" name="products[]" class="announcement-products" value="' + pro_ids + '">' +
                                                '<input type="text" name="quantities[]" class="announcement-products" min="1">' + '&nbsp;&nbsp;' + product + '</li>');
                    }

                    form.append(productList);
                    form.append('<button type="submit" class="donate-button">Donate</button>');
                    announcementCard.append(form);
                }

                $('#announcements').append(announcementCard);
            });
        },
        error: function(error) {
            console.error('Error fetching announcements:', error);
        }
    });
});

