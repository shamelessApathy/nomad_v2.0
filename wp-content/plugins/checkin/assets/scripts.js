var FOURSQUARE_VENUE_SEARCH_API_URL = "https://api.foursquare.com/v2/venues/search?";
var FOURSQUARE_VENUE_SEARCH_API_CID = "353GZNRPJL4HJYGGVHRV1TTE5VUBPFEGWPZT0YZH0FQYMKU4";
var FOURSQUARE_VENUE_SEARCH_API_CS = "M5LB1RT1DYGN0TRKH1OOGCYRAN5DL3YELS3ZOLR3VSNUHF05";
var loading = "<div id='loader'></div>";

jQuery( document ).ready(function(){
    if ( jQuery( "#venue-search-container" ).length ) {
        jQuery( "#venue-search-box #town-search, #venue-search-box #venue-search" ).on( "keydown", function( e ){
            if ( e.keyCode == 13 ) {
                e.preventDefault();
                searchVenue( jQuery( "#venue-search-box #town-search" ).val().trim(), jQuery( "#venue-search-box #venue-search" ).val().trim() );
            }
        } );

		jQuery( "#venue-search-box #search-controller" ).on( "click", function(){
			searchVenue(
				jQuery( "#venue-search-box #town-search" ).val().trim(),
				jQuery( "#venue-search-box #venue-search" ).val().trim()
			);
		} );
    }
});


function searchVenue( venueTown, venue ) {
    if ( venueTown !== undefined && venueTown != "" ) {
        jQuery( "#venue-search-container #venues-list" ).append( loading );

        jQuery.ajax({
    		url: FOURSQUARE_VENUE_SEARCH_API_URL +"near="+ venueTown +"&query="+ venue +"&client_id="+ FOURSQUARE_VENUE_SEARCH_API_CID +"&client_secret="+ FOURSQUARE_VENUE_SEARCH_API_CS +"&v=20170308",
    		success: function( result ) {
    			console.log( result );
				jQuery( "#venue-search-container #venues-list" ).empty();
				venues_ = result.response.venues;

				console.log( venues_ );

				for ( venue_key in venues_ ) {
					venue_ = venues_[ venue_key ];
					venue_city = venue_.location.city !== undefined ? venue_.location.city : "Unknown";
					venue_address = venue_.location.address !== undefined ? venue_.location.address : "Unknown";
					venue_category = venue_.categories[0] !== undefined ? venue_.categories[0].name : "Unknown";

					view_ = "\
					<div id='venue-"+ venue_.id +"' class='venue'>\
						<h1 class='title'>"+ venue_.name +"</h1>\
						<div class='metas'>\
							<span id='city' class='meta'>"+ venue_city +"</span>\
							<span class='dotter'>&bull;</span>\
							<span id='address' class='meta'>"+ venue_address +"</span>\
							<span class='dotter'>&bull;</span>\
							<span id='category' class='meta'>"+ venue_category +"</span>\
						</div>\
					</div>\
					";

					jQuery( "#venue-search-container #venues-list" ).append( view_ );

					jQuery( "#venue-"+ venue_.id ).on( "click", function(){
						view_ = "\
						<div id='selected-venue-"+ jQuery( this ).attr( "id" ).split( "-" )[1] +"' class='selected-venue'>\
							<h1 class='title'>"+ jQuery( this ).children( ".title" ).html().trim() +"</h1>\
							<div class='metas'>\
								<span class='meta'>"+ jQuery( this ).find( "#city" ).html().trim() +"</span>\
								<span class='dotter'>&bull;</span>\
								<span class='meta'>"+ jQuery( this ).find( "#address" ).html().trim() +"</span>\
								<span class='dotter'>&bull;</span>\
								<span class='meta'>"+ jQuery( this ).find( "#category" ).html().trim() +"</span>\
							</div>\
						</div>\
						";

						jQuery( "#venue-id" ).val( jQuery( this ).attr( "id" ).split( "-" )[1] );
						jQuery( "#venue-search-container" ).hide();
						jQuery( "#venue-selection-container" ).show().append( view_ );
						jQuery( "#selected-venue-"+ jQuery( this ).attr( "id" ).split( "-" )[1] ).on( "click", function(){
							jQuery( "#venue-id" ).val( "" );
							jQuery( "#venue-selection-container" ).empty().hide();
							jQuery( "#venue-search-container" ).show();
						} );
					} );
				}
    		},
            error: function( result ) {
                console.log( result );
            }
    	});
    }
}

function getVenue( venueID ) {
	url = "https://api.foursquare.com/v2/venues/"+ venueID +"?client_id="+ FOURSQUARE_VENUE_SEARCH_API_CID +"&client_secret="+ FOURSQUARE_VENUE_SEARCH_API_CS +"&v=20170303";
	jQuery.ajax({
		url: url,
		success: function( response ) {
			venue_ = response.response.venue;
			venue_city = venue_.location.city !== undefined ? venue_.location.city : "Unknown";
			venue_address = venue_.location.address !== undefined ? venue_.location.address : "Unknown";
			venue_category = venue_.categories[0] !== undefined ? venue_.categories[0].name : "Unknown";

			view_ = "\
			<div id='selected-venue-"+ venueID +"' class='selected-venue'>\
				<h1 class='title'>"+ venue_.name +"</h1>\
				<div class='metas'>\
					<span class='meta'>"+ venue_city +"</span>\
					<span class='dotter'>&bull;</span>\
					<span class='meta'>"+ venue_address +"</span>\
					<span class='dotter'>&bull;</span>\
					<span class='meta'>"+ venue_category +"</span>\
				</div>\
			</div>\
			";

			jQuery( "#venue-id" ).val( venueID );
			jQuery( "#venue-search-container" ).hide();
			jQuery( "#venue-selection-container" ).show().append( view_ );
			jQuery( "#selected-venue-"+ venueID ).on( "click", function(){
				jQuery( "#venue-id" ).val( "" );
				jQuery( "#venue-selection-container" ).empty().hide();
				jQuery( "#venue-search-container" ).show();
			} );
		},
		error: function( response ) { console.log( response ); }
	});
}
