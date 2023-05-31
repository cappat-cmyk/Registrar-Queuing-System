const express = require('express');
const app = express();

const server = require('http').createServer(app);
const io = require('socket.io')(server);

app.use(express.static(__dirname + '/public'));

io.on('connection', (socket) => {
  console.log('a user connected');

  socket.on('queueData', (data) => {
    console.log(data);
    io.emit('queueData', data);
  });

  socket.on('disconnect', () => {
    console.log('user disconnected');
  });
});

server.listen(3000, () => {
  console.log('listening on *:3000');
});
