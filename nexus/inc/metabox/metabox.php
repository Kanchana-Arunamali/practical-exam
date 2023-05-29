<?php
/**
 * The template for displaying meta box in page/post
 *
 * This adds a metabox for selecting Header Featured Image Options, Single Page/Post Image Layout
 */

/**
 * Class to Renders and save metabox options
 */
class Nexus_Metabox {
	private $meta_box;

	private $fields;

	/**
	* Constructor
	*
	* @access public
	*
	*/
	public function __construct( $meta_box_id, $meta_box_title, $post_type ) {

		$this->meta_box = array (
							'id' 		=> $meta_box_id,
							'title' 	=> $meta_box_title,
							'post_type' => $post_type,
							);

		$this->fields = array(
			'nexus-header-image',
            'nexus-page-layout',
		);


		// Add metaboxes
		add_action( 'add_meta_boxes', array( $this, 'add' ) );

		add_action( 'save_post', array( $this, 'save' ) );

		
   	}

	/**
	* Add Meta Box for multiple post types.
	*
	* @access public
	*/
	public function add( $post_type ) {
		add_meta_box( $this->meta_box['id'], $this->meta_box['title'], array( $this, 'show' ), $post_type, 'side', 'high' );
	}

	/**
	* Renders metabox
	*
	* @access public
	*/
	public function show() {
		global $post;

        //header featured image options

		$header_image_options 	= array(
			'default' => esc_html__( 'Default', 'nexus' ),
			'enable'  => esc_html__( 'Enable', 'nexus' ),
			'disable' => esc_html__( 'Disable', 'nexus' ),
		);

        //page layout options

        $page_layout_options = array(
            'default' => esc_html__( 'Default', 'nexus' ),
            'no-sidebar' => esc_html__( 'No Sidebar', 'nexus' ),
            'right-sidebar' => esc_html__( 'Right Sidebar', 'nexus' ),
        );

	    // Use nonce for verification
	    wp_nonce_field( basename( __FILE__ ), 'nexus_custom_meta_box_nonce' );

        // Render header image options

	    // Begin the field table and loop  ?>
	    <p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="nexus-header-image"><?php esc_html_e( 'Header Featured Image Options', 'nexus' ); ?></label></p>
		<select class="widefat" name="nexus-header-image" id="nexus-header-image">
			 <?php
				$meta_value = get_post_meta( $post->ID, 'nexus-header-image', true );
				
				if ( empty( $meta_value ) ){
					$meta_value='default';
				}
				
				foreach ( $header_image_options as $field =>$label ) {	
				?>
					<option value="<?php echo esc_attr( $field ); ?>" <?php selected( $meta_value, $field ); ?>><?php echo esc_html( $label ); ?></option>
				<?php
				} // end foreach
			?>
		</select>

        <!-- Render page layout options -->
        <p class="post-attributes-label-wrapper">
            <label class="post-attributes-label" for="nexus-page-layout">
                <?php esc_html_e( 'Page Layout Options', 'nexus' ); ?>
            </label>
        </p>
        <select class="widefat" name="nexus-page-layout" id="nexus-page-layout">
            <?php
            $layout_meta_value = get_post_meta( $post->ID, 'nexus-page-layout', true );

            if ( empty( $layout_meta_value ) ) {
                $layout_meta_value = 'default';
            }

            foreach ( $page_layout_options as $field => $label ) {
                ?>
                <option value="<?php echo esc_attr( $field ); ?>" <?php selected( $layout_meta_value, $field ); ?>>
                    <?php echo esc_html( $label ); ?>
                </option>
                <?php
            }
            ?>
        </select>
	    
	<?php
	}

	/**
	 * Save custom metabox data
	 *
	 * @action save_post
	 *
	 * @access public
	 */
	public function save( $post_id ) {
		global $post_type;

		$post_type_object = get_post_type_object( $post_type );

	    if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )                      // Check Autosave
	    || ( ! isset( $_POST['post_ID'] ) || $post_id != $_POST['post_ID'] )        // Check Revision
	    || ( ! in_array( $post_type, $this->meta_box['post_type'] ) )                  // Check if current post type is supported.
	    || ( ! check_admin_referer( basename( __FILE__ ), 'nexus_custom_meta_box_nonce') )    // Check nonce - Security
	    || ( ! current_user_can( $post_type_object->cap->edit_post, $post_id ) ) )  // Check permission
	    {
	      return $post_id;
	    }

	    foreach ( $this->fields as $field ) {
			$new = $_POST[ $field ];

			delete_post_meta( $post_id, $field );

			if ( '' == $new || array() == $new ) {
				return;
			} else {
				if ( ! update_post_meta ( $post_id, $field, sanitize_key( $new ) ) ) {
					add_post_meta( $post_id, $field, sanitize_key( $new ), true );
				}
			}
		} // end foreach
	}
}

$Nexus_Metabox = new Nexus_Metabox(
	'nexus-options', 					//metabox id
	esc_html__( 'Nexus Options', 'nexus' ), //metabox title
	array( 'page', 'post' )				//metabox post types
);
