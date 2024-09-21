$(document).ready(function () {

     
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

            let categoriesData = [];
            categoriesData = data;
            initAutocomplete(categoriesData);


            loadTable(getSelectedCategories());
        },
        error: function (error) {
            console.error('Error fetching categories:', error);
        }
    });

    
    $(document).on('change', '.category-checkbox', function () {
        loadTable(getSelectedCategories());
    });


    //search categories with autocomplete
    //doesnt work perfectly with only 1 letter
    function initAutocomplete(categories) {
        var categoryNames = categories.map(function (entry) {
            return entry.name_category;
        });

        //autocomplete function is from jQuery UI 
        $('#autocomplete').autocomplete({
            source: categoryNames,
            select: function (event, ui) {
                var selectedCategory = ui.item.value;

                //check the coresponding category from the menu
                $('.category-checkbox').each(function () {
                    //get the container and change is to checked
                    var label = $(this).parent().text().trim();
                    if (label === selectedCategory) {
                        $(this).prop('checked', true).trigger('change');
                    }
                });

                //colapse the ui
                $('#autocomplete').val('');
                return false;
            }
        });
    }

   
    function getSelectedCategories() {
        var selectedCategories = [];
        $('.category-checkbox:checked').each(function () {
            selectedCategories.push($(this).val());
        });
        return selectedCategories;
    }

    
    function loadTable(categories) {
        //if no categories selected set selection to all
        if (categories.length === 0) {
            categories = ['all'];
        }

        $.ajax({
           
            url: 'new_request/fetch_products.php?category=' + categories.join(','),
            method: 'GET',
            dataType: 'json',
            success: function (data) {
             
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
