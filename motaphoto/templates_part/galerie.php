<script>
jQuery(document).ready(function($) {
    // Fonction pour initialiser Fancybox
    function initialiserFancybox() {
        $('.full-view').fancybox({
            // Options générales
            closeExisting: false,   // Fermer toutes les instances de fancybox existantes lors de l'ouverture d'une nouvelle
            loop: true,             // Activer la boucle à travers les galeries
            gutter: 50,             // Espace entre les diapositives en pixels
            keyboard: true,         // Activer la navigation au clavier
            arrows: true,           // Afficher les flèches de navigation
            infobar: true,          // Afficher la barre d'information
            smallBtn: false,        // Afficher le petit bouton de fermeture
            toolbar: true,          // Afficher la barre d'outils
            buttons: ['thumbs', 'close'], // Personnaliser les boutons de la barre d'outils
            // Options d'animation
            animationEffect: 'fade',        // Effet de transition
            animationDuration: 500,         // Durée de transition en millisecondes
            transitionEffect: 'fade',       // Effet de transition entre les diapositives
            transitionDuration: 500,        // Durée de transition entre les diapositives en millisecondes
            slideClass: 'fancybox-slide',   // Classe CSS personnalisée pour les diapositives
            baseClass: 'fancybox-container', // Classe CSS personnalisée pour le conteneur fancybox
            // Options de vignettes
            thumbs: {
                autoStart: true,   // Démarrage automatique de l'affichage des vignettes
                hideOnClose: true, // Masquer les vignettes lors de la fermeture de fancybox
                axis: 'y'          // Direction d'affichage des vignettes ('x' pour horizontal, 'y' pour vertical)
            },
            // Modèles de boutons
            btnTpl: {
                arrowLeft: '<button data-fancybox-prev class="fancybox-button fancybox-button--arrow_left" title="{{PREV}}">' +
                '<div class="container-precedentes">'+
                    '<img src="<?php echo get_stylesheet_directory_uri() . '/assets/fleche_gauche.png'; ?>" alt="flèche gauche">' +
                    '<span class="custom-span">Précédentes</span>' +
                '</div>'+
                    '</button>',
                arrowRight: '<button data-fancybox-next class="fancybox-button fancybox-button--arrow_right" title="{{NEXT}}">' +
                '<div class="container-suivantes">'+
                    '<span class="custom-span">Suivantes</span>' +
                    '<img src="<?php echo get_stylesheet_directory_uri() . '/assets/fleche_droite.png'; ?>" alt="flèche droite">' +     
                '</div>'+
                '</button>',
            },
            // Options d'image
            protect: true,           // Empêcher le téléchargement des images
            hideScrollbar: false,    // Masquer la barre de défilement vertical
            clickContent: 'close',   // Action à effectuer lors du clic sur la zone de contenu ('close' ou 'next')
            // Autres options
            autoFocus: true,         // Mise au point automatique sur le premier élément visible lors de l'ouverture de fancybox
            backFocus: true,         // Restaurer le focus sur l'élément déclencheur lors de la fermeture de fancybox
            trapFocus: true,         // Empêcher de sortir de fancybox en tabulant
            touch: {
                vertical: false,     // Autoriser le glissement vertical
                momentum: true       // Activer le défilement par inertie
            },
            hash: false              // Activer la navigation par hachage d'URL
        });
    }

    // Réinitialiser Fancybox pour les éléments .full-view
    initialiserFancybox();

    // Fonction pour filtrer les images
    function filtrerImages() {
        var categorie = $('#categorie').val();
        var format = $('#format').val();
        var annee = $('#annee').val();

        $('.grid').empty(); // Vide la grille avant d'ajouter les nouvelles images

        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'filter_images',
                categorie: categorie,
                format: format,
                annee: annee
            },
            success: function(response) {
                $('.grid').html(response); // Ajoute les nouvelles images à la grille
                // Réinitialiser Fancybox pour les nouvelles images
                initialiserFancybox();
                // Cacher le bouton "Charger plus" si aucune image supplémentaire n'est disponible
                if ($('.grid .item').length < 8) {
                    $('#load-more').hide();
                } else {
                    $('#load-more').show();
                }
                // Cacher le bouton si aucun résultat n'est retourné
                if (response.trim() == 'Aucune image trouvée.') {
                    $('#load-more').hide();
                }
            }
        });
    }

    // Filtre lorsque le sélecteur de catégorie change
    $('#categorie').on('change', function() {
        filtrerImages();
    });

    // Filtre lorsque le sélecteur de format change
    $('#format').on('change', function() {
        filtrerImages();
    });

    // Filtre lorsque le sélecteur d'année change
    $('#annee').on('change', function() {
        filtrerImages();
    });

    var offset = 8;

    $('#load-more').on('click', function() {
        var categorie = $('#categorie').val();
        var format = $('#format').val();
        var annee = $('#annee').val();
        var offset = $('.grid .item').length; // Calcul de la position actuelle

        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'load_more_images',
                offset: offset,
                categorie: categorie,
                format: format,
                annee: annee
            },
            success: function(response) {
                if (response.trim() !== '') {
                    $('.grid').append(response);
                    offset += 8;
                    // Réinitialiser Fancybox pour les nouvelles images
                    initialiserFancybox();
                } else {
                    $('#load-more').hide(); // Masquer le bouton "Charger plus" s'il n'y a pas de nouvelles images disponibles
                }
            }
        });
    });
});

</script>