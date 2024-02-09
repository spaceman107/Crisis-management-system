$(document).ready(function () {
    //AJAX request to fetch categories and populate the checkboxes
    $.ajax({
        url: 'new_request/fetch_categories.php',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            var checkboxesContainer = $('#categories-checkboxes');
            $.each(data, function (key, entry) {
                checkboxesContainer.append(
                    '<label class="container">' + entry.name_category +
                    '<input type="checkbox" class="category-checkbox" value="' + entry.product_category_id + '" />' +
                    '<span class="checkmark"></span>'+
                     '</label><br>'
                );
            });

            //initialize the table
            loadTable(getSelectedCategories());
        },
        error: function (error) {
            console.error('Error fetching categories:', error);
        }
    });

    //trigger loadTable() when there is a change in the selection
    $(document).on('change', '.category-checkbox', function () {
        loadTable(getSelectedCategories());
    });

    //get the checked checkboxes
    function getSelectedCategories() {
        var selectedCategories = [];
        $('.category-checkbox:checked').each(function () {
            selectedCategories.push($(this).val());
        });
        return selectedCategories;
    }

    //function to load the table based on the selected categories
    function loadTable(categories) {
        //if no categories selected set selection to all
        if (categories.length === 0) {
            categories = ['all'];
        }

        $.ajax({
            //categories are sent to the php file as parameters in the request
            url: 'new_request/fetch_products.php?category=' + categories.join(','),
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                //populate the table body with id #tBody
                var tableBody = $('#tBody');
                tableBody.empty();

                $.each(data, function (key, entry) {
                    tableBody.append('<tr>' +
                        '<td><input type="checkbox" name="products[] "value="'+ entry.product_id +'"></td>' +
                        '<td>' + entry.category + '</td>' +
                        '<td>' + entry.details + '</td>' +
                        '</tr>');
                });
            },
            error: function (error) {
                console.error('Error fetching products:', error);
            }
        });
    }
});
