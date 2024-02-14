<?php get_header(); ?>

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
                        <header class="entry-header">
                            <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                        </header><!-- .entry-header -->

                        <div class="entry-content">
                            <?php
                            // Afficher la photo mise en avant
                            if (has_post_thumbnail()) {
                                echo '<div class="post-thumbnail">';
                                the_post_thumbnail('large');
                                echo '</div>';
                            }

                            // Afficher tous les champs personnalisés dans l'ordre spécifié
                            $fields = get_fields();
                            if ($fields) {
                                echo '<div class="custom-fields">';
                                // Afficher la référence
                                if (isset($fields['photo_reference'])) {
                                    echo '<p><strong>Référence : </strong> ' . $fields['photo_reference'] . '</p>';
                                }
                                // Afficher la catégorie
                                $categories = get_the_terms(get_the_ID(), 'categorie');
                                if ($categories && !is_wp_error($categories)) {
                                    echo '<p><strong>Catégorie : </strong> ';
                                    foreach ($categories as $category) {
                                        echo esc_html($category->name);
                                    }
                                    echo '</p>';
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
                                    echo '<p><strong>Type : </strong> ' . $fields['photo_type'] . '</p>';
                                }
                                // Afficher l'année
                                if (isset($fields['annee'])) {
                                    echo '<p><strong>Année : </strong> ' . $fields['annee'] . '</p>';
                                }
                                echo '</div>';
                            }
                            ?>
                        </div><!-- .entry-content -->
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
        // Remplir le champ de référence avec la valeur de photo_reference
        var reference = '<?php echo isset($fields['photo_reference']) ? esc_js($fields['photo_reference']) : ''; ?>';
        $('#ref-photo').val(reference); // Assurez-vous de remplacer #photo-reference-input par l'ID de votre champ d'entrée spécifique
    });
</script>
