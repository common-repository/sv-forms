<?php
namespace sv_forms;

class spam_guard extends sv_forms {
	protected $block_attr = array();

	public function init() {
		$this->register_block();
	}

	public function render_block( array $attr ): string {
		$this->block_attr = $attr;

		ob_start();
		
		require( $this->get_path( 'lib/frontend/tpl/spam_guard.php' ) );

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	private function register_block() {
		register_block_type(
			'straightvisions/sv-forms-spam-guard', array(
				'editor_script' 	=> 'sv-forms-block',
				'editor_style'  	=> 'sv-forms-block-editor',
				'render_callback'	=> array( $this, 'render_block' ),
				'attributes'		=> array(
					// Honeypot Settings
					'honeypot' => array(
						'type' => 'boolean',
						'default' => true,
					),

					// Time Trap Settings
					'timeTrap' => array(
						'type' => 'boolean',
						'default' => true,
					),
					'timeTrapTimeWindow' => array(
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

	// ###### Spam Guard - Features ######

	// Creates trap input fields, that will be hidden via JS
	private function honeypot() {
		echo '<input type="text" name="' .  $this->get_root()->get_prefix( 'sg_hp' ) . '" value="" tabindex="-1" autocomplete="off" style="display:none;" />';
	}

	// Creates a hidden input field with an encrypted timestamp
	private function time_trap() {
		$encrypted_timestamp = $this->encrypt_string( time() );

		echo '<input type="hidden" name="' . $this->get_root()->get_prefix( 'sg_tt' ) . '" value="' . $encrypted_timestamp . '" tabindex="-1" autocomplete="off" />';
	}

	// Starts the spam guard traps, base on the spam guard level
	protected function start_spam_guard() {
		if ( $this->block_attr['honeypot'] ) $this->honeypot();
		if ( $this->block_attr['timeTrap'] ) $this->time_trap();
	}
}