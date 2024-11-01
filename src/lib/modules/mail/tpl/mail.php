<?php
require( $this->get_path( 'tpl/mail_header.php' ) );
echo $this->cleanup_mail_content( $this->replace_input_values( $attr['content'], $data ) );
require( $this->get_path( 'tpl/mail_footer.php' ) );