<?php
namespace sv_forms;

class number extends sv_forms {
	protected $block_attr = array();

	public function init() {
		$this->register_block();
	}

	public function render_block( array $attr ): string {
		$this->block_attr = $attr;

		if ( did_action( 'wp_enqueue_scripts' ) ) {
			$this->load_block_assets();
		} else {
			add_action( 'wp_enqueue_scripts', array( $this, 'load_block_assets' ), 999 );
		}

		ob_start();
		
		require( $this->get_path( 'lib/frontend/tpl/number.php' ) );

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	public function load_block_assets() {
		if ( ! is_admin() ) {
			$this->get_parent()->get_script( 'number' )->set_is_enqueued();
		}
	}

	private function register_block() {
		register_block_type(
			'straightvisions/sv-forms-number', array(
				'editor_script' 	=> 'sv-forms-block',
				'editor_style'  	=> 'sv-forms-block-editor',
				'render_callback'	=> array( $this, 'render_block' ),
				'attributes'		=> array(
					// Input Settings
					'defaultValue' => array(
						'type' => 'string',
					),

					// Input Settings
					'name' => array(
						'type' => 'string',
					),
					'type' => array(
						'type' => 'string',
						'default' => 'number',
					),
					'placeholder' => array(
						'type' => 'string',
						'default' => '0',
					),
					'inputFontSize' => array(
						'type' => 'number',
					),

					// Label Settings
					'label' => array(
						'type' => 'string',
					),
					'labelFontSize' => array(
						'type' => 'number',
					),

					// Color Settings
					'inputColor' => array(
						'type' => 'string',
						'default' => '#000000'
					),
					'inputColorClass' => array(
						'type' => 'string',
					),
					'inputBackgroundColor' => array(
						'type' => 'string',
						'default' => '#FFFFFF'
					),
					'inputBackgroundColorClass' => array(
						'type' => 'string',
					),
					'labelColor' => array(
						'type' => 'string',
					),
					'labelColorClass' => array(
						'type' => 'string',
					),
					'inputBorderColor' => array(
						'type' => 'string',
						'default' => '#E5E5E5'
					),

					// Border Settings
					'borderStyle' => array(
						'type' => 'string',
						'default' => 'solid'
					),
					'borderWidthTop' => array(
						'type' => 'number',
						'default' => 1,
					),
					'borderWidthRight' => array(
						'type' => 'number',
						'default' => 1,
					),
					'borderWidthBottom' => array(
						'type' => 'number',
						'default' => 1,
					),
					'borderWidthLeft' => array(
						'type' => 'number',
						'default' => 1,
					),
					'borderRadius' => array(
						'type' => 'number',
						'default' => 5,
					),

					// Validation Settings
					'required' => array(
						'type' => 'boolean',
					),
					'min' => array(
						'type' => 'number',
					),
					'max' => array(
						'type' => 'number',
					),
					'step' => array(
						'type' => 'number',
						'default' => 1,
					),

					// Advanced Settings
					'autofocus' => array(
						'type' => 'boolean',
					),
					'autocomplete' => array(
						'type' => 'boolean',
					),
					'readonly' => array(
						'type' => 'boolean',
					),
					'disabled' => array(
						'type' => 'boolean',
					),
					'className' => array(
						'type' => 'string',
					),
				),
			)
		);
	}

	// Returns a string with all classes for the input wrapper
	protected function get_wrapper_class(): string {
		return $this->get_root()->sv_forms->get_default_wrapper_class( $this->block_attr, $this->get_module_name() );
	}

	// Returns a string with all attributes for the label
	protected function get_label_attr(): string {
		return $this->get_root()->sv_forms->get_default_label_attr( $this->block_attr );
	}

	// Returns a string with all attributes for the input
	protected function get_input_attr(): string {
		return $this->get_root()->sv_forms->get_default_input_attr( $this->block_attr );
	}
}