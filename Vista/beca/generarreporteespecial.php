

<?php
session_start();
require_once("../dompdf/dompdf_config.inc.php");



$code.="<center><img src='../imagenes1/encabezado.png'></center>";


    $code.="<h1 class=texto>".$_SESSION['titulo']."</h1>";
    $code.=$_SESSION['reportebeca'];
    $filename= $_SESSION['titulo'].'.pdf';



$code.='<link rel="stylesheet" href="../css/pdfreporte.css" type="text/css">';



$dompdf = new DOMPDF();
$dompdf->load_html($code);
$dompdf->set_paper('office','portrait');
$dompdf->render(); //este comando renderiza el PDF

$canvas = $dompdf->get_canvas();
$footer = $canvas->open_object();
$w = $canvas->get_width();
$h = $canvas->get_height();
$canvas->page_text($w-80,$h-15,"Página {PAGE_NUM} de {PAGE_COUNT}", Font_Metrics::get_font('helvetica'),9);
$canvas->page_text($w-450,$h-15,"Instituto Autónomo del Deporte FUNDEY", Font_Metrics::get_font('helvetica'),9);

$pdf = $dompdf->output(); //extrae el contenido renderizado del PDF


$dompdf->stream($filename,array("attachment"=>0));

$html_para_pdf = ob_get_clean();


