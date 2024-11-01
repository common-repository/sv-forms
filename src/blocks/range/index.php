<?php
namespace sv_forms;

class range extends sv_forms {
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
		
		require( $this->get_path( 'lib/frontend/tpl/range.php' ) );

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	public function load_block_assets() {
		if ( ! is_admin() ) {
			$this->get_parent()->get_script( 'range' )->set_is_enqueued();
			$this->get_parent()->get_script( 'range_js' )->set_is_enqueued();
		}
	}

	private function register_block() {
		register_block_type(
			'straightvisions/sv-forms-range', array(
				'editor_script' 	=> 'sv-forms-block',
				'editor_style'  	=> 'sv-forms-block-editor',
				'render_callback'	=> array( $this, 'render_block' ),
				'attributes'		=> array(
					// Input Settings
					'defaultValue' => array(
						'type' => 'number',
					),
					'label' => array(
						'type' => 'string',
					),
					'name' => array(
						'type' => 'string',
					),
					'type' => array(
						'type' => 'string',
						'default' => 'range',
					),

					// Validation Settings
					'required' => array(
						'type' => 'boolean',
					),
					'min' => array(
						'type' => 'number',
						'default' => 0,
					),
					'max' => array(
						'type' => 'number',
						'default' => 100,
					),
					'step' => array(
						'type' => 'number',
						'default' => 1,
					),

					// Display Settings
					'showValue' => array(
						'type' => 'boolean',
						'default' => true,
					),
					'showMin' => array(
						'type' => 'boolean',
					),
					'showMax' => array(
						'type' => 'boolean',
					),

					// Color Settings
					'labelColor' => array(
						'type' => 'string',
					),
					'labelColorClass' => array(
						'type' => 'string',
					),

					// Advanced Settings
					'autofocus' => array(
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

	// Returns a string with all attributes for the value display
	protected function get_value_display_attr(): string {
		$attr = array();

		// Type
		$attr[]	= 'type="number"';

		// ID
		if ( isset( $this->block_attr['name'] ) ) {
			$attr[]	= 'id="' . $this->block_attr['name'] . '_value_display"';
		}

		// Value
		if ( isset( $this->block_attr['defaultValue'] ) ) {
			$attr[]	= 'value="' . $this->block_attr['defaultValue'] . '"';
		}

		// Min
		if ( isset( $this->block_attr['min'] ) ) {
			$attr[]	= 'min="' . $this->block_attr['min'] . '"';
		}

		// Max
		if ( isset( $this->block_attr['max'] ) ) {
			$attr[]	= 'max="' . $this->block_attr['max'] . '"';
		}

		// Step
		if ( isset( $this->block_attr['step'] ) ) {
			$attr[]	= 'step="' . $this->block_attr['step'] . '"';
		}

		return implode( ' ', $attr );
	}

	protected function get_value_display(): string {
		if ( ! isset( $this->block_attr['showValue'] ) || ! $this->block_attr['showValue'] ) return '';

		return '<input ' . $this->get_value_display_attr() . ' />';
	}

	protected function get_min_display(): string {
		if ( 
			! isset( $this->block_attr['showMin'] ) 
			|| ! $this->block_attr['showMin'] 
			|| ! isset( $this->block_attr['min'] ) 
		) return '';

		return '<div class="min_display">' . $this->block_attr['min'] . '</div>';
	}

	protected function get_max_display(): string {
		if ( 
			! isset( $this->block_attr['showMax'] ) 
			|| ! $this->block_attr['showMax'] 
			|| ! isset( $this->block_attr['max'] ) 
		) return '';

		return '<div class="max_display">' . $this->block_attr['max'] . '</div>';
	}
}