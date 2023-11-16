const express = require('express');
const app = express();
const http = require('http').Server(app);
const io = require("socket.io")(http, {
    cors: {
        origin: "http://127.0.0.1:8000"
    }
});

const PORT = process.env.PORT || 3000;

const mysql = require('mysql2');
const moment = require('moment');
const sockets = {};

// create the connection to database
const connect = mysql.createConnection({
    host: '127.0.0.1',
    user: 'root',
    database: 'joboard'
});

connect.connect(function (err) {
    if (err) throw err;
    connect.query('UPDATE users SET is_online=0');
    console.log("Database Connected!");
});

// listen events when php client connect
io.on('connection', (socket) => {

    if (!sockets[socket.handshake.query.user_id]) {
        sockets[socket.handshake.query.user_id] = [];
    }
    sockets[socket.handshake.query.user_id].push(socket);
    socket.broadcast.emit('user_connected', socket.handshake.query.user_id); // send user_id to all client with event 'user_connectted'
    // change status from off -> on in database
    connect.query('UPDATE users SET is_online=1 where id=?', socket.handshake.query.user_id, (err) => {
        if (err) {
            throw err;
        }
        console.log("User Connectted", socket.handshake.query.user_id);
    });
    // listen event 'send_message' from client
    socket.on('send_message', (data) => {
        var group_id = (data.user_id > data.other_user_id) ? data.user_id + data.other_user_id : data.other_user_id + data.user_id;
        var time = moment().format("h:mm:ss A");
        data.time = time; // add time field to data

        connect.query('INSERT INTO chats (user_id, other_user_id, messages, group_id) VALUES (?, ?, ?, ?)', [data.user_id, data.other_user_id, data.message, group_id], (err, res) => {
            if (err) throw err;
            console.log("Message sent!");
            data.id = res.insertId;  // get id of chat that just insert to DB

            for (var index in sockets[data.user_id]) {
                sockets[data.user_id][index].emit('receive_message', data); // send event 'recieve_message' to all client;
            }
            // count message unread
            connect.query(`SELECT COUNT(id) AS unread_messages FROM chats WHERE user_id=? AND other_user_id=? AND is_read = 0`, [data.user_id, data.other_user_id], (err, res) => {
                if (err) throw err;

                data.unread_messages = res[0].unread_messages;

                for (var index in sockets[data.other_user_id]) {
                    sockets[data.other_user_id][index].emit('receive_message', data);
                }
            });
        });
    });

    socket.on('read_message', (id) => {
        connect.query(`UPDATE chats SET is_read = 1 WHERE id=?`, id, (err) => {
            if (err) throw err;
            console.log("Message read!");
        });
    });

    socket.on('disconnect', (err) => {
        // if(err) throw err;
        socket.broadcast.emit('user_disconnected', socket.handshake.query.user_id);
        for (var index in sockets[socket.handshake.query.user_id]) {
            if (socket.id == sockets[socket.handshake.query.user_id][index].id) {
                sockets[socket.handshake.query.user_id].splice(index, 1);
            }
        }

        connect.query('UPDATE users SET is_online=0 where id=?', socket.handshake.query.user_id, (err) => {
            if (err) {
                throw err;
            }
            console.log("User Disonnectted", socket.handshake.query.user_id);
        });
    });
});

app.get('/', (req, res) => {
    res.send("THIS IS SERVER");
});

http.listen(PORT, () => {
    console.log(`App listening at http://localhost:${PORT}`);
});