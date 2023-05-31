
function deleteRow(str) {
    console.log('Deleting row with ID:', str);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        console.log('AJAX request state:', this.readyState, 'status:', this.status);
        if (this.readyState == 4 && this.status == 200) {
            console.log('AJAX response:', this.responseText);
            var response = JSON.parse(this.responseText);
            if (response.status == 'success') {
                alert(response.message);
                // Code to update the UI or reload the page
             
            } else {
                alert(response.message);
            }
        }
    };
    xmlhttp.open("GET", "deleteonhold.php?delete_onholdticket=" + str, true);
    xmlhttp.send();
}

function deletethisrow(row){
    row.parentNode.removeChild(row);
}
