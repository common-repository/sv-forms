<?php
namespace sv_forms;

class files extends modules {
	protected static $upload_dir;
	protected static $temp_dirs = array();
	protected $temp_dir;

	public function init() {
		$this->create_dir();
	}

	// Creates a folder in wp-content/uploads
	private function create_dir(): files {
		$upload_dir = wp_upload_dir()['basedir'] . '/sv-forms';
		$temp_dir	= $upload_dir . '/tmp';

		if ( wp_mkdir_p( $upload_dir ) ) {
			if ( wp_mkdir_p( $temp_dir ) ) {
				$this->set_dir( $temp_dir );
			}	
		}

		return $this;
	}

	// Sets the path for the plugin upload dir
	private function set_dir( string $path ): files {
		$this::$upload_dir = trailingslashit( $path );

		return $this;
	}

	// Return the path to the plugin upload dir
	public function get_dir(): string {
		return $this::$upload_dir;
	}

	// Creates a temporary directory
	private function create_temp_dir( string $name ): string {
		$temp_dir = '';

		if ( ! wp_mkdir_p( $this->get_dir() ) ) {
			$this->create_dir();
		}

		$this->set_temp_dir( $this->get_dir() . $name );

		wp_mkdir_p( $this->get_temp_dir() );

		return $this->get_temp_dir();
	}

	// Sets the path for the temp dir
	private function set_temp_dir( string $path ): files {
		$this->temp_dir = trailingslashit( $path );

		return $this;
	}

	// Return the path to the temp dir
	public function get_temp_dir(): string {
		return $this->temp_dir;
	}

	// Uploads a file to wordpress
	public function upload_file( array $file ) {
		$temp_dir_name = pathinfo( $file['tmp_name'] )['filename'];
		$temp_dir_path = $this->create_temp_dir( $temp_dir_name );

		if ( ! is_dir( $temp_dir_path ) ) return false;

		$destination 	= trailingslashit( $temp_dir_path ) . $file['name'];
		$moved_file 	= move_uploaded_file( $file['tmp_name'], $destination );

		if ( ! $moved_file ) return false;

		$this->add_to_temp_dirs();

		return $destination;
	}

	// Adds the path of the temp dir to the temp dirs array
	private function add_to_temp_dirs(): files {
		$this::$temp_dirs[] = $this->get_temp_dir();

		return $this;
	}

	// Returns the temp dirs array
	private function get_temp_dirs(): array {
		return $this::$temp_dirs;
	}

	// Deletes all temporary directories and its content
	public function delete_files() {
		foreach( $this->get_temp_dirs() as $path ) {
			$files = glob( $path . '/*' );

			foreach ( $files as $file ) {
				unlink( $file );
			}

			rmdir( $path );
		}
	}
}