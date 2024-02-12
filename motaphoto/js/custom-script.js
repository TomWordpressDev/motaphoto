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
