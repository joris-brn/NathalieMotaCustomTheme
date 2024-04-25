<div id="modale" class="popup-overlay">
	<div class="popup-salon">
		<div class="popup-header">
		<img src="<?php echo  get_stylesheet_directory_uri() . '/assets/images/contactmodale.png'; ?> " alt="Contact">
		</div>
		<?php
		// On insère le formulaire de demandes de renseignements
		echo do_shortcode('[contact-form-7 id="11dc64f" title="Formulaire pop-up"]');
		?>
	</div>
</div>