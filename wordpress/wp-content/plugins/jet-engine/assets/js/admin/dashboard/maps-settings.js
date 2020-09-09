(function( $, mapsSettings ) {

	'use strict';

	Vue.component( 'jet-engine-maps-settings', {
		template: '#jet_engine_maps_settings',
		data: function() {
			return {
				settings: mapsSettings.settings,
				nonce: mapsSettings._nonce,
			};
		},
		methods: {
			updateSetting: function( value, setting ) {

				var self = this;

				self.$set( self.settings, setting, value );

				jQuery.ajax({
					url: window.ajaxurl,
					type: 'POST',
					dataType: 'json',
					data: {
						action: 'jet_engine_maps_save_settings',
						nonce: self.nonce,
						settings: self.settings,
					},
				}).done( function( response ) {
					if ( response.success ) {
						self.$CXNotice.add( {
							message: response.data.message,
							type: 'success',
							duration: 7000,
						} );
					} else {
						self.$CXNotice.add( {
							message: response.data.message,
							type: 'error',
							duration: 15000,
						} );
					}
				} ).fail( function( jqXHR, textStatus, errorThrown ) {
					self.$CXNotice.add( {
						message: errorThrown,
						type: 'error',
						duration: 15000,
					} );
				} );
			}
		}
	} );

})( jQuery, window.JetEngineMapsSettings );
