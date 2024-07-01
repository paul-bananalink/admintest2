document.addEventListener("DOMContentLoaded", function() {
    if (document.querySelector('meta[name="swal-message"]')) {
        Swal.fire({
            title: 'Notification',
            text: document.querySelector('meta[name="swal-message"]').getAttribute('content'),
            icon: 'info',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                location.href = '/partner/notice/index';
            }
        });
    }
});
