<?php

class SPA_Loader {

    public function __construct() {
        // AJAX endpoint
        add_action('wp_ajax_load_content', [$this, 'handle_ajax']);
        add_action('wp_ajax_nopriv_load_content', [$this, 'handle_ajax']);
        
        // Enqueue JS
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
    }

    public function enqueue_scripts() {
        wp_enqueue_script(
            'spa_js',
            get_template_directory_uri() . '/assets/js/ajax-loader.js',
            ['jquery'],
            false,
            true
        );

        wp_localize_script(
            'spa_js',
            'page_loader',
            ['ajax_url' => admin_url('admin-ajax.php')]
        );
    }

    public function handle_ajax() {
        try {
            $type = isset($_POST['type']) ? sanitize_text_field($_POST['type']) : '';
            $id   = isset($_POST['id']) ? intval($_POST['id']) : null;

            if (!$type) throw new Exception('Missing type parameter');

            $html = $this->render_template($type, $id);

            wp_send_json_success(['html' => $html]);

        } catch (Exception $e) {
            wp_send_json_error('Error loading content: ' . $e->getMessage());
        }
    }

    private function render_template($type, $id = null) {
        ob_start();

        switch ($type) {
            case 'home':
                load_template(get_template_directory() . '/pages/home-template.php', false);
                break;


            default:
                throw new Exception('Unknown type: ' . $type);
        }

        return ob_get_clean();
    }
}

new SPA_Loader();
