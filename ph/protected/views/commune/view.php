<?php 
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js' , CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->request->baseUrl. '/js/jquery.touch-punch.min.js' , CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->request->baseUrl. '/js/jquery.shapeshift.min.js' , CClientScript::POS_END);

$cs->registerCssFile(Yii::app()->request->baseUrl. '/js/morris.js-0.4.3/morris.css');
$cs->registerScriptFile(Yii::app()->request->baseUrl. '/js/morris.js-0.4.3/morris.min.js' , CClientScript::POS_END);
$cs->registerScriptFile( 'http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js' , CClientScript::POS_END);

?>
<style>
h2 {
	font-family: "Homestead";
  position:relative;
  top:0px;
  left:0px;
  color: #324553;
  
}
.grid a{
display:block;
font-family: "Homestead";
  position:relative;
  top:0px;
  left:0px;
  color: #324553;
}
.grid {
  border: 1px dashed #CCC;
  position: relative;
}

.grid > div {
  background: #AAA;
  position: absolute;
  height: 50px;
  width: 100px;
}

.grid > div[data-ss-colspan="2"] { width: 210px; }
.grid > div[data-ss-colspan="3"] { width: 320px; }

.grid > .ss-placeholder-child {
  background: transparent;
  border: 1px dashed blue;
}	
.graph div.block{border:1px solid #666;text-align:center}
#myfirstchart svg{z-index: 1000;}
.actu ul{text-align:left;font-size:small}
</style>
<div class="container graph">
    <br/>
    <div class="hero-unit">
    
    <h2> Commune <?php echo OpenData::$commune["974"][$cp]." ( ".$cp.""?></h2>
    <p> Un condenser de votre commune, contribuez à l'action locale. 
    <br/>Commencons par définir un canevas en format ouvert(opendata) decrivant une commune.
    <br/>Pour faciliter la tache pour toute les commune interressé par l'initiative.
    <br/>A tout moment il est important de communecter un maximum de citoyen.
    <br/>*se communecter : Un citoyen connecté à sa commune. 
    </p>
 	<div class="grid">
        <div data-ss-colspan="2"><a href="<?php echo Yii::app()->createUrl('index.php/commune/annuaireElus/ci/'.OpenData::$codePostalToCodeInsee["974"][$cp])?>"  > Annuaire des élus </a></div>
        <div data-ss-colspan="3"><a href="<?php echo Yii::app()->createUrl('index.php/commune/servicesMunicipaux/ci/'.OpenData::$codePostalToCodeInsee["974"][$cp])?>">Services Municipaux</a></div>
        <div data-ss-colspan="3"><a href="<?php echo Yii::app()->createUrl('index.php/opendata/commune/ci/'.OpenData::$codePostalToCodeInsee["974"][$cp])?>">Open Data Commune</a> </div>
        <div data-ss-colspan="2"><a href="#"   target="_blank" role="button" data-toggle="modal">Quartiers, Agglo</a></div>
        <div data-ss-colspan="2"><a href="#"   target="_blank" role="button" data-toggle="modal">Budget</a></div>
        <div></div>
        <div></div>
        <div></div>
   </div>
</div></div>

<div class="container graph">
<div class="hero-unit">
	<div class="row-fluid">
		<div class="span4 block">
			<h2>Évolution population</h2>
			<script>var population = [];
			<?php 
			$cpdb = Yii::app()->mongodb->codespostaux->findOne(array("codeinsee"=>OpenData::$codePostalToCodeInsee[$dep][$cp],"type"=>"commune"));
			foreach($cpdb["demographie"] as $an=>$pop)
			    echo "population.unshift({y:'$an',a:$pop,b:10000});";
			?>
			    </script>
			<div id="myfirstchart" style="height: 250px;"></div>
		</div>
		<div class=" actu span4 block">
			<h2>Informations / Activité</h2>
			
			<?php 
			$content = file_get_contents('http://www.saintjoseph.re/spip.php?page=rss_nouveautes');  
            $x = new SimpleXmlElement($content);  
              
            echo "<ul>";  
              
            foreach($x->channel->item as $entry) {  
                echo "<li><a href='$entry->link' title='$entry->title'>" . $entry->title . "</a></li>";  
            }  
            echo "</ul>";  
			?>
			
		</div>
		<div class="span4 block">
			<h2>Associations </h2>
			<?php 
			$assos = Yii::app()->mongodb->group->find(array("cp"=>$cp,"type"=>"association"));
			foreach($assos as $a)
			    echo $a["name"]."<br/>";?>
			Annuaire Associations par filtre évolué
		</div>
	</div>
	<br/>
	<div class="row-fluid">
		<div class="span8 block">
		<h2>Photographies / Vidéos</h2>
		<div id="myCarousel" class="carousel slide">
            
              <div class="space20px;"></div>
              <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
              </ol>
              <!-- Carousel nav -->
              <div class="carousel-controls">
                  <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
                  <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
              </div>
              <!-- Carousel items -->
              <div class="carousel-inner" style="width:85%;margin-left:60px">
              	
              	<?php 
              	function get_url_contents($url) {
                    $crl = curl_init();
                
                    curl_setopt($crl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
                    curl_setopt($crl, CURLOPT_URL, $url);
                    curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($crl, CURLOPT_CONNECTTIMEOUT, 5);
                
                    $ret = curl_exec($crl);
                    curl_close($crl);
                    return $ret;
                }
                $q = urlencode(OpenData::$commune["974"][$cp]." réunion");
                $json = get_url_contents('http://ajax.googleapis.com/ajax/services/search/images?v=1.0&q='.$q);
                
                $data = json_decode($json);
                
                if(isset($data->responseData->results)){
                    foreach ($data->responseData->results as $result) {
                        $results[] = array('url' => $result->url, 'alt' => $result->title);
                        
                    }
                    $ct = "active";
                    foreach($results as $r){
                        
                        echo '<div class="'.$ct.' item p40" >';
                        echo "<img width=500 src='".$r["url"]."'/>";
                        
                        echo '<div class="clear"></div></div>';
                        $ct = "";
                    }
                }
              	?>
              	
              		
               </div> 
              
    		<div class="clear"></div>
        </div>
        
		</div>
		<div class="span4 block">
		<h2>Entreprises </h2>
		<?php 
			$assos = Yii::app()->mongodb->group->find(array("cp"=>$cp,"type"=>"entreprise"));
			foreach($assos as $a)
			    echo $a["name"]."<br/>";?>
			Annuaire Entreprise locales
		</div>
	</div>
	<br/>
	<div class="row-fluid">
		<div class="span4  block">
		<h2>Agenda</h2>
		flux RSS de divers source locale
		</div>
		<div class="span4 block">
		<h2>Découvrez</h2>
		</div>
		<div class="span4 block">
		<h2>Participez</h2>
		</div>
	</div>
	<br/>
	<div class="row-fluid">
		<div class="span6 block">
		<h2>Interrogez</h2>
		</div>
		<div class="span6 block ">
		<h2>Recommendez</h2>
		</div>
	</div>
	<br/>
	<div class="row-fluid">
		<div class="span4 block">
		<h2>Petites Annonces</h2>
		</div>
		<div class="span4 block">
		<h2>Covoiturez</h2>
		</div>
		<div class="span4 block">
		<h2>Rézoté</h2>
		</div>
	</div>
	<br/>
	<div class="row-fluid">
		<div class="span6 block">
		<h2>Calendrier</h2>
		</div>
		<div class="span6 block">
		<h2></h2>
		</div>
	</div>
	
</div></div>

<script type="text/javascript"		>
initT['animInit'] = function(){
	Morris.Bar({
		  element: 'myfirstchart',
		  data: population,
		  xkey: 'y',
		  ykeys: ['a', 'b'],
		  labels: ['Series A', 'Series B']
		});
	$(".grid").shapeshift({
	    minColumns: 3
	  });
        (function ani(){
        	  TweenMax.staggerFromTo(".container h2", 4, {scaleX:0.4, scaleY:0.4}, {scaleX:1, scaleY:1},1);
        })();
};
</script>			