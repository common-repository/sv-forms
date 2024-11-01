<?php
namespace sv_forms;

class post extends modules {
	public function init() {
        $this->add_form_index();

        // Actions Hooks & Filter
        add_action( 'init', array( $this, 'register_post_type' ) );
    }
    
    // Registers an option to save all form ids in
	private function add_form_index(): post {
		add_option( $this->get_root()->get_prefix( 'index' ) );

		return $this;
    }

    // Registers a new custom post type
	public function register_post_type(): post {
		$labels = array(
			'name'                  => __( 'Submissions', 'sv_forms' ),
			'singular_name'         => __( 'Submission', 'sv_forms' ),
			'menu_name'             => __( 'SV Forms Submissions', 'sv_forms' ),
			'name_admin_bar'        => __( 'SV Forms Submissions', 'sv_forms' ),
			'add_new'               => __( 'Add New', 'sv_forms' ),
			'add_new_item'          => __( 'Add New Submission', 'sv_forms' ),
			'new_item'              => __( 'New Submission', 'sv_forms' ),
			'edit_item'             => __( 'Edit Submission', 'sv_forms' ),
			'view_item'             => __( 'View Submission', 'sv_forms' ),
			'all_items'             => __( 'All Submissions', 'sv_forms' ),
			'search_items'          => __( 'Search Submissions', 'sv_forms' ),
			'parent_item_colon'     => __( 'Parent Submissions:', 'sv_forms' ),
			'not_found'             => __( 'No Submissions found.', 'sv_forms' ),
			'not_found_in_trash'    => __( 'No Submissions found in Trash.', 'sv_forms' ),
			'archives'              => __( 'Submission archives', 'sv_forms' ),
			'insert_into_item'      => __( 'Insert into Submission', 'sv_forms' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Submission', 'sv_forms' ),
			'filter_items_list'     => __( 'Filter Submissions list', 'sv_forms' ),
			'items_list_navigation' => __( 'Submissions list navigation', 'sv_forms' ),
			'items_list'            => __( 'Submissions list', 'sv_forms' ),
		);
        $supports = array( 'editor', 'custom-fields' );
        $capabilities = array(
            'create_posts' => false,
        );
		$args = array(
			'labels'				=> $labels,
            'public'				=> false,
            'hierarchical'			=> false,
            'exclude_from_search'	=> true,
			'publicly_queryable'	=> false,
			'show_ui'				=> true,
			'show_in_menu'			=> true,
			'show_in_nav_menus'		=> false,
            'show_in_rest'			=> true,
            'capability_type'       => $this->get_post_type(),
            'capabilities'          => $capabilities,
            'map_meta_cap'          => true,
            'supports'				=> $supports,
            'taxonomies'            => array( $this->taxonomy->get_taxonomy() ),
            'has_archive'			=> false,
            'query_var'             => false,
            'delete_with_user'		=> false,
        );

        register_post_type( $this->get_post_type(), $args );

        do_action( $this->get_root()->get_prefix( 'register_post_type' ) );

		return $this;
    }
    
    // Returns the name of the custom post type
    public function get_post_type(): string {
        return $this->get_root()->get_prefix( 'submit' );
    }

    // Returns the form index option value
    public function get_form_index(): array {
        $option_name    = $this->get_root()->get_prefix( 'index' );
        $option_value   = get_option( $option_name );

		return empty( $option_value ) ? array() : json_decode( $option_value );
	}

    // Returns the form data as table for the post content
    private function get_post_content( array $data ): string {
        $filtered_data = $this->remove_input_value( 'sv_forms_form_id', $data );

        $content = '<!-- wp:table --><figure class="wp-block-table"><table class=""><tbody>';

        foreach( $filtered_data as $input ) {
            if ( $input['type'] !== 'file' ) {
                $content .= '<tr><td>' . $input['name'] . '</td><td>' . $input['value'] . '</td></tr>';
            }
        }

        $content .= '</tbody></table></figure><!-- /wp:table -->';

        return $content;
    }

    // Returns the submission data as post meta array
    private function get_post_meta( object $attr, array $data ): array {
		$data_assoc = array();
		foreach($data as $field){
			$data_assoc['_'.$this->get_root()->get_prefix($field['name'])]		= $field['value'];
		}

        return array_merge(
			$data_assoc,
			// form common fields
			array(
				'_' . $this->get_root()->get_prefix( 'post_id' ) 			=> $attr->postId,
				'_' . $this->get_root()->get_prefix( 'form_id' )			=> $attr->formId,
				'_' . $this->get_root()->get_prefix( 'user_mail_sent' )     => $attr->userMailSend ? 1 : 0,
				'_' . $this->get_root()->get_prefix( 'user_mail_mails' )    => $attr->userMailToMails,
				'_' . $this->get_root()->get_prefix( 'admin_mail_sent' )    => $attr->adminMailSend ? 1 : 0,
				'_' . $this->get_root()->get_prefix( 'admin_mail_mails' )   => $attr->adminMailToUsers,
				'_' . $this->get_root()->get_prefix( 'admin_mail_mails' )   => $attr->adminMailToMails,
			)
		);
    }

    // Adds the submission as a new post
    public function insert_post( object $attr, array $data ): post {
        if ( ! $attr || ! $data || ! $attr->saveSubmissions ) return $this;

        $form_post = get_post( $attr->postId );

        // Post Arguments
        $postarr = array(
            'post_title'	=> $form_post->post_title . ' (' . $form_post->ID . ')',
            'post_content'	=> $this->get_post_content( $data ),
            'post_type'		=> $this->get_post_type(),
            'post_status'	=> 'publish',
            'meta_input'	=> $this->get_post_meta( $attr, $data ),
        );

        $post_id = wp_insert_post( $postarr );
        
        if ( $post_id ) {
            $this->set_form_index( $attr->formId )->taxonomy->set_post_term( $post_id, $attr );
        }

        return $this; 
    }

    // Checks if the form id exists in the form index and adds it, if not
	private function set_form_index( string $form_id ): post {
		$forms_array = $this->get_form_index();
		$form_exists = in_array( $form_id, $forms_array );

		if ( ! $form_exists ) {
            $forms_array[]  = $form_id;
            $option_name    = $this->get_root()->get_prefix( 'index' );

			update_option( $option_name, json_encode( $forms_array ) );
		}

		return $this;
    }
}