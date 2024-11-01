<?php
	namespace sv_forms;

	class update extends modules {
		public function init() {
			add_action( 'admin_init', array( $this, 'admin_init' ) );
		}

		// register update routines
		public function admin_init() {
			if($this->get_previous_version() < 2100) {
				$this->register_cron(2100);
			}
		}
		public function v2100(){
			$posts	= get_posts([
				'post_type'     => 'sv_forms_submit',
				'numberposts'   => 1000,
				'meta_key'		=> '_sv_forms_form_data'
			]);

			if(!$posts){
				$this->update_version(2100);
				wp_clear_scheduled_hook( $this->get_prefix('2100'));
				return;
			}

			foreach($posts as $post){
				$form_data	= json_decode(get_post_meta($post->ID, '_sv_forms_form_data', true), true);

				foreach($form_data as $field){
					update_post_meta($post->ID, '_sv_forms_'.$field['name'], $field['value']);
					delete_post_meta($post->ID, '_sv_forms_form_data');
				}
			}
		}
		private function register_cron(int $v){
			add_action( $this->get_prefix($v), array($this, 'v'.$v ));

			if ( ! wp_next_scheduled( $this->get_prefix($v) ) ) {
				wp_schedule_event( time(), 'hourly',  $this->get_prefix($v) );
			}
		}
		public function get_prefix(string $append = ''): string{
			return parent::get_prefix('v'.$append);
		}
	}