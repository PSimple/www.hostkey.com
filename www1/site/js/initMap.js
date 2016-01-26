jQuery(document).ready(function($) {
    var $currentPlaceX = 59.9458134,
        $currentPlaceY = 30.3296705;

    $(document).on('click', '.js-add-map', function(e){

        e.preventDefault();

        var $this = $(this);

        $currentPlaceX = $this.attr('data-pos-x');
        $currentPlaceY = $this.attr('data-pos-y');

        initialize('map-canvas');

        return false;
    });

    initialize('map-canvas');

    function initialize(el) {

        var MY_MAPTYPE_ID = 'custom_style';
        var featureOpts = [
            {
                stylers: [
                    {"saturation": -100}
                ]
            }
        ];

        var styledMapOptions = {
            name: 'Custom Style'
        };

        var customMapType = new google.maps.StyledMapType(featureOpts, styledMapOptions);

        var mapOptions = {
            zoom: 15,
            center: new google.maps.LatLng($currentPlaceX,$currentPlaceY),
            mapTypeControl: false,
            mapTypeId: MY_MAPTYPE_ID
        }


        var map = new google.maps.Map(document.getElementById(el),
            mapOptions);

        var image = 'images/map-icon.png';
        var officePos1 = new google.maps.LatLng($currentPlaceX,$currentPlaceY);
        var officeMarker1 = new google.maps.Marker({
            position: officePos1,
            map: map,
            icon: image
        })

        map.mapTypes.set(MY_MAPTYPE_ID, customMapType);

    }



});