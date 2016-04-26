<?php
	include_once(dirname(__FILE__).'/../include/global.include.php');
	
	// Get the language parameter and load website content
	$lang = strtolower(trim($SYSCONFIG['FRONT_END']['DEFAULT_LANG']));
	if (isset($_REQUEST['lang']) === true && in_array(strtolower(trim($_REQUEST['lang'])), $SYSCONFIG['FRONT_END']['LANG_SET']) === true) {
		$lang = strtolower(trim($_REQUEST['lang']));
	}
	include_once(dirname(__FILE__).'/../lang/lang.'.$lang.'.php');
	
	$url = $SYSCONFIG['GAPI_Host']['URL'];

	// Load region list
	$dataArr = $_REQUEST;
	$dataArr['m'] = 'FIND_A_STORE_REGION';
	$dataArr['token'] = $SYSCONFIG['TOKEN']['FIND_A_STORE_REGION'];
	$dataArr['locale'] = $lang;
	
	$dataArr['func'] = 'getList';
	// debug_r($dataArr); exit;
	// debug_r($url.'?'.http_build_query($dataArr, '', '&')); exit;
	$returnStr = getData($url, $dataArr);
	$dataSet = json_decode($returnStr, true);
	// debug_r($returnStr); exit;
	// debug_r($dataSet); exit;
	
	$regionArr = array();
	if ($dataSet['hasError'] === false && count($dataSet['ResponseObj']['Items']) > 0) {
		$regionArr = $dataSet['ResponseObj']['Items'];
	}
	unset($dataSet);

	// Load district list
	$dataArr = $_REQUEST;
	$dataArr['m'] = 'FIND_A_STORE_DISTRICT';
	$dataArr['token'] = $SYSCONFIG['TOKEN']['FIND_A_STORE_DISTRICT'];
	$dataArr['locale'] = $lang;
	
	$dataArr['func'] = 'getList';
	// debug_r($dataArr); exit;
	// debug_r($url.'?'.http_build_query($dataArr, '', '&')); exit;
	$returnStr = getData($url, $dataArr);
	$dataSet = json_decode($returnStr, true);
	// debug_r($returnStr); exit;
	// debug_r($dataSet); exit;
	
	$districtArr = array();
	if ($dataSet['hasError'] === false && count($dataSet['ResponseObj']['Items']) > 0) {
		$districtArr = $dataSet['ResponseObj']['Items'];
	}
	unset($dataSet);

	// Load list
	$dataArr = $_REQUEST;
	$dataArr['m'] = 'FIND_A_STORE';
	$dataArr['token'] = $SYSCONFIG['TOKEN']['FIND_A_STORE'];
	$dataArr['locale'] = $lang;
	
	$dataArr['func'] = 'getList';
	// debug_r($dataArr); exit;
	// debug_r($url.'?'.http_build_query($dataArr, '', '&')); exit;
	$returnStr = getData($url, $dataArr);
	$dataSet = json_decode($returnStr, true);
	// debug_r($returnStr); exit;
	// debug_r($dataSet); exit;
	
	$storeArr = array();
	if ($dataSet['hasError'] === false && count($dataSet['ResponseObj']['Items']) > 0) {
		foreach($dataSet['ResponseObj']['Items'] as $item)  {
			$storeArr[intval($item['region_id'], 10)][] = $item;
		}
	}
	unset($dataSet);
	
?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-hk">

<head>
	<meta name="description" content="<?php echo encodeSpecChar($langArr['FIND_A_STORE']['META_DESCRIPTION']); ?>" />
	<meta name="keywords" content="<?php echo encodeSpecChar($langArr['FIND_A_STORE']['META_KEYWORD']); ?>" />
	
	<meta property="og:description" content="<?php echo encodeSpecChar($langArr['FIND_A_STORE']['META_DESCRIPTION']); ?>" />
	<meta property="og:image" content="" />
	<meta property="og:image:height" content="" />
	<meta property="og:image:width" content="" />
	<meta property="og:site_name" content="<?php echo encodeSpecChar($langArr['FIND_A_STORE']['PAGE_TITLE']); ?>" />
	<meta property="og:title" content="<?php echo encodeSpecChar($langArr['FIND_A_STORE']['PAGE_TITLE']); ?>" />
	<meta property="og:type" content="Article" />
	<meta property="og:url" content="http://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']?>" />
	
	<?php include_once(dirname(__FILE__).'/../include/common/include.php'); ?>
	
	<!--Individual-->
	<link rel="stylesheet" href="/css/store.css" type="text/css" />
	
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&language=en"></script>
	<script type="text/javascript" src="/js/jquery.history.js"></script>
	<script type="text/javascript" src="/js/infobox.js"></script>
	<script type="text/javascript" src="/js/markerwithlabel.js"></script>
	<script type="text/javascript" src="/js/location.js"></script>
	
	<script type="text/javascript" src="http://api.map.baidu.com/api?key=&v=1.4&services=true"></script>
	<script type="text/javascript" src="/js/infobox_baidu.js"></script>

	<title><?php echo $langArr['FIND_A_STORE']['PAGE_TITLE']; ?></title>
</head>

<body>
	<div class="loading in"><div class="imgLoading active"></div></div>
	
	<div class="wrapper store">
		
		<div class="main">
			<?php include_once(dirname(__FILE__).'/../include/'.$lang.'/header.php'); ?>

			<div class="content">

				<?php include_once(dirname(__FILE__).'/../include/'.$lang.'/mobileHeader.php'); ?>

				<div class="innerContent">
				
					<div class="mapWrapper">

							<div class="mapCanvas" id="mapCanvas"></div>
							<div class="mapCanvas baiduMap" id="baiduMap"></div>

							<div class="shopListContainer">
							
								<a href="javascript:void(0);" class="icon-icoArrowRight btnToggleMapList"></a>
								
								<div class="locationFilterBar">
								
									<a href="javascript:void(0);" class="btnBackToMap"><span class="icon-icoArrowLeft"></span><?php echo $langArr['FIND_A_STORE']['BUTTON']['BACK']; ?></a>
								
									<div class="region pageCatItem">
										<select class="regionSelector">
											<option value=""><?php echo $langArr['FIND_A_STORE']['REGION']['ALL']; ?></option>
											<?
											if (count($regionArr) > 0) {
												foreach($regionArr as $item) {
											?>
											<option value="<?php echo $item['region_code']; ?>"><?php echo $item['title']; ?></option>
											<?php
												}
											}
											?>
										</select>
									</div>
									<div class="district pageCatItem">
										<select>
											<option value=""><?php echo $langArr['FIND_A_STORE']['DISTRICT']['ALL']; ?></option>
											<?
											if (count($districtArr) > 0) {
												foreach($districtArr as $item) {
											?>
											<option value="<?php echo $item['district_code']; ?>" data-region="<?php echo $item['region_code']; ?>"><?php echo $item['title']; ?></option>
											<?php
												}
											}
											?>
										</select>
									</div>
									<!--<a href="javascript:void(0);" class="commonBtn btnOpenLocation">
										<span class="txt"><?php echo $langArr['FIND_A_STORE']['BUTTON']['YOUR_NEAREST_STORE']; ?></span>
									</a>-->
								</div>

								<div class="shopListWrapper">
									
									<div class="shopList">

										<?php
										if (count($storeArr) > 0) {
											$boutique = 0;
											foreach($storeArr as $storeItem) {
										?>
										<div class="locTitle" data-region="region<?php echo $storeItem[0]['region_code']; ?>"><?php echo $storeItem[0]['region']; ?></div>
										<?php
												foreach($storeItem as $item) {
										?>
										<span class="shopItem" data-lat="<?php echo $item['google_lat']; ?>" data-lng="<?php echo $item['google_lng']; ?>" data-baidulat="<?php echo $item['baidu_lat']; ?>" data-baidulng="<?php echo $item['baidu_lng']; ?>" data-region="<?php echo $item['region_code']; ?>" data-district="<?php echo $item['district_code']; ?>" data-boutique="<?php echo ++$boutique; ?>">
											<a href="#" class="pinLink">
												<span class="shopDetails">
													<span class="shopName"><?php echo $item['title']; ?></span>
													<?php
													if (trim($item['address']) != '') {
													?>
													<span class="shopAddress"><?php echo $item['address']; ?></span>
													<?php
													}
													?>
												</span>
											</a>
											<?php
											if (trim($item['phone']) != '') {
												$phoneLink = trim($item['phone']);
												$phoneLink = str_replace(' ', '', $phoneLink);
												$phoneLink = str_replace('(', '', $phoneLink);
												$phoneLink = str_replace(')', '', $phoneLink);
												$phoneLink = str_replace('+', '', $phoneLink);
											?>
											<span class="shopTel"><?php echo $langArr['FIND_A_STORE']['TEL']; ?>: <a href="tel:<?php echo $phoneLink; ?>"><?php echo $item['phone']; ?></a></span>
											<?php
											}
											?>
										</span>
										<?php
												}
											}
										}
										?>


										<div class="norecords">
											<?php echo $langArr['FIND_A_STORE']['SHOP_NOT_FOUND']; ?>
										</div>

									</div>
									
								</div>
							</div>
						</div>
						
					<?php include_once(dirname(__FILE__).'/../include/'.$lang.'/footer.php'); ?>
					<?php include_once(dirname(__FILE__).'/../include/'.$lang.'/popup.php'); ?>
					
				</div>
				
			</div>

		</div>
		
	</div>
	<div class="tracker"></div>
	<script type="text/javascript">
		var pageTitle = document.title;
		gCurrentPage = 0;
		gLang = '<?php echo strtolower($lang); ?>';
		
		$(document).ready(init_fn);

		function init_fn() {

			common_init();
			locationInit();

		}

	</script>
</body>

</html>
