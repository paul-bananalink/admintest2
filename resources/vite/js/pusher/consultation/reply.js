import '../../bootstrap';

window.Echo.channel('note-page').listen('.reply-member-consultation-test', (e) => {
    console.log(e);
});
