<div class="<?php echo $this->get_wrapper_class(); ?>">
    <?php if ( isset( $attr['label'] ) && ! empty( $attr['label'] ) ) { ?>
        <label <?php echo $this->get_label_attr(); ?>>
            <?php echo $attr['label']; ?>
        </label>
    <?php } ?>
    <div class="input_wrapper">
        <div class="range_wrapper">
        <?php echo $this->get_min_display(); ?>
        <input <?php echo $this->get_input_attr(); ?> />
        <?php echo $this->get_max_display(); ?>
        </div>
        <?php echo $this->get_value_display(); ?>
    </div>
</div>