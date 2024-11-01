<?php
namespace sv_forms;

class admin_mail extends sv_forms {
	public function init() {
		$this->register_block();
	}

	private function register_block() {
		register_block_type(
			'straightvisions/sv-forms-admin-mail', array(
				'editor_script' 	=> 'sv-forms-block',
				'editor_style'  	=> 'sv-forms-block-editor',
				'render_callback'	=> function() { return ''; },
			)
		);
	}
}