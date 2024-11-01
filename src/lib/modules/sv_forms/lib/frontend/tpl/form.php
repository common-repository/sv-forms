<?php 
$form_id = isset( $attr['formId'] ) ? $attr['formId'] : ''; 
$form_css_selector = 'form.wp-block-straightvisions-sv-forms-form[data-sv_forms_form_id="' . $form_id . '"]';
?>

<form method="POST" class="<?php echo $this->get_form_class(); ?>" enctype="multipart/form-data" data-sv_forms_form_id="<?php echo $form_id; ?>">
    <input type="hidden" name="<?php echo $this->get_root()->get_prefix( 'form_id' ) ?>" value="<?php echo $form_id; ?>" tabindex="-1" autocomplete="off" />
	<input type="hidden" name="<?php echo $this->get_root()->get_prefix( 'post_id' ) ?>" value="<?php echo apply_filters('sv100_premium_insert_post_id', get_the_ID()); ?>" tabindex="-1" autocomplete="off" />
	<?php echo $content; ?>
    <style>
        <?php echo $form_css_selector; ?> input::placeholder,
        <?php echo $form_css_selector; ?> textarea::placeholder {
            color: <?php echo $attr['placeholderColor']; ?>;
        }
    </style>  
</form>