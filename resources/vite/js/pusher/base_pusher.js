import "../bootstrap";

// thinking about refactor
function handleDataFromPusher(channelName, eventName, funcCall, strict = []) {
    window.Echo.channel(channelName).listen(`.${eventName}`, (data) => {
        funcCall(data, strict);
    });
}

export {
    handleDataFromPusher
}
