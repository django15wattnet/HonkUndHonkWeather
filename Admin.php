<?php
/**
 * Plugin Name: Geo Location Multi Admin
 * Description: Administrationsseite mit OpenStreetMap zur Auswahl mehrerer Geo-Standorte.
 * Version: 1.0.0
 * Author: Dein Name
 */

if (!defined('ABSPATH')) {
    exit;
}

class GLA_Geo_Location_Multi_Admin {
    
    const OPTION_NAME = 'gla_multi_geo_locations';
    
    public function __construct() {
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_init', [$this, 'register_settings']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_assets']);
    }
    
    public function add_admin_menu() {
        add_menu_page(
            'Geo Locations',
            'Geo Locations',
            'manage_options',
            'gla-geo-locations',
            [$this, 'render_admin_page'],
            'dashicons-location-alt',
            80
            );
    }
    
    public function register_settings() {
        register_setting(
            'gla_multi_settings_group',
            self::OPTION_NAME,
            [$this, 'sanitize_locations']
            );
    }
    
    public function sanitize_locations($input) {
        $clean = [];
        
        if (!is_array($input)) {
            return $clean;
        }
        
        foreach ($input as $location) {
            if (
                isset($location['lat']) &&
                isset($location['lng']) &&
                is_numeric($location['lat']) &&
                is_numeric($location['lng'])
                ) {
                    $clean[] = [
                        'lat' => floatval($location['lat']),
                        'lng' => floatval($location['lng']),
                    ];
                }
        }
        
        return $clean;
    }
    
    public function enqueue_assets($hook) {
        if ($hook !== 'toplevel_page_gla-geo-locations') {
            return;
        }
        
        wp_enqueue_style(
            'leaflet-css',
            'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css'
            );
        
        wp_enqueue_script(
            'leaflet-js',
            'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js',
            [],
            null,
            true
            );
    }
    
    public function render_admin_page() {
        
        $locations = get_option(self::OPTION_NAME, []);
        $locations_json = esc_js(json_encode($locations));
        ?>

        <div class="wrap">
            <h1>Mehrere Geo-Standorte auswählen</h1>

            <form method="post" action="options.php">
                <?php settings_fields('gla_multi_settings_group'); ?>

                <div id="gla-map" style="height: 500px; margin-bottom:20px;"></div>

                <div id="gla-hidden-fields"></div>

                <?php submit_button(); ?>
            </form>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function () {

            const savedLocations = <?php echo $locations_json; ?>;
            const hiddenContainer = document.getElementById('gla-hidden-fields');

            const map = L.map('gla-map').setView([51.1657, 10.4515], 6);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            let markers = [];

            function renderHiddenFields() {
                hiddenContainer.innerHTML = '';

                markers.forEach((marker, index) => {
                    const pos = marker.getLatLng();

                    hiddenContainer.innerHTML += `
                        <input type="hidden" name="<?php echo self::OPTION_NAME; ?>[${index}][lat]" value="${pos.lat}">
                        <input type="hidden" name="<?php echo self::OPTION_NAME; ?>[${index}][lng]" value="${pos.lng}">
                    `;
                });
            }

            function addMarker(latlng) {
                const marker = L.marker(latlng, { draggable: true }).addTo(map);

                marker.on('dragend', function () {
                    renderHiddenFields();
                });

                marker.on('click', function () {
                    map.removeLayer(marker);
                    markers = markers.filter(m => m !== marker);
                    renderHiddenFields();
                });

                markers.push(marker);
                renderHiddenFields();
            }

            map.on('click', function (e) {
                addMarker(e.latlng);
            });

            // Vorhandene Marker laden
            savedLocations.forEach(loc => {
                addMarker([loc.lat, loc.lng]);
            });

        });
        </script>

        <?php
    }
}

new GLA_Geo_Location_Multi_Admin();