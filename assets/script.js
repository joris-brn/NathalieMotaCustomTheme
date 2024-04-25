document.addEventListener('DOMContentLoaded', function() {
    var contactLink = document.querySelector('.menu-item-21'); // Sélectionnez le lien "Contact" dans le menu
    var contactButton = document.querySelector('.contact_button'); // Sélectionnez le bouton "Contact"
    var contactModale = document.querySelector('.popup-overlay'); // Sélectionnez la modale
    
    // Eventlistener au clic sur le lien "Contact" dans le menu
    if (contactLink && contactModale) {
        contactLink.addEventListener('click', function(event) {
            event.preventDefault(); // Pour éviter que le lien ne suive son comportement par défaut
            contactModale.style.display = 'block'; // Affichage de la modale
        });
    }

    // Eventlistener au clic sur le bouton "Contact"
    if (contactButton && contactModale) {
        contactButton.addEventListener('click', function(event) {
            event.preventDefault(); // Pour éviter que le bouton ne suive son comportement par défaut
            contactModale.style.display = 'block'; // Affichage de la modale
            let referenceLabel = document.querySelector('#wpcf7-f32-o1 > form > div.formulaire > p:nth-child(3) > label > span > input');
            let referenceText = document.querySelector('#reference').textContent;
            referenceLabel.value = referenceText;
        });
    }

    // Eventlistener pour fermer la modale au click a l'exterieur de celle-ci
    window.addEventListener('click', function(event) {
        if (event.target === contactModale) {
            contactModale.style.display = 'none'; // Fermeture de la modale
        }
    });
});



/* Affichages des miniatures des images au hover */


/* Menu BURGER */

document.addEventListener('DOMContentLoaded', function() {
    const burgerButton = document.querySelector('.burger_button');
    const fullscreenMenu = document.querySelector('.fullscreen_menu');

    burgerButton.addEventListener('click', function() {
        fullscreenMenu.classList.toggle('is-visible');
    });
});


