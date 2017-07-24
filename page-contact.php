<?php
/**
 * Template Name: Contact
 */

get_header(); ?>

	<main role="main">

		<div class="mapWrap">
				<div id="map"></div>
		</div>	

		<div class="container">
        	<section id='pageContent'>				
				<?php while ( have_posts() ) : the_post(); ?>
					<?php the_content(); ?>
				<?php endwhile; ?>
			</section>
		</div>	

	</main>


    <script>
      function initMap() {
        // Styles a map in night mode.
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 53.570530, lng: -113.480130},
          zoom: 13,
          scrollwheel: false,
          styles: [
					  {
					    "elementType": "geometry",
					    "stylers": [
					      {
					        "color": "#ececec"
					      }
					    ]
					  },
					  {
					    "elementType": "labels.icon",
					    "stylers": [
					      {
					        "visibility": "off"
					      }
					    ]
					  },
					  {
					    "elementType": "labels.text.fill",
					    "stylers": [
					      {
					        "color": "#2e1a46"
					      }
					    ]
					  },
					  {
					    "elementType": "labels.text.stroke",
					    "stylers": [
					      {
					        "color": "#ffffff"
					      }
					    ]
					  },
					  {
					    "featureType": "administrative.land_parcel",
					    "elementType": "labels.text.fill",
					    "stylers": [
					      {
					        "color": "#bdbdbd"
					      }
					    ]
					  },
					  {
					    "featureType": "administrative.locality",
					    "elementType": "labels.text.fill",
					    "stylers": [
					      {
					        "color": "#583189"
					      }
					    ]
					  },
					  {
					    "featureType": "administrative.neighborhood",
					    "elementType": "labels.text.fill",
					    "stylers": [
					      {
					        "color": "#9c9c9c"
					      }
					    ]
					  },
					  {
					    "featureType": "poi",
					    "elementType": "geometry",
					    "stylers": [
					      {
					        "color": "#cae5e7"
					      }
					    ]
					  },
					  {
					    "featureType": "poi",
					    "elementType": "labels.text.fill",
					    "stylers": [
					      {
					        "color": "#ffffff"
					      }
					    ]
					  },
					  {
					    "featureType": "poi.park",
					    "elementType": "geometry",
					    "stylers": [
					      {
					        "color": "#a1e5e3"
					      }
					    ]
					  },
					  {
					    "featureType": "poi.park",
					    "elementType": "labels.text.fill",
					    "stylers": [
					      {
					        "color": "#9e9e9e"
					      }
					    ]
					  },
					  {
					    "featureType": "road",
					    "elementType": "geometry",
					    "stylers": [
					      {
					        "color": "#ffffff"
					      }
					    ]
					  },
					  {
					    "featureType": "road.arterial",
					    "elementType": "labels.text.fill",
					    "stylers": [
					      {
					        "color": "#757575"
					      }
					    ]
					  },
					  {
					    "featureType": "road.highway",
					    "elementType": "geometry",
					    "stylers": [
					      {
					        "color": "#dadada"
					      }
					    ]
					  },
					  {
					    "featureType": "road.highway",
					    "elementType": "labels.text.fill",
					    "stylers": [
					      {
					        "color": "#616161"
					      }
					    ]
					  },
					  {
					    "featureType": "road.local",
					    "elementType": "labels.text.fill",
					    "stylers": [
					      {
					        "color": "#9e9e9e"
					      }
					    ]
					  },
					  {
					    "featureType": "transit.line",
					    "elementType": "geometry",
					    "stylers": [
					      {
					        "color": "#e5e5e5"
					      }
					    ]
					  },
					  {
					    "featureType": "transit.station",
					    "elementType": "geometry",
					    "stylers": [
					      {
					        "color": "#eeeeee"
					      }
					    ]
					  },
					  {
					    "featureType": "water",
					    "elementType": "geometry",
					    "stylers": [
					      {
					        "color": "#69d9d4"
					      }
					    ]
					  },
					  {
					    "featureType": "water",
					    "elementType": "labels.text.fill",
					    "stylers": [
					      {
					        "color": "#9e9e9e"
					      }
					    ]
					  }
					]
        });


		var contentString = '<div id="content">'+
            '<h4 id="firstHeading" class="firstHeading">Company Name</h4>'+
            '<div id="bodyContent">'+
            '<p>Address</p>'+
            '<p><strong>Phone:</strong> <a href="tel:12345678901">123-456-7890</a><br>'+
			'<strong>Email:</strong> <a href="mailto:info@company.ca">info@company.ca</a></p>'+
            '</div>'+
            '</div>';

		var infowindow = new google.maps.InfoWindow({
          content: contentString
        });

		var marker = new google.maps.Marker({
	      position: {lat: 53.570530, lng:  -113.480130},
	      icon: '<?php echo get_bloginfo('template_url')?>/img/pin.png',
	      map: map,
	      title: 'Ufinancial'
	    });

	    marker.addListener('click', function() {
          infowindow.open(map, marker);
        });

      }








    </script>
    <!-- ALWAYS GET A CUSTOM KEY -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDH1vlE7qPNc0LK8H6JTY5YZtxCYTGgWf0&callback=initMap"
    async defer></script>


<?php get_template_part( 'prefoot' );?>


<?php get_footer(); ?>


