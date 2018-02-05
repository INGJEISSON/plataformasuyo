<?php
	ob_start();
     include(dirname(__FILE__).'/pdfdiagnostico.php');  
	$content = ob_get_clean();

	// conversion HTML => PDF
	require_once(dirname(__FILE__).'/html2pdf.class.php');
  $html2pdf = new HTML2PDF('P','Letter','fr' , array(30, 10, 30, 15));
	$html2pdf->pdf->IncludeJS("print(true);");	//Muestra el mensaje de impresion.*/
	$html2pdf->WriteHTML($content, isset($_GET['vuehtml']));
	$html2pdf->Output("Algo".".pdf");
?>