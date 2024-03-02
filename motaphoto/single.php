<?php get_header(); ?>

<!-- Inclure Slick Carousel CSS -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css"/>

<!-- Inclure jQuery et Slick Carousel JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<!-- Inclure Fancybox CSS -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css"/>

<!-- Inclure Fancybox JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>

<script>
    $(document).ready(function() {
    $('.full-view').fancybox({
        // General Options
        closeExisting: false,   // Close all existing fancybox instances when opening a new one
        loop: true,             // Enable looping through galleries
        gutter: 50,             // Space between slides in pixels
        keyboard: true,         // Enable keyboard navigation
        arrows: true,           // Display navigation arrows
        infobar: true,          // Display information bar
        smallBtn: false,        // Display small close button
        toolbar: true,          // Display toolbar
        buttons: ['slideShow', 'thumbs', 'close'], // Customize toolbar buttons

        // Animation Options
        animationEffect: 'fade',        // Transition effect
        animationDuration: 500,         // Transition duration in milliseconds
        transitionEffect: 'fade',       // Transition effect between slides
        transitionDuration: 500,        // Transition duration between slides in milliseconds
        slideClass: 'fancybox-slide',   // Custom CSS class for slides
        baseClass: 'fancybox-container', // Custom CSS class for fancybox container

        // Thumbnail Options
        thumbs: {
            autoStart: true,   // Automatically start thumbnail display
            hideOnClose: true, // Hide thumbnails when closing fancybox
            axis: 'y'          // Thumbnail display direction ('x' for horizontal, 'y' for vertical)
        },

       
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

        // Image Options
        protect: true,           // Prevent downloading images
        hideScrollbar: false,    // Hide vertical scrollbar
        clickContent: 'close',   // Action to perform on clicking content area ('close' or 'next')

        // Other Options
        autoFocus: true,         // Autofocus on first visible element when opening fancybox
        backFocus: true,         // Restore focus to the trigger element when closing fancybox
        trapFocus: true,         // Prevent tabbing out of fancybox
        touch: {
            vertical: false,     // Allow vertical swipe
            momentum: true       // Enable momentum scrolling
        },
        hash: false              // Enable URL hash navigation
    });
});

</script>
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <!-- Contenu principal -->
        <div class="single-content">
            <?php
            // Vérifier s'il y a des articles
            if (have_posts()) :
                // Parcourir chaque article
                while (have_posts()) : the_post();
            ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <section class="detail">
                            <div class="detail-photo">
                                <div class="d-photo">
                            <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                                <?php
                                // Afficher la référence
                                $fields = get_fields();
                                if (isset($fields['photo_reference'])) {
                                    echo '<p><strong>Référence : </strong> ' . esc_html($fields['photo_reference']) . '</p>';
                                }
                                // Afficher la catégorie
                                $categories = get_the_terms(get_the_ID(), 'categorie');
                                if ($categories && !is_wp_error($categories)) {
                                    echo '<p><strong>Catégorie : </strong> ';
                                    foreach ($categories as $category) {
                                        echo esc_html($category->name);
                                    }
                                    echo '</p>';
                                    
                                    // Récupérer un ID de catégorie aléatoire
                                    $category_id = $categories[array_rand($categories)]->term_id;
                                    
                                    // Créer une nouvelle requête pour récupérer deux images aléatoires avec la même catégorie
                                    $additional_images_query = new WP_Query(array(
                                        'post_type' => 'photos',
                                        'posts_per_page' => 2,
                                        'post__not_in' => array(get_the_ID()), // Exclure l'image courante
                                        'tax_query' => array(
                                            array(
                                                'taxonomy' => 'categorie',
                                                'field' => 'id',
                                                'terms' => $category_id
                                            )
                                        ),
                                        'orderby' => 'rand' // Ordre aléatoire
                                    ));
                                }
                                // Afficher le format
                                $formats = get_the_terms(get_the_ID(), 'format');
                                if ($formats && !is_wp_error($formats)) {
                                    echo '<p><strong>Format : </strong> ';
                                    foreach ($formats as $format) {
                                        echo esc_html($format->name);
                                    }
                                    echo '</p>';
                                }
                                // Afficher le type
                                if (isset($fields['photo_type'])) {
                                    echo '<p><strong>Type : </strong> ' . esc_html($fields['photo_type']) . '</p>';
                                }
                                // Afficher l'année
                                if (isset($fields['annee'])) {
                                    echo '<p><strong>Année : </strong> ' . esc_html($fields['annee']) . '</p>';
                                }
                                ?>
                                </div>
                            </div>
                            <?php
                            // Afficher la photo mise en avant
                            if (has_post_thumbnail()) {
                                echo '<div class="post-thumbnail">';
                                the_post_thumbnail('large');
                                echo '</div>';
                            }
                            ?>
                        </section>
                        <section class="section-contact">
                            <div class="container-question">
                                <p>Cette photo vous intéresse ?</p>
                                <button id="openModalButton">Contact</button>
                            </div>
                            <!-- Carousel -->
                            <div class="carousel-container">
                                <div class="carousel">
                                    <?php
                                    // Nouvelle WP_Query pour récupérer toutes les images de la galerie
                                    $gallery_query = new WP_Query(array(
                                        'post_type' => 'photos',
                                        'posts_per_page' => -1 // Récupérer toutes les images
                                    ));
                                    if ($gallery_query->have_posts()) {
                                        while ($gallery_query->have_posts()) {
                                            $gallery_query->the_post();
                                            if (has_post_thumbnail()) {
                                                echo '<div class="carousel-item">';
                                                // Ajouter un lien vers la page de détails de l'image
                                                echo '<a href="' . get_permalink() . '">';
                                                the_post_thumbnail('thumbnail');
                                                echo '</a>';
                                                echo '</div>';
                                            }
                                        }
                                        // Réinitialiser la requête WP_Query
                                        wp_reset_postdata();
                                    }
                                    ?>
                                </div>
                                <!-- Ajouter les flèches de navigation -->
                                <div class="container-arrow">
                                    <div class="slick-prev"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/precedent.png'; ?>" alt="Précédent"></div>
                                    <div class="slick-next"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/suivant.png'; ?>" alt="Suivant"></div>
                                </div>
   
                            </div>
                        </section>
                  
                        <?php
                        // Afficher les images supplémentaires
                       // Afficher les images supplémentaires
// Afficher les images supplémentaires
if ($additional_images_query->have_posts()) {
    echo '<h3>Vous aimerez AUSSI</h3>';
    echo '<div class="grid-single">';
    while ($additional_images_query->have_posts()) {
        $additional_images_query->the_post();
        if (has_post_thumbnail()) {
            // Récupérer la catégorie de l'image
            $categories = get_the_terms(get_the_ID(), 'categorie');
            $category_name = !empty($categories) ? esc_html($categories[0]->name) : '';

            // Ajouter un lien vers la page de détails de l'image avec les attributs pour Fancybox
            echo '<div class="item">';
            the_post_thumbnail('large');
            echo '<div class="image-overlay">';
            // Récupérer la référence de la photo
            $photo_reference = get_post_meta(get_the_ID(), 'photo_reference', true);
            echo '<a href="' . get_the_permalink() . '" class="post-permalink">
                    <i class="fas fa-regular fa-eye"></i>
                </a>
                <a class="full-view" href="' . wp_get_attachment_image_src(get_post_thumbnail_id(), 'large')[0] . '" class="lightbox-trigger" data-fancybox="gallery" data-caption="<div class=container-caption><div>' . $photo_reference . '</div> <div> ' . $categories[0]->name . '</div></div> ">
                    <i class="fas fa-expand"></i>
                </a>    
                <div class="info-thumbnail">
                    <div class="image-title">' . get_the_title() . '</div> <!-- Titre de l\'image -->
                    <div class="image-category">' . $categories[0]->name . '</div> <!-- Catégorie de l\'image -->
                </div>';
            echo '</div>
            <span class="annee">' . $annee . '</span>
            </div>';
        }
    }
    echo '</div>';
    // Réinitialiser la requête WP_Query
    wp_reset_postdata();
}


                        ?>
                    </article><!-- #post-<?php the_ID(); ?> -->
            <?php
                endwhile;
            else :
                // Si aucun article n'est trouvé, afficher un message
                echo 'Aucun contenu trouvé.';
            endif;
            ?>
        </div><!-- .single-content -->

      
    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>

<script>
jQuery(document).ready(function($) {
    // Ouvrir la modal lorsque le bouton est cliqué
    $('#openModalButton').click(function(e) {
        e.preventDefault();
        $('#contactModal').fadeIn();
        console.log("La modal est ouverte.");
    });

    // Fermer la modale lorsque l'utilisateur clique en dehors d'elle
    $(document).click(function(event) {
        if (!$(event.target).closest('.modal-content, #openModalButton').length) {
            $('#contactModal').fadeOut();
            console.log("La modal est fermée.");
        }
    });
});



</script>

<!-- Initialisez le carousel dans votre script JavaScript -->
<script>
      jQuery(document).ready(function($) {
        // Initialisez le carousel dans votre script JavaScript
        var carousel = $('.carousel').slick({
            dots: false,
            infinite: true,
            speed: 500,
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false // Désactiver les boutons par défaut
        });

        // Récupérer les flèches personnalisées
        var prevArrow = $('.slick-prev');
        var nextArrow = $('.slick-next');

        // Ajouter les événements de clic aux flèches personnalisées
        prevArrow.click(function() {
            carousel.slick('slickPrev');
        });

        nextArrow.click(function() {
            carousel.slick('slickNext');
        });
    });
</script>

<script>   
    jQuery(document).ready(function($) {
        // Remplir le champ de référence avec la valeur de photo_reference
        var reference = '<?php echo isset($fields['photo_reference']) ? esc_js($fields['photo_reference']) : ''; ?>';
        $('#ref-photo').val(reference); 
    });
</script>
