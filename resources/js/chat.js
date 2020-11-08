window.myUserId = undefined;
window.users = [];

window.Echo.join('public_room')
    .here(users => {
        console.log('Here: ' + JSON.stringify(users));
        users.forEach(user => {
            if(window.myUserId === undefined){
                window.myUserId = user.id;
            }
            addConnectedUser(user);
            window.users.push(user);
        });
    })
    .joining(user => {
        console.log('Joining: ' + JSON.stringify(user));
        addConnectedUser(user);
        window.users.push(user);
    })
    .leaving(user => {
        console.log('Leaving: ' + JSON.stringify(user));
        removeConnectedUser(user);
        window.users.splice(users.indexOf(user), 1);
    })
    .listen('Message\\NewMessage', e => {
            console.log(e);
            let name = users.find(user => {
                return String(user.id) === String(e.sender);
            });
            if(name === undefined){
                console.error("Can't find user from received message");
                return;
            }
            name = name.name;
            const discussion = $("#chat-discussion");
            discussion.append(
                "<div class=\"chat-message " + (String(e.sender) === String(myUserId) ? "left" : "right") + "\">" +
                "<div class=\"message\">" +
                "<a class=\"message-author\" href=\"#\"> " + name + " </a>" +
                "<span class=\"message-date\"> " + e.date + " </span>" +
                "<span class=\"message-content\">" + e.message + "</span></div></div>"
            );
            discussion.animate({ scrollTop: discussion[0].scrollHeight}, 500);
        }
    );

window.sendMessage = function(msg){
    window.axios.post('/message', {msg: msg})
        .then(r => console.log('Send OK : ' + r.data))
        .catch(err => console.log('Send failed : ' + err));
}

$(function() {
    $("#sendMsgBtn").click(function(e){
        let input = $("#inputMsg");
        sendMessage(input.val());
        input.val("");
    });
    $("#inputMsg").keypress(function(e){
        if(e.which === 13) {
            let input = $(this);
            sendMessage(input.val());
            input.val("");
            e.preventDefault();
        }
    });
});

function addConnectedUser(user){
    $("#users-list").append(`<div class="chat-user" data-id="${user.id}"><div class="chat-user-name">${user.name}</div></div>`);
}

function removeConnectedUser(user){
    $(`[data-id='${user.id}']`).remove();
}
