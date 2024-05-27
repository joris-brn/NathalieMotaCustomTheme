    document.addEventListener('DOMContentLoaded', function() {
    var contactLink = document.querySelector('#menu-menu-2 > li.menu-item.menu-item-type-post_type.menu-item-object-page.menu-item-21'); // Sélectionnez le lien "Contact" dans le menu
    var contactLink2 = document.querySelector('.menu-item-21');
    var contactButton = document.querySelector('.contact_button'); // Bouton contact
    var contactModale = document.querySelector('.popup-overlay'); // Modale
    const fullscreenMenu = document.querySelector('.fullscreen_menu');
    const burgerButton = document.querySelector('.burger_button');
    
    // Eventlistener au clic sur le lien "Contact" dans le menu
    if (contactLink && contactModale) {
        contactLink.addEventListener('click', function(event) {
            event.preventDefault(); // Pour éviter que le lien ne suive son comportement par défaut
            fullscreenMenu.classList.remove('is-visible'); // Masque le menu
            burgerButton.classList.remove('active');
            contactModale.style.display = 'block'; // Affichage de la modale
        });
    }

    if (contactLink2 && contactModale) {
        contactLink2.addEventListener('click', function(event) {
            event.preventDefault(); // Pour éviter que le lien ne suive son comportement par défaut
            fullscreenMenu.classList.remove('is-visible'); // Masque le menu
            burgerButton.classList.remove('active');
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


/* Menu BURGER */

document.addEventListener('DOMContentLoaded', function() {
    const burgerButton = document.querySelector('.burger_button');
    const fullscreenMenu = document.querySelector('.fullscreen_menu');
    const body = document.querySelector('body');

    burgerButton.addEventListener('click', function() {
        fullscreenMenu.classList.toggle('is-visible');
        body.classList.toggle('no-scroll');
        burgerButton.classList.toggle('active');
        
    });
});



/* Lightbox */

document.addEventListener('DOMContentLoaded', function() {
    let currentPhotoIndex = 0;
    let filteredPhotos = [];

    function attachEventListeners() {
        const photEyeElements = document.querySelectorAll('.photEye');
        photEyeElements.forEach(function(photEye, index) {
            photEye.addEventListener('click', function(event) {
                event.preventDefault();
                event.stopPropagation();

                const lightbox = document.getElementById('lightbox');
                lightbox.style.display = 'block';

                const photoBlock = photEye.closest('.photo-block');
                if (photoBlock) {
                    const imageUrl = photoBlock.querySelector('img').getAttribute('src');
                    document.getElementById('lightbox-image').setAttribute('src', imageUrl);

                    const photoTitle = photoBlock.querySelector('.title_hov').textContent;
                    const photoCategory = photoBlock.querySelector('.categorie_hov').textContent;
                    const photoReference = getPhotoReference(photoBlock);

                    document.querySelector('.lightbox-ref').textContent = photoReference;
                    document.querySelector('.lightbox-cat').textContent = photoCategory;

                    currentPhotoIndex = index;
                    filteredPhotos = Array.from(document.querySelectorAll('.photo-block'));
                }
            });
        });
    }

    function getPhotoReference(photoBlock) {
        const referenceElement = photoBlock.querySelector('.reference');
        return referenceElement ? referenceElement.textContent : '';
    }

    function navigatePhotos(direction) {
        if (filteredPhotos.length > 0) {
            const prevIndex = currentPhotoIndex;
            currentPhotoIndex = (currentPhotoIndex + direction + filteredPhotos.length) % filteredPhotos.length;
            const newPhotoBlock = filteredPhotos[currentPhotoIndex];

            const newImageUrl = newPhotoBlock.querySelector('img').getAttribute('src');
            document.getElementById('lightbox-image').setAttribute('src', newImageUrl);

            const newPhotoTitle = newPhotoBlock.querySelector('.title_hov').textContent;
            const newPhotoCategory = newPhotoBlock.querySelector('.categorie_hov').textContent;
            const newPhotoReference = getPhotoReference(newPhotoBlock);

            document.querySelector('.lightbox-ref').textContent = newPhotoReference;
            document.querySelector('.lightbox-cat').textContent = newPhotoCategory;

            // Déplacer la classe CSS pour mettre en évidence la photo actuelle (facultatif)
            filteredPhotos[prevIndex].classList.remove('active');
            filteredPhotos[currentPhotoIndex].classList.add('active');
        }
    }

    attachEventListeners();

    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.addedNodes.length > 0) {
                attachEventListeners();
            }
        });
    });
    observer.observe(document.body, { childList: true, subtree: true });

    document.querySelector('.close-lightbox').addEventListener('click', function() {
        document.getElementById('lightbox').style.display = 'none';
    });

    window.addEventListener('click', function(event) {
        const lightbox = document.getElementById('lightbox');
        if (event.target === lightbox) {
            lightbox.style.display = 'none';
        }
    });

    document.querySelector('.lightbox-content').addEventListener('click', function(event) {
        event.stopPropagation();
    });

    document.querySelector('.prev').addEventListener('click', function() {
        navigatePhotos(-1);
    });

    document.querySelector('.next').addEventListener('click', function() {
        navigatePhotos(1);
    });
});


 

/* Init SELECT2 */