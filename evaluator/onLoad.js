window.onload = function() {
    var customer1 = localStorage.getItem("customer");
    var customer = JSON.parse(customer1);

    if(customer){
    console.log(customer);
  
    document.getElementById("btn_save").disabled = false;
    document.getElementById("call").disabled = true;
    document.getElementById("recall").disabled = false;
    document.getElementById("transactionstatus").disabled = false;
    document.getElementById("next").disabled = true;
    document.getElementById("pwd").disabled = true;

  
    dateOfArrival = customer.arrivalTime;
    dateOfArrival = dateOfArrival.substring(0, 10);
    
    var dateToday=getCurrentDate();
    

    if (dateOfArrival == dateToday) {
      if (customer.client_type) {
        document.getElementById("usertype").setAttribute("placeholder", "no value inputted");
        document.getElementById("usertype").value = customer.client_type;
      }
  
      if (customer.ticket_number) {
        document.getElementById("ticketnumber").setAttribute("placeholder", "no value inputted");
        document.getElementById("ticketnumber").value = customer.ticket_number;
      }
  
      if (customer.client_id) {
        document.getElementById("studentId").setAttribute("placeholder", "no value inputted");
        document.getElementById("studentId").value = customer.client_id;
      }
  
      if (customer.client_name) {
        document.getElementById("Name").setAttribute("placeholder", "no value inputted");
        document.getElementById("Name").value = customer.client_name;
      }
  
      if (customer.transaction_type) {
        document.getElementById("transactiontype").setAttribute("placeholder", "no value inputted");
        document.getElementById("transactiontype").value = customer.transaction_type;
      }
  
      if (customer.credential) {
        document.getElementById("document").setAttribute("placeholder", "no value inputted");
        document.getElementById("document").value = customer.credential;
      }
  
      if (customer.course_name) {
        document.getElementById("department").setAttribute("placeholder", "no value inputted");
        document.getElementById("department").value = customer.course_name;
      }
    }
  }
  else{
    document.getElementById("btn_save").disabled = false;
    document.getElementById("call").disabled = true;
    document.getElementById("recall").disabled = true;
    document.getElementById("transactionstatus").disabled = true;
  }
  }
  
  function getCurrentDate() {
    var today = new Date();
    var yyyy = today.getFullYear();
    var mm = today.getMonth() + 1;
    var dd = today.getDate();
  
    if (dd < 10) {
      dd = '0' + dd;
    }
  
    if (mm < 10) {
      mm = '0' + mm;
    }
  
    return yyyy + '-' + mm + '-' + dd;
  }
  