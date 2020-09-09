<?php
/**
 * input[type="hidden"] template
 */

$this->add_attribute( 'placeholder', $args['placeholder'] );
$this->add_attribute( 'value', $args['default'] );
$this->add_attribute( 'required', $this->get_required_val( $args ) );
$this->add_attribute( 'name', $args['name'] );
$this->add_attribute( 'type', $args['field_type'] );

if ( ! empty( $args['minlength'] ) ) {
	$this->add_attribute( 'minlength', $args['minlength'] );
}

if ( ! empty( $args['maxlength'] ) ) {
	$this->add_attribute( 'maxlength', $args['maxlength'] );
}

?>
<input class="jet-form__field text-field"<?php $this->render_attributes_string(); ?>>