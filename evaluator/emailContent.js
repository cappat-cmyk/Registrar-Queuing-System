let customer = JSON.parse(localStorage.getItem('customer')); // retrieve the array
function getCourse(){
  customer.course_name = document.getElementById('department').value;
  localStorage.setItem('customer', JSON.stringify(customer)); // store the updated array in local storage

}

function getCredential(){
  customer.credential = document.getElementById('document').value;
  localStorage.setItem('customer', JSON.stringify(customer)); // store the updated array in local storage
}

function getName() {
    // update the value of client_name in the array
    customer.client_name = document.getElementById('Name').value;
    localStorage.setItem('customer', JSON.stringify(customer)); // store the updated array in local storage
  }

function getStudentId(){
    customer.client_id=document.getElementById("studentId").value;
    localStorage.setItem('customer', JSON.stringify(customer)); // store the updated array in local storage

    customer.client_name = document.getElementById('Name').value;
    localStorage.setItem('customer', JSON.stringify(customer)); // store the updated array in local storage
}


function getTransactionType(){
    customer.transaction_type = document.getElementById('transactiontype').value;
    localStorage.setItem('customer', JSON.stringify(customer)); // store the updated array in local storage
}


function getDate() {
    let inputDate = document.getElementById("dateclaim").value;
    const event = new Date(inputDate);
    const dayOfWeek = event.getDay();
    let month = "";
    switch (event.getMonth()) {
      case 0:
        month = "January";
        break;
      case 1:
        month = "February";
        break;
      case 2:
        month = "March";
        break;
      case 3:
        month = "April";
        break;
      case 4:
        month = "May";
        break;
      case 5:
        month = "June";
        break;
      case 6:
        month = "July";
        break;
      case 7:
        month = "August";
        break;
      case 8:
        month = "September";
        break;
      case 9:
        month = "October";
        break;
      case 10:
        month = "November";
        break;
      case 11:
        month = "December";
        break;
    }
    const year = event.getFullYear();
    const dateStr = `${month} ${event.getDate()}, ${year}`;
    const storageVal = dateStr;
    localStorage.setItem("getDate", storageVal);
    console.log(storageVal);
}








