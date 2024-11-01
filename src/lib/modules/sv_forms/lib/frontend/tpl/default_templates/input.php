<?php // Default Template for: text, email, password, url, number & date ?>
<div class="<?php echo $this->get_wrapper_class(); ?>">
    <?php if ( isset( $attr['label'] ) && ! empty( $attr['label'] ) ) { ?>
        <label <?php echo $this->get_label_attr(); ?>>
            <?php echo $attr['label']; ?>
        </label>
    <?php } ?>
    <input <?php echo $this->get_input_attr(); ?> />
</div>