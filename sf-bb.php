<?php
/*
Plugin Name: Search&Filter - Beaver Builder
Description: Integration of Search & Filter and Beaver Builder
Version: 1.1
Author: Dean Cleave-Smith
GitHub Plugin URI: https://github.com/deancs/sf-bb-plugin
*/

defined( 'ABSPATH' ) or exit;
define( 'SFBB_PATH', plugin_dir_path( __FILE__ ) );

class SFBB_Integration {

    private $grids;
    private $settings;
    private static $instance;


    function __construct() {

	add_action( 'init', array( $this, 'register_modules' ), 30 );
        add_action( 'fl_builder_loop_before_query', array( $this, 'store_module_settings' ) );

        add_filter( 'fl_builder_render_settings_field', array( $this, 'add_source' ), 10, 2 );
        add_filter( 'fl_builder_loop_query_args', array( $this, 'loop_query_args' ) );
    }


    public static function init() {
        if ( ! isset( self::$instance ) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    function register_modules() {
        $this->grids = array();

        if ( class_exists( 'FLBuilderModule' ) ) {
            include_once SFBB_PATH . 'modules/widget/class-widget.php';
		}
    }

    /**
     * Add S&F widgets to the "data source" dropdown
     */
    function add_source( $field, $name ) {
        if ( 'data_source' === $name ) {

	    $templates = $this->get_sf_widgets();

            foreach ( $templates as $template ) {
                $field['options'][ 'sf/' . $template['id'] ] = 'S&F: ' . $template['title'].'('.$template['id'].')';
            }
        }

        return $field;
    }


    /**
     * Override query arguments
     */
    function loop_query_args( $query_vars ) {

        // Exit if not the builder
        if ( empty( $query_vars['fl_builder_loop' ] ) ) {
            return $query_vars;
        }

        $is_enabled = true;
        $source = isset( $this->settings->data_source ) ? $this->settings->data_source : '';
        $is_sf_query = ( 0 === strpos( $source, 'sf/' ) );

        if ( $is_enabled || $is_sf_query ) {
            if ( $is_sf_query ) {

		    $sfid = substr($source, strpos($source, "/") + 1);
		    $query_vars['search_filter_id'] = $sfid;
            }

        	// Set paged and offset
		   if(isset($_GET['sf_paged'])){
		   		global $wp_the_query;
				$wp_the_query->set('paged',$_GET['sf_paged']);
	   		}

        }

        return $query_vars;
    }


    /**
     * Return array of configured search&filter widgets
     *
     */

    function get_sf_widgets() {

	$sfposts = array();

	$sf_args = array(
		"post_type" => "search-filter-widget",
		"post_status" => "publish",
		"posts_per_page" =>  -1
	);

	$sf_query = new WP_Query($sf_args);

       if ($sf_query->have_posts() ):
                while ($sf_query->have_posts()) : $sf_query->the_post();

			$pid = get_the_ID();
                        $sfposts[] = array('id' => $pid,'title' => get_the_title($pid) );

                endwhile;
        endif;

	return $sfposts;

    }
    /**
     * Use this hook since the "fl_builder_loop_query_args" hook
     * doesn't pass the $settings object
     */
    function store_module_settings( $settings ) {
        $this->settings = $settings;
    }


}

SFBB_Integration::init();
