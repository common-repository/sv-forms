<?php
namespace sv_forms;

class personal_data extends modules {
    public function init() {
        // Actions Hooks & Filter
        add_filter( 'wp_privacy_personal_data_exporters', array( $this, 'wp_privacy_personal_data_exporters' ), 10 );
		add_filter( 'wp_privacy_personal_data_erasers', array( $this, 'wp_privacy_personal_data_erasers' ), 10 );
    }

    // Registers the personal data exporter
	public function wp_privacy_personal_data_exporters( array $exporters ): array {
		$exporters[ $this->get_root()->get_prefix() ] = array(
			'exporter_friendly_name' => __( 'SV Forms Plugin', 'sv_forms' ),
			'callback' => array( $this, 'personal_data_exporter' ),
		);

		return $exporters;
	}

    // Registers the personal data eraser
	public function wp_privacy_personal_data_erasers( array $erasers ): array {
		$erasers[ $this->get_root()->get_prefix() ] = array(
			'eraser_friendly_name' => __( 'SV Forms Plugin', 'sv_forms' ),
			'callback' => array( $this, 'personal_data_eraser' ),
		);

		return $erasers;
	}

	// Fetches all submissions linked to the email adress
	private function get_submissions_by_user_mail( string $email ): array {
		$meta_key = $this->get_root()->get_prefix( 'user_mail' );

		$query_args		= array(
			'posts_per_page' => -1,
			'post_type'		=> $this->get_root()->get_prefix( 'submit' ),
			'meta_query' 	=> array(
				array(
					'key'		=> $meta_key,
					'value' 	=> $email,
					'compare' 	=> '=',
				),
			),
		);
		
		return get_posts( $query_args );
	}

	// Returns all the personal data that is connected with the given email adress
	public function personal_data_exporter( string $email, int $page = 1 ): array {
		$number 		= 500;
		$export_items 	= array();
		$posts			= $this->get_submissions_by_user_mail( $email );
		$meta_key		= $this->get_root()->get_prefix( 'form_data' );

		// Fetches all data for each submission
		foreach ( $posts as $post ) {
			$form_data 	= json_decode( get_post_meta( $post->ID, $meta_key, true ) );
			$item_id 	= 'sv-forms-submission-' . $post->ID;
			$group_id 	= 'sv-forms-submissions';
			$group_label= __( 'SV Forms Submissions', 'sv_forms' );
			$data		= array();
			
			foreach ( $form_data as $form_input ) {
				$data[] = get_object_vars( $form_input );
			}

			$export_items[] = array(
				'group_id'		=> $group_id,
				'group_label'	=> $group_label,
				'item_id'		=> $item_id,
				'data'			=> $data,
			);
		}
		
		$done = count( $posts ) < $number;

		return array(
			'data'	=> $export_items,
			'done'	=> $done,
		);
	}

	// Deletes all the personal data that is connected with the given email adress
	public function personal_data_eraser( string $email, int $page = 1 ): array {
		$number 		= 500;
		$export_items 	= array();
		$posts			= $this->get_submissions_by_mail( $email );
		$items_removed	= false;

		// Fetches all data for each submission
		foreach ( $posts as $post ) {
			wp_delete_post( $post->ID, true );
		}

		if ( count( $this->get_submissions_by_mail( $email ) ) < 1 ) {
			$items_removed = true;
		}
		
		$done = count( $posts ) < $number;

		return array(
			'items_removed'	 => $items_removed,
			'items_retained' => false,
			'messages' => '',
			'done' => $done,
		);
	}
}