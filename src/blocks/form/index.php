<?php
namespace sv_forms;

class form extends sv_forms {	
	protected $block_attr = array();

	public function init() {
		$this->register_block();
	}

	public function render_block( array $attr, string $content ): string {
		$this->block_attr = $attr;

		if ( did_action( 'wp_enqueue_scripts' ) ) {
			$this->load_block_assets();
		} else {
			add_action( 'wp_enqueue_scripts', array( $this, 'load_block_assets' ), 999 );
		}
		
		ob_start();
		
		require( $this->get_path( 'lib/frontend/tpl/form.php' ) );

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	public function load_block_assets() {
		if ( ! is_admin() ) {
			$this->get_parent()->get_script( 'form' )->set_is_enqueued();
		}
	}

	private function register_block() {
		register_block_type(
			'straightvisions/sv-forms-form', array(
				'editor_script' 	=> 'sv-forms-block',
				'editor_style'  	=> 'sv-forms-block-editor',
				'render_callback'	=> array( $this, 'render_block' ),
				'attributes'		=> array(
					'formId' => array(
						'type' => 'string',
					),
					'collapsed' => array(
						'type' => 'boolean',
						'default' => false,
					),
					'placeholderColor' => array(
						'type' => 'string',
						'default' => '#808080',
					),
					
					// Advanced
					'className' => array(
						'type'		=> 'string',
					),
				),
			)
		);
	}

	// Returns a string with all attributes for the form
	public function get_form_class(): string {
		return $this->get_root()->sv_forms->get_default_wrapper_class( $this->block_attr, $this->get_module_name() );
	}
}