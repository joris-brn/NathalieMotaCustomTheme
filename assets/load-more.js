jQuery(document).ready(function($) {
    var page = 2; // Démarre à la page 2, car la première page est déjà chargée

    $('#load-more-photos').on('click', function() {
        $.ajax({
            url: ajax_vars.ajax_url,
            type: 'post',
            data: {
                action: 'load_more_photos',
                page: page
            },
            success: function(response) {
                if (response.success) {
                    $('.affichage_photo-fp').append(response.data); // Ajouter les nouvelles photos
                    page++; // Incrémenter le compteur de pages
                } else {
                    $('#load-more-photos').hide();
                }
            }
        });
    });
});
