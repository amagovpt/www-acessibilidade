jQuery(document).ready(function($) {
    $('#tutos-sync-button').on('click', function() {
        var $button = $(this);
        var $response = $('#tutos-sync-response');
        
        $button.prop('disabled', true).text('A sincronizar...');
        $response.html('<p style="color: #666;">A sincronizar tutoriais do GitHub...</p>');
        
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: { action: 'tutos_sync_github' },
            success: function(response) {
                var cssClass = response.success ? 'notice-success' : 'notice-error';
                $response.html('<div class="notice ' + cssClass + ' is-dismissible"><p>' + response.data + '</p></div>');
                $button.prop('disabled', false).text('Sincronizar Dados');
            },
            error: function(xhr, status, error) {
                $response.html('<div class="notice notice-error is-dismissible"><p>Erro de comunicação com o servidor: ' + error + '</p></div>');
                $button.prop('disabled', false).text('Sincronizar Dados');
            }

        });
    });
});
