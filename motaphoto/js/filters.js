jQuery(document).ready(function($) {
    // Fonction pour appliquer la sélection des filtres à tous les éléments
    function applyFilters() {
        $('.filter').each(function() {
            var value = $(this).data('value');
            if ($(this).hasClass('selected')) {
                $(this).css({
                    'background-color': '#E00000',
                    'color': '#fff'
                });
            } else {
                $(this).css({
                    'background-color': '#fff',
                    'color': '#000'
                });
            }
        });

        // Filtrer les éléments en fonction des filtres sélectionnés
        var selectedValues = $('.filter.selected').map(function() {
            return $(this).data('value');
        }).get();

        if (selectedValues.length > 0) {
            $('.item').hide(); // Masquer tous les éléments
            for (var i = 0; i < selectedValues.length; i++) {
                var value = selectedValues[i];
                $('.item.' + value).show(); // Afficher les éléments correspondant à chaque filtre sélectionné
            }
        } else {
            $('.item').show(); // Si aucun filtre n'est sélectionné, afficher tous les éléments
        }
    }

    // Gérer le clic sur un filtre
    $('.filter').on('click', function() {
        var value = $(this).data('value');
        
        // Désélectionner tous les autres filtres du même groupe
        var group = $(this).parent().attr('id');
        $('#' + group + ' .filter').removeClass('selected');

        // Sélectionner le filtre actuel
        $(this).addClass('selected');

        // Appliquer les filtres
        applyFilters();
    });

    // Initialiser les filtres au chargement de la page
    applyFilters();
});


document.addEventListener("DOMContentLoaded", function() {
    initializeDropdown("dropdownMenuButton", "dropdownContent", "Catégories", "chevron");
    initializeDropdown("dropdownMenuButton2", "dropdownContent2", "FORMATS", "chevron2");
    initializeDropdown("dropdownMenuButton3", "dropdownContent3", "TRIER PAR", "chevron3");
  
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
  
  function initializeDropdown(buttonId, contentId, defaultText, chevronClass) {
    var dropdownMenuButton = document.getElementById(buttonId);
    var dropdownContent = document.getElementById(contentId);
  
    dropdownMenuButton.addEventListener("click", function(event) {
      event.stopPropagation(); // Empêcher la propagation du clic pour éviter la fermeture du menu lors du clic sur le bouton
      // Vérifier si le dropdown-content est visible
      if ($('#' + contentId).is(':visible')) {
        // Si le dropdown-content est visible, remettre le chevron à sa rotation initiale
        $('.' + chevronClass).removeClass('rotate-chevron');
        // Mettre le texte du toggle au choix sélectionné ou au texte par défaut si aucun choix n'a été fait
        var selectedCategory = $('#' + contentId + ' .selected').text();
        $('#' + buttonId + ' .button-text').text(selectedCategory !== "" ? selectedCategory : defaultText);
      } else {
        // Sinon, appliquer la rotation normale au chevron
        $('.' + chevronClass).addClass('rotate-chevron');
        // Mettre le texte du toggle au texte par défaut
        $('#' + buttonId + ' .button-text').text(defaultText);
      }
      // Toggle de la visibilité du dropdown-content
      $('#' + contentId).toggle();
      // Toggle de la classe 'opened' sur le bouton
      $(this).toggleClass('opened');
    });
  
    // Fermer le menu déroulant si l'utilisateur clique en dehors
    window.addEventListener("click", function(event) {
      if (!event.target.closest('.dropdown-toggle')) {
        // Vérifier si un choix a été fait
        var selectedCategory = $('#' + contentId + ' .selected').text();
        if (selectedCategory !== "") {
          // Afficher le choix sélectionné dans le bouton
          $('#' + buttonId + ' .button-text').text(selectedCategory);
        }
        $('#' + contentId).hide(); // Cacher le menu déroulant
        $('#' + buttonId).removeClass('opened'); // Retirer la classe 'opened' du bouton
        $('.' + chevronClass).removeClass('rotate-chevron'); // Remettre le chevron à sa rotation initiale
      }
    });
  }

// Modification du nom des menus lorsqu'il son ouvert
// Fonction pour gérer les événements de clic sur les menus déroulants
function handleDropdownClick(contentId, buttonId, chevronClass) {
    $(document).ready(function($) {
        $('#' + contentId + ' .dropdown-item').on('click', function() {
            // Retirer la classe 'selected' des autres éléments et l'ajouter à l'élément sélectionné
            $('#' + contentId + ' .dropdown-item').removeClass('selected');
            $(this).addClass('selected');
            // Mettre le texte du toggle au choix sélectionné
            var selectedCategory = $(this).text();
            $('#' + buttonId + ' .button-text').text(selectedCategory); // Modifier uniquement ce bouton
            // Fermer le menu
            $('#' + contentId).hide();
            $('#' + buttonId).removeClass('opened');
            // Remettre le chevron à sa rotation initiale
            $('.' + chevronClass).removeClass('rotate-chevron');
        });
    });
}

// Appeler la fonction handleDropdownClick pour chaque menu déroulant
handleDropdownClick("dropdownContent", "dropdownMenuButton", "chevron");
handleDropdownClick("dropdownContent2", "dropdownMenuButton2", "chevron2");
handleDropdownClick("dropdownContent3", "dropdownMenuButton3", "chevron3");


