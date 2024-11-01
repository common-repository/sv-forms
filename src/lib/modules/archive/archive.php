<?php
namespace sv_forms;

class archive extends modules {
	public function init() {
		// Actions Hooks & Filter
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'restrict_manage_posts', array( $this, 'restrict_manage_posts' ) );
		add_action( 'manage_sv_forms_submit_posts_custom_column' , array( $this, 'manage_sv_forms_submit_posts_custom_column' ), 10, 2 );
		add_filter( 'parse_query', array( $this, 'parse_query' ) );
		add_filter( 'manage_sv_forms_submit_posts_columns', array( $this, 'manage_sv_forms_submit_posts_columns' ) );
		add_filter( 'post_row_actions', array( $this, 'post_row_actions' ), 10, 2 );
	}

	// Adds roles and capabilities to manage the Submissions
	public function admin_init() {
		$this->add_roles()->add_role_caps();
	}

	// Adds two new user roles for the CPT sv_forms_submit
	private function add_roles(): archive {
		$cap = $this->post->get_post_type() . 's';
		$editor_role = array(
			'role' => $this->get_root()->get_prefix( 'submissions_editor' ),
			'name' => __( 'SV Forms Submissions Editor', 'sv_forms' ),
			'caps' => array(
				'edit_' . $cap			=> true,
				'edit_others' . $cap	=> true,
				'edit_published' . $cap	=> true,
			),
		);
		$admin_role = array(
			'role' => $this->get_root()->get_prefix( 'submissions_admin' ),
			'name' => __( 'SV Forms Submissions Admin', 'sv_forms' ),
			'caps' => array_merge( 
				$editor_role['caps'], array(
					'delete_' . $cap			=> true,
					'delete_others' . $cap		=> true,
					'delete_published' . $cap	=> true,
				) 
			),
		);

		if ( ! get_role( $editor_role['role'] ) ) {
			add_role( $editor_role['role'], $editor_role['name'], $editor_role['caps'] );
		}

		if ( ! get_role( $admin_role['role'] ) ) {
			add_role( $admin_role['role'], $admin_role['name'], $admin_role['caps'] );
		}

		return $this;
	}

	// Adds capabilities to default WP roles, to manage the CPT sv_forms_submit
	private function add_role_caps(): archive {
		$cap 	= $this->post->get_post_type() . 's';
		$admin 	= get_role('administrator');

		$admin->add_cap( 'edit_' . $cap );
		$admin->add_cap( 'edit_others_' . $cap );
		$admin->add_cap( 'edit_published_' . $cap );
		$admin->add_cap( 'delete_' . $cap );
		$admin->add_cap( 'delete_others_' . $cap );
		$admin->add_cap( 'delete_published_' . $cap );

		return $this;
	}

	// Adds a form label filter to the post table
	public function restrict_manage_posts( $post_type ) {
		if ( $post_type === $this->post->get_post_type() ) {
			$taxonomy_slug 	= $this->taxonomy->get_taxonomy();
			$taxonomy      	= get_taxonomy( $taxonomy_slug );
			$request_attr  	= $selected = $taxonomy_slug;

			if ( $this->get_submissions_count() > 0 ) {
				wp_dropdown_categories( array(
					'show_option_all' =>  __( 'Show All', 'sv_forms' ) . ' ' . $taxonomy->label,
					'taxonomy'        =>  $taxonomy_slug,
					'name'            =>  $request_attr,
					'orderby'         =>  'name',
					'selected'        =>  $selected,
					'hierarchical'    =>  true,
					'depth'           =>  3,
					'show_count'      =>  true,
					'hide_empty'      =>  true,
				) );
			} 
		}
	}

	// Filters the query vars, so that the posts will be filtered by the term slug instead of the term id
	public function parse_query( $query ) {
		global $pagenow;

		$qv = $query->query_vars;
		$taxonomy_slug = $this->taxonomy->get_taxonomy();

		if ( 
			$pagenow === 'edit.php' 
			&& $qv['post_type'] === $this->post->get_post_type()
			&& isset( $qv[ $taxonomy_slug ] )
			&& is_numeric( $qv[ $taxonomy_slug ] )
		) {
			$term = get_term_by( 'id', $qv[ $taxonomy_slug ], $taxonomy_slug );
			$qv[ $taxonomy_slug ] = $term->slug;
			$query->query_vars = $qv;
		}
	}

	// Sets the titles of the post columns
	public function manage_sv_forms_submit_posts_columns( array $columns ): array {
		$columns[ $this->get_root()->get_prefix( 'user_mail_sent' ) ] 	= __( 'User Mail Sent', 'sv_forms' );
		$columns[ $this->get_root()->get_prefix( 'admin_mail_sent' ) ] 	= __( 'Admin Mail Sent', 'sv_forms' );

		return $columns;
	}

	// Sets the value of the custom columns
	public function manage_sv_forms_submit_posts_custom_column( $column, $post_id ) {
		switch( $column ) {
			case $this->get_root()->get_prefix( 'user_mail_sent' ):
				$meta_key 	= '_' . $this->get_root()->get_prefix( 'user_mail_sent' );
				$user_mail 	= get_post_meta( $post_id, $meta_key, true ) ? boolval( get_post_meta( $post_id, $meta_key, true ) ) : false;

				if ( $user_mail ) {
					echo '<span class="dashicons dashicons-yes-alt"></span>';
				} else {
					echo '<span class="dashicons dashicons-dismiss"></span>';
				}
				break;
			case $this->get_root()->get_prefix( 'admin_mail_sent' ):
				$meta_key 	= '_' . $this->get_root()->get_prefix( 'admin_mail_sent' );
				$admin_mail = get_post_meta( $post_id, $meta_key, true ) && ! empty( get_post_meta( $post_id, $meta_key, true ) ) ? true : false;

				if ( $admin_mail ) {
					echo '<span class="dashicons dashicons-yes-alt"></span>';
				} else {
					echo '<span class="dashicons dashicons-dismiss"></span>';
				}
				break;
		}
	}

	// Adds custom post row actions to the sv_forms_submit post type
	public function post_row_actions( array $actions, object $post ): array {
		if ( $post->post_type === $this->get_root()->get_prefix( 'submit' ) && current_user_can( 'edit_post', $post->ID ) ) {
			// Building a link to open the post with the form of the submission
			$form_post_id 			= get_post_meta( $post->ID, $this->get_root()->get_prefix( 'post_id' ), true );
			$form_post_url 			= admin_url( 'post.php?post=' . $form_post_id );
			$edit_form_link 		= add_query_arg( array( 'action' => 'edit' ), $form_post_url );
			$edit_form_label		= sprintf( '<a href="%1$s">%2$s</a>', esc_url( $edit_form_link ), esc_html( __( 'Edit Form', 'sv_forms' ) ) );
			$actions[ $this->get_root()->get_prefix( 'edit_form' ) ] = $edit_form_label;

			// Building a link to resend the user mail
			$user_mail_meta_key = '_' . $this->get_root()->get_prefix( 'send_user_mail' );
			$user_mail = get_post_meta( $post->ID, $user_mail_meta_key, true ) ? boolval( get_post_meta( $post->ID, $user_mail_meta_key, true ) ) : false;
			
			if ( $user_mail ) {
				// @todo Add ajax link to resend mail
				$resend_user_mail_id = $this->get_root()->get_prefix( 'resend_user_mail' );
				$resend_user_mail_label	= sprintf( '<a href="#" id="' . $resend_user_mail_id . '">%1$s</a>', esc_html( __( 'Resend User Mail', 'sv_forms' ) ) );
				$actions[ $this->get_root()->get_prefix( 'resend_user_mail' ) ] = $resend_user_mail_label;
			}

			// Building a link to resend the admin mail
			$admin_mail_meta_key = '_' . $this->get_root()->get_prefix( 'admin_mail' );
			$admin_mail = get_post_meta( $post->ID, $admin_mail_meta_key, true ) && ! empty( get_post_meta( $post->ID, $admin_mail_meta_key, true ) ) ? true : false;
			
			if ( $admin_mail ) {
				// @todo Add ajax link to resend mail
				$resend_admin_mail_id = $this->get_root()->get_prefix( 'resend_admin_mail' );
				$resend_admin_mail_label = sprintf( '<a href="#" id="' . $resend_admin_mail_id . '">%1$s</a>', esc_html( __( 'Resend Admin Mail', 'sv_forms' ) ) );
				$actions[ $this->get_root()->get_prefix( 'resend_admin_mail' ) ] = $resend_admin_mail_label;
			}
		}

		return $actions;
	}

	// Returns the submissions count
	protected function get_submissions_count( string $term_slug = '' ): int {
		$args = array(
			'post_type'	=> $this->post->get_post_type(),
		);

		if ( ! empty( $term_slug ) ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' 	=> $this->taxonomy->get_taxonomy(),
					'field'		=> 'slug',
					'terms'		=> $term_slug,
				),
			);
		}

		$query = new \WP_Query( $args );

		return $query->post_count;
	}
}