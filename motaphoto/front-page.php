<?php
$categories = get_terms('categorie');
$formats = get_terms('format');
?>

<?php get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <header class="hero-header">
            <img class="header-image" src="<?php echo get_random_gallery_image_url(); ?>" >
            <img class="header-title" src="<?php echo get_stylesheet_directory_uri() . '/assets/titre-header.png'; ?>" alt="titre header">
        </header>
        
        <div class="filters-container">
            <div class="dropdown">
        <button class="dropdown-toggle" id="dropdownMenuButton">
        <span class="button-text">Catégories</span>
            <span class="arrow"><img class="chevron" src="<?php echo get_stylesheet_directory_uri() . '/assets/chevron.png'; ?>" alt="chevron"></span>
        </button>
        <div class="dropdown-content" id="dropdownContent">
            <div class="filters" id="filter-categorie">
                <div class="filter" data-value="all">CATEGORIES</div>
                <?php foreach ($categories as $categorie) : ?>
                    <div class="filter" data-value="<?php echo $categorie->slug; ?>"><?php echo $categorie->name; ?></div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>



    <div class="dropdown" id="filter-format">
        <button class="dropdown-toggle" id="dropdownMenuButton2">
            <span class="button-text">Formats</span>
            <span class="arrow"><img class="chevron2" src="<?php echo get_stylesheet_directory_uri() . '/assets/chevron.png'; ?>" alt="chevron"></span>
        </button>
        <div class="dropdown-content" id="dropdownContent2">
            <div class="filters" id="filter-format">
                <div class="filter" data-value="all">FORMATS</div>
                <?php foreach ($formats as $format) : ?>
                    <div class="filter" data-value="<?php echo $format->slug; ?>"><?php echo $format->name; ?></div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="dropdown">
        <button class="dropdown-toggle" id="dropdownMenuButton3">
            <span class="button-text">Trier par</span>
            <span class="arrow"><img class="chevron3" src="<?php echo get_stylesheet_directory_uri() . '/assets/chevron.png'; ?>" alt="chevron">
            </span>
        </button>
        <div class="dropdown-content" id="dropdownContent3">

            <div class="filters" id="filter-annee">
                <div class="filter" data-value="">TRIER PAR</div>
                <div class="filter" data-value="asc">A partir des plus anciennes</div>
                <div class="filter" data-value="desc">A partir des plus récentes</div>
            </div>
        </div>
        </div>
        </div>
            <div class="main-filters-container">
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
jQuery(document).ready(function($) {
    // Ajouter ou supprimer la classe de sélection lorsque le filtre est cliqué
    $('.filter').on('click', function() {
        // Supprimer la classe de sélection de tous les filtres et réinitialiser les couleurs de fond et de texte
        $('.filter').removeClass('selected').css({
            'background-color': '#fff',
            'color': '#000'
        });
        // Ajouter la classe de sélection au filtre cliqué et changer la couleur de fond et de texte
        $(this).addClass('selected').css({
            'background-color': '#E00000',
            'color': '#fff'
        });
        
        // Récupérer la valeur du filtre sélectionné
        var value = $(this).data('value');
        // Mettre en œuvre le filtrage en fonction de la valeur sélectionnée
        console.log("Filtrage avec la valeur :", value);
    });
});


</script>
<script>
    jQuery(document).ready(function($) {
    // Gérer l'ouverture/fermeture du menu et la rotation du chevron
    $('#dropdownMenuButton').on('click', function() {
        $(this).toggleClass('opened'); // Ajouter/retirer la classe 'opened' au bouton
        $('.chevron').toggleClass('rotate-chevron'); // Ajouter/retirer la classe de rotation au chevron
    });
});

</script>
<script>
    jQuery(document).ready(function($) {
    // Gérer l'ouverture/fermeture du menu et la rotation du chevron
    $('#dropdownMenuButton2').on('click', function() {
        $(this).toggleClass('opened'); // Ajouter/retirer la classe 'opened' au bouton
        $('.chevron2').toggleClass('rotate-chevron'); // Ajouter/retirer la classe de rotation au chevron
    });
});

</script>
<script>
    jQuery(document).ready(function($) {
    // Gérer l'ouverture/fermeture du menu et la rotation du chevron
    $('#dropdownMenuButton3').on('click', function() {
        $(this).toggleClass('opened'); // Ajouter/retirer la classe 'opened' au bouton
        $('.chevron3').toggleClass('rotate-chevron'); // Ajouter/retirer la classe de rotation au chevron
    });
});

</script>
<script>
jQuery(document).ready(function($) {
    // Mettre à jour le texte du toggle lorsqu'une catégorie est sélectionnée
    $('#categorie').on('change', function() {
        var selectedCategory = $(this).find('option:selected').text();
        var chevronImage = '<?php echo get_stylesheet_directory_uri() . '/assets/chevron.png'; ?>'; // Chemin de l'image du chevron
        $('#dropdownMenuButton .button-text').text(selectedCategory);
        $('#dropdownMenuButton .dropdown-image').attr('src', chevronImage);
    });
});

</script>
<script>
jQuery(document).ready(function($) {
    // Mettre à jour le texte du toggle lorsqu'une catégorie est sélectionnée
    $('#format').on('change', function() {
        var selectedCategory = $(this).find('option:selected').text();
        var chevronImage = '<?php echo get_stylesheet_directory_uri() . '/assets/chevron.png'; ?>'; // Chemin de l'image du chevron
        $('#dropdownMenuButton2 .button-text').text(selectedCategory);
        $('#dropdownMenuButton2 .dropdown-image').attr('src', chevronImage);
    });
});
</script>
<script>
jQuery(document).ready(function($) {
    // Mettre à jour le texte du toggle lorsqu'une catégorie est sélectionnée
    $('#annee').on('change', function() {
        var selectedCategory = $(this).find('option:selected').text();
        var chevronImage = '<?php echo get_stylesheet_directory_uri() . '/assets/chevron.png'; ?>'; // Chemin de l'image du chevron
        $('#dropdownMenuButton3 .button-text').text(selectedCategory);
        $('#dropdownMenuButton3 .dropdown-image').attr('src', chevronImage);
    });
});
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
  var dropdownMenuButton = document.getElementById("dropdownMenuButton");
  var dropdownContent = document.getElementById("dropdownContent");

  dropdownMenuButton.addEventListener("click", function() {
    dropdownContent.classList.toggle("show");
    dropdownMenuButton.classList.toggle("opened");
  });

  // Fermer le menu déroulant si l'utilisateur clique en dehors
  window.addEventListener("click", function(event) {
    if (!event.target.matches('.dropdown-toggle')) {
      var dropdowns = document.getElementsByClassName("dropdown-content");
      for (var i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        var dropdownButton = openDropdown.previousElementSibling;
        if (openDropdown.classList.contains('show')) {
          openDropdown.classList.remove('show');
          dropdownButton.classList.remove('opened');
        }
      }
    }
  });

  // Ajouter un écouteur d'événement pour les filtres
  var filters = document.querySelectorAll('.filter');
  filters.forEach(function(filter) {
    filter.addEventListener('click', function() {
      var value = this.getAttribute('data-value');
      // Mettre en œuvre le filtrage en fonction de la valeur sélectionnée
      console.log("Filtrage avec la valeur :", value);
    });
  });
});

</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    var dropdownMenuButton = document.getElementById("dropdownMenuButton2");
    var dropdownContent = document.getElementById("dropdownContent2");

    dropdownMenuButton.addEventListener("click", function() {
    dropdownContent.classList.toggle("show");
    dropdownMenuButton.classList.toggle("opened");
});

// Fermer le menu déroulant si l'utilisateur clique en dehors
window.addEventListener("click", function(event) {
if (!event.target.matches('.dropdown-toggle2')) {
    var dropdowns = document.getElementsByClassName("dropdown-content2");
    for (var i = 0; i < dropdowns.length; i++) {
    var openDropdown = dropdowns[i];
    var dropdownButton = openDropdown.previousElementSibling;
    if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
        dropdownButton.classList.remove('opened');
    }
    }
}
});

  // Ajouter un écouteur d'événement pour les filtres
  var filters = document.querySelectorAll('.filter');
  filters.forEach(function(filter) {
    filter.addEventListener('click', function() {
      var value = this.getAttribute('data-value');
      // Mettre en œuvre le filtrage en fonction de la valeur sélectionnée
      console.log("Filtrage avec la valeur :", value);
    });
  });
});

</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
  var dropdownMenuButton = document.getElementById("dropdownMenuButton3");
  var dropdownContent = document.getElementById("dropdownContent3");

  dropdownMenuButton.addEventListener("click", function() {
    dropdownContent.classList.toggle("show");
    dropdownMenuButton.classList.toggle("opened");
  });

  // Fermer le menu déroulant si l'utilisateur clique en dehors
  window.addEventListener("click", function(event) {
    if (!event.target.matches('.dropdown-toggle3')) {
      var dropdowns = document.getElementsByClassName("dropdown-content3");
      for (var i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        var dropdownButton = openDropdown.previousElementSibling;
        if (openDropdown.classList.contains('show')) {
          openDropdown.classList.remove('show');
          dropdownButton.classList.remove('opened');
        }
      }
    }
  });

  // Ajouter un écouteur d'événement pour les filtres
  var filters = document.querySelectorAll('.filter');
  filters.forEach(function(filter) {
    filter.addEventListener('click', function() {
      var value = this.getAttribute('data-value');
      // Mettre en œuvre le filtrage en fonction de la valeur sélectionnée
      console.log("Filtrage avec la valeur :", value);
    });
  });
});

</script>
<script>
    // Synchronisation des filtres select et div
$('.filter').on('click', function() {
    var value = $(this).data('value');
    var id = $(this).parent().attr('id').replace('filter-', ''); // Récupérer l'ID du filtre
    $('#' + id).val(value).trigger('change'); // Mettre à jour le select correspondant
});

</script>
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
