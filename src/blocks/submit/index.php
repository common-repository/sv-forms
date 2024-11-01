<?php
namespace sv_forms;

class submit extends sv_forms {
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
		
		require( $this->get_path( 'lib/frontend/tpl/submit.php' ) );

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	public function load_block_assets() {
		if ( ! is_admin() ) {
			$this->get_parent()->get_script( 'submit' )->set_is_enqueued();
		}
	}

	private function register_block() {
		register_block_type(
			'straightvisions/sv-forms-submit', array(
				'editor_script' 	=> 'sv-forms-block',
				'editor_style'  	=> 'sv-forms-block-editor',
				'render_callback'	=> array( $this, 'render_block' ),
				'attributes'		=> array(
					// Content
					'content' => array(
						'type' => 'string',
						'default' => __( 'Send', 'sv_forms' ),
					),

					// Color Settings
					'textColor' => array(
						'type' => 'string',
						'default' => '#000000'
					),
					'textColorClass'=> array(
						'type' => 'string',
					),
					'backgroundColor' => array(
						'type' => 'string',
						'default' => '#FFFFFF'
					),
					'backgroundColorClass' => array(
						'type' => 'string',
					),
					'borderColor' => array(
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

	// Returns a string with all attributes for the button
	protected function get_button_attr(): string {
		$attr = array();

		// Class
		$class = array();

		// Text Color
		if ( 
			isset( $this->block_attr['textColorClass'] ) && empty($this->block_attr['textColorClass']) === false ) {
            $class[] = $this->block_attr['textColorClass'];
		}

		// Background Color
		if ( isset( $this->block_attr['backgroundColorClass'] ) && empty($this->block_attr['backgroundColorClass']) === false ) {
            $class[] = $this->block_attr['backgroundColorClass'];
		}
		
		if ( empty( $class ) === false ) {
			$attr[]	= 'class="' . implode( ' ', $class ) . '"';
		}

		// Style
		$style = array();

		// Text Color
		if ( isset( $this->block_attr['textColor'] ) && empty($this->block_attr['textColor']) === false ) {
			$style[] = 'color:' . $this->block_attr['textColor'];
		}

		// Background Color
		if ( isset( $this->block_attr['backgroundColor'] ) && empty($this->block_attr['backgroundColor']) === false ) {
			$style[] = 'background-color:' . $this->block_attr['backgroundColor'];
		}

		// Border Color
		if ( isset( $this->block_attr['borderColor'] ) && empty($this->block_attr['borderColor']) === false ) {
			$style[] = 'border-color:' . $this->block_attr['borderColor'];
		}

		// Border Style
		if ( isset( $this->block_attr['borderStyle'] ) && empty($this->block_attr['borderStyle']) === false ) {
			$style[] = 'border-style:' . $this->block_attr['borderStyle'];
		}

		// Border Width Top
		if ( isset( $this->block_attr['borderWidthTop'] ) && empty($this->block_attr['borderWidthTop']) === false ) {
			$style[] = 'border-top-width:' . $this->block_attr['borderWidthTop'] . 'px';
		}

		// Border Width Right
		if ( isset( $this->block_attr['borderWidthRight'] ) && empty($this->block_attr['borderWidthRight']) === false ) {
			$style[] = 'border-right-width:' . $this->block_attr['borderWidthRight'] . 'px';
		}

		// Border Width Bottom
		if ( isset( $this->block_attr['borderWidthBottom'] ) && empty($this->block_attr['borderWidthBottom']) === false ) {
			$style[] = 'border-bottom-width:' . $this->block_attr['borderWidthBottom'] . 'px';
		}

		// Border Width Left
		if ( isset( $this->block_attr['borderWidthLeft'] ) && empty($this->block_attr['borderWidthLeft']) === false ) {
			$style[] = 'border-left-width:' . $this->block_attr['borderWidthLeft'] . 'px';
		}

		// Border Radius
		if ( isset( $this->block_attr['borderRadius'] ) && empty($this->block_attr['borderRadius']) === false ) {
			$style[] = 'border-radius:' . $this->block_attr['borderRadius'] . 'px';
		}

		if ( ! empty( $style ) ) {
			$attr[] = 'style="' . implode( ';', $style ) . '"';
		}

		return implode( ' ', $attr );
	}
}