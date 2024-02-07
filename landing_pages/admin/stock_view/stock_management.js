
    async function initializeStockManagement() {  
    let selectedCategories = []; // Array to store selected categories
    let selectedItems = []; // Array to store selected items


async function loadCategories() {
    // Fetch item categories from the server
    try {
        // Fetch categories
        selectedCategories = [];
        const response = await fetch('stock_management/fetch_categories.php');
        const categories = await response.json();
            const categorySelect = document.getElementById('categorySelect');

            // Clear existing options
            categorySelect.innerHTML = '';

            // Add default option
            const defaultOption = document.createElement('option');
            defaultOption.text = 'Select Category';
            categorySelect.add(defaultOption);

            // Add categories to the select dropdown
            categories.forEach(category => {
                const option = document.createElement('option');
                option.value = category.product_category_id;
                option.text = category.name_category;
                categorySelect.appendChild(option);
            });
            categorySelect.dispatchEvent(new Event('change'));
        } catch (error) {
            console.error('Error fetching categories:', error);
        }
    }

    async function loadItems() {
        try {
    // Fetch items based on the selected category using the Fetch API with the body method
        selectedItems = [];
            //updateSubmitButton();
    const categoryID = document.getElementById('categorySelect').value;
    const response = await fetch('stock_management/fetch_items.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ product_category_id: categoryID }),
    });
    const items = await response.json();
        const itemsContainer = document.getElementById('itemsContainer');
    
        // Clear existing items
        itemsContainer.innerHTML = '';

        // Add checkboxes for each item
        items.forEach(item => {
            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.name = 'items[]';
            checkbox.value = item.product_id;
            checkbox.id = `item_${item.product_id}`;

            const label = document.createElement('label');
            label.htmlFor = `item_${item.product_id}`;
            label.appendChild(document.createTextNode(item.product_name));

            checkbox.addEventListener('change', () => {
                // Update the selected items array
                if (checkbox.checked) {
                    selectedItems.push(item);
                } else {
                    const index = selectedItems.findIndex(selectedItem => selectedItem.product_id === item.product_id);
                    if (index !== -1) {
                        selectedItems.splice(index, 1);
                    }
                }
                console.log('Selected items:', selectedItems);
            });

            itemsContainer.appendChild(checkbox);
            itemsContainer.appendChild(label);
            itemsContainer.appendChild(document.createElement('br'));
            
        });

        } catch (error) {
            console.error('Error fetching items:', error);
        }
    }
    
     // Load categories on page load
    await loadCategories();

    const categorySelection = document.getElementById('categorySelect');
    categorySelection.addEventListener('change', async function (){
        console.log('Category changed:', this.value);
        selectedCategories = [this.value]; // Store the selected category in the array
        console.log('Selected categories:', selectedCategories);
        try {
            await loadItems();
            console.log('Load items completed successfully');
        } catch (error) {
            console.error('Error loading items:', error);
        }
    });
}

    async function submitForm(event) {
        try {
        console.log('Submit form function is running.');

        // Log the selectedItems array
        console.log('Selected items:', selectedItems);
        
    
        event.preventDefault();
        const itemsToSubmit = JSON.stringify(selectedItems);
        console.log('Items to submit:', itemsToSubmit);
    
        if (itemsToSubmit.length === 0) {
            console.log('No items selected.');
            return;
        }
    
        try {
            // Assuming you have a server-side endpoint for updating item availability
            const response = await fetch('stock_management/mark_items_available.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ selectedItems : itemsToSubmit }),
            });
    
            const result = await response.json();
    
            if (result.success) {
                console.log('Items marked as available successfully.');
                // Additional logic if needed
            } else {
                console.error('Error marking items as available:', result.error);
            }
        } catch (error) {
            console.error('Error submitting form:', error);
        }  } catch (error) {
            console.error('Error in form submission:', error);
        }
    }
    console.log('itemsForm:', document.getElementById('itemsForm'));
    console.log('submitButton:', document.getElementById('submitButton'));


    
