<!DOCTYPE html>
<!-- Template Name: Rapido - Responsive Admin Template build with Twitter Bootstrap 3.x Version: 1.0 Author: ClipTheme -->
<!--[if IE 8]><html class="ie8 no-js" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9 no-js" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
	<!--<![endif]-->
	<!-- start: HEAD -->
	<head>
		<title>Rapido - Responsive Admin Template</title>
		<!-- start: META -->
		<meta charset="utf-8" />
		<!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="" name="description" />
		<meta content="" name="author" />
		<!-- end: META -->
		<!-- start: MAIN CSS -->
		<?php 
		$cs = Yii::app()->getClientScript();
		$cs->registerCssFile(Yii::app()->theme->baseUrl. '/assets/plugins/bootstrap/css/bootstrap.min.css');
		$cs->registerCssFile(Yii::app()->theme->baseUrl. '/assets/plugins/font-awesome/css/font-awesome.min.css');
		$cs->registerCssFile(Yii::app()->theme->baseUrl. '/assets/plugins/animate.css/animate.min.css');
		$cs->registerCssFile(Yii::app()->theme->baseUrl. '/assets/plugins/iCheck/skins/all.css');
		$cs->registerCssFile(Yii::app()->theme->baseUrl. '/assets/css/styles.css');
		$cs->registerCssFile(Yii::app()->theme->baseUrl. '/assets/css/styles-responsive.css');
		$cs->registerCssFile(Yii::app()->theme->baseUrl. '/assets/plugins/iCheck/skins/all.css');
		echo "<!--[if IE 7]>";
		$cs->registerCssFile(Yii::app()->theme->baseUrl. '/assets/plugins/font-awesome/css/font-awesome-ie7.min.css');
		?>
		<!--[endif]-->
		<!-- end: MAIN CSS -->
		<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
		<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
		<script>
		   var initT = new Object();
		   var showDelaunay = true;
		   var baseUrl = "<?php echo Yii::app()->getRequest()->getBaseUrl(true);?>";
		   var themeUrl = "<?php echo Yii::app()->theme->baseUrl;?>";
		</script>
	</head>
	<!-- end: HEAD -->
	<!-- start: BODY -->
	<body class="login">
		<?php echo $content;  ?>
		<!-- start: MAIN JAVASCRIPTS -->
		<?php
		echo "<!-- start: MAIN JAVASCRIPTS -->";
		echo "<!--[if lt IE 9]>";
		$cs->registerScriptFile(Yii::app()->theme->baseUrl. '/assets/plugins/respond.min.js' , CClientScript::POS_HEAD);
		$cs->registerScriptFile(Yii::app()->theme->baseUrl. '/assets/plugins/excanvas.min.js' , CClientScript::POS_HEAD);
		$cs->registerScriptFile(Yii::app()->theme->baseUrl. '/assets/plugins/jQuery/jquery-1.11.1.min.js' , CClientScript::POS_HEAD);
		echo "<![endif]-->";
		echo "<!--[if gte IE 9]><!-->";
		$cs->registerScriptFile(Yii::app()->theme->baseUrl. '/assets/plugins/jQuery/jquery-2.1.1.min.js' , CClientScript::POS_HEAD);
		echo "<!--<![endif]-->";
		$cs->registerScriptFile(Yii::app()->theme->baseUrl. '/assets/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js' , CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->theme->baseUrl. '/assets/plugins/bootstrap/js/bootstrap.min.js' , CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->theme->baseUrl. '/assets/plugins/iCheck/jquery.icheck.min.js' , CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->theme->baseUrl. '/assets/plugins/jquery.transit/jquery.transit.js' , CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->theme->baseUrl. '/assets/plugins/TouchSwipe/jquery.touchSwipe.min.js' , CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/api.js' , CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->theme->baseUrl. '/assets/js/main.js' , CClientScript::POS_END);
		//<!-- end: MAIN JAVASCRIPTS -->
		//<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		?>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		
	</body>
	<!-- end: BODY -->
</html>