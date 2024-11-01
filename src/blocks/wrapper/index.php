<?php
namespace sv_forms;

class wrapper extends sv_forms {	
	protected $block_attr = array();

	public function init() {
		$this->register_block();
	}

	public function load_scripts( string $form_id ): wrapper {
		if ( did_action( 'wp_enqueue_scripts' ) ) {
			$this->load_block_assets();
		} else {
			add_action( 'wp_enqueue_scripts', array( $this, 'load_block_assets' ), 999 );
		}

		$this->get_parent()->get_script( 'form_js' )->set_localized( 
			array_merge(
				$this->get_parent()->get_script( 'form_js' )->get_localized(),
				apply_filters($this->get_prefix('form_mapping'), array( $form_id => get_the_ID() )) // @filter_name: sv_forms_sv_forms_wrapper_form_id
			)
		);

		return $this;
	}

	public function init_block( array $attr, string $content ): string {
		if ( isset( $attr['formId'] ) ) {
			$this->load_scripts( $attr['formId'] );
		}

		return $this->render_block( $attr, $content );
	}

	public function render_block( array $attr, string $content ): string {
		$this->block_attr = $attr;
		
		ob_start();
		
		require( $this->get_path( 'lib/frontend/tpl/wrapper.php' ) );

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	public function load_block_assets() {
		if ( ! is_admin() ) {
			$this->get_parent()->get_script( 'common' )->set_is_enqueued();
			$this->get_parent()->get_script( 'wrapper' )->set_is_enqueued();
			$this->get_parent()->get_script( 'form_js' )
				->set_is_enqueued()
				->set_localized( 
					array_merge(
						$this->get_parent()->get_script( 'form_js' )->get_localized(),
						array(
							'sv_forms_ajaxurl' 	=> admin_url( 'admin-ajax.php' ),
							'sv_forms_nonce' 	=> \wp_create_nonce( 'sv_forms_submit' ),
						)
					)
				);
		}
	}

	private function register_block() {
		register_block_type(
			'straightvisions/sv-forms', array(
				'editor_script' 	=> 'sv-forms-block',
				'editor_style'  	=> 'sv-forms-block-editor',
				'render_callback'	=> array( $this, 'init_block' ),
				'attributes'		=> array(
					'postId' => array(
						'type' => 'number',
					),
					'formId' => array(
						'type' => 'string',
					),
					'formLabel' => array(
						'type' => 'string',
					),
					'saveSubmissions' => array(
						'type' => 'boolean',
						'default' => true,
					),
					'formInputs' => array(
						'type' => 'string',
					),

					// Thank You Message, Admin Mail & User Mail Block
					'inputNames' => array(
						'type' => 'string',
					),

					// Admin Mail Block
					'adminMailSend' => array(
						'type' => 'boolean',
					),
					'adminMailToUsers' => array(
						'type' => 'string',
					),
					'adminMailToMails' => array(
						'type' => 'string',
					),
					'adminMailSubject' => array(
						'type' => 'string',
					),
					'adminMailFromTitle' => array(
						'type' => 'string',
					),
					'adminMailFromMail' => array(
						'type' => 'string',
					),

					// Mail Settings
					// Admin Mails
					'adminMail' => array(
						'type' => 'string',
						'default' => 'disabled',
					),
					'adminMailUser' => array(
						'type' => 'number',
					),
					'adminMailAdress'=> array(
						'type' => 'string',
					),
					'adminMailSubject' => array(
						'type' => 'string',
					),
					'adminMailFromTitle' => array(
						'type' => 'string',
					),
					'adminMailFromMail'	=> array(
						'type' => 'string',
					),
					'adminMailContent'=> array(
						'type' => 'string',
					),
					'adminMailBlockStyles'=> array(
						'type' => 'string',
					),

					// User Mails
					'userMail' => array(
						'type' => 'boolean',
					),
					'userMailInputName' => array(
						'type' => 'string',
					),
					'userMailSubject' => array(
						'type' => 'string',
					),
					'userMailFromTitle' => array(
						'type' => 'string',
					),
					'userMailFromMail' => array(
						'type' => 'string',
					),
					'userMailContent' => array(
						'type' => 'string',
					),
					'userMailBlockStyles'=> array(
						'type' => 'string',
					),

					// Spam Guard Settings
					// Honeypot
					'sgHoneypot' => array(
						'type' => 'boolean',
					),

					// Time Trap
					'sgTimeTrap' => array(
						'type' => 'boolean',
					),
					'sgTimeTrapWindow' => array(
						'type' => 'number',
						'default' => 5,
					),

					// Advanced
					'className' => array(
						'type'		=> 'string',
					),
				),
			)
		);
	}

	// Returns a string with all classes for the input wrapper
	protected function get_wrapper_class(): string {
		return $this->get_root()->sv_forms->get_default_wrapper_class( $this->block_attr, $this->get_module_name() );
	}
}