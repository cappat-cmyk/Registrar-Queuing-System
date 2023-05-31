// this code will save the transaction to the database based from the localstorage
function customer_saveTransaction(){


  // get the JSON-encoded data from local storage
let jsonData = localStorage.getItem('customer');

// parse the JSON string to a JavaScript object
let myData = JSON.parse(jsonData);

// customer.id= counterNumber= Counter kung san siya dapat
// customer.counter_id= handled_By= sino ang may handle sa counter na iyon
// id=evaluated_By= sino ang nag entertain
// client_type=client_type- student, faculty, others
// studentID= client_id
// fullname= client_name
// email= email
// is_priority= yes or no
// ticketNumber- customer ticketnumber
// transactionType= kung request or claim
// requestedDocument- kung anong document ang nirerequest
// status- kung finish, incomplete, onhold
// remarksTextArea- kung incomplete, on hold
// additional_info- yung meron dun sa ibaba
// arrivalTime- date ng pumasok sa queue
// servedAt- date ng natawag sa call
// finishedAt- pag naclick yung save
// claimDate- yung sinet ng evaluator
// is_claimed= if yes or no

 // i add this
 const now = new Date();
 const year = now.getFullYear();
 const month = (now.getMonth() + 1).toString().padStart(2, '0');
 const day = now.getDate().toString().padStart(2, '0');
 const hour = now.getHours().toString().padStart(2, '0');
 const minute = now.getMinutes().toString().padStart(2, '0');
 const second = now.getSeconds().toString().padStart(2, '0');
 const millisecond = now.getMilliseconds().toString().padStart(6, '0');
 
 const datetimeString = `${year}-${month}-${day} ${hour}:${minute}:${second}.${millisecond}`;
 localStorage.setItem('finishedAt', datetimeString);
 

// access the data properties
let customerId= myData.Handled_by;
let counterId= myData.counter_id;
let evaluated_By=localStorage.getItem('counternumber');
let client_type= myData.client_type;
let client_id= document.getElementById("studentId").value;
let client_name= document.getElementById("Name").value;
let email= myData.email;
let is_priority=myData.is_priority;
let ticket_number= myData.ticket_number;
let transaction_type= document.getElementById("transactiontype").value;
let credential= document.getElementById("document").value;
let department= myData.course_name;
let status= document.getElementById("transactionstatus").value;
let remarksTextArea=document.getElementById("remarkstxtarea").value;
let additonal_info= document.getElementById("faculty_transactinfo").value;
let arrivalTime= myData.arrivalTime;
let servedAt= localStorage.getItem('servedAt');
let finishedAt= datetimeString;
let claimDate= document.getElementById("dateclaim").value;
let is_claimed='no';
let emailbody = document.getElementById("emailBody").value;
// Create an object containing the data to be sent to the server
let data = {
  customerId: customerId,
  counterId: counterId,
  evaluated_By: evaluated_By,
  client_type: client_type,
  client_id: client_id,
  client_name: client_name,
  email: email,
  is_priority: is_priority,
  ticket_number: ticket_number,
  transaction_type: transaction_type,
  credential: credential,
  department:department,
  status: status,
  remarksTextArea: remarksTextArea,
  additonal_info: additonal_info,
  arrivalTime: arrivalTime,
  servedAt: servedAt,
  finishedAt: finishedAt,
  claimDate: claimDate,
  is_claimed: is_claimed,
  emailbody: emailbody,
};

// Send an AJAX request to the server
$.ajax({
  type: 'POST',
  url: 'saveTransaction.php',
  data: data,
  success: function(response) {
    deleteLocalStorage();
  },
  error: function(xhr, status, error) {
    // Handle any errors that occur during the AJAX request

    console.error(error);
  }
});
}

function deleteLocalStorage(){
  delete localStorage.customer;
  delete localStorage.getDate;
}