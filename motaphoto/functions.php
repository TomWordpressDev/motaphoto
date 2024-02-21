<?php
function custom_theme_enqueue_scripts() {
    // Ajout du style du thème parent
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');

    // Ajout du style personnalisé généré à partir de Sass, dépendant du style du thème parent
    wp_enqueue_style('custom-style', get_template_directory_uri() . '/css/styles.css', array('parent-style'), '1.0.0', 'all');

    wp_enqueue_script('custom-script', get_template_directory_uri() . '/js/custom-script.js', array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'custom_theme_enqueue_scripts');

// Enregistrer les menus de navigation
function theme_register_menus() {
    register_nav_menus(
        array(
            'primary-menu' => __( 'Primary Menu', 'theme-text-domain' ),
            // Vous pouvez ajouter plus d'emplacements de menu au besoin
        )
    );
}
add_action( 'init', 'theme_register_menus' );


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
        'posts_per_page' => -1,
        'meta_key' => 'annee',
        'orderby' => 'meta_value_num',
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
            <i class="fas fa-regular fa-eye"></i>
        </a>
        <a class="full-view" href="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id(), 'large')[0]; ?>" class="lightbox-trigger" data-fancybox="gallery" data-caption="<div class=container-caption><div><?php echo $photo_reference; ?></div> <div> <?php echo $categories[0]->name; ?></div></div> ">
            <i class="fas fa-expand"></i>
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

    // Préparation des arguments de la requête WP_Query
    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => 8,
        'meta_key' => 'annee',
        'orderby' => 'meta_value_num',
        'order' => 'ASC'
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

    // Filtrage par année si une année est sélectionnée
    if (!empty($annee)) {
        // Ajoutez votre logique pour le filtrage par année si nécessaire
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

    // Ajouter un argument d'offset à la requête
    $args['offset'] = $offset;

    // Exécution de la requête WP_Query avec le nouvel offset
    $query = new WP_Query($args);

    // Affichage des résultats
    if ($query->have_posts()) :
        while ($query->have_posts()) :
            $query->the_post();
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
            <i class="fas fa-regular fa-eye"></i>
        </a>
        <a class="full-view" href="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id(), 'large')[0]; ?>" class="lightbox-trigger" data-fancybox="gallery" data-caption="<div class=container-caption><div><?php echo $photo_reference; ?></div> <div> <?php echo $categories[0]->name; ?></div></div> ">
            <i class="fas fa-expand"></i>
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

