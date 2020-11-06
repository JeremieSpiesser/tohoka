require('./bootstrap')

window.Echo.channel('test')
    .listen('TestEvent', e => {
            console.log(e);
            alert('Une notif x3');
        }
    );

