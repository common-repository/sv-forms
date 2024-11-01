<?php
namespace sv_forms;

class radio extends sv_forms {
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
		
		require( $this->get_path( 'lib/frontend/tpl/radio.php' ) );

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	public function load_block_assets() {
		if ( ! is_admin() ) {
			$this->get_parent()->get_script( 'radio' )->set_is_enqueued();
		}
	}

	private function register_block() {
		register_block_type(
			'straightvisions/sv-forms-radio', array(
				'editor_script' 	=> 'sv-forms-block',
				'editor_style'  	=> 'sv-forms-block-editor',
				'render_callback'	=> array( $this, 'render_block' ),
				'attributes'		=> array(					
					// Input Settings
					'defaultValue' => array(
						'type' => 'string',
					),
					'label' => array(
						'type' => 'string',
					),
					'name' => array(
						'type' => 'string',
					),
					'type' => array(
						'type' => 'string',
						'default' => 'radio',
					),
					'options' => array(
						'type' => 'string',
						'default' => '[{"label":"' . __( 'Option', 'sv_forms' ) .  '","value":""}]',
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
						'default' => 10,
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

					// Advanced Settings
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
	protected function get_input_attr( object $option ): string {
		$attr = array();

		// Type
		$attr[] = 'type="' . $this->block_attr['type'] . '"';

		// ID
		$attr[]	= 'id="' . $option->value . '"';

		// Name
		if ( isset( $this->block_attr['name'] ) ) {
			$attr[]	= 'name="' . $this->block_attr['name'] . '"';
		}

		// Value
		$attr[]	= 'value="' . $option->value . '"';

		// Checked
		if ( isset( $this->block_attr['defaultValue'] ) && $this->block_attr['defaultValue'] === $option->value ) {
			$attr[]	= 'checked';
		}

		// Disabled
		if ( isset( $option->disabled ) && $option->disabled ) {
			$attr[]	= 'disabled';
		}

		// Class
		$class = array();

		// Input Background Color
		if ( 
			isset( $this->block_attr['inputBackgroundColorClass'] )
			&& $this->block_attr['inputBackgroundColorClass'] 
		) {
            $class[] = $this->block_attr['inputBackgroundColorClass'];
		}
		
		if ( ! empty( $class ) ) {
			$attr[]	= 'class="' . implode( ' ', $class ) . '"';
		}

		// Style
		$style = array();

		// Input Background Color
		if ( 
			isset( $this->block_attr['inputBackgroundColor'] ) 
			&& ! $this->block_attr['inputBackgroundColor']
		) {
			$style[] = 'background-color:' . $this->block_attr['inputBackgroundColor'];
		}
		
		// Border Color
		if ( isset( $this->block_attr['inputBorderColor'] ) ) {
			$style[] = 'border-color:' . $this->block_attr['inputBorderColor'];
		}

		// Border Style
		if ( isset( $this->block_attr['borderStyle'] ) ) {
			$style[] = 'border-style:' . $this->block_attr['borderStyle'];
		}

		// Border Width Top
		if ( isset( $this->block_attr['borderWidthTop'] ) ) {
			$style[] = 'border-top-width:' . $this->block_attr['borderWidthTop'] . 'px';
		}

		// Border Width Right
		if ( isset( $this->block_attr['borderWidthRight'] ) ) {
			$style[] = 'border-right-width:' . $this->block_attr['borderWidthRight'] . 'px';
		}

		// Border Width Bottom
		if ( isset( $this->block_attr['borderWidthBottom'] ) ) {
			$style[] = 'border-bottom-width:' . $this->block_attr['borderWidthBottom'] . 'px';
		}

		// Border Width Left
		if ( isset( $this->block_attr['borderWidthLeft'] ) ) {
			$style[] = 'border-left-width:' . $this->block_attr['borderWidthLeft'] . 'px';
		}

		// Border Radius
		if ( isset( $this->block_attr['borderRadius'] ) ) {
			$style[] = 'border-radius:' . $this->block_attr['borderRadius'] . 'px';
		}

		if ( ! empty( $style ) ) {
			$attr[] = 'style="' . implode( ';', $style ) . '"';
		}

		return implode( ' ', $attr );
	}

	// Returns the radio options as html string
	protected function get_options(): string {
		$options = array();

		foreach( json_decode( $this->block_attr['options'] ) as $option ) {
			$output = '<div class="wp-block-straightvisions-sv-forms-radio-option">';
			$output .= '<input ' . $this->get_input_attr( $option ) . ' />';
			$output .= '<label ' . $this->get_label_attr( $option->value ) . '>' . $option->label . '</label>';
			$output .= '</div>';

			$options[] = $output;
		}

		return implode( '', $options );
	}
}