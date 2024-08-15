function submitAnnouncement() {
    var announcementText = document.getElementById('announcementText').value;
    var announcementProducts = document.getElementById('announcementProducts').value;

    if (!announcementText || announcementText.trim() === '') {
        alert('Announcement text is required.');
        return;
    }

    if (!announcementProducts || announcementProducts.trim() === '') {
        alert('Product IDs are required.');
        return;
    }


    //add product ids to array
    var productIds = announcementProducts.split(',');

    //create an object to send as JSON to the server
    var data = {
        announcementText: announcementText,
        productIds: productIds
    };

    fetch('create_announcement/insert_announcement.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (response.ok) {
            alert('Announcement successfully created!');
            console.log('Announcement successfully created.');

            //clear text fields
            document.getElementById('announcementText').value = '';
            document.getElementById('announcementProducts').value = '';
        } else {
            alert('Failed to create announcement.');
            console.error('Failed to create announcement.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

