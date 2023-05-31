function setPlain() {
    socket.emit('call-customer', { counterNumber: 1, ticketNumber: 'A123' });

  }
  