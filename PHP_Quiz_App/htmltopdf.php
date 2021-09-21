<?php


require_once 'dompdf/autoload.inc.php';



use Dompdf\Dompdf;



$document = new Dompdf();




$page = file_get_contents("./test-pdf.php");

$document->loadHtml($page);





$document->setPaper('A4', 'landscape');



$document->render();



$document->stream("Report", array("Attachment"=>0));



?>