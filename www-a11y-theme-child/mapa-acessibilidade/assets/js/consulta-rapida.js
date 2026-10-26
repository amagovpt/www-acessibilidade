jQuery(window).off().on('load', init);

function toggleLoading() {
    jQuery("#consulta-rapida-loading").toggleClass("show")
}

function init() {

    let filterForm = jQuery('#wcag-form')

    console.log(filterForm)

    filterForm.on('submit', (e)=>{
        e.preventDefault()
        let formSubmit = jQuery.ajax({
            url: filterForm.attr('action'),
            type: filterForm.attr('method'),
            data: filterForm.serialize(),
            processData: false,
            contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
            beforeSend: function(xhr){
                //xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
                toggleLoading();
            },
            success: (response) => {
                if(response.status === 'success') {
                    jQuery('#principios-diretrizes').html(response.html);
                    jQuery('#numero-resultados').html(response.number_results)
                    toggleLoading();
                }
            },
            error: (response) => {
                console.log(response);
                toggleLoading();
            }
        });
    })
}