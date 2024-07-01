document.addEventListener('DOMContentLoaded', function () {
    const loader = document.getElementById('loader');

    function showLoader() {
        loader.style.display = 'block';
    }

    function hideLoader() {
        loader.style.display = 'none';
    }

    window.addEventListener('beforeunload', function () {
        showLoader();
    });

    window.addEventListener('load', function () {
        setTimeout(hideLoader, 7000);
    });

    window.addEventListener('load', hideLoader);
})




