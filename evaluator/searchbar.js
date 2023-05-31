$(document).ready(function() {
    $('#searchfield').on('input', function() {
        var query = $(this).val();
        $.ajax({
            url: 'searchbar.php',
            type: 'POST',
            data: {query: query},
            success: function(data) {
                $('#search-results').html(data).show();
                $('#search-results li').on('click', function() {
                    var selected = $(this).text().split(' ')[0]; // extract student ID
                    $('#searchfield').val(selected);
                    $('#search-results').empty();
                });
            }
        });
    });

    $(document).on('click', function(e) {
        if (!$(e.target).closest('#search-container').length) {
            $('#search-results').hide();
        }
    });
});
