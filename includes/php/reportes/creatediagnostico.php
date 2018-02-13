<?php
	ob_start();
     include(dirname(__FILE__).'/pdfdiagnostico.php');  
	$content = ob_get_clean();

	// conversion HTML => PDF
	require_once(dirname(__FILE__).'/html2pdf.class.php');
  $html2pdf = new HTML2PDF('P','A4','fr' , array(20, 10, 10, 10));
	$html2pdf->pdf->IncludeJS("print(true);");	//Muestra el mensaje de impresion.*/
	//$html2pdf->addFont('Trebuchet_MS', '', 'Trebuchet_MS.php');
	//$html2pdf->addFont('lato i', '', 'latoi.php');
	$html2pdf->WriteHTML($content, isset($_GET['vuehtml']));
	$html2pdf->Output("Algo".".pdf");
?>