<?php

final class Imp_FacturaPDF{

	private $Conex;

	public function __construct(){    
		 
	}

	public function printOut($Conex){

		$this -> Conex = $Conex; 

		require_once("Imp_FacturaPDFLayoutClass.php");
		require_once("../../../framework/clases/fpdf/fpdf.php");		 
		require_once("Imp_FacturaPDFModelClass.php");
		
		$Layout = new Imp_FacturaPDFLayout();
		$Model  = new Imp_FacturaPDFModel();	


		$rango_desde = $_REQUEST['rango_desde'];
		$rango_hasta = $_REQUEST['rango_hasta'];	
		$factura_id  = $_REQUEST['factura_id'];	

		$facturas = $Model -> getFacturas($rango_desde,$rango_hasta,$factura_id,$this -> Conex);	
		$pdf=new FPDF();

		for($c=0;$c<count($facturas);$c++){

			$cont_hojas = 1;



			$factura_id = $facturas[$c]['factura_id'];

			$encabezado   = $Model -> getEncabezado($factura_id,$this -> Conex);	  
			$imputaciones = $Model -> getitemFactura($factura_id,$this -> Conex);  
			$item_puc     = $Model -> get_pucFactura($factura_id,$this -> Conex);  
			$valor_letras = $Model -> getTotales($factura_id,$this -> Conex);
			$valor_letras = $Layout -> num2letras($valor_letras[0]['total']);


			$pdf->AddPage('P','Letter','mm');
			$pdf->SetFont('Arial','B',8); 

			$pdf->SetMargins(7, 5 , 5);
			$pdf->SetAutoPageBreak(true,1);  	



			$pdf->SetX(2);	
			$pdf->Image($encabezado[0]['logo'],8,4,49,19); 
		  //$pdf->Cell(1,5,null,0,0,'R');	
			$pdf->SetX(2);
			$pdf->SetY(5);
			$pdf->SetFont('Arial','B',10); 
			$pdf->Cell(68,5,null,0,0,'R');
			$pdf->Cell(65,5,$encabezado[0]['nombre_oficina'],0,0,'C');	
			$pdf->SetFont('Arial','B',12);	 
			$pdf->Cell(38,5,null,0,0,'R');
			$pdf->Cell(42,5,"INVOICE",0,0,'C');	


			$pdf->Ln(3);	
			$pdf->SetX(6);
			$pdf->SetFont('Arial','B',8);	 	 	 	  
			$pdf->Cell(80,5,null,0,0,'R');
			$pdf->Cell(36,5,$encabezado[0]['tipo_identificacion_emp'].' - '.$encabezado[0]['numero_identificacion_emp'],0,0,'C');
			/*$pdf->Ln(3);
			$pdf->Cell(80,5,null,0,0,'R');
			$pdf->Cell(36,5,'Regimen Comun - ACTIVIDAD ECONOMICA DESARROLLO DE SOFTWARE',0,0,'C');*/
			$pdf->Ln(3);
			$pdf->Cell(80,5,null,0,0,'R');
			$pdf->Cell(36,5,'Res Facturacion DIAN '.$encabezado[0]['resolucion_dian'],0,0,'C');
			$pdf->Ln(3);
			$pdf->Cell(80,5,null,0,0,'R');
			$pdf->Cell(36,5,' del '.$encabezado[0]['fecha_resolucion_dian'].' '.$encabezado[0]['rangos_factura'],0,0,'C');
			$pdf->Ln(6);
			$pdf->SetFont('Arial','',8);	
			$pdf->Cell(160,5,null,0,0,'R');
			$pdf->Cell(20,5,"Date",1,0,'C');	
			$pdf->Cell(20,5,"Invoice #",1,0,'C');	

			$pdf->Ln(5);
			$pdf->Cell(160,5,null,0,0,'R');
			$pdf->SetFont('Arial','',8);	 
			$pdf->Cell(20,6,$encabezado[0]['fecha'],1,0,'C');	
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(20,6,$encabezado[0]['prefijo'].'  '.$encabezado[0]['consecutivo_factura'],1,0,'C');	

			$pdf->SetX(20);
			$pdf->SetY(24);
		 // $pdf->Cell(10,5,null,0,0,'R');
			$pdf->SetFont('Arial','',8);	 
			$pdf->Cell(20,6,'Phone ',1,0,'C');	
			$pdf->Cell(20,6,$encabezado[0]['tel_oficina'],1,0,'C');	

			$pdf->Ln(6);
		  //$pdf->Cell(10,5,null,0,0,'R');
			$pdf->SetFont('Arial','',8);	 
			$pdf->Cell(20,6,'E-mail ',1,0,'C');	
			$pdf->Cell(62,6,$encabezado[0]['email'],1,0,'C');	
			
		  /* $pdf->Ln(4);	
		  $pdf->SetFont('Arial','B',8);	 	 	 	  
		  $pdf->Cell(45,5,null,0,0,'R');		 	 	 
		  $pdf->Cell(85,5,'CODIGO POSTAL 0380',0,0,'C');
		  $pdf->SetFont('Arial','',8);	 	
		  $pdf->Cell(15,5,null,0,0,'R');
		  $pdf->Cell(45,5,"Rango autorizado ".$encabezado[0]['rango'],0,0,'C');	*/

		 //recuadro que encierra todo el encabezado
		  $pdf->SetX(40);
		  $pdf->SetY(40);
		  $pdf->SetFont('Arial','B',10);	 	 	 	  
		  $pdf->Cell(80,30,null,1,0,'L');
		  $pdf->SetX(40);
		  $pdf->SetY(40);
		  $pdf->Cell(80,6,'  Bill To ',1,0,'L');
		  
		  $pdf->SetX(40);
		  $pdf->SetY(46);
		  $pdf->SetFont('Arial','',8);
		  $pdf->Cell(80,6,$encabezado[0]['nom_cliente'],0,0,'L');
		  
		  $pdf->SetX(40);
		  $pdf->SetY(49);
		  $pdf->SetFont('Arial','',8);
		  $pdf->Cell(80,6,$encabezado[0]['dir_cliente'],0,0,'L');
		  
		  $pdf->SetX(40);
		  $pdf->SetY(52);
		  $pdf->SetFont('Arial','',8);
		  $pdf->Cell(80,6,$encabezado[0]['ubicacion_cliente'],0,0,'L');

		  $pdf->SetX(40);
		  $pdf->SetY(55);
		  $pdf->SetFont('Arial','',8);
		  $pdf->Cell(80,6,$encabezado[0]['telefono_cliente'],0,0,'L');

		  $pdf->SetX(40);
		  $pdf->SetY(58);
		  $pdf->SetFont('Arial','',8);
		  $pdf->Cell(80,6,$encabezado[0]['apartado_cliente'],0,0,'L');
		  
		  $pdf->SetX(40);
		  $pdf->SetY(36);
		  $pdf->Cell(120,30,null,0,0,'L');
		  $pdf->Cell(80,34,null,1,0,'C');
		  
		  $pdf->SetX(40);
		  $pdf->SetY(36);
		  $pdf->SetFont('Arial','B',10);
		  $pdf->Cell(120,30,null,0,0,'L');
		  $pdf->Cell(80,6,'  Ship To ',1,0,'L');
		  

		  $pdf->SetY(42);
		  $pdf->SetFont('Arial','',8);
		  $pdf->Cell(120,30,null,0,0,'L');
		  $pdf->Cell(80,6,$encabezado[0]['nom_cliente'],0,0,'L');
		  

		  $pdf->SetY(45);
		  $pdf->SetFont('Arial','',8);
		  $pdf->Cell(120,30,null,0,0,'L');
		  $pdf->Cell(80,6,$encabezado[0]['dir_cliente'],0,0,'L');
		  

		  $pdf->SetY(48);
		  $pdf->SetFont('Arial','',8);
		  $pdf->Cell(120,30,null,0,0,'L');
		  $pdf->Cell(80,6,$encabezado[0]['ubicacion_cliente'],0,0,'L');

		  $pdf->SetY(51);
		  $pdf->SetFont('Arial','',8);
		  $pdf->Cell(120,30,null,0,0,'L');
		  $pdf->Cell(80,6,$encabezado[0]['telefono_cliente'],0,0,'L');

		  $pdf->SetY(54);
		  $pdf->SetFont('Arial','',8);
		  $pdf->Cell(120,30,null,0,0,'L');
		  $pdf->Cell(80,6,$encabezado[0]['apartado_cliente'],0,0,'L');
		  
		  $pdf->Ln(39);
		  $pdf->SetFont('Arial','B',10);	 	 	 	  
		  //$pdf->Cell(200,14,null,1,0,'L');
		  
		  /*$pdf->SetX(10);
		  $pdf->SetY(73);
		  $pdf->SetFont('Arial','B',10);
		  //$pdf->Cell(120,30,null,1,0,'L');
		  $pdf->Cell(29,5,'   P.O. Number',1,0,'L');
		  $pdf->Cell(29,5,'       Terms ',1,0,'L');
		  $pdf->Cell(24,5,'      Rep ',1,0,'L');
		  $pdf->Cell(29,5,'        Ship  ',1,0,'L');
		  $pdf->Cell(29,5,'         Via ',1,0,'L');
		  $pdf->Cell(30,5,'      F.O.B. ',1,0,'L');
		  $pdf->Cell(30,5,'      Project ',1,0,'L');
		  
		  $pdf->SetX(10);
		  $pdf->SetY(78);
		  $pdf->SetFont('Arial','',10);
		  //$pdf->Cell(120,30,null,1,0,'L');
		  $pdf->Cell(29,9,' # '.$encabezado[0]['os_rel'],1,0,'L');
		  $pdf->Cell(29,9,'    '.$encabezado[0]['vencimiento'],1,0,'L');
		  $pdf->Cell(24,9,'       WC ',1,0,'L');
		  $pdf->Cell(29,9,'    '.$encabezado[0]['radicacion'],1,0,'L');
		  $pdf->Cell(29,9,'',1,0,'L');
		  $pdf->Cell(30,9,'',1,0,'L');
		  $pdf->Cell(30,9,'',1,0,'L');*/

		   //cuerpo de la factura
		   //titulos
		  //$pdf->Ln(9);

		  $pdf->SetX(40);
		  $pdf->SetY(92);
		  $pdf->SetFillColor(208, 208, 208);
		  $pdf->Cell(15,130,null,1,0,'L');
		  $pdf->Cell(15,130,null,1,0,'L');
		  $pdf->Cell(30,130,null,1,0,'L');
		  $pdf->Cell(77,130,null,1,0,'L');
		  $pdf->Cell(10,130,null,1,0,'L');
		  $pdf->Cell(26,130,null,1,0,'L');
		  $pdf->Cell(27,130,null,1,0,'L');

		  $pdf->SetY(87);
		  $pdf->SetX(7);
		  $pdf->SetFont('Arial','B',10);	 	 	 	  
		  $pdf->SetFillColor(208, 208, 208);
		  $pdf->Cell(15,5,'Quantity',1,0,'C','true');
		  $pdf->Cell(15,5,'Weight',1,0,'C','true');	
		  $pdf->Cell(30,5,'Item Code ',1,0,'C','true');
		  $pdf->Cell(77,5,'Description',1,0,'C','true');		
		  $pdf->Cell(10,5,'U/M',1,0,'C','true');	
		  $pdf->Cell(26,5,'Price Each',1,0,'C','true');	
		  $pdf->Cell(27,5,'Amount',1,0,'C','true');	

		  
		  
		  //detalles
		  
		  for($i=0; $i < count($imputaciones); $i++){

		  	if($i%2==0){
		  		$pdf->SetFillColor(255, 255, 255);
		  	}else{
		  		$pdf->SetFillColor(240, 240, 240);

		  	}

		  	$pdf->Ln(5);	
		  	$pdf->SetFont('Arial','',8);	 	 	 	  
		  	$pdf->Cell(15,4,$imputaciones[$i]['cantidades'],0,0,'C','true');	
		  	$pdf->Cell(15,4,$imputaciones[$i]['peso'],0,0,'C','true');	
		  	$pdf->Cell(30,4,$imputaciones[$i]['codigo_producto'],0,0,'C','true');
		   //if(strlen($imputaciones[$i]['descripcion'])<80){
		   	if(strlen($imputaciones[$i]['descripcion'])>44){
		  		$pdf->Cell(77,4,utf8_decode(substr($imputaciones[$i]['descripcion'],0,43)),0,0,'L','true');
		  		$pdf->Cell(63,4,null,0,0,'C','true');
		   		$pdf->Ln(4);
		  		$pdf->Cell(60,4,null,0,0,'C','true');
		  		$pdf->Cell(77,4,utf8_decode(substr($imputaciones[$i]['descripcion'],43,43)),0,0,'L','true');
		  	}elseif(strlen($imputaciones[$i]['pesos_producto'])>1){
		  		$pdf->Cell(77,4,utf8_decode(substr($imputaciones[$i]['descripcion'],0,43)),0,0,'L','true');
		  		$pdf->Cell(63,4,null,0,0,'C','true');
		  	}else{
		  		$pdf->Cell(77,4,utf8_decode(substr($imputaciones[$i]['descripcion'],0,43)),0,0,'L','true');
		  	}

		  	if(strlen($imputaciones[$i]['pesos_producto'])>1){

		  		$cant_reng = strlen(str_replace(' ', ' - ', $imputaciones[$i]['pesos_producto'])) / 56 ;
				$posFin = 0;
				$posIni = 0;

		  		for($k=0;$k<$cant_reng;$k++){

					//$posFin = $k*56 > 0 ? $k*56 : 56;										
		  			$pdf->Ln(4);
			  		$pdf->Cell(60,4,null,0,0,'C','true');
			  		$pdf->Cell(77,4,utf8_decode(substr(str_replace(' ', ' - ', $imputaciones[$i]['pesos_producto']),$posIni,56)),0,0,'C','true');
					$posIni = $posIni+56;
							  			
		  		}

		  		/*if(strlen($imputaciones[$i]['pesos_producto'])>56){
			  		
			  		$pdf->Ln(4);
			  		$pdf->Cell(60,4,null,0,0,'C');
			  		$pdf->Cell(77,4,utf8_decode(substr($imputaciones[$i]['pesos_producto'],56,56)),0,0,'C','true');
			  	}else{
			  		$pdf->Ln(4);
			  		$pdf->Cell(60,4,null,0,0,'C');
			  		$pdf->Cell(77,4,utf8_decode(substr($imputaciones[$i]['pesos_producto'],0,56)),0,0,'C','true');
			  	}*/
		  	}

			/*}else{
				$posY = $pdf->GetY();
				$posX = $pdf->GetX();
				$pdf->MultiCell(77,5,utf8_decode($imputaciones[$i]['descripcion']."\n"),0,0,'C','true');
				$pdf->SetX(7);
				$pdf->Cell(200,0,'',1,0,'C','true');
			}*/
				/*$pdf->SetY($posY);
				$pdf->SetX(145);*/
				$pdf->Cell(10,4,'',0,0,'C','true');
				$pdf->Cell(26,4,number_format($imputaciones[$i]['valor_unitario'],2,',','.'),0,0,'C','true');
				$pdf->Cell(27,4,number_format($imputaciones[$i]['valor'],2,',','.'),0,0,'C','true');		   

				$posY = $pdf->GetY();

				if($posY>214){


					$pdf->SetX(80);
					$pdf->SetY(217);

					$pdf->Ln(5);
					$pdf->SetX(7);	
					$pdf->SetFont('Arial','B',10);	 	 	 	  
					$pdf->Cell(200,5,'CONTINUE',1,0,'R');	
					
					$pdf->SetFont('Arial','',8);
					$pdf->Ln(10);
					$pdf->Cell(200,15,null,0,0,'C');
					$pdf->SetX(10);
					$pdf->Cell(100,5,"_______________________",0,0,'C');
					$pdf->Cell(100,5,"_______________________",0,0,'C');
					$pdf->Ln(5);
					$pdf->Cell(100,5,"ELABORA",0,0,'C');
					$pdf->Cell(100,5,"FIRMA Y SELLO C.C / NIT. DEL COMPRADOR",0,0,'C');

					$pdf->Ln(5);
					$pdf->Cell(200,10,null,1,0,'C');
					$pdf->SetX(8);
					$pdf->Cell(200,5,substr($encabezado[0]['observacion_uno'],0,120),0,0,'C');
					$pdf->Ln(5);
					$pdf->Cell(200,5,substr($encabezado[0]['observacion_uno'],120,280),0,0,'C');
					

					$pdf->SetFont('Arial','',8);	
					$pdf->Ln(5);
					$pdf->Cell(200,5,substr($encabezado[0]['observacion_dos'],0,122),0,0,'C');
					$pdf->Ln(5);
					$pdf->Cell(200,5,substr($encabezado[0]['observacion_dos'],123,121),0,0,'C');
					$pdf->Ln(5);
					$pdf->Cell(200,5,substr($encabezado[0]['observacion_dos'],244,300),0,0,'C');
					$pdf->Ln(3);
					$pdf->Cell(200,5,'PAGINA '.$cont_hojas,0,0,'C');
					$cont_hojas=$cont_hojas+1;



					$pdf->AddPage('P','Letter','mm');
					$pdf->SetFont('Arial','B',8); 

					$pdf->SetMargins(7, 5 , 5);
					$pdf->SetAutoPageBreak(true,1);  	



					$pdf->SetX(2);	
			//$pdf->Image($encabezado[0]['logo'],8,4,49,19); 
		  //$pdf->Cell(1,5,null,0,0,'R');	
					$pdf->SetX(2);
					$pdf->SetY(5);
					$pdf->SetFont('Arial','B',10); 
					$pdf->Cell(68,5,null,0,0,'R');
					$pdf->Cell(65,5,$encabezado[0]['nom_oficina'],0,0,'C');	
					$pdf->SetFont('Arial','B',12);	 
					$pdf->Cell(38,5,null,0,0,'R');
					$pdf->Cell(42,5,"INVOICE",0,0,'C');	


					$pdf->Ln(3);	
					$pdf->SetX(6);
					$pdf->SetFont('Arial','B',8);	 	 	 	  
					$pdf->Cell(80,5,null,0,0,'R');
					$pdf->Cell(36,5,$encabezado[0]['dir_oficna'],0,0,'C');
					$pdf->Ln(3);
					$pdf->Cell(80,5,null,0,0,'R');
					$pdf->Cell(36,5,$encabezado[0]['ubicacion_id'],0,0,'C');
					$pdf->Ln(6);
					$pdf->SetFont('Arial','',8);	
					$pdf->Cell(160,5,null,0,0,'R');
					$pdf->Cell(20,5,"Date",1,0,'C');	
					$pdf->Cell(20,5,"Invoice #",1,0,'C');	

					$pdf->Ln(5);
					$pdf->Cell(160,5,null,0,0,'R');
					$pdf->SetFont('Arial','',8);	 
					$pdf->Cell(20,6,$encabezado[0]['fecha'],1,0,'C');	
					$pdf->Cell(20,6,$encabezado[0]['prefijo'].' - '.$encabezado[0]['consecutivo_factura'],1,0,'C');	

					$pdf->SetX(20);
					$pdf->SetY(24);
		 // $pdf->Cell(10,5,null,0,0,'R');
					$pdf->SetFont('Arial','',8);	 
					$pdf->Cell(20,6,'Phone ',1,0,'C');	
					$pdf->Cell(20,6,$encabezado[0]['tel_oficina'],1,0,'C');	

					$pdf->Ln(6);
		  //$pdf->Cell(10,5,null,0,0,'R');
					$pdf->SetFont('Arial','',8);	 
					$pdf->Cell(20,6,'E-mail ',1,0,'C');	
					$pdf->Cell(55,6,$encabezado[0]['email'],1,0,'C');	

		  /* $pdf->Ln(4);	
		  $pdf->SetFont('Arial','B',8);	 	 	 	  
		  $pdf->Cell(45,5,null,0,0,'R');		 	 	 
		  $pdf->Cell(85,5,'CODIGO POSTAL 0380',0,0,'C');
		  $pdf->SetFont('Arial','',8);	 	
		  $pdf->Cell(15,5,null,0,0,'R');
		  $pdf->Cell(45,5,"Rango autorizado ".$encabezado[0]['rango'],0,0,'C');	*/

		 //recuadro que encierra todo el encabezado
		  $pdf->SetX(40);
		  $pdf->SetY(40);
		  $pdf->SetFont('Arial','B',10);	 	 	 	  
		  $pdf->Cell(80,30,null,1,0,'L');
		  $pdf->SetX(40);
		  $pdf->SetY(40);
		  $pdf->Cell(80,6,'  Bill To ',1,0,'L');
		  
		  $pdf->SetX(40);
		  $pdf->SetY(46);
		  $pdf->SetFont('Arial','',8);
		  $pdf->Cell(80,6,$encabezado[0]['nom_cliente'],0,0,'L');
		  
		  $pdf->SetX(40);
		  $pdf->SetY(49);
		  $pdf->SetFont('Arial','',8);
		  $pdf->Cell(80,6,$encabezado[0]['dir_cliente'],0,0,'L');
		  
		  $pdf->SetX(40);
		  $pdf->SetY(52);
		  $pdf->SetFont('Arial','',8);
		  $pdf->Cell(80,6,$encabezado[0]['ubicacion_cliente'],0,0,'L');

		  $pdf->SetX(40);
		  $pdf->SetY(55);
		  $pdf->SetFont('Arial','',8);
		  $pdf->Cell(80,6,$encabezado[0]['telefono_cliente'],0,0,'L');

		  $pdf->SetX(40);
		  $pdf->SetY(58);
		  $pdf->SetFont('Arial','',8);
		  $pdf->Cell(80,6,$encabezado[0]['apartado_cliente'],0,0,'L');
		  
		  $pdf->SetX(40);
		  $pdf->SetY(36);
		  $pdf->Cell(120,30,null,0,0,'L');
		  $pdf->Cell(80,34,null,1,0,'C');
		  
		  $pdf->SetX(40);
		  $pdf->SetY(36);
		  $pdf->SetFont('Arial','B',10);
		  $pdf->Cell(120,30,null,0,0,'L');
		  $pdf->Cell(80,6,'  Ship To ',1,0,'L');
		  

		  $pdf->SetY(42);
		  $pdf->SetFont('Arial','',8);
		  $pdf->Cell(120,30,null,0,0,'L');
		  $pdf->Cell(80,6,$encabezado[0]['nom_cliente'],0,0,'L');
		  

		  $pdf->SetY(45);
		  $pdf->SetFont('Arial','',8);
		  $pdf->Cell(120,30,null,0,0,'L');
		  $pdf->Cell(80,6,$encabezado[0]['dir_cliente'],0,0,'L');
		  

		  $pdf->SetY(48);
		  $pdf->SetFont('Arial','',8);
		  $pdf->Cell(120,30,null,0,0,'L');
		  $pdf->Cell(80,6,$encabezado[0]['ubicacion_cliente'],0,0,'L');

		  $pdf->SetY(51);
		  $pdf->SetFont('Arial','',8);
		  $pdf->Cell(120,30,null,0,0,'L');
		  $pdf->Cell(80,6,$encabezado[0]['telefono_cliente'],0,0,'L');

		  $pdf->SetY(54);
		  $pdf->SetFont('Arial','',8);
		  $pdf->Cell(120,30,null,0,0,'L');
		  $pdf->Cell(80,6,$encabezado[0]['apartado_cliente'],0,0,'L');
		  
		  $pdf->Ln(39);
		  $pdf->SetFont('Arial','B',10);	 	 	 	  
		  //$pdf->Cell(200,14,null,1,0,'L');
		  
		  $pdf->SetX(10);
		  $pdf->SetY(73);
		  $pdf->SetFont('Arial','B',10);
		  //$pdf->Cell(120,30,null,1,0,'L');
		  $pdf->Cell(29,5,'   P.O. Number',1,0,'L');
		  $pdf->Cell(29,5,'       Terms ',1,0,'L');
		  $pdf->Cell(24,5,'      Rep ',1,0,'L');
		  $pdf->Cell(29,5,'        Ship  ',1,0,'L');
		  $pdf->Cell(29,5,'         Via ',1,0,'L');
		  $pdf->Cell(30,5,'      F.O.B. ',1,0,'L');
		  $pdf->Cell(30,5,'      Project ',1,0,'L');
		  
		  $pdf->SetX(10);
		  $pdf->SetY(78);
		  $pdf->SetFont('Arial','',10);
		  //$pdf->Cell(120,30,null,1,0,'L');
		  $pdf->Cell(29,9,' # '.$encabezado[0]['os_rel'],1,0,'L');
		  $pdf->Cell(29,9,'    '.$encabezado[0]['vencimiento'],1,0,'L');
		  $pdf->Cell(24,9,'       WC ',1,0,'L');
		  $pdf->Cell(29,9,'    '.$encabezado[0]['radicacion'],1,0,'L');
		  $pdf->Cell(29,9,'',1,0,'L');
		  $pdf->Cell(30,9,'',1,0,'L');
		  $pdf->Cell(30,9,'',1,0,'L');

		   //cuerpo de la factura
		   //titulos
		  //$pdf->Ln(9);

		  $pdf->SetX(40);
		  $pdf->SetY(92);
		  $pdf->SetFillColor(208, 208, 208);
		  $pdf->Cell(15,130,null,1,0,'L');
		  $pdf->Cell(15,130,null,1,0,'L');
		  $pdf->Cell(30,130,null,1,0,'L');
		  $pdf->Cell(77,130,null,1,0,'L');
		  $pdf->Cell(10,130,null,1,0,'L');
		  $pdf->Cell(26,130,null,1,0,'L');
		  $pdf->Cell(27,130,null,1,0,'L');

		  $pdf->SetY(87);
		  $pdf->SetX(7);
		  $pdf->SetFont('Arial','B',10);	 	 	 	  
		  $pdf->SetFillColor(208, 208, 208);
		  $pdf->Cell(15,5,'Quantity',1,0,'C','true');
		  $pdf->Cell(15,5,'Weight',1,0,'C','true');	
		  $pdf->Cell(30,5,'Item Code ',1,0,'C','true');
		  $pdf->Cell(77,5,'Description',1,0,'C','true');		
		  $pdf->Cell(10,5,'U/M',1,0,'C','true');	
		  $pdf->Cell(26,5,'Price Each',1,0,'C','true');	
		  $pdf->Cell(27,5,'Amount',1,0,'C','true');	
		}

	}	  



		 /* $pdf->SetX(40);
		  $pdf->SetY(220);
		  $pdf->SetFont('Arial','B',11);	
		  if(strlen($valor_letras)<40){
			 $pdf->Cell(120,10,'Valor en Letras : '.$valor_letras.' Pesos M/CTE',0,0,'L');	
		  }elseif(strlen($valor_letras)>=40 && strlen($valor_letras)<90){
			  $pdf->Cell(120,10,'Valor en Letras : '.substr($valor_letras,0,40),0,0,'R');
			  $pdf->Ln(5);		
			  $pdf->Cell(120,10,substr($valor_letras,40,120).' Pesos M/CTE',0,0,'R');	
			}*/
		   //recuadros que integran todos los detalles
			
			$pdf->SetX(80);
			$pdf->SetY(217);

			for($i=0; $i < count($item_puc); $i++){
				$pdf->Ln(5);
				$pdf->SetX(7);	
				$pdf->SetFont('Arial','B',10);	 	 	 	  
				$pdf->Cell(172,5,$item_puc[$i]['tipo_texto'],1,0,'R');	
				$pdf->SetFont('Arial','',10);
				$pdf->Cell(28,5,number_format($item_puc[$i]['valor'],2,',','.'),1,0,'R');	

			}
			$pdf->SetFont('Arial','I',8);
			$pdf->Ln(10);
			$pdf->Cell(200,15,null,0,0,'C');
			$pdf->SetX(10);
			//$pdf->Image('/application/framework/media/images/general/firma.jpg',8,4,49,19); 
			//$pdf->Image('http://162.241.155.145/ulc/framework/media/images/general/firma_pdf.jpg',45,230,30,24,'JPG');
			$pdf->Cell(100,5,"_______________________",0,0,'C');
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(100,5,"_______________________",0,0,'C');
			$pdf->Ln(5);
			$pdf->Cell(100,5,"ELABORA",0,0,'C');
			$pdf->Cell(100,5,"FIRMA Y SELLO C.C / NIT. DEL COMPRADOR",0,0,'C');

			$pdf->Ln(7);
			$pdf->Cell(200,14,null,1,0,'C');
			$pdf->SetX(8);
			$pdf->Cell(200,5,substr($encabezado[0]['observacion_uno'],0,118),0,0,'C');
			$pdf->Ln(5);
			$pdf->Cell(200,5,substr($encabezado[0]['observacion_uno'],118,122),0,0,'C');
			$pdf->Ln(5);
			$pdf->Cell(200,5,substr($encabezado[0]['observacion_uno'],242,280),0,0,'C');

			$pdf->SetFont('Arial','',8);	
			$pdf->Ln(4);
			$pdf->Cell(200,5,substr($encabezado[0]['observacion_dos'],0,122),0,0,'C');
			$pdf->Ln(5);
			$pdf->Cell(200,5,substr($encabezado[0]['observacion_dos'],123,121),0,0,'C');
			$pdf->Ln(0.1);
			$pdf->Cell(200,5,'PAGINA '.$cont_hojas,0,0,'C');
			//$cont_hojas=$cont_hojas+1;






		}



		$pdf->Output();	  


	}


}
new Imp_FacturaPDF();

?>