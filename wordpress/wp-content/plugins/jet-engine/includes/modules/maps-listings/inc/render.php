<?php
namespace Jet_Engine\Modules\Maps_Listings;

class Render extends \Jet_Engine_Render_Listing_Grid {

	public function get_name() {
		return 'jet-engine-maps-listing';
	}

	public function default_settings() {
		return array(
			'lisitng_id'                 => '',
			'address_field'              => '',
			'auto_center'                => true,
			'custom_center'              => '',
			'custom_zoom'                => 11,
			'posts_query'                => array(),
			'meta_query_relation'        => 'AND',
			'tax_query_relation'         => 'AND',
			'hide_widget_if'             => '',
			'popup_width'                => 320,
			'popup_offset'               => 40,
			'marker_type'                => 'image',
			'marker_image'               => null,
			'marker_icon'                => null,
			'marker_label_type'          => 'post_title',
			'marker_label_field'         => '',
			'marker_label_field_custom'  => '',
			'marker_label_text'          => '',
			'marker_label_format_cb'     => 0,
			'marker_label_custom'        => false,
			'marker_label_custom_output' => '%s',
			'popup_pin'                  => false,
		);
	}

	/**
	 * Get posts
	 *
	 * @param  array $settings
	 * @return array
	 */
	public function get_posts( $settings ) {

		$args  = $this->build_posts_query_args_array( $settings );
		$query = new \WP_Query( $args );

		return $query->posts;

	}

	/**
	 * Returns encoded map data
	 *
	 * @param  array  $settings [description]
	 * @return [type]           [description]
	 */
	public function get_map_data( $settings = array() ) {

		$result = array();

		return htmlspecialchars( json_encode( $result ) );

	}

	/**
	 * Returns map markers list
	 *
	 * @param  array  $query    [description]
	 * @param  array  $settings [description]
	 * @return [type]           [description]
	 */
	public function get_map_markers( $query = array(), $settings = array(), $json = true ) {

		$result        = array();
		$address_field = ! empty( $settings['address_field'] ) ? $settings['address_field'] : false;

		if ( $address_field ) {
			foreach ( $query as $post ) {

				$address = get_post_meta( $post->ID, $address_field, true );

				if ( ! $address ) {
					continue;
				}

				$latlang = Module::instance()->lat_lng->get( $post->ID, $address );

				if ( empty( $latlang ) ) {
					continue;
				}

				$result[] = array(
					'id'            => $post->ID,
					'latLang'       => $latlang,
					'label'         => $this->get_marker_label( $post->ID, $settings ),
					'custom_marker' => false,
				);

			}
		}

		$result = apply_filters( 'jet-engine/maps-listing/map-markers', $result );

		if ( $json ) {
			return htmlspecialchars( json_encode( $result ) );
		} else {
			return $result;
		}

	}

	/**
	 * Returns marker label
	 *
	 * @param  [type] $post_id  [description]
	 * @param  array  $settings [description]
	 * @return [type]           [description]
	 */
	public function get_marker_label( $post_id, $settings = array() ) {

		$type = ! empty( $settings['marker_type'] ) ? $settings['marker_type'] : 'image';

		if ( 'text' !== $type ) {
			return false;
		}

		$label_type = ! empty( $settings['marker_label_type'] ) ? $settings['marker_label_type'] : 'post_title';
		$result     = '';

		switch ( $label_type ) {
			case 'post_title':
				$result = get_the_title( $post_id );
				break;

			case 'meta_field':

				$field = ! empty( $settings['marker_label_field'] ) ? $settings['marker_label_field'] : null;

				if ( ! empty( $settings['marker_label_field_custom'] ) ) {
					$field = $settings['marker_label_field_custom'];
				}

				if ( $field ) {
					$result = get_post_meta( $post_id, $field, true );
				}

				break;

			case 'static_text':
				$result = ! empty( $settings['marker_label_text'] ) ? $settings['marker_label_text'] : '';
				break;
		}

		$callback = ! empty( $settings['marker_label_format_cb'] ) ? $settings['marker_label_format_cb'] : false;

		if ( $callback ) {
			$result = jet_engine()->listings->apply_callback( $result, $callback, $settings, $this );
		}

		$customize = ! empty( $settings['marker_label_custom'] ) ? $settings['marker_label_custom'] : false;
		$customize = filter_var( $customize, FILTER_VALIDATE_BOOLEAN );

		if ( $customize && ! empty( $settings['marker_label_custom_output'] ) ) {
			$result = sprintf( $settings['marker_label_custom_output'], $result );
		}

		return $result;

	}

	/**
	 * Returns marker data
	 *
	 * @return [type] [description]
	 */
	public function get_marker_data( $settings = array() ) {

		$type   = ! empty( $settings['marker_type'] ) ? $settings['marker_type'] : 'image';
		$result = array( 'type' => null );

		switch ( $type ) {

			case 'image':

				$image          = ! empty( $settings['marker_image'] ) ? $settings['marker_image'] : false;
				$result['type'] = 'image';

				if ( ! $image ) {
					return false;
				} elseif ( is_array( $image ) && empty( $image['url'] ) ) {
					return false;
				} elseif ( is_array( $image ) ) {
					$result['url'] = $image['url'];
					return $result;
				} else {
					$result['url'] = $image;
					return $result;
				}

			case 'icon':

				$icon           = ! empty( $settings['marker_icon'] ) ? $settings['marker_icon'] : false;
				$result['type'] = 'icon';

				if ( ! $icon ) {
					return false;
				} else {
					$icon_html      = \Jet_Engine_Tools::render_icon( $icon, 'jet-map-marker' );
					$result['html'] = $icon_html;
					return $result;
				}

			case 'text':

				$result['type'] = 'text';
				$result['html'] = '<div class="jet-map-marker-wrap">_marker_label_</div>';

				return $result;

		}

		return false;

	}

	public function enqueue_deps( $listing_id ) {

		if ( ! $listing_id ) {
			return;
		}

		$document      = \Elementor\Plugin::$instance->documents->get( $listing_id );
		$elements_data = $document->get_elements_raw_data();

		$this->enqueue_elements_deps( $elements_data );

	}

	public function enqueue_elements_deps( $elements_data ) {

		foreach ( $elements_data as $element_data ) {

			if ( 'widget' === $element_data['elType'] ) {

				$widget = \Elementor\Plugin::$instance->elements_manager->create_element_instance( $element_data );

				$widget_script_depends = $widget->get_script_depends();
				$widget_style_depends  = $widget->get_style_depends();

				if ( ! empty( $widget_script_depends ) ) {
					foreach ( $widget_script_depends as $script_handler ) {
						wp_enqueue_script( $script_handler );
					}
				}

				if ( ! empty( $widget_style_depends ) ) {
					foreach ( $widget_style_depends as $style_handler ) {
						wp_enqueue_style( $style_handler );
					}
				}

			} else {

				$element  = \Elementor\Plugin::$instance->elements_manager->create_element_instance( $element_data );
				$children = $element->get_children();

				foreach ( $children as $key => $child ) {
					$children_data[ $key ] = $child->get_raw_data();
					$this->enqueue_elements_deps( $children_data );
				}
			}
		}

	}

	/**
	 * Render posts template.
	 * Moved to separate function to be rewritten by other layouts
	 *
	 * @param  array  $query    Query array.
	 * @param  array  $settings Settings array.
	 * @return void
	 */
	public function posts_template( $query, $settings ) {

		$map_data    = $this->get_map_data( $settings );
		$map_markers = $this->get_map_markers( $query, $settings );

		jet_engine()->frontend->set_listing( $settings['lisitng_id'] );

		wp_enqueue_script( 'jet-markerclustererplus' );
		wp_enqueue_script( 'jet-maps-listings' );

		$listing_id    = ! empty( $settings['lisitng_id'] ) ? absint( $settings['lisitng_id'] ) : false;
		$auto_center   = ! empty( $settings['auto_center'] ) ? $settings['auto_center'] : false;
		$auto_center   = filter_var( $auto_center, FILTER_VALIDATE_BOOLEAN );
		$custom_center = ! empty( $settings['custom_center'] ) ? $settings['custom_center'] : false;
		$custom_zoom   = ! empty( $settings['custom_zoom'] ) ? $settings['custom_zoom'] : 11;


		if ( ! $auto_center && $custom_center ) {
			$custom_center = Module::instance()->lat_lng->get_from_transient( $custom_center );
		}

		$general = array(
			'api'          => jet_engine()->api->get_route( 'get-map-marker-info', true ),
			'listingID'    => $listing_id,
			'width'        => ! empty( $settings['popup_width'] ) ? absint( $settings['popup_width'] ) : 320,
			'offset'       => isset( $settings['popup_offset'] ) ? absint( $settings['popup_offset'] ) : 40,
			'clustererImg' => jet_engine()->plugin_url( 'assets/lib/markerclustererplus/img/m' ),
			'marker'       => $this->get_marker_data( $settings ),
			'autoCenter'   => $auto_center,
			'customCenter' => $custom_center,
			'customZoom'   => $custom_zoom,
		);

		if ( ! empty( $settings['custom_style'] ) ) {
			$general['styles'] = json_decode( $settings['custom_style'] );
		}

		$this->enqueue_deps( $listing_id );

		$general = htmlspecialchars( json_encode( $general ) );

		$classes = array( 'jet-map-listing' );

		if ( ! empty( $settings['popup_pin'] ) ) {
			$classes[] = 'popup-has-pin';
		}

		printf(
			'<div class="%4$s" data-init="%1$s" data-markers="%2$s" data-general="%3$s"></div>',
			$map_data,
			$map_markers,
			$general,
			implode( ' ', $classes )
		);

	}

}
