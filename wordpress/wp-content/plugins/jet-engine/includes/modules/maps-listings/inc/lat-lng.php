<?php
namespace Jet_Engine\Modules\Maps_Listings;

class Lat_Lng {

	public $geo_api_url = 'https://maps.googleapis.com/maps/api/geocode/json';
	public $meta_key    = '_jet_maps_coord';

	/**
	 * Constructor for the class
	 */
	public function __construct() {
		$this->hook_preload();
	}

	/**
	 * Hook meta-fields preloading
	 *
	 * @return [type] [description]
	 */
	public function hook_preload() {

		$preload = Module::instance()->settings->get( 'enable_preload_meta' );

		if ( ! $preload ) {
			return;
		}

		$preload_fields = Module::instance()->settings->get( 'preload_meta' );

		if ( empty( $preload_fields ) ) {
			return;
		}

		$preload_fields = explode( ',', $preload_fields );

		foreach ( $preload_fields as $field ) {
			$field = trim( $field );
			add_action( 'cx_post_meta/before_save_meta/' . $field, array( $this, 'preload' ), 10, 2 );
		}

	}

	/**
	 * Preload field address
	 *
	 * @param  [type] $post_id [description]
	 * @param  [type] $address [description]
	 * @return [type]          [description]
	 */
	public function preload( $post_id, $address ) {

		if ( empty( $address ) ) {
			return;
		}

		$coord = $this->get( $post_id, $address );

	}

	/**
	 * Returns remote coordinates by location
	 *
	 * @param  [type] $location [description]
	 * @return [type]           [description]
	 */
	public function get_remote( $location ) {

		$api_key = Module::instance()->settings->get( 'api_key' );

		// Do nothing if api key not provided
		if ( ! $api_key ) {
			return false;
		}

		// Prepare request data
		$location    = esc_attr( $location );
		$api_key     = esc_attr( $api_key );
		$request_url = add_query_arg(
			array(
				'address' => urlencode( $location ),
				'key'     => urlencode( $api_key )
			),
			esc_url( $this->geo_api_url )
		);

		$response = wp_remote_get( $request_url );
		$json     = wp_remote_retrieve_body( $response );
		$data     = json_decode( $json, true );

		$coord = isset( $data['results'][0]['geometry']['location'] )
			? $data['results'][0]['geometry']['location']
			: false;

		if ( ! $coord ) {
			return false;
		}

		return $coord;

	}

	/**
	 * Get not-post related coordinates
	 *
	 * @param  [type] $location [description]
	 * @return [type]           [description]
	 */
	public function get_from_transient( $location ) {

		$key   = md5( $location );
		$coord = get_transient( $key );

		if ( ! $coord ) {

			$coord = $this->get_remote( $location );

			if ( $coord ) {
				set_transient( $key, $coord, WEEK_IN_SECONDS );
			}

		}

		return $coord;

	}

	/**
	 * Returns lat and lang for passed address
	 *
	 * @param  [type] $address [description]
	 * @return [type]          [description]
	 */
	public function get( $post_id, $location ) {

		$key   = md5( $location );
		$meta  = get_post_meta( $post_id, $this->meta_key, true );

		if ( ! empty( $meta ) && $key === $meta['key'] ) {
			return $meta['coord'];
		}

		$coord = $this->get_remote( $location );

		if ( ! $coord ) {
			return false;
		}

		update_post_meta( $post_id, $this->meta_key, array(
			'key'   => $key,
			'coord' => $coord,
		) );

		return $coord;

	}

}
