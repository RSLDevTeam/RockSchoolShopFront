<?php
// misc functions

// image sizes
add_image_size( 'square', 500, 500, true );

// close flex content elements when opening page
function my_acf_admin_head() {
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        $('.layout').not('.clones .layout').addClass('-collapsed');
    });
    </script>
    <?php
}
add_action('acf/input/admin_head', 'my_acf_admin_head');