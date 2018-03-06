var FOURSQUARE_VENUE_SEARCH_API_URL = "https://api.foursquare.com/v2/venues/search?";
var FOURSQUARE_VENUE_SEARCH_API_CID = "353GZNRPJL4HJYGGVHRV1TTE5VUBPFEGWPZT0YZH0FQYMKU4";
var FOURSQUARE_VENUE_SEARCH_API_CS = "M5LB1RT1DYGN0TRKH1OOGCYRAN5DL3YELS3ZOLR3VSNUHF05";

jQuery( document ).ready(function(){});

function getVenue( venueID ) {
	url = "https://api.foursquare.com/v2/venues/"+ venueID +"?client_id="+ FOURSQUARE_VENUE_SEARCH_API_CID +"&client_secret="+ FOURSQUARE_VENUE_SEARCH_API_CS +"&v=20170303";
	jQuery.ajax({
		url: url,
		success: function( response ) {
			console.log( response );
			venue_ = response.response.venue;
			venue_city = venue_.location.city !== undefined ? venue_.location.city : "Unknown";
			venue_address = venue_.location.address !== undefined ? venue_.location.address : "Unknown";
			venue_category = venue_.categories[0] !== undefined ? venue_.categories[0].name : "Unknown";

			view_ = "\
            <a href='"+ venue_.shortUrl +"' class='venue-anchor' target='_blank'>\
    			<div id='selected-venue-"+ venueID +"' class='selected-venue'>\
    				<h1 class='title'>"+ venue_.name +"</h1>\
    				<div class='metas'>\
                        <span class='meta'>"+ venue_.location.country +"</span>\
                        <span class='dotter'>&bull;</span>\
                        <span class='meta'>"+ venue_city +"</span>\
    					<span class='dotter'>&bull;</span>\
    					<span class='meta'>"+ venue_address +"</span>\
    					<span class='dotter'>&bull;</span>\
    					<span class='meta'>"+ venue_category +"</span>\
    				</div>\
    			</div>\
            </a>\
			";

            jQuery( "#post-venue-container" ).append( view_ );
            jQuery( "#post-header .sub-header" ).append( venue_.name );
		},
		error: function( response ) { console.log( response ); }
	});
}

function getVenuePlace( venueID, container ) {
    url = "https://api.foursquare.com/v2/venues/"+ venueID +"?client_id="+ FOURSQUARE_VENUE_SEARCH_API_CID +"&client_secret="+ FOURSQUARE_VENUE_SEARCH_API_CS +"&v=20170303";
	jQuery.ajax({
		url: url,
		success: function( response ) {
			venue_ = response.response.venue;
            jQuery( container ).each(function(){
				jQuery( this ).html( "@"+ venue_.name );
			});
        },
        error: function ( response ) { console.log( response ); }
    });
}
