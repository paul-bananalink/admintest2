import createToast from "../toast/script.js";
import { fetchData } from '../functions.js';
import { validateInput} from './validate.js';

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById('create-domain');

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        if (!validateInput('dPartNer')) {
            return;
        } else if(!validateInput('dDomain')){
            return;
        } else if(!validateInput('dName')){
            return;
        } else if(!validateInput('dTitle')){
            return;
        }

        submitForm();
    });

    function submitForm() {
        form.submit();
    }
});


$(document).on('click', '.delete-btn', function (e) {
    e.preventDefault();
    let url = $(e.currentTarget).data('route');
    console.log($(e.currentTarget), url);

    Swal.fire({
        title: 'Are you sure?',
        // text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            fetchData(url, 'POST', {
                _token: $('meta[name="csrf-token"]').attr('content'),
            }).then(data => {
                if (data?.message) {
                    createToast(data?.type, data?.message);
                    location.reload();
                }
            }).catch(error => {
                alert(error.message)
            });
        }
    })
});

