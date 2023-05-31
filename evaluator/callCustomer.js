function callCustomer() {
 
  const socket = io('http://192.168.251.139:3000');
  var message= document.getElementById("ticketnumber").value;
  var CounterNumber= document.getElementById("CounterNumber").value;

  if(message==""){
    alert("Please click next button to call the next customer");
  }else{

  // Emit the 'call-customer' event with the ticket number and counter number data
  socket.emit('call-customer', { ticketNumber: message, counterNumber: CounterNumber });

  }
     // Speak the message
     document.getElementById("call").disabled=true;
     document.getElementById("recall").disabled=false;
     document.getElementById("btn_save").disabled=false;
}
