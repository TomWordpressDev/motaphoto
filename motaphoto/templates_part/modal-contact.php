<!-- /templates_part/modal-contact.php -->
<div id="contactModal" class="modal">
    <div class="modal-content">
    <img class="contact-image" src=<?php echo get_stylesheet_directory_uri() . '/assets/contact-image.png'; ?> >
    <?php    
		// Insertion du formulaire de demandes de renseignements
		echo do_shortcode('[contact-form-7 id="ed8df6a" title="Formulaire de la modale"]');		
    ?>
    </div>
</div>
