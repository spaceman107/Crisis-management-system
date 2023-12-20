        $(document).ready(function () {
            // Fetch categories and populate the dropdown
            $.ajax({
                url: 'fetch_categories.php', 
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    // Populate the dropdown with categories
                    var dropdown = $('#categories-dropdown');
                    dropdown.empty();
                    dropdown.append('<option value="all">All Categories</option>');
                    $.each(data, function (key, entry) {
                        dropdown.append($('<option></option>').attr('value', entry.product_category_id).text(entry.name_category));
                    });

                    // Initial table load with all products
                    loadTable('all');
                },
                error: function (error) {
                    console.error('Error fetching categories:', error);
                }
            });

            // Handle category dropdown change event
            $('#categories-dropdown').on('change', function () {
                var selectedCategory = $(this).val();
                loadTable(selectedCategory);
            });

            // Function to load the table based on the selected category
            function loadTable(category) {
                $.ajax({
                    url: 'fetch_products.php?category=' + category, 
                    method: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        var tableBody = $('#tBody');
                        tableBody.empty();

                        $.each(data, function (key, entry) {
                            tableBody.append('<tr>' +
                                '<td>' + entry.product_id + '</td>' +
                                '<td>' + entry.quantity + '</td>' +
                                '<td>' + entry.name_category + '</td>' +
                                '<td>' + entry.details + '</td>' +
                                '<td>' + entry.name + '</td>' +
                                '</tr>');
                        });
                    },
                    error: function (error) {
                        console.error('Error fetching products:', error);
                    }
                });
            }
        });