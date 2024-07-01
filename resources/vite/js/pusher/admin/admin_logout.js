export const adminLogoutEvent = (data) => {
    Swal.fire({ icon: "warning", title: data.message }).then(() => {
        location.reload();
    });
    
    setTimeout(() => location.reload(), 3000);
}
