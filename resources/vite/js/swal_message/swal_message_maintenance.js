$(document).on('click', '.maintenance-item', function (e) {
    e.preventDefault();
    Swal.fire({
        icon: 'info',
        title: '작업중',
        // text: 'This section is currently under maintenance.',
        confirmButtonText: 'OK'
    });
});
