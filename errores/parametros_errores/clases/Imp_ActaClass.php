<?php
final class Imp_Acta{
  private $Conex;
  
	public function __construct($Conex){    
		$this -> Conex = $Conex;  
	}

	public function printOut($acta1_id,$download,$nombre_pdf){
    	
		require_once("Imp_ActaLayoutClass.php");
		require_once("../../../framework/clases/fpdf/fpdf.php");		 
		require_once("Imp_ActaModelClass.php");

		$Layout = new Imp_ActaLayout();
		$Model  = new Imp_ActaModel();

		$acta_id = $_REQUEST['acta_id'];

		if ($acta_id=='') {
			$acta_id = $acta1_id;
		}

		$encabezado		= $Model -> getEncabezado($acta_id,$this -> Conex);	  
		$temas			= $Model -> getimputaciones($acta_id,$this -> Conex);  
		$acuerdos			= $Model -> getTotal($acta_id,$this -> Conex);  
		$participantes	= $Model -> getTotales($acta_id,$this -> Conex);
		
		// tamaño de letras
		$tamaño_titulos = 15;
		$tamaño_subtitulos = 9;
		$tamaño_letra = 8;
		// tamaño de letras

		$pdf=new FPDF();
		$pdf->AddPage('P','Letter','mm');
		$pdf->SetFont('Arial','B',$tamaño_subtitulos); 
		$pdf->SetMargins(5, 5 , 5);
		$pdf->SetAutoPageBreak(true,1);  	  
		$pdf->SetY(5);	
		$pdf->SetX(20);
		$pdf->Image($encabezado[0]['logo'],21,8,35,11); 
		

		/*****************************************/
		/*INICIO Recuadros para el pie del acta */
		/***************************************/
		// Recuadro del logo
		$pdf->Cell(37,20,null,1,0,'C');

		// Recuadro Titulo
		$pdf->SetFont('Arial','B',$tamaño_titulos);
		$pdf->Cell(140,15,'ACTA DE REUNION',1,0,'C');
		//Salto de linea
		$pdf->SetY(20);
		// Celda de margen
		$pdf->Cell(15,20,null,0,0,'C');
		// fila de nombre de la empresa
		$pdf->SetFont('Arial','',$tamaño_letra);
		$pdf->SetTextColor(155, 155, 155);
		$pdf->Cell(37,5,null,0,0,'C');
		$pdf->Cell(90,5,utf8_decode($encabezado[0]['empresa']),1,0,'C');
		$pdf->Cell(50,5,'V.1.2 25-11-2021',1,0,'C');

		/**************************************/
		/*FIN Recuadros para el pie del acta */
		/************************************/


		/************************************************/
		/*INICIO Recuadros para el encabezado del acta */
		/**********************************************/
		$pdf->Ln(25);

		// Celda de margen
		$pdf->Cell(15,20,null,0,0,'C');

		$pdf->SetFont('Arial','B',$tamaño_subtitulos);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->Cell(45,5,'Acta No. :',0,0,'L');
		$pdf->SetFont('Arial','',$tamaño_letra);
		$pdf->Cell(52,5,utf8_decode($encabezado[0]['acta_id']),0,0,'L');


		$pdf->Ln(5);

		// Celda de margen
		$pdf->Cell(15,20,null,0,0,'C');

		$pdf->SetFont('Arial','B',$tamaño_subtitulos);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->Cell(45,5,'Fecha :',0,0,'L');
		$pdf->SetFont('Arial','',$tamaño_letra);
		$pdf->Cell(52,5,utf8_decode($encabezado[0]['fecha_acta']),0,0,'L');
		$pdf->SetFont('Arial','B',$tamaño_subtitulos);
		$pdf->Cell(20,5,'Ciudad :',0,0,'L');
		$pdf->SetFont('Arial','',$tamaño_letra);
		$pdf->Cell(60,5,utf8_decode($encabezado[0]['ubicacion']),0,0,'L');


		$pdf->Ln(5);

		// Celda de margen
		$pdf->Cell(15,20,null,0,0,'C');

		$pdf->SetFont('Arial','B',$tamaño_subtitulos);
		$pdf->Cell(45,5,'Nombre Acta y/o Reunion :',0,0,'L');
		$pdf->SetFont('Arial','',$tamaño_letra);
		$pdf->Cell(132,5,utf8_decode($encabezado[0]['nombre_acta']),0,0,'L');

		$pdf->Ln(5);

		// Celda de margen
		$pdf->Cell(15,20,null,0,0,'C');

		$pdf->SetFont('Arial','B',$tamaño_subtitulos);
		$pdf->Cell(45,5,'Cliente :',0,0,'L');
		$pdf->SetFont('Arial','',$tamaño_letra);
		$pdf->Cell(132,5,utf8_decode($encabezado[0]['cliente']),0,0,'L');

		/*********************************************/
		/*FIN Recuadros para el encabezado del acta */
		/*******************************************/


		/************************************************/
		/*INICIO Recuadro para el objetivo del acta */
		/**********************************************/

		$pdf->Ln(20);

		// Celda de margen
		$pdf->Cell(15,10,null,0,0,'C');

		$pdf->SetFont('Arial','B',$tamaño_subtitulos);
		$pdf->Cell(25,5,utf8_decode('Objetivo Acta y/o Reunión :'),0,0,'J');

		$pdf->Ln(5);
		// Celda de margen
		$pdf->Cell(15,10,null,0,0,'C');
		$pdf->SetFont('Arial','',$tamaño_letra);
		$pdf->Cell(25,5,null,0,0,'C');
		$pdf->Cell(140,5,utf8_decode($encabezado[0]['asunto']),0,0,'L');


		/*********************************************/
		/*FIN Recuadros para el objetivo del acta */
		/*******************************************/

		/************************************************/
		/*INICIO Recuadro para temas tratados del acta */
		/**********************************************/


		$pdf->Ln(20);

		// Celda de margen
		$pdf->Cell(15,5,null,0,0,'C');

		$pdf->SetFont('Arial','B',$tamaño_subtitulos);
		$pdf->Cell(25,5,'TEMAS TRATADOS',0,0,'L');

		$pdf->Ln(5);
		for($i=0; $i < count($temas); $i++){

			$pdf->Ln(5);
			// Celda de margen
			$pdf->Cell(15,5,null,0,0,'C');
			$pdf->SetFont('Arial','B',$tamaño_subtitulos);
			$pdf->Cell(25,5,utf8_decode('-'),0,0,'C');
			$pdf->SetFont('Arial','',$tamaño_letra);
				if (strlen($temas[0]['tema'])<90) {
					$pdf->Cell(152,5,utf8_decode($temas[$i]['tema']),0,90,'J');
				}else {
					$pdf->Cell(152,5,utf8_decode(substr($temas[$i]['tema'],90,90)),0,0,'J');
				}
		

		}


		/*********************************************/
		/*FIN Recuadros para el temas tratados del acta */
		/*******************************************/



		/************************************************/
		/*INICIO Recuadro para acuerdos y compromisos del acta */
		/**********************************************/


		$pdf->Ln(20);

		// Celda de margen
		$pdf->Cell(15,5,null,0,0,'C');

		$pdf->SetFont('Arial','B',$tamaño_subtitulos);
		$pdf->Cell(25,5,'ACUERDOS Y COMPROMISOS',0,0,'L');
		
		$pdf->Ln(5);
		for($i=0; $i < count($acuerdos); $i++){

			$pdf->Ln(5);
			
				if (strlen($acuerdos[$i]['compromiso'])<90) {
					// Celda de margen
					$pdf->Cell(15,5,null,0,0,'C');

					$pdf->SetFont('Arial','B',$tamaño_subtitulos);
					$pdf->Cell(25,5,utf8_decode('-'),0,0,'C');
					$pdf->SetFont('Arial','',$tamaño_letra);
					$pdf->Cell(152,5,utf8_decode(substr($acuerdos[$i]['compromiso'],0,90)),0,90,'J');
				}else {
					$pdf->Ln(5);
					// Celda de margen
					$pdf->Cell(15,5,null,0,0,'C');
					
					$pdf->SetFont('Arial','B',$tamaño_subtitulos);
					$pdf->Cell(25,5,utf8_decode('-'),0,0,'C');
					$pdf->SetFont('Arial','',$tamaño_letra);
					$pdf->Cell(152,5,utf8_decode(substr($acuerdos[$i]['compromiso'],0,90)),0,0,'J');
					
					$pdf->Ln(5);
					// Celda de margen
					$pdf->Cell(15,5,null,0,0,'C');
					
					$pdf->SetFont('Arial','B',$tamaño_subtitulos);
					$pdf->Cell(25,5,null,0,0,'C');
					$pdf->SetFont('Arial','',$tamaño_letra);
					$pdf->Cell(152,5,utf8_decode(substr($acuerdos[$i]['compromiso'],90,90)),0,0,'J');

					
					$pdf->Ln(5);
					// Celda de margen
					$pdf->Cell(15,5,null,0,0,'C');
					
					$pdf->SetFont('Arial','B',$tamaño_subtitulos);
					$pdf->Cell(25,5,null,0,0,'C');
					$pdf->SetFont('Arial','',$tamaño_letra);
					$pdf->Cell(152,5,utf8_decode(substr($acuerdos[$i]['compromiso'],180,90)),0,0,'J');

					$pdf->Ln(5);
					// Celda de margen
					$pdf->Cell(15,5,null,0,0,'C');
					
					$pdf->SetFont('Arial','B',$tamaño_subtitulos);
					$pdf->Cell(25,5,null,0,0,'C');
					$pdf->SetFont('Arial','',$tamaño_letra);
					$pdf->Cell(152,5,utf8_decode(substr($acuerdos[$i]['compromiso'],270,90)),0,0,'J');

					$pdf->Ln(5);
					// Celda de margen
					$pdf->Cell(15,5,null,0,0,'C');
					
					$pdf->SetFont('Arial','B',$tamaño_subtitulos);
					$pdf->Cell(25,5,null,0,0,'C');
					$pdf->SetFont('Arial','',$tamaño_letra);
					$pdf->Cell(152,5,utf8_decode(substr($acuerdos[$i]['compromiso'],360,90)),0,0,'J');

					
					$pdf->Ln(5);
					// Celda de margen
					$pdf->Cell(15,5,null,0,0,'C');
					
					$pdf->SetFont('Arial','B',$tamaño_subtitulos);
					$pdf->Cell(25,5,null,0,0,'C');
					$pdf->SetFont('Arial','',$tamaño_letra);
					$pdf->Cell(152,5,utf8_decode(substr($acuerdos[$i]['compromiso'],450,90)),0,0,'J');


					
					$pdf->Ln(5);
					// Celda de margen
					$pdf->Cell(15,5,null,0,0,'C');
					
					$pdf->SetFont('Arial','B',$tamaño_subtitulos);
					$pdf->Cell(25,5,null,0,0,'C');
					$pdf->SetFont('Arial','',$tamaño_letra);
					$pdf->Cell(152,5,utf8_decode(substr($acuerdos[$i]['compromiso'],540,90)),0,0,'J');
				}
		

		}


		/*********************************************/
		/*FIN Recuadros para acuerdos y compromisos del acta */
		/*******************************************/



		/************************************************/
		/*INICIO Recuadro para participantes del acta */
		/**********************************************/


		$pdf->Ln(15);

		// Celda de margen
		$pdf->Cell(15,5,null,0,0,'C');

		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(177,5,'PARTICIPANTES',1,0,'C');

		$pdf->Ln(5);
		// Celda de margen
		$pdf->Cell(15,5,null,0,0,'C');
		$pdf->Cell(177,5,null,1,0,'C');

		$pdf->Ln(5);

		// Celda de margen
		$pdf->Cell(15,5,null,0,0,'C');

		
		$pdf->Cell(39,5,'No.',1,0,'C');
		$pdf->Cell(88,5,'NOMBRE',1,0,'C');
		$pdf->Cell(50,5,'TIPO PARTICIPANTE',1,0,'C');
		$pdf->SetFont('Arial','',$tamaño_letra);
		for($i=0; $i < count($participantes); $i++){

			$pdf->Ln(5);
			// Celda de margen
			$pdf->Cell(15,5,null,0,0,'C');

			$pdf->Cell(39,5,$i+1,1,0,'C');
			$pdf->Cell(88,5,utf8_decode($participantes[$i]['participante']),1,0,'L');
			$pdf->Cell(50,5,utf8_decode($participantes[$i]['tipo_participante']),1,0,'C');

		}


		/*********************************************/
		/*FIN Recuadros para participantes del acta */
		/*******************************************/


	
	   
		// Nueva linea realizado por

		$pdf->Ln(30);	
		// Celda de margen
		$pdf->Cell(15,5,null,0,0,'C');

		$pdf->SetFont('Arial','I',6);	 	 	 	  
		$pdf->Cell(90,5,utf8_decode('Realizado por : '.$encabezado[0]['empresa'].'.'),0,0,'L');	

		// logo marca agua
		$pdf->Image('../../../framework/media/images/varios/SiandsiMarcaAgua.png',75,90,65,41); 
  	 
	  if ($download=='true') {
		$pdf->Output($nombre_pdf,'F');
	  }else {
		$pdf->Output();
	  }
	  	  
	  
	  
  }
  
  
}
new Imp_Acta($Conex);
?>