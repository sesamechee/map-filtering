var gLang = 'tc'; //default google map
var mapPinImg = "images/icoGooglePin.svg";

//Google map
var jspAPI, map;
var gMarkersInfo = [];
var gMarkersArray = [];
var gInfoboxsArray = [];
var getNearestStore = true;
var gCity = [];
var gInit = true;
var gMapCenter;
var resizeTimer;
var pinClicked = false;

//BAIDU
var iconSize = {w:34,h:52,l:0,t:0,x:6,lb:5};

function locationInit(){
	
	resetSelectOption();
	resetLayout();
	bindEvent();
	
	$(window).on('load', function(){
		//Show map listing
		setTimeout(function(){
			$('.shopListContainer').addClass('active');
			setTimeout(function(){
				$('.shopListContainer').removeClass('active');
			},1000);
		},3000);
	});
	
	$(window).on('resize', function(){
		resizeMap();
	});
	
	
	$(document).on('responsive', function(){
		resetLayout();
	});
	
	if( gLang == 'sc' ){
		$('#mapCanvas').remove();
	}else{
		$('#baiduMap').remove();
	}
	
	if( gLang == 'sc' ){
		baidu_init();
	}else{
		googleMapInit();
	}
	
	filterAction();
	checkMapURL();
	
}

function checkMapURL(){
	var selectedStore = null;
	var selectedRegion = null;
	var hash_id = window.location.href.split('?id=');
	var hash_region = window.location.href.split('?region=');
	
	//History JS
	if ( IE9down == false ) {
		var History = window.History;
		var State = History.getState();
		
		History.Adapter.bind(window,'statechange',function(){

			if ( pinClicked == false ) {
				var mIdx;
				var hash = window.location.href;
				hash = hash.split('?id=');
				selectedStore = hash[1];

				for( var j=0; j<gMarkersInfo.length; j++ ){
					if ( gMarkersInfo[j].number == selectedStore ) {
						mIdx = j;
					}
				}

				openInfobox( mIdx );
				panMap( gMarkersInfo[mIdx].lat , gMarkersInfo[mIdx].lng , gMarkersInfo[mIdx].region );
			}

		});
	}

	if( hash_id.length > 1 ){
		selectedStore = hash_id[1];
	}
	if ( hash_region.length > 1 ) {
		selectedRegion = hash_region[1];
	}
	
	if ( selectedRegion == null ) {
		if( selectedStore == null ){
			//no id and no region > geo check
			$('.btnOpenLocation').trigger("click");
		} else {
			//id check
			var _matchIdx = null;
			for( var _i = 0; _i < gMarkersInfo.length ; _i++ ){
				if( gMarkersInfo[_i].number == selectedStore ){
					_matchIdx = _i;
				}
			}
			if( _matchIdx == null ){
				//Find nearest if no id match
				$('.btnOpenLocation').trigger("click");
			}else{
				//Find by id
				openInfobox( _matchIdx, true );
				panMap( gMarkersInfo[_matchIdx].lat , gMarkersInfo[_matchIdx].lng , gMarkersInfo[_matchIdx].region );
			}
		}
	} else {
		//region check
		$('.region select').val(selectedRegion).selectric('refresh').trigger('change');
	}
}

function resizeMap(){
	//mobile full height
	if( $('body').hasClass('mobile') ){
		$('.mapWrapper .mapCanvas').height( $(window).height() - $('.mobileHeader').outerHeight() );
	}
	//map center
	if( !gMapCenter ){
		gMapCenter = map.getCenter();
	}
	clearTimeout(resizeTimer);
	resizeTimer = setTimeout(function () {

		if( gLang == 'sc' ){
			map.setCenter( new BMap.Point( Number( gMapCenter.lng ) , Number( gMapCenter.lat ) ) );
		}else{
			map.setCenter( new google.maps.LatLng( gMapCenter.lat() , gMapCenter.lng() ) );
			google.maps.event.trigger(map, 'resize');
		}
		
		gMapCenter = null;

	}, 200);
}

function bindEvent(){
	
	$('.btnToggleMapList').on('click', function(){
		$('.shopListContainer').toggleClass('active');
	});

	$('.btnBackToMap').on('click', function(){
		$('.shopListContainer').removeClass('active');
	});
	
	$('.shopItem').each(function( i ){
		var $this = $(this);
		//Store marker array
		if( gLang == 'sc' ){
			gMarkersInfo[i] = {
				lat: $this.attr('data-baidulat'),
				lng: $this.attr('data-baidulng'),
				number : Number( $this.attr('data-boutique') ),
				title: $this.find('.shopName').html(),
				region: $this.attr('data-region')
			};
		}else{
			gMarkersInfo[i] = {
				position: new google.maps.LatLng( $this.attr('data-lat') , $this.attr('data-lng') ),
				lat: $this.attr('data-lat'),
				lng: $this.attr('data-lng'),
				number : Number( $this.attr('data-boutique') ),
				region: $this.attr('data-region')
			};
		}

		//Click pin
		$(this).find('.pinLink').on('click', function(e){
			e.preventDefault();
			pinClicked = true;
			changePage( 'map' );
			openInfobox( i );
			panMap( gMarkersInfo[i].lat , gMarkersInfo[i].lng , gMarkersInfo[i].region );
		});

		//GetNearest
		$(this).find('.pinLink').on('getNearest', function(e){
			e.preventDefault();
			/*=====START Auto select region/city dropdown when clicking pin=====*/
			var _cityId = $(this).parents(".shopItem").attr("data-region");
			var _regionId = 0;
			for(var _i = 0; _i < gCity.length; _i++){
				if($(gCity[_i]).val() == _cityId){
					_regionId = $(gCity[_i]).attr('data-boutique');
					break;
				}
			}

			$(this).trigger("click");
			/*=====END Auto select region/city dropdown when clicking pin=====*/
		});

		$(this).find('.moreBtn').attr('href','locator-details.php?id='+$(this).attr('data-boutique'));

	});
	
	$('.btnOpenLocation').on("click", function(e){
		e.preventDefault();

		if(navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function(position) {
				var currentLng = position.coords.longitude;
				var currentLat = position.coords.latitude;
				var distanceArr = [];


				if( gLang == 'sc' ){
					lng = 'data-baidulng';
					lat = 'data-baidulat';
				} else {
					lng = 'data-lng';
					lat = 'data-lat';
				}

				$('.shopList .shopItem').each(function(){
					distanceArr.push(Math.sqrt(Math.pow($(this).attr(lng) - currentLng, 2) + Math.pow($(this).attr(lat) - currentLat, 2)));
				});

				var minDistance = 0;
				var minDistStore = 0;
				$.each(distanceArr, function(index, value){
					if(index == 0 || value < minDistance){
						minDistance = value;
						minDistStore = index;
					}
				});

				$(".shopItem a.pinLink").eq(minDistStore).trigger("getNearest"); //one-off action to render the correct dropdown

			}, function() {
				geoLocNotSupported();
			});
		} else {
			geoLocNotSupported();
		}
	});
	
	$('.locationFilterBar select').on('change', function(){
		if( $(this).parents('.pageCatItem').hasClass('region') ){
			$('.locationFilterBar .district select').val('');
		}
		filterAction();
		resetSelectOption();
	});
	
}

function googleMapInit() {
	var _overlay;
	var _targetID = 'mapCanvas';
	var _center = ['22.298300', '114.176131'];
	var _mapStyle = 
	[{"featureType":"landscape.man_made","elementType":"geometry","stylers":[{"color":"#f7f1df"}]},{"featureType":"landscape.natural","elementType":"geometry","stylers":[{"color":"#d0e3b4"}]},{"featureType":"landscape.natural.terrain","elementType":"geometry","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"poi.business","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"poi.medical","elementType":"geometry","stylers":[{"color":"#fbd3da"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#bde6ab"}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"on"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffe15f"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#efd151"}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"road.local","elementType":"geometry.fill","stylers":[{"color":"black"}]},{"featureType":"transit.station.airport","elementType":"geometry.fill","stylers":[{"color":"#cfb2db"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#a2daf2"}]}];

	var mapOptions = {
		zoom: 18,
		minZoom: 6,
		zoomControl: false,
		scrollwheel: false,
		mapTypeControl: false,
		disableDefaultUI: true,
		disableDoubleClickZoom: true,
		center: new google.maps.LatLng(_center[0], _center[1]),
		styles: _mapStyle
	};
	var infoBoxOptions = {
		content: '',
		alignBottom : true,
		disableAutoPan: true,
		maxWidth: 0,
		pixelOffset: new google.maps.Size(40, 20),
		zIndex: null, 
		boxStyle: { 
			//background: "url('tipbox.gif') no-repeat",
			width: "320px"
		},
		closeBoxMargin: "0",
		closeBoxURL: 'images/infoboxCloseBtn.png',
		infoBoxClearance: new google.maps.Size(1, 1),
		isHidden: false,
		pane: "floatPane",
		enableEventPropagation: false
	};

	var pin = {
        url: mapPinImg,
        anchor: new google.maps.Point(40,60),
        scaledSize: new google.maps.Size(40,60)
    }

	map = new google.maps.Map(document.getElementById(_targetID), mapOptions);

	for( var i=0; i<gMarkersInfo.length; i++ ){

		gMarkersArray[i] = new MarkerWithLabel({
			position: gMarkersInfo[i].position,
			map: map,
			icon: pin,
			//labelContent: gMarkersInfo[i].number,
			labelClass: "labelPin",
			labelInBackground: false
		});
		

		infoBoxOptions.content = '<div class="infobox Avenir-Roman">';
		infoBoxOptions.content +='		<div class="boxInner">' + $('.shopItem').eq(i).find('.shopDetails').html() + '</div>';
		infoBoxOptions.content +='		<div class="infoboxBottom"></div>';
		infoBoxOptions.content +='</div>';
		gInfoboxsArray[i] = new InfoBox(infoBoxOptions);
		markerEvent( i );

	}
	
	function markerEvent( i ){
		google.maps.event.addListener(gMarkersArray[i], "click", function (e) {
			openInfobox( i );
			panMap( gMarkersInfo[i].lat , gMarkersInfo[i].lng , gMarkersInfo[i].region );
		});
	}

}

function baidu_init(){
	var _center = ['22.298300', '114.176131'];
	
	initMap();
	
	function initMap(){
		createMap();
		setMapEvent();
		addMapControl();
		addMarker();
	}
	
	function createMap(){
		var map = new BMap.Map("baiduMap");
		var point = new BMap.Point(_center[1],_center[0]);
		map.centerAndZoom(point,16);
		window.map = map;
	}
	
	function setMapEvent(){
		map.enableDragging();
		map.disableDoubleClickZoom();
	}
	
	function addMapControl(){
	}
	
	function addMarker(){
		for(var i=0;i< gMarkersInfo.length;i++){
			var point = new BMap.Point( gMarkersInfo[i].lng, gMarkersInfo[i].lat);
			var iconImg = createIcon(iconSize);
			gInfoboxsArray[i] = new BMap.Label({
				position : point
			});
			var html = '<div class="infobox">' + $('.shopItem').eq(i).find('.shopDetails').html() + '</div><div class="infoboxBottom"></div>';
			
			gMarkersArray[i] = new BMap.Marker(point,{icon:iconImg});
			map.addOverlay(gMarkersArray[i]);
			map.addOverlay(gInfoboxsArray[i])
			
			gInfoboxsArray[i] = new BMap.InfoWindow(html);

			gMarkersArray[i].addEventListener("click", openInfobox.bind( null, i ));
		}
	}
	function createIcon(json){
		var icon = new BMap.Icon(mapPinImg , new BMap.Size(40,60),{
			imageOffset: new BMap.Size(-json.l,-json.t),
			infoWindowOffset:new BMap.Size(json.lb+5,1),
			offset:new BMap.Size(json.x,json.h)
		})
		return icon;
	}
	
}

function openInfobox( i, isInit ){
	isInit = ( typeof isInit == "undefined" ) ? false : true;
	
	//History
	if ( gInit == false ) {
		var _idx = gMarkersInfo[i].number;
		if ( ! IE9down ) {
			History.pushState(null, pageTitle, "?id="+_idx);
		}
	}
	
	if( gLang == 'sc' ){
		var _markerIndex = i;

		gMarkersArray[_markerIndex].openInfoWindow(gInfoboxsArray[_markerIndex]);

		setTimeout(function() {
			gInfoboxsArray[_markerIndex].redraw();
		}, 100);
		
	}else{
		for( var j=0; j<gInfoboxsArray.length; j++ ){
			gInfoboxsArray[j].close();
		}
		gInfoboxsArray[i].open(map, gMarkersArray[i]);
	}

	gInit = false;
}

function resetSelectOption(){
	var _shopAreaArr = [];
	var _shopDistrictArr = [];
	
	$('.shopList .shopItem').each(function(i){
		if( $.inArray( $(this).attr('data-region') , _shopAreaArr ) == -1 ){
			_shopAreaArr.push( $(this).attr('data-region') );
		}
	});
		
	$('.locationFilterBar .region select option').prop('disabled', true);
	$('.locationFilterBar .region select option[value=""]').prop('disabled', false);

	if( _shopAreaArr.length > 0 ){
		for( var _i = 0; _i < _shopAreaArr.length; _i++ ){
			$('.locationFilterBar .region select option[value="'+ _shopAreaArr[_i] +'"]').prop('disabled', false);
		}
		if( _shopAreaArr.length == 1 ){
			$('.locationFilterBar .region select').val( _shopAreaArr[0] );
		}
	}

	if( $('.region select').val() != '' ){
		$('.shopList .shopItem[data-region="'+ $('.region select').val() +'"]').each(function(i){
			if( $.inArray( $(this).attr('data-district') , _shopDistrictArr ) == -1 ){
				_shopDistrictArr.push( $(this).attr('data-district') );
			}
		});
	}else{
		$('.shopList .shopItem').each(function(i){
			if( $.inArray( $(this).attr('data-district') , _shopDistrictArr ) == -1 ){
				_shopDistrictArr.push( $(this).attr('data-district') );
			}
		});
	}
		
	$('.locationFilterBar .district select option').prop('disabled', true);
	$('.locationFilterBar .district select option[value=""]').prop('disabled', false);
	
	if( _shopDistrictArr.length > 0 ){
		for( var _i = 0; _i < _shopDistrictArr.length; _i++ ){
			$('.locationFilterBar .district select option[value="'+ _shopDistrictArr[_i] +'"]').prop('disabled', false);
		}
		if( _shopAreaArr.length == 1 ){
			$('.locationFilterBar .district select').val( _shopDistrictArr[0] );
		}
	}
	
	//Check region select?
	if( $('.locationFilterBar .region select').val() == '' ){
		$('.locationFilterBar .district select').prop('disabled', true);
	}else{
		$('.locationFilterBar .district select').prop('disabled', false);
	}

	
	$('.locationFilterBar .region select').selectric('refresh');
	$('.locationFilterBar .district select').selectric('refresh');
	
}

function filterAction(){
	var _currentNum = 0;
	var _region = $('.region select').val();
	var _district = $('.district select').val();
	
	$('.shopList .shopItem').removeClass('show');

	$('.shopList .shopItem').filter(function(i){
		if( _region == '' && _district == '' ){
			return true;
		}else if( _region == '' ){
			return $(this).attr('data-district') == _district ;
		}else if( _district == '' ){
			return $(this).attr('data-region') == _region ;
		}else{
			return $(this).attr('data-region') == _region && $(this).attr('data-district') == _district;
		}
	}).addClass('show');
	
	for( var i = 0; i< gMarkersArray.length ; i++){
		if( gLang == 'sc' ){
			gMarkersArray[i].hide();
		}else{
			gMarkersArray[i].setVisible(false);
		}
	}
	
	$('.shopList .shopItem').each(function(i){
		if( $(this).hasClass('show') ){
			if( gLang == 'sc' ){
				gMarkersArray[i].show();
				gInfoboxsArray[i].show();
			}else{
				gMarkersArray[i].setVisible(true);
			}
		}
	});
	
	$('.shopList .locTitle').each(function(){
		var $this = $(this);
		var _length = $('.shopList .shopItem').filter(function(){
			return $(this).attr('data-region') == $this.attr('data-region') && $(this).hasClass('show');
		}).length;
		
		if( _length == 0 ){
			$this.removeClass('show');	
		}else{
			$this.addClass('show');	
		}
	});
	
	
	if( $('.shopList .shopItem.show').length > 0 ){
		$('.shopList .norecords').hide();
		var lat = Number($('.shopList .shopItem.show').eq(0).attr('data-lat'));
		var lng = Number($('.shopList .shopItem.show').eq(0).attr('data-lng'));
		var region = Number($('.shopList .shopItem.show').eq(0).attr('data-region'));
		
		panMap( lat , lng , region );
	}else{
		$('.shopList .norecords').show();
	}

	for( var j=0; j<gInfoboxsArray.length; j++ ){
		gInfoboxsArray[j].close();
	}

	if( jspAPI ){
		jspAPI.reinitialise();
	}
	
	if( !$('body').hasClass('mobile') ){
		$('.shopList .shopItem.show').eq(0).find('.pinLink').trigger('click');
	}
	
}


function resetLayout(){
	jspAPI = $('.shopList').jScrollPane({
		hideFocus : true,
		mouseWheelSpeed : 30,
		verticalGutter: 10,
		autoReinitialise: true
	}).data('jsp');
}

function changePage( page ){
	if( $('body').hasClass('mobile') ){
		if( page == 'list' ){
			$('.shopListContainer').addClass('active');
		}else if( page == 'map' ){
			$('.shopListContainer').removeClass('active');
		}
		$('html, body').animate({
			'scrollTop': 0
		},0);
	}
}

function panMap( lat , lng , region ) {
			
	//china map zoom out
	if( gLang == 'sc' ){
		if( region == 'china' ){
			map.setZoom(7);
		}else if( region == 'malaysia' ){
			map.setZoom(7);
		}else{
			map.setZoom(20);
		}
		setTimeout(function(){
			map.panTo( new BMap.Point( Number(lng) - 0.001 , Number(lat) ) );
		},500);
	}else{
		if( region == 'china' ){
			map.setZoom(6);
			map.setOptions({maxZoom: 6});
		}else{
			map.setZoom(18);
			map.setOptions({maxZoom: 20});
		}
		
		if( $('body').hasClass('mobile') ){
			map.panTo( new google.maps.LatLng( Number(lat) , Number(lng) ) );
		}else{
			map.panTo( new google.maps.LatLng( Number(lat) , Number(lng) - 0.001 ) );
		}
	}

	pinClicked = false;
}

function geoLocNotSupported() {
	console.log('geolocation not supported');
	window.location.href = '?id='+gMarkersInfo[0].number;
	// Browser doesn't support Geolocation
	return false;
}