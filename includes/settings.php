<?php

// If this file is called directly, abort. 
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

class Settings {

	public function __construct() {
		add_action('admin_menu', array( $this, 'bsf_stripe_settings_setup') );
		add_action('admin_init', array( $this, 'bsf_stripe_register_settings') );
	}

	function bsf_stripe_settings_setup() {
		add_options_page('Stripe Settings', 'Stripe Settings', 'manage_options', 'stripe-settings', array( $this, 'bsf_stripe_render_options_page') );
	}

	function bsf_stripe_render_options_page() {
		global $stripe_options;
		global $stripe_general_settings;
		?>
		<div class="wrap">
			<h2><?php _e('Stripe Settings', 'simple-stripe-payments'); ?></h2>
			<?php

				// Condition to check the current tab
                
                if( isset( $_GET[ 'tab' ] ) ) {
                    $active_tab = $_GET[ 'tab' ];
                }
                else {
                    $active_tab = 'api_settings';
                }

			?>
			<h2 class="nav-tab-wrapper">
	                <a href="?page=stripe-settings&tab=api_settings" class="nav-tab <?php echo $active_tab == 'api_settings' ? 'nav-tab-active' : ''; ?>"><?php _e('API Settings', 'simple-stripe-payments') ?></a>
	                <a href="?page=stripe-settings&tab=general_settings" class="nav-tab <?php echo $active_tab == 'general_settings' ? 'nav-tab-active' : ''; ?>"><?php _e('General Settings', 'simple-stripe-payments') ?></a>
	                <a href="?page=stripe-settings&tab=help_options" class="nav-tab <?php echo $active_tab == 'help_options' ? 'nav-tab-active' : ''; ?>"><?php _e('Help', 'simple-stripe-payments') ?></a>
	            </h2>
	        <?php

	        // Checking if active tab is api_settings

	        if( $active_tab == 'api_settings' ) {
	        ?>     
			<form method="post" action="options.php">
			
				<?php settings_fields('stripe_settings_group'); ?>
				
				<table class="form-table">
					<tbody>
						<tr valign="top">	
							<th scope="row" valign="top">
								<?php _e('Test Mode', 'simple-stripe-payments'); ?>
							</th>
							<td>
								<input id="stripe_settings[test_mode]" name="stripe_settings[test_mode]" type="checkbox" value="1" <?php checked(1, $stripe_options['test_mode']); ?> />
								<label class="description" for="stripe_settings[test_mode]"><?php _e('Check this to use the plugin in test mode.', 'test_mode'); ?></label>
							</td>
						</tr>
					</tbody>
				</table>	
				
				<h3 class="title"><?php _e('API Keys', 'simple-stripe-payments'); ?></h3>
				<table class="form-table">
					<tbody>
						<tr valign="top">	
							<th scope="row" valign="top">
								<?php _e('Live Secret', 'simple-stripe-payments'); ?>
							</th>
							<td>
								<input id="stripe_settings[live_secret_key]" name="stripe_settings[live_secret_key]" type="text" class="regular-text" value="<?php echo $stripe_options['live_secret_key']; ?>"/>
								<label class="description" for="stripe_settings[live_secret_key]"><?php _e('Paste your live secret key.', 'simple-stripe-payments'); ?></label>
							</td>
						</tr>
						<tr valign="top">	
							<th scope="row" valign="top">
								<?php _e('Live Publishable', 'simple-stripe-payments'); ?>
							</th>
							<td>
								<input id="stripe_settings[live_publishable_key]" name="stripe_settings[live_publishable_key]" type="text" class="regular-text" value="<?php echo $stripe_options['live_publishable_key']; ?>"/>
								<label class="description" for="stripe_settings[live_publishable_key]"><?php _e('Paste your live publishable key.', 'simple-stripe-payments'); ?></label>
							</td>
						</tr>
						<tr valign="top">	
							<th scope="row" valign="top">
								<?php _e('Test Secret', 'simple-stripe-payments'); ?>
							</th>
							<td>
								<input id="stripe_settings[test_secret_key]" name="stripe_settings[test_secret_key]" type="text" class="regular-text" value="<?php echo $stripe_options['test_secret_key']; ?>"/>
								<label class="description" for="stripe_settings[test_secret_key]"><?php _e('Paste your test secret key.', 'simple-stripe-payments'); ?></label>
							</td>
						</tr>
						<tr valign="top">	
							<th scope="row" valign="top">
								<?php _e('Test Publishable', 'simple-stripe-payments'); ?>
							</th>
							<td>
								<input id="stripe_settings[test_publishable_key]" name="stripe_settings[test_publishable_key]" class="regular-text" type="text" value="<?php echo $stripe_options['test_publishable_key']; ?>"/>
								<label class="description" for="stripe_settings[test_publishable_key]"><?php _e('Paste your test publishable key.', 'simple-stripe-payments'); ?></label>
							</td>
						</tr>
					</tbody>
				</table>	
				
				<!--<table class="form-table">
					<tbody>
						<tr valign="top">	
							<th scope="row" valign="top">
								<?php _e('Allow Recurring', 'simple-stripe-payments'); ?>
							</th>
							<td>
								<input id="stripe_settings[recurring]" name="stripe_settings[recurring]" type="checkbox" value="1" <?php checked(1, $stripe_options['recurring']); ?> />
								<label class="description" for="stripe_settings[recurring]"><?php _e('Check this to allow users to setup recurring payments.', 'simple-stripe-payments'); ?></label>
							</td>
						</tr>
					</tbody>
				</table> -->
				
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e('Save Options', 'mfwp_domain'); ?>" />
				</p>	
			</form>
			<div class="stripe-shortcode-display">
			<h2><?php _e('Generated Short Code', 'simple-stripe-payments'); ?></h2>
	    	<pre id="stripe-shortcode-generator" style="padding:15px;background:#666;color:#fff;">[simple_stripe_payments_form]</pre>
	    	</div>
		<?php
		}

	    // Checking if active tab is general settings

	    if( $active_tab == 'general_settings' ) {
		?>
		<form method="post" action="options.php">
			
				<?php settings_fields('stripe_general_settings_group'); 
	            wp_enqueue_script( 'maintenance_custom_js', plugins_url( '../assets/js/jquery.custom.js', __FILE__ ), array( 'jquery', 'wp-color-picker' ), '', true  );
				?>	
				
				<table class="form-table">
					<tbody>
						<tr valign="top">	
							<th scope="row" valign="top">
								<?php _e('Button Title', 'simple-stripe-payments'); ?>
							</th>
							<td>

								<input id="stripe_general_settings[form_button_title]" name="stripe_general_settings[form_button_title]" type="text" class="regular-text" value="<?php echo $stripe_general_settings['form_button_title']; ?>"/>
								<p class="input-desc">The name of the button.</p>
								<label class="description" for="stripe_general_settings[form_button_title]"></label>
							</td>
						</tr>
						<tr valign="top">	
							<th scope="row" valign="top">
								<?php _e('Button Color', 'simple-stripe-payments'); ?>
							</th>
							<td>
								<input id="stripe_general_settings[form_button_color] image_url" name="stripe_general_settings[form_button_color]" type="hidden" class="regular-text cpa-color-picker" value="<?php echo $stripe_general_settings['form_button_color']; ?>"/>
								<p class="input-desc">Select the color of the Button.</p>

								<label class="description" for="stripe_general_settings[form_button_color]"></label>
							</td>
						</tr>
						<tr valign="top">	
							<th scope="row" valign="top">
								<?php _e('Button Color on hover', 'simple-stripe-payments'); ?>
							</th>
							<td>
								<input id="stripe_general_settings[form_button_hover_color] image_url" name="stripe_general_settings[form_button_hover_color]" type="hidden" class="regular-text cpa-color-picker" value="<?php echo $stripe_general_settings['form_button_hover_color']; ?>"/>
								<p class="input-desc">Select the hover color of the Button.</p>
								<label class="description" for="stripe_general_settings[form_button_hover_color]"></label>
							</td>
						</tr>
						<tr valign="top">	
							<th scope="row" valign="top">
								<?php _e('Site Title', 'simple-stripe-payments'); ?>
							</th>
							<td>
								<input id="stripe_general_settings[stripe_title]" name="stripe_general_settings[stripe_title]" type="text" class="regular-text" value="<?php echo $stripe_general_settings['stripe_title']; ?>"/>
								<p class="input-desc">The name of your store or website.</p>
								<label class="description" for="stripe_general_settings[stripe_title]"></label>
							</td>
						</tr>
						<tr valign="top">	
							<th scope="row" valign="top">
								<?php _e('Site Tagline', 'simple-stripe-payments'); ?>
							</th>
							<td>
								<input id="stripe_general_settings[tag_line_for_stripe]" name="stripe_general_settings[tag_line_for_stripe]" type="text" class="regular-text" value="<?php echo $stripe_general_settings['tag_line_for_stripe']; ?>"/>
								<p class="input-desc">The tagline of your store or website.</p>

								<label class="description" for="stripe_general_settings[tag_line_for_stripe]"></label>
							</td>
						</tr>
						<tr valign="top">	
							<th scope="row" valign="top">
								<?php _e('Payment Button Label', 'simple-stripe-payments'); ?>
							</th>
							<td>
								<input id="stripe_general_settings[stripe_pay_button]" name="stripe_general_settings[stripe_pay_button]" type="text" class="regular-text" value="<?php echo $stripe_general_settings['stripe_pay_button']; ?>"/>
								<p class="input-desc">The name on the stripe payment button.</p>
								<label class="description" for="stripe_general_settings[stripe_pay_button]"></label>
							</td>
						</tr>
						<tr valign="top">	
							<th scope="row" valign="top">
								<?php _e('Currency Code', 'simple-stripe-payments'); ?>
							</th>
							<td>
								<input id="stripe_general_settings[stripe_currency_type]" name="stripe_general_settings[stripe_currency_type]" type="text" class="regular-text" value="<?php echo $stripe_general_settings['stripe_currency_type']; ?>"/>
								<p class="input-desc">Specify a currency using it's <a href="https://support.stripe.com/questions/which-currencies-does-stripe-support#currencygroup1" target="_blank">3-letter Code</a>.</p>
								<label class="description" for="stripe_general_settings[stripe_currency_type]"></label>
							</td>
						</tr>
					</tbody>
				</table>
				
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e('Save Options', 'simple-stripe-payments'); ?>" />
				</p>	
			</form>
		<?php 
		}
		// Checking if tab is help options
		if( $active_tab == 'help_options' ) {
		?>
		<h1>Help</h1>
		<?php 
		}
	}

		
	function bsf_stripe_register_settings() {
		// creates our settings in the options table
		register_setting('stripe_settings_group', 'stripe_settings');
		register_setting('stripe_general_settings_group', 'stripe_general_settings');
	}

}
new Settings();
?>

