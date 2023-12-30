$(document).ready(function () {
    // Fetch categories and populate the checkboxes
    $.ajax({
        url: 'stock_view/fetch_categories.php',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            // Populate the checkboxes with categories
            var checkboxesContainer = $('#categories-checkboxes');
            $.each(data, function (key, entry) {
                checkboxesContainer.append(
                    '<label class="container">' + entry.name_category +
                    '<input type="checkbox" class="category-checkbox" value="' + entry.product_category_id + '" />' +
                    '<span class="checkmark"></span>'+
                     '</label><br>'
                );
            });

            // Initial table load with all products
            loadTable(getSelectedCategories());
        },
        error: function (error) {
            console.error('Error fetching categories:', error);
        }
    });

    // Handle category checkboxes change event
    $(document).on('change', '.category-checkbox', function () {
        loadTable(getSelectedCategories());
    });

    // Function to get selected categories
    function getSelectedCategories() {
        var selectedCategories = [];
        $('.category-checkbox:checked').each(function () {
            selectedCategories.push($(this).val());
        });
        return selectedCategories;
    }

    // Function to load the table based on the selected categories
    function loadTable(categories) {
        // If no categories selected, default to 'all'
        if (categories.length === 0) {
            categories = ['all'];
        }

        $.ajax({
            url: 'stock_view/fetch_products.php?category=' + categories.join(','),
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                var tableBody = $('#tBody');
                tableBody.empty();

                $.each(data, function (key, entry) {
                    tableBody.append('<tr>' +
                        '<td>' + entry.product_id + '</td>' +
                        '<td>' + entry.quantity + '</td>' +
                        '<td>' + entry.category + '</td>' +
                        '<td>' + entry.details + '</td>' +
                        '<td>' + entry.name + '</td>' +
                        '<td>' + entry.total_quantity_in_transactions + '</td>' +
                        '</tr>');
                });
            },
            error: function (error) {
                console.error('Error fetching products:', error);
            }
        });
    }
});