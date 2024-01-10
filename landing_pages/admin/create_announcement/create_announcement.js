function submitForm() {
    var announcementText = document.getElementById('announcementText').value;
    var announcementProducts = document.getElementById('announcementProducts').value;

    // Split the product IDs into an array
    var productIds = announcementProducts.split(',');

    // Create an object to send as JSON to the server
    var data = {
        announcementText: announcementText,
        productIds: productIds
    };

    // Use Fetch API to send data to the server
    fetch('create_announcement/insert_announcement.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        // Handle the server response if needed
        console.log(result);
    })
    .catch(error => {
        // Handle errors
        console.error('Error:', error);
    });
}

