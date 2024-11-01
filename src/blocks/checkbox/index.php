<?php
namespace sv_forms;

class checkbox extends sv_forms {
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
		
		require( $this->get_path( 'lib/frontend/tpl/checkbox.php' ) );

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	public function load_block_assets() {
		if ( ! is_admin() ) {
			$this->get_parent()->get_script( 'checkbox' )->set_is_enqueued();
		}
	}

	private function register_block() {
		register_block_type(
			'straightvisions/sv-forms-checkbox', array(
				'editor_script' 	=> 'sv-forms-block',
				'editor_style'  	=> 'sv-forms-block-editor',
				'render_callback'	=> array( $this, 'render_block' ),
				'attributes'		=> array(
					// Input Settings
					'isChecked' => array(
						'type' => 'boolean',
					),
					'label' => array(
						'type' => 'string',
						'default' => __( 'Checkbox', 'sv_forms' ),
					),
					'name' => array(
						'type' => 'string',
					),
					'type' => array(
						'type' => 'string',
						'default' => 'checkbox',
					),
					'value' => array(
						'type' => 'string',
					),

					// Color Settings
					'labelColor' => array(
						'type' => 'string',
					),
					'labelColorClass' => array(
						'type' => 'string',
					),
					'inputBackgroundColor' => array(
						'type' => 'string',
						'default' => '#FFFFFF'
					),
					'inputBackgroundColorClass' => array(
						'type' => 'string',
					),
					'inputBorderColor' => array(
						'type' => 'string',
						'default' => '#000000'
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
						'default' => 0,
					),

					// Validation Settings
					'required' => array(
						'type' => 'boolean',
					),

					// Advanced Settings
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
		$attr = array();
		$block_attr = $this->block_attr;
		
		// Type
		$attr[]	= 'type="' . $block_attr['type'] . '"';

		// ID
		if ( isset( $block_attr['name'] ) && ! empty( $block_attr['name'] ) ) {
			$attr[]	= 'id="' . $this->get_root()->get_prefix($block_attr['name']) . '"';
		}

		// Name
		if ( isset( $block_attr['name'] ) ) {
			$attr[] = 'name="' . $block_attr['name'] . '"';
		}

		// Value
		$default_value = isset( $block_attr['defaultValue'] ) ? $block_attr['defaultValue'] :  '';
		$value = $this->get_input_value_from_url_params( $block_attr['name'], $default_value );
		
		if ( empty( $value ) === false ) {
			$attr[]	= 'value="' . $value . '"';
		}

		// Checked
		if ( isset( $block_attr['isChecked'] ) && $block_attr['isChecked'] ) {
			$attr[]	= 'checked';
		}
		
		// Checked true if value 1 is set
		if ( isset( $block_attr['isChecked'] ) === false || empty( $block_attr['isChecked'] ) === true ) {
			if( empty($value) === false ){ // this will include value = 0
				$attr[]	= 'checked';
			}
		}
		
		// Required
		if ( isset( $block_attr['required'] ) && $block_attr['required'] ) {
			$attr[] = 'required';
		}

		// Disabled
		if ( isset( $block_attr['disabled'] ) && $block_attr['disabled'] ) {
			$attr[] = 'disabled';
		}

		// Class
		$class = array();

		// Input Background Color
		if ( 
			isset( $block_attr['inputBackgroundColor'] ) && isset( $block_attr['inputBackgroundColorClass'] )
			&& $block_attr['inputBackgroundColorClass'] 
		) {
            $class[] = $block_attr['inputBackgroundColorClass'];
		}
		
		if ( ! empty( $class ) ) {
			$attr[]	= 'class="' . implode( ' ', $class ) . '"';
		}

		// Style
		$style = array();

		// Input Background Color
		if ( 
			isset( $block_attr['inputBackgroundColor'] ) && ( isset( $block_attr['inputBackgroundColorClass'] ) === false
			|| empty($block_attr['inputBackgroundColorClass']) === false )
		) {
			$style[] = 'background-color:' . $block_attr['inputBackgroundColor'];
		}
		
		// Border Color
		if ( isset( $block_attr['inputBorderColor'] ) ) {
			$style[] = 'border-color:' . $block_attr['inputBorderColor'];
		}

		// Border Style
		if ( isset( $block_attr['borderStyle'] ) ) {
			$style[] = 'border-style:' . $block_attr['borderStyle'];
		}

		// Border Width Top
		if ( isset( $block_attr['borderWidthTop'] ) ) {
			$style[] = 'border-top-width:' . $block_attr['borderWidthTop'] . 'px';
		}

		// Border Width Right
		if ( isset( $block_attr['borderWidthRight'] ) ) {
			$style[] = 'border-right-width:' . $block_attr['borderWidthRight'] . 'px';
		}

		// Border Width Bottom
		if ( isset( $block_attr['borderWidthBottom'] ) ) {
			$style[] = 'border-bottom-width:' . $block_attr['borderWidthBottom'] . 'px';
		}

		// Border Width Left
		if ( isset( $block_attr['borderWidthLeft'] ) ) {
			$style[] = 'border-left-width:' . $block_attr['borderWidthLeft'] . 'px';
		}

		// Border Radius
		if ( isset( $block_attr['borderRadius'] ) ) {
			$style[] = 'border-radius:' . $block_attr['borderRadius'] . 'px';
		}

		if ( ! empty( $style ) ) {
			$attr[] = 'style="' . implode( ';', $style ) . '"';
		}

		return implode( ' ', $attr );
	}
}