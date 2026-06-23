<?php
class ApiLoader {
    public static function init() {
        $files = [];
        // Load all helper functions
        foreach (glob(get_template_directory() . '/apis/helpers/*.php') as $file) {
          require_once $file;
        }

        // Load all REST API endpoints
        foreach (glob(get_template_directory() . '/apis/endpoints/*.php') as $file) {
          require_once $file;
        }
    }
}

// Hook into init
add_action('rest_api_init', ['ApiLoader', 'init']);
