<?php
namespace Jet_Engine\Modules\Maps_Listings;

class Settings {

	public $settings_key = 'jet-engine-maps-settings';
	public $settings     = false;
	public $defaults     = array(
		'api_key'             => null,
		'disable_api_file'    => false,
		'enable_preload_meta' => false,
		'preload_meta'        => '',
	);

	/**
	 * Constructor for the class
	 */
	public function __construct() {

		add_action( 'jet-engine/dashboard/tabs', array( $this, 'register_settings_tab' ), 99 );
		add_action( 'jet-engine/dashboard/assets', array( $this, 'register_settings_js' ) );

		add_action( 'wp_ajax_jet_engine_maps_save_settings', array( $this, 'save_settings' ) );

	}

	/**
	 * Ajax callback to save settings
	 *
	 * @return [type] [description]
	 */
	public function save_settings() {

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => __( 'Access denied', 'jet-engine' ) ) );
		}

		$nonce = ! empty( $_REQUEST['nonce'] ) ? $_REQUEST['nonce'] : false;

		if ( ! $nonce || ! wp_verify_nonce( $nonce, $this->settings_key ) ) {
			wp_send_json_error( array( 'message' => __( 'Nonce validation failed', 'jet-engine' ) ) );
		}

		$settings     = ! empty( $_REQUEST['settings'] ) ? $_REQUEST['settings'] : array();
		$boolean_keys = array( 'disable_api_file', 'enable_preload_meta' );

		foreach ( $settings as $key => $value ) {
			if ( in_array( $key, $boolean_keys ) ) {
				$settings[ $key ] = filter_var( $value, FILTER_VALIDATE_BOOLEAN );
			}
		}

		update_option( $this->settings_key, $settings, false );

		wp_send_json_success( array( 'message' => __( 'Settings saved', 'jet-engine' ) ) );

	}

	/**
	 * Register settings JS file
	 *
	 * @return [type] [description]
	 */
	public function register_settings_js() {

		wp_enqueue_script(
			'jet-engine-maps-settings',
			jet_engine()->plugin_url( 'assets/js/admin/dashboard/maps-settings.js' ),
			array( 'cx-vue-ui' ),
			jet_engine()->get_version(),
			true
		);

		wp_localize_script(
			'jet-engine-maps-settings',
			'JetEngineMapsSettings',
			array(
				'settings' => $this->get_all(),
				'_nonce'   => wp_create_nonce( $this->settings_key ),
			)
		);

		add_action( 'admin_footer', array( $this, 'print_templates' ) );

	}

	/**
	 * Print VU template for maps settings
	 *
	 * @return [type] [description]
	 */
	public function print_templates() {
		?>
		<script type="text/x-template" id="jet_engine_maps_settings">
			<div>
				<cx-vui-input
					label="<?php _e( 'API Key', 'jet-engine' ); ?>"
					description="<?php _e( 'Google maps API key. Video tutorial about creating Google Maps API key <a href=\'https://www.youtube.com/watch?v=t2O2a2YiLJA\' target=\'_blank\'>here</a>. <br>Please make sure <b>Geocoding API</b> is enabled for your API key.', 'jet-engine' ); ?>"
					:wrapper-css="[ 'equalwidth' ]"
					size="fullwidth"
					@on-input-change="updateSetting( $event.target.value, 'api_key' )"
					:value="settings.api_key"
				></cx-vui-input>
				<cx-vui-switcher
					label="<?php _e( 'Disable Google Maps API JS file', 'jet-engine' ); ?>"
						description="<?php _e( 'Disable Google Maps API JS file, if it already included by another plugin or theme', 'jet-engine' ); ?>"
					:wrapper-css="[ 'equalwidth' ]"
					@input="updateSetting( $event, 'disable_api_file' )"
					:value="settings.disable_api_file"
				></cx-vui-switcher>
				<cx-vui-switcher
					label="<?php _e( 'Preload coordinates by address', 'jet-engine' ); ?>"
						description="<?php _e( 'We recommend to enable this option and set meta field to preload coordinates for. This is required to avoid optimize Google Maps API requests. Note: only JetEngine meta fields could be preloaded', 'jet-engine' ); ?>"
					:wrapper-css="[ 'equalwidth' ]"
					@input="updateSetting( $event, 'enable_preload_meta' )"
					:value="settings.enable_preload_meta"
				></cx-vui-switcher>
				<cx-vui-textarea
					label="<?php _e( 'Meta fields to preload', 'jet-engine' ); ?>"
					description="<?php _e( 'Comma separated meta fields list which is contain addresses to preload', 'jet-engine' ); ?>"
					:wrapper-css="[ 'equalwidth' ]"
					size="fullwidth"
					v-if="settings.enable_preload_meta"
					@on-input-change="updateSetting( $event.target.value, 'preload_meta' )"
					:value="settings.preload_meta"
				></cx-vui-textarea>
			</div>
		</script>
		<?php
	}

	/**
	 * Returns all settings
	 *
	 * @return [type] [description]
	 */
	public function get_all() {

		if ( false === $this->settings ) {
			$this->settings = get_option( $this->settings_key, $this->defaults );
		}

		return $this->settings;

	}

	/**
	 * Returns specidic setting
	 *
	 * @param  [type] $setting [description]
	 * @return [type]          [description]
	 */
	public function get( $setting ) {

		$settings = $this->get_all();

		if ( isset( $settings[ $setting ] ) ) {
			return $settings[ $setting ];
		} elseif ( isset( $this->defaults[ $setting ] ) ) {
			return $this->defaults[ $setting ];
		} else {
			return false;
		}

	}

	/**
	 * Register settings tab
	 *
	 * @return [type] [description]
	 */
	public function register_settings_tab() {
		?>
		<cx-vui-tabs-panel
			name="maps_settings"
			label="<?php _e( 'Maps Settings', 'jet-engine' ); ?>"
			key="maps_settings"
		>
			<keep-alive>
				<jet-engine-maps-settings></jet-engine-maps-settings>
			</keep-alive>
		</cx-vui-tabs-panel>
		<?php
	}

}
