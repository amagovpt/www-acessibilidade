// Example starter JavaScript for disabling form submissions if there are invalid fields
jQuery(document).ready(function ($) {
    (function () {
        'use strict';

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        let forms = document.querySelectorAll('.needs-validation')
        if(forms) {
            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                            showError();
                        } else {
                            clearError();
                            // form is valid, submit it
                            event.preventDefault()
                            event.stopPropagation()
                            submitForm()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        }
    })()
})

function submitForm() {
    let uri = document.getElementById("uri").value;
    location.href = "https://accessmonitor.acessibilidade.gov.pt/results/" + encodeURIComponent(uri);
    return false;
}

function showError() {
    jQuery('.ama.invalid-feedback').addClass('show')
}

function clearError() {
    jQuery('.ama.invalid-feedback.show').removeClass('show')
}