<?php 
//$this->renderPartial("../docs/assets");
$cssAnsScriptFilesTheme = array(
		
	'/plugins/jQCloud/dist/jqcloud.min.js',
	'/plugins/jQCloud/dist/jqcloud.min.css',

);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesTheme,Yii::app()->request->baseUrl);

?>
<style type="text/css">
    .tpl_title{font-size: 38px!important;}
    #notragoraExplains{
		position: relative;
	    top: -10px;
	    right: -15px;
	    -moz-box-shadow: 0px 5px 5px -2px #656565 !important;
	    -webkit-box-shadow: 0px 5px 5px -2px #656565 !important;
	    -o-box-shadow: 0px 5px 5px -2px #656565 !important;
	    box-shadow: 0px -5px 5px -2px #656565 !important;
	    margin-bottom: -100px;
    }
    .pointCircle{
		position: absolute;
	    left: -40px;
	    top: 10px;
	    height: 20px;
	    width: 20px;
	    border-radius: 10px;
	    background-color: grey;
    }
</style>
<div class="col-md-9">
	<div id="canvas" class="col-md-12">
	</div>
</div>
<div class="col-md-3" id="notragoraExplains">
	<div class="panel-white padding-15">
		<div class="col-md-12 no-padding">
		<span class="pointCircle"></span>
		<h4 clss="title-menu-left" style="color:#484848">Bienvenu sur la plateforme Notragora</h4>
		<span>
		Bienvenu dans notre Agora etc etc... Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. <br/><br/>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.<br/><br/></span>
		</div>
		<div class="col-md-12 no-padding">
		<span class="pointCircle"></span>
		<h4 clss="title-menu-left" style="color:#484848">La plateforme en chiffres</h4>
		<span>
		Bienvenu dans notre Agora etc etc... Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
		</span>
		</div>
	</div>
</div>
<script type="text/javascript">

var words = [
  {text: "Réseaux", weight: 13},
  {text: "Vidéo", weight: 10.5},
  {text: "Harcèlement", weight: 9.4},
  {text: "Intégration", weight: 8},
  {text: "Différence", weight: 6.2},
  {text: "Portrait", weight: 5},
  {text: "Identité", weight: 5},
  {text: "Intégration", weight: 13},
  {text: "Insertion", weight: 10.5},
  {text: "Emploi", weight: 9.4},
  {text: "Avenir", weight: 8},
  {text: "Documentaire", weight: 6.2},
  {text: "Fiction", weight: 5},
  {text: "FilmsOutils", weight: 13},
  {text: "FilmDeCommande", weight: 5},
  {text: "PortraitCitoyens", weight: 9.4},
  {text: "ParcoursDEngagement", weight: 8},
  {text: "PasseurDImages", weight: 13},
];
jQuery(document).ready(function() {
	$('#canvas').jQCloud(words, {
  height: 600,
  autoResize: true,
   shape: 'rectangular',
   colors: ["#484848", "#6c6969", "#929292"],
  fontSize: {
    from: 0.1,
    to: 0.02
  }
});
  setTitle("<span class='text-red'>Commune<span class='text-dark'>cter</span> : la doc</span>","connectdevelop", "Communecter : La Doc");
});
</script>

