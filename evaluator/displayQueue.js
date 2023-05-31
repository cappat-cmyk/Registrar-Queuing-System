// This function will display all the queue list (wag nangdisplayqueue galawin)
function displayQueue(selectedId, selectedCounter) {
    console.log(selectedId);
    console.log(selectedCounter);

        $.ajax({
    type: "GET",
    url: "displayQueue.php",
    data: {id:selectedId,counternumber:selectedCounter},
    dataType: "json",
    success: function(queue) {
        document.getElementById("queueCount").textContent=queue.length;
        var queueList = document.getElementById("queue-table");
        queueList.innerHTML = "";

        // create table header row
        var headerRow = document.createElement("tr");
        var ticketNumberHeader = document.createElement("th");
        ticketNumberHeader.innerHTML = "Queue List";
        ticketNumberHeader.style.backgroundColor = "blue";
        ticketNumberHeader.style.color = "white";


        headerRow.appendChild(ticketNumberHeader);

        // Append the header row to the table header
        
        var tableHead = queueList.createTHead();
        tableHead.appendChild(headerRow);

        for (var i = 0; i < queue.length; i++) {
            var row = document.createElement("tr");
            var cell = document.createElement("td");
            cell.innerHTML = queue[i].ticket_number;
            row.appendChild(cell);
            if(queue[i].is_priority == "yes") {
                row.classList.add("priority");
                }
            queueList.appendChild(row);
        }
    }
});

}