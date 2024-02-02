function showProductsInVehicle() {
    

    // Fetch products associated with the specified vehicle_id
    fetch('get_products_in_vehicle.php')
        .then(response => response.json())
        .then(products => {
            const productList = document.getElementById('productList');
            productList.innerHTML = "";  // Clear previous content

            // Display products
            if (products.length > 0) {
                products.forEach(product => {
                    const productName = product.product_name;
                    

                    // Display product information (you can customize this part)
                    const productInfo = productName;
                    const productElement = document.createElement('p');
                    productElement.textContent = productInfo;
                    productList.appendChild(productElement);
                });
            } else {
                productList.textContent = "No products found for the selected vehicle.";
            }
        })
        .catch(error => console.error('Error:', error));
}
function unload() {
fetch('unload_products.php')
    .then(response => response.json())
    .then(data => {
        // Check if the operation was successful
        if (data.success) {
            console.log('Products unloaded successfully. Message:', data.message);
            // You can perform additional actions here if needed
        } else {
            console.error('Error:', data.error);
            // Handle the error if the operation was not successful
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Handle other types of errors, e.g., network issues
    });

}

function showProducts() {
    fetch('get_products.php')
        .then(response => response.json())
        .then(products => {
            // Assuming there's an element with id "productList" to display products
            const productList = document.getElementById('productList');
            productList.innerHTML = "";  // Clear previous content

            // Create checkboxes and input fields dynamically for each product
            products.forEach(product => {
                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.name = 'selectedProducts';
                checkbox.value = product.product_id; // Assuming each product has a unique ID

                const quantityInput = document.createElement('input');
                quantityInput.type = 'number';
                quantityInput.name = 'quantity';
                quantityInput.value = 0; // Default quantity to 0
                quantityInput.min = 0;   // Minimum quantity allowed

                const label = document.createElement('label');
                label.appendChild(checkbox);

                // Concatenate product_name for the label text
                const labelText = `${product.product_name} (Quantity: ${product.quantity})`;
                label.appendChild(document.createTextNode(labelText));
                label.appendChild(quantityInput);

                productList.appendChild(label);
                productList.appendChild(document.createElement('br'));
            });
        })
        .catch(error => console.error('Error:', error));
}


// Function to execute SQL query on selected products
function executeQuery() {
    // Retrieve all checkboxes with name 'selectedProducts'
    const checkboxes = document.querySelectorAll('input[name="selectedProducts"]:checked');

    // Create an array to store selected products and quantities
    const selectedProducts = [];

    // Loop through the checked checkboxes and store product ID and quantity in the array
    checkboxes.forEach(checkbox => {
        const productId = checkbox.value;

        // Assuming the quantity input is next to the checkbox within the label
        const quantityInput = checkbox.nextElementSibling;
        const quantity = quantityInput.value;

        // Push the selected product and quantity to the array
        selectedProducts.push({ productId, quantity });
    });

    // Send the selected products and quantities to a PHP script using fetch
    fetch('process_selected_products.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ selectedProducts }),
    })
    .then(response => response.json())
    .then(data => {
        // Handle the response from the server if needed
        console.log(data);
    })
    .catch(error => console.error('Error:', error));
}


fetch('rescuer_coordinates.php')
    .then(response => response.json())
    .then(RescuerCoordinates => {
        console.log('RescuerCoordinates:', RescuerCoordinates);

        RescuerCoordinates.forEach(item => {
            var markerRescuer = L.divIcon({
                className: 'markerRescuer',
                html: '<img src="https://png.pngtree.com/png-vector/20190215/ourmid/pngtree-vector-car-icon-png-image_515825.jpg" width="30" height="30" alt="Custom Marker">',
                iconSize: [30, 20],
            });

            var RescuerMarker = L.marker([parseFloat(item.lat), parseFloat(item.lng)], {
                icon: markerRescuer,
                draggable: true
            }).addTo(RescuerLayer)
            updateButtonVisibility();
        });

        // Call updateCoordinates after markers are created (if needed)
        // updateCoordinates(someLat, someLng);
    })
    .catch(error => console.error('Error fetching data:', error));

    fetch('base_coordinates.php')
    .then(response => response.json())
    .then(BaseCoordinates => {
        console.log('BaseCoordinates:', BaseCoordinates);

        BaseCoordinates.forEach(item => {
            var markerBase = L.divIcon({
                html: '<img src="https://cdn.iconscout.com/icon/free/png-256/free-base-1786434-1520324.png" width="30" height="30" alt="Custom Marker">',
                className: 'markerBase',
                iconSize: [30, 20],
            });

    L.marker([parseFloat(item.lat), parseFloat(item.lng)], { icon: markerBase,}).addTo(map).addTo(baseLayer).bindPopup("Base id :" + item.base_id);
     updateButtonVisibility();
           

            
        });
    })
    .catch(error => console.error('Error fetching data:', error));

    
    function updateButtonVisibility() {
        const rescuerMarker = RescuerLayer.getLayers()[0]; 
        const baseMarker = baseLayer.getLayers()[0]; 
        const button = document.getElementById('myButton');
    
        if (rescuerMarker && baseMarker) {
            const distance = rescuerMarker.getLatLng().distanceTo(baseMarker.getLatLng());
    
            if (distance < 100) {
                button.style.display = 'block';
                return;
            }
        }
    
        button.style.display = 'none';
    }