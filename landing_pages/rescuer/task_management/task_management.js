document.addEventListener('DOMContentLoaded', function() {
    const map1 = L.map('map1', {
        center: [37.983810, 23.727539],
        zoom: 10,
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
    }).addTo(map1);

    let rescuerMarker = null;



    fetch('task_management/rescuer_coordinates.php')
        .then(response => response.json())
        .then(rescuerCoordinates => {

            const item = rescuerCoordinates[0];
            const icon = L.divIcon({
                html: '<img src="https://png.pngtree.com/png-vector/20190215/ourmid/pngtree-vector-car-icon-png-image_515825.jpg" width="30" height="30" alt="Custom Marker">',
                iconSize: [30, 20],
                className: 'markerRescuer',
                iconSize: [30, 30],
            });
            rescuerMarker = L.marker([parseFloat(item.lat), parseFloat(item.lng)], { icon: icon}).addTo(map1);
        })
        .catch(error => console.error('Error fetching rescuer coordinates:', error));



    fetch('task_management/tasks.php')
        .then(response => response.json())
        .then(TaskHimselfCoordinates => {
            const taskListContainer = document.getElementById('taskList');
            taskListContainer.innerHTML = '';

            TaskHimselfCoordinates.forEach(item => {
                const taskMarker = L.marker([parseFloat(item.lat), parseFloat(item.lng)])
                    .addTo(map1)
                    .bindPopup(
                        "User Fullname: " + item.first_name + " " + item.last_name +
                        "<br>Phone: " + item.phone +
                        "<br>Time of Submission: " + item.time_of_submition +
                        "<br>Product Category: " + item.name_category +
                        "<br>Quantity: " + item.quantity
                    );

                const listItem = document.createElement('li');
                listItem.innerHTML = `
                        <strong>User:</strong> ${item.first_name} ${item.last_name}<br>
                        Phone: ${item.phone}<br>
                        Submission: ${item.time_of_submition}<br>
                        Acceptance: ${item.time_of_acceptance}<br>
                        Category : ${item.name_category}<br>
                        Quantity :  ${item.quantity}
                    `;


                const button1 = document.createElement('button');
                button1.innerText = 'cancel';
                button1.style.display = 'block';

                const button2 = document.createElement('button');
                button2.innerText = 'Complete';
                button2.style.display = 'none';


                listItem.appendChild(button1);
                listItem.appendChild(button2);

                taskListContainer.appendChild(listItem);
                button1.onclick = () => handleTaskCancellation(taskItem);
                updateButtonVisibility(taskMarker, button2, item);
            });
        })
        .catch(error => console.error('Error fetching Task Coordinates:', error));


    function updateButtonVisibility(taskMarker, button2, taskItem) {
        if (rescuerMarker) {
            const distance = rescuerMarker.getLatLng().distanceTo(taskMarker.getLatLng());
            console.log(`Distance to task: ${distance}`);

            if (distance <= 50) {

                button2.style.display = 'block';

                button2.onclick = () => handleTaskCompletion(taskItem);
            } else {

                button2.style.display = 'none';
            }
        }
    }

    function handleTaskCompletion(taskItem) {

        fetch('task_management/complete_task.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({

                    transactionId: taskItem.transaction_id
                }),
            })
            .then(response => response.json())
            .then(data => {
                console.log('Task completed:', data);

            })
            .catch(error => console.error('Error completing task:', error));
    }

    function handleTaskCancellation(taskItem) {

        fetch('task_management/cancel_task.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({

                    transactionId: taskItem.transaction_id
                }),
            })
            .then(response => response.json())
            .then(data => {
                console.log('Task cancelled:', data);

            })
            .catch(error => console.error('Error cancelling task:', error));
    }


});
