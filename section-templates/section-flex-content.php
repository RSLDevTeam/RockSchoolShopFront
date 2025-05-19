<?php
/**
* Flexible Content (ACF 'page builder')
*
* @package understrap
*/
 
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
 
$acf_json_path = get_template_directory() . '/acf-json';

$flex_index = 1;

// Check value exists.
if( have_rows('flexible_elements') ):

    // Loop through rows.
    while ( have_rows('flexible_elements') ) : the_row();
    
        if (is_dir($acf_json_path)) {
            $files = scandir($acf_json_path);
            foreach ($files as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) === 'json') {
                    $json_data = json_decode(file_get_contents($acf_json_path . '/' . $file), true);
                    if (isset($json_data['title']) && $json_data['title'] === 'Flexible content') {
                        if (isset($json_data['fields'])) {
                            foreach ($json_data['fields'] as $field) {
                                if (isset($field['layouts'])) {
                                    foreach ($field['layouts'] as $layout) {
                                        $flexible_content_layouts[] = $layout['name'];
                                        $layout = $layout['name'];
                                        if (get_row_layout() === $layout) {
                                            $sub_template_path = get_template_directory() . '/flex-sub-content/' . $layout . '.php';
                                            if (file_exists($sub_template_path)) {
                                                include $sub_template_path;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $flex_index ++;
    

    endwhile;

endif;
?>


