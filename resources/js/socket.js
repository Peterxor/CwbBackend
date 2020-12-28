import Echo from 'laravel-echo'
window.io = require('socket.io-client')

window.Echo = new Echo({
    broadcaster: 'socket.io',
    // host: 'https://wfc-wds-websocket.larvata.tw'
    host:window.location.hostname + ':6001',
})

window.Echo.channel('laravel_database_mobile_event').listen('MobileActionEvent', (e) => {
    console.log(e)
})
