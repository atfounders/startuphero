<?php wp_nonce_field( $this->get_field_id( 'update_form' ) );?>
<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', $this->text_domain ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'stuff' ); ?>"><?php printf(
	__( 'Paste your EMBED code from <a href="%s">Open Table Reservations</a> here:', $this->text_domain ),
	'http://www.otrestaurant.com/marketing/ReservationWidget" target="_blank'
); ?></label>

	<textarea class="widefat" id="<?php echo $this->get_field_id( 'stuff' ); ?>" name="<?php echo $this->get_field_name( 'stuff' ); ?>"><?php echo esc_textarea( $this->build_element( $instance ) ); ?></textarea>
</p>
