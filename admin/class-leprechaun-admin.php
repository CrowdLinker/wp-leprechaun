<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://crowdlinker.com
 * @since      1.0.0
 *
 * @package    Leprechaun
 * @subpackage Leprechaun/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Leprechaun
 * @subpackage Leprechaun/admin
 * @author     Crowdlinker <dev@crowdlinker.com>
 */
class Leprechaun_Admin {

	const FACEBOOK_THUMBNAIL_SIZES = [
		'width' => 1200,
		'height' => 1200,
	];

	const TWITTER_THUMBNAIL_SIZES = [
		'width' => 1200,
		'height' => 1200,
	];

	const PREFIX = 'wp_lp_';

	const IMAGE_SIZES = self::PREFIX.'image_sizes';

	const POST_TYPES = self::PREFIX.'post_types';

	const DEFAULT_BG = self::PREFIX.'default_bg';

	const TEMPLATE_POST_TYPE = self::PREFIX.'template';

	const TEMPLATE_CANVAS = self::PREFIX.'template_canvas';

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/leprechaun-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'dist/leprechaun-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register templates post type
	 */
	public function register_templates_post_type() {
		$labels = array(
			'name'                  => _x( 'Templates', 'Post type general name', 'leprechaun' ),
			'singular_name'         => _x( 'Template', 'Post type singular name', 'leprechaun' ),
			'menu_name'             => _x( 'Templates', 'Admin Menu text', 'leprechaun' ),
			'name_admin_bar'        => _x( 'Template', 'Add New on Toolbar', 'leprechaun' ),
			'add_new'               => __( 'Add New', 'leprechaun' ),
			'add_new_item'          => __( 'Add New Template', 'leprechaun' ),
			'new_item'              => __( 'New Template', 'leprechaun' ),
			'edit_item'             => __( 'Edit Template', 'leprechaun' ),
			'view_item'             => __( 'View Template', 'leprechaun' ),
			'all_items'             => __( 'All Templates', 'leprechaun' ),
			'search_items'          => __( 'Search Templates', 'leprechaun' ),
			'parent_item_colon'     => __( 'Parent Templates:', 'leprechaun' ),
			'not_found'             => __( 'No templates found.', 'leprechaun' ),
			'not_found_in_trash'    => __( 'No templates found in Trash.', 'leprechaun' ),
			'featured_image'        => _x( 'Template Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'leprechaun' ),
			'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'leprechaun' ),
			'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'leprechaun' ),
			'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'leprechaun' ),
			'archives'              => _x( 'Template archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'leprechaun' ),
			'insert_into_item'      => _x( 'Insert into template', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'leprechaun' ),
			'uploaded_to_this_item' => _x( 'Uploaded to this template', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'leprechaun' ),
			'filter_items_list'     => _x( 'Filter templates list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'leprechaun' ),
			'items_list_navigation' => _x( 'Templates list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'leprechaun' ),
			'items_list'            => _x( 'Templates list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'leprechaun' ),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'template' ),
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title'),
		);

		register_post_type( self::TEMPLATE_POST_TYPE, $args );
	}

	function add_menu_item() {
        //add a new menu item. This is a top level menu item i.e., this menu item can have sub menus
        add_management_page(
            'Leprechaun', //Required. Text in browser title bar when the page associated with this menu item is displayed.
            'Leprechaun', //Required. Text to be displayed in the menu.
            'manage_options', //Required. The required capability of users to access this menu item.
            'wp-leprechaun', //Required. A unique identifier to identify this menu item.
            array($this, 'render_options_page') //Optional. This callback outputs the content of the page associated with this menu item.
        );
	}
	
	function render_options_page() {
		?>	
		<div class="wrap">
            <div id="icon-options-general" class="icon32"></div>
            <h1>WP Leprechaun - Global Settings</h1>
            <form method="post" action="options.php" enctype="multipart/form-data">
				<table class="form-table">
                <?php
                
                    //add_settings_section callback is displayed here. For every new section we need to call settings_fields.
					settings_fields('wp-leprechaun');
                    
                    // all the add_settings_field callbacks is displayed here
                    do_settings_sections('wp-leprechaun');
                
                    // Add the submit button to serialize the options
                    submit_button(); 
				?>
				</table>          
            </form>
		</div>
		<?php
	}

	function display_settings() {
		// Sizes section
		add_settings_section('header_section', 'Sizes Options', null, 'wp-leprechaun');
		add_settings_field(self::IMAGE_SIZES, 'Image Sizes', array($this, 'render_image_sizes_form_element'), 'wp-leprechaun', 'header_section');
		
		// Section post types
		add_settings_section('post_types_section', 'Enable for selected Post Types', null, 'wp-leprechaun');
		add_settings_field(self::POST_TYPES, 'Post Types', array($this, 'render_post_type_settings'), 'wp-leprechaun', 'post_types_section');

		// Section post types
		add_settings_section('background_section', 'Default background', null, 'wp-leprechaun');
		add_settings_field(self::DEFAULT_BG, 'Background', array($this, 'render_file_upload'), 'wp-leprechaun', 'background_section');
		
		// Register settings
		register_setting('wp-leprechaun', self::IMAGE_SIZES, array(
            'type' => 'string', 
            'sanitize_callback' => array(Helpers, 'sanitize'),
		));

		register_setting('wp-leprechaun', self::POST_TYPES, array(
            'type' => 'string', 
            'sanitize_callback' => array(Helpers, 'sanitize'),
		));

		register_setting('wp-leprechaun', self::DEFAULT_BG, array(
            'type' => 'string', 
            'sanitize_callback' => array($this, 'handle_image_upload'),
		));
	}
	
	function render_image_sizes_form_element() {
		$value = get_option(self::IMAGE_SIZES);
		$checked = Helpers::unserialize($value);

		$html = '<fieldset>';
		$html .= '<label><input type="checkbox" name="'.self::IMAGE_SIZES.'[]" value="1" ' . Helpers::checked( $checked, '1' ) . '>Facebook ('. self::FACEBOOK_THUMBNAIL_SIZES['width'] .'x'. self::FACEBOOK_THUMBNAIL_SIZES['height'] .')</label><br/>';
		$html .= '<label><input type="checkbox" name="'.self::IMAGE_SIZES.'[]" value="2"' . Helpers::checked( $checked, '2' ) . '>Twitter ('. self::TWITTER_THUMBNAIL_SIZES['width'] .'x'.  self::TWITTER_THUMBNAIL_SIZES['height'] .')</label>';
		$html .= '</fieldset>';

		echo $html;
	}

	function render_post_type_settings() {
		$post_types = get_post_types([
			'public' => true,
		], 'objects');

		$value = get_option(self::POST_TYPES);
		$checked = Helpers::unserialize($value);

		$html = '<fieldset>';
		foreach ($post_types as $post_type) {
			if($post_type->name !== 'attachment') {
				$html .= sprintf('<label><input type="checkbox" value="%s" name="%s[]" %s> %s</label><br/>',$post_type->name, self::POST_TYPES ,Helpers::checked( $checked, $post_type->name ) ,$post_type->labels->name);
			}
		}
		$html .= '</fieldset>';

		echo $html;
	}

	function render_file_upload() {
		$value = get_option(self::DEFAULT_BG);

		if($value) {
			echo '<img src="'. $value .'"><br/>';
		}

		echo sprintf('<input type="file" name="%s" />', self::DEFAULT_BG);
	}

	function save_canvas($post_id) {
		if (array_key_exists(self::TEMPLATE_CANVAS, $_POST)) {
            update_post_meta(
                $post_id,
                self::TEMPLATE_CANVAS,
                $_POST[self::TEMPLATE_CANVAS]
            );
        }
	}

	/**
	 * Handle upload
	 */
	public static function handle_image_upload($options) {
        //check if user had uploaded a file and clicked save changes button
        if(!empty($_FILES[self::DEFAULT_BG]["tmp_name"])) {
            $urls = wp_handle_upload($_FILES[self::DEFAULT_BG], array('test_form' => FALSE));
            $temp = $urls["url"];
            return $temp;
		}

        //no upload. old file url is the new value.
        return get_option(self::DEFAULT_BG);
	}
	
	function canvas_box() {
		$screens = [self::TEMPLATE_POST_TYPE];
		foreach ($screens as $screen) {
			add_meta_box(
				'wp_leprechaun_box_id',
				'Template',
				array($this, 'wp_lp_custom_box_html'),
				$screen 
			);
		}
	}

	function wp_lp_custom_box_html($post) {
		$value = get_post_meta($post->ID, self::TEMPLATE_CANVAS, true);
	?>
		<div class="wp-leprechaun-canvas-wrapper">
			<div class="wp-leprechaun-toolbox">
				<select>
					<option value="">Select Variable Tag...</option>
					<option value="logo">Website Logo</option>
					<option value="post-date">Post Date</option>
					<option value="post-author-name">Post Author Name</option>
				</select>
				<button type="button">Add</button>
			</div>
			<canvas id="wp-leprechaun-canvas" width="910" height="500"></canvas>
			<input type="hidden" name="<?php echo self::TEMPLATE_CANVAS; ?>" value="<?php echo Helpers::encodeURIComponent($value); ?>"/>
		</div>
    <?php
	}
}
