// It will mark the customer as serving (gagawin palang)
function markAsServing() {
    var ticket = document.getElementById("ticketnumber").value;
    var servedBy= localStorage.getItem("counternumber");
    console.log(ticket,servedBy);


$.ajax({
    type: "POST",
    url: "setAsServing.php",
    data: {ticketnumber:ticket ,servedBy: servedBy},
    success: function(response) {
        console.log(response);
        selectedId= localStorage.getItem("selected_id");
        selectedCounter= localStorage.getItem("selected_Counter");
        displayQueue(selectedId, selectedCounter);
        
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
        localStorage.setItem('servedAt', datetimeString);


    }
});
}