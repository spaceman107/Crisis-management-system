$(document).ready(function() {
    $.ajax({
        url: 'transaction_history/fetch_transactions.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            var tableBody = $('#hisBody');
            tableBody.empty();

            $.each(data, function(key, entry) {
                tableBody.append('<tr>' +
                    '<td>' + entry.transaction_id + '</td>' +
                    '<td>' + entry.status + '</td>' +
                    '<td>' + entry.time_of_acceptance + '</td>' +
                    '<td>' + entry.time_of_completion + '</td>' +
                    '</tr>');
            });
        },
        error: function(error) {
            console.error('Error getting history:', error);
        }
    });
});