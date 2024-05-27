jQuery(document).ready(function($) {
    var photoContainer = document.getElementById('photo-container');
    var loadMoreButton = document.getElementById('load-more-photos');
    var currentPage = 1;
    var isLoading = false;

    function loadPhotos(page, append = true) {
        if (isLoading) return; // Évite les doublons de requêtes
        isLoading = true;

        var category = $('#photo-category-filter').val() || '';
        var format = $('#photo-format-filter').val() || '';
        var sort = $('#photo-sort').val() || 'date_desc';

        fetch(`${window.location.origin}/wp-admin/admin-ajax.php?action=load_photos&page=${page}&category=${category}&format=${format}&sort=${sort}`)
            .then((response) => {
                if (!response.ok) {
                    console.error("Erreur lors de la requête AJAX:", response.status, response.statusText);
                    isLoading = false;
                    return;
                }

                return response.json();
            })
            .then((data) => {
                if (!data || !data.html) {
                    console.error("Données incorrectes retournées par AJAX.");
                    isLoading = false;
                    return;
                }

                if (append) {
                    photoContainer.innerHTML += data.html; // Ajout de nouvelles photos
                } else {
                    photoContainer.innerHTML = data.html; // Remplace le contenu
                }

                // Contrôle de la visibilité du bouton
                if (data.has_more === false) {
                    loadMoreButton.style.display = 'none'; // Cache si aucune photo supplémentaire
                } else {
                    loadMoreButton.style.display = 'block'; // Affiche le bouton sinon
                }

                isLoading = false;
            })
            .catch((error) => {
                console.error("Erreur lors du chargement des photos:", error);
                isLoading = false;
            });
    }

    // Charge la première page 
    loadPhotos(currentPage, false);

    // Gestion du bouton "Charger plus"
    loadMoreButton.addEventListener('click', function () {
        currentPage++;
        loadPhotos(currentPage, true); // Charge des pages supplémentaires
    });

    // Initialisation de Select2 après avoir lié les événements
  
        $('#photo-category-filter').select2();
        $('#photo-format-filter').select2();
        $('#photo-sort').select2();

    // Gestion des filtres
    $('#photo-category-filter').on('change', function () {
        currentPage = 1;
        loadPhotos(currentPage, false); // Recharger les photos selon la catégorie
    });

    $('#photo-format-filter').on('change', function () {
        currentPage = 1;
        loadPhotos(currentPage, false); // Recharger les photos selon le format
    });

    $('#photo-sort').on('change', function () {
        currentPage = 1;
        loadPhotos(currentPage, false); // Recharger les photos selon le tri
    });
});
