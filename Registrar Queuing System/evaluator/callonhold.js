
function CallOnHold(str) {
    if (str.length == 0) {
      // document.getElementById("id").value = "";
        
        document.getElementById("usertype").value = "";
        document.getElementById("studentId").value = "";
        document.getElementById("Name").value = "";

        
        
        document.getElementById("ticketnumber").value = "";
        document.getElementById("transactiontype").value = "";
        document.getElementById("department").value = "";
        document.getElementById("transactionstatus").value = ""; 
        document.getElementById("document").value = ""; 
        document.getElementById("email").value = "";
        document.getElementById("emailBody").value = "";
        
        return;
    }
    else {
        // Creates a new XMLHttpRequest object
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {
                var myObj = JSON.parse(this.responseText);

                document.getElementById
                    ("usertype").value = myObj[0];

                document.getElementById
                    ("studentId").value = myObj[1];
                 
               
                document.getElementById(
                    "Name").value = myObj[2];
                      
                document.getElementById(
                    "ticketnumber").value = myObj[3];

                document.getElementById(
                    "transactiontype").value = myObj[4];

            

                   
                document.getElementById(
                    "department").value = myObj[5];
                   
               
             

                document.getElementById(
                    "transactionstatus").value =  myObj[6];
                    document.getElementById("transactionstatus").dispatchEvent(new Event("change"));

                    document.getElementById(
                    "document").value = myObj[7];
                    document.getElementById("document").dispatchEvent(new Event("change"));
           

                document.getElementById(
                    "email").value = myObj[8];

                    document.getElementById(
                        "emailBody").value = myObj[9];
                

                
            
                   
            }
        };

        // xhttp.open("GET", "filename", true);
        xmlhttp.open("GET", "callonhold.php?onholdticket=" + str, true);
          
        // Sends the request to the server
        xmlhttp.send();
    }
}

function deleteRow(row) {
    row.parentNode.removeChild(row);
}