// It will mark the customer as serving (gagawin palang)
function markAsServing() {

    // Get the JSON object from session storage
    const customerJson = localStorage.getItem("customer");

    // Parse the JSON object
    const customerObj = JSON.parse(customerJson);

$.ajax({
    type: "POST",
    url: "setAsServing.php",
    data: {customerId: customerObj.queue_id,servedBy: localStorage.getItem("counternumber")},
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