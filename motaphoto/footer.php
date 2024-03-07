<?php wp_footer(); ?>
<?php include get_template_directory() . '/templates_part/modal-contact.php'; ?>
  <footer class="footer">
        <nav class="footer__nav">   
            <ul>
                <?php    
                // Utilisation d'un menu déroulant simulant un menu burger
                    $menu_items = wp_get_nav_menu_items('footer-menu');
                    if ($menu_items) {
                        foreach ($menu_items as $item) {
                            echo '<li class="menu-item"><a href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a></li>';
                        }
                    }
                ?> 
            </ul>           
        </nav>
    </footer> 
</body>
</html>