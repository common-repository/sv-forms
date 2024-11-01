<?php
namespace sv_forms;

class spam_guard_check extends modules {
	public function init() {}

    // Checks all active spam guard features, if one of them was triggered
	// Returns true when a trap was triggered and false if not
	public function run_check( object $attr, array $data ): bool {

		// Checks Honeypot
		if ( $attr->sgHoneypot ) {
			$input_name = $this->get_root()->get_prefix( 'sg_hp' );
			$input_value = $this->get_input_value( $input_name, $data );

			if ( $input_value && $this->check_honeypot( $input_value ) ) return true;
		}

		// Checks Time Trap
		if ( $attr->sgTimeTrap ) {
			$input_name = $this->get_root()->get_prefix( 'sg_tt' );
			$input_value = $this->get_input_value( $input_name, $data );

			if ( $input_value && $this->check_time_trap( $input_value, $attr->sgTimeTrapWindow ) ) return true;
        }

		return false;
	}

    // Checks if the honeypot was triggered
	private function check_honeypot( string $value ): bool {
		return ! empty( $value ) || strlen( $value ) > 0 ? true : false;
	}

	// Checks if the time tramp was triggered
	private function check_time_trap( string $encrypted_timestamp, int $time_trap_window ): bool {
		$current_timestamp = time();
		$form_timestamp = $this->decrypt_string( $encrypted_timestamp );

		if ( 
			! is_numeric( $form_timestamp )
			|| ( $current_timestamp - $form_timestamp <= $time_trap_window )
		) {
			return true;
		}

		return false;
	}
}