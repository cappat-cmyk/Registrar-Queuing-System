function getTransactDetail(studentID) {
    $.ajax({
      url: "getTransactions.php",
      type: "POST",
      data: { studentID: studentID },
      success: function(result) {
        var data = JSON.parse(result);
        var transactHtml = '';

        if(data){
          document.getElementById("transaction-details").style.visibility="visible";

        }
        
        // Remove the existing transaction details
        $('#transaction-details .transaction-list').empty();
        
        // Add the new transaction details
        for (var i = 0; i < data.length; i++) {
          var dateHtml = '<span class="fs-6 date">Date: ' + data[i].arrivalTime.substring(0, 10) + '</span><br>';
          var credentialHtml = '<span class="fs-6 credential"> Credential: ' + data[i].requestedDocument + '</span><br>';
          transactHtml += dateHtml + credentialHtml;          
            
        }

        // Check if pagination is needed
        if (data.length > 3) {
          // Calculate the number of pages needed
          var numPages = Math.ceil(data.length / 3);

          // Add pagination links to the HTML
          transactHtml += '<div class="pagination">';
          for (var j = 1; j <= numPages; j++) {
            transactHtml += '<a href="#" class="page-link">' + j + '</a>';
          }
          transactHtml += '</div>';

          // Hide all but the first 3 transactions
          $('.transact-container > div').slice(3).hide();

          // Add click event handlers to the pagination links
          $('.page-link').click(function(e) {
            e.preventDefault();

            // Hide all transactions
            $('.transact-container > div').hide();

            // Show the transactions for the clicked page
            var pageNum = parseInt($(this).text());
            var start = (pageNum - 1) * 3;
            var end = start + 3;
            $('.transact-container > div').slice(start, end).show();
          });
        }
        transactHtml = '<div style="line-height:1;">' + transactHtml + '</div>';
        $('#transaction-details .transaction-list').append(transactHtml);

      },
      error: function() {
        alert('Error fetching transaction details');
      }
    });
  }
  