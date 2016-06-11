<?php
/**
 *	GIVESF Asset Loader
 *	@since 1.0
 *
 **/

add_action('wp_enqueue_scripts', 'give_promin_scripts');

function give_promin_scripts() {
	if (is_singular('give_forms')) {
		wp_enqueue_script('give-promin-js', GIVESF_URL . '/assets/vendor/promin/givesf-promin.js', array(), '', false);
		wp_enqueue_style('give-promin-css', GIVESF_URL . '/assets/vendor/promin/givesf-promin.css');
	}
}

add_action('wp_footer', 'give_promin_init');

function give_promin_init() { 
	if (is_singular('give_forms')) { ?>

		<script>
			jQuery(document).ready(function( $ ) {

				// Cache the form
				var $form = $('.give-form');

				// Stuff for the progress bar
				var $bar = $('.progress-bar .bar');
				var steps = $('.pm-step').length;

				// Initialize Promin
				$form.promin({
				    // Want to update the bar on every change
				    events: {
				        change: function(i) {
				            $bar.css('width', (i / steps * 100) + '%');
				            $('.pm-num-steps').text(i + '/' + steps);
				        }
				    }
				});

				// Tell the button to go to the next step
				$('#promin-next').on('click', function() {
				    $form.promin('next');
				});

				$('#promin-prev').on('click', function() {
				    $form.promin('previous');
				});

			});
		</script>

<?php }

}

// All the Promin BEFORE steps
add_action('give_before_donation_levels', 'give_promin_before');
add_action('give_payment_mode_before_gateways_wrap', 'give_promin_before');
add_action('give_purchase_form_before_personal_info', 'give_promin_before');
add_action('give_purchase_form_before_submit', 'give_promin_before');

// All the Promin AFTER steps
add_action('give_after_donation_levels', 'give_promin_after');
add_action('give_payment_mode_after_gateways_wrap', 'give_promin_after');
add_action('give_purchase_form_after_personal_info', 'give_promin_after');
add_action('give_purchase_form_after_submit', 'give_promin_after');


function give_promin_before() {
	$before = '<div class="pm-step">';

	echo $before;
}

function give_promin_after() {
	$after = '</div><!-- End Promin Step -->';

	echo $after;
}

add_action('give_post_form_output', 'give_promin_nav_prog');

function give_promin_nav_prog() {
?>
	<div class="progress-bar">
		<span class="bar" style="width: 33.3333%;"></span>
	</div>
	<div class="pm-num-steps">
	</div>
	<div class="givesf-pm-nav">
		<input type="button" id="promin-prev" value="Previous step">
		<input type="button" id="promin-next" value="Next step">
	</div>

<?php 

}