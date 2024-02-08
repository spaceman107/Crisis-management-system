$(document).ready(function() {
    //function to delete a transaction
    function deleteTransaction(transactionId) {
        //prompt the user for confirmation
        if (confirm("Are you sure you want to cancel this transaction?")) {
            
            $.ajax({
                url: 'transaction_history/reject_transaction.php',
                method: 'POST',
                data: { transactionId: transactionId },
                success: function(response) {
                    // Handle success
                    console.log('Transaction canceled successfully');
                     
                    //refresh the table after deletion doesnt work???
                    fetchTransactions(); 
                },
                error: function(error) {
                    console.error('Error canceling transaction:', error);
                }
            });
        }
    }

    //fetch transactions 
    $.ajax({
        url: 'transaction_history/fetch_transactions.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            var tableBody = $('#hisBody');
            tableBody.empty();

            $.each(data, function(key, entry) {
                var row = $('<tr>' +
                    '<td>' + entry.transaction_id + '</td>' +
                    '<td>' + entry.status + '</td>' +
                    '<td>' + entry.time_of_acceptance + '</td>' +
                    '<td>' + entry.time_of_completion + '</td>' +
                    '</tr>');

                //dont add button for COMPLETE or REJECTED
                if (entry.status !== 'COMPLETE' && entry.status !== 'REJECTED') {
                    row.append('<td><button class="cancel-button">CANCEL</button></td>');
                } else {
                    row.append('<td></td>'); 
                }

                tableBody.append(row);
            });

            //event listener for the cancel buttton
            $('.cancel-button').on('click', function() {
                var transactionId = $(this).closest('tr').find('td:first').text();
                deleteTransaction(transactionId);
            });
        },
        error: function(error) {
            console.error('Error getting history:', error);
        }
    });
});
