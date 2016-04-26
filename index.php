<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-hk">

<head>
	
	<link rel="stylesheet" href="css/reset.css" type="text/css" />

	<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="js/common.js"></script>
	
	<!--Individual-->
	<link rel="stylesheet" href="css/store.css" type="text/css" />
	
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&language=en"></script>
	<script type="text/javascript" src="js/jquery.history.js"></script>
	<script type="text/javascript" src="js/infobox.js"></script>
	<script type="text/javascript" src="js/markerwithlabel.js"></script>
	<script type="text/javascript" src="js/location.js"></script>
	
	<script type="text/javascript" src="http://api.map.baidu.com/api?key=&v=1.4&services=true"></script>
	<script type="text/javascript" src="js/infobox_baidu.js"></script>

	<title>Map Filtering</title>
</head>

<body>
	<div class="loading in"><div class="imgLoading active"></div></div>
	
	<div class="wrapper store">
		
		<div class="main">

			<div class="content">

				<div class="innerContent">
				
					<div class="mapWrapper">

							<div class="mapCanvas" id="mapCanvas"></div>
							<div class="mapCanvas baiduMap" id="baiduMap"></div>

							<div class="shopListContainer">
							
								<a href="javascript:void(0);" class="btnToggleMapList"></a>
								
								<div class="locationFilterBar">
								
									<a href="javascript:void(0);" class="btnBackToMap">BACK</a>
								
									<div class="region pageCatItem">
										<select class="regionSelector">
											<option value="">ALL REGIONS</option>
											<option value="hongkong">HONG KONG</option>
											<option value="macau">MACAU</option>
											<option value="china">CHINA</option>
											<option value="malaysia">MALAYSIA</option>
										</select>
									</div>
									<div class="district pageCatItem">
										<select>
											<option value="">ALL DISTRICTS</option>
											<option value="hkisland" data-region="hongkong">HONG KONG ISLAND</option>
											<option value="kowloon" data-region="hongkong">KOWLOON</option>
											<option value="macau" data-region="macau">MACAU</option>
											<option value="east" data-region="china">EAST AREA</option>
											<option value="south" data-region="china">SOUTH AREA</option>
											<option value="west" data-region="china">WEST AREA</option>
											<option value="north" data-region="china">NORTH AREA</option>
											<option value="isetan" data-region="malaysia">ISETAN</option>
											<option value="parkson" data-region="malaysia">PARKSON</option>
											<option value="sogo" data-region="malaysia">SOGO</option>
											<option value="metrojayacityonemegamall" data-region="malaysia">METROJAYA CITY ONE MEGAMALL</option>
											<option value="metrojaya" data-region="malaysia">METROJAYA</option>
										</select>
									</div>
								</div>

								<div class="shopListWrapper">
									
									<div class="shopList">

										<div class="locTitle" data-region="hongkong">HONG KONG</div>

										<span class="shopItem" data-lat="22.295235" data-lng="114.170051" data-baidulat="22.298155" data-baidulng="114.181495" data-region="hongkong" data-district="kowloon" data-boutique="1">
											<a href="#" class="pinLink">
												<span class="shopDetails">
													<span class="shopName">1881 Heritage, Tsimshatsui</span>
													<span class="shopAddress">House 2, 1881 Heritage, 2A Canton Road, Tsimshatsui, Kowloon, Hong Kong</span>
												</span>
											</a>
											<span class="shopTel">Tel: <a href="tel:85226311881">(+852) 2631 1881</a></span>
										</span>


										<span class="shopItem" data-lat="22.281398" data-lng="114.157400" data-baidulat="22.282471" data-baidulng="114.175271" data-region="hongkong" data-district="hkisland" data-boutique="2">
											<a href="#" class="pinLink">
												<span class="shopDetails">
													<span class="shopName">Central Building, Central</span>
													<span class="shopAddress">Shops 14-18, 24 &amp; 27, Central Building, 1-3 Pedder Street, Central, Hong Kong</span>
												</span>
											</a>
											<span class="shopTel">Tel: <a href="tel:85225221288"> (+852) 2522 1288</a> / <a href="tel:85225223812">(+852) 2522 3812</a></span>
										</span>

										<span class="shopItem" data-lat="22.277920" data-lng="114.184065" data-baidulat="22.281702" data-baidulng="114.196343" data-region="hongkong" data-district="hkisland" data-boutique="3">
											<a href="#" class="pinLink">
												<span class="shopDetails">
													<span class="shopName">Lee Gardens One, Causeway Bay</span>
													<span class="shopAddress">Shops 311–312, Level 3, The Lee Gardens, 33 Hysan Avenue, Causeway Bay, Hong Kong</span>
												</span>
											</a>
											<span class="shopTel">Tel: <a href="tel:85228907070"> (+852) 2890 7070</a></span>
										</span>

										<span class="shopItem" data-lat="22.292859" data-lng="114.201994" data-baidulat="22.287789" data-baidulng="114.228035" data-region="hongkong" data-district="hkisland" data-boutique="4">
											<a href="#" class="pinLink">
												<span class="shopDetails">
													<span class="shopName">59 Russell Street, Causeway Bay</span>
													<span class="shopAddress">Shop B5, G/F, 59 Russell Street, Causeway Bay, Hong Kong</span>
												</span>
											</a>
											<span class="shopTel">Tel: <a href="tel:85228324880"> (+852) 2832 4880</a></span>
										</span>

										<span class="shopItem" data-lat="22.279051" data-lng="114.183241" data-baidulat="22.28105" data-baidulng="114.190411" data-region="hongkong" data-district="kowloon" data-boutique="5">
											<a href="#" class="pinLink">
												<span class="shopDetails">
													<span class="shopName">Imperial Hotel, Tsimshatsui</span>
													<span class="shopAddress">Shop B5, G/F, 59 Russell Street, Causeway Bay, Hong Kong</span>
												</span>
											</a>
											<span class="shopTel">Tel: <a href="tel:85223666001">(+852) 2366 6001</a></span>
										</span>

										<span class="shopItem" data-lat="22.296536" data-lng="114.169175" data-baidulat="22.374451" data-baidulng="114.148243" data-region="hongkong" data-district="kowloon" data-boutique="6">
											<a href="#" class="pinLink">
												<span class="shopDetails">
													<span class="shopName">14 Canton Road, Tsimshatsui</span>
													<span class="shopAddress">G/F, 14 Canton Road, Tsimshatsui, Kowloon, Hong Kong</span>
												</span>
											</a>
											<span class="shopTel">Tel: <a href="tel:85223170055">(+852) 2317 0055</a></span>
										</span>

										<span class="shopItem" data-lat="22.304899" data-lng="114.161531" data-baidulat="22.306105" data-baidulng="114.17467" data-region="hongkong" data-district="kowloon" data-boutique="7">
											<a href="#" class="pinLink">
												<span class="shopDetails">
													<span class="shopName">Elements, 1 Austin Road West</span>
													<span class="shopAddress">Shops 2119 - 2120, Level 2, Elements, 1 Austin Road West, Kowloon, Hong Kong</span>
												</span>
											</a>
											<span class="shopTel">Tel: <a href="tel:85221776728">(+852) 2177 6728</a></span>
										</span>

										<span class="shopItem" data-lat="22.298354" data-lng="114.178421" data-baidulat="22.301608" data-baidulng="114.186238" data-region="hongkong" data-district="kowloon" data-boutique="8">
											<a href="#" class="pinLink">
												<span class="shopDetails">
													<span class="shopName">Tsimshatsui Centre, Tsimshatsui</span>
													<span class="shopAddress">G/F &amp; UG/F, Tsimshatsui Centre, 66 Mody Road, Tsimshatsui East, Kowloon, Hong Kong</span>
												</span>
											</a>
											<span class="shopTel">Tel: <a href="tel:85227232833">(+852) 2723 2833</a></span>
										</span>


										<span class="shopItem" data-lat="22.298354" data-lng="114.178421" data-baidulat="22.287822" data-baidulng="114.169825" data-region="hongkong" data-district="hkisland" data-boutique="9">
											<a href="#" class="pinLink">
												<span class="shopDetails">
													<span class="shopName">ifc Mall, Central</span>
													<span class="shopAddress">Shop 1001, Podium Level One, IFC Mall, 1 Harbour View Street, Central, Hong Kong</span>
												</span>
											</a>
											<span class="shopTel">Tel: <a href="tel:85222951688">(+852) 2295 1688</a></span>
										</span>

										<span class="shopItem" data-lat="22.295223" data-lng="114.167262" data-baidulat="22.300011" data-baidulng="114.180324" data-region="hongkong" data-district="kowloon" data-boutique="10">
											<a href="#" class="pinLink">
												<span class="shopDetails">
													<span class="shopName">Harbour City, Tsimshatsui</span>
													<span class="shopAddress">Shop OT 274-5, Level 2, Ocean Terminal, Harbour City, Tsimshatsui, Kowloon, Hong Kong</span>
												</span>
											</a>
											<span class="shopTel">Tel: <a href="tel:85227360111">(+852) 2736 0111</a></span>
										</span>

										<span class="shopItem" data-lat="22.2773813" data-lng="114.1645664" data-baidulat="22.28095" data-baidulng="114.176043" data-region="hongkong" data-district="kowloon" data-boutique="11">
											<a href="#" class="pinLink">
												<span class="shopDetails">
													<span class="shopName">Pacific Place, 88 Queensway</span>
													<span class="shopAddress">Shop 344, Pacific Place, 88 Queensway, Hong Kong (Gain entry via the entrance near the Celine and Loewe shop, next to Conrad Hotel's entrance on 3/F)</span>
												</span>
											</a>
											<span class="shopTel">Tel: <a href="tel:85227360111">(+852) 2736 0111</a></span>
										</span>

										<div class="locTitle" data-region="macau">MACAU</div>

										<span class="shopItem" data-lat="39.937417" data-lng="116.4546" data-baidulat="22.205065" data-baidulng="113.555562" data-region="macau" data-district="macau" data-boutique="12">
											<a href="#" class="pinLink">
												<span class="shopDetails">
													<span class="shopName">One Central Mall, Macau</span>
													<span class="shopAddress">Shop 248, Level 2, One Central Macau, Avenida de Sagres, Nape, Macau</span>
												</span>
											</a>
											<span class="shopTel">Tel: <a href="tel:862782790290">(+86 27) 8279 0290</a></span>
										</span>

										<div class="locTitle" data-region="china">CHINA</div>

										<span class="shopItem" data-lat="31.205971" data-lng="121.407699" data-baidulat="31.232703" data-baidulng="121.484522" data-region="china" data-district="east" data-boutique="13">
											<a href="#" class="pinLink">
												<span class="shopDetails">
													<span class="shopName">Shanghai</span>
												</span>
											</a>
										</span>

										<span class="shopItem" data-lat="28.194850" data-lng="112.997446" data-baidulat="28.179838" data-baidulng="112.992536" data-region="china" data-district="south" data-boutique="14">
											<a href="#" class="pinLink">
												<span class="shopDetails">
													<span class="shopName">Changsha</span>
												</span>
											</a>
										</span>

										<span class="shopItem" data-lat="30.585632" data-lng="114.301825" data-baidulat="30.541951" data-baidulng="114.338346" data-region="china" data-district="west" data-boutique="15">
											<a href="#" class="pinLink">
												<span class="shopDetails">
													<span class="shopName">Wuhan</span>
												</span>
											</a>
										</span>

										<span class="shopItem" data-lat="39.937417" data-lng="116.4546" data-baidulat="30.542091" data-baidulng="114.338095" data-region="china" data-district="north" data-boutique="16">
											<a href="#" class="pinLink">
												<span class="shopDetails">
													<span class="shopName">Beijing</span>
												</span>
											</a>
										</span>

										<span class="shopItem" data-lat="31.223314" data-lng="121.473668" data-baidulat="23.135242" data-baidulng="113.271296" data-region="china" data-district="east" data-boutique="17">
											<a href="#" class="pinLink">
												<span class="shopDetails">
													<span class="shopName">Guang Zhou</span>
												</span>
											</a>
										</span>

										<div class="locTitle" data-region="malaysia">MALAYSIA</div>

										<span class="shopItem" data-lat="3.157174" data-lng="101.712410" data-region="malaysia" data-district="isetan" data-boutique="18">
											<a href="#" class="pinLink">
												<span class="shopDetails">
													<span class="shopName">Jalan Ampang</span>
													<span class="shopAddress">Suria KLCC Mall, Jalan Ampang, 50088 Kuala Lumpur</span>
												</span>
											</a>
											<span class="shopTel">Tel: <a href="tel:862782790290">(+86 27) 8279 0290</a></span>
										</span>

										<span class="shopItem" data-lat="3.149090" data-lng="101.713478" data-region="malaysia" data-district="parkson" data-boutique="19">
											<a href="#" class="pinLink">
												<span class="shopDetails">
													<span class="shopName">Pavilion Kuala Lumpur</span>
													<span class="shopAddress">Pavilion Kuala Lumpur, 168 Jalan Bukit Bintang, 55100 Kuala Lumpur</span>
												</span>
											</a>
											<span class="shopTel">Tel: <a href="tel:862782790290">(+86 27) 8279 0290</a></span>
										</span>

										<span class="shopItem" data-lat="3.156304" data-lng="101.695450" data-region="malaysia" data-district="sogo" data-boutique="20">
											<a href="#" class="pinLink">
												<span class="shopDetails">
													<span class="shopName">SOGO Kuala Lumpur</span>
													<span class="shopAddress">SOGO Kuala Lumpur, 190 Jalan Tuanku Abdul Rahman, 50100 Kuala Lumpur</span>
												</span>
											</a>
											<span class="shopTel">Tel: <a href="tel:862782790290">(+86 27) 8279 0290</a></span>
										</span>

										<span class="shopItem" data-lat="1.520315" data-lng="110.354851" data-region="malaysia" data-district="metrojayacityonemegamall" data-boutique="21">
											<a href="#" class="pinLink">
												<span class="shopDetails">
													<span class="shopName">Cityone Megamall</span>
													<span class="shopAddress">G/F, Cityone Megamall, Jalan Song, 93350 Kuching, Sarawak</span>
												</span>
											</a>
											<span class="shopTel">Tel: <a href="tel:862782790290">(+86 27) 8279 0290</a></span>
										</span>

										<span class="shopItem" data-lat="3.118341" data-lng="101.677367" data-region="malaysia" data-district="metrojaya" data-boutique="22">
											<a href="#" class="pinLink">
												<span class="shopDetails">
													<span class="shopName">Mid Valley Megamall</span>
													<span class="shopAddress">Mid Valley Megamall, Valley City Lingkaran Syed Putra, 59200 Kuala Lumpur</span>
												</span>
											</a>
											<span class="shopTel">Tel: <a href="tel:862782790290">(+86 27) 8279 0290</a></span>
										</span>


										<div class="norecords">
											Shop not found.
										</div>

									</div>
									
								</div>
							</div>
						</div>
						
						<a href="javascript:void(0);" class="btnOpenLocation"></a>
					
				</div>
				
			</div>

		</div>
		
	</div>
	<div class="tracker"></div>
	<script type="text/javascript">
		var pageTitle = document.title;
		gLang = 'tc'; // sc or tc
		
		$(document).ready(init_fn);

		function init_fn() {

			common_init();
			locationInit();

		}

	</script>
</body>

</html>
