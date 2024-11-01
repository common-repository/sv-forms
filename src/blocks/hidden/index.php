<?php
namespace sv_forms;

class hidden extends sv_forms {
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
		
		require( $this->get_path( 'lib/frontend/tpl/hidden.php' ) );

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	public function load_block_assets() {
		if ( ! is_admin() ) {
			$this->get_parent()->get_script( 'hidden' )->set_is_enqueued();
		}
	}

	private function register_block() {
		register_block_type(
			'straightvisions/sv-forms-hidden', array(
				'editor_script' 	=> 'sv-forms-block',
				'editor_style'  	=> 'sv-forms-block-editor',
				'render_callback'	=> array( $this, 'render_block' ),
				'attributes'		=> array(
					// Input Settings
					'defaultValue' => array(
						'type' => 'string',
					),
					'name' => array(
						'type' => 'string',
					),
					'type' => array(
						'type' => 'string',
						'default' => 'hidden',
					),

					// Advanced Settings
					'className' => array(
						'type' => 'string',
					),
				),
			)
		);
	}

	// Returns a string with all attributes for the input
	protected function get_input_attr(): string {		
		$attr = array();
		$block_attr = $this->block_attr;
		// Type
		if ( isset( $block_attr['type'] ) ) {
			$attr[] = 'type="' . $block_attr['type'] .  '"';
		}

		// Name
		if ( isset( $block_attr['name'] ) ) {
			$attr[] = 'name="' . $block_attr['name'] . '"';
		}else{
			$attr[] = 'name="unknown"'; // fallback
		}

		// Value
		$default_value = isset( $block_attr['defaultValue'] ) ? $block_attr['defaultValue'] :  '';
		$attr[]	= 'value="' . $this->get_root()->sv_forms->get_input_value_from_url_params( $block_attr['name'] ?? '', $default_value ) . '"';

		$attr[] = 'tabindex="-1" autocomplete="off"';

		// Class
		$class 		= array();
		$class[]	= 'wp-block-straightvisions-sv-forms-hidden';

		// Additional Classes
		if ( isset( $block_attr['className'] ) ) { 
			$class[] = $block_attr['className'];
		}
		
		if ( ! empty( $class ) ) {
			$attr[]	= 'class="' . implode( ' ', $class ) . '"';
		}

		return implode( ' ', $attr );
	}
}