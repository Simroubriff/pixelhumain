<?php
/**
 * [actionAddWatcher 
 * create or update a user account
 * if the email doesn't exist creates a new citizens with corresponding data 
 * else simply adds the watcher app the users profile ]
 * @return [json] 
 */
class GenerateTicketPdfAction extends CAction
{
    public function run()
    {
		require_once("../ph/protected/extensions/barcodegen/html/include/function.php");
		require_once("../ph/protected/extensions/fpdf.php");
		
		//$offerID = Yii::app()->session['offer'];
		$offerID = $_POST['orderID'];
		//$ts = PHDB::findOne( PHType::TYPE_EVENTS, array( "_id" => new MongoId( $offerID ) ) );
		$m = new MongoClient("mongodb://oceatoon:6ognom9_$@open-atlas.org:27017/");
		$db = $m->selectDB ( "pixelhumainQA" );
		$tickets = new MongoCollection($db, 'tickets');
		$ts = $tickets->findOne(array("_id"=>new MongoId($offerID)));
		$image1 = "http://dev.azotlive.com/barcodegen/html/include/logo.png";   
		$now = new DateTime();
		$now->setTimezone(new DateTimeZone('Indian/Reunion'));
		$date = $now->format("d/m/Y G:i");

		/* $organizer_name = $ts["organizer"]["@Type"] . ' presente';
		$organizer_name = iconv('UTF-8', 'windows-1252', $organizer_name);
		$event_title = iconv('UTF-8', 'windows-1252', $ts['name']);
		$event_loc = $ts['location']['name'] . ', ';
		$event_loc = iconv('UTF-8', 'windows-1252', $event_loc);
		$event_time = $ts["startDate"];    
		$evn_loc_time =  $ts["startDate"] ." - ". $event_loc = iconv('UTF-8', 'windows-1252', $ts['location']['name']);
		$ticket_categoty = iconv('UTF-8', 'windows-1252', $t['type']);
		$price = $t['price'];
		$paid_price = "**"."$price"."Euros"."**";
		$org_licence = '12ycytdtyttgq24';
		$event_org_li = "Event Organizer Licence Number : "."$org_licence";
		$ticket_Number = $tn["ticketNumber"];
		$info = "organisateur ocsesionel";
		$organizer_info = "N LIC :". $ts["organizer"]["@id"];
		$barcode = time()."azotlive".$tn["ticketNumber"]; */
		// usage:
		$num_of_tickets = 4;
		$pdf = new FPDF('P','mm',array(150,101));


		$default_value = array();
		$default_value['filetype'] = 'PNG';
		$default_value['dpi'] = 30;
		$default_value['scale'] = isset($defaultScale) ? $defaultScale : 3;
		$default_value['rotation'] = 0;
		$default_value['font_family'] = 'Arial.ttf';
		$default_value['font_size'] = 28;

		$default_value['a1'] = '';
		$default_value['a2'] = '';
		$default_value['a3'] = '';

		$filetype = isset($_POST['filetype']) ? $_POST['filetype'] : $default_value['filetype'];
		$dpi = isset($_POST['dpi']) ? $_POST['dpi'] : $default_value['dpi'];
		$scale = intval(isset($_POST['scale']) ? $_POST['scale'] : $default_value['scale']);
		$rotation = intval(isset($_POST['rotation']) ? $_POST['rotation'] : $default_value['rotation']);
		$font_family = isset($_POST['font_family']) ? $_POST['font_family'] : $default_value['font_family'];
		$font_size = intval(isset($_POST['font_size']) ? $_POST['font_size'] : $default_value['font_size']);
		registerImageKey('filetype', $filetype);
		registerImageKey('dpi', $dpi);
		registerImageKey('scale', $scale);
		registerImageKey('rotation', $rotation);
		registerImageKey('font_family', $font_family);
		registerImageKey('font_size', $font_size);
		registerImageKey('code', 'BCGcode39');
		registerImageKey('thickness','90');

		$pdf = new FPDF('P','mm',array(150,101));
		
		foreach( $ts["tickets"]["@list"] as $t )
		{
			foreach( $t["ticketNumbers"] as $tn )
			{
				$event_data = PHDB::findOne( PHType::TYPE_EVENTS, array( "_id" => new MongoId( $t['@id'] ) ) );
				$organizer_name = $event_data["organizer"]["@Type"] . ' presente';
				$organizer_name = iconv('UTF-8', 'windows-1252', $organizer_name);
				$event_title = iconv('UTF-8', 'windows-1252', $t['name']);
				$event_loc = $event_data['location']['name'] . ', ';
				$event_loc = iconv('UTF-8', 'windows-1252', $event_loc);
				$event_time = $event_data["startDate"];    
				$evn_loc_time =  $event_data["startDate"] ." - ". $event_loc = iconv('UTF-8', 'windows-1252', $event_data['location']['name']);
				$ticket_categoty = iconv('UTF-8', 'windows-1252', $t['type']);
				$price = $t['price'];
				$paid_price = "**"."$price"."Euros"."**";
				$org_licence = '12ycytdtyttgq24';
				$event_org_li = "Event Organizer Licence Number : "."$org_licence";
				$ticket_Number = $tn["ticketNumber"];
				$info = "organisateur ocsesionel";
				$organizer_info = "N LIC :". $event_data["organizer"]["@id"];
				$barcode = time()."azotlive".$tn["ticketNumber"];
				
				registerImageKey('text', $ticket_Number);
				// Text in form is different than text sent to the image
				$text = convertText('Ticket Generation dummy text');
				$finalRequest = '';
				foreach (getImageKeys() as $key => $value) {
					$finalRequest .= '&' . $key . '=' . urlencode($value);
				}
			
				if (strlen($finalRequest) > 0) {
					$finalRequest[0] = '?';
				}
				$content = file_get_contents("http://dev.azotlive.com/barcodegen/html/image.php" .$finalRequest);
				file_put_contents('../ph/protected/extensions/BarCodeImages/barcode-'.$ticket_Number.'.png', $content);
			
				$pdf->AddPage("L");
				$pdf->SetAutoPageBreak(TRUE, 0);
				$pdf->SetFont('Arial','',12);
				$pdf->SetXY(0,4);
				$pdf->SetFillColor(92,143,203);
				$pdf->Rect(0, 18, 300, 4, 'F');
				$pdf->Image($image1, 4, $pdf->GetY(), 38.78);
				$pdf->SetTextColor(0,0,0);
				$pdf->SetFont('Arial','',11);
				$pdf->SetXY(110,5);
				$pdf->Cell (0,0,$date, 0,1, 'L');
				$pdf->SetFont('Arial','',8);
				$pdf->SetTextColor(0,0,0);
				$pdf->SetXY(42,16);
				$pdf->Cell (0,0,$organizer_name, 0,1, 'L');
				$pdf->SetTextColor(0,0,0);
				$pdf->SetFont('Arial','',12);
				$pdf->SetXY(10,20);
				$pdf->Cell (10,32,$ticket_categoty, 0,1, 'L');
				$pdf->SetTextColor(0,0,0);
				$pdf->SetFont('Arial','B',13);
				$pdf->SetXY(10,20);
				$pdf->Cell (10,50,$paid_price, 0,1, 'L');
				$pdf->SetTextColor(0,0,0);
				$pdf->SetFont('Arial','B',14);
				$pdf->SetXY(70,20);
				$pdf->Cell (70,42,$event_title, 0,1, 'L');
				$pdf->SetTextColor(0,0,0);
				$pdf->SetFont('Arial','',11);
				$pdf->SetXY(10,30);
				$pdf->Cell (0,46,$evn_loc_time, 0,1, 'L');
				$pdf->SetFillColor(92,143,203);
				$pdf->Rect(0, 57, 300, 4, 'F');
				$pdf->SetTextColor(0,0,0);
				$pdf->SetFont('Arial','',9);
				$pdf->SetXY(10,59.2);
				$pdf->Cell (10,0,$ticket_Number, 0,1, 'L');
				$pdf->Image('../ph/protected/extensions/BarCodeImages/barcode-'.$ticket_Number.'.png',80,66,30,30);
				$pdf->SetTextColor(0,0,0);
				$pdf->SetFont('Arial','',8);
				$pdf->SetXY(0,94);
				$pdf->Cell (10,0,$organizer_info, 0,1, 'L');
			}
		}
		$pdf->Output('../ph/protected/extensions/EventTicketPDFs/ticket-'.$ticket_Number.'.pdf', 'F');

		// email stuff (change data below)
		/* $to = ( isset($_POST['messageType']) ) ? "azotlivecontact@gmail.com" : $p["email"]; 
		$CC = "azotlivecontact@gmail.com"; 
		$from = "azotlive@gmail.com"; 
		$subject = "AzotLive : Billet URBAN BLOCK PARTY"; 
		$message = "<p><img src='http://dev.azotlive.com/barcodegen/html/include/logo.png' style='width:130px;float:left;padding:20px;'/>".
		"L'équipe d'azotlive.com vous souhaite de profiter de votre spectacle.<br/>".
		"Vous trouverez ci-joint le(s) billet(s) correspondant a votre commande.<br/>".
		"<br/>".
		"Informations spécifiques:<br/>".
		"Contrôle et fouille à l’entrée.<br/>".
		"Nourriture et boissons (autres que bouteille d’eau) interdites dans l’enceinte de la NORDEV.<br/>".
		"Appareil photo et caméra interdits.<br/>".
		"L’annulation d’un artiste ne donne pas lieu à un remboursement du billet.<br/><br/>".
		"Les places à retirer dans les Mac Donald's, achetées avant le 30 septembre 2014, seront disponibles à partir du 1er octobre 2014.<br/>
		Les places à retirer dans les Mac Donald's, achetées à partir du 30 septembre 2014, seront disponibles à partir du 10 octobre 2014.<br/>";
		 
		// a random hash will be necessary to send mixed content
		$separator = md5(time());

		// carriage return type (we use a PHP end of line constant)
		$eol = PHP_EOL;

		// attachment name
		$filename = "ticket.pdf";

		// encode data (puts attachment in proper format)
		$pdfdoc = $pdf->Output("", "S");
		$attachment = chunk_split(base64_encode($pdfdoc));

		// main header
		$headers  = "From: ".$from.$eol;
		$headers  = "CC: ".$CC.$eol;
		$headers .= "MIME-Version: 1.0".$eol; 
		$headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"";

		// no more headers after this, we start the body! //

		$body = "--".$separator.$eol;
		$body .= "Content-Transfer-Encoding: 7bit".$eol.$eol;

		// message
		$body .= "--".$separator.$eol;
		$body .= "Content-Type: text/html; charset=\"utf-8\"".$eol;
		$body .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
		$body .= $message.$eol;

		// attachment
		$body .= "--".$separator.$eol;
		$body .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol; 
		$body .= "Content-Transfer-Encoding: base64".$eol;
		$body .= "Content-Disposition: attachment".$eol.$eol;
		$body .= $attachment.$eol;
		$body .= "--".$separator."--";

		// send message
		mail($to, $subject, $body, $headers);
		 */
		
    }
}
?>