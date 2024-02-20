<?php
$categories = get_terms('categorie');
$formats = get_terms('format');
?>

<?php get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <header class="hero-header">
            <img class="header-image" src="<?php echo get_random_gallery_image_url(); ?>" >
        </header>
       
            <div class="filters-container">
                <div class="filters">
                    <select id="categorie" class="filter">
                        <option value="all">CATEGORIES</option>
                        <?php foreach ($categories as $categorie) : ?>
                            <option value="<?php echo $categorie->slug; ?>"><?php echo $categorie->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="filters" id="filter-format">
                    <select id="format" class="filter">
                        <option value="all">FORMATS</option>
                        <?php foreach ($formats as $format) : ?>
                            <option value="<?php echo $format->slug; ?>"><?php echo $format->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="filters">          
                    <select id="annee" class="filter">
                        <option value="">TRIER PAR</option>
                        <option value="asc">A partir des plus anciennes</option>
                        <option value="desc">A partir des plus récentes</option>
                    </select>
                </div>
            </div>
            <div class="gallery-container">
                <div class="grid">
                    <?php
                    function display_gallery() {
                        global $categories, $formats;

                        $args = array(
                            'post_type' => 'photos',
                            'posts_per_page' => 8,
                            'meta_key' => 'annee',
                            'orderby' => 'meta_value_num',
                            'order' => 'ASC'
                        );

                        $query = new WP_Query($args);

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
        <span class="image-title"><?php the_title(); ?></span> <!-- Titre de l'image -->
        <span class="image-category"><?php echo $categories[0]->name; ?></span> <!-- Catégorie de l'image -->
        <a href="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id(), 'large')[0]; ?>" class="lightbox-trigger" data-fancybox="gallery">
            <i class="fas fa-expand"></i>
        </a>
        <a href="<?php the_permalink(); ?>" class="post-permalink">
            <i class="fas fa-regular fa-eye"></i>
        </a>
    </div>
    <span class="annee"><?php echo $annee; ?></span>
</div>

                                <?php
                            endwhile;
                            wp_reset_postdata();
                        else :
                            echo 'Aucune image trouvée.';
                        endif;
                    }

                    display_gallery();
                    ?>
                </div>
            </div>

            <button id="load-more">Charger plus</button>
            
    </main>


<?php get_footer(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>

<script>
    // /js/scripts.js
jQuery(document).ready(function($) {
    // Fermer la modale lorsque l'utilisateur clique en dehors d'elle
    $(document).click(function(event) {
        if ($(event.target).closest('.modal-content').length === 0) {
            $('#contactModal').fadeOut();
        }
    });
});
jQuery(document).ready(function($) {
  console.log("Script executed!")
  
});
</script>
<script>
    jQuery(document).ready(function($) {
        // Réinitialiser les valeurs par défaut des sélecteurs
        $('#categorie').val('all');
        $('#format').val('all');
        $('#annee').val('');

        // Fonction pour filtrer les images
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
            // Réinitialiser Fancybox pour les nouvelles images
            $('.grid item').attr('data-fancybox', 'gallery');
            $('.grid item').fancybox({
                // Options éventuelles de Fancybox
            });
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
    if (response != '') {
        $('.grid').append(response);
        offset += 8;
        // Réinitialiser Fancybox pour les nouvelles images
        $('.grid item').each(function() {
            $(this).attr('data-fancybox', 'gallery');
        });
        // Mise à jour de l'attribut data-fancybox pour les nouvelles images
        $('.grid item').fancybox({
            // Options éventuelles de Fancybox
        });
    } else {
        $('#load-more').hide(); // Masquer le bouton "Charger plus" s'il n'y a pas de nouvelles images disponibles
    }
}




            });
        });
    });
</script>
