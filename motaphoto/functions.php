<?php
function custom_theme_enqueue_scripts() {
    // Ajout du style du thème parent
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    

    // Enqueue des styles et scripts pour Slick Carousel
    wp_enqueue_style('slick-css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css');
    wp_enqueue_script('slick-js', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js', array('jquery'), null, true);

    // Enqueue des styles et scripts pour FancyBox
    wp_enqueue_style('fancybox-css', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css');
    wp_enqueue_script('fancybox-js', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js', array('jquery'), null, true);

    // Enqueue des styles personnalisés du thème
    wp_enqueue_style('custom-style', get_template_directory_uri() . '/css/styles.css', array('parent-style'), '1.0.0', 'all');

     // Enqueue des scripts personnalisés du thème
    wp_enqueue_script('menus', get_template_directory_uri() . '/js/menus.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('custom-script', get_template_directory_uri() . '/js/custom-script.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('modale', get_template_directory_uri() . '/js/modale.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('filters', get_template_directory_uri() . '/js/filters.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('slider', get_template_directory_uri() . '/js/slider.js', array('jquery'), 'null', true);

}
add_action('wp_enqueue_scripts', 'custom_theme_enqueue_scripts');

// Enregistrer les menus de navigation
function theme_register_menus() {
    register_nav_menus(
        array(
            'primary-menu' => __( 'Primary Menu', 'theme-text-domain' ),
            'footer-menu' => __( 'Footer Menu', 'theme-text-domain' ),            
        )
    );
}
add_action( 'init', 'theme_register_menus' );

// Fonction pour désactiver la mise en cache lors du chargement de la page
add_action('init', 'disable_cache_on_page_load');
function disable_cache_on_page_load() {
    // Envoie des en-têtes HTTP spécifiques pour empêcher la mise en cache
    header('Cache-Control: no-cache, no-store, must-revalidate'); // Indique au navigateur de ne pas mettre en cache la page
    header('Pragma: no-cache'); // Empêche la mise en cache dans certains navigateurs plus anciens
    header('Expires: 0'); // Indique que la page expire immédiatement, évitant ainsi toute mise en cache par les proxies
}


// Gestion de la requête AJAX pour filtrer les images
add_action('wp_ajax_filter_images', 'filter_images');
add_action('wp_ajax_nopriv_filter_images', 'filter_images');
function filter_images() {
    $categorie = $_POST['categorie'];
    $format = $_POST['format'];
    $annee = $_POST['annee'];

    // Préparation des arguments de la requête WP_Query
    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => 8,
        'meta_key' => 'annee', 
        'order' => ($annee == 'asc') ? 'ASC' : 'DESC' // Ordre défini par la sélection de l'utilisateur
    );

    // Filtrage par catégorie si une catégorie est sélectionnée
    if ($categorie != 'all') {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field' => 'slug',
            'terms' => $categorie
        );
    }

    // Filtrage par format si un format est sélectionné
    if ($format != 'all') {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => $format
        );
    }
  // Si l'utilisateur trie par année, afficher toutes les images
  if ($annee == 'asc' || $annee == 'desc') {
    $args['posts_per_page'] = -1;
} else {
    // Sinon, afficher seulement 8 images par page
    $args['posts_per_page'] = 8;
}
    // Exécution de la requête WP_Query
    $query = new WP_Query($args);

    // Affichage des résultats
    if ($query->have_posts()) :
        while ($query->have_posts()) :
            $query->the_post();
            $categories = get_the_terms(get_the_ID(), 'categorie');
            $formats = get_the_terms(get_the_ID(), 'format');
            $annee = get_post_meta(get_the_ID(), 'annee', true); // Récupérer l'année depuis les données de la photo
            ?>

<div class="item <?php foreach ($categories as $categorie) echo $categorie->slug . ' '; foreach ($formats as $format) echo $format->slug . ' '; ?>">
    <?php the_post_thumbnail('full'); ?>
    <div class="image-overlay">
        
        <?php
        // Récupérer la référence de la photo
        $photo_reference = get_post_meta(get_the_ID(), 'photo_reference', true);
        ?>
        
        <a href="<?php the_permalink(); ?>" class="post-permalink">
        <svg width="46" height="32" viewBox="0 0 46 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M45.9081 15.5489C41.9937 6.34547 33.0015 0.398438 23 0.398438C12.9985 0.398438 4.00649 6.34529 0.0919102 15.5489C-0.0306367 15.8369 -0.0306367 16.1622 0.0919102 16.4503C4.00622 25.6548 12.9983 31.6023 23 31.6023C33.0019 31.6023 41.994 25.6548 45.9081 16.4503C46.0306 16.1622 46.0306 15.8369 45.9081 15.5489ZM23 29.2992C14.088 29.2992 6.05933 24.0953 2.40862 15.9997C6.05942 7.90497 14.0883 2.70158 23 2.70158C31.9119 2.70158 39.9407 7.90497 43.5914 15.9995C39.9407 24.0951 31.912 29.2992 23 29.2992Z" fill="white"/>
            <path d="M23 7.17993C18.1364 7.17993 14.1797 11.1367 14.1797 16.0003C14.1797 20.8638 18.1365 24.8206 23 24.8206C27.8635 24.8206 31.8203 20.8639 31.8203 16.0003C31.8203 11.1366 27.8635 7.17993 23 7.17993ZM23 22.5177C19.4064 22.5177 16.4827 19.594 16.4827 16.0004C16.4827 12.4069 19.4064 9.48317 23 9.48317C26.5936 9.48317 29.5173 12.4069 29.5173 16.0004C29.5173 19.594 26.5936 22.5177 23 22.5177Z" fill="white"/>
            <path d="M23 11.3176C20.418 11.3176 18.3171 13.4184 18.3171 16.0006C18.3171 16.6365 18.8325 17.1521 19.4686 17.1521C20.1047 17.1521 20.6201 16.6365 20.6201 16.0006C20.6201 14.6883 21.6877 13.6207 23 13.6207C23.6361 13.6207 24.1515 13.1051 24.1515 12.4692C24.1515 11.8331 23.6359 11.3176 23 11.3176Z" fill="white"/>
        </svg> 
        </a>
        <a class="full-view" href="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id(), 'large')[0]; ?>" class="lightbox-trigger" data-fancybox="gallery" data-caption="<div class=container-caption><div><?php echo $photo_reference; ?></div> <div> <?php echo $categories[0]->name; ?></div></div> ">
        <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="17" cy="17" r="17" fill="black"/>
            <line x1="15" y1="10.5" x2="10" y2="10.5" stroke="white"/>
            <line y1="-0.5" x2="5" y2="-0.5" transform="matrix(-1 8.74227e-08 8.74227e-08 1 15 24)" stroke="white"/>
            <line x1="9.5" y1="16" x2="9.5" y2="10" stroke="white"/>
            <line y1="-0.5" x2="6" y2="-0.5" transform="matrix(4.37114e-08 1 1 -4.37114e-08 10 18)" stroke="white"/>
            <line y1="-0.5" x2="5" y2="-0.5" transform="matrix(1 -8.74227e-08 -8.74227e-08 -1 19 10)" stroke="white"/>
            <line y1="-0.5" x2="6" y2="-0.5" transform="matrix(-4.37114e-08 -1 -1 4.37114e-08 24 16)" stroke="white"/>
            <line x1="19" y1="23.5" x2="24" y2="23.5" stroke="white"/>
            <line x1="24.5" y1="18" x2="24.5" y2="24" stroke="white"/>
        </svg>
        </a>      
        <div class="info-thumbnail">
            <div class="image-title"><?php the_title(); ?></div> <!-- Titre de l'image -->
            <div class="image-category"><?php echo $categories[0]->name; ?></div> <!-- Catégorie de l'image -->
        </div>
        
    </div>
    <span class="annee"><?php echo $annee; ?></span>
</div>


    <?php
        endwhile;
        wp_reset_postdata();
    else :
        echo 'Aucune image trouvée.';
    endif;

    wp_die(); // Important pour terminer la requête AJAX
}

// Charger plus d'images
add_action('wp_ajax_nopriv_load_more_images', 'load_more_images');
add_action('wp_ajax_load_more_images', 'load_more_images');

function load_more_images() {
    $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
    $categorie = isset($_POST['categorie']) ? $_POST['categorie'] : 'all';
    $format = isset($_POST['format']) ? $_POST['format'] : 'all';
    $annee = isset($_POST['annee']) ? $_POST['annee'] : '';
  // Récupérer les IDs des publications déjà chargées
  $excluded_posts = isset($_POST['excluded_posts']) ? $_POST['excluded_posts'] : array();

  // Nettoyer les doublons des IDs des publications déjà chargées
  $excluded_posts = array_unique($excluded_posts);


    // Préparation des arguments de la requête WP_Query
    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => 8,
        'meta_key' => 'annee',
       
        'post__not_in' => $excluded_posts, // Exclure les publications déjà chargées
    );

    // Filtrage par catégorie si une catégorie est sélectionnée
    if ($categorie != 'all') {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field' => 'slug',
            'terms' => $categorie
        );
    }

    // Filtrage par format si un format est sélectionné
    if ($format != 'all') {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => $format
        );
    }


    // Exécution de la requête WP_Query
    $query = new WP_Query($args);

    // Comptage total des images
    $total_images = $query->found_posts;

    // Nouvel offset basé sur le nombre total d'images et l'offset précédent
    $new_offset = $offset + 8;

    // Vérifier si l'offset dépasse le nombre total d'images
    if ($new_offset >= $total_images) {
        $new_offset = $total_images; // Définir l'offset au nombre total d'images si dépassement
    }

    // Mettre à jour l'offset pour la prochaine requête
    $_POST['offset'] = $new_offset;

    // Ajouter les IDs des publications déjà chargées
    foreach ($query->posts as $post) {
        $excluded_posts[] = $post->ID;
    }

    // Ajouter un argument d'offset à la requête
    $args['offset'] = $offset;

    // Exécution de la requête WP_Query avec le nouvel offset
    $query = new WP_Query($args);

    // Affichage des résultats
    if ($query->have_posts()) :
        while ($query->have_posts()) :
            $query->the_post();
            
            // Vérifier si l'ID de la publication fait partie des IDs déjà chargés
            if (!in_array(get_the_ID(), $excluded_posts)) {
                $categories = get_the_terms(get_the_ID(), 'categorie');
                $formats = get_the_terms(get_the_ID(), 'format');
                $annee = get_post_meta(get_the_ID(), 'annee', true);
                ?>
                <div class="item <?php foreach ($categories as $categorie) echo $categorie->slug . ' '; foreach ($formats as $format) echo $format->slug . ' '; ?>">
                    <?php the_post_thumbnail('full'); ?>
                    <div class="image-overlay">
                        
                        <?php
                        // Récupérer la référence de la photo
                        $photo_reference = get_post_meta(get_the_ID(), 'photo_reference', true);
                        ?>
                        
                        <a href="<?php the_permalink(); ?>" class="post-permalink">
                                        <svg width="46" height="32" viewBox="0 0 46 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M45.9081 15.5489C41.9937 6.34547 33.0015 0.398438 23 0.398438C12.9985 0.398438 4.00649 6.34529 0.0919102 15.5489C-0.0306367 15.8369 -0.0306367 16.1622 0.0919102 16.4503C4.00622 25.6548 12.9983 31.6023 23 31.6023C33.0019 31.6023 41.994 25.6548 45.9081 16.4503C46.0306 16.1622 46.0306 15.8369 45.9081 15.5489ZM23 29.2992C14.088 29.2992 6.05933 24.0953 2.40862 15.9997C6.05942 7.90497 14.0883 2.70158 23 2.70158C31.9119 2.70158 39.9407 7.90497 43.5914 15.9995C39.9407 24.0951 31.912 29.2992 23 29.2992Z" fill="white"/>
                                            <path d="M23 7.17993C18.1364 7.17993 14.1797 11.1367 14.1797 16.0003C14.1797 20.8638 18.1365 24.8206 23 24.8206C27.8635 24.8206 31.8203 20.8639 31.8203 16.0003C31.8203 11.1366 27.8635 7.17993 23 7.17993ZM23 22.5177C19.4064 22.5177 16.4827 19.594 16.4827 16.0004C16.4827 12.4069 19.4064 9.48317 23 9.48317C26.5936 9.48317 29.5173 12.4069 29.5173 16.0004C29.5173 19.594 26.5936 22.5177 23 22.5177Z" fill="white"/>
                                            <path d="M23 11.3176C20.418 11.3176 18.3171 13.4184 18.3171 16.0006C18.3171 16.6365 18.8325 17.1521 19.4686 17.1521C20.1047 17.1521 20.6201 16.6365 20.6201 16.0006C20.6201 14.6883 21.6877 13.6207 23 13.6207C23.6361 13.6207 24.1515 13.1051 24.1515 12.4692C24.1515 11.8331 23.6359 11.3176 23 11.3176Z" fill="white"/>
                                        </svg> 
                                        </a>
                                        <a class="full-view" href="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id(), 'large')[0]; ?>" class="lightbox-trigger" data-fancybox="gallery" data-caption="<div class=container-caption><div><?php echo $photo_reference; ?></div> <div> <?php echo $categories[0]->name; ?></div></div> ">
                                        <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="17" cy="17" r="17" fill="black"/>
                                            <line x1="15" y1="10.5" x2="10" y2="10.5" stroke="white"/>
                                            <line y1="-0.5" x2="5" y2="-0.5" transform="matrix(-1 8.74227e-08 8.74227e-08 1 15 24)" stroke="white"/>
                                            <line x1="9.5" y1="16" x2="9.5" y2="10" stroke="white"/>
                                            <line y1="-0.5" x2="6" y2="-0.5" transform="matrix(4.37114e-08 1 1 -4.37114e-08 10 18)" stroke="white"/>
                                            <line y1="-0.5" x2="5" y2="-0.5" transform="matrix(1 -8.74227e-08 -8.74227e-08 -1 19 10)" stroke="white"/>
                                            <line y1="-0.5" x2="6" y2="-0.5" transform="matrix(-4.37114e-08 -1 -1 4.37114e-08 24 16)" stroke="white"/>
                                            <line x1="19" y1="23.5" x2="24" y2="23.5" stroke="white"/>
                                            <line x1="24.5" y1="18" x2="24.5" y2="24" stroke="white"/>
                                        </svg>
                                        </a>      
                        <div class="info-thumbnail">
                            <div class="image-title"><?php the_title(); ?></div> <!-- Titre de l'image -->
                            <div class="image-category"><?php echo $categories[0]->name; ?></div> <!-- Catégorie de l'image -->
                        </div>
                        
                    </div>
                    <span class="annee"><?php echo $annee; ?></span>
                </div>
                <?php
            }
        endwhile;
        wp_reset_postdata();
    else :
        echo 'Aucune nouvelle image disponible.'; // Affiche un message si aucune nouvelle image n'est disponible
    endif;

    wp_die();
}




function get_random_gallery_image_url() {
    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => 1, // Récupérer une seule image aléatoire
        'orderby' => 'rand' // Ordonner de manière aléatoire
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        $query->the_post();
        return get_the_post_thumbnail_url(get_the_ID(), 'full');
    }

    // Si aucune image n'est trouvée, retourner une image de remplacement par défaut
    return get_stylesheet_directory_uri() . '/assets/header-image.png';
}

