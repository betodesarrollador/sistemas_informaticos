<?php
final class Imp_Documento
{
    private $Conex;

    public function __construct()
    {
         
    }
    public function printOut($encabezado_registro=null,$nombre=null,$Conex){   
    {

        require_once "Imp_DocumentoLayoutClass.php";
        require_once "../../../framework/clases/fpdf/fpdf.php";
        require_once "Imp_DocumentoModelClass.php";

        $Layout = new Imp_DocumentoLayout();
        $Model = new Imp_DocumentoModel();

            if($encabezado_registro==null){
		           $encabezado_registro_id = $_REQUEST['encabezado_registro_id'];
            }else{
                    $encabezado_registro_id = $encabezado_registro;
            }

      
        $encabezado = $Model->getEncabezado($encabezado_registro_id, $this->Conex);
        $imputaciones = $Model->getimputaciones($encabezado_registro_id, $this->Conex);
        $total = $Model->getTotal($encabezado_registro_id, $this->Conex);
        $valor_letras = $Model->getTotales($encabezado_registro_id, $this->Conex);

        //********************************************************************//
		//*************** Codigo para generar codigo QR inicio ***************//
		//********************************************************************//
			
		if($encabezado[0]['cufe']!=''){
			if($encabezado[0]['ValIva']== ''){
			  $encabezado[0]['ValIva']=0;
			}

			if($encabezado[0]['ValOtroIm']== ''){
			  $encabezado[0]['ValOtroIm']=0;
			}

			require_once "../../../framework/clases/QRcode/phpqrcode/phpqrcode.php";
			
			//Carpeta para guardar las imagenes
			$dir = "../../../archivos/facturacion/QRfacturas/";
			
			//el nombre de la imagen va a ser el numero de factura
			$filename = $dir . $encabezado[0]['prefijo_doc'].$encabezado[0]['consecutivo'] . '.png';
			//configuracion de la imagen
			$tamaño = 8; //Tamano de Pixel
			$level = 'L'; //Precision Baja
			$framSize = 2; //Tamano en blanco
			
				$contenido = 'NumFac:'.$encabezado[0]['prefijo_doc'].$encabezado[0]['consecutivo']."\r\n".
							 'FecFac:'.$encabezado[0]['fecha']."\r\n".
							 'NitFac:'.$encabezado[0]['numero_identificacion_emp']."\r\n".
							 'DocAdq:'.$encabezado[0]['numero_identificacion']."\r\n".
							 'ValFac:'.$encabezado[0]['valor']."\r\n".
							 'ValIva:'.$encabezado[0]['ValIva']."\r\n".
							 'ValOtroIm:'.$encabezado[0]['ValOtroIm']."\r\n".
							 'ValFacIm:'.$encabezado[0]['valor']."\r\n".
							 'CUFE:'.$encabezado[0]['cufe']."\r\n";
				//Datos que debe llevar el QR
				
				//Creamos objeto de la clase QRCode
				$QRcode = new QRcode();
				//llamammos la funcion para generar la imagen
			$QRcode->png($contenido, $filename, $level, $tama�o, $framSize);
			
			//Asignamos la ruta de la imagen al layout
			$codigoqr= $dir . basename($filename);
		}
		//********************************************************************//
		//*************** Codigo para generar codigo QR final ****************//
		//********************************************************************//

        $pdf = new FPDF();
        $pdf->AddPage('P', 'Letter', 'mm');
        $pdf->SetFont('Arial', 'B', 8);

        $pdf->SetMargins(7, 5, 5);
        $pdf->SetAutoPageBreak(true, 1);

        if($encabezado[0]['cufe']!=''){

            $pdf->SetX(40);
            $pdf->SetY(10);	
            $pdf->Image($encabezado[0]['logo'],2,10,45,17); 
            $pdf->Cell(25,5,null,0,0,'R');		 
            $pdf->Cell(85,5,utf8_decode($encabezado[0]['razon_social_emp']),0,0,'C');	
            $pdf->SetFillColor(0, 0, 128);
            $pdf->SetTextColor(255, 255, 255); 
            $pdf->Cell(40,5,utf8_decode($encabezado[0]['tipo_documento']),1,0,'C',True);	
            $pdf->SetFont('Arial','B',10);	
            $pdf->SetFillColor(220, 220, 220);
            $pdf->SetTextColor(0, 0, 0); 
            $pdf->Cell(15,5,$encabezado[0]['consecutivo'],1,0,'C',true);
            $pdf->Image($codigoqr,180,8,25,25);
            

            $pdf->Ln(4);	
            $pdf->SetFont('Arial','B',10);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetTextColor(0, 0, 0); 	 	 	 	  
            $pdf->Cell(25,5,null,0,0,'R');		 
            $pdf->Cell(85,5,utf8_decode($encabezado[0]['nom_oficina']),0,0,'C');
            
            $pdf->Ln(4);	
            $pdf->SetFont('Arial','B',10);	 	 	 	  
            $pdf->Cell(25,5,null,0,0,'R');		 	 	 
            $pdf->Cell(85,5,$encabezado[0]['tipo_identificacion_emp'].':'.$encabezado[0]['numero_identificacion_emp'],0,0,'C');
            
            $pdf->Ln(8);

	    }else{

            $pdf->SetX(40);
            $pdf->SetY(10);	
            $pdf->Image($encabezado[0]['logo'],8,8,45,11); 
            $pdf->Cell(45,5,null,0,0,'R');	
            $pdf->Cell(85,5,utf8_decode($encabezado[0]['razon_social_emp']),0,0,'C');
            $pdf->SetFillColor(0, 0, 128);
            $pdf->SetTextColor(255, 255, 255); 	
            $pdf->Cell(50,5,utf8_decode($encabezado[0]['tipo_documento']),1,0,'C',True);	
            $pdf->SetFont('Arial','B',10);
            $pdf->SetFillColor(220, 220, 220);
            $pdf->SetTextColor(0, 0, 0); 	 
            $pdf->Cell(20,5,$encabezado[0]['prefijo_doc'].$encabezado[0]['consecutivo'],1,0,'C');		

            $pdf->Ln(4);		  
            $pdf->SetFont('Arial','B',10);	 	 	 	  
            $pdf->Cell(45,5,null,0,0,'R');		 
            $pdf->Cell(85,5,utf8_decode($encabezado[0]['nom_oficina']),0,0,'C');
            
            $pdf->Ln(4);	
            $pdf->SetFont('Arial','B',10);	 	 	 	  
            $pdf->Cell(45,5,null,0,0,'R');		 	 	 
            $pdf->Cell(85,5,$encabezado[0]['tipo_identificacion_emp'].':'.$encabezado[0]['numero_identificacion_emp'],0,0,'C');
        
	    }

        $pdf->Ln(10);	
	  $pdf->SetFont('Arial','B',10);
	  $pdf->SetFillColor(220, 220, 220);
      $pdf->SetTextColor(0, 0, 0);	 	 	 	 	  
	  $pdf->Cell(35,5,'Fecha :',1,0,'L',true);
	  $pdf->SetTextColor(0, 0, 0);	
	  $pdf->Cell(80,5,$encabezado[0]['fecha'],1,0,'L');
	  $pdf->SetFillColor(220, 220, 220);
      $pdf->SetTextColor(0, 0, 0);  	
	  $pdf->Cell(35,5,'Ciudad :',1,0,'L',true);	
	  $pdf->SetTextColor(0, 0, 0);	
	  $pdf->Cell(50,5,$encabezado[0]['ciudad_ofi'],1,0,'L');		 	 	 
	 
	  $pdf->Ln(5);	
	  $pdf->SetFont('Arial','B',10);	
	  $pdf->SetFillColor(220, 220, 220);
      $pdf->SetTextColor(0, 0, 0);	 	 	  
	  $pdf->Cell(35,5,$encabezado[0]['texto_tercero'],1,0,'L',true);	
	  $pdf->Cell(80,5,utf8_decode($encabezado[0]['razon_social'].' '.$encabezado[0]['primer_nombre'].' '.$encabezado[0]['segundo_nombre'].' '.$encabezado[0]['primer_apellido'].' '.$encabezado[0]['segundo_apellido']),1,0,'L');	
	  $pdf->SetFillColor(220, 220, 220);
      $pdf->SetTextColor(0, 0, 0);
	  $pdf->Cell(35,5,$encabezado[0]['tipo_identificacion_emp'],1,0,'L',true);	
	  $pdf->Cell(50,5,$encabezado[0]['numero_identificacion'],1,0,'L');	
	 
	  $pdf->Ln(5);	
	  $pdf->SetFont('Arial','B',10);
	  $pdf->SetFillColor(220, 220, 220);
      $pdf->SetTextColor(0, 0, 0);	 	 	 	  
	  $pdf->Cell(35,5,'Concepto :',1,0,'L',true);	
	  $pdf->Cell(165,5,$encabezado[0]['concepto'],1,0,'L');	

	  $pdf->Ln(5);	
      $pdf->SetFont('Arial','B',10);	 	 	 	  
	  $pdf->SetFillColor(220, 220, 220);
      $pdf->SetTextColor(0, 0, 0);	
	  $pdf->Cell(35,5,'Forma Pago :',1,0,'L',true);	
	  $pdf->Cell(80,5,$encabezado[0]['formapago'],1,0,'L');	
	  $pdf->SetFillColor(220, 220, 220);
      $pdf->SetTextColor(0, 0, 0);
	  $pdf->Cell(35,5,$encabezado[0]['texto_soporte'],1,0,'L',true);	
	  $pdf->Cell(50,5,$encabezado[0]['consecutivo'],1,0,'L');	 
	 
	   $pdf->Ln(10);	
	  $pdf->SetFont('Arial','B',10);
	  $pdf->SetFillColor(0, 0, 128);
      $pdf->SetTextColor(255, 255, 255); 	 	 	 	  
	  $pdf->Cell(20,5,'CODIGO',1,0,'C',true);	
	  $pdf->Cell(20,5,'TERCERO',1,0,'C',true);	
	  $pdf->Cell(10,5,'CC',1,0,'C',true);	
	  $pdf->Cell(94,5,'DETALLE',1,0,'C',true);	
	  $pdf->Cell(28,5,'DEBITO',1,0,'C',true);	
	  $pdf->Cell(28,5,'CREDITO',1,0,'C',true);
	  $pdf->SetTextColor(0, 0, 0); 	
	 	
	  for($i=0; $i < count($imputaciones); $i++){

	   $pdf->Ln(5);	
       $pdf->SetFont('Arial','B',10);	 	 	 	  
	   $pdf->Cell(20,5,$imputaciones[$i]['puc_cod'],1,0,'C');	
//	   $pdf->Cell(40,5,$imputaciones[$i]['numero_identificacion'],1,0,'C');	
	   $pdf->Cell(20,5,$imputaciones[$i]['identificacion_tercero'],1,0,'C');	
//	   $pdf->Cell(15,5,$imputaciones[$i]['codigo_centro_costo'],1,0,'C');		   
	   $pdf->Cell(10,5,$imputaciones[$i]['codigo_cento'],1,0,'C');		   
	   $pdf->Cell(94,5,substr($imputaciones[$i]['descripcion'],0,42),1,0,'C');	
	   $pdf->Cell(28,5,number_format($imputaciones[$i]['debito'],2,',','.'),1,0,'R');	
	   $pdf->Cell(28,5,number_format($imputaciones[$i]['credito'],2,',','.'),1,0,'R');	   
	 
	  }
	 
	  $pdf->Ln(10);	
	  $pdf->SetFont('Arial','B',10);
	  $pdf->SetFillColor(220, 220, 220);
      $pdf->SetTextColor(0, 0, 0); 	 	 	 	  
	  $pdf->Cell(144,5,'SUMAS IGUALES',1,0,'C',true);	
	  $pdf->Cell(28,5,number_format($total[0]['total_debito'],2,',','.'),1,0,'R');	
	  $pdf->Cell(28,5,number_format($total[0]['total_credito'],2,',','.'),1,0,'R');	
	  
	  $pdf->Ln(10);	
	  $pdf->SetFont('Arial','B',10);
	  $pdf->SetFillColor(220, 220, 220);
      $pdf->SetTextColor(0, 0, 0); 	 	 	 	  
	  $pdf->Cell(200,10,'Valor en Letras : '.$Layout -> num2letras($valor_letras[0]['total']).' Pesos M/CTE',1,0,'C',true);	
	  
	  $pdf->Ln(10);	
      $pdf->SetFont('Arial','B',10);	 	 	 	  
  	  $pdf->Cell(40,8,'','LR',0,'C');	
  	  $pdf->Cell(40,8,'','LR',0,'C');		  	  
  	  $pdf->Cell(40,8,'','LR',0,'C');	
  	  $pdf->Cell(40,8,'Recibi','LR',0,'C');	
 	  $pdf->Cell(40,8,'','LR',0,'C');	
	  	  
	  $elaboro = explode(" ",$encabezado[0]['modifica']);
	  
	  $pdf->Ln(5);	
      $pdf->SetFont('Arial','B',10);	 	 	 	  
  	  $pdf->Cell(40,8,$elaboro[0],'LR',0,'C');	
  	  $pdf->Cell(40,8,'','LR',0,'C');		  	  
  	  $pdf->Cell(40,8,'','LR',0,'C');	
  	  $pdf->Cell(40,8,'','LR',0,'C');	
 	  $pdf->Cell(40,8,'','LR',0,'C');		  	  	  
	  
	  $pdf->Ln(5);	
      $pdf->SetFont('Arial','B',10);	 	 	 	  
  	  $pdf->Cell(40,8,$elaboro[1],'LR',0,'C');	
  	  $pdf->Cell(40,8,'','LR',0,'C');		  	  
  	  $pdf->Cell(40,8,'','LR',0,'C');	
  	  $pdf->Cell(40,8,'','LR',0,'C');	
 	  $pdf->Cell(40,8,'','LR',0,'C');	
	  	  
	  $pdf->Ln(5);	
      $pdf->SetFont('Arial','B',10);	 	 	 	  
  	  $pdf->Cell(40,8,$elaboro[2],'LR',0,'C');	
  	  $pdf->Cell(40,8,'','LR',0,'C');		  	  
  	  $pdf->Cell(40,8,'','LR',0,'C');	
  	  $pdf->Cell(40,8,'','LR',0,'C');	
 	  $pdf->Cell(40,8,'','LR',0,'C');	 
	  
	  $pdf->Ln(5);	
      $pdf->SetFont('Arial','B',10);	 	 	 	  
  	  $pdf->Cell(40,8,'Elaboro','LRB',0,'C');	
  	  $pdf->Cell(40,8,'Reviso','LRB',0,'C');		  	  
  	  $pdf->Cell(40,8,'Aprobo','LRB',0,'C');	
  	  $pdf->Cell(40,8,'C.C / NIT','LRB',0,'C');	
	  $pdf->Cell(40,8,'Huella','LRB',0,'C');

        if($encabezado[0]['cufe']!=''){
	  		$pdf->Ln(8);
			$pdf->SetFont('Arial','B',9);
			$pdf->SetFillColor(220, 220, 220);
            $pdf->SetTextColor(0, 0, 0); 	
			$pdf->Cell(200,8,'Cufe: '.$encabezado[0]['cufe'],1,0,'C',true);
	  
	  }

        	   /* Nueva linea para mostrar modulo de procedencia */

		 $pdf->Ln(8);	
		 $pdf->SetFont('Arial','I',8);	 	 	 	  
		   $pdf->Cell(200,8,'Modulo de procedencia : FACTURACION','',0,'C');		   	  	  	  

            if($nombre == null){
		        $pdf->Output();
            }else{
                $ruta="../../../archivos/facturacion/notas/".$nombre.".pdf";
                $pdf->Output($ruta);  
            }

    }

}
new Imp_Documento();
