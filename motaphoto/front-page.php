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

        <div class="filters">
            <select id="categorie" class="filter">
                <option value="all">CATEGORIES</option>
                <?php foreach ($categories as $categorie) : ?>
                    <option value="<?php echo $categorie->slug; ?>"><?php echo $categorie->name; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="filters">
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
                                <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('large'); ?></a>
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
</div>

<?php get_footer(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    jQuery(document).ready(function($) {
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
    });
    jQuery(document).ready(function($) {
    var offset = 8;

    $('#load-more').on('click', function() {
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'load_more_images',
                offset: offset,
            },
            success: function(response) {
                if (response != '') {
                    $('.grid').append(response);
                    offset += 8;
                } else {
                    $('#load-more').hide(); // Masquer le bouton "Charger plus" s'il n'y a pas de nouvelles images disponibles
                }
            }
        });
    });
});

</script>
