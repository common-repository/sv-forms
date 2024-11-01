<?php
namespace sv_forms;

class taxonomy extends modules {
	public function init() {
		// Actions Hooks & Filter
		add_action( $this->get_root()->get_prefix( 'register_post_type' ), array( $this, 'register_taxonomy' ) );
	}
	
	// Registers a new custom taxonomy for the custom post type
	public function register_taxonomy(): taxonomy {
		$args = array(
			'label'        			=> __( 'Form', 'sv_forms' ),
			'public'       			=> false,
			'rewrite'      			=> false,
			'hierarchical' 			=> true,
			'show_ui'				=> false,
			'show_admin_column' 	=> true,
			'exclude_from_search'	=> true,
			'publicly_queryable'	=> false,
		);

		register_taxonomy( $this->get_taxonomy(), $this->post->get_post_type(), $args );

		return $this;
	}
	
	// Returns the taxonomy name
	public function get_taxonomy(): string {
		return $this->get_root()->get_prefix( 'form_label' );
	}

	// Returns the term by the form id
	private function get_term( string $form_id ) {
		$term = get_term_by( 'slug', md5( $form_id ), $this->get_taxonomy() );

		return $term ? $term : false;
	}

	// Inserts a new term to the form_label taxonomy
	private function insert_term( string $term, string $form_id ): taxonomy {
		$args = array( 'slug' => md5( $form_id ) );

		wp_insert_term( $term, $this->get_taxonomy(), $args );

		return $this;
	}

	// Updates the term name
	private function update_term_name( int $term_id, string $term_name ): taxonomy {
		wp_update_term( $term_id, $this->get_taxonomy(), array( 'name' => $term_name ) );

		return $this;
	}

	// Sets the post term by the form id
	public function set_post_term( int $post_id, object $attr ) {
		$term = $this->get_term( $attr->formId );
		$form_label = empty( $attr->formLabel ) ? $attr->formId : $attr->formLabel;

		if ( $term && $term->term_taxonomy_id ) {
			if ( $term->name !== $form_label ) {
				$this->update_term_name( $term->term_id, $form_label );
			}

			wp_set_post_terms( $post_id, array( $term->term_taxonomy_id ), $this->get_taxonomy() );
		} else {
			$this->insert_term( $form_label, $attr->formId )->set_post_term( $post_id, $attr );
		}
    }

}