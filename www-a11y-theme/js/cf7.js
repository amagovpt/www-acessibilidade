// Verifica se exist um formulário CF7 na página
const cf7Form = document.querySelector('.wpcf7-form');

if (document.querySelector('.wpcf7-form')) {
    function getErrorMessage(input) {
        // Seleciona o elemento wrapper com a class .wpcf7-form-control-wrap
        const parentElement = input.closest('.wpcf7-form-control-wrap');

        // Identifica todos os sub-elementos do elemento wrapper
        const siblings = Array.from(parentElement.parentNode.children);

        // Encontra o elemento com a mensagem de erro
        const errorMessageElement = siblings.find(sibling => sibling.classList.contains('mensagem-erro'));

        console.log(errorMessageElement.getAttribute('data-mensagem-erro'));

        // Retorna a mensagem de erro
        return errorMessageElement ? errorMessageElement.getAttribute('data-mensagem-erro') : 'No message';
    }

    // Function to set custom error message
    function setCustomErrorMessage(input) {
        const errorMessage = getErrorMessage(input);
        if (errorMessage) {
            input.nextElementSibling.textContent = errorMessage;
        }
    }

    // Detect changes to the input fields via mutation observer
    const observer = new MutationObserver(function (mutations) {
        mutations.forEach(function (mutation) {
            if (mutation.type === 'attributes') {
                if (mutation.attributeName === 'aria-invalid'
                    && mutation.target.getAttribute('aria-invalid') === 'true'
                ) {
                    setCustomErrorMessage(mutation.target);
                }
            }
        });
    });

    // Configure and start the MutationObserver
    const observerConfig = { attributes: true, childList: true, subtree: true };
    observer.observe(cf7Form, observerConfig);

    // Set initial error messages for inputs with aria-invalid=true
    cf7Form.querySelectorAll('[aria-invalid="true"]').forEach(function (input) {
        setCustomErrorMessage(input);
    });
}