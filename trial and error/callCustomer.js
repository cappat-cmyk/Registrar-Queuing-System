const socket = io();
const counterNumber = 1; // Example counter number
const ticketNumber = 123; // Example ticket number

socket.emit('queueData', { counterNumber, ticketNumber });