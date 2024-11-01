<?php
namespace sv_forms;

class select extends sv_forms {
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
		
		require( $this->get_path( 'lib/frontend/tpl/select.php' ) );

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	public function load_block_assets() {
		if ( ! is_admin() ) {
			$this->get_parent()->get_script( 'select' )->set_is_enqueued();
		}
	}

	private function register_block() {
		register_block_type(
			'straightvisions/sv-forms-select', array(
				'editor_script' 	=> 'sv-forms-block',
				'editor_style'  	=> 'sv-forms-block-editor',
				'render_callback'	=> array( $this, 'render_block' ),
				'attributes'		=> array(					
					'defaultValue' => array(
						'type' => 'string',
					),

					// Input Settings
					'name' => array(
						'type' => 'string',
					),
					'type' => array(
						'type' => 'string',
						'default' => 'text',
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
					
					// Options
					'options' => array(
						'type' => 'string',
						'default' => '[{"label":"' . __( 'Please select...', 'sv_forms' ) .  '","value":""}]',
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

					// Advanced Settings
					'autofocus' => array(
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

	// Returns a string with all attributes for the select
	protected function get_select_attr(): string {
		return $this->get_root()->sv_forms->get_default_input_attr( $this->block_attr );
	}

	protected function get_options(): string {
		$options = array();
		$block_attr = $this->block_attr;
		
		$default_value = isset( $block_attr['defaultValue'] ) ? $block_attr['defaultValue'] :  '';
		$value = $this->get_input_value_from_url_params( $block_attr['name'], $default_value );
		
		foreach( json_decode( $block_attr['options'] ) as $option ) {
			$el	= '<option value="' . $option->value .'"';

			if ( $value === $option->value ) {
				$el .= ' selected';
			}

			if ( isset( $option->disabled ) && $option->disabled ) {
				$el .= ' disabled';
			}

			$el .= '>' . $option->label . '</option>';

			$options[] = $el;
		}

		return implode( ' ', $options );
	}
}