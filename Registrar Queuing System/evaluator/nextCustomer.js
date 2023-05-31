// get the next PWD on the counter (wag nang galawin)
function nextCustomer(value1){
            //when selection changes
           var selectedId= document.getElementById("select_id").value;
           var selectedCounter= document.getElementById("select_counter").value;

    $.ajax({
        type: "GET",
        data: {value: value1,id:selectedId,counternumber:selectedCounter},
        url: "nextCustomer.php",
        dataType: "json",
        success: function(customer) {
            //save the client to the session storage
            localStorage.setItem("customer", JSON.stringify(customer));

           var fname = document.getElementById("Name").value = customer.client_name;
           var credentialname = document.getElementById("document").value = customer.credential;
           const emailBody = `Good Day Mr./Ms. ${fname}, this is to inform you that you have requested ${credentialname}. You can claim your document on `;
        //    var emailBody = `Good Day Mr./Ms. ${fname}, this is to inform you that you have requested ${credentialname}. You can claim your document on `;
            // Fill the text fields
                if (customer.client_type) {
                    document.getElementById("usertype").setAttribute("placeholder", "no value inputted");
                    document.getElementById("usertype").value = customer.client_type;
                }

                if (customer.ticket_number) {
                    document.getElementById("ticketnumber").setAttribute("placeholder", "no value inputted");
                    document.getElementById("ticketnumber").value = customer.ticket_number;
                }

                if (customer.client_id ) {
                    document.getElementById("studentId").setAttribute("placeholder", "no value inputted");
                    document.getElementById("studentId").value = customer.client_id;
                }

                if (customer.client_name ) {
                    document.getElementById("Name").setAttribute("placeholder", "no value inputted");
                    document.getElementById("Name").value = customer.client_name;
                }

                if (customer.transaction_type ) {
                    document.getElementById("transactiontype").setAttribute("placeholder", "no value inputted");
                    document.getElementById("transactiontype").value = customer.transaction_type;
                }
                if (customer.email ) {
                    document.getElementById("email").setAttribute("placeholder", "no value inputted");
                    document.getElementById("email").value = customer.email;
                    document.getElementById("emailBody").setAttribute("placeholder", "no value inputted");
                    document.getElementById("emailBody").value = emailBody;
                }
                


            credentialDropdown=document.getElementById("document");
            if(customer.requestCredentials){
            for (var i = 0; i < credentialDropdown.options.length; i++) {
                if (credentialDropdown.options[i].value == customer.requestCredentials) {
                credentialDropdown.selectedIndex = i;
                break;
            }
        }   
    }else{

    }

            if (document.getElementById("department").value == '') {
            document.getElementById("department").value = customer.course_name || 'no value inputted';
            }

            document.getElementById("next").disabled=true;
            document.getElementById("next").removeAttribute("title");
            document.getElementById("next").removeAttribute("data-bs-placement");

            document.getElementById("pwd").disabled=true;
            document.getElementById("pwd").removeAttribute("title");
            document.getElementById("pwd").removeAttribute("data-bs-placement");

            document.getElementById("call").disabled=false;
            document.getElementById("transactionstatus").disabled=false;
            document.getElementById("btn_save").disabled=false;
}

});
}