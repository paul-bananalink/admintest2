document.addEventListener('DOMContentLoaded', function() {
    var memberIdInput = document.getElementById('member_id');
    var memberPasswordInput = document.getElementById('member_password');

    var oldMemberId = localStorage.getItem('oldMemberId');
    var oldMemberPassword = localStorage.getItem('oldMemberPassword');

    if (oldMemberId) {
        memberIdInput.value = oldMemberId;
    }
    if (oldMemberPassword) {
        memberPasswordInput.value = oldMemberPassword;
    }

    document.querySelector('form').addEventListener('submit', function() {
        localStorage.setItem('oldMemberId', memberIdInput.value);
        localStorage.setItem('oldMemberPassword', memberPasswordInput.value);
    });
});
