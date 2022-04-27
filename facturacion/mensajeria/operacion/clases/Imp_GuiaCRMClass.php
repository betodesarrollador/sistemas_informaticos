<?php

final class Imp_GuiaCRM{

  private $Conex;
  
  public function __construct($Conex){  
    $this -> Conex = $Conex;  
  }

  public function printOut($usuario,$empresa_id,$oficina_id,$nit_empresa){
      	
      //require_once("Imp_GuiaCRMLayoutClass.php");
      require_once("Imp_GuiaCRMModelClass.php");
      require_once("../../../framework/clases/fpdf/fpdf.php");	  	  
      require_once("../../../framework/clases/barcode.php");	  
		
      //$Layout  = new Imp_GuiaCRMLayout();
	  
		  
      $Model   = new Imp_GuiaCRMModel();		
	  $barcode = new barcode();		
	  $guia = $Model -> getGuia($oficina_id,$empresa_id,$this -> Conex);	
	
	  if(!count($guia)>0){
		  exit('Los filtros utilizados no arrojan ninguna Guia a imprimir <br> Por favor verifique');
		  
	  }
	  for($i = 0; $i < count($guia); $i++){	  
	    foreach($guia[$i] as $llave => $valor){		
		  if($llave == 'numero_guia_codigo'){ //echo $valor;
	         $barcode -> setParams("$valor"); 
			 $guia[$i]['codbar'] = $barcode -> getUrlImageCodBar();
		   }	    		
	    }		
	 }	
	
//      $Layout -> setGuia($guia,$usuario);	
  //    $Layout -> setOficinas($Model -> getOficinas($empresa_id,$this -> Conex));	            
      
      //$Layout -> RenderMain();
		if ($_REQUEST['formato']=='SI'){
			$pdf=new FPDF(); // Crea un objeto de la clase fpdf()
			$pdf->AddPage('P','Letter','mm'); // Agrega una hoja al documento.
			$pdf->SetFont('Arial','B',10); //Establece la fuente a utilizar, el formato Negrita y el tama�o
		
			#Establecemos los m�rgenes izquierda, arriba y derecha:
			$pdf->SetMargins(10, 5 , 5);
		
			#Establecemos el margen inferior:
			$pdf->SetAutoPageBreak(true,1);  
		
			$array = array(0 => 'PRUEBA ENTREGA',1 => 'DESTINATARIO', 2 => 'REMITENTE', 3 => 'ARCHIVO');
			// print_r($array);

			for($i = 0; $i < count($guia); $i++){	
			 if($i > 0) $pdf->AddPage('P','Letter','mm');

			 $logo       = $guia[$i]['logo'];
			 $super      = "../media/images/forms/super.jpg";
			 $codBar     = $guia[$i]['codbar'];

			 	$sumaY = 0;
			 for($j = 0; $j < 4; $j++){

				// Copia 1
				$pdf->SetX(40);
				$pdf->SetY(10+$sumaY);	
				$pdf->Image($logo,10,(8+$sumaY),41,11); 
				$pdf->Image($super,140,(8+$sumaY),21,9); 
				$pdf->Image($codBar,165,(8+$sumaY),40,7);  	 
				$pdf->Cell(40,3,null,0,0,'R');		 	 
				$pdf->SetFont('Arial','B',6);	 
				$pdf->Cell(89,3,utf8_decode('Ppal. Carrera 6 No 21-34 B/el Carmen. Ibagué NIT. '.$nit_empresa.' Web: '.strtolower($guia[$i]['pagina_web']).''),0,0,'R');		 
				
				$pdf->SetFont('Arial','B',8);		 	 
				//$pdf->Cell(25,3,$guia[$i]['fecha_guia'],0,0,'C');		 	 
				$pdf->Ln(3);	 
				$pdf->SetFont('Arial','B',6);	
				//$pdf->Cell(115,3,'Formulario DIAN '.$guia[$i]['resolucion_dian'].' de '.$guia[$i]['fecha_dian'].' Prefijo '.$guia[$i]['prefijo'].':  '.$guia[$i]['rango_dian_ini'].' al '.$guia[$i]['rango_dian_fin'],0,0,'R');	
				$pdf->SetFont('Arial','B',6);	
				$pdf->Cell(128,3,utf8_decode('Resol. MINTIC No. '.$guia[$i]['resolucion_ministerio'].' de '.$guia[$i]['fecha_resolucion'].'. Régimen Común  Rpostal 404                     '),0,0,'R');		
				$pdf->Ln(3);	 
				$pdf->Cell(119,3,'',0,0,'R');		 	 
				$pdf->SetFont('Arial','B',8);		 	 	 
				//$pdf->Cell(22,3,$guia[$i]['solicitud_id'],0,0,'R');			 
				$pdf->Cell(45,3,"CONTADO",0,0,'R');
				$pdf->Cell(30,3,'GUIA No '.$guia[$i]['numero_guia_bar'],0,0,'C');		 	 	 
				$pdf->Ln(3.5);	 
				
				// Cuadro 1	
				$pdf->Cell(195,15,null,1,0,'C');
				
				// Fila 1 Cuadro 1
				$pdf->SetX(40);
				$pdf->SetY(20+$sumaY);

				$pdf->SetFont('Arial','B',6);
				$pdf->Cell(18, 3, "Origen:", 0);
				$pdf->Cell(65, 3, substr(utf8_decode($guia[$i]['origen']),0,40).' - '.$guia[$i]['pais_origen'].' - CP '.$guia[$i]['postal_origen'],0);
				$pdf->Cell(20, 3, "Destino :", 0);
				$pdf->Cell(62, 3, substr(utf8_decode($guia[$i]['destino']),0,40).' - '.$guia[$i]['pais_destino'].' - CP '.$guia[$i]['postal_destino'],0);	 	 	 	 	 
				$pdf->Cell(30,3,"Fecha y Hora Aforo",0,0,'C');
				// Fila 2 Cuadro 1
				$pdf->SetX(40);
				$pdf->SetY(24+$sumaY);
				$pdf->Cell(18, 0, "Remitente:", 0);
				$pdf->Cell(65, 0, substr(utf8_decode($guia[$i]['remitente']),0,50), 0);
				$pdf->Cell(20, 0, "Destinatario:", 0);
				$pdf->Cell(62, 0, substr(utf8_decode($guia[$i]['destinatario']),0,60), 0);	 
				$pdf->Cell(30,0,$guia[$i]['fecha_guia'].' '.$guia[$i]['hora_guia'],0,0,'C');
				
				
				// Fila 3 Cuadro 1
				$pdf->SetX(40);
				$pdf->SetY(28+$sumaY);
				$pdf->Cell(18, -3, utf8_decode("Dirección1:"), 0);
				$pdf->Cell(65, -3, substr(utf8_decode($guia[$i]['direccion_remitente']),0,50), 0);
				$pdf->Cell(20, -3, utf8_decode("Dirección:"), 0);
				$pdf->Cell(62, -3, substr(utf8_decode($guia[$i]['direccion_destinatario']),0,60), 0);	 	 	
				$pdf->Cell(30,-3,"Servicio",0,0,'C');
				
				
				$pdf->SetX(40);
				$pdf->SetY(32+$sumaY);
				$pdf->Cell(18, -5, utf8_decode("Correo Remi:"),0);
				$pdf->Cell(65, -5, substr(utf8_decode($guia[$i]['correo_remitente']),0,50), 0);
				$pdf->Cell(20, -5, utf8_decode("Correo Dest:"), 0);
				$pdf->Cell(62, -5, substr(utf8_decode($guia[$i]['correo_destinatario']),0,60), 0);	 	 	
				$pdf->Cell(30,-5,"Servicio",0,0,'C');
				
				
				// Fila 4 Cuadro 1
				$pdf->SetX(40);
				$pdf->SetY(36+$sumaY);
				$pdf->Cell(18, -7, "DI/NIT:", 0);
				$pdf->Cell(20, -7, substr(utf8_decode($guia[$i]['doc_remitente']),0,34), 0);
				$pdf->Cell(15, -7, utf8_decode("Teléfono:"), 0);
				$pdf->Cell(30, -7, substr(utf8_decode($guia[$i]['telefono_remitente']),0,34), 0);
				$pdf->Cell(20, -7, "DI/NIT:", 0);
				$pdf->Cell(20, -7, substr(utf8_decode($guia[$i]['doc_destinatario']),0,34), 0);
				$pdf->Cell(15, -7, utf8_decode("Teléfono:"), 0);
				$pdf->Cell(30, -7, substr(utf8_decode($guia[$i]['telefono_destinatario']),0,26), 0);
				$pdf->Cell(25,-7,$guia[$i]['tipo_servicio'],0,0,'C');
				
				// Cuadro 2
				
				$pdf->SetX(40);
				$pdf->SetY(35+$sumaY);	 	
				$pdf->Cell(195,7,null,1,0,'C');
				$pdf->SetX(40);
				$pdf->SetY(38+$sumaY);	 
				$pdf->Cell(25, -3, "Cantidad", 0,0,'C');	 	 	
				$pdf->Cell(80, -3, "Dice contener", 0,0,'C');	 	 	
				$pdf->Cell(15, -3, "Peso (".$guia[$i]['medida'].")", 0,0,'C');	
				$pdf->Cell(20, -3, "Vol(kg)", 0,0,'C');	
				$pdf->Cell(25, -3, "Doc. Cliente/Bolsa", 0,0,'C');	 
				$pdf->Cell(40, -3, "V/r. Declarado", 0,0,'C');	 	 
				
				$pdf->SetFont('Arial','B',6);
				
				$pdf->SetX(40);
				$pdf->SetY(42+$sumaY);
				
				$pdf->Cell(25, -4, $guia[$i]['cantidad'], 0,0,'C');	 	 	
				$pdf->Cell(80, -4, substr($guia[$i]['descripcion_producto'],0,60), 0,0,'C');	 	 	
				$pdf->Cell(15, -4, $guia[$i]['peso'], 0,0,'C');	
				$pdf->Cell(20, -4, $guia[$i]['peso_volumen'], 0,0,'C');	
				$pdf->Cell(25, -4, $guia[$i]['guia_cliente'], 0,0,'C');	 
				$pdf->Cell(40, -4, number_format($guia[$i]['valor'],0,',','.'), 0,0,'C');	  	
				
				$pdf->SetFont('Arial','B',5);
				$pdf->SetX(40);
				$pdf->SetY(42+$sumaY);	 
				$pdf->Cell(140, 7,"", 1,0,'C');	 	 	
				$pdf->SetX(40);
				$pdf->SetY(42+$sumaY);//	+ arriba o abajo -
				$pdf->Cell(140, 3,utf8_decode("El usuario declara tener conocimiento del contrato que regula el servicio acordado entre las partes, el cual se encuentra publicado en la página www.velotax.com.co"), 0,0,'L');	 	 	
				$pdf->Cell(55, 7, "", 1,0,'C');	 	 	
				$pdf->SetX(150);
				$pdf->Cell(55, 3,utf8_decode("velotax entidad cooperativa del Régimen tributario especial."), 0,0,'L');
				
				$pdf->SetY(52+$sumaY);
				$pdf->Cell(140, -13,utf8_decode("sección mensajería y en los centros de recepción, aceptando las clausulas con la suscripción de la guía. También declara tener conocimiento de nuestro aviso de "), 0,0,'L');	 	 	
				$pdf->Cell(55, -13,utf8_decode("Nuestros ingresos NO están sujetos a retención en la fuente."), 0,0,'L');
				$pdf->SetY(56+$sumaY);
				$pdf->Cell(140, -17,utf8_decode("privacidad y aceptar la política de protección de datos personales los cuales están en el portal web. Para P.Q.R  diríjase al sitio web o a la línea 018000934380."), 0,0,'L');	 	 	
				$pdf->Cell(55, -17,utf8_decode("(Art. 19-4 Par.1del E.T); (Art.14 D.R 4400 de 2004)."), 0,0,'L');
				$pdf->SetY(68+$sumaY);
				$pdf->Cell(140, 3,"", 0,0,'L');	 	 	
				$pdf->Cell(55, 3,"", 0,0,'L');
				
				$pdf->SetFont('Arial','B',6);
				/*$pdf->SetX(40);
				$pdf->SetY(44);	 
				$pdf->Cell(25, 3, $guia[$i]['cantidad'], 0,0,'C');	 	 	
				$pdf->Cell(80, 3, substr($guia[$i]['descripcion_producto'],0,60), 0,0,'C');	 	 	
				$pdf->Cell(15, 3, $guia[$i]['peso'], 0,0,'C');	
				$pdf->Cell(20, 3, $guia[$i]['peso_volumen'], 0,0,'C');	
				$pdf->Cell(25, 3, $guia[$i]['guia_cliente'], 0,0,'C');	 
				$pdf->Cell(40, 3, number_format($guia[$i]['valor'],0,',','.'), 0,0,'C');*/	
				
				// Cuadro 3	 
				$pdf->SetX(40);
				$pdf->SetY(49+$sumaY);	 	
				$pdf->Cell(195,15,"",1,0,'C');		 
				
				
				$pdf->SetX(40);
				$pdf->SetY(48+$sumaY);	 	
				$pdf->Cell(65,5,"Observaciones :",0,0,'L');
				$pdf->Cell(50,5,"Recibe a conformidad",0,0,'L');
				$pdf->Cell(60,5,"DESCONOCIDO   __    __    __ Fecha: __ __ __ Hora: __ __",0,0,'L');
				$pdf->Cell(12,5,"V/R Flete:",0,0,'L');
				$pdf->Cell(10,5,number_format($guia[$i]['valor_flete'],0,',','.')."",0,0,'L');	 
				
				$pdf->SetX(40);
				$pdf->SetY(51+$sumaY);	// 	
				$pdf->Cell(65,5,"",0,0,'L');
				$pdf->Cell(50,5,"",0,0,'L');
				$pdf->Cell(60,5,"DIR. ERRADA      __    __    __ Fecha: __ __ __ Hora: __ __",0,0,'L');
				$pdf->Cell(12,5,"V/r Seguro:",0,0,'L');
				$pdf->Cell(10,5,number_format($guia[$i]['valor_seguro'],0,',','.')."",0,0,'L');
				
				$pdf->SetX(40);
				$pdf->SetY(54+$sumaY);	 	
				$pdf->Cell(65,5,"",0,0,'L');
				$pdf->Cell(50,5,"",0,0,'L');
				$pdf->Cell(60,5,"REHUSADA         __    __    __ Fecha: __ __ __ Hora: __ __",0,0,'L');
				$pdf->Cell(12,5,"Vr. Dcto:",0,0,'L');
				$pdf->Cell(10,5,number_format($guia[$i]['valor_descuento'],0,',','.')."",0,0,'L');	 
				
				$pdf->SetX(40);
				$pdf->SetY(57+$sumaY);	 	
				$pdf->Cell(65,5,"",0,0,'L');
				$pdf->Cell(50,5,"",0,0,'L');
				$pdf->Cell(60,5,"NO RESIDE.         __    __    __",0,0,'L');
				$pdf->Cell(12,5,"Otros:",0,0,'L');
				$pdf->Cell(10,5,number_format($guia[$i]['valor_otros'],0,',','.')."",0,0,'L');	 
				
				$pdf->SetX(40);
				$pdf->SetY(60+$sumaY);	 	
				$pdf->Cell(65,5,"",0,0,'L');
				$pdf->Cell(50,5,"",0,0,'L');
				$pdf->Cell(60,5,"OTRO                   __    __    __",0,0,'L');			 
				$pdf->Cell(12,5,"TOTAL",0,0,'L');
				$pdf->Cell(10,5,number_format($guia[$i]['valor_total'],0,',','.')."",0,0,'L');
				
				$pdf->SetX(40);
				$pdf->SetY(52+$sumaY);	 	
				$pdf->Cell(65,5,substr($guia[$i]['observaciones'],0,80),0,0,'L');	 
				$pdf->Cell(95,5,null,0,0,'L');	 
				
				$pdf->SetX(40);
				$pdf->SetY(55+$sumaY);	 	
				$pdf->Cell(65,5,trim(substr($guia[$i]['observaciones'],79,80)),0,0,'L');	 	 
				$pdf->Cell(95,5,null,0,0,'L');	 
				
				$pdf->SetX(40);
				$pdf->SetY(60+$sumaY);	
				$pdf->SetFont('Arial','B',5);
				$pdf->Cell(65,5,$guia[$i]['oficina_responsable'],0,0,'L');	 
				$pdf->SetFont('Arial','B',6);
				$pdf->Cell(75,5,"Nombre legible, C.C, Sello y Fecha/Hora Entrega",0,0,'L');	 
				
				$pdf->SetFont('Arial','B',6);		 
				$pdf->SetX(40);
				$pdf->SetY(64+$sumaY);	 	
				$pdf->Cell(40,3,utf8_decode("Impresión Software Si & Si NIT. 900608466-4"),0,0,'L');	
				$pdf->Cell(115,3,$array[$j],0,0,'C');	 
				// fin copia 1
				$sumaY += 67;
				
				}
			 
			 
			 }	 	
			
			$pdf->Output(); //Env�a como salida del documento    
			
		}elseif($_REQUEST['formato']=='IS'){ //inicia impresion sencilla sencilla un original y una copia dos guias pagina
		
			$pdf=new FPDF(); // Crea un objeto de la clase fpdf()
			$pdf->AddPage('P','Letter','mm'); // Agrega una hoja al documento.
			$pdf->SetFont('Arial','B',10); //Establece la fuente a utilizar, el formato Negrita y el tama�o
		
			#Establecemos los m�rgenes izquierda, arriba y derecha:
			$pdf->SetMargins(10, 5 , 5);
		
			#Establecemos el margen inferior:
			$pdf->SetAutoPageBreak(true,1);  
		
			$j=0;
			for($i = 0; $i < count($guia); $i++){	

			 if($j==0){
			 // Copia 1
			 $pdf->SetX(40);
			 $pdf->SetY(10);	
			 $pdf->Image($guia[$i]['logo'],10,8,41,11); 
			 $pdf->Image($guia[$i]['codbar'],165,8,40,7); 	 
			 $pdf->Cell(40,3,null,0,0,'R');		 	 
			 $pdf->SetFont('Arial','B',7);	 
			 $pdf->Cell(55,3,"NIT. $nit_empresa",0,0,'R');		 
			 
			 $pdf->SetFont('Arial','B',5);	 
			 $pdf->Cell(30,3,'SERVICIO',0,0,'C');	
			 $pdf->SetFont('Arial','B',8);		 	 
			 $pdf->Cell(25,3,$guia[$i]['fecha_guia'],0,0,'C');		 	 
			 $pdf->Ln(3);	 
			 
			 $pdf->Cell(100,3,$guia[$i]['pagina_web'],0,0,'R');	
			 $pdf->SetFont('Arial','B',7);	
			 $pdf->Cell(1,9,'Resol. No. '.$guia[$i]['resolucion_ministerio'].' de '.$guia[$i]['fecha_resolucion'],0,0,'R');		
			 $pdf->SetFont('Arial','B',5);	
			 $pdf->Cell(15,3,'ENTREGA',0,0,'R');		 	 
			 $pdf->Ln(3);	 
			 $pdf->Cell(116,3,'INMEDIATA',0,0,'R');		 	 
			 $pdf->SetFont('Arial','B',8);		 	 	 
			 $pdf->Cell(22,3,$guia[$i]['solicitud_id'],0,0,'R');			 
			 $pdf->Cell(27,3,$guia[$i]['tipo_servicio'],0,0,'R');
			 $pdf->Cell(30,3,$guia[$i]['numero_guia_bar'],0,0,'C');		 	 	 
			 $pdf->Ln(3.5);	 
		
			 // Cuadro 1	
			 $pdf->Cell(195,16,null,1,0,'C');


			
			 // Cuadro 3	 
			 $pdf->SetX(40);
			 $pdf->SetY(50);	 	
			 $pdf->Cell(195,15,null,1,0,'C');		 
			 $pdf->SetFont('Arial','B',6);		 
			 $pdf->SetX(40);
			 $pdf->SetY(50);	 	
			 $pdf->Cell(90,5,"Observaciones :",0,0,'L');
			 $pdf->Cell(75,5,"Recibe a conformidad",0,0,'L');
			 $pdf->Cell(15,5,"V/R Flete:",0,0,'L');
			 $pdf->Cell(10,5,number_format($guia[$i]['valor_flete'],0,',','.')."",0,0,'L');	 
		
			 $pdf->SetX(40);
			 $pdf->SetY(53);	 	
			 $pdf->Cell(90,5,"",0,0,'L');
			 $pdf->Cell(75,5,"",0,0,'L');
			 $pdf->Cell(15,5,"V/r Seguro:",0,0,'L');
			 $pdf->Cell(10,5,number_format($guia[$i]['valor_seguro'],0,',','.')."",0,0,'L');
			 
			 $pdf->SetX(40);
			 $pdf->SetY(56);	 	
			 $pdf->Cell(90,5,"",0,0,'L');
			 $pdf->Cell(75,5,"",0,0,'L');
			 $pdf->Cell(15,5,"Vr. Dcto:",0,0,'L');
			 $pdf->Cell(10,5,number_format($guia[$i]['valor_descuento'],0,',','.')."",0,0,'L');	 
		
			 $pdf->SetX(40);
			 $pdf->SetY(59);	 	
			 $pdf->Cell(90,5,"",0,0,'L');
			 $pdf->Cell(75,5,"",0,0,'L');
			 $pdf->Cell(15,5,"Otros:",0,0,'L');
			 $pdf->Cell(10,5,number_format($guia[$i]['valor_otros'],0,',','.')."",0,0,'L');	 
		
			 $pdf->SetX(40);
			 $pdf->SetY(61);	 	
			 $pdf->Cell(90,5,"",0,0,'L');
			 $pdf->Cell(75,5,"",0,0,'L');
			 $pdf->Cell(15,5,"V/R. TOTAL",0,0,'L');
			 $pdf->Cell(10,5,number_format($guia[$i]['valor_total'],0,',','.')."",0,0,'L');
			 
			 $pdf->SetX(40);
			 $pdf->SetY(54);	 	
			 $pdf->Cell(90,5,substr($guia[$i]['observaciones'],0,80),0,0,'L');	 
			 $pdf->Cell(95,5,null,0,0,'L');	 
			 
			 $pdf->SetX(40);
			 $pdf->SetY(57);	 	
			 $pdf->Cell(90,5,trim(substr($guia[$i]['observaciones'],79,80)),0,0,'L');	 	 
			 $pdf->Cell(95,5,null,0,0,'L');	 
				 
			 $pdf->SetX(40);
			 $pdf->SetY(61);	 	
			 $pdf->Cell(90,5,$guia[$i]['oficina_responsable'],0,0,'C');	 
			 $pdf->Cell(95,5,"Nombre legible, C.C, Firma, Sello y Fecha.",0,0,'L');	 
				 
			 $pdf->SetFont('Arial','B',6);		 
			 $pdf->SetX(40);
			 $pdf->SetY(66);	 	
			 $pdf->Cell(195,3,"TRANSPORTADORA",0,0,'C');	 
			 // fin copia 1
			 // copia 2	 
			 $pdf->Ln(10);	 
			 $pdf->SetFont('Arial','B',10); 	 
			 
			 $pdf->Image($guia[$i]['logo'],10,74,41,11); 
			 $pdf->Image($guia[$i]['codbar'],165,74,40,7); 	 
			 $pdf->Cell(40,3,null,0,0,'R');		 	 
			 $pdf->SetFont('Arial','B',7);	 
			 $pdf->Cell(55,3,"NIT. $nit_empresa",0,0,'R');		 
			 
			 $pdf->SetFont('Arial','B',5);	 
			 $pdf->Cell(30,3,'SERVICIO',0,0,'C');	
			 $pdf->SetFont('Arial','B',8);		 	 
			 $pdf->Cell(25,3,$guia[$i]['fecha_guia'],0,0,'C');		 	 	 	 	 
			 $pdf->Ln(3);	 
			 $pdf->Cell(100,3,$guia[$i]['pagina_web'],0,0,'R');		
			 $pdf->SetFont('Arial','B',7);	
			 $pdf->Cell(1,9,'Resol. No. '.$guia[$i]['resolucion_ministerio'].' de '.$guia[$i]['fecha_resolucion'],0,0,'R');		
			 
			 $pdf->SetFont('Arial','B',5);		 	 	 	 
			 $pdf->Cell(15,3,'ENTREGA',0,0,'R');		 	 
			 $pdf->Ln(3);	 
			 $pdf->Cell(116,3,'INMEDIATA',0,0,'R');		 	 
			 $pdf->SetFont('Arial','B',8);		 	 	 
			 $pdf->Cell(22,3,$guia[$i]['solicitud_id'],0,0,'R');			 	 	 
			 $pdf->Cell(27,3,$guia[$i]['tipo_servicio'],0,0,'R');
			 $pdf->Cell(30,3,$guia[$i]['numero_guia_bar'],0,0,'C');		 	 	 
			 $pdf->Ln(3.5);	 
		
			 // Cuadro 1	
			 $pdf->Cell(195,16,null,1,0,'C');
				 
//aca			
			 // Fila 1 Cuadro 1
			 $pdf->SetX(40);
			 $pdf->SetY(20);
			 $pdf->Cell(18, 3, "Origen :", 0);
			 $pdf->Cell(65, 3, substr(utf8_decode($guia[$i]['origen']),0,34), 0);
			 $pdf->Cell(20, 3, "Destino :", 0);
			 $pdf->Cell(50, 3, substr(utf8_decode($guia[$i]['destino']),0,26).' - '.$guia[$i]['depto_destino'].' - '.substr(utf8_decode($guia[$i]['pais_destino']),0,3), 0);	 	 	 	 	 
			 
			 // Fila 2 Cuadro 1
			 $pdf->SetX(40);
			 $pdf->SetY(24);
			 $pdf->Cell(18, 3, "Remitente :", 0);
			 $pdf->Cell(65, 3, substr(utf8_decode($guia[$i]['remitente']),0,34), 0);
			 $pdf->Cell(20, 3, "Destinatario :", 0);
			 $pdf->Cell(50, 3, substr(utf8_decode($guia[$i]['destinatario']),0,60).'', 0);	 
			 
			 // Fila 3 Cuadro 1
			 $pdf->SetX(40);
			 $pdf->SetY(28);
			 $pdf->Cell(18, 3, "Direccion :", 0);
			 $pdf->Cell(65, 3, substr(utf8_decode($guia[$i]['direccion_remitente']),0,34), 0);
			 $pdf->Cell(20, 3, "Direccion :", 0);
			 $pdf->Cell(50, 3, substr(utf8_decode($guia[$i]['direccion_destinatario']),0,60), 0);	 	 	 	 	 
		 
			 // Fila 4 Cuadro 1
			 $pdf->SetX(40);
			 $pdf->SetY(32);
			 $pdf->Cell(18, 3, "Telefono :", 0);
			 $pdf->Cell(65, 3, substr(utf8_decode($guia[$i]['telefono_remitente']),0,34), 0);
			 $pdf->Cell(20, 3, "Telefono :", 0);
			 $pdf->Cell(50, 3, substr(utf8_decode($guia[$i]['telefono_destinatario']),0,26), 0);
			 
			 // Cuadro 2
			 
			 $pdf->SetX(40);
			 $pdf->SetY(35);	 	
			 $pdf->Cell(195,16,null,1,0,'C');
			 $pdf->SetX(40);
			 $pdf->SetY(36);	 
			 $pdf->Cell(25, 3, "Cantidad", 0,0,'C');	 	 	
			 $pdf->Cell(80, 3, "Producto", 0,0,'C');	 	 	
			 $pdf->Cell(15, 3, "Peso (".$guia[$i]['medida'].")", 0,0,'C');	
			 $pdf->Cell(20, 3, "Peso Vol", 0,0,'C');	
			 $pdf->Cell(25, 3, "Doc. Cliente", 0,0,'C');	 
			 $pdf->Cell(40, 3, "V/r. Declarado", 0,0,'C');	 	 
			 
			 $pdf->SetFont('Arial','B',6);
			 
			 $pdf->SetX(40);
			 $pdf->SetY(40);	 
			 $pdf->Cell(25, 3, $guia[$i]['cantidad'], 0,0,'C');	 	 	
			 $pdf->Cell(80, 3, substr($guia[$i]['descripcion_producto'],0,60), 0,0,'C');	 	 	
			 $pdf->Cell(15, 3, $guia[$i]['peso'], 0,0,'C');	
			 $pdf->Cell(20, 3, $guia[$i]['peso_volumen'], 0,0,'C');	
			 $pdf->Cell(25, 3, $guia[$i]['guia_cliente'], 0,0,'C');	 
			 $pdf->Cell(40, 3, number_format($guia[$i]['valor'],0,',','.'), 0,0,'C');	  	
			 
			/* $pdf->SetX(40);
			 $pdf->SetY(44);	 
			 $pdf->Cell(25, 3, $guia[$i]['cantidad'], 0,0,'C');	 	 	
			 $pdf->Cell(80, 3, substr($guia[$i]['descripcion_producto'],0,60), 0,0,'C');	 	 	
			 $pdf->Cell(15, 3, $guia[$i]['peso'], 0,0,'C');	
			 $pdf->Cell(20, 3, $guia[$i]['peso_volumen'], 0,0,'C');	
			 $pdf->Cell(25, 3, $guia[$i]['guia_cliente'], 0,0,'C');	 
			 $pdf->Cell(40, 3, number_format($guia[$i]['valor'],0,',','.'), 0,0,'C');	*/

			 // Fila 1 Cuadro 1
			 $pdf->SetX(40);
			 $pdf->SetY(86);
 			 $pdf->SetFont('Arial','B',8);		 	 	 
			 $pdf->Cell(18, 3, "Origen :", 0);
			 $pdf->Cell(65, 3, substr(utf8_decode($guia[$i]['origen']),0,34), 0);
			 $pdf->Cell(20, 3, "Destino :", 0);
			 $pdf->Cell(50, 3, substr(utf8_decode($guia[$i]['destino']),0,26).' - '.$guia[$i]['depto_destino'].' - '.substr(utf8_decode($guia[$i]['pais_destino']),0,3), 0); 	 	 	 	 
			 
			 // Fila 2 Cuadro 1
			 $pdf->SetX(40);
			 $pdf->SetY(90);
			 $pdf->Cell(18, 3, "Remitente :", 0);
			 $pdf->Cell(65, 3, substr(utf8_decode($guia[$i]['remitente']),0,34), 0);
			 $pdf->Cell(20, 3, "Destinatario :", 0);
			 $pdf->Cell(50, 3, substr(utf8_decode($guia[$i]['destinatario']),0,60), 0);	
			 
			 // Fila 3 Cuadro 1
			 $pdf->SetX(40);
			 $pdf->SetY(94);
			 $pdf->Cell(18, 3, "Direccion :", 0);
			 $pdf->Cell(65, 3, substr(utf8_decode($guia[$i]['direccion_remitente']),0,34), 0);
			 $pdf->Cell(20, 3, "Direccion :", 0);
			 $pdf->Cell(50, 3, substr(utf8_decode($guia[$i]['direccion_destinatario']),0,60), 0); 	 	 	 	 
		 
			 // Fila 4 Cuadro 1
			 $pdf->SetX(40);
			 $pdf->SetY(98);
			 $pdf->Cell(18, 3, "Telefono :", 0);
			 $pdf->Cell(65, 3, substr(utf8_decode($guia[$i]['telefono_remitente']),0,34), 0);
			 $pdf->Cell(20, 3, "Telefono :", 0);
			 $pdf->Cell(50, 3, substr(utf8_decode($guia[$i]['telefono_destinatario']),0,26), 0);	
			 
			 // Cuadro 2	 
			 $pdf->SetX(40);
			 $pdf->SetY(101);	 	
			 $pdf->Cell(195,16,null,1,0,'C');
			 $pdf->SetX(40);
			 $pdf->SetY(102);	 
			 $pdf->Cell(25, 3, "Cantidad", 0,0,'C');	 	 	
			 $pdf->Cell(80, 3, "Producto", 0,0,'C');	 	 	
			 $pdf->Cell(15, 3, "Peso (".$guia[$i]['medida'].")", 0,0,'C');	
			 $pdf->Cell(20, 3, "Peso Vol", 0,0,'C');	
			 $pdf->Cell(25, 3, "Doc. Cliente", 0,0,'C');	 
			 $pdf->Cell(40, 3, "V/r. Declarado", 0,0,'C');	 	 
			 
			 $pdf->SetFont('Arial','B',6);
			 
			 $pdf->SetX(40);
			 $pdf->SetY(105);	 
			 $pdf->Cell(25, 3, $guia[$i]['cantidad'], 0,0,'C');	 	 	
			 $pdf->Cell(80, 3, substr($guia[$i]['descripcion_producto'],0,60), 0,0,'C');	 	 	
			 $pdf->Cell(15, 3, $guia[$i]['peso'], 0,0,'C');	 
			 $pdf->Cell(20, 3, $guia[$i]['peso_volumen'], 0,0,'C');	 
			 $pdf->Cell(25, 3, $guia[$i]['orden_despacho'], 0,0,'C');	 
			 $pdf->Cell(40, 3, number_format($guia[$i]['valor'],0,',','.'), 0,0,'C');	  	
			 
			/* $pdf->SetX(40);
			 $pdf->SetY(108);	 
			 $pdf->Cell(25, 3, $guia[$i]['cantidad'], 0,0,'C');	 	 	
			 $pdf->Cell(80, 3, substr($guia[$i]['descripcion_producto'],0,60), 0,0,'C');	 	 	
			 $pdf->Cell(15, 3, $guia[$i]['peso'], 0,0,'C');	
			 $pdf->Cell(20, 3, $guia[$i]['peso_volumen'], 0,0,'C');	
			 $pdf->Cell(25, 3, $guia[$i]['guia_cliente'], 0,0,'C');	 
			 $pdf->Cell(40, 3, number_format($guia[$i]['valor'],0,',','.'), 0,0,'C');	*/	 

			 // Cuadro 3	 
			 $pdf->SetX(40);
			 $pdf->SetY(117);	 	
			 $pdf->Cell(195,15,null,1,0,'C');		 
			 
			 $pdf->SetX(40);
			 $pdf->SetY(117);	 	
			 $pdf->Cell(90,5,"Observaciones :",0,0,'L');
			 $pdf->Cell(75,5,"Recibe a conformidad",0,0,'L');	 
			 $pdf->Cell(15,5,"V/R Flete:",0,0,'L');
			 $pdf->Cell(10,5,number_format($guia[$i]['valor_flete'],0,',','.')."",0,0,'L');	 
		
			 $pdf->SetX(40);
			 $pdf->SetY(120);	 	
			 $pdf->Cell(90,5,"",0,0,'L');
			 $pdf->Cell(75,5,"",0,0,'L');
			 $pdf->Cell(15,5,"V/r Seguro:",0,0,'L');
			 $pdf->Cell(10,5,number_format($guia[$i]['valor_seguro'],0,',','.')."",0,0,'L');
			 
			 $pdf->SetX(40);
			 $pdf->SetY(123);	 	
			 $pdf->Cell(90,5,"",0,0,'L');
			 $pdf->Cell(75,5,"",0,0,'L');
			 $pdf->Cell(15,5,"Vr. Dcto:",0,0,'L');
			 $pdf->Cell(10,5,number_format($guia[$i]['valor_descuento'],0,',','.')."",0,0,'L');	 
		
			 $pdf->SetX(40);
			 $pdf->SetY(126);	 	
			 $pdf->Cell(90,5,"",0,0,'L');
			 $pdf->Cell(75,5,"",0,0,'L');
			 $pdf->Cell(15,5,"Otros:",0,0,'L');
			 $pdf->Cell(10,5,number_format($guia[$i]['valor_otros'],0,',','.')."",0,0,'L');	 
		
			 $pdf->SetX(40);
			 $pdf->SetY(128);	 	
			 $pdf->Cell(90,5,"",0,0,'L');
			 $pdf->Cell(75,5,"",0,0,'L');
			 $pdf->Cell(15,5,"V/R. TOTAL",0,0,'L');
			 $pdf->Cell(10,5,number_format($guia[$i]['valor_total'],0,',','.')."",0,0,'L');
		
			 $pdf->SetX(40);
			 $pdf->SetY(120);	 	
			 $pdf->Cell(90,5,substr(utf8_decode($guia[$i]['observaciones']),0,80),0,0,'L');	 	 
			 $pdf->Cell(95,5,null,0,0,'L');	 
		
			 $pdf->SetX(40);
			 $pdf->SetY(123);	 	
			 $pdf->Cell(90,5,trim(substr($guia[$i]['observaciones'],79,80)),0,0,'L');	 	 
			 $pdf->Cell(95,5,null,0,0,'L');	 
				 
			 $pdf->SetX(40);
			 $pdf->SetY(127);	 	
			 $pdf->Cell(90,5,utf8_decode($guia[$i]['oficina_responsable']),0,0,'C');	 
			 $pdf->Cell(95,5,"Nombre legible, C.C, Firma, Sello y Fecha.",0,0,'L');	  	 	 	 
			 
			 $pdf->SetFont('Arial','B',6);		 
			 $pdf->SetX(40);
			 $pdf->SetY(132);	 	
			 $pdf->Cell(195,3,"CLIENTE",0,0,'C');	 	 
			 // fin copia 2
			 }
			 if($j==1){
			 // copia 3	 
			 $pdf->Ln(10);	 
			 $pdf->SetFont('Arial','B',10); 	 
			 $pdf->Image($guia[$i]['logo'],10,140,41,11); 
			 $pdf->Image($guia[$i]['codbar'],165,140,40,7); 	 
			 
			 $pdf->Cell(40,3,null,0,0,'R');		 	 
			 $pdf->SetFont('Arial','B',7);	 
			 $pdf->Cell(55,3,"NIT. $nit_empresa",0,0,'R');		 
			 
			 $pdf->SetFont('Arial','B',5);	 
			 $pdf->Cell(30,3,'SERVICIO',0,0,'C');	
			 $pdf->SetFont('Arial','B',8);		 	 
			 $pdf->Cell(25,3,$guia[$i]['fecha_guia'],0,0,'C');		 	 	 	 	 
			 $pdf->Ln(3);	 
			 $pdf->Cell(100,3,$guia[$i]['pagina_web'],0,0,'R');	
			 $pdf->SetFont('Arial','B',7);	
			 $pdf->Cell(1,9,'Resol. No. '.$guia[$i]['resolucion_ministerio'].' de '.$guia[$i]['fecha_resolucion'],0,0,'R');		
			 
			 $pdf->SetFont('Arial','B',5);		 	 	 	 
			 $pdf->Cell(15,3,'ENTREGA',0,0,'R');	 	 
			 $pdf->Ln(3);	 
			 $pdf->Cell(116,3,'INMEDIATA',0,0,'R');		 	 
			 $pdf->SetFont('Arial','B',8);		 	 	 
			 $pdf->Cell(22,3,$guia[$i]['solicitud_id'],0,0,'R');			 	 	 
			 $pdf->Cell(27,3,$guia[$i]['tipo_servicio'],0,0,'R');
			 $pdf->Cell(30,3,$guia[$i]['numero_guia_bar'],0,0,'C');			 	 	 
			 $pdf->Ln(3.5);	 
		
			 // Cuadro 1	
			 $pdf->Cell(195,16,null,1,0,'C');

			 // Fila 1 Cuadro 1
			 $pdf->SetX(40);
			 $pdf->SetY(152);
			 $pdf->Cell(18, 3, "Origen :", 0);
			 $pdf->Cell(65, 3, substr(utf8_decode($guia[$i]['origen']),0,34), 0);
			 $pdf->Cell(20, 3, "Destino :", 0);
			 $pdf->Cell(50, 3, substr(utf8_decode($guia[$i]['destino']),0,26).' - '.$guia[$i]['depto_destino'].' - '.substr(utf8_decode($guia[$i]['pais_destino']),0,3), 0); 	 	 	 	 
			 
			 // Fila 2 Cuadro 1
			 $pdf->SetX(40);
			 $pdf->SetY(156);
			 $pdf->Cell(18, 3, "Remitente :", 0);
			 $pdf->Cell(65, 3, substr(utf8_decode($guia[$i]['remitente']),0,34), 0);
			 $pdf->Cell(20, 3, "Destinatario :", 0);
			 $pdf->Cell(50, 3, substr(utf8_decode($guia[$i]['destinatario']),0,60).'', 0);	 	
			 
			 // Fila 3 Cuadro 1
			 $pdf->SetX(40);
			 $pdf->SetY(160);
			 $pdf->Cell(18, 3, "Direccion :", 0);
			 $pdf->Cell(65, 3, substr(utf8_decode($guia[$i]['direccion_remitente']),0,34), 0);
			 $pdf->Cell(20, 3, "Direccion :", 0);
			 $pdf->Cell(50, 3, substr(utf8_decode($guia[$i]['direccion_destinatario']),0,60), 0);	
		 
			 // Fila 4 Cuadro 1
			 $pdf->SetX(40);
			 $pdf->SetY(164);
			 $pdf->Cell(18, 3, "Telefono :", 0);
			 $pdf->Cell(65, 3, substr(utf8_decode($guia[$i]['telefono_remitente']),0,34), 0);
			 $pdf->Cell(20, 3, "Telefono :", 0);
			 $pdf->Cell(50, 3, substr(utf8_decode($guia[$i]['telefono_destinatario']),0,26), 0);
			 
			 // Cuadro 2	 
			 $pdf->SetX(40);
			 $pdf->SetY(167);	 	
			 $pdf->Cell(195,16,null,1,0,'C');
			 $pdf->SetX(40);
			 $pdf->SetY(168);	 
			 $pdf->Cell(25, 3, "Cantidad", 0,0,'C');	 	 	
			 $pdf->Cell(80, 3, "Producto", 0,0,'C');	 	 	
			 $pdf->Cell(15, 3, "Peso (".$guia[$i]['medida'].")", 0,0,'C');	
			 $pdf->Cell(20, 3, "Peso Vol", 0,0,'C');	
			 $pdf->Cell(25, 3, "Doc. Cliente", 0,0,'C');	 
			 $pdf->Cell(40, 3, "V/r. Declarado", 0,0,'C');	 	 
			 
			 $pdf->SetFont('Arial','B',6);
			 
			 $pdf->SetX(40);
			 $pdf->SetY(171);	 
			 $pdf->Cell(25, 3, $guia[$i]['cantidad'], 0,0,'C');	 	 	
			 $pdf->Cell(80, 3, substr($guia[$i]['descripcion_producto'],0,60), 0,0,'C');	 	 	
			 $pdf->Cell(15, 3, $guia[$i]['peso'], 0,0,'C');
			 $pdf->Cell(20, 3, $guia[$i]['peso_volumen'], 0,0,'C');
			 $pdf->Cell(25, 3, $guia[$i]['orden_despacho'], 0,0,'C');	 
			 $pdf->Cell(40, 3, number_format($guia[$i]['valor'],0,',','.'), 0,0,'C');	  	
			 
			 $pdf->SetX(40);
			 $pdf->SetY(174);	 
			 $pdf->Cell(25, 3, $guia[$i]['cantidad'], 0,0,'C');	 	 	
			 $pdf->Cell(80, 3, substr($guia[$i]['descripcion_producto'],0,60), 0,0,'C');	 	 	
			 $pdf->Cell(15, 3, $guia[$i]['peso'], 0,0,'C');	
			 $pdf->Cell(20, 3, $guia[$i]['peso_volumen'], 0,0,'C');	
			 $pdf->Cell(25, 3, $guia[$i]['orden_despacho'], 0,0,'C');	 
			 $pdf->Cell(40, 3, number_format($guia[$i]['valor'],0,',','.'), 0,0,'C');		 

			
			 // Cuadro 3
			 $pdf->SetX(40);
			 $pdf->SetY(183);	 	
			 $pdf->Cell(195,15,null,1,0,'C');	
			 
			 $pdf->SetX(40);
			 $pdf->SetY(182);	 	
			 $pdf->Cell(90,5,"Observaciones :",0,0,'L');
			 $pdf->Cell(75,5,"Recibe a conformidad",0,0,'L');	
			 $pdf->Cell(15,5,"V/R Flete:",0,0,'L');
			 $pdf->Cell(10,5,number_format($guia[$i]['valor_flete'],0,',','.')."",0,0,'L');
		
			 $pdf->SetX(40);
			 $pdf->SetY(185);	 	
			 $pdf->Cell(90,5,"",0,0,'L');
			 $pdf->Cell(75,5,"",0,0,'L');
			 $pdf->Cell(15,5,"V/r Seguro:",0,0,'L');
			 $pdf->Cell(10,5,number_format($guia[$i]['valor_seguro'],0,',','.')."",0,0,'L');
			 
			 $pdf->SetX(40);
			 $pdf->SetY(188);	 	
			 $pdf->Cell(90,5,"",0,0,'L');
			 $pdf->Cell(75,5,"",0,0,'L');
			 $pdf->Cell(15,5,"Vr. Dcto:",0,0,'L');
			 $pdf->Cell(10,5,number_format($guia[$i]['valor_descuento'],0,',','.')."",0,0,'L');	 
		
			 $pdf->SetX(40);
			 $pdf->SetY(191);	 	
			 $pdf->Cell(90,5,"",0,0,'L');
			 $pdf->Cell(75,5,"",0,0,'L');
			 $pdf->Cell(15,5,"Otros:",0,0,'L');
			 $pdf->Cell(10,5,number_format($guia[$i]['valor_otros'],0,',','.')."",0,0,'L');
		
			 $pdf->SetX(40);
			 $pdf->SetY(194);	 	
			 $pdf->Cell(90,5,"",0,0,'L');
			 $pdf->Cell(75,5,"",0,0,'L');
			 $pdf->Cell(15,5,"V/R. TOTAL",0,0,'L');
			 $pdf->Cell(10,5,number_format($guia[$i]['valor_total'],0,',','.')."",0,0,'L');
		
			 $pdf->SetX(40);
			 $pdf->SetY(185);	 	
			 $pdf->Cell(90,5,substr($guia[$i]['observaciones'],0,80),0,0,'L');	 	 
			 $pdf->Cell(95,5,null,0,0,'L');	 
		
			 $pdf->SetX(40);
			 $pdf->SetY(188);	 	
			 $pdf->Cell(90,5,trim(substr($guia[$i]['observaciones'],79,80)),0,0,'L');	 	 
			 $pdf->Cell(95,5,null,0,0,'L');	 
		
			 $pdf->SetX(40);
			 $pdf->SetY(193);	 	
			 $pdf->Cell(90,5,$guia[$i]['oficina_responsable'],0,0,'C');	 
			 $pdf->Cell(95,5,"Nombre legible, C.C, Firma, Sello y Fecha.",0,0,'L');	 
			 
			 $pdf->SetFont('Arial','B',6);		 
			 $pdf->SetX(40);
			 $pdf->SetY(198);	 	
			 $pdf->Cell(195,3,"TRANSPORTADORA",0,0,'C');	
			 // fin copia 3	 
		
			//copia 4
			 $pdf->Ln(9);	 
			 $pdf->SetFont('Arial','B',10); 	 
			 
			 $pdf->Image($guia[$i]['logo'],10,205,41,11); 
			 $pdf->Image($guia[$i]['codbar'],165,205,40,7); 	 
			 $pdf->Cell(40,3,null,0,0,'R');		 	 
			 $pdf->SetFont('Arial','B',7);	 
			 $pdf->Cell(55,3,"NIT. $nit_empresa",0,0,'R');		 
			 
			 $pdf->SetFont('Arial','B',5);	 
			 $pdf->Cell(30,3,'SERVICIO',0,0,'C');	
			 $pdf->SetFont('Arial','B',8);		 	 
			 $pdf->Cell(25,3,$guia[$i]['fecha_guia'],0,0,'C');		 	 	 	 	 
			 $pdf->Ln(3);	 
			 $pdf->Cell(100,3,$guia[$i]['pagina_web'],0,0,'R');	
			 $pdf->SetFont('Arial','B',7);	
			 $pdf->Cell(1,9,'Resol. No. '.$guia[$i]['resolucion_ministerio'].' de '.$guia[$i]['fecha_resolucion'],0,0,'R');		
			 
			 $pdf->SetFont('Arial','B',5);		 	 	 	 
			 $pdf->Cell(15,3,'ENTREGA',0,0,'R');	 	 
			 $pdf->Ln(3);	 
			 $pdf->Cell(116,3,'INMEDIATA',0,0,'R');		 	 
			 $pdf->SetFont('Arial','B',8);		 	 	 
			 $pdf->Cell(22,3,$guia[$i]['solicitud_id'],0,0,'R');			 		 	 
			 $pdf->Cell(27,3,$guia[$i]['tipo_servicio'],0,0,'R');
			 $pdf->Cell(30,3,$guia[$i]['numero_guia_bar'],0,0,'C');		 	 	 
			 $pdf->Ln(3.5);	 
		
			 // Cuadro 1	
			 $pdf->Cell(195,16,null,1,0,'C');
				 
			 // Fila 1 Cuadro 1
			 $pdf->SetX(40);
			 $pdf->SetY(217);
			 $pdf->Cell(18, 3, "Origen :", 0);
			 $pdf->Cell(65, 3, substr(utf8_decode($guia[$i]['origen']),0,34), 0);
			 $pdf->Cell(20, 3, "Destino :", 0);
			 $pdf->Cell(50, 3, substr(utf8_decode($guia[$i]['destino']),0,26).' - '.$guia[$i]['depto_destino'].' - '.substr(utf8_decode($guia[$i]['pais_destino']),0,3), 0); 	 	 	 	 
			 
			 // Fila 2 Cuadro 1
			 $pdf->SetX(40);
			 $pdf->SetY(221);
			 $pdf->Cell(18, 3, "Remitente :", 0);
			 $pdf->Cell(65, 3, substr(utf8_decode($guia[$i]['remitente']),0,34), 0);
			 $pdf->Cell(20, 3, "Destinatario :", 0);
			 $pdf->Cell(50, 3, substr(utf8_decode($guia[$i]['destinatario']),0,60), 0);	
			 
			 // Fila 3 Cuadro 1
			 $pdf->SetX(40);
			 $pdf->SetY(225);
			 $pdf->Cell(18, 3, "Direccion :", 0);
			 $pdf->Cell(65, 3, substr(utf8_decode($guia[$i]['direccion_remitente']),0,34), 0);
			 $pdf->Cell(20, 3, "Direccion :", 0);
			 $pdf->Cell(50, 3, substr(utf8_decode($guia[$i]['direccion_destinatario']),0,60), 0);		 	 
		 
			 // Fila 4 Cuadro 1
			 $pdf->SetX(40);
			 $pdf->SetY(229);
			 $pdf->Cell(18, 3, "Telefono :", 0);
			 $pdf->Cell(65, 3, substr(utf8_decode($guia[$i]['telefono_remitente']),0,34), 0);
			 $pdf->Cell(20, 3, "Telefono :", 0);
			 $pdf->Cell(50, 3, substr(utf8_decode($guia[$i]['telefono_destinatario']),0,26), 0);
			 
			 // Cuadro 2	 
			 $pdf->SetX(40);
			 $pdf->SetY(232);	 	
			 $pdf->Cell(195,16,null,1,0,'C');
			 $pdf->SetX(40);
			 $pdf->SetY(233);	 
			 $pdf->Cell(25, 3, "Cantidad", 0,0,'C');	 	 	
			 $pdf->Cell(80, 3, "Producto", 0,0,'C');	 	 	
			 $pdf->Cell(15, 3, "Peso (".$guia[$i]['medida'].")", 0,0,'C');	 
			 $pdf->Cell(20, 3, "Peso Vol", 0,0,'C');	 
			 $pdf->Cell(25, 3, "Doc. Cliente", 0,0,'C');	 
			 $pdf->Cell(40, 3, "V/r. Declarado", 0,0,'C');	 	 
			 
			 $pdf->SetFont('Arial','B',6);
			 
			 $pdf->SetX(40);
			 $pdf->SetY(236);	 
			 $pdf->Cell(25, 3, $guia[$i]['cantidad'], 0,0,'C');	 	 	
			 $pdf->Cell(80, 3, substr($guia[$i]['descripcion_producto'],0,60), 0,0,'C');	 	 	
			 $pdf->Cell(15, 3, $guia[$i]['peso'], 0,0,'C');	 	 	
			 $pdf->Cell(20, 3, $guia[$i]['peso_volumen'], 0,0,'C');
			 $pdf->Cell(25, 3, $guia[$i]['orden_despacho'], 0,0,'C');	 
			 $pdf->Cell(40, 3, number_format($guia[$i]['valor'],0,',','.'), 0,0,'C');	  	
			 
			 $pdf->SetX(40);
			 $pdf->SetY(239);	 
			 $pdf->Cell(25, 3, $guia[$i]['cantidad'], 0,0,'C');	 	 	
			 $pdf->Cell(80, 3, substr($guia[$i]['descripcion_producto'],0,60), 0,0,'C');	 	 	
			 $pdf->Cell(15, 3, $guia[$i]['peso'], 0,0,'C');	
			 $pdf->Cell(20, 3, $guia[$i]['peso_volumen'], 0,0,'C');
			 $pdf->Cell(25, 3, $guia[$i]['orden_despacho'], 0,0,'C');	 
			 $pdf->Cell(40, 3, number_format($guia[$i]['valor'],0,',','.'), 0,0,'C');	
			 
			 // Cuadro 3	 
			 $pdf->SetX(40);
			 $pdf->SetY(248);	 	
			 $pdf->Cell(195,15,null,1,0,'C');		 
			 
			 $pdf->SetX(40);
			 $pdf->SetY(247);	 	
			 $pdf->Cell(90,5,"Observaciones :",0,0,'L');
			 $pdf->Cell(75,5,"Recibe a conformidad",0,0,'L');
			 $pdf->Cell(15,5,"V/R Flete:",0,0,'L');
			 $pdf->Cell(10,5,number_format($guia[$i]['valor_flete'],0,',','.')."",0,0,'L');
		
			 $pdf->SetX(40);
			 $pdf->SetY(250);	 	
			 $pdf->Cell(90,5,"",0,0,'L');
			 $pdf->Cell(75,5,"",0,0,'L');
			 $pdf->Cell(15,5,"V/r Seguro:",0,0,'L');
			 $pdf->Cell(10,5,number_format($guia[$i]['valor_seguro'],0,',','.')."",0,0,'L');
			 
			 $pdf->SetX(40);
			 $pdf->SetY(253);	 	
			 $pdf->Cell(90,5,"",0,0,'L');
			 $pdf->Cell(75,5,"",0,0,'L');
			 $pdf->Cell(15,5,"Vr. Dcto:",0,0,'L');
			 $pdf->Cell(10,5,number_format($guia[$i]['valor_descuento'],0,',','.')."",0,0,'L');	 
		
			 $pdf->SetX(40);
			 $pdf->SetY(256);	 	
			 $pdf->Cell(90,5,"",0,0,'L');
			 $pdf->Cell(75,5,"",0,0,'L');
			 $pdf->Cell(15,5,"Otros:",0,0,'L');
			 $pdf->Cell(10,5,number_format($guia[$i]['valor_otros'],0,',','.')."",0,0,'L');
		
			 $pdf->SetX(40);
			 $pdf->SetY(259);	 	
			 $pdf->Cell(90,5,"",0,0,'L');
			 $pdf->Cell(75,5,"",0,0,'L');
			 $pdf->Cell(15,5,"V/R. TOTAL",0,0,'L');
			 $pdf->Cell(10,5,number_format($guia[$i]['valor_total'],0,',','.')."",0,0,'L');
		
			 $pdf->SetX(40);
			 $pdf->SetY(251);	 	
			 $pdf->Cell(90,5,substr($guia[$i]['observaciones'],0,80),0,0,'L');	 	 
			 $pdf->Cell(95,5,null,0,0,'L');	 
		
			 $pdf->SetX(40);
			 $pdf->SetY(254);	 	
			 $pdf->Cell(90,5,trim(substr($guia[$i]['observaciones'],79,80)),0,0,'L');	 	 
			 $pdf->Cell(95,5,null,0,0,'L');	 
				 
			 $pdf->SetX(40);
			 $pdf->SetY(258);	 	
			 $pdf->Cell(90,5,$guia[$i]['oficina_responsable'],0,0,'C');	 
			 $pdf->Cell(95,5,"Nombre legible, C.C, Firma, Sello y Fecha.",0,0,'L');	  	 	 	 
			 
			 $pdf->SetFont('Arial','B',6);		 
			 $pdf->SetX(40);
			 $pdf->SetY(263);	 	
			 $pdf->Cell(195,3,"CLIENTE",0,0,'C');	
			// fin copia 4
			 }
			if($j == 1){ $pdf->AddPage('P','Letter','mm'); $j=0;  }else{ $j++; }
		  }	 	
			
		  $pdf->Output(); //Env�a como salida del documento    
		
			//finaliza impresion sencilla un original y una copia dos guias pagina
			
		}elseif($_REQUEST['formato']=='NO'){ //Inicia Impresion Masivo
		
			$pdf=new FPDF(); // Crea un objeto de la clase fpdf()
			$pdf->AddPage('P','Letter','mm'); // Agrega una hoja al documento.
			$pdf->SetFont('Arial','B',8); //Establece la fuente a utilizar, el formato Negrita y el tama�o
		
			#Establecemos los m�rgenes izquierda, arriba y derecha:
			$pdf->SetMargins(4,5,4,5);
		
			#Establecemos el margen inferior:
			$pdf->SetAutoPageBreak(true,1);  
		
			$j=0;
			for($i = 0; $i < count($guia); $i++){	
			 
			 if($j==0){
				 $pdf->Cell(98,50,null,0,0,'');
				 $pdf->Cell(98,50,null,0,0,'');
				 
				 // Copia 1
				 $pdf->SetX(40);
				 $pdf->SetY(10);	
				 $pdf->Image($guia[$i]['logo'],4,13,10,7); 
				 $pdf->Image($guia[$i]['codbar'],74,13,25,7); 
				 $pdf->Image($guia[$i]['logo'],34,13,10,7);
				 $pdf->SetFont('Arial','',4);	 
				 $pdf->Cell(55,8,"NIT. $nit_empresa",0,0,'R');		 
				 $pdf->Ln(3);	 
				 $pdf->SetFont('Arial','B',5);	
				 $pdf->Cell(60,6,$guia[$i]['pagina_web'],0,0,'R');		 	 
				 $pdf->Ln(3);	 
				 $pdf->SetFont('Arial','B',7);		 	 	 
				 $pdf->Cell(170,12,$guia[$i]['numero_guia_bar'],0,0,'C');		 	 	 
				 $pdf->Ln(9);	

				 // Cuadro 1 Marco Izquierda	
				 $pdf->Cell(27,13,null,1,0,'C');
				 //Espacio Entre Marcos
				 $pdf->Cell(1,1,null,0,0,'C');
				 // Cuadro 1 Marco Derecha
				 $pdf->Cell(42,7,null,0,0,'C');
				  //Espacio Entre Marcos
				 $pdf->Cell(1,1,null,0,0,'C');
				 // Cuadro 2 Marco Derecha
				 $pdf->Cell(25,22,null,1,0,'C');
				 //Espacio Entre Marcos
				 $pdf->Cell(4,4,null,0,0,'C');
				 
				  // Direccion y Telefono Izquierda
				 $pdf->SetY(13);
				 $pdf->SetX(14);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, "Cra. 26 A No. 1D - 53", 0);
				 $pdf->SetY(16);
				 $pdf->SetX(14);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, "Tels.: 2012415 - 3513534", 0);
				 $pdf->SetY(19);
				 $pdf->SetX(3.5);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, ($guia[$i]['orden_despacho']), 0);


				 // Fila 1 Cuadro 1
				 $pdf->SetX(40);
				 $pdf->SetY(25);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(20, 5, "Destinatario :", 0);
				 
				 // Fila 2 Cuadro 1
				 $pdf->SetX(40);
				 $pdf->SetY(28);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,27), 0);
				 $pdf->SetX(40);
				 $pdf->SetY(30);
				 //$pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 27,27), 0);
				 $pdf->SetX(40);
				 $pdf->SetY(32);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,30), 0);
				 $pdf->SetX(40);
				 $pdf->SetY(34);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.ucfirst(strtolower($guia[$i]['destino'])), 0);
				

				 
				 // Cuadro 2
				 $pdf->SetX(40);
				 $pdf->SetY(38);	 	
				 $pdf->Cell(27,10,null,1,0,'C');
				 //Espacio Entre Marcos
				 $pdf->Cell(1,1,null,0,0,'C');
				 //$pdf->Cell(42,7,null,1,0,'C');
				 
				 // Cuadro 3
				 $pdf->SetY(47);
				 $pdf->SetX(75);	 	
				 $pdf->Cell(25,14,null,1,0,'C');
				 $pdf->SetX(40);
				 $pdf->SetY(48);	 	
				 $pdf->Cell(27,13,null,1,0,'C');
				 $pdf->SetX(40);
				 $pdf->SetY(48);
				 
				  
				 // Fila 1 Cuadro 3
				 $pdf->SetX(40);
				 $pdf->SetY(48);
				 $pdf->Cell(20, 3, "Remitente :", 0); 	 	 	 
				 
				 // Fila 2 Cuadro 3
				 $pdf->SetX(39);
				 $pdf->SetY(51);
				 $pdf->Cell(18, 3, substr(utf8_decode($guia[$i]['remitente']), 0,23), 0);
				 $pdf->SetX(39);
				 $pdf->SetY(53);
				 $pdf->Cell(18, 3, substr(utf8_decode($guia[$i]['remitente']), 23,22), 0);
				 $pdf->SetX(39);
				 $pdf->SetY(55);
				 $pdf->Cell(18, 3, substr(utf8_decode(str_replace("OFICINA","OFI",$guia[$i]['direccion_remitente'])), 0,30), 0);
				 $pdf->SetX(39);				 
				 $pdf->SetY(57);
				 $pdf->Cell(18, 3, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_remitente']), 0,22).' '.ucfirst(strtolower($guia[$i]['origen'])), 0);
				 

				 // Cuadro 1 Marco Derecha	

				 // Fila 1 Cuadro derecho joh
				
				 $pdf->SetY(26);
				 $pdf->SetX(76);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(20, 3, "Destinatario", 1);
				 $pdf->SetY(28);				 
				 $pdf->SetX(74.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,27), 0);
				 $pdf->SetY(30);				 
				 $pdf->SetX(74.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,30), 0);
				 $pdf->SetY(32);				 
				 $pdf->SetX(74.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 30,30), 0);
				 $pdf->SetY(34);
				 $pdf->SetX(74.5);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22));
				 $pdf->SetY(36);
				 $pdf->SetX(74.5);
				 $pdf->Cell(18, 5, $guia[$i]['destino'], 0);
				 

				 $pdf->SetY(51);				 
				 $pdf->SetX(74.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['remitente']), 0,20), 0);
				 $pdf->SetY(53);				 
				 $pdf->SetX(74.5);
				 $pdf->Cell(18, 5, substr(utf8_decode(trim($guia[$i]['remitente'])), 20,18), 0);
				 $pdf->SetY(55);				 
				 $pdf->SetX(74.5);
				 $pdf->Cell(18, 5, substr(utf8_decode(trim(str_replace("OFICINA","OFI",$guia[$i]['direccion_remitente']))), 0,30), 0);
				 $pdf->SetY(57);
				 $pdf->SetX(75);				 				 
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_remitente']), 0,22).' '.ucfirst(strtolower($guia[$i]['origen'])), 0);
				 

				 // Fila 2 Cuadro derecho joh
				 
				 $pdf->SetY(42);
				 $pdf->SetX(75);
				 $pdf->Cell(25, 5," ", 1);
				 $pdf->SetY(42);
				 $pdf->SetX(74.5);
				 $pdf->SetFont('Arial','',4);
				 $pdf->Cell(18,2, 'PESO '.substr(utf8_decode($guia[$i]['peso']).' '.$guia[$i]['medida'], 0,20),'',0);
				 $pdf->SetY(44);
				 $pdf->SetX(74.5);
				 $pdf->SetFont('Arial','',4);
				 $pdf->Cell(18,2, 'VR. ENVIO '.number_format($guia[$i]['valor_total'],0,',','.'),0,0);
					
				
				 $pdf->SetY(48);
				 $pdf->SetX(76);
				 $pdf->Cell(20, 3, "Remitente", 1);
				 
				 //CUADRO DERECHO FECHA HORA CODIGO MENSAJERO
 				 $pdf->SetY(38);	 	
				 $pdf->SetX(4);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(17,2,'FECHA',1);
 				 $pdf->SetY(38);	 	
				 $pdf->SetX(21);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,2,'HORA',1);

 				 $pdf->SetY(40);	 	
				 $pdf->SetX(4);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(17,4,'',1);
 				 $pdf->SetY(40);	 	
				 $pdf->SetX(21);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,4,'',1);
 				 $pdf->SetY(43);	 	
				 $pdf->SetX(3);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,4,'COD. MENS',0);

				 //PARTE DE CENTRO
 				 $pdf->SetY(25);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,36,'',1);

 				 $pdf->SetY(25);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,9,'',1);


 				 $pdf->SetY(26);	 	
				 $pdf->SetX(35);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(12,2,'ENT.ALMACEN',1);

 				 $pdf->SetY(26);	 	
				 $pdf->SetX(47);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(9,2,'REMISION',1);

 				 $pdf->SetY(26);
				 $pdf->SetX(56);
				 $pdf->SetFont('Arial','',4);
				 $pdf->Cell(6,2,'ZONA',1);
 				 $pdf->SetY(28);
				 $pdf->SetX(56);
				 $pdf->SetFont('Arial','',4);
				 $pdf->Cell(6,6,utf8_decode($guia[$i]['zona']),1);

 				 $pdf->SetY(26);	 	
				 $pdf->SetX(62);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(12,2,'CONSECUTIVO',1);

 				 $pdf->SetY(34);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,8,'',1);


 				 $pdf->SetY(35);	 	
				 $pdf->SetX(38);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(11,2,'MENSAJERO',1);

 				 $pdf->SetY(35);	 	
				 $pdf->SetX(51);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,2,'FECHA ENT.',1);

 				 $pdf->SetY(35);	 	
				 $pdf->SetX(63);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(9,2,'HORA ENT.',1);


 				 $pdf->SetY(58);	 	
				 $pdf->SetX(34);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(14,2,'RECIBIDO POR',1);
				 
				 $pdf->SetY(59);	 	
				 $pdf->SetX(58);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Impreso '. date("Y-m-d"),0);
				 
				 $pdf->SetY(42);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,9,'',1);

 				 $pdf->SetY(42);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(8,2,'DEVOL',1);

 				 $pdf->SetY(45);	 	
				 $pdf->SetX(34);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(14,2,'DESCONOCIDO',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(11,2,'REHUSADO',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(10,2,'NO RESIDE',0);

 				 $pdf->SetY(48);	 	
				 $pdf->SetX(34);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(14,2,'DIR INCOMPLETA',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(11,2,'DIR ERRADA',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(10,2,'OTRO',0);

 				 $pdf->SetY(17);	 	
				 $pdf->SetX(45);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Res. MINTIC No 4304 de 2013',0);
				 					 
				 $pdf->SetY(19);	 	
				 $pdf->SetX(45);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,($guia[$i]['tipo_servicio']),0);
				 if(!empty($guia[$i]['orden_despacho'])){
					 $pdf->SetY(21);	 	
					 $pdf->SetX(45);
					 $pdf->Cell(14,2,'Doc. Cliente: '.$guia[$i]['orden_despacho'],0);
				 }
				 //FIN PARTE DE CENTRO

 				 //FIN CUADRO DERECHO FECHA HORA CODIGO MENSAJERO
				 // Fin Fila 1 Columna 1
			 }
			 if($j==1){
			 
				 //Lado Derecho
				 $pdf->SetX(118);
				 $pdf->SetY(10);	
				 $pdf->Image($guia[$i]['logo'],113,13,10,7); 
				 $pdf->Image($guia[$i]['codbar'],183,13,25,7); 
				 $pdf->Image($guia[$i]['logo'],143,13,10,7);
				 $pdf->SetFont('Arial','',4);	 
				 $pdf->Cell(164,8,"NIT. $nit_empresa",0,0,'R');		 
				 $pdf->Ln(3);	 
				 $pdf->SetFont('Arial','B',5);	
				 $pdf->Cell(169,6,$guia[$i]['pagina_web'],0,0,'R');		 	 
				 $pdf->Ln(3);	 
				 $pdf->SetFont('Arial','B',7);		 	 	 
				 $pdf->Cell(385,12,$guia[$i]['numero_guia_bar'],0,0,'C');		 	 	 
				 $pdf->Ln(9);

				 // Fila 1 Columna 2
				 $pdf->SetY(25);	 	
				 $pdf->SetX(113);
				 $pdf->Cell(27,13,null,1,0,'C');
				 $pdf->Cell(1,1,null,0,0,'C');
				 
				 // Cuadro 1 Marco Derecha
				 $pdf->Cell(42,7,null,0,0,'C');
				  //Espacio Entre Marcos
				 $pdf->Cell(1,1,null,0,0,'C');
				 // Cuadro 1 Marco Derecha
				 $pdf->Cell(25,22,null,1,0,'C');
				 //Espacio Entre Marcos
				 $pdf->Cell(4,4,null,0,0,'C');
				 
				 // Direccion y Telefono Izquierda
				 $pdf->SetY(13);
				 $pdf->SetX(123);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, "Cra. 26 A No. 1D - 53", 0);
				 $pdf->SetY(16);
				 $pdf->SetX(123);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, "Tels.: 2012415 - 3513534", 0);
				 $pdf->SetY(19);
				 $pdf->SetX(112.5);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, ($guia[$i]['orden_despacho']), 0);
				 
				 // Linea 1
				 $pdf->SetY(25);
				 $pdf->SetX(113);
				  $pdf->SetFont('Arial','',5);
				 $pdf->Cell(20, 5, "Destinatario :", 0);		 
				 
				 // Linea 2
				 $pdf->SetY(28);
				 $pdf->SetX(112.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,27), 0);
				 $pdf->SetY(30);
				 $pdf->SetX(112.5);
				 //$pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 27,27), 0);
				 $pdf->SetY(32);
				 $pdf->SetX(112.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,30), 0);
				 $pdf->SetY(34);
				 $pdf->SetX(112.5);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.ucfirst(strtolower($guia[$i]['destino'])), 0);
				 
				 // Fin Cuadro 1
				 // Cuadro 2
				 $pdf->SetY(38);
				 $pdf->SetX(113);	 	
				 $pdf->Cell(27,10,null,1,0,'C');
				 // Fin Cuadro 2
				 //Espacio Entre Columnas
				 $pdf->Cell(1,1,null,0,0,'C');
				 // Cuadro 3
				 $pdf->Cell(42,7,null,0,0,'C');
				 $pdf->SetY(48);
				 $pdf->SetX(113);
				 $pdf->Cell(27,13,null,1,0,'C');
				 $pdf->SetY(47);
				 $pdf->SetX(184);	 	
				 $pdf->Cell(25,14,null,1,0,'C');
				 // Linea 1
				 $pdf->SetY(48);
				 $pdf->SetX(113);
				 $pdf->Cell(20, 3, "Remitente :", 0);
				  // Linea 2 
				 $pdf->SetY(52);
				 $pdf->SetX(113);
				 $pdf->Cell(18, 3, substr(utf8_decode($guia[$i]['remitente']), 0,23), 0);
				 $pdf->SetY(54);
				 $pdf->SetX(113);
				 $pdf->Cell(18, 3, substr(utf8_decode($guia[$i]['remitente']), 23,22), 0);
				 $pdf->SetY(56);
				 $pdf->SetX(113);
				 $pdf->Cell(18, 3, substr(utf8_decode(str_replace("OFICINA","OFI",$guia[$i]['direccion_remitente'])), 0,30), 0);
				 $pdf->SetY(58);
				 $pdf->SetX(113);				 
				 $pdf->Cell(18, 3, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_remitente']), 0,22).' '.ucfirst(strtolower($guia[$i]['origen'])), 0);
				 
				 
				 // Fin Cuadro 3
				 
				// Fin Fila 1 Columna 2
				 $pdf->SetY(26);
				 $pdf->SetX(185);
				 $pdf->Cell(20, 3, "Destinatario", 1);
				 $pdf->SetY(28);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,27), 0);
				 $pdf->SetY(30);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,30), 0);
				 $pdf->SetY(32);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 30,30), 0);
				 $pdf->SetY(34);
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22), 0);
				 $pdf->SetY(36);
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, $guia[$i]['destino'], 0);
				 


				 $pdf->SetY(51);				 
				 $pdf->SetX(184);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['remitente']), 0,20), 0);
				 $pdf->SetY(53);				 
				 $pdf->SetX(184);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['remitente']), 20,18), 0);
				 $pdf->SetY(55);				 
				 $pdf->SetX(184);
				 $pdf->Cell(18, 5, substr(utf8_decode(str_replace("OFICINA","OFI",$guia[$i]['direccion_remitente'])), 0,30), 0);
				 $pdf->SetY(57);
				 $pdf->SetX(184);				 				 
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_remitente']), 0,22).' '.ucfirst(strtolower($guia[$i]['origen'])), 0);
				 

				 // Fila 2 Cuadro derecho joh
				 
				 $pdf->SetY(42);
				 $pdf->SetX(184);
				 $pdf->Cell(25, 5," ", 1);
				 $pdf->SetY(42);
				 $pdf->SetX(183.5);
				 $pdf->SetFont('Arial','',4);
				 $pdf->Cell(18,2, 'PESO '.substr(utf8_decode($guia[$i]['peso']).' '.$guia[$i]['medida'], 0,20),'',0);
				 $pdf->SetY(44);
				 $pdf->SetX(183.5);
				 $pdf->SetFont('Arial','',4);
				 $pdf->Cell(18,2, 'VR. ENVIO '.number_format($guia[$i]['valor_total'],0,',','.'),0,0);
				 
				 $pdf->SetY(48);
				 $pdf->SetX(185);
				 $pdf->Cell(20, 3, "Remitente", 1);

				 //CUADRO DERECHO FECHA HORA CODIGO MENSAJERO
 				 $pdf->SetY(38);	 	
				 $pdf->SetX(113);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(17,2,'FECHA',1);
 				 $pdf->SetY(38);	 	
				 $pdf->SetX(130);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,2,'HORA',1);

 				 $pdf->SetY(40);	 	
				 $pdf->SetX(113);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(17,4,'',1);
 				 $pdf->SetY(40);	 	
				 $pdf->SetX(130);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,4,'',1);
 				 $pdf->SetY(43);	 	
				 $pdf->SetX(112);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,4,'COD. MENS',0);
				 
				 //PARTE DE CENTRO
 				 $pdf->SetY(25);	 	
				 $pdf->SetX(142);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,36,'',1);

 				 $pdf->SetY(25);	 	
				 $pdf->SetX(142);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,9,'',1);


 				 $pdf->SetY(26);	 	
				 $pdf->SetX(144);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(12,2,'ENT.ALMACEN',1);

 				 $pdf->SetY(26);	 	
				 $pdf->SetX(156);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(9,2,'REMISION',1);

 				 $pdf->SetY(26);	 	
				 $pdf->SetX(165);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(6,2,'ZONA',1);
 				 $pdf->SetY(28);	 	
				 $pdf->SetX(165);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(6,6,utf8_decode($guia[$i]['zona']),1);

 				 $pdf->SetY(26);	 	
				 $pdf->SetX(171);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(12,2,'CONSECUTIVO',1);

 				 $pdf->SetY(34);	 	
				 $pdf->SetX(142);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,8,'',1);


 				 $pdf->SetY(35);	 	
				 $pdf->SetX(147);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(11,2,'MENSAJERO',1);

 				 $pdf->SetY(35);	 	
				 $pdf->SetX(160);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,2,'FECHA ENT.',1);

 				 $pdf->SetY(35);	 	
				 $pdf->SetX(172);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(9,2,'HORA ENT.',1);


 				 $pdf->SetY(58);	 	
				 $pdf->SetX(143);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(14,2,'RECIBIDO POR',1);
				 
				 $pdf->SetY(59);	 	
				 $pdf->SetX(167);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Impreso '. date("Y-m-d"),0);
				 
				 $pdf->SetY(42);	 	
				 $pdf->SetX(142);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,9,'',1);

 				 $pdf->SetY(42);	 	
				 $pdf->SetX(142);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(8,2,'DEVOL',1);

 				 $pdf->SetY(45);	 	
				 $pdf->SetX(143);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(14,2,'DESCONOCIDO',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(11,2,'REHUSADO',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(10,2,'NO RESIDE',0);

 				 $pdf->SetY(48);	 	
				 $pdf->SetX(143);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(14,2,'DIR INCOMPLETA',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(11,2,'DIR ERRADA',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(10,2,'OTRO',0);

 				 $pdf->SetY(17);	 	
				 $pdf->SetX(154);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Res. MINTIC No 4304 de 2013',0);
				 
				 $pdf->SetY(19);	 	
				 $pdf->SetX(154);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,($guia[$i]['tipo_servicio']),0);
				 if(!empty($guia[$i]['orden_despacho'])){
					 $pdf->SetY(21);	 	
					 $pdf->SetX(154);
					 $pdf->Cell(14,2,'Doc. Cliente: '.$guia[$i]['orden_despacho'],0);
				 }
				 
				 //FIN PARTE DE CENTRO
				 
 				 //FIN CUADRO DERECHO FECHA HORA CODIGO MENSAJERO

				 
				  // Fila 1 Cuadro derecho joh

			 }
			
			 // Fila 2 Columna 1
			 if($j==2){
			  	 $pdf->SetX(115);
				 $pdf->SetY(66);	
 
				 $pdf->SetFont('Arial','B',5); 	 
				 $pdf->Image($guia[$i]['logo'],4,64,10,7); 
				 $pdf->Image($guia[$i]['codbar'],74,64,25,7); 
				 $pdf->Image($guia[$i]['logo'],34,64,10,7);		 	 
				 $pdf->SetFont('Arial','',4);	 
				 $pdf->Cell(55,-2,"NIT. $nit_empresa",0,0,'R');	
				 $pdf->Ln(3);
				 $pdf->SetFont('Arial','B',5);	 
				 $pdf->Cell(60,-4,$guia[$i]['pagina_web'],0,0,'R');	
				 $pdf->Ln(3);	 
				 $pdf->SetFont('Arial','B',7);		 	 	 
				 $pdf->Cell(170,2,$guia[$i]['numero_guia_bar'],0,0,'C');		 	 	 
				 $pdf->Ln(4);	
				 
				 // Cuadro 1 Marco Izquierda	
				 $pdf->Cell(27,13,null,1,0,'C');
				 //Espacio Entre Marcos
				 $pdf->Cell(1,1,null,0,0,'C');
				 // Cuadro 1 Marco Derecha
				 $pdf->Cell(42,7,null,0,0,'C');
				  //Espacio Entre Marcos
				 $pdf->Cell(1,1,null,0,0,'C');
				 // Cuadro 1 Marco Derecha
				 $pdf->Cell(25,22,null,1,0,'C');
				 //Espacio Entre Marcos
				 $pdf->Cell(4,4,null,0,0,'C');
				 
				 // Direccion y Telefono Izquierda
				 $pdf->SetY(64);
				 $pdf->SetX(14);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, "Cra. 26 A No. 1D - 53", 0);
				 $pdf->SetY(67);
				 $pdf->SetX(14);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, "Tels.: 2012415 - 3513534", 0);
 				 $pdf->SetY(70);
				 $pdf->SetX(3.5);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, ($guia[$i]['orden_despacho']), 0);

					 
				 // Fila 1 Cuadro 1
				 $pdf->SetX(84);
				 $pdf->SetY(76);
				 $pdf->SetFont('Arial','',5);	 
				 $pdf->Cell(20, 5, "Destinatario :", 0);		 
				 
				 // Fila 2 Cuadro 1
				 $pdf->SetX(84);
				 $pdf->SetY(79);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,27), 0);
				 $pdf->SetX(84);
				 $pdf->SetY(81);
				 //$pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 27,27), 0); 
				 $pdf->SetX(87);
				 $pdf->SetY(83);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,30), 0); 
				 $pdf->SetX(87);
				 $pdf->SetY(85);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,30).' '.ucfirst(strtolower($guia[$i]['destino'])), 0); 
				 
				 // Fila 1 Cuadro 3
				 $pdf->SetX(40);
				 $pdf->SetY(100);
				 $pdf->Cell(20, 3, "Remitente :", 0);
				  // Fila 2 Cuadro 3
				 $pdf->SetX(40);
				 $pdf->SetY(103);
				 $pdf->Cell(18, 3, substr(utf8_decode($guia[$i]['remitente']), 0,23), 0);
				 $pdf->SetX(40);
				 $pdf->SetY(105);
				 $pdf->Cell(18, 3, substr(utf8_decode($guia[$i]['remitente']), 23,22), 0);
				 $pdf->SetX(40);
				 $pdf->SetY(107);
				 $pdf->Cell(18, 3, substr(utf8_decode(str_replace("OFICINA","OFI",$guia[$i]['direccion_remitente'])), 0,30), 0);
				 $pdf->SetX(40);
				 $pdf->SetY(109);
				 $pdf->Cell(18, 3, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_remitente']), 0,30).' '.ucfirst(strtolower($guia[$i]['origen'])), 0);

				// Cuadro 2
				$pdf->SetX(70);
				$pdf->SetY(89);	 	
				$pdf->Cell(27,10,null,1,0,'C');
				
				//Espacio Entre Marcos
				$pdf->Cell(1,1,null,0,0,'C');
				
				// Cuadro 3
				$pdf->Cell(42,7,null,0,0,'C');
				$pdf->SetX(70);
				$pdf->SetY(99);
				$pdf->Cell(27,13,null,1,0,'C');
				$pdf->SetY(98);
				$pdf->SetX(75);	 	
				$pdf->Cell(25,14,null,1,0,'C');
				

				 // Fila 1 Cuadro derecho joh
				
				 $pdf->SetY(77);
				 $pdf->SetX(76);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(20, 3, "Destinatario", 1);
				 $pdf->SetY(79);				 
				 $pdf->SetX(75);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,27), 0);
				 $pdf->SetY(81);				 
				 $pdf->SetX(75);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,30), 0);
				 $pdf->SetY(83);				 
				 $pdf->SetX(75);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 30,30), 0);
				 $pdf->SetY(85);				 
				 $pdf->SetX(75);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,30), 0);
				 $pdf->SetY(87);				 
				 $pdf->SetX(75);
				 $pdf->Cell(18, 5, $guia[$i]['destino'], 0);

				 $pdf->SetY(102);				 
				 $pdf->SetX(75);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['remitente']), 0,20), 0);
				 $pdf->SetY(104);				 
				 $pdf->SetX(75);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['remitente']), 20,18), 0);
				 $pdf->SetY(106);				 
				 $pdf->SetX(75);
				 $pdf->Cell(18, 5, substr(utf8_decode(str_replace("OFICINA","OFI",$guia[$i]['direccion_remitente'])), 0,30), 0);
				 $pdf->SetY(108);				 
				 $pdf->SetX(75);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_remitente']), 0,30).' '.ucfirst(strtolower($guia[$i]['origen'])), 0);

				 // Fila 2 Cuadro derecho joh
				 
				 $pdf->SetY(93);
				 $pdf->SetX(75);
				 $pdf->Cell(25, 5," ", 1);
				 $pdf->SetY(93);
				 $pdf->SetX(74.5);
				 $pdf->SetFont('Arial','',4);
				 $pdf->Cell(18,2, 'PESO '.substr(utf8_decode($guia[$i]['peso']).' '.$guia[$i]['medida'], 0,20),'',0);
				 $pdf->SetY(95);
				 $pdf->SetX(74.5);
				 $pdf->SetFont('Arial','',4);
				 $pdf->Cell(18,2, 'VR. ENVIO '.number_format($guia[$i]['valor_total'],0,',','.'),0,0);
				
				 $pdf->SetY(99);
				 $pdf->SetX(76);
				 $pdf->Cell(20, 3, "Remitente", 1);

				 // Fin Fila 1 Columna 1

				 //CUADRO DERECHO FECHA HORA CODIGO MENSAJERO
 				 $pdf->SetY(89);	 	
				 $pdf->SetX(4);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(17,2,'FECHA',1);
 				 $pdf->SetY(89);	 	
				 $pdf->SetX(21);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,2,'HORA',1);

 				 $pdf->SetY(91);	 	
				 $pdf->SetX(4);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(17,4,'',1);
 				 $pdf->SetY(91);	 	
				 $pdf->SetX(21);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,4,'',1);
 				 $pdf->SetY(94);	 	
				 $pdf->SetX(3);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,4,'COD. MENS',0);

				 //CUADRO DERECHO FECHA HORA CODIGO MENSAJERO


				 //PARTE DE CENTRO
 				 $pdf->SetY(76);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,36,'',1);

 				 $pdf->SetY(76);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,9,'',1);


 				 $pdf->SetY(77);	 	
				 $pdf->SetX(35);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(12,2,'ENT.ALMACEN',1);

 				 $pdf->SetY(77);	 	
				 $pdf->SetX(47);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(9,2,'REMISION',1);

 				 $pdf->SetY(77);	 	
				 $pdf->SetX(56);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(6,2,'ZONA',1);
 				 $pdf->SetY(79);	 	
				 $pdf->SetX(56);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(6,6,utf8_decode($guia[$i]['zona']),1);

 				 $pdf->SetY(77);	 	
				 $pdf->SetX(62);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(12,2,'CONSECUTIVO',1);

 				 $pdf->SetY(85);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,8,'',1);


 				 $pdf->SetY(86);	 	
				 $pdf->SetX(38);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(11,2,'MENSAJERO',1);

 				 $pdf->SetY(86);	 	
				 $pdf->SetX(51);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,2,'FECHA ENT.',1);

 				 $pdf->SetY(86);	 	
				 $pdf->SetX(63);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(9,2,'HORA ENT.',1);


 				 $pdf->SetY(109);	 	
				 $pdf->SetX(34);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(14,2,'RECIBIDO POR',1);
				 
				 $pdf->SetY(110);	 	
				 $pdf->SetX(58);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Impreso '. date("Y-m-d"),0);
				 
				 $pdf->SetY(93);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,9,'',1);

 				 $pdf->SetY(93);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(8,2,'DEVOL',1);

 				 $pdf->SetY(96);	 	
				 $pdf->SetX(34);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(14,2,'DESCONOCIDO',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(11,2,'REHUSADO',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(10,2,'NO RESIDE',0);

 				 $pdf->SetY(99);	 	
				 $pdf->SetX(34);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(14,2,'DIR INCOMPLETA',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(11,2,'DIR ERRADA',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(10,2,'OTRO',0);

 				 $pdf->SetY(68);	 	
				 $pdf->SetX(45);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Res. MINTIC No 4304 de 2013',0);
				 
				 $pdf->SetY(70);	 	
				 $pdf->SetX(45);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,($guia[$i]['tipo_servicio']),0);
				 if(!empty($guia[$i]['orden_despacho'])){
					 $pdf->SetY(72);	 	
					 $pdf->SetX(45);
					 $pdf->Cell(14,2,'Doc. Cliente: '.$guia[$i]['orden_despacho'],0);
				 }
				 
				 //FIN PARTE DE CENTRO
 				 //FIN CUADRO DERECHO FECHA HORA CODIGO MENSAJERO

				// Fin Fila 2 Columna 1
				 
			 }
			 
			 if($j==3){//aca
				 //Lado Derecho
				 $pdf->SetX(123);
				 $pdf->SetY(57);
				 $pdf->Image($guia[$i]['logo'],113,64,10,7); 
				 $pdf->Image($guia[$i]['codbar'],182,64,25,7); 
				 $pdf->Image($guia[$i]['logo'],143,64,10,7);
				 $pdf->SetFont('Arial','B',4);	 
				 $pdf->Cell(164,16,"NIT. $nit_empresa",0,0,'R');		 
				 $pdf->Ln(3);
				 $pdf->SetFont('Arial','B',5);	
				 $pdf->Cell(169,14,$guia[$i]['pagina_web'],0,0,'R');		 	 
				 $pdf->Ln(3);	 
				 $pdf->SetFont('Arial','B',7);		 	 	 
				 $pdf->Cell(383,19,$guia[$i]['numero_guia_bar'],0,0,'C');		 	 	 				 	 	 
				 $pdf->Ln(13);	 

				// Fila 2 Columna 2
				$pdf->SetY(76);	 	
				$pdf->SetX(113);
				$pdf->Cell(27,13,null,1,0,'C');
				$pdf->Cell(1,1,null,0,0,'C');
				
				// Cuadro 1 Marco Derecha
				$pdf->Cell(42,7,null,0,0,'C');
				//Espacio Entre Marcos
				$pdf->Cell(1,1,null,0,0,'C');
				// Cuadro 1 Marco Derecha
				$pdf->Cell(25,22,null,1,0,'C');
				//Espacio Entre Marcos
				$pdf->Cell(4,4,null,0,0,'C');
				
				// Direccion y Telefono Izquierda
				 $pdf->SetY(64);
				 $pdf->SetX(123);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, "Cra. 26 A No. 1D - 53", 0);
				 $pdf->SetY(67);
				 $pdf->SetX(123);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, "Tels.: 2012415 - 3513534", 0);
				 $pdf->SetY(70);
				 $pdf->SetX(112.5);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, ($guia[$i]['orden_despacho']), 0);

				 // Linea 1
				 $pdf->SetY(76);
				 $pdf->SetX(113);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(20, 5, "Destinatario :", 0);		 
				 
				 // Linea 2
				 $pdf->SetY(79);
				 $pdf->SetX(113);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,27), 0);
				 $pdf->SetY(81);
				 $pdf->SetX(113);
				 //$pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 27,27), 0);
				 $pdf->SetY(83);
				 $pdf->SetX(113);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,30), 0);
				 $pdf->SetY(85);
				 $pdf->SetX(113);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,30).' '.ucfirst(strtolower($guia[$i]['destino'])), 0);
				 
				// Fin Cuadro 1
				// Cuadro 2
				$pdf->SetY(89);
				$pdf->SetX(113);	 	
				$pdf->Cell(27,10,null,1,0,'C');
				// Fin Cuadro 2
				//Espacio Entre Columnas
				$pdf->Cell(1,1,null,0,0,'C');
				// Cuadro 3
				$pdf->Cell(42,7,null,0,0,'C');
				$pdf->SetY(99);
				$pdf->SetX(113);
				$pdf->Cell(27,13,null,1,0,'C');
				$pdf->SetY(98);
				$pdf->SetX(184);	 	
				$pdf->Cell(25,14,null,1,0,'C');
				 // Linea 1
				 $pdf->SetY(99);
				 $pdf->SetX(113);
				 $pdf->Cell(20, 3, "Remitente :", 0);
				  // Linea 2 
				 $pdf->SetY(103);
				 $pdf->SetX(113);
				 $pdf->Cell(18, 3, substr(utf8_decode($guia[$i]['remitente']), 0,23), 0);
				 $pdf->SetY(105);
				 $pdf->SetX(113);
				 $pdf->Cell(18, 3, substr(utf8_decode($guia[$i]['remitente']), 23,22), 0);
				 $pdf->SetY(107);
				 $pdf->SetX(113);
				 $pdf->Cell(18, 3, substr(utf8_decode(str_replace("OFICINA","OFI",$guia[$i]['direccion_remitente'])), 0,30), 0);
				 $pdf->SetY(109);
				 $pdf->SetX(113);
				 $pdf->Cell(18, 3, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_remitente']), 0,30).' '.ucfirst(strtolower($guia[$i]['origen'])), 0);
				 
				// Fin Cuadro 3


				// Fin Fila 1 Columna 2
				 $pdf->SetY(77);
				 $pdf->SetX(185);
				 $pdf->Cell(20, 3, "Destinatario", 1);
				 $pdf->SetY(79);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,27), 0);
				 $pdf->SetY(81);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,30), 0);
				 $pdf->SetY(83);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 30,30), 0);
				 $pdf->SetY(85);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,30), 0);
				 $pdf->SetY(87);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, $guia[$i]['destino'], 0);


				 $pdf->SetY(102);				 
				 $pdf->SetX(184);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['remitente']), 0,20), 0);
				 $pdf->SetY(104);				 
				 $pdf->SetX(184);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['remitente']), 20,18), 0);
				 $pdf->SetY(106);				 
				 $pdf->SetX(184);
				 $pdf->Cell(18, 5, substr(utf8_decode(str_replace("OFICINA","OFI",$guia[$i]['direccion_remitente'])), 0,30), 0);
				 $pdf->SetY(108);				 
				 $pdf->SetX(184);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_remitente']), 0,30).' '.ucfirst(strtolower($guia[$i]['origen'])), 0);

				 // Fila 2 Cuadro derecho joh
				 
				 $pdf->SetY(93);
				 $pdf->SetX(184);
				 $pdf->Cell(25, 5," ", 1);
				 $pdf->SetY(93);
				 $pdf->SetX(183.5);
				 $pdf->SetFont('Arial','',4);
				 $pdf->Cell(18,2, 'PESO '.substr(utf8_decode($guia[$i]['peso']).' '.$guia[$i]['medida'], 0,20),'',0);
				 $pdf->SetY(95);
				 $pdf->SetX(183.5);
				 $pdf->SetFont('Arial','',4);
				 $pdf->Cell(18,2, 'VR. ENVIO '.number_format($guia[$i]['valor_total'],0,',','.'),0,0);
				 
				 $pdf->SetY(99);
				 $pdf->SetX(185);
				 $pdf->Cell(20, 3, "Remitente", 1);

				 //CUADRO DERECHO FECHA HORA CODIGO MENSAJERO
 				 $pdf->SetY(89);	 	
				 $pdf->SetX(113);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(17,2,'FECHA',1);
 				 $pdf->SetY(89);	 	
				 $pdf->SetX(130);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,2,'HORA',1);

 				 $pdf->SetY(91);	 	
				 $pdf->SetX(113);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(17,4,'',1);
 				 $pdf->SetY(91);	 	
				 $pdf->SetX(130);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,4,'',1);
 				 $pdf->SetY(94);	 	
				 $pdf->SetX(112);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,4,'COD. MENS',0);


				 //PARTE DE CENTRO
 				 $pdf->SetY(76);	 	
				 $pdf->SetX(142);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,36,'',1);

 				 $pdf->SetY(76);	 	
				 $pdf->SetX(142);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,9,'',1);


 				 $pdf->SetY(77);	 	
				 $pdf->SetX(144);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(12,2,'ENT.ALMACEN',1);

 				 $pdf->SetY(77);	 	
				 $pdf->SetX(156);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(9,2,'REMISION',1);

 				 $pdf->SetY(77);	 	
				 $pdf->SetX(165);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(6,2,'ZONA',1);
 				 $pdf->SetY(79);	 	
				 $pdf->SetX(165);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(6,6,utf8_decode($guia[$i]['zona']),1);

 				 $pdf->SetY(77);	 	
				 $pdf->SetX(171);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(12,2,'CONSECUTIVO',1);

 				 $pdf->SetY(85);	 	
				 $pdf->SetX(142);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,8,'',1);


 				 $pdf->SetY(86);	 	
				 $pdf->SetX(147);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(11,2,'MENSAJERO',1);

 				 $pdf->SetY(86);	 	
				 $pdf->SetX(160);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,2,'FECHA ENT.',1);

 				 $pdf->SetY(86);	 	
				 $pdf->SetX(172);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(9,2,'HORA ENT.',1);


 				 $pdf->SetY(109);	 	
				 $pdf->SetX(143);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(14,2,'RECIBIDO POR',1);
				 
				 $pdf->SetY(110);	 	
				 $pdf->SetX(167);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Impreso '. date("Y-m-d"),0);
				 
				 $pdf->SetY(93);	 	
				 $pdf->SetX(142);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,9,'',1);

 				 $pdf->SetY(93);	 	
				 $pdf->SetX(142);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(8,2,'DEVOL',1);

 				 $pdf->SetY(96);	 	
				 $pdf->SetX(143);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(14,2,'DESCONOCIDO',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(11,2,'REHUSADO',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(10,2,'NO RESIDE',0);

 				 $pdf->SetY(99);	 	
				 $pdf->SetX(143);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(14,2,'DIR INCOMPLETA',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(11,2,'DIR ERRADA',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(10,2,'OTRO',0);

 				 $pdf->SetY(68);	 	
				 $pdf->SetX(154);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Res. MINTIC No 4304 de 2013',0);
				 
				 $pdf->SetY(70);	 	
				 $pdf->SetX(154);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,($guia[$i]['tipo_servicio']),0);
				 
				 if(!empty($guia[$i]['orden_despacho'])){
					 $pdf->SetY(72);	 	
					 $pdf->SetX(154);
					 $pdf->Cell(14,2,'Doc. Cliente: '.$guia[$i]['orden_despacho'],0);
				 }
				 //FIN PARTE DE CENTRO

 				 //FIN CUADRO DERECHO FECHA HORA CODIGO MENSAJERO


				// Fin Fila 2 Columna 2

			}
			if($j==4){

				 // Fila 3 Columna 1
	
			  	 $pdf->SetX(115);
				 $pdf->SetY(103);	
				 $pdf->SetFont('Arial','B',5); 	 
				 $pdf->Image($guia[$i]['logo'],4,115,10,7); 
				 $pdf->Image($guia[$i]['codbar'],74,115,25,7); 
				 $pdf->Image($guia[$i]['logo'],34,115,10,7);		 	 
				 $pdf->SetFont('Arial','',4);	 
				 $pdf->Cell(55,26,"NIT. $nit_empresa",0,0,'R');	
				 $pdf->Ln(3);
				 $pdf->SetFont('Arial','B',5);	 
				 $pdf->Cell(60,24,$guia[$i]['pagina_web'],0,0,'R');	
				 $pdf->Ln(3);	 
				 $pdf->SetFont('Arial','B',7);		 	 	 
				 $pdf->Cell(170,30,$guia[$i]['numero_guia_bar'],0,0,'C');		 	 	 
				 $pdf->Ln(6);	
				 $pdf->SetY(127);
				 // Cuadro 1 Marco Izquierda	
				 $pdf->Cell(27,13,null,1,0,'C');
				 //Espacio Entre Marcos
				 $pdf->Cell(1,1,null,0,0,'C');
				 // Cuadro 1 Marco Derecha
				 $pdf->Cell(42,7,null,0,0,'C');
				  //Espacio Entre Marcos
				 $pdf->Cell(1,1,null,0,0,'C');
				 // Cuadro 1 Marco Derecha
				 $pdf->Cell(25,22,null,1,0,'C');
				 //Espacio Entre Marcos
				 $pdf->Cell(4,4,null,0,0,'C');
				 
				 // Direccion y Telefono Izquierda
				 $pdf->SetY(115);
				 $pdf->SetX(14);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, "Cra. 26 A No. 1D - 53", 0);
				 $pdf->SetY(118);
				 $pdf->SetX(14);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, "Tels.: 2012415 - 3513534", 0);
				 $pdf->SetY(121);
				 $pdf->SetX(3.5);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, ($guia[$i]['orden_despacho']), 0);
	 
				 // Fila 1 Cuadro 1
				 $pdf->SetX(84);
				 $pdf->SetY(127);
				  $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(20, 5, "Destinatario :", 0);		 
				 
				 // Fila 2 Cuadro 1
				 $pdf->SetX(84);
				 $pdf->SetY(130);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,27), 0);
				 $pdf->SetX(84);
				 $pdf->SetY(132);
				 //$pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 27,27), 0); 
				 $pdf->SetX(84);
				 $pdf->SetY(134);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,30), 0); 
				 $pdf->SetX(84);
				 $pdf->SetY(136);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,30).' '.ucfirst(strtolower($guia[$i]['destino'])), 0); 
				 
				  // Cuadro 2
				 $pdf->SetX(70);
				 $pdf->SetY(140);	 	
				 $pdf->Cell(27,10,null,1,0,'C');
				 
				 //Espacio Entre Marcos
				 $pdf->Cell(1,1,null,0,0,'C');
				 
				 // Cuadro 3
				 $pdf->Cell(42,7,null,0,0,'C');
				 $pdf->SetX(70);
				 $pdf->SetY(150);
				 $pdf->Cell(27,13,null,1,0,'C');
				 $pdf->SetY(149);
				 $pdf->SetX(75);	 	
				 $pdf->Cell(25,14,null,1,0,'C');
				 // Fila 1 Cuadro 3
				 $pdf->SetX(40);
				 $pdf->SetY(151);
				 $pdf->Cell(20, 3, "Remitente :", 0);
				  // Fila 2 Cuadro 3
				 $pdf->SetX(40);
				 $pdf->SetY(154);
				 $pdf->Cell(18, 3, substr(utf8_decode($guia[$i]['remitente']), 0,23), 0);
				 $pdf->SetX(40);
				 $pdf->SetY(156);
				 $pdf->Cell(18, 3, substr(utf8_decode($guia[$i]['remitente']), 23,22), 0);
				 $pdf->SetX(40);
				 $pdf->SetY(158);
				 $pdf->Cell(18, 3, substr(utf8_decode(str_replace("OFICINA","OFI",$guia[$i]['direccion_remitente'])), 0,30), 0);
				 $pdf->SetX(40);
				 $pdf->SetY(160);
				 $pdf->Cell(18, 3, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_remitente']), 0,30).' '.ucfirst(strtolower($guia[$i]['origen'])), 0);

				 // Fila 1 Cuadro derecho joh
				
				 $pdf->SetY(128);
				 $pdf->SetX(76);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(20, 3, "Destinatario", 1);
				 $pdf->SetY(130);				 
				 $pdf->SetX(74.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,27), 0);
				 $pdf->SetY(132);				 
				 $pdf->SetX(74.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,30), 0);
				 $pdf->SetY(134);				 
				 $pdf->SetX(74.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 30,30), 0);
				 $pdf->SetY(136);				 
				 $pdf->SetX(74.5);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,30), 0);
				 $pdf->SetY(138);				 
				 $pdf->SetX(74.5);
				 $pdf->Cell(18, 5,$guia[$i]['destino'], 0);

				 $pdf->SetY(153);				 
				 $pdf->SetX(75);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['remitente']), 0,20), 0);
				 $pdf->SetY(155);				 
				 $pdf->SetX(75);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['remitente']), 20,18), 0);
				 $pdf->SetY(157);				 
				 $pdf->SetX(75);
				 $pdf->Cell(18, 5, substr(utf8_decode(str_replace("OFICINA","OFI",$guia[$i]['direccion_remitente'])), 0,30), 0);
				 $pdf->SetY(159);				 
				 $pdf->SetX(75);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_remitente']), 0,30).' '.ucfirst(strtolower($guia[$i]['origen'])), 0);

				 // Fila 2 Cuadro derecho joh
				 
				 $pdf->SetY(144);
				 $pdf->SetX(75);
				 $pdf->Cell(25, 5," ", 1);
				 $pdf->SetY(144);
				 $pdf->SetX(74.5);
				 $pdf->SetFont('Arial','',4);
				 $pdf->Cell(18,2, 'PESO '.substr(utf8_decode($guia[$i]['peso']).' '.$guia[$i]['medida'], 0,20),'',0);
				 $pdf->SetY(146);
				 $pdf->SetX(74.5);
				 $pdf->SetFont('Arial','',4);
				 $pdf->Cell(18,2, 'VR. ENVIO '.number_format($guia[$i]['valor_total'],0,',','.'),0,0);
				
				 $pdf->SetY(150);
				 $pdf->SetX(76);
				 $pdf->Cell(20, 3, "Remitente", 1);

				 //CUADRO DERECHO FECHA HORA CODIGO MENSAJERO
 				 $pdf->SetY(140);	 	
				 $pdf->SetX(4);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(17,2,'FECHA',1);
 				 $pdf->SetY(140);	 	
				 $pdf->SetX(21);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,2,'HORA',1);

 				 $pdf->SetY(142);	 	
				 $pdf->SetX(4);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(17,4,'',1);
 				 $pdf->SetY(142);	 	
				 $pdf->SetX(21);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,4,'',1);
 				 $pdf->SetY(145);	 	
				 $pdf->SetX(3);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,4,'COD. MENS',0);

				 //PARTE DE CENTRO
 				 $pdf->SetY(127);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,36,'',1);

 				 $pdf->SetY(136);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,8,'',1);


 				 $pdf->SetY(128);	 	
				 $pdf->SetX(35);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(12,2,'ENT.ALMACEN',1);

 				 $pdf->SetY(128);	 	
				 $pdf->SetX(47);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(9,2,'REMISION',1);

 				 $pdf->SetY(128);	 	
				 $pdf->SetX(56);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(6,2,'ZONA',1);
 				 $pdf->SetY(130);	 	
				 $pdf->SetX(56);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(6,6,utf8_decode($guia[$i]['zona']),1);

 				 $pdf->SetY(128);	 	
				 $pdf->SetX(62);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(12,2,'CONSECUTIVO',1);

 				 $pdf->SetY(144);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,9,'',1);

 				 $pdf->SetY(137);	 	
				 $pdf->SetX(38);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(11,2,'MENSAJERO',1);

 				 $pdf->SetY(137);	 	
				 $pdf->SetX(51);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,2,'FECHA ENT.',1);

 				 $pdf->SetY(137);	 	
				 $pdf->SetX(63);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(9,2,'HORA ENT.',1);


 				 $pdf->SetY(160);	 	
				 $pdf->SetX(34);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(14,2,'RECIBIDO POR',1);
				 
				 $pdf->SetY(161);	 	
				 $pdf->SetX(58);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Impreso '. date("Y-m-d"),0);
				 
				 $pdf->SetY(144);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,9,'',1);

 				 $pdf->SetY(144);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(8,2,'DEVOL',1);

 				 $pdf->SetY(147);	 	
				 $pdf->SetX(34);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(14,2,'DESCONOCIDO',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(11,2,'REHUSADO',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(10,2,'NO RESIDE',0);

 				 $pdf->SetY(150);	 	
				 $pdf->SetX(34);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(14,2,'DIR INCOMPLETA',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(11,2,'DIR ERRADA',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(10,2,'OTRO',0);
				 //FIN PARTE DE CENTRO

 				 $pdf->SetY(119);	 	
				 $pdf->SetX(45);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Res. MINTIC No 4304 de 2013',0);
				 
				 $pdf->SetY(121);	 	
				 $pdf->SetX(45);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,($guia[$i]['tipo_servicio']),0);
				 if(!empty($guia[$i]['orden_despacho'])){
					 $pdf->SetY(123);	 	
					 $pdf->SetX(45);
					 $pdf->Cell(14,2,'Doc. Cliente: '.$guia[$i]['orden_despacho'],0);
				 }
				 
				 
 				 //FIN CUADRO DERECHO FECHA HORA CODIGO MENSAJERO
				 // Fin Fila 1 Columna 1
			}
			if($j==5){
				 //Lado Derecho
				 $pdf->SetX(123);
				 $pdf->SetY(108);
				 $pdf->Image($guia[$i]['logo'],113,115,10,7); 
				 $pdf->Image($guia[$i]['codbar'],182,115,25,7); 
				 $pdf->Image($guia[$i]['logo'],143,115,10,7);
				 $pdf->SetFont('Arial','B',4);	 
				 $pdf->Cell(164,16,"NIT. $nit_empresa",0,0,'R');		 
				 $pdf->Ln(3);
				 $pdf->SetFont('Arial','B',5);	
				 $pdf->Cell(169,14,$guia[$i]['pagina_web'],0,0,'R');		 	 
				 $pdf->Ln(3);	 
				 $pdf->SetFont('Arial','B',7);		 	 	 
				 $pdf->Cell(383,20,$guia[$i]['numero_guia_bar'],0,0,'C');		 	 	 				 	 	 
				 $pdf->Ln(13);	 
				 
				// Fila 3 Columna 2
				$pdf->SetY(127);	 	
				$pdf->SetX(113);
				$pdf->Cell(27,13,null,1,0,'C');
				$pdf->Cell(1,1,null,0,0,'C');
				
				// Cuadro 1 Marco Derecha
				$pdf->Cell(42,7,null,0,0,'C');
				//Espacio Entre Marcos
				$pdf->Cell(1,1,null,0,0,'C');
				// Cuadro 1 Marco Derecha
				$pdf->Cell(25,22,null,1,0,'C');
				//Espacio Entre Marcos
				$pdf->Cell(4,4,null,0,0,'C');
				
				 // Direccion y Telefono Izquierda
				 $pdf->SetY(115);
				 $pdf->SetX(123);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, "Cra. 26 A No. 1D - 53", 0);
				 $pdf->SetY(118);
				 $pdf->SetX(123);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, "Tels.: 2012415 - 3513534", 0);
				 $pdf->SetY(121);
				 $pdf->SetX(112.5);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, ($guia[$i]['orden_despacho']), 0);

				 // Linea 1
				 $pdf->SetY(127);
				 $pdf->SetX(113);
				 $pdf->SetFont('Arial','',5);		
				 $pdf->Cell(20, 5, "Destinatario :", 0);		 
				 
				 // Linea 2
				 $pdf->SetY(130);
				 $pdf->SetX(113);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,27), 0);
				 $pdf->SetY(132);
				 $pdf->SetX(113);
				 //$pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 27,27), 0);
				 $pdf->SetY(134);
				 $pdf->SetX(113);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,30), 0);
				 $pdf->SetY(136);
				 $pdf->SetX(113);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,30).' '.ucfirst(strtolower($guia[$i]['destino'])), 0);
				 
				// Fin Cuadro 1
				// Cuadro 2
				$pdf->SetY(140);
				$pdf->SetX(113);	 	
				$pdf->Cell(27,10,null,1,0,'C');
				// Fin Cuadro 2
				//Espacio Entre Columnas
				$pdf->Cell(1,1,null,0,0,'C');
				// Cuadro 3
				$pdf->Cell(42,7,null,0,0,'C');
				$pdf->SetY(150);
				$pdf->SetX(113);
				$pdf->Cell(27,13,null,1,0,'C');
				$pdf->SetY(149);
				$pdf->SetX(184);	 	
				$pdf->Cell(25,14,null,1,0,'C');
				 // Linea 1
				 $pdf->SetY(150);
				 $pdf->SetX(113);
				 $pdf->Cell(20, 3, "Remitente :", 0);
				  // Linea 2 
				 $pdf->SetY(154);
				 $pdf->SetX(113);
				 $pdf->Cell(18, 3, substr(utf8_decode($guia[$i]['remitente']), 0,23), 0);
				 $pdf->SetY(156);
				 $pdf->SetX(113);
				 $pdf->Cell(18, 3, substr(utf8_decode($guia[$i]['remitente']), 23,22), 0);
				 $pdf->SetY(158);
				 $pdf->SetX(113);
				 $pdf->Cell(18, 3, substr(utf8_decode(str_replace("OFICINA","OFI",$guia[$i]['direccion_remitente'])), 0,30), 0);
				 $pdf->SetY(160);
				 $pdf->SetX(113);
				 $pdf->Cell(18, 3, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_remitente']), 0,30).' '.ucfirst(strtolower($guia[$i]['origen'])), 0);
				 
				// Fin Cuadro 3

				// Fin Fila 1 Columna 2
				 $pdf->SetY(128);
				 $pdf->SetX(185);
				 $pdf->Cell(20, 3, "Destinatario", 1);
				 $pdf->SetY(130);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,27), 0);
				 $pdf->SetY(132);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,30), 0);
				 $pdf->SetY(134);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 30,30), 0);
				 $pdf->SetY(136);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,30), 0);
				 $pdf->SetY(138);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, $guia[$i]['destino'], 0);


				 $pdf->SetY(153);				 
				 $pdf->SetX(184);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['remitente']), 0,20), 0);
				 $pdf->SetY(155);				 
				 $pdf->SetX(184);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['remitente']), 20,18), 0);
				 $pdf->SetY(157);				 
				 $pdf->SetX(184);
				 $pdf->Cell(18, 5, substr(utf8_decode(str_replace("OFICINA","OFI",$guia[$i]['direccion_remitente'])), 0,30), 0);
				 $pdf->SetY(159);				 
				 $pdf->SetX(184);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_remitente']), 0,30).' '.ucfirst(strtolower($guia[$i]['origen'])), 0);

				 // Fila 2 Cuadro derecho joh
				 
				 $pdf->SetY(144);
				 $pdf->SetX(184);
				 $pdf->Cell(25, 5," ", 1);
				 $pdf->SetY(144);
				 $pdf->SetX(183.5);
				 $pdf->SetFont('Arial','',4);
				 $pdf->Cell(18,2, 'PESO '.substr(utf8_decode($guia[$i]['peso']).' '.$guia[$i]['medida'], 0,20),'',0);
				 $pdf->SetY(146);
				 $pdf->SetX(183.5);
				 $pdf->SetFont('Arial','',4);
				 $pdf->Cell(18,2, 'VR. ENVIO '.number_format($guia[$i]['valor_total'],0,',','.'),0,0);
				 
				 $pdf->SetY(150);
				 $pdf->SetX(185);
				 $pdf->Cell(20, 3, "Remitente", 1);

				 //CUADRO DERECHO FECHA HORA CODIGO MENSAJERO
 				 $pdf->SetY(140);	 	
				 $pdf->SetX(113);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(17,2,'FECHA',1);
 				 $pdf->SetY(140);	 	
				 $pdf->SetX(130);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,2,'HORA',1);

 				 $pdf->SetY(142);	 	
				 $pdf->SetX(113);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(17,4,'',1);
 				 $pdf->SetY(142);	 	
				 $pdf->SetX(130);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,4,'',1);
 				 $pdf->SetY(145);	 	
				 $pdf->SetX(112);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,4,'COD. MENS',0);

				 //PARTE DE CENTRO
 				 $pdf->SetY(127);	 	
				 $pdf->SetX(142);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,36,'',1);

 				 $pdf->SetY(127);	 	
				 $pdf->SetX(142);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,9,'',1);


 				 $pdf->SetY(128);	 	
				 $pdf->SetX(144);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(12,2,'ENT.ALMACEN',1);

 				 $pdf->SetY(128);	 	
				 $pdf->SetX(156);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(9,2,'REMISION',1);

 				 $pdf->SetY(128);	 	
				 $pdf->SetX(165);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(6,2,'ZONA',1);
 				 $pdf->SetY(130);	 	
				 $pdf->SetX(165);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(6,6,utf8_decode($guia[$i]['zona']),1);

 				 $pdf->SetY(128);	 	
				 $pdf->SetX(171);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(12,2,'CONSECUTIVO',1);

 				 $pdf->SetY(136);	 	
				 $pdf->SetX(142);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,8,'',1);


 				 $pdf->SetY(137);	 	
				 $pdf->SetX(147);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(11,2,'MENSAJERO',1);

 				 $pdf->SetY(137);	 	
				 $pdf->SetX(160);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,2,'FECHA ENT.',1);

 				 $pdf->SetY(137);	 	
				 $pdf->SetX(172);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(9,2,'HORA ENT.',1);


 				 $pdf->SetY(160);	 	
				 $pdf->SetX(143);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(14,2,'RECIBIDO POR',1);
				 
				 $pdf->SetY(161);	 	
				 $pdf->SetX(167);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Impreso '. date("Y-m-d"),0);
				 
				 $pdf->SetY(144);	 	
				 $pdf->SetX(142);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,9,'',1);

 				 $pdf->SetY(144);	 	
				 $pdf->SetX(142);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(8,2,'DEVOL',1);

 				 $pdf->SetY(147);	 	
				 $pdf->SetX(143);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(14,2,'DESCONOCIDO',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(11,2,'REHUSADO',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(10,2,'NO RESIDE',0);

 				 $pdf->SetY(150);	 	
				 $pdf->SetX(143);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(14,2,'DIR INCOMPLETA',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(11,2,'DIR ERRADA',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(10,2,'OTRO',0);
				 //FIN PARTE DE CENTRO


 				 $pdf->SetY(119);	 	
				 $pdf->SetX(154);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Res. MINTIC No 4304 de 2013',0);
				
				 $pdf->SetY(121);	 	
				 $pdf->SetX(154);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,($guia[$i]['tipo_servicio']),0);
				 if(!empty($guia[$i]['orden_despacho'])){
					 $pdf->SetY(123);	 	
					 $pdf->SetX(154);
					 $pdf->Cell(14,2,'Doc. Cliente: '.$guia[$i]['orden_despacho'],0);
				 }
				 

 				 //FIN CUADRO DERECHO FECHA HORA CODIGO MENSAJERO
				// Fin Fila 3 Columna 2
			}
			 
			if($j==6){
				 // Fila 4 Columna 1
			  	 $pdf->SetX(115);
				 $pdf->SetY(154);	
				 $pdf->SetFont('Arial','B',5); 	 
				 $pdf->Image($guia[$i]['logo'],4,166,10,7); 
				 $pdf->Image($guia[$i]['codbar'],74,166,25,7); 
				 $pdf->Image($guia[$i]['logo'],34,166,10,7);		 	 
				 $pdf->SetFont('Arial','B',4);	 
				 $pdf->Cell(55,26,"NIT. $nit_empresa",0,0,'R');	
				 $pdf->Ln(3);
				 $pdf->SetFont('Arial','B',5);	 
				 $pdf->Cell(60,24,$guia[$i]['pagina_web'],0,0,'R');	
				 $pdf->Ln(3);	 
				 $pdf->SetFont('Arial','B',7);		 	 	 
				 $pdf->Cell(170,30,$guia[$i]['numero_guia_bar'],0,0,'C');		 	 	 
				 $pdf->Ln(6);	
				 $pdf->SetY(178);
				 // Cuadro 1 Marco Izquierda	
				$pdf->Cell(27,13,null,1,0,'C');
				//Espacio Entre Marcos
				$pdf->Cell(1,1,null,0,0,'C');
				// Cuadro 1 Marco Derecha
				$pdf->Cell(42,7,null,0,0,'C');
				//Espacio Entre Marcos
				$pdf->Cell(1,1,null,0,0,'C');
				// Cuadro 1 Marco Derecha
				$pdf->Cell(25,22,null,1,0,'C');
				//Espacio Entre Marcos
				$pdf->Cell(4,4,null,0,0,'C');
				
				 // Direccion y Telefono Izquierda
				 $pdf->SetY(166);
				 $pdf->SetX(14);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, "Cra. 26 A No. 1D - 53", 0);
				 $pdf->SetY(169);
				 $pdf->SetX(14);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, "Tels.: 2012415 - 3513534", 0);
 				 $pdf->SetY(172);
				 $pdf->SetX(3.5);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, ($guia[$i]['orden_despacho']), 0);

				// Fila 1 Cuadro 1
				$pdf->SetX(84);
				$pdf->SetY(178);
				$pdf->SetFont('Arial','',5);	
				$pdf->Cell(20, 5, "Destinatario :", 0);		 
				
				// Fila 2 Cuadro 1
				$pdf->SetX(84);
				$pdf->SetY(181);
				$pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,27), 0);
				$pdf->SetX(84);
				$pdf->SetY(183);
				//$pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 27,27), 0);
				$pdf->SetX(84);
				$pdf->SetY(185);
				$pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,30), 0);
				$pdf->SetX(84);
				$pdf->SetY(187);
				$pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,30).' '.ucfirst(strtolower($guia[$i]['destino'])), 0);
				
				// Cuadro 2
				$pdf->SetX(70);
				$pdf->SetY(191);	 	
				$pdf->Cell(27,10,null,1,0,'C');
				
				//Espacio Entre Marcos
				$pdf->Cell(1,1,null,0,0,'C');
				
				// Cuadro 3
				$pdf->Cell(42,7,null,0,0,'C');
				$pdf->SetX(70);
				$pdf->SetY(201);
				$pdf->Cell(27,13,null,1,0,'C');
				$pdf->SetY(200);
				$pdf->SetX(75);	 	
				$pdf->Cell(25,14,null,1,0,'C');
				// Fila 1 Cuadro 3
				$pdf->SetX(40);
				$pdf->SetY(202);
				$pdf->Cell(20, 3, "Remitente :", 0);
				// Fila 2 Cuadro 3
				$pdf->SetX(40);
				$pdf->SetY(205);
				$pdf->Cell(18, 3, substr(utf8_decode($guia[$i]['remitente']), 0,23), 0);
				$pdf->SetX(40);
				$pdf->SetY(207);
				$pdf->Cell(18, 3, substr(utf8_decode($guia[$i]['remitente']), 23,22), 0);
				$pdf->SetX(40);
				$pdf->SetY(209);
				$pdf->Cell(18, 3, substr(utf8_decode(str_replace("OFICINA","OFI",$guia[$i]['direccion_remitente'])), 0,30), 0);
				$pdf->SetX(40);
				$pdf->SetY(211);
				$pdf->Cell(18, 3, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_remitente']), 0,30).' '.ucfirst(strtolower($guia[$i]['origen'])), 0);
				
				 $pdf->SetY(179);
				 $pdf->SetX(76);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(20, 3, "Destinatario", 1);
				 $pdf->SetY(181);				 
				 $pdf->SetX(74.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,27), 0);
				 $pdf->SetY(183);				 
				 $pdf->SetX(74.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,30), 0);
				 $pdf->SetY(185);				 
				 $pdf->SetX(74.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 30,30), 0);
				 $pdf->SetY(187);				 
				 $pdf->SetX(74.5);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,30), 0);
				 $pdf->SetY(189);				 
				 $pdf->SetX(74.5);
				 $pdf->Cell(18, 5, $guia[$i]['destino'], 0);

				 $pdf->SetY(204);				 
				 $pdf->SetX(75);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['remitente']), 0,20), 0);
				 $pdf->SetY(206);				 
				 $pdf->SetX(75);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['remitente']), 20,18), 0);
				 $pdf->SetY(208);				 
				 $pdf->SetX(75);
				 $pdf->Cell(18, 5, substr(utf8_decode(str_replace("OFICINA","OFI",$guia[$i]['direccion_remitente'])), 0,30), 0);
				 $pdf->SetY(210);				 
				 $pdf->SetX(75);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_remitente']), 0,30).' '.ucfirst(strtolower($guia[$i]['origen'])), 0);

				 // Fila 2 Cuadro derecho joh
				 
				 $pdf->SetY(195);
				 $pdf->SetX(75);
				 $pdf->Cell(25, 5," ", 1);
				 $pdf->SetY(195);
				 $pdf->SetX(74.5);
				 $pdf->SetFont('Arial','',4);
				 $pdf->Cell(18,2, 'PESO '.substr(utf8_decode($guia[$i]['peso']).' '.$guia[$i]['medida'], 0,20),'',0);
				 $pdf->SetY(197);
				 $pdf->SetX(74.5);
				 $pdf->SetFont('Arial','',4);
				 $pdf->Cell(18,2, 'VR. ENVIO '.number_format($guia[$i]['valor_total'],0,',','.'),0,0);
				
				 $pdf->SetY(201);
				 $pdf->SetX(76);
				 $pdf->Cell(20, 3, "Remitente", 1);

				 //CUADRO DERECHO FECHA HORA CODIGO MENSAJERO
 				 $pdf->SetY(191);	 	
				 $pdf->SetX(4);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(17,2,'FECHA',1);
 				 $pdf->SetY(191);	 	
				 $pdf->SetX(21);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,2,'HORA',1);

 				 $pdf->SetY(193);	 	
				 $pdf->SetX(4);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(17,4,'',1);
 				 $pdf->SetY(193);	 	
				 $pdf->SetX(21);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,4,'',1);
 				 $pdf->SetY(196);	 	
				 $pdf->SetX(3);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,4,'COD. MENS',0);


				 //PARTE DE CENTRO
 				 $pdf->SetY(178);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,36,'',1);

 				 $pdf->SetY(178);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,9,'',1);


 				 $pdf->SetY(179);	 	
				 $pdf->SetX(35);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(12,2,'ENT.ALMACEN',1);

 				 $pdf->SetY(179);	 	
				 $pdf->SetX(47);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(9,2,'REMISION',1);

 				 $pdf->SetY(179);	 	
				 $pdf->SetX(56);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(6,2,'ZONA',1);
 				 $pdf->SetY(181);	 	
				 $pdf->SetX(56);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(6,6,utf8_decode($guia[$i]['zona']),1);

 				 $pdf->SetY(179);	 	
				 $pdf->SetX(62);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(12,2,'CONSECUTIVO',1);

 				 $pdf->SetY(187);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,8,'',1);


 				 $pdf->SetY(188);	 	
				 $pdf->SetX(38);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(11,2,'MENSAJERO',1);

 				 $pdf->SetY(188);	 	
				 $pdf->SetX(51);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,2,'FECHA ENT.',1);

 				 $pdf->SetY(188);	 	
				 $pdf->SetX(63);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(9,2,'HORA ENT.',1);


 				 $pdf->SetY(211);	 	
				 $pdf->SetX(34);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(14,2,'RECIBIDO POR',1);
				 
				 $pdf->SetY(212);	 	
				 $pdf->SetX(58);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Impreso '. date("Y-m-d"),0);
				 
				 $pdf->SetY(195);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,9,'',1);

 				 $pdf->SetY(195);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(8,2,'DEVOL',1);

 				 $pdf->SetY(198);	 	
				 $pdf->SetX(34);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(14,2,'DESCONOCIDO',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(11,2,'REHUSADO',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(10,2,'NO RESIDE',0);

 				 $pdf->SetY(201);	 	
				 $pdf->SetX(34);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(14,2,'DIR INCOMPLETA',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(11,2,'DIR ERRADA',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(10,2,'OTRO',0);
				 //FIN PARTE DE CENTRO

 				 $pdf->SetY(170);	 	
				 $pdf->SetX(45);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Res. MINTIC No 4304 de 2013',0);
				 
				 $pdf->SetY(172);	 	
				 $pdf->SetX(45);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,($guia[$i]['tipo_servicio']),0);
				 if(!empty($guia[$i]['orden_despacho'])){
					 $pdf->SetY(174);	 	
					 $pdf->SetX(45);
					 $pdf->Cell(14,2,'Doc. Cliente: '.$guia[$i]['orden_despacho'],0);
				 }
				 

 				 //FIN CUADRO DERECHO FECHA HORA CODIGO MENSAJERO
				// Fin Fila 4 Columna 1
			}
			
			if($j==7){
				 //Lado Derecho
				 $pdf->SetX(123);
				 $pdf->SetY(159.5);
				 $pdf->Image($guia[$i]['logo'],113,166,10,7); 
				 $pdf->Image($guia[$i]['codbar'],182,166,25,7); 
				 $pdf->Image($guia[$i]['logo'],143,166,10,7);
				 $pdf->SetFont('Arial','',4);	 
				 $pdf->Cell(164,14.5,"NIT. $nit_empresa",0,0,'R');		 
				 $pdf->Ln(3);
				 $pdf->SetFont('Arial','B',5);	
				 $pdf->Cell(169,12.5,$guia[$i]['pagina_web'],0,0,'R');		 	 
				 $pdf->Ln(3);	 
				 $pdf->SetFont('Arial','B',7);		 	 	 
				 $pdf->Cell(383,20,$guia[$i]['numero_guia_bar'],0,0,'C');		 	 	 				 	 	 
				 $pdf->Ln(13);	 
						
				// Fila 4 Columna 2
				$pdf->SetY(178);	 	
				$pdf->SetX(113);
				$pdf->Cell(27,13,null,1,0,'C');
				$pdf->Cell(1,1,null,0,0,'C');
				
				// Cuadro 1 Marco Derecha
				$pdf->Cell(42,7,null,0,0,'C');
				//Espacio Entre Marcos
				$pdf->Cell(1,1,null,0,0,'C');
				// Cuadro 1 Marco Derecha
				$pdf->Cell(25,22,null,1,0,'C');
				//Espacio Entre Marcos
				$pdf->Cell(4,4,null,0,0,'C');
				
				// Direccion y Telefono Izquierda
				 $pdf->SetY(166);
				 $pdf->SetX(123);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, "Cra. 26 A No. 1D - 53", 0);
				 $pdf->SetY(169);
				 $pdf->SetX(123);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, "Tels.: 2012415 - 3513534", 0);
 				 $pdf->SetY(172);
				 $pdf->SetX(112.5);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, ($guia[$i]['orden_despacho']), 0);

				 // Linea 1
				 $pdf->SetY(178);
				 $pdf->SetX(113);
				 $pdf->SetFont('Arial','',5);
				 $pdf->Cell(20, 5, "Destinatario :", 0);		 
				 
				 // Linea 2
				 $pdf->SetY(181);
				 $pdf->SetX(113);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,27), 0);
				 $pdf->SetY(183);
				 $pdf->SetX(113);
				 //$pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 27,27), 0);
				 $pdf->SetY(185);
				 $pdf->SetX(113);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,30), 0);
				 $pdf->SetY(187);
				 $pdf->SetX(113);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,30).' '.ucfirst(strtolower($guia[$i]['destino'])), 0);
				 
				// Fin Cuadro 1
				// Cuadro 2
				$pdf->SetY(191);
				$pdf->SetX(113);	 	
				$pdf->Cell(27,10,null,1,0,'C');
				// Fin Cuadro 2
				//Espacio Entre Columnas
				$pdf->Cell(1,1,null,0,0,'C');
				// Cuadro 3
				$pdf->Cell(42,7,null,0,0,'C');
				$pdf->SetY(201);
				$pdf->SetX(113);
				$pdf->Cell(27,13,null,1,0,'C');
				$pdf->SetY(200);
				$pdf->SetX(184);	 	
				$pdf->Cell(25,14,null,1,0,'C');
				 // Linea 1
				 $pdf->SetY(202);
				 $pdf->SetX(113);
				 $pdf->Cell(20, 3, "Remitente :", 0);
				  // Linea 2 
				 $pdf->SetY(205);
				 $pdf->SetX(113);
				 $pdf->Cell(18, 3, substr(utf8_decode($guia[$i]['remitente']), 0,23), 0);
				 $pdf->SetY(207);
				 $pdf->SetX(113);
				 $pdf->Cell(18, 3, substr(utf8_decode($guia[$i]['remitente']), 23,22), 0);
				 $pdf->SetY(209);
				 $pdf->SetX(113);
				 $pdf->Cell(18, 3, substr(utf8_decode(str_replace("OFICINA","OFI",$guia[$i]['direccion_remitente'])), 0,30), 0);
				 $pdf->SetY(211);
				 $pdf->SetX(113);
				 $pdf->Cell(18, 3, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_remitente']), 0,30).' '.ucfirst(strtolower($guia[$i]['origen'])), 0);
				 
				// Fin Cuadro 3

				 $pdf->SetY(179);
				 $pdf->SetX(185);
				 $pdf->Cell(20, 3, "Destinatario", 1);
				 $pdf->SetY(181);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,27), 0);
				 $pdf->SetY(183);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,30), 0);
				 $pdf->SetY(185);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 30,30), 0);
				 $pdf->SetY(187);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,30), 0);
				 $pdf->SetY(189);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, $guia[$i]['destino'], 0);


				 $pdf->SetY(204);				 
				 $pdf->SetX(184);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['remitente']), 0,18), 0);
				 $pdf->SetY(206);				 
				 $pdf->SetX(184);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['remitente']), 18,18), 0);
				 $pdf->SetY(208);				 
				 $pdf->SetX(184);
				 $pdf->Cell(18, 5, substr(utf8_decode(str_replace("OFICINA","OFI",$guia[$i]['direccion_remitente'])), 0,30), 0);
				 $pdf->SetY(210);				 
				 $pdf->SetX(184);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_remitente']), 0,30).' '.ucfirst(strtolower($guia[$i]['origen'])), 0);

				 // Fila 2 Cuadro derecho joh
				 
				 $pdf->SetY(195);
				 $pdf->SetX(184);
				 $pdf->Cell(25, 5," ", 1);
				 $pdf->SetY(195);
				 $pdf->SetX(183.5);
				 $pdf->SetFont('Arial','',4);
				 $pdf->Cell(18,2, 'PESO '.substr(utf8_decode($guia[$i]['peso']).' '.$guia[$i]['medida'], 0,20),'',0);
				 $pdf->SetY(197);
				 $pdf->SetX(183.5);
				 $pdf->SetFont('Arial','',4);
				 $pdf->Cell(18,2, 'VR. ENVIO '.number_format($guia[$i]['valor_total'],0,',','.'),0,0);
				
				 
				 $pdf->SetY(201);
				 $pdf->SetX(185);
				 $pdf->Cell(20, 3, "Remitente", 1);

				 //CUADRO DERECHO FECHA HORA CODIGO MENSAJERO
 				 $pdf->SetY(191);	 	
				 $pdf->SetX(113);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(17,2,'FECHA',1);
 				 $pdf->SetY(191);	 	
				 $pdf->SetX(130);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,2,'HORA',1);

 				 $pdf->SetY(193);	 	
				 $pdf->SetX(113);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(17,4,'',1);
 				 $pdf->SetY(193);	 	
				 $pdf->SetX(130);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,4,'',1);
 				 $pdf->SetY(196);	 	
				 $pdf->SetX(112);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,4,'COD. MENS',0);

				 //PARTE DE CENTRO
 				 $pdf->SetY(178);	 	
				 $pdf->SetX(142);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,36,'',1);

 				 $pdf->SetY(178);	 	
				 $pdf->SetX(142);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,9,'',1);


 				 $pdf->SetY(179);	 	
				 $pdf->SetX(144);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(12,2,'ENT.ALMACEN',1);

 				 $pdf->SetY(179);	 	
				 $pdf->SetX(156);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(9,2,'REMISION',1);

 				 $pdf->SetY(179);	 	
				 $pdf->SetX(165);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(6,2,'ZONA',1);
 				 $pdf->SetY(181);	 	
				 $pdf->SetX(165);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(6,6,utf8_decode($guia[$i]['zona']),1);

 				 $pdf->SetY(179);	 	
				 $pdf->SetX(171);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(12,2,'CONSECUTIVO',1);

 				 $pdf->SetY(187);	 	
				 $pdf->SetX(142);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,8,'',1);


 				 $pdf->SetY(188);	 	
				 $pdf->SetX(147);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(11,2,'MENSAJERO',1);

 				 $pdf->SetY(188);	 	
				 $pdf->SetX(160);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,2,'FECHA ENT.',1);

 				 $pdf->SetY(188);	 	
				 $pdf->SetX(172);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(9,2,'HORA ENT.',1);


 				 $pdf->SetY(211);	 	
				 $pdf->SetX(143);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(14,2,'RECIBIDO POR',1);
				 
				 $pdf->SetY(212);	 	
				 $pdf->SetX(167);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Impreso '. date("Y-m-d"),0);
				 				 
 				 $pdf->SetY(195);	 	
				 $pdf->SetX(142);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,9,'',1);

 				 $pdf->SetY(195);	 	
				 $pdf->SetX(142);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(8,2,'DEVOL',1);

 				 $pdf->SetY(198);	 	
				 $pdf->SetX(143);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(14,2,'DESCONOCIDO',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(11,2,'REHUSADO',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(10,2,'NO RESIDE',0);

 				 $pdf->SetY(201);	 	
				 $pdf->SetX(143);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(14,2,'DIR INCOMPLETA',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(11,2,'DIR ERRADA',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(10,2,'OTRO',0);
				 //FIN PARTE DE CENTRO

 				 $pdf->SetY(170);	 	
				 $pdf->SetX(154);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Res. MINTIC No 4304 de 2013',0);
				
				 $pdf->SetY(172);	 	
				 $pdf->SetX(154);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,($guia[$i]['tipo_servicio']),0);
				 if(!empty($guia[$i]['orden_despacho'])){
					 $pdf->SetY(174);	 	
					 $pdf->SetX(154);
					 $pdf->Cell(14,2,'Doc. Cliente: '.$guia[$i]['orden_despacho'],0);
				 }
				 
 				 //FIN CUADRO DERECHO FECHA HORA CODIGO MENSAJERO


				// Fin Fila 4 Columna 2
			}


			if($j==8){
				 // Fila 4 Columna 1
			  	 $pdf->SetX(115);
				 $pdf->SetY(205);	
				 $pdf->SetFont('Arial','B',5); 	 
				 $pdf->Image($guia[$i]['logo'],4,217,10,7); 
				 $pdf->Image($guia[$i]['codbar'],74,217,25,7); 
				 $pdf->Image($guia[$i]['logo'],34,217,10,7);		 	 
				 $pdf->SetFont('Arial','B',4);	 
				 $pdf->Cell(55,25.8,"NIT. $nit_empresa",0,0,'R');	
				 $pdf->Ln(3);
				 $pdf->SetFont('Arial','B',5);	 
				 $pdf->Cell(60,23.8,$guia[$i]['pagina_web'],0,0,'R');	
				 $pdf->Ln(3);	 
				 $pdf->SetFont('Arial','B',7);		 	 	 
				 $pdf->Cell(170,31,$guia[$i]['numero_guia_bar'],0,0,'C');		 	 	 
				 $pdf->Ln(6);	
				 $pdf->SetY(230);
				 // Cuadro 1 Marco Izquierda	
				$pdf->Cell(27,13,null,1,0,'C');
				//Espacio Entre Marcos
				$pdf->Cell(1,1,null,0,0,'C');
				// Cuadro 1 Marco Derecha
				$pdf->Cell(42,7,null,0,0,'C');
				//Espacio Entre Marcos
				$pdf->Cell(1,1,null,0,0,'C');
				// Cuadro 1 Marco Derecha
				$pdf->Cell(25,22,null,1,0,'C');
				//Espacio Entre Marcos
				$pdf->Cell(4,4,null,0,0,'C');
				
				// Direccion y Telefono Izquierda
				 $pdf->SetY(217);
				 $pdf->SetX(14);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, "Cra. 26 A No. 1D - 53", 0);
				 $pdf->SetY(220);
				 $pdf->SetX(14);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, "Tels.: 2012415 - 3513534", 0);
 				 $pdf->SetY(223);
				 $pdf->SetX(3.5);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, ($guia[$i]['orden_despacho']), 0);

				// Fila 1 Cuadro 1
				$pdf->SetX(84);
				$pdf->SetY(230);
				$pdf->SetFont('Arial','',5);	
				$pdf->Cell(20, 5, "Destinatario :", 0);		 
				
				// Fila 2 Cuadro 1
				$pdf->SetX(84);
				$pdf->SetY(233);
				$pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,27), 0);
				$pdf->SetX(84);
				$pdf->SetY(235);
				//$pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 27,27), 0);
				$pdf->SetX(84);
				$pdf->SetY(237);
				$pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,30), 0);
				$pdf->SetX(84);
				$pdf->SetY(239);
				$pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,30).' '.ucfirst(strtolower($guia[$i]['destino'])), 0);
				
				// Cuadro 2
				$pdf->SetX(70);
				$pdf->SetY(243);	 	
				$pdf->Cell(27,10,null,1,0,'C');
				
				//Espacio Entre Marcos
				$pdf->Cell(1,1,null,0,0,'C');
				
				// Cuadro 3
				$pdf->Cell(42,7,null,0,0,'C');
				$pdf->SetX(70);
				$pdf->SetY(253);
				$pdf->Cell(27,13,null,1,0,'C');
				$pdf->SetY(252);
				$pdf->SetX(75);	 	
				$pdf->Cell(25,14,null,1,0,'C');
				// Fila 1 Cuadro 3
				$pdf->SetX(40);
				$pdf->SetY(254);
				$pdf->Cell(20, 3, "Remitente :", 0);
				// Fila 2 Cuadro 3
				$pdf->SetX(40);
				$pdf->SetY(257);
				$pdf->Cell(18, 3, substr(utf8_decode($guia[$i]['remitente']), 0,23), 0);
				$pdf->SetX(40);
				$pdf->SetY(259);
				$pdf->Cell(18, 3, substr(utf8_decode($guia[$i]['remitente']), 23,22), 0);
				$pdf->SetX(40);
				$pdf->SetY(261);
				$pdf->Cell(18, 3, substr(utf8_decode(str_replace("OFICINA","OFI",$guia[$i]['direccion_remitente'])), 0,30), 0);
				$pdf->SetX(40);
				$pdf->SetY(263);
				$pdf->Cell(18, 3, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_remitente']), 0,30).' '.ucfirst(strtolower($guia[$i]['origen'])), 0);
				
				 $pdf->SetY(231);
				 $pdf->SetX(76);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(20, 3, "Destinatario", 1);
				 $pdf->SetY(233);				 
				 $pdf->SetX(75);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,27), 0);
				 $pdf->SetY(235);				 
				 $pdf->SetX(75);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,30), 0);
				 $pdf->SetY(237);				 
				 $pdf->SetX(75);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']),30,30), 0);
				 $pdf->SetY(239);				 
				 $pdf->SetX(75);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,30), 0);
				 $pdf->SetY(241);				 
				 $pdf->SetX(75);
				 $pdf->Cell(18, 5, $guia[$i]['destino'], 0);

				 $pdf->SetY(256);				 
				 $pdf->SetX(75);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['remitente']), 0,20), 0);
				 $pdf->SetY(258);				 
				 $pdf->SetX(75);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['remitente']), 20,18), 0);
				 $pdf->SetY(260);				 
				 $pdf->SetX(75);
				 $pdf->Cell(18, 5, substr(utf8_decode(str_replace("OFICINA","OFI",$guia[$i]['direccion_remitente'])), 0,30), 0);
				 $pdf->SetY(262);				 
				 $pdf->SetX(75);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_remitente']), 0,30).' '.ucfirst(strtolower($guia[$i]['origen'])), 0);

				 // Fila 2 Cuadro derecho joh
				 
				 $pdf->SetY(247);
				 $pdf->SetX(75);
				 $pdf->Cell(25, 5," ", 1);
				 $pdf->SetY(247);
				 $pdf->SetX(74.5);
				 $pdf->SetFont('Arial','',4);
				 $pdf->Cell(18,2, 'PESO '.substr(utf8_decode($guia[$i]['peso']).' '.$guia[$i]['medida'], 0,20),'',0);
				 $pdf->SetY(249);
				 $pdf->SetX(74.5);
				 $pdf->SetFont('Arial','',4);
				 $pdf->Cell(18,2, 'VR. ENVIO '.number_format($guia[$i]['valor_total'],0,',','.'),0,0);
				
				
				 $pdf->SetY(253);
				 $pdf->SetX(76);
				 $pdf->Cell(20, 3, "Remitente", 1);

				 //CUADRO DERECHO FECHA HORA CODIGO MENSAJERO
 				 $pdf->SetY(243);	 	
				 $pdf->SetX(4);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(17,2,'FECHA',1);
 				 $pdf->SetY(243);	 	
				 $pdf->SetX(21);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,2,'HORA',1);

 				 $pdf->SetY(245);	 	
				 $pdf->SetX(4);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(17,4,'',1);
 				 $pdf->SetY(245);	 	
				 $pdf->SetX(21);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,4,'',1);
 				 $pdf->SetY(248);	 	
				 $pdf->SetX(3);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,4,'COD. MENS',0);


				 //PARTE DE CENTRO
 				 $pdf->SetY(230);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,36,'',1);

 				 $pdf->SetY(230);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,9,'',1);


 				 $pdf->SetY(231);	 	
				 $pdf->SetX(35);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(12,2,'ENT.ALMACEN',1);

 				 $pdf->SetY(231);	 	
				 $pdf->SetX(47);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(9,2,'REMISION',1);

 				 $pdf->SetY(231);	 	
				 $pdf->SetX(56);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(6,2,'ZONA',1);
 				 $pdf->SetY(233);	 	
				 $pdf->SetX(56);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(6,6,utf8_decode($guia[$i]['zona']),1);

 				 $pdf->SetY(231);	 	
				 $pdf->SetX(62);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(12,2,'CONSECUTIVO',1);

 				 $pdf->SetY(239);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,8,'',1);


 				 $pdf->SetY(240);	 	
				 $pdf->SetX(38);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(11,2,'MENSAJERO',1);

 				 $pdf->SetY(240);	 	
				 $pdf->SetX(51);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,2,'FECHA ENT.',1);

 				 $pdf->SetY(240);	 	
				 $pdf->SetX(63);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(9,2,'HORA ENT.',1);


 				 $pdf->SetY(263);	 	
				 $pdf->SetX(34);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(14,2,'RECIBIDO POR',1);
				 
				 $pdf->SetY(264);	 	
				 $pdf->SetX(58);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Impreso '. date("Y-m-d"),0);
				 
				 $pdf->SetY(247);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,9,'',1);

 				 $pdf->SetY(247);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(8,2,'DEVOL',1);

 				 $pdf->SetY(250);	 	
				 $pdf->SetX(34);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(14,2,'DESCONOCIDO',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(11,2,'REHUSADO',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(10,2,'NO RESIDE',0);

 				 $pdf->SetY(253);	 	
				 $pdf->SetX(34);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(14,2,'DIR INCOMPLETA',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(11,2,'DIR ERRADA',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(10,2,'OTRO',0);
				 //FIN PARTE DE CENTRO

 				 $pdf->SetY(221);	 	
				 $pdf->SetX(45);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Res. MINTIC No 4304 de 2013',0);
				 
				 $pdf->SetY(223);	 	
				 $pdf->SetX(45);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,($guia[$i]['tipo_servicio']),0);
				 if(!empty($guia[$i]['orden_despacho'])){
					 $pdf->SetY(225);	 	
					 $pdf->SetX(45);
					 $pdf->Cell(14,2,'Doc. Cliente: '.$guia[$i]['orden_despacho'],0);
				 }
				 

 				 //FIN CUADRO DERECHO FECHA HORA CODIGO MENSAJERO
				// Fin Fila 4 Columna 1
			}
			
			if($j==9){
				 //Lado Derecho
				 $pdf->SetX(123);
				 $pdf->SetY(211);
				 $pdf->Image($guia[$i]['logo'],113,217,10,7); 
				 $pdf->Image($guia[$i]['codbar'],182,217,25,7); 
				 $pdf->Image($guia[$i]['logo'],143,217,10,7);
				 $pdf->SetFont('Arial','',4);	 
				 $pdf->Cell(164,14,"NIT. $nit_empresa",0,0,'R');		 
				 $pdf->Ln(3);
				 $pdf->SetFont('Arial','B',5);	
				 $pdf->Cell(169,12,$guia[$i]['pagina_web'],0,0,'R');		 	 
				 $pdf->Ln(3);	 
				 $pdf->SetFont('Arial','B',7);		 	 	 
				 $pdf->Cell(383,20,$guia[$i]['numero_guia_bar'],0,0,'C');		 	 	 				 	 	 
				 $pdf->Ln(13);	 
						
				// Fila 4 Columna 2
				$pdf->SetY(230);	 	
				$pdf->SetX(113);
				$pdf->Cell(27,13,null,1,0,'C');
				$pdf->Cell(1,1,null,0,0,'C');
				
				// Cuadro 1 Marco Derecha
				$pdf->Cell(42,7,null,0,0,'C');
				//Espacio Entre Marcos
				$pdf->Cell(1,1,null,0,0,'C');
				// Cuadro 1 Marco Derecha
				$pdf->Cell(25,22,null,1,0,'C');
				//Espacio Entre Marcos
				$pdf->Cell(4,4,null,0,0,'C');
				
				// Direccion y Telefono Izquierda
				 $pdf->SetY(217);
				 $pdf->SetX(123);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, "Cra. 26 A No. 1D - 53", 0);
				 $pdf->SetY(220);
				 $pdf->SetX(123);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, "Tels.: 2012415 - 3513534", 0);
				 $pdf->SetY(223);
				 $pdf->SetX(112.5);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, ($guia[$i]['orden_despacho']), 0);

				 // Linea 1
				 $pdf->SetY(230);
				 $pdf->SetX(113);
				 $pdf->SetFont('Arial','',5);
				 $pdf->Cell(20, 5, "Destinatario :", 0);		 
				 
				 // Linea 2
				 $pdf->SetY(233);
				 $pdf->SetX(113);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,27), 0);
				 $pdf->SetY(235);
				 $pdf->SetX(113);
				 //$pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 27,27), 0);
				 $pdf->SetY(237);
				 $pdf->SetX(113);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,30), 0);
				 $pdf->SetY(239);
				 $pdf->SetX(113);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,30).' '.ucfirst(strtolower($guia[$i]['destino'])), 0);
				 
				// Fin Cuadro 1
				// Cuadro 2
				$pdf->SetY(243);
				$pdf->SetX(113);	 	
				$pdf->Cell(27,10,null,1,0,'C');
				// Fin Cuadro 2
				//Espacio Entre Columnas
				$pdf->Cell(1,1,null,0,0,'C');
				// Cuadro 3
				$pdf->Cell(42,7,null,0,0,'C');
				$pdf->SetY(253);
				$pdf->SetX(113);
				$pdf->Cell(27,13,null,1,0,'C');
				$pdf->SetY(252);
				$pdf->SetX(184);	 	
				$pdf->Cell(25,14,null,1,0,'C');
				 // Linea 1
				 $pdf->SetY(254);
				 $pdf->SetX(113);
				 $pdf->Cell(20, 3, "Remitente :", 0);
				  // Linea 2 
				 $pdf->SetY(257);
				 $pdf->SetX(113);
				 $pdf->Cell(18, 3, substr(utf8_decode($guia[$i]['remitente']), 0,23), 0);
				 $pdf->SetY(259);
				 $pdf->SetX(113);
				 $pdf->Cell(18, 3, substr(utf8_decode($guia[$i]['remitente']), 23,22), 0);
				 $pdf->SetY(261);
				 $pdf->SetX(113);
				 $pdf->Cell(18, 3, substr(utf8_decode(str_replace("OFICINA","OFI",$guia[$i]['direccion_remitente'])), 0,30), 0);
				 $pdf->SetY(263);
				 $pdf->SetX(113);
				 $pdf->Cell(18, 3, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_remitente']), 0,30).' '.ucfirst(strtolower($guia[$i]['origen'])), 0);
				 
				// Fin Cuadro 3

				 $pdf->SetY(231);
				 $pdf->SetX(185);
				 $pdf->Cell(20, 3, "Destinatario", 1);
				 $pdf->SetY(233);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,27), 0);
				 $pdf->SetY(235);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,30), 0);
				 $pdf->SetY(237);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 30,30), 0);
				 $pdf->SetY(239);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,30), 0);
				 $pdf->SetY(241);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, $guia[$i]['destino'], 0);


				 $pdf->SetY(256);				 
				 $pdf->SetX(184);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['remitente']), 0,18), 0);
				 $pdf->SetY(258);				 
				 $pdf->SetX(184);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['remitente']), 18,18), 0);
				 $pdf->SetY(260);				 
				 $pdf->SetX(184);
				 $pdf->Cell(18, 5, substr(utf8_decode(str_replace("OFICINA","OFI",$guia[$i]['direccion_remitente'])), 0,30), 0);
				 $pdf->SetY(262);				 
				 $pdf->SetX(184);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_remitente']), 0,30).' '.ucfirst(strtolower($guia[$i]['origen'])), 0);

				 // Fila 2 Cuadro derecho joh
				 
				 $pdf->SetY(247);
				 $pdf->SetX(184);
				 $pdf->Cell(25, 5," ", 1);
				 $pdf->SetY(247);
				 $pdf->SetX(183.5);
				 $pdf->SetFont('Arial','',4);
				 $pdf->Cell(18,2, 'PESO '.substr(utf8_decode($guia[$i]['peso']).' '.$guia[$i]['medida'], 0,20),'',0);
				 $pdf->SetY(249);
				 $pdf->SetX(183.5);
				 $pdf->SetFont('Arial','',4);
				 $pdf->Cell(18,2, 'VR. ENVIO '.number_format($guia[$i]['valor_total'],0,',','.'),0,0);
				
				 
				 $pdf->SetY(253);
				 $pdf->SetX(185);
				 $pdf->Cell(20, 3, "Remitente", 1);

				 //CUADRO DERECHO FECHA HORA CODIGO MENSAJERO
 				 $pdf->SetY(243);	 	
				 $pdf->SetX(113);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(17,2,'FECHA',1);
 				 $pdf->SetY(245);	 	
				 $pdf->SetX(130);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,2,'HORA',1);

 				 $pdf->SetY(245);	 	
				 $pdf->SetX(113);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(17,4,'',1);
 				 $pdf->SetY(245);	 	
				 $pdf->SetX(130);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,4,'',1);
 				 $pdf->SetY(248);	 	
				 $pdf->SetX(112);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,4,'COD. MENS',0);

				 //PARTE DE CENTRO
 				 $pdf->SetY(230);	 	
				 $pdf->SetX(142);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,36,'',1);

 				 $pdf->SetY(230);	 	
				 $pdf->SetX(142);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,9,'',1);


 				 $pdf->SetY(231);	 	
				 $pdf->SetX(144);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(12,2,'ENT.ALMACEN',1);

 				 $pdf->SetY(231);	 	
				 $pdf->SetX(156);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(9,2,'REMISION',1);

 				 $pdf->SetY(231);	 	
				 $pdf->SetX(165);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(6,2,'ZONA',1);
 				 $pdf->SetY(233);	 	
				 $pdf->SetX(165);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(6,6,utf8_decode($guia[$i]['zona']),1);

 				 $pdf->SetY(231);	 	
				 $pdf->SetX(171);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(12,2,'CONSECUTIVO',1);

 				 $pdf->SetY(239);	 	
				 $pdf->SetX(142);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,8,'',1);


 				 $pdf->SetY(240);	 	
				 $pdf->SetX(147);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(11,2,'MENSAJERO',1);

 				 $pdf->SetY(240);	 	
				 $pdf->SetX(160);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,2,'FECHA ENT.',1);

 				 $pdf->SetY(240);	 	
				 $pdf->SetX(172);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(9,2,'HORA ENT.',1);


 				 $pdf->SetY(263);	 	
				 $pdf->SetX(143);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(14,2,'RECIBIDO POR',1);
				 
 				 $pdf->SetY(264);	 	
				 $pdf->SetX(167);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Impreso '. date("Y-m-d"),0);
				
 				 $pdf->SetY(247);	 	
				 $pdf->SetX(142);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,9,'',1);

 				 $pdf->SetY(247);	 	
				 $pdf->SetX(142);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(8,2,'DEVOL',1);

 				 $pdf->SetY(250);	 	
				 $pdf->SetX(143);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(14,2,'DESCONOCIDO',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(11,2,'REHUSADO',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(10,2,'NO RESIDE',0);

 				 $pdf->SetY(253);	 	
				 $pdf->SetX(143);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(14,2,'DIR INCOMPLETA',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(11,2,'DIR ERRADA',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(10,2,'OTRO',0);
				 //FIN PARTE DE CENTRO

 				 $pdf->SetY(221);	 	
				 $pdf->SetX(154);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Res. MINTIC No 4304 de 2013',0);
				 
				 $pdf->SetY(223);	 	
				 $pdf->SetX(154);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,($guia[$i]['tipo_servicio']),0);
				 if(!empty($guia[$i]['orden_despacho'])){
					 $pdf->SetY(225);	 	
					 $pdf->SetX(154);
					 $pdf->Cell(14,2,'Doc. Cliente: '.$guia[$i]['orden_despacho'],0);
				 }
				 

 				 //FIN CUADRO DERECHO FECHA HORA CODIGO MENSAJERO


				// Fin Fila 4 Columna 2
			}

			if($j == 9){ $pdf->AddPage('P','Letter','mm'); $j=0;  }else{ $j++; } 

		  }	 	
			
		  $pdf->Output(); //Env�a como salida del documento  
	 	}elseif($_REQUEST['formato']=='RT'){
		 	//Inicia Impresion rotulos
		
			$pdf=new FPDF(); // Crea un objeto de la clase fpdf()
			$pdf->AddPage('P','Letter','mm'); // Agrega una hoja al documento.
			$pdf->SetFont('Arial','B',9); //Establece la fuente a utilizar, el formato Negrita y el tama�o
		
			#Establecemos los m�rgenes izquierda, arriba y derecha:
			$pdf->SetMargins(3, 4 , 3);
		
			#Establecemos el margen inferior:
			$pdf->SetAutoPageBreak(true,1);  
		
			$j=0;
			$t=0;

			for($i = 0; $i < count($guia); $i++){	
			 $t++;
			 if($j==0){
			 
				 // Copia 1
				 $pdf->SetY(8);
				 $pdf->SetX(7);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(11);				 
				 $pdf->SetX(7);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(15);				 
				 $pdf->SetX(7);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(19);
				 $pdf->SetX(7);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			 }
			if($j==1){
				 // Copia 1
				 $pdf->SetY(8);
				 $pdf->SetX(58);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(11);				 
				 $pdf->SetX(58);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(15);				 
				 $pdf->SetX(58);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(19);
				 $pdf->SetX(58);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			 
			}
			
			if($j==2){
				 // Copia 1
				 $pdf->SetY(8);
				 $pdf->SetX(110);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(11);				 
				 $pdf->SetX(110);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(15);				 
				 $pdf->SetX(110);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(19);
				 $pdf->SetX(110);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			}
			 
			if($j==3){
				 // Copia 1
				 $pdf->SetY(8);
				 $pdf->SetX(161);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(11);				 
				 $pdf->SetX(161);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(15);				 
				 $pdf->SetX(161);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(19);
				 $pdf->SetX(161);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			}

			 if($j==4){
				 // Copia 1
				 $pdf->SetY(28);
				 $pdf->SetX(7);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(31);				 
				 $pdf->SetX(7);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(35);				 
				 $pdf->SetX(7);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(39);
				 $pdf->SetX(7);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			 }
			if($j==5){
				 // Copia 1
				 $pdf->SetY(28);
				 $pdf->SetX(58);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(31);				 
				 $pdf->SetX(58);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(35);				 
				 $pdf->SetX(58);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(39);
				 $pdf->SetX(58);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			 
			}
			
			if($j==6){
				 // Copia 1
				 $pdf->SetY(28);
				 $pdf->SetX(110);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(31);				 
				 $pdf->SetX(110);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(35);				 
				 $pdf->SetX(110);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(39);
				 $pdf->SetX(110);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			}
			 
			if($j==7){
				 // Copia 1
				 $pdf->SetY(28);
				 $pdf->SetX(161);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(31);				 
				 $pdf->SetX(161);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(35);				 
				 $pdf->SetX(161);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(39);
				 $pdf->SetX(161);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			}

			 if($j==8){
			 
				 // Copia 1
				 $pdf->SetY(50);
				 $pdf->SetX(7);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(53);				 
				 $pdf->SetX(7);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(57);				 
				 $pdf->SetX(7);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(61);
				 $pdf->SetX(7);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			 }
			if($j==9){
				 // Copia 1
				 $pdf->SetY(50);
				 $pdf->SetX(58);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(53);				 
				 $pdf->SetX(58);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(57);				 
				 $pdf->SetX(58);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(61);
				 $pdf->SetX(58);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			 
			}
			
			if($j==10){
				 // Copia 1
				 $pdf->SetY(50);
				 $pdf->SetX(110);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(53);				 
				 $pdf->SetX(110);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(57);				 
				 $pdf->SetX(110);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(61);
				 $pdf->SetX(110);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			}
			 
			if($j==11){
				 // Copia 1
				 $pdf->SetY(50);
				 $pdf->SetX(161);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(53);				 
				 $pdf->SetX(161);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(57);				 
				 $pdf->SetX(161);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(61);
				 $pdf->SetX(161);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			}

			 if($j==12){
			 
				 // Copia 1
				 $pdf->SetY(72);
				 $pdf->SetX(7);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(75);				 
				 $pdf->SetX(7);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(79);				 
				 $pdf->SetX(7);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(83);
				 $pdf->SetX(7);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			 }
			if($j==13){
				 // Copia 1
				 $pdf->SetY(72);
				 $pdf->SetX(58);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(75);				 
				 $pdf->SetX(58);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(79);				 
				 $pdf->SetX(58);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(83);
				 $pdf->SetX(58);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			 
			}
			
			if($j==14){
				 // Copia 1
				 $pdf->SetY(72);
				 $pdf->SetX(110);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(75);				 
				 $pdf->SetX(110);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(79);				 
				 $pdf->SetX(110);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(83);
				 $pdf->SetX(110);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			}
			 
			if($j==15){
				 // Copia 1
				 $pdf->SetY(72);
				 $pdf->SetX(161);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(75);				 
				 $pdf->SetX(161);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(79);				 
				 $pdf->SetX(161);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(83);
				 $pdf->SetX(161);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			}

			 if($j==16){
			 
				 // Copia 1
				 $pdf->SetY(94);
				 $pdf->SetX(7);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(97);				 
				 $pdf->SetX(7);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(101);				 
				 $pdf->SetX(7);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(105);
				 $pdf->SetX(7);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			 }
			if($j==17){
				 // Copia 1
				 $pdf->SetY(94);
				 $pdf->SetX(58);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(97);				 
				 $pdf->SetX(58);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(101);				 
				 $pdf->SetX(58);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(105);
				 $pdf->SetX(58);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			 
			}
			
			if($j==18){
				 // Copia 1
				 $pdf->SetY(94);
				 $pdf->SetX(110);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(97);				 
				 $pdf->SetX(110);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(101);				 
				 $pdf->SetX(110);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(105);
				 $pdf->SetX(110);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			}
			 
			if($j==19){
				 // Copia 1
				 $pdf->SetY(94);
				 $pdf->SetX(161);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(97);				 
				 $pdf->SetX(161);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(101);				 
				 $pdf->SetX(161);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(105);
				 $pdf->SetX(161);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			}

			 if($j==20){
			 
				 // Copia 1
				 $pdf->SetY(116);
				 $pdf->SetX(7);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(119);				 
				 $pdf->SetX(7);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(123);				 
				 $pdf->SetX(7);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(127);
				 $pdf->SetX(7);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			 }
			if($j==21){
				 // Copia 1
				 $pdf->SetY(116);
				 $pdf->SetX(58);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(119);				 
				 $pdf->SetX(58);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(123);				 
				 $pdf->SetX(58);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(127);
				 $pdf->SetX(58);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			 
			}
			
			if($j==22){
				 // Copia 1
				 $pdf->SetY(116);
				 $pdf->SetX(110);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(119);				 
				 $pdf->SetX(110);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(123);				 
				 $pdf->SetX(110);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(127);
				 $pdf->SetX(110);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			}
			 
			if($j==23){
				 // Copia 1
				 $pdf->SetY(116);
				 $pdf->SetX(161);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(119);				 
				 $pdf->SetX(161);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(123);				 
				 $pdf->SetX(161);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(127);
				 $pdf->SetX(161);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			}

			 if($j==24){
			 
				 // Copia 1
				 $pdf->SetY(138);
				 $pdf->SetX(7);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(141);				 
				 $pdf->SetX(7);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(145);				 
				 $pdf->SetX(7);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(149);
				 $pdf->SetX(7);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			 }
			if($j==25){
				 // Copia 1
				 $pdf->SetY(138);
				 $pdf->SetX(58);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(141);				 
				 $pdf->SetX(58);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(145);				 
				 $pdf->SetX(58);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(149);
				 $pdf->SetX(58);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			 
			}
			
			if($j==26){
				 // Copia 1
				 $pdf->SetY(138);
				 $pdf->SetX(110);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(141);				 
				 $pdf->SetX(110);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(145);				 
				 $pdf->SetX(110);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(149);
				 $pdf->SetX(110);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			}
			 
			if($j==27){
				 // Copia 1
				 $pdf->SetY(138);
				 $pdf->SetX(161);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(141);				 
				 $pdf->SetX(161);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(145);				 
				 $pdf->SetX(161);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(149);
				 $pdf->SetX(161);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			}


			 if($j==28){
			 
				 // Copia 1
				 $pdf->SetY(158);
				 $pdf->SetX(7);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(161);				 
				 $pdf->SetX(7);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(165);				 
				 $pdf->SetX(7);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(169);
				 $pdf->SetX(7);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			 }
			if($j==29){
				 // Copia 1
				 $pdf->SetY(158);
				 $pdf->SetX(58);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(161);				 
				 $pdf->SetX(58);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(165);				 
				 $pdf->SetX(58);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(169);
				 $pdf->SetX(58);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			 
			}
			
			if($j==30){
				 // Copia 1
				 $pdf->SetY(158);
				 $pdf->SetX(110);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(161);				 
				 $pdf->SetX(110);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(165);				 
				 $pdf->SetX(110);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(169);
				 $pdf->SetX(110);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			}
			 
			if($j==31){
				 // Copia 1
				 $pdf->SetY(158);
				 $pdf->SetX(161);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(161);				 
				 $pdf->SetX(161);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(165);				 
				 $pdf->SetX(161);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(169);
				 $pdf->SetX(161);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			}

			 if($j==32){
			 
				 // Copia 1
				 $pdf->SetY(178);
				 $pdf->SetX(7);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(181);				 
				 $pdf->SetX(7);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(185);				 
				 $pdf->SetX(7);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(189);
				 $pdf->SetX(7);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			 }
			if($j==33){
				 // Copia 1
				 $pdf->SetY(178);
				 $pdf->SetX(58);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(181);				 
				 $pdf->SetX(58);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(185);				 
				 $pdf->SetX(58);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(189);
				 $pdf->SetX(58);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			 
			}
			
			if($j==34){
				 // Copia 1
				 $pdf->SetY(178);
				 $pdf->SetX(110);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(181);				 
				 $pdf->SetX(110);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(185);				 
				 $pdf->SetX(110);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(189);
				 $pdf->SetX(110);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			}
			 
			if($j==35){
				 // Copia 1
				 $pdf->SetY(178);
				 $pdf->SetX(161);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(181);				 
				 $pdf->SetX(161);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(185);				 
				 $pdf->SetX(161);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(189);
				 $pdf->SetX(161);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			}

			 if($j==36){
			 
				 // Copia 1
				 $pdf->SetY(198);
				 $pdf->SetX(7);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(201);				 
				 $pdf->SetX(7);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(205);				 
				 $pdf->SetX(7);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(209);
				 $pdf->SetX(7);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			 }
			if($j==37){
				 // Copia 1
				 $pdf->SetY(198);
				 $pdf->SetX(58);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(201);				 
				 $pdf->SetX(58);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(205);				 
				 $pdf->SetX(58);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(209);
				 $pdf->SetX(58);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			 
			}
			
			if($j==38){
				 // Copia 1
				 $pdf->SetY(198);
				 $pdf->SetX(110);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(201);				 
				 $pdf->SetX(110);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(205);				 
				 $pdf->SetX(110);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(209);
				 $pdf->SetX(110);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			}
			 
			if($j==39){
				 // Copia 1
				 $pdf->SetY(198);
				 $pdf->SetX(161);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(201);				 
				 $pdf->SetX(161);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(205);				 
				 $pdf->SetX(161);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(209);
				 $pdf->SetX(161);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			}


			 if($j==40){
			 
				 // Copia 1
				 $pdf->SetY(218);
				 $pdf->SetX(7);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(221);				 
				 $pdf->SetX(7);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(225);				 
				 $pdf->SetX(7);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(229);
				 $pdf->SetX(7);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			 }
			if($j==41){
				 // Copia 1
				 $pdf->SetY(218);
				 $pdf->SetX(58);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(221);				 
				 $pdf->SetX(58);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(225);				 
				 $pdf->SetX(58);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(229);
				 $pdf->SetX(58);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			 
			}
			
			if($j==42){
				 // Copia 1
				 $pdf->SetY(218);
				 $pdf->SetX(110);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(221);				 
				 $pdf->SetX(110);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(225);				 
				 $pdf->SetX(110);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(229);
				 $pdf->SetX(110);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			}
			 
			if($j==43){
				 // Copia 1
				 $pdf->SetY(218);
				 $pdf->SetX(161);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(221);				 
				 $pdf->SetX(161);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(225);				 
				 $pdf->SetX(161);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(229);
				 $pdf->SetX(161);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			}
			
			if($j==44){
				 // Copia 1
				 $pdf->SetY(238);
				 $pdf->SetX(7);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(241);				 
				 $pdf->SetX(7);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(245);				 
				 $pdf->SetX(7);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(249);
				 $pdf->SetX(7);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			}
		
			if($j==45){
				 // Copia 1
				 $pdf->SetY(238);
				 $pdf->SetX(58);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(241);				 
				 $pdf->SetX(58);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(245);				 
				 $pdf->SetX(58);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(249);
				 $pdf->SetX(58);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			}
			
			if($j==46){
				 // Copia 1
				 $pdf->SetY(238);
				 $pdf->SetX(110);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(241);				 
				 $pdf->SetX(110);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(245);				 
				 $pdf->SetX(110);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(249);
				 $pdf->SetX(110);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			}
			
			if($j==47){
				 // Copia 1
				 $pdf->SetY(238);
				 $pdf->SetX(161);
				 $pdf->SetFont('Arial','',8);	
				 //$pdf->Cell(20, 3, "DESTINATARIO", 0);
				 $pdf->SetY(241);				 
				 $pdf->SetX(161);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,32), 0);
				 $pdf->SetY(245);				 
				 $pdf->SetX(161);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,32), 0);
				 $pdf->SetY(249);
				 $pdf->SetX(161);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'].' - '. $t, 0);
			}
			
			if($j == 47){ $pdf->AddPage('P','Letter','mm'); $j=0;  }else{ $j++; } 

		  }	 	
			
		  $pdf->Output(); //Env�a como salida del documento  
	 				
		}elseif($_REQUEST['formato']=='MT'){ //impresion mintic
			$pdf=new FPDF(); // Crea un objeto de la clase fpdf()
			$pdf->AddPage('P','Legal','mm'); // Agrega una hoja al documento.
			$pdf->SetFont('Arial','B',8); //Establece la fuente a utilizar, el formato Negrita y el tama�o
		
			#Establecemos los m�rgenes izquierda, arriba y derecha:
			$pdf->SetMargins(4,1,4,3);
		
			#Establecemos el margen inferior:
			//$pdf->SetAutoPageBreak(true,1);  
			$j=0;
			$t=0;
			
			for($i = 0; $i < count($guia); $i++){
				
			 $t++;
			 
			 if($j==0){
				 
				 $pdf->Cell(98,50,null,0,0,'');
				 $pdf->Cell(98,50,null,0,0,'');
				 
				 // Copia 1
				 //Encabezado
				 $pdf->SetX(40);
				 $pdf->SetY(10);	
				 $pdf->Image($guia[$i]['logo'],4,13,10,7); 
				 $pdf->Image($guia[$i]['codbar'],62,13,37,7); 
				 $pdf->Image($guia[$i]['logo'],34,13,10,7);
				 $pdf->SetFont('Arial','',4);	 
				 $pdf->Cell(55,8,"NIT. $nit_empresa",0,0,'R');		 
				 $pdf->Ln(3);	 
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(57,6,$guia[$i]['pagina_web'],0,0,'R');		 	 
				 $pdf->Ln(3);	 
				 $pdf->SetFont('Arial','B',7);		 	 	 
				 $pdf->Cell(165,12,$guia[$i]['numero_guia_bar'],0,0,'C');		 	 	 
				 $pdf->Ln(9);	

				 // Cuadro 1 Marco Izquierda	
				 $pdf->Cell(27,20,null,1,0,'C');
				 
				 //Espacio Entre Marcos
				 $pdf->Cell(1,1,null,0,0,'C');
				 
				 // Cuadro 1 Marco Centro
				 $pdf->Cell(42,10,null,0,0,'C');
				 
				  //Espacio Entre Marcos
				 $pdf->Cell(1,1,null,0,0,'C');
				 
				 //Espacio Entre Marcos
				 $pdf->Cell(4,4,null,0,0,'C');
				 
				 // Direccion y Telefono Encabezado Izquierda
				 $pdf->SetY(13);
				 $pdf->SetX(14);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, "Cra. 26 A No. 1D - 53", 0);
				 $pdf->SetY(16);
				 $pdf->SetX(14);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, "Tels.: 2012415 - 3513534", 0);
				 
				 // Cod Cliente Izquierda
	 			 $pdf->SetY(20);
				 $pdf->SetX(3);
				 $pdf->SetFont('Arial','',6);	
				 $pdf->Cell(20, 5,$guia[$i]['orden_despacho'], 0);
				 
				  // Numero de Orden de Servicio Izquierda
	 			 $pdf->SetY(24);
				 $pdf->SetX(20);
				 $pdf->SetFont('Arial','',6);	
				 $pdf->Cell(18, 5,'O.S.  '.substr(strtoupper($guia[$i]['solicitud_id']), 0,50), 0);
				 
				 // Numero de Guia Izquierda
				 $pdf->SetY(24);				 
				 $pdf->SetX(3);
				 $pdf->SetFont('Arial','',6);
				 $pdf->Cell(20, 5,$guia[$i]['numero_guia_bar'], 0);

				 
				 //Encabezado Central
				 $pdf->SetY(22);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Res. MINTIC 4304 de 2013',0);
				 					 
				 $pdf->SetY(17);	 	
				 $pdf->SetX(51);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,($guia[$i]['tipo_servicio']),0);
				 if(!empty($guia[$i]['orden_despacho'])){
					 $pdf->SetY(20);	 	
					 $pdf->SetX(33);
					 $pdf->Cell(14,2,'Doc. Cliente: '.$guia[$i]['orden_despacho'],0);
					 $pdf->SetY(23);	 	
					 $pdf->SetX(45);
					 //$pdf->Cell(14,2,$t,0);
				  }
				 $pdf->SetY(17);	 	
				 $pdf->SetX(45);
				 $pdf->Cell(14,2,$t,0);

				 // Fila 1 Cuadro 1 Remitente Izquierda
				 $pdf->SetX(40);
				 $pdf->SetY(28);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(20, 6, "Remitente :", 0);
				 
				 // Fila 2 Cuadro 1 Remitente Izquierda
				 $pdf->SetX(40);
				 $pdf->SetY(30);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['remitente']), 0,23), 0);
				 $pdf->SetX(40);
				 $pdf->SetY(32);
				 $pdf->Cell(18, 5, substr(strtoupper($guia[$i]['remitente']), 23,22), 0);
				 $pdf->SetX(40);
				 $pdf->SetY(35);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['direccion_remitente']), 0,30), 0);
				 $pdf->SetX(40);
				 $pdf->SetY(38);
				 $pdf->Cell(18, 6, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_remitente']), 0,22), 0);
				 $pdf->SetX(40);
				 $pdf->SetY(41);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['origen1']), 0,22), 0);
				 // Cuadro 2 Remitente Izquierda - Cuadro Codigo Mensajeria
				 $pdf->SetX(40);
				 $pdf->SetY(45);	 	
				 $pdf->Cell(27,18,null,1,0,'C');
				 //Espacio Entre Marcos
				 $pdf->Cell(1,1,null,0,0,'C');
				 
				 //Cuadro Inferior
				 $pdf->SetX(40);
				 $pdf->SetY(56);	 
				 $pdf->Cell(27,24,null,1,0,'C');  
				 $pdf->SetX(40);
				 $pdf->SetY(56);
				 
     			 // Fila 1 Cuadro 3 Destinatario Izquierda
				 $pdf->SetX(40);
				 $pdf->SetY(62);
				 $pdf->Cell(20, 6, "Destinatario :", 0); 	 	 	 
				 
				 // Fila 2 Cuadro 3 Destinatario Izquierda
				 $pdf->SetX(39);
				 $pdf->SetY(65);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['destinatario']), 0,23), 0);
				 $pdf->SetX(39);
				 $pdf->SetY(67);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['destinatario']), 23,22), 0);
				 $pdf->SetX(39);
				 $pdf->SetY(70);
				 $pdf->Cell(18, 6, substr(strtoupper(str_replace("OFICINA","OFI",$guia[$i]['direccion_destinatario'])), 0,30), 0);
				 $pdf->SetX(39);				 
				 $pdf->SetY(73);
				 $pdf->Cell(18, 6, 'Tel. '.substr(strtoupper($guia[$i]['telefono_destinatario']), 0,22), 0);
				 $pdf->SetX(39);				 
				 $pdf->SetY(76);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['destino1']), 0,22), 0);
				 
				 //CUADRO IZQUIERDO FECHA HORA CODIGO MENSAJERO
 				 $pdf->SetY(45);	 	
				 $pdf->SetX(4);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(17,5,'FECHA',1);
 				 $pdf->SetY(45);	 	
				 $pdf->SetX(21);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(10,5,'HORA',1);

 				 $pdf->SetY(50);	 	
				 $pdf->SetX(4);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(17,6,'',1);
 				 $pdf->SetY(50);	 	
				 $pdf->SetX(21);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,6,'',1);
 				 $pdf->SetY(55);	 	
				 $pdf->SetX(3);
				 $pdf->SetFont('Arial','',4.5);	
				 $pdf->Cell(10,5,'COD. MENS',0);
				 
			 
     			 //PARTE DE CENTRO
 				 $pdf->SetY(25);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(66,55,'',1);
				 
				 // Numero de Orden de Servicio
				 $pdf->SetY(24);				 
				 $pdf->SetX(88);
				 $pdf->SetFont('Arial','',6);
				 $pdf->Cell(18, 5,'O.S.  '.substr(strtoupper($guia[$i]['solicitud_id']), 0,50), 0);

				 // Parte 1 Cuadro Centro - Remitente
				
				 $pdf->SetY(26);
				 $pdf->SetX(36);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(20, 3.5, "Remitente", 1);
				 $pdf->SetY(30);				 
				 $pdf->SetX(34.5);
				 $pdf->Cell(18, 5, substr(strtoupper($guia[$i]['remitente']), 0,50), 0);
				 $pdf->SetY(33);				 
				 $pdf->SetX(34.5);
				 $pdf->Cell(18, 5, substr(strtoupper($guia[$i]['direccion_remitente']), 0,60), 0);
				 $pdf->SetY(36);
				 $pdf->SetX(34.5);
				 $pdf->Cell(18, 5, 'Tel. '.substr(strtoupper($guia[$i]['telefono_remitente']), 0,22));
				 $pdf->SetY(39);
				 $pdf->SetX(34.5);
				 $pdf->Cell(18, 5, $guia[$i]['origen1'].'     Cod Pos Nal. '.$guia[$i]['postal_origen'], 0);
				 
				 // Parte 2 Cuadro Centro - Destinatario
				 $pdf->SetY(44);
				 $pdf->SetX(36);
				 $pdf->Cell(20, 3, "Destinatario", 1);
				 
				 $pdf->SetY(47);				 
				 $pdf->SetX(34.5);
				 $pdf->Cell(18, 5, substr(strtoupper($guia[$i]['destinatario']), 0,50), 0);
				 $pdf->SetY(50);				 
				 $pdf->SetX(34.5);
				 $pdf->Cell(18, 5, substr(strtoupper(trim(str_replace("OFICINA","OFI",$guia[$i]['direccion_destinatario']))), 0,60), 0);
				 $pdf->SetY(53);
				 $pdf->SetX(34.5);				 				 
				 $pdf->Cell(18, 5, 'Tel. '.substr(strtoupper($guia[$i]['telefono_destinatario']), 0,22), 0);
				 $pdf->SetY(56);
				 $pdf->SetX(34.5);				 				 
				 $pdf->Cell(18, 5, substr(strtoupper($guia[$i]['destino1']), 0,22).'     Cod Pos Nal. '.$guia[$i]['postal_destino'], 0);
				 $pdf->SetY(60);
				 $pdf->SetX(34.5);
				 $pdf->SetFont('Arial','',5);
				 $pdf->Cell(18,3, 'PESO '.substr(utf8_decode($guia[$i]['peso']).' '.$guia[$i]['medida'], 0,20),'',0);
				 $pdf->SetY(63);
				 $pdf->SetX(34.5);
				 $pdf->SetFont('Arial','',5);
				 $pdf->Cell(18,3, 'VR. ENVIO '.number_format($guia[$i]['valor_total'],0,',','.'),0,0);
				 
				 // Cuadro Devolucion
				 $pdf->SetY(66);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(32,14,'',1);

 				 $pdf->SetY(66);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(8,2,'DEVOL',1);

 				 $pdf->SetY(70);	 	
				 $pdf->SetX(34);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(13,2,'DESCONOCIDO',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(11,2,'REHUSADO',0);
				 
				 $pdf->SetY(73);	 	
				 $pdf->SetX(34);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(13,2,'NO RESIDE',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(14,2,'DIR INCOMPLETA',0);
				 
				 $pdf->SetY(76);	 	
				 $pdf->SetX(34);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(13,2,'DIR ERRADA',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(10,2,'OTRO',0);
				 
				 // Cuadro Devolucion
				 $pdf->SetY(66);	 	
				 $pdf->SetX(65);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(34,14,'',1);
				 
				 $pdf->SetY(77);	 	
				 $pdf->SetX(66);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(14,2,'RECIBIDO POR',1);
				 
				 $pdf->SetY(78);	 	
				 $pdf->SetX(82);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Impreso '. date("Y-m-d"),0);
				 
				 
				 //FIN PARTE DE CENTRO

 				 //FIN CUADRO DERECHO FECHA HORA CODIGO MENSAJERO
				 // Fin Fila 1 Columna 1
			 }
			 if($j==1){
				 
				 //Lado Derecho
				 $pdf->SetX(114);
				 $pdf->SetY(10);
				 $pdf->Image($guia[$i]['logo'],114,13,10,7); 
				 $pdf->Image($guia[$i]['codbar'],172,13,37,7); 
				 $pdf->Image($guia[$i]['logo'],144,13,10,7);
				 $pdf->SetFont('Arial','',4);	 
				 $pdf->Cell(165,8,"NIT. $nit_empresa",0,0,'R');		 
				 $pdf->Ln(3);	 
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(167,6,$guia[$i]['pagina_web'],0,0,'R');		 	 
				 $pdf->Ln(3);	 
				 $pdf->SetFont('Arial','B',7);		 	 	 
				 $pdf->Cell(385,12,$guia[$i]['numero_guia_bar'],0,0,'C');		 	 	 
				 $pdf->Ln(9);

				 // Fila 1 Columna 2
				 $pdf->SetY(25);	 	
				 $pdf->SetX(114);
				 $pdf->Cell(27,20,null,1,0,'C');
				 $pdf->Cell(1,1,null,0,0,'C');	
				 
				 // Cuadro 1 Marco Centro
				 $pdf->Cell(42,10,null,0,0,'C');
				 
				  //Espacio Entre Marcos
				 $pdf->Cell(1,1,null,0,0,'C');
				 
				 //Espacio Entre Marcos
				 $pdf->Cell(4,4,null,0,0,'C');
				 
				 // Direccion y Telefono Encabezado Izquierda
				 $pdf->SetY(13);
				 $pdf->SetX(124);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, "Cra. 26 A No. 1D - 53", 0);
				 $pdf->SetY(16);
				 $pdf->SetX(124);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, "Tels.: 2012415 - 3513534", 0);
				 
				 // Cod Cliente Izquierda
	 			 $pdf->SetY(20);
				 $pdf->SetX(113);
				 $pdf->SetFont('Arial','',6);	
				 $pdf->Cell(20, 5,$guia[$i]['orden_despacho'], 0);
				 
				 // Numero de Orden de Servicio Izquierda
	 			 $pdf->SetY(24);
				 $pdf->SetX(130);
				 $pdf->SetFont('Arial','',6);	
				 $pdf->Cell(18, 5,'O.S.  '.substr(strtoupper($guia[$i]['solicitud_id']), 0,50), 0);
				 
				  // Numero de Guia Izquierda
	 			 $pdf->SetY(24);
				 $pdf->SetX(113);
				 $pdf->SetFont('Arial','',6);	
				 $pdf->Cell(20, 5,$guia[$i]['numero_guia_bar'], 0);
				 
				 //Encabezado Central
				 $pdf->SetY(22);	 	
				 $pdf->SetX(143);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Res. MINTIC 4304 de 2013',0);
				 					 
				 $pdf->SetY(17);	 	
				 $pdf->SetX(162);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,($guia[$i]['tipo_servicio']),0);
				 if(!empty($guia[$i]['orden_despacho'])){
					 $pdf->SetY(20);	 	
					 $pdf->SetX(143);
					 $pdf->Cell(14,2,'Doc. Cliente: '.$guia[$i]['orden_despacho'],0);
					 $pdf->SetY(23);	 	
					 $pdf->SetX(155);
					 //$pdf->Cell(14,2,$t,0);
				  }
				 $pdf->SetY(17);	 	
				 $pdf->SetX(155);
				 $pdf->Cell(14,2,$t,0);
				 // Fila 1 Cuadro 1 Remitente Izquierda
				 $pdf->SetY(28);
				 $pdf->SetX(114);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(20, 6, "Remitente :", 0);
				 
				 // Fila 2 Cuadro 1 Remitente Izquierda
				 $pdf->SetY(30);
				 $pdf->SetX(114);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['remitente']), 0,23), 0);
				 $pdf->SetY(32);
				 $pdf->SetX(114);
				 $pdf->Cell(18, 5, substr(strtoupper($guia[$i]['remitente']), 23,22), 0);
				 $pdf->SetY(35);
				 $pdf->SetX(114);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['direccion_remitente']), 0,30), 0);
				 $pdf->SetY(38);
				 $pdf->SetX(114);
				 $pdf->Cell(18, 6, 'Tel. '.substr(strtoupper($guia[$i]['telefono_remitente']), 0,22), 0);
                 $pdf->SetY(41);
				 $pdf->SetX(114);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['origen1']), 0,22), 0);

				 // Cuadro 2 Remitente Izquierda - Cuadro Codigo Mensajeria
				 $pdf->SetY(45);	 	
				 $pdf->SetX(114);
				 $pdf->Cell(27,18,null,1,0,'C');
				 //Espacio Entre Marcos
				 $pdf->Cell(1,1,null,0,0,'C');
				 //$pdf->Cell(42,7,null,1,0,'C');
				 
				 //Cuadro Inferior
				 $pdf->SetY(56);	 
				 $pdf->SetX(114);
				 $pdf->Cell(27,24,null,1,0,'C');  
				 $pdf->SetY(56);
				 $pdf->SetX(114);
				 
     			 // Fila 1 Cuadro 3 Destinatario Izquierda
				 $pdf->SetY(62);
				 $pdf->SetX(114);
				 $pdf->Cell(20, 6, "Destinatario :", 0); 	 	 	 
				 
				 // Fila 2 Cuadro 3 Destinatario Izquierda
				 $pdf->SetY(65);
				 $pdf->SetX(114);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['destinatario']), 0,23), 0);
				 $pdf->SetY(67);
				 $pdf->SetX(114);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['destinatario']), 23,22), 0);
				 $pdf->SetY(70);
				 $pdf->SetX(114);
				 $pdf->Cell(18, 6, substr(strtoupper(str_replace("OFICINA","OFI",$guia[$i]['direccion_destinatario'])), 0,30), 0);
				 $pdf->SetY(73);
				 $pdf->SetX(114);
				 $pdf->Cell(18, 6, 'Tel. '.substr(strtoupper($guia[$i]['telefono_destinatario']), 0,22), 0);
				 $pdf->SetY(76);
				 $pdf->SetX(114);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['destino1']), 0,22), 0);
				 
				 //CUADRO IZQUIERDO FECHA HORA CODIGO MENSAJERO
 				 $pdf->SetY(45);	 	
				 $pdf->SetX(114);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(17,5,'FECHA',1);
 				 $pdf->SetY(45);	 	
				 $pdf->SetX(131);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(10,5,'HORA',1);

 				 $pdf->SetY(50);	 	
				 $pdf->SetX(114);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(17,6,'',1);
 				 $pdf->SetY(50);	 	
				 $pdf->SetX(131);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,6,'',1);
 				 $pdf->SetY(55);	 	
				 $pdf->SetX(113);
				 $pdf->SetFont('Arial','',4.5);	
				 $pdf->Cell(10,5,'COD. MENS',0);
				 
			 
     			 //PARTE DE CENTRO
 				 $pdf->SetY(25);	 	
				 $pdf->SetX(143);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(66,55,'',1);
					
				 // Numero de Orden de Servicio
				 $pdf->SetY(24);				 
				 $pdf->SetX(198);
				 $pdf->SetFont('Arial','',6);
				 $pdf->Cell(18, 5,'O.S.  '.substr(strtoupper($guia[$i]['solicitud_id']), 0,50), 0);	
					
				 // Parte 1 Cuadro Centro - Remitente
				
				 $pdf->SetY(26);
				 $pdf->SetX(146);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(20, 3.5, "Remitente", 1);
				 $pdf->SetY(30);				 
				 $pdf->SetX(144.5);
				 $pdf->Cell(18, 5, substr(strtoupper($guia[$i]['remitente']), 0,50), 0);
				 $pdf->SetY(33);				 
				 $pdf->SetX(144.5);
				 $pdf->Cell(18, 5, substr(strtoupper($guia[$i]['direccion_remitente']), 0,60), 0);
				 $pdf->SetY(36);
				 $pdf->SetX(144.5);
				 $pdf->Cell(18, 5, 'Tel. '.substr(strtoupper($guia[$i]['telefono_remitente']), 0,22));
				 $pdf->SetY(39);
				 $pdf->SetX(144.5);
				 $pdf->Cell(18, 5, $guia[$i]['origen1'].'     Cod Pos Nal. '.$guia[$i]['postal_origen'], 0);
				 
				 // Parte 2 Cuadro Centro - Destinatario
				 $pdf->SetY(44);
				 $pdf->SetX(146);
				 $pdf->Cell(20, 3, "Destinatario", 1);
				 
				 $pdf->SetY(47);				 
				 $pdf->SetX(144.5);
				 $pdf->Cell(18, 5, substr(strtoupper($guia[$i]['destinatario']), 0,50), 0);
				 $pdf->SetY(50);				 
				 $pdf->SetX(144.5);
				 $pdf->Cell(18, 5, substr(strtoupper(trim(str_replace("OFICINA","OFI",$guia[$i]['direccion_destinatario']))), 0,60), 0);
				 $pdf->SetY(53);
				 $pdf->SetX(144.5);				 				 
				 $pdf->Cell(18, 5, 'Tel. '.substr(strtoupper($guia[$i]['telefono_destinatario']), 0,22), 0);
				 $pdf->SetY(56);
				 $pdf->SetX(144.5);				 				 
				 $pdf->Cell(18, 5, substr(strtoupper($guia[$i]['destino1']), 0,22).'     Cod Pos Nal. '.$guia[$i]['postal_destino'], 0);
				 $pdf->SetY(60);
				 $pdf->SetX(144.5);
				 $pdf->SetFont('Arial','',5);
				 $pdf->Cell(18,3, 'PESO '.substr(utf8_decode($guia[$i]['peso']).' '.$guia[$i]['medida'], 0,20),'',0);
				 $pdf->SetY(63);
				 $pdf->SetX(144.5);
				 $pdf->SetFont('Arial','',5);
				 $pdf->Cell(18,3, 'VR. ENVIO '.number_format($guia[$i]['valor_total'],0,',','.'),0,0);
				 
				 // Cuadro Devolucion
				 $pdf->SetY(66);	 	
				 $pdf->SetX(143);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(32,14,'',1);

 				 $pdf->SetY(66);	 	
				 $pdf->SetX(143);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(8,2,'DEVOL',1);

 				 $pdf->SetY(70);	 	
				 $pdf->SetX(144);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(13,2,'DESCONOCIDO',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(11,2,'REHUSADO',0);
				 
				 $pdf->SetY(73);	 	
				 $pdf->SetX(144);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(13,2,'NO RESIDE',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(14,2,'DIR INCOMPLETA',0);
				 
				 $pdf->SetY(76);	 	
				 $pdf->SetX(144);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(13,2,'DIR ERRADA',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(10,2,'OTRO',0);
				 
				 // Cuadro Devolucion
				 $pdf->SetY(66);	 	
				 $pdf->SetX(175);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(34,14,'',1);
				 
				 $pdf->SetY(77);	 	
				 $pdf->SetX(176);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(14,2,'RECIBIDO POR',1);
				 
				 $pdf->SetY(78);	 	
				 $pdf->SetX(192);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Impreso '. date("Y-m-d"),0);
				 
				 
				 //FIN PARTE DE CENTRO

 				 //FIN CUADRO DERECHO FECHA HORA CODIGO MENSAJERO
				 // Fin Fila 1 Columna 1
			 
					 
			 }
			
			 // Fila 2 Columna 1
			 if($j==2){
				
				 // Copia 1
				 //Encabezado
				 $pdf->SetX(40);
				 $pdf->SetY(58);	
				 $pdf->Image($guia[$i]['logo'],4,96,10,7); 
				 $pdf->Image($guia[$i]['codbar'],62,96,37,7); 
				 $pdf->Image($guia[$i]['logo'],34,96,10,7);
				 $pdf->SetFont('Arial','',4);	 
				 $pdf->Cell(55,78,"NIT. $nit_empresa",0,0,'R');		 
				 $pdf->Ln(3);	 
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(57,76,$guia[$i]['pagina_web'],0,0,'R');		 	 
				 $pdf->Ln(3);	 
				 $pdf->SetFont('Arial','B',7);		 	 	 
				 $pdf->Cell(165,82,$guia[$i]['numero_guia_bar'],0,0,'C');		 	 	 
				 $pdf->Ln(9);	
				 
				 // Fila 1 Columna 2
				 $pdf->SetY(108);	 	
				 $pdf->SetX(4);
				 $pdf->Cell(27,20,null,1,0,'C');
				 $pdf->Cell(1,1,null,0,0,'C');	

				 // Cuadro 1 Marco Centro
				 $pdf->Cell(42,10,null,0,0,'C');
				 
				  //Espacio Entre Marcos
				 $pdf->Cell(1,1,null,0,0,'C');
				 
				 //Espacio Entre Marcos
				 $pdf->Cell(4,4,null,0,0,'C');
				 
				 // Direccion y Telefono Encabezado Izquierda
				 $pdf->SetY(96);
				 $pdf->SetX(14);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, "Cra. 26 A No. 1D - 53", 0);
				 $pdf->SetY(99);
				 $pdf->SetX(14);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, "Tels.: 2012415 - 3513534", 0);
				 
 				 // Cod Cliente Izquierda
	 			 $pdf->SetY(103);
				 $pdf->SetX(3);
				 $pdf->SetFont('Arial','',6);	
				 $pdf->Cell(20, 5,$guia[$i]['orden_despacho'], 0);
				 
 				 // Numero de Orden de Servicio Izquierda
	 			 $pdf->SetY(107);
				 $pdf->SetX(20);
				 $pdf->SetFont('Arial','',6);	
				 $pdf->Cell(18, 5,'O.S.  '.substr(strtoupper($guia[$i]['solicitud_id']), 0,50), 0);
				 			 
				  // Numero de Guia Izquierda
	 			 $pdf->SetY(107);
				 $pdf->SetX(3);
				 $pdf->SetFont('Arial','',6);	
				 $pdf->Cell(20, 5,$guia[$i]['numero_guia_bar'], 0);

				 
				 //Encabezado Central
				 $pdf->SetY(105);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Res. MINTIC 4304 de 2013',0);
				 					 
				 $pdf->SetY(100);	 	
				 $pdf->SetX(52);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,($guia[$i]['tipo_servicio']),0);
				 if(!empty($guia[$i]['orden_despacho'])){
					 $pdf->SetY(103);	 	
					 $pdf->SetX(33);
					 $pdf->Cell(14,2,'Doc. Cliente: '.$guia[$i]['orden_despacho'],0);
				 	 $pdf->SetY(106);	 	
					 $pdf->SetX(45);
					 //$pdf->Cell(14,2,$t,0);
				  }
				 $pdf->SetY(100);	 	
				 $pdf->SetX(45);
				 $pdf->Cell(14,2,$t,0);
				 // Fila 1 Cuadro 1 Remitente Izquierda
				 $pdf->SetX(40);
				 $pdf->SetY(111);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(20, 6, "Remitente :", 0);
				 
				 // Fila 2 Cuadro 1 Remitente Izquierda
				 $pdf->SetX(40);
				 $pdf->SetY(113);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['remitente']), 0,23), 0);
				 $pdf->SetX(40);
				 $pdf->SetY(115);
				 $pdf->Cell(18, 5, substr(strtoupper($guia[$i]['remitente']), 23,22), 0);
				 $pdf->SetX(40);
				 $pdf->SetY(118);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['direccion_remitente']), 0,30), 0);
				 $pdf->SetX(40);
				 $pdf->SetY(121);
				 $pdf->Cell(18, 6, 'Tel. '.substr(strtoupper($guia[$i]['telefono_remitente']), 0,22), 0);
                 $pdf->SetX(40);
				 $pdf->SetY(124);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['origen1']), 0,22), 0);

				 
				 // Cuadro 2 Remitente Izquierda - Cuadro Codigo Mensajeria
				 $pdf->SetX(40);
				 $pdf->SetY(128);	 	
				 $pdf->Cell(27,18,null,1,0,'C');
				 //Espacio Entre Marcos
				 $pdf->Cell(1,1,null,0,0,'C');
				 //$pdf->Cell(42,7,null,1,0,'C');
				 
				 //Cuadro Inferior
				 $pdf->SetX(40);
				 $pdf->SetY(139);	 
				 $pdf->Cell(27,24,null,1,0,'C');  
				 $pdf->SetX(40);
				 $pdf->SetY(140);
				 
     			 // Fila 1 Cuadro 3 Destinatario Izquierda
				 $pdf->SetX(40);
				 $pdf->SetY(145);
				 $pdf->Cell(20, 6, "Destinatario :", 0); 	 	 	 
				 
				 // Fila 2 Cuadro 3 Destinatario Izquierda
				 $pdf->SetX(39);
				 $pdf->SetY(148);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['destinatario']), 0,23), 0);
				 $pdf->SetX(39);
				 $pdf->SetY(150);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['destinatario']), 23,22), 0);
				 $pdf->SetX(39);
				 $pdf->SetY(153);
				 $pdf->Cell(18, 6, substr(strtoupper(str_replace("OFICINA","OFI",$guia[$i]['direccion_destinatario'])), 0,30), 0);
				 $pdf->SetX(39);				 
				 $pdf->SetY(156);
				 $pdf->Cell(18, 6, 'Tel. '.substr(strtoupper($guia[$i]['telefono_destinatario']), 0,22), 0);
				 $pdf->SetX(39);				 
				 $pdf->SetY(159);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['destino1']), 0,22), 0);
				 
				 //CUADRO IZQUIERDO FECHA HORA CODIGO MENSAJERO
 				 $pdf->SetY(128);	 	
				 $pdf->SetX(4);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(17,5,'FECHA',1);
 				 $pdf->SetY(128);	 	
				 $pdf->SetX(21);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(10,5,'HORA',1);

 				 $pdf->SetY(133);	 	
				 $pdf->SetX(4);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(17,6,'',1);
 				 $pdf->SetY(133);	 	
				 $pdf->SetX(21);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,6,'',1);
 				 $pdf->SetY(138);	 	
				 $pdf->SetX(3);
				 $pdf->SetFont('Arial','',4.5);	
				 $pdf->Cell(10,5,'COD. MENS',0);
				 
			 
     			 //PARTE DE CENTRO
 				 $pdf->SetY(108);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(66,55,'',1);

				 // Numero de Orden de Servicio
				 $pdf->SetY(107);				 
				 $pdf->SetX(88);
				 $pdf->SetFont('Arial','',6);
				 $pdf->Cell(18, 5,'O.S.  '.substr(strtoupper($guia[$i]['solicitud_id']), 0,50), 0);
				 
				 // Parte 1 Cuadro Centro - Remitente
				
				 $pdf->SetY(109);
				 $pdf->SetX(36);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(20, 3.5, "Remitente", 1);
				 $pdf->SetY(113);				 
				 $pdf->SetX(34.5);
				 $pdf->Cell(18, 5, substr(strtoupper($guia[$i]['remitente']), 0,50), 0);
				 $pdf->SetY(116);				 
				 $pdf->SetX(34.5);
				 $pdf->Cell(18, 5, substr(strtoupper($guia[$i]['direccion_remitente']), 0,60), 0);
				 $pdf->SetY(119);
				 $pdf->SetX(34.5);
				 $pdf->Cell(18, 5, 'Tel. '.substr(strtoupper($guia[$i]['telefono_remitente']), 0,22));
				 $pdf->SetY(122);
				 $pdf->SetX(34.5);
				 $pdf->Cell(18, 5, $guia[$i]['origen1'].'     Cod Pos Nal. '.$guia[$i]['postal_origen'], 0);
				 
				 // Parte 2 Cuadro Centro - Destinatario
				 $pdf->SetY(127);
				 $pdf->SetX(36);
				 $pdf->Cell(20, 3, "Destinatario", 1);
				 
				 $pdf->SetY(130);				 
				 $pdf->SetX(34.5);
				 $pdf->Cell(18, 5, substr(strtoupper($guia[$i]['destinatario']), 0,50), 0);
				 $pdf->SetY(133);				 
				 $pdf->SetX(34.5);
				 $pdf->Cell(18, 5, substr(strtoupper(trim(str_replace("OFICINA","OFI",$guia[$i]['direccion_destinatario']))), 0,60), 0);
				 $pdf->SetY(136);
				 $pdf->SetX(34.5);				 				 
				 $pdf->Cell(18, 5, 'Tel. '.substr(strtoupper($guia[$i]['telefono_destinatario']), 0,22), 0);
				 $pdf->SetY(139);
				 $pdf->SetX(34.5);				 				 
				 $pdf->Cell(18, 5, substr(strtoupper($guia[$i]['destino1']), 0,22).'     Cod Pos Nal. '.$guia[$i]['postal_destino'], 0);
				 $pdf->SetY(143);
				 $pdf->SetX(34.5);
				 $pdf->SetFont('Arial','',5);
				 $pdf->Cell(18,3, 'PESO '.substr(utf8_decode($guia[$i]['peso']).' '.$guia[$i]['medida'], 0,20),'',0);
				 $pdf->SetY(146);
				 $pdf->SetX(34.5);
				 $pdf->SetFont('Arial','',5);
				 $pdf->Cell(18,3, 'VR. ENVIO '.number_format($guia[$i]['valor_total'],0,',','.'),0,0);
				 
				 // Cuadro Devolucion
				 $pdf->SetY(149);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(32,14,'',1);

 				 $pdf->SetY(149);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(8,2,'DEVOL',1);

 				 $pdf->SetY(153);	 	
				 $pdf->SetX(34);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(13,2,'DESCONOCIDO',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(11,2,'REHUSADO',0);
				 
				 $pdf->SetY(156);	 	
				 $pdf->SetX(34);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(13,2,'NO RESIDE',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(14,2,'DIR INCOMPLETA',0);
				 
				 $pdf->SetY(159);	 	
				 $pdf->SetX(34);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(13,2,'DIR ERRADA',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(10,2,'OTRO',0);
				 
				 // Cuadro Devolucion
				 $pdf->SetY(149);	 	
				 $pdf->SetX(65);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(34,14,'',1);
				 
				 $pdf->SetY(160);	 	
				 $pdf->SetX(66);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(14,2,'RECIBIDO POR',1);
				 
				 $pdf->SetY(161);	 	
				 $pdf->SetX(82);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Impreso '. date("Y-m-d"),0);
				 
				 
				 //FIN PARTE DE CENTRO

 				 //FIN CUADRO DERECHO FECHA HORA CODIGO MENSAJERO
				 // Fin Fila 1 Columna 1
			 	 
			
			}
			 
			 if($j==3){
								 
				 //Lado Derecho
				 $pdf->SetX(109);
				 $pdf->SetY(93);
				 $pdf->Image($guia[$i]['logo'],114,96,10,7); 
				 $pdf->Image($guia[$i]['codbar'],172,96,37,7); 
				 $pdf->Image($guia[$i]['logo'],144,96,10,7);
				 $pdf->SetFont('Arial','',4);	 
				 $pdf->Cell(165,8,"NIT. $nit_empresa",0,0,'R');		 
				 $pdf->Ln(3);	 
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(167,6,$guia[$i]['pagina_web'],0,0,'R');		 	 
				 $pdf->Ln(3);	 
				 $pdf->SetFont('Arial','B',7);		 	 	 
				 $pdf->Cell(385,12,$guia[$i]['numero_guia_bar'],0,0,'C');		 	 	 
				 $pdf->Ln(9);

				 // Fila 1 Columna 2
				 $pdf->SetY(108);	 	
				 $pdf->SetX(114);
				 $pdf->Cell(27,20,null,1,0,'C');
				 $pdf->Cell(1,1,null,0,0,'C');	
				 
				 // Cuadro 1 Marco Centro
				 $pdf->Cell(42,10,null,0,0,'C');
				 
				  //Espacio Entre Marcos
				 $pdf->Cell(1,1,null,0,0,'C');
				 
				 //Espacio Entre Marcos
				 $pdf->Cell(4,4,null,0,0,'C');
				 
				 // Direccion y Telefono Encabezado Izquierda
				 $pdf->SetY(96);
				 $pdf->SetX(124);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, "Cra. 26 A No. 1D - 53", 0);
				 $pdf->SetY(99);
				 $pdf->SetX(124);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, "Tels.: 2012415 - 3513534", 0);
				 
  				 // Cod Cliente Izquierda
	 			 $pdf->SetY(103);
				 $pdf->SetX(113);
				 $pdf->SetFont('Arial','',6);	
				 $pdf->Cell(20, 5,$guia[$i]['orden_despacho'], 0);
				 
  				 // Numero de Orden de Servicio Izquierda
	 			 $pdf->SetY(107);
				 $pdf->SetX(130);
				 $pdf->SetFont('Arial','',6);	
				 $pdf->Cell(18, 5,'O.S.  '.substr(strtoupper($guia[$i]['solicitud_id']), 0,50), 0);
				 				 			 
				  // Numero de Guia Izquierda
	 			 $pdf->SetY(107);
				 $pdf->SetX(113);
				 $pdf->SetFont('Arial','',6);	
				 $pdf->Cell(20, 5,$guia[$i]['numero_guia_bar'], 0);

				 
				 //Encabezado Central
				 $pdf->SetY(105);	 	
				 $pdf->SetX(143);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Res. MINTIC 4304 de 2013',0);
				 					 
				 $pdf->SetY(100);	 	
				 $pdf->SetX(162);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,($guia[$i]['tipo_servicio']),0);
				 if(!empty($guia[$i]['orden_despacho'])){
					 $pdf->SetY(103);	 	
					 $pdf->SetX(143);
					 $pdf->Cell(14,2,'Doc. Cliente: '.$guia[$i]['orden_despacho'],0);
  					 $pdf->SetY(106);	 	
					 $pdf->SetX(155);
					 //$pdf->Cell(14,2,$t,0);
				  }
				 $pdf->SetY(100);	 	
				 $pdf->SetX(155);
				 $pdf->Cell(14,2,$t,0);
				 // Fila 1 Cuadro 1 Remitente Izquierda
				 $pdf->SetY(111);
				 $pdf->SetX(114);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(20, 6, "Remitente :", 0);
				 
				 // Fila 2 Cuadro 1 Remitente Izquierda
				 $pdf->SetY(113);
				 $pdf->SetX(114);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['remitente']), 0,23), 0);
				 $pdf->SetY(115);
				 $pdf->SetX(114);
				 $pdf->Cell(18, 5, substr(strtoupper($guia[$i]['remitente']), 23,22), 0);
				 $pdf->SetY(118);
				 $pdf->SetX(114);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['direccion_remitente']), 0,30), 0);
				 $pdf->SetY(121);
				 $pdf->SetX(114);
				 $pdf->Cell(18, 6, 'Tel. '.substr(strtoupper($guia[$i]['telefono_remitente']), 0,22), 0);
 				 $pdf->SetY(124);
				 $pdf->SetX(114);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['origen1']), 0,22), 0);
				

				 
				 // Cuadro 2 Remitente Izquierda - Cuadro Codigo Mensajeria
				 $pdf->SetY(128);	 	
				 $pdf->SetX(114);
				 $pdf->Cell(27,18,null,1,0,'C');
				 //Espacio Entre Marcos
				 $pdf->Cell(1,1,null,0,0,'C');
				 //$pdf->Cell(42,7,null,1,0,'C');
				 
				 //Cuadro Inferior
				 $pdf->SetY(139);	 
				 $pdf->SetX(114);
				 $pdf->Cell(27,24,null,1,0,'C');  
				 $pdf->SetY(139);
				 $pdf->SetX(114);
				 
     			 // Fila 1 Cuadro 3 Destinatario Izquierda
				 $pdf->SetY(145);
				 $pdf->SetX(114);
				 $pdf->Cell(20, 6, "Destinatario :", 0); 	 	 	 
				 
				 // Fila 2 Cuadro 3 Destinatario Izquierda
				 $pdf->SetY(148);
				 $pdf->SetX(114);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['destinatario']), 0,23), 0);
				 $pdf->SetY(150);
				 $pdf->SetX(114);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['destinatario']), 23,22), 0);
				 $pdf->SetY(153);
				 $pdf->SetX(114);
				 $pdf->Cell(18, 6, substr(strtoupper(str_replace("OFICINA","OFI",$guia[$i]['direccion_destinatario'])), 0,30), 0);
				 $pdf->SetY(156);
				 $pdf->SetX(114);
				 $pdf->Cell(18, 6, 'Tel. '.substr(strtoupper($guia[$i]['telefono_destinatario']), 0,22), 0);
				 $pdf->SetY(159);
				 $pdf->SetX(114);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['destino1']), 0,22), 0);
				 
				 //CUADRO IZQUIERDO FECHA HORA CODIGO MENSAJERO
 				 $pdf->SetY(128);	 	
				 $pdf->SetX(114);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(17,5,'FECHA',1);
 				 $pdf->SetY(128);	 	
				 $pdf->SetX(131);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(10,5,'HORA',1);

 				 $pdf->SetY(133);	 	
				 $pdf->SetX(114);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(17,6,'',1);
 				 $pdf->SetY(133);	 	
				 $pdf->SetX(131);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,6,'',1);
 				 $pdf->SetY(138);	 	
				 $pdf->SetX(113);
				 $pdf->SetFont('Arial','',4.5);	
				 $pdf->Cell(10,5,'COD. MENS',0);
				 
			 
     			 //PARTE DE CENTRO
 				 $pdf->SetY(108);	 	
				 $pdf->SetX(143);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(66,55,'',1);

				 // Numero de Orden de Servicio
				 $pdf->SetY(107);				 
				 $pdf->SetX(198);
				 $pdf->SetFont('Arial','',6);
				 $pdf->Cell(18, 5,'O.S.  '.substr(strtoupper($guia[$i]['solicitud_id']), 0,50), 0);
				 
				 // Parte 1 Cuadro Centro - Remitente
				
				 $pdf->SetY(109);
				 $pdf->SetX(146);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(20, 3.5, "Remitente", 1);
				 $pdf->SetY(113);				 
				 $pdf->SetX(144.5);
				 $pdf->Cell(18, 5, substr(strtoupper($guia[$i]['remitente']), 0,50), 0);
				 $pdf->SetY(116);				 
				 $pdf->SetX(144.5);
				 $pdf->Cell(18, 5, substr(strtoupper($guia[$i]['direccion_remitente']), 0,60), 0);
				 $pdf->SetY(119);
				 $pdf->SetX(144.5);
				 $pdf->Cell(18, 5, 'Tel. '.substr(strtoupper($guia[$i]['telefono_remitente']), 0,22));
				 $pdf->SetY(122);
				 $pdf->SetX(144.5);
				 $pdf->Cell(18, 5, $guia[$i]['origen1'].'     Cod Pos Nal. '.$guia[$i]['postal_origen'], 0);
				 
				 // Parte 2 Cuadro Centro - Destinatario
				 $pdf->SetY(127);
				 $pdf->SetX(146);
				 $pdf->Cell(20, 3, "Destinatario", 1);
				 
				 $pdf->SetY(130);				 
				 $pdf->SetX(144.5);
				 $pdf->Cell(18, 5, substr(strtoupper($guia[$i]['destinatario']), 0,50), 0);
				 $pdf->SetY(133);				 
				 $pdf->SetX(144.5);
				 $pdf->Cell(18, 5, substr(strtoupper(trim(str_replace("OFICINA","OFI",$guia[$i]['direccion_destinatario']))), 0,60), 0);
				 $pdf->SetY(136);
				 $pdf->SetX(144.5);				 				 
				 $pdf->Cell(18, 5, 'Tel. '.substr(strtoupper($guia[$i]['telefono_destinatario']), 0,22), 0);
				 $pdf->SetY(139);
				 $pdf->SetX(144.5);				 				 
				 $pdf->Cell(18, 5, substr(strtoupper($guia[$i]['destino1']), 0,22).'     Cod Pos Nal. '.$guia[$i]['postal_destino'], 0);
				 $pdf->SetY(143);
				 $pdf->SetX(144.5);
				 $pdf->SetFont('Arial','',5);
				 $pdf->Cell(18,3, 'PESO '.substr(utf8_decode($guia[$i]['peso']).' '.$guia[$i]['medida'], 0,20),'',0);
				 $pdf->SetY(146);
				 $pdf->SetX(144.5);
				 $pdf->SetFont('Arial','',5);
				 $pdf->Cell(18,3, 'VR. ENVIO '.number_format($guia[$i]['valor_total'],0,',','.'),0,0);
				 
				 // Cuadro Devolucion
				 $pdf->SetY(149);	 	
				 $pdf->SetX(143);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(32,14,'',1);

 				 $pdf->SetY(149);	 	
				 $pdf->SetX(143);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(8,2,'DEVOL',1);

 				 $pdf->SetY(153);	 	
				 $pdf->SetX(144);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(13,2,'DESCONOCIDO',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(11,2,'REHUSADO',0);
				 
				 $pdf->SetY(156);	 	
				 $pdf->SetX(144);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(13,2,'NO RESIDE',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(14,2,'DIR INCOMPLETA',0);
				 
				 $pdf->SetY(159);	 	
				 $pdf->SetX(144);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(13,2,'DIR ERRADA',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(10,2,'OTRO',0);
				 
				 // Cuadro Devolucion
				 $pdf->SetY(149);	 	
				 $pdf->SetX(175);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(34,14,'',1);
				 
				 $pdf->SetY(160);	 	
				 $pdf->SetX(176);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(14,2,'RECIBIDO POR',1);
				 
				 $pdf->SetY(161);	 	
				 $pdf->SetX(192);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Impreso '. date("Y-m-d"),0);
				 
				 
				 //FIN PARTE DE CENTRO

 				 //FIN CUADRO DERECHO FECHA HORA CODIGO MENSAJERO
				 // Fin Fila 1 Columna 1
					
			}
			if($j==4){
				
				 // Copia 1
				 //Encabezado
				 $pdf->SetX(40);
				 $pdf->SetY(141);	
				 $pdf->Image($guia[$i]['logo'],4,179,10,7); 
				 $pdf->Image($guia[$i]['codbar'],62,179,37,7); 
				 $pdf->Image($guia[$i]['logo'],34,179,10,7);
				 $pdf->SetFont('Arial','',4);	 
				 $pdf->Cell(55,78,"NIT. $nit_empresa",0,0,'R');		 
				 $pdf->Ln(3);	 
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(57,76,$guia[$i]['pagina_web'],0,0,'R');		 	 
				 $pdf->Ln(3);	 
				 $pdf->SetFont('Arial','B',7);		 	 	 
				 $pdf->Cell(165,82,$guia[$i]['numero_guia_bar'],0,0,'C');		 	 	 
				 $pdf->Ln(9);	
				 
				 // Fila 1 Columna 2
				 $pdf->SetY(191);	 	
				 $pdf->SetX(4);
				 $pdf->Cell(27,20,null,1,0,'C');
				 $pdf->Cell(1,1,null,0,0,'C');	

				 // Cuadro 1 Marco Centro
				 $pdf->Cell(42,10,null,0,0,'C');
				 
				  //Espacio Entre Marcos
				 $pdf->Cell(1,1,null,0,0,'C');
				 
				 //Espacio Entre Marcos
				 $pdf->Cell(4,4,null,0,0,'C');
				 
				 // Direccion y Telefono Encabezado Izquierda
				 $pdf->SetY(179);
				 $pdf->SetX(14);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, "Cra. 26 A No. 1D - 53", 0);
				 $pdf->SetY(182);
				 $pdf->SetX(14);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, "Tels.: 2012415 - 3513534", 0);
				 
   				 // Cod Cliente Izquierda
	 			 $pdf->SetY(186);
				 $pdf->SetX(3);
				 $pdf->SetFont('Arial','',6);	
				 $pdf->Cell(20, 5,$guia[$i]['orden_despacho'], 0);
				 
   				 // Numero de Orden de Servicio Izquierda
	 			 $pdf->SetY(190);
				 $pdf->SetX(20);
				 $pdf->SetFont('Arial','',6);	
				 $pdf->Cell(18, 5,'O.S.  '.substr(strtoupper($guia[$i]['solicitud_id']), 0,50), 0);
				 				 				 			 
				  // Numero de Guia Izquierda
	 			 $pdf->SetY(190);
				 $pdf->SetX(3);
				 $pdf->SetFont('Arial','',6);	
				 $pdf->Cell(20, 5,$guia[$i]['numero_guia_bar'], 0);

				 //Encabezado Central
				 $pdf->SetY(188);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Res. MINTIC 4304 de 2013',0);
				 					 
				 $pdf->SetY(183);	 	
				 $pdf->SetX(52);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,($guia[$i]['tipo_servicio']),0);
				 if(!empty($guia[$i]['orden_despacho'])){
					 $pdf->SetY(186);	 	
					 $pdf->SetX(33);
					 $pdf->Cell(14,2,'Doc. Cliente: '.$guia[$i]['orden_despacho'],0);
				  	 $pdf->SetY(189);	 	
					 $pdf->SetX(45);
					 //$pdf->Cell(14,2,$t,0);
				  }
				 $pdf->SetY(183);	 	
				 $pdf->SetX(45);
				 $pdf->Cell(14,2,$t,0);
				 // Fila 1 Cuadro 1 Remitente Izquierda
				 $pdf->SetX(40);
				 $pdf->SetY(194);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(20, 6, "Remitente :", 0);
				 
				 // Fila 2 Cuadro 1 Remitente Izquierda
				 $pdf->SetX(40);
				 $pdf->SetY(196);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['remitente']), 0,23), 0);
				 $pdf->SetX(40);
				 $pdf->SetY(198);
				 $pdf->Cell(18, 5, substr(strtoupper($guia[$i]['remitente']), 23,22), 0);
				 $pdf->SetX(40);
				 $pdf->SetY(201);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['direccion_remitente']), 0,30), 0);
				 $pdf->SetX(40);
				 $pdf->SetY(204);
				 $pdf->Cell(18, 6, 'Tel. '.substr(strtoupper($guia[$i]['telefono_remitente']), 0,22), 0);
				 $pdf->SetX(40);
				 $pdf->SetY(207);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['origen1']), 0,22), 0);
				

				 
				 // Cuadro 2 Remitente Izquierda - Cuadro Codigo Mensajeria
				 $pdf->SetX(40);
				 $pdf->SetY(211);	 	
				 $pdf->Cell(27,18,null,1,0,'C');
				 //Espacio Entre Marcos
				 $pdf->Cell(1,1,null,0,0,'C');
				 //$pdf->Cell(42,7,null,1,0,'C');
				 
				 //Cuadro Inferior
				 $pdf->SetX(40);
				 $pdf->SetY(222);	 
				 $pdf->Cell(27,24,null,1,0,'C');  
				 $pdf->SetX(40);
				 $pdf->SetY(222);
				 
     			 // Fila 1 Cuadro 3 Destinatario Izquierda
				 $pdf->SetX(40);
				 $pdf->SetY(228);
				 $pdf->Cell(20, 6, "Destinatario :", 0); 	 	 	 
				 
				 // Fila 2 Cuadro 3 Destinatario Izquierda
				 $pdf->SetX(39);
				 $pdf->SetY(231);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['destinatario']), 0,23), 0);
				 $pdf->SetX(39);
				 $pdf->SetY(233);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['destinatario']), 23,22), 0);
				 $pdf->SetX(39);
				 $pdf->SetY(236);
				 $pdf->Cell(18, 6, substr(strtoupper(str_replace("OFICINA","OFI",$guia[$i]['direccion_destinatario'])), 0,30), 0);
				 $pdf->SetX(39);				 
				 $pdf->SetY(239);
				 $pdf->Cell(18, 6, 'Tel. '.substr(strtoupper($guia[$i]['telefono_destinatario']), 0,22), 0);
				 $pdf->SetX(39);				 
				 $pdf->SetY(242);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['destino1']), 0,22), 0);
				 
				 //CUADRO IZQUIERDO FECHA HORA CODIGO MENSAJERO
 				 $pdf->SetY(211);	 	
				 $pdf->SetX(4);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(17,5,'FECHA',1);
 				 $pdf->SetY(211);	 	
				 $pdf->SetX(21);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(10,5,'HORA',1);

 				 $pdf->SetY(216);	 	
				 $pdf->SetX(4);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(17,6,'',1);
 				 $pdf->SetY(216);	 	
				 $pdf->SetX(21);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,6,'',1);
 				 $pdf->SetY(221);	 	
				 $pdf->SetX(3);
				 $pdf->SetFont('Arial','',4.5);	
				 $pdf->Cell(10,5,'COD. MENS',0);
				 
			 
     			 //PARTE DE CENTRO
 				 $pdf->SetY(191);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(66,55,'',1);

				 // Numero de Orden de Servicio
				 $pdf->SetY(190);				 
				 $pdf->SetX(88);
				 $pdf->SetFont('Arial','',6);
				 $pdf->Cell(18, 5,'O.S.  '.substr(strtoupper($guia[$i]['solicitud_id']), 0,50), 0);
				 
				 // Parte 1 Cuadro Centro - Remitente
				
				 $pdf->SetY(192);
				 $pdf->SetX(36);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(20, 3.5, "Remitente", 1);
				 $pdf->SetY(196);				 
				 $pdf->SetX(34.5);
				 $pdf->Cell(18, 5, substr(strtoupper($guia[$i]['remitente']), 0,50), 0);
				 $pdf->SetY(199);				 
				 $pdf->SetX(34.5);
				 $pdf->Cell(18, 5, substr(strtoupper($guia[$i]['direccion_remitente']), 0,60), 0);
				 $pdf->SetY(202);
				 $pdf->SetX(34.5);
				 $pdf->Cell(18, 5, 'Tel. '.substr(strtoupper($guia[$i]['telefono_remitente']), 0,22));
				 $pdf->SetY(205);
				 $pdf->SetX(34.5);
				 $pdf->Cell(18, 5, $guia[$i]['origen1'].'     Cod Pos Nal. '.$guia[$i]['postal_origen'], 0);
				 
				 // Parte 2 Cuadro Centro - Destinatario
				 $pdf->SetY(210);
				 $pdf->SetX(36);
				 $pdf->Cell(20, 3, "Destinatario", 1);
				 
				 $pdf->SetY(213);				 
				 $pdf->SetX(34.5);
				 $pdf->Cell(18, 5, substr(strtoupper($guia[$i]['destinatario']), 0,50), 0);
				 $pdf->SetY(216);				 
				 $pdf->SetX(34.5);
				 $pdf->Cell(18, 5, substr(strtoupper(trim(str_replace("OFICINA","OFI",$guia[$i]['direccion_destinatario']))), 0,60), 0);
				 $pdf->SetY(219);
				 $pdf->SetX(34.5);				 				 
				 $pdf->Cell(18, 5, 'Tel. '.substr(strtoupper($guia[$i]['telefono_destinatario']), 0,22), 0);
				 $pdf->SetY(222);
				 $pdf->SetX(34.5);				 				 
				 $pdf->Cell(18, 5, substr(strtoupper($guia[$i]['destino1']), 0,22).'     Cod Pos Nal. '.$guia[$i]['postal_destino'], 0);
				 $pdf->SetY(226);
				 $pdf->SetX(34.5);
				 $pdf->SetFont('Arial','',5);
				 $pdf->Cell(18,3, 'PESO '.substr(utf8_decode($guia[$i]['peso']).' '.$guia[$i]['medida'], 0,20),'',0);
				 $pdf->SetY(229);
				 $pdf->SetX(34.5);
				 $pdf->SetFont('Arial','',5);
				 $pdf->Cell(18,3, 'VR. ENVIO '.number_format($guia[$i]['valor_total'],0,',','.'),0,0);
				 
				 // Cuadro Devolucion
				 $pdf->SetY(232);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(32,14,'',1);

 				 $pdf->SetY(232);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(8,2,'DEVOL',1);

 				 $pdf->SetY(236);	 	
				 $pdf->SetX(34);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(13,2,'DESCONOCIDO',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(11,2,'REHUSADO',0);
				 
				 $pdf->SetY(239);	 	
				 $pdf->SetX(34);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(13,2,'NO RESIDE',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(14,2,'DIR INCOMPLETA',0);
				 
				 $pdf->SetY(242);	 	
				 $pdf->SetX(34);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(13,2,'DIR ERRADA',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(10,2,'OTRO',0);
				 
				 // Cuadro Devolucion
				 $pdf->SetY(232);	 	
				 $pdf->SetX(65);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(34,14,'',1);
				 
				 $pdf->SetY(243);	 	
				 $pdf->SetX(66);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(14,2,'RECIBIDO POR',1);
				 
				 $pdf->SetY(244);	 	
				 $pdf->SetX(82);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Impreso '. date("Y-m-d"),0);
				 
				 
				 //FIN PARTE DE CENTRO

 				 //FIN CUADRO DERECHO FECHA HORA CODIGO MENSAJERO
				 // Fin Fila 1 Columna 1
			 	 			
			}
			if($j==5){
				
								 
				 //Lado Derecho
				 $pdf->SetX(114);
				 $pdf->SetY(176);
				 $pdf->Image($guia[$i]['logo'],114,179,10,7); 
				 $pdf->Image($guia[$i]['codbar'],172,179,37,7); 
				 $pdf->Image($guia[$i]['logo'],144,179,10,7);
				 $pdf->SetFont('Arial','',4);	 
				 $pdf->Cell(165,8,"NIT. $nit_empresa",0,0,'R');		 
				 $pdf->Ln(3);	 
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(167,6,$guia[$i]['pagina_web'],0,0,'R');		 	 
				 $pdf->Ln(3);	 
				 $pdf->SetFont('Arial','B',7);		 	 	 
				 $pdf->Cell(385,12,$guia[$i]['numero_guia_bar'],0,0,'C');		 	 	 
				 $pdf->Ln(9);

				 // Fila 1 Columna 2
				 $pdf->SetY(191);	 	
				 $pdf->SetX(114);
				 $pdf->Cell(27,20,null,1,0,'C');
				 $pdf->Cell(1,1,null,0,0,'C');	
				 
				 // Cuadro 1 Marco Centro
				 $pdf->Cell(42,10,null,0,0,'C');
				 
				  //Espacio Entre Marcos
				 $pdf->Cell(1,1,null,0,0,'C');
				 
				 //Espacio Entre Marcos
				 $pdf->Cell(4,4,null,0,0,'C');
				 
				 // Direccion y Telefono Encabezado Izquierda
				 $pdf->SetY(179);
				 $pdf->SetX(124);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, "Cra. 26 A No. 1D - 53", 0);
				 $pdf->SetY(182);
				 $pdf->SetX(124);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, "Tels.: 2012415 - 3513534", 0);
				 
   				 // Cod Cliente Izquierda
	 			 $pdf->SetY(186);
				 $pdf->SetX(113);
				 $pdf->SetFont('Arial','',6);	
				 $pdf->Cell(20, 5,$guia[$i]['orden_despacho'], 0);
				 
   				 // Numero de Orden de Servicio Izquierda
	 			 $pdf->SetY(190);
				 $pdf->SetX(130);
				 $pdf->SetFont('Arial','',6);	
				 $pdf->Cell(18, 5,'O.S.  '.substr(strtoupper($guia[$i]['solicitud_id']), 0,50), 0);
				 				 				 				 			 
				  // Numero de Guia Izquierda
	 			 $pdf->SetY(190);
				 $pdf->SetX(113);
				 $pdf->SetFont('Arial','',6);	
				 $pdf->Cell(20, 5,$guia[$i]['numero_guia_bar'], 0);
				 
				 //Encabezado Central
				 $pdf->SetY(188);	 	
				 $pdf->SetX(143);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Res. MINTIC 4304 de 2013',0);
				 					 
				 $pdf->SetY(183);	 	
				 $pdf->SetX(162);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,($guia[$i]['tipo_servicio']),0);
				 if(!empty($guia[$i]['orden_despacho'])){
					 $pdf->SetY(186);	 	
					 $pdf->SetX(143);
					 $pdf->Cell(14,2,'Doc. Cliente: '.$guia[$i]['orden_despacho'],0);
				  	 $pdf->SetY(189);	 	
					 $pdf->SetX(155);
					 //$pdf->Cell(14,2,$t,0);
				  }
				 $pdf->SetY(183);	 	
				 $pdf->SetX(155);
				 $pdf->Cell(14,2,$t,0);
				 // Fila 1 Cuadro 1 Remitente Izquierda
				 $pdf->SetY(194);
				 $pdf->SetX(114);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(20, 6, "Remitente :", 0);
				 
				 // Fila 2 Cuadro 1 Remitente Izquierda
				 $pdf->SetY(196);
				 $pdf->SetX(114);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['remitente']), 0,23), 0);
				 $pdf->SetY(198);
				 $pdf->SetX(114);
				 $pdf->Cell(18, 5, substr(strtoupper($guia[$i]['remitente']), 23,22), 0);
				 $pdf->SetY(201);
				 $pdf->SetX(114);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['direccion_remitente']), 0,30), 0);
				 $pdf->SetY(204);
				 $pdf->SetX(114);
				 $pdf->Cell(18, 6, 'Tel. '.substr(strtoupper($guia[$i]['telefono_remitente']), 0,22), 0);
				 $pdf->SetY(207);
				 $pdf->SetX(114);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['origen1']), 0,22), 0);


				 
				 // Cuadro 2 Remitente Izquierda - Cuadro Codigo Mensajeria
				 $pdf->SetY(211);	 	
				 $pdf->SetX(114);
				 $pdf->Cell(27,18,null,1,0,'C');
				 //Espacio Entre Marcos
				 $pdf->Cell(1,1,null,0,0,'C');
				 //$pdf->Cell(42,7,null,1,0,'C');
				 
				 //Cuadro Inferior
				 $pdf->SetY(222);	 
				 $pdf->SetX(114);
				 $pdf->Cell(27,24,null,1,0,'C');  
				 $pdf->SetY(222);
				 $pdf->SetX(114);
				 
     			 // Fila 1 Cuadro 3 Destinatario Izquierda
				 $pdf->SetY(228);
				 $pdf->SetX(114);
				 $pdf->Cell(20, 6, "Destinatario :", 0); 	 	 	 
				 
				 // Fila 2 Cuadro 3 Destinatario Izquierda
				 $pdf->SetY(231);
				 $pdf->SetX(114);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['destinatario']), 0,23), 0);
				 $pdf->SetY(233);
				 $pdf->SetX(114);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['destinatario']), 23,22), 0);
				 $pdf->SetY(236);
				 $pdf->SetX(114);
				 $pdf->Cell(18, 6, substr(strtoupper(str_replace("OFICINA","OFI",$guia[$i]['direccion_destinatario'])), 0,30), 0);
				 $pdf->SetY(239);
				 $pdf->SetX(114);
				 $pdf->Cell(18, 6, 'Tel. '.substr(strtoupper($guia[$i]['telefono_destinatario']), 0,22), 0);
				 $pdf->SetY(242);
				 $pdf->SetX(114);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['destino1']), 0,22), 0);


				 //CUADRO IZQUIERDO FECHA HORA CODIGO MENSAJERO
 				 $pdf->SetY(211);	 	
				 $pdf->SetX(114);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(17,5,'FECHA',1);
 				 $pdf->SetY(211);	 	
				 $pdf->SetX(131);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(10,5,'HORA',1);

 				 $pdf->SetY(216);	 	
				 $pdf->SetX(114);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(17,6,'',1);
 				 $pdf->SetY(216);	 	
				 $pdf->SetX(131);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,6,'',1);
 				 $pdf->SetY(221);	 	
				 $pdf->SetX(113);
				 $pdf->SetFont('Arial','',4.5);	
				 $pdf->Cell(10,5,'COD. MENS',0);
				 
			 
     			 //PARTE DE CENTRO
 				 $pdf->SetY(191);	 	
				 $pdf->SetX(143);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(66,55,'',1);

				 // Numero de Orden de Servicio
				 $pdf->SetY(190);				 
				 $pdf->SetX(198);
				 $pdf->SetFont('Arial','',6);
				 $pdf->Cell(18, 5,'O.S.  '.substr(strtoupper($guia[$i]['solicitud_id']), 0,50), 0);
				 
				 // Parte 1 Cuadro Centro - Remitente
				
				 $pdf->SetY(192);
				 $pdf->SetX(146);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(20, 3.5, "Remitente", 1);
				 $pdf->SetY(196);				 
				 $pdf->SetX(144.5);
				 $pdf->Cell(18, 5, substr(strtoupper($guia[$i]['remitente']), 0,50), 0);
				 $pdf->SetY(199);				 
				 $pdf->SetX(144.5);
				 $pdf->Cell(18, 5, substr(strtoupper($guia[$i]['direccion_remitente']), 0,60), 0);
				 $pdf->SetY(202);
				 $pdf->SetX(144.5);
				 $pdf->Cell(18, 5, 'Tel. '.substr(strtoupper($guia[$i]['telefono_remitente']), 0,22));
				 $pdf->SetY(205);
				 $pdf->SetX(144.5);
				 $pdf->Cell(18, 5, $guia[$i]['origen1'].'     Cod Pos Nal. '.$guia[$i]['postal_origen'], 0);
				 
				 // Parte 2 Cuadro Centro - Destinatario
				 $pdf->SetY(210);
				 $pdf->SetX(146);
				 $pdf->Cell(20, 3, "Destinatario", 1);
				 
				 $pdf->SetY(213);				 
				 $pdf->SetX(144.5);
				 $pdf->Cell(18, 5, substr(strtoupper($guia[$i]['destinatario']), 0,50), 0);
				 $pdf->SetY(216);				 
				 $pdf->SetX(144.5);
				 $pdf->Cell(18, 5, substr(strtoupper(trim(str_replace("OFICINA","OFI",$guia[$i]['direccion_destinatario']))), 0,60), 0);
				 $pdf->SetY(219);
				 $pdf->SetX(144.5);				 				 
				 $pdf->Cell(18, 5, 'Tel. '.substr(strtoupper($guia[$i]['telefono_destinatario']), 0,22), 0);
				 $pdf->SetY(222);
				 $pdf->SetX(144.5);				 				 
				 $pdf->Cell(18, 5, substr(strtoupper($guia[$i]['destino1']), 0,22).'     Cod Pos Nal. '.$guia[$i]['postal_destino'], 0);
				 $pdf->SetY(226);
				 $pdf->SetX(144.5);
				 $pdf->SetFont('Arial','',5);
				 $pdf->Cell(18,3, 'PESO '.substr(utf8_decode($guia[$i]['peso']).' '.$guia[$i]['medida'], 0,20),'',0);
				 $pdf->SetY(229);
				 $pdf->SetX(144.5);
				 $pdf->SetFont('Arial','',5);
				 $pdf->Cell(18,3, 'VR. ENVIO '.number_format($guia[$i]['valor_total'],0,',','.'),0,0);
				 
				 // Cuadro Devolucion
				 $pdf->SetY(232);	 	
				 $pdf->SetX(143);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(32,14,'',1);

 				 $pdf->SetY(232);	 	
				 $pdf->SetX(143);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(8,2,'DEVOL',1);

 				 $pdf->SetY(236);	 	
				 $pdf->SetX(144);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(13,2,'DESCONOCIDO',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(11,2,'REHUSADO',0);
				 
				 $pdf->SetY(239);	 	
				 $pdf->SetX(144);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(13,2,'NO RESIDE',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(14,2,'DIR INCOMPLETA',0);
				 
				 $pdf->SetY(242);	 	
				 $pdf->SetX(144);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(13,2,'DIR ERRADA',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(10,2,'OTRO',0);
				 
				 // Cuadro Devolucion
				 $pdf->SetY(232);	 	
				 $pdf->SetX(175);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(34,14,'',1);
				 
				 $pdf->SetY(243);	 	
				 $pdf->SetX(176);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(14,2,'RECIBIDO POR',1);
				 
				 $pdf->SetY(244);	 	
				 $pdf->SetX(192);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Impreso '. date("Y-m-d"),0);
				 
				 
				 //FIN PARTE DE CENTRO

 				 //FIN CUADRO DERECHO FECHA HORA CODIGO MENSAJERO
				 // Fin Fila 1 Columna 1
					
			
			}
			 
			if($j==6){
				
				 // Copia 1
				 //Encabezado
				 $pdf->SetX(40);
				 $pdf->SetY(224);	
				 $pdf->Image($guia[$i]['logo'],4,261,10,7); 
				 $pdf->Image($guia[$i]['codbar'],62,261,37,7); 
				 $pdf->Image($guia[$i]['logo'],34,261,10,7);
				 $pdf->SetFont('Arial','',4);	 
				 $pdf->Cell(55,78,"NIT. $nit_empresa",0,0,'R');		 
				 $pdf->Ln(3);	 
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(57,76,$guia[$i]['pagina_web'],0,0,'R');		 	 
				 $pdf->Ln(3);	 
				 $pdf->SetFont('Arial','B',7);		 	 	 
				 $pdf->Cell(165,82,$guia[$i]['numero_guia_bar'],0,0,'C');		 	 	 
				 $pdf->Ln(9);	
				 
				 // Fila 1 Columna 2
				 $pdf->SetY(274);	 	
				 $pdf->SetX(4);
				 $pdf->Cell(27,20,null,1,0,'C');
				 $pdf->Cell(1,1,null,0,0,'C');	

				 // Cuadro 1 Marco Centro
				 $pdf->Cell(42,10,null,0,0,'C');
				 
				  //Espacio Entre Marcos
				 $pdf->Cell(1,1,null,0,0,'C');
				 
				 //Espacio Entre Marcos
				 $pdf->Cell(4,4,null,0,0,'C');
				 
				 // Direccion y Telefono Encabezado Izquierda
				 $pdf->SetY(262);
				 $pdf->SetX(14);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, "Cra. 26 A No. 1D - 53", 0);
				 $pdf->SetY(265);
				 $pdf->SetX(14);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, "Tels.: 2012415 - 3513534", 0);
				 
   				 // Cod Cliente Izquierda
	 			 $pdf->SetY(269);
				 $pdf->SetX(3);
				 $pdf->SetFont('Arial','',6);	
				 $pdf->Cell(20, 5,$guia[$i]['orden_despacho'], 0);
				 
				 // Numero de Orden de Servicio Izquierda
	 			 $pdf->SetY(273);
				 $pdf->SetX(20);
				 $pdf->SetFont('Arial','',6);	
				 $pdf->Cell(18, 5,'O.S.  '.substr(strtoupper($guia[$i]['solicitud_id']), 0,50), 0);
				 				 				 				 				 			 
				  // Numero de Guia Izquierda
	 			 $pdf->SetY(273);
				 $pdf->SetX(3);
				 $pdf->SetFont('Arial','',6);	
				 $pdf->Cell(20, 5,$guia[$i]['numero_guia_bar'], 0);

				 //Encabezado Central
				 $pdf->SetY(272);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Res. MINTIC 4304 de 2013',0);
				 					 
				 $pdf->SetY(266);	 	
				 $pdf->SetX(52);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,($guia[$i]['tipo_servicio']),0);
				 if(!empty($guia[$i]['orden_despacho'])){
					 $pdf->SetY(269);	 	
					 $pdf->SetX(33);
					 $pdf->Cell(14,2,'Doc. Cliente: '.$guia[$i]['orden_despacho'],0);
				  	 $pdf->SetY(272);	 	
					 $pdf->SetX(45);
					 //$pdf->Cell(14,2,$t,0);
				  }
				 $pdf->SetY(266);	 	
				 $pdf->SetX(45);
				 $pdf->Cell(14,2,$t,0);
				 // Fila 1 Cuadro 1 Remitente Izquierda
				 $pdf->SetX(40);
				 $pdf->SetY(277);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(20, 6, "Remitente :", 0);
				 
				 // Fila 2 Cuadro 1 Remitente Izquierda
				 $pdf->SetX(40);
				 $pdf->SetY(279);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['remitente']), 0,23), 0);
				 $pdf->SetX(40);
				 $pdf->SetY(281);
				 $pdf->Cell(18, 5, substr(strtoupper($guia[$i]['remitente']), 23,22), 0);
				 $pdf->SetX(40);
				 $pdf->SetY(284);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['direccion_remitente']), 0,30), 0);
				 $pdf->SetX(40);
				 $pdf->SetY(287);
				 $pdf->Cell(18, 6, 'Tel. '.substr(strtoupper($guia[$i]['telefono_remitente']), 0,22), 0);
				 $pdf->SetX(40);
				 $pdf->SetY(290);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['origen1']), 0,22), 0);
				

				 
				 // Cuadro 2 Remitente Izquierda - Cuadro Codigo Mensajeria
				 $pdf->SetX(40);
				 $pdf->SetY(294);	 	
				 $pdf->Cell(27,18,null,1,0,'C');
				 //Espacio Entre Marcos
				 $pdf->Cell(1,1,null,0,0,'C');
				 //$pdf->Cell(42,7,null,1,0,'C');
				 
				 //Cuadro Inferior
				 $pdf->SetX(40);
				 $pdf->SetY(305);	 
				 $pdf->Cell(27,24,null,1,0,'C');  
				 $pdf->SetX(40);
				 $pdf->SetY(305);
				 
     			 // Fila 1 Cuadro 3 Destinatario Izquierda
				 $pdf->SetX(40);
				 $pdf->SetY(311);
				 $pdf->Cell(20, 6, "Destinatario :", 0); 	 	 	 
				 
				 // Fila 2 Cuadro 3 Destinatario Izquierda
				 $pdf->SetX(39);
				 $pdf->SetY(314);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['destinatario']), 0,23), 0);
				 $pdf->SetX(39);
				 $pdf->SetY(316);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['destinatario']), 23,22), 0);
				 $pdf->SetX(39);
				 $pdf->SetY(319);
				 $pdf->Cell(18, 6, substr(strtoupper(str_replace("OFICINA","OFI",$guia[$i]['direccion_destinatario'])), 0,30), 0);
				 $pdf->SetX(39);				 
				 $pdf->SetY(322);
				 $pdf->Cell(18, 6, 'Tel. '.substr(strtoupper($guia[$i]['telefono_destinatario']), 0,22), 0);
				 $pdf->SetX(39);				 
				 $pdf->SetY(325);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['destino1']), 0,22), 0);

				 //CUADRO IZQUIERDO FECHA HORA CODIGO MENSAJERO
 				 $pdf->SetY(294);	 	
				 $pdf->SetX(4);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(17,5,'FECHA',1);
 				 $pdf->SetY(294);	 	
				 $pdf->SetX(21);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(10,5,'HORA',1);

 				 $pdf->SetY(299);	 	
				 $pdf->SetX(4);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(17,6,'',1);
 				 $pdf->SetY(299);	 	
				 $pdf->SetX(21);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,6,'',1);
 				 $pdf->SetY(304);	 	
				 $pdf->SetX(3);
				 $pdf->SetFont('Arial','',4.5);	
				 $pdf->Cell(10,5,'COD. MENS',0);
				 
			 
     			 //PARTE DE CENTRO
 				 $pdf->SetY(274);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(66,55,'',1);

				 // Numero de Orden de Servicio
				 $pdf->SetY(273);				 
				 $pdf->SetX(88);
				 $pdf->SetFont('Arial','',6);
				 $pdf->Cell(18, 5,'O.S.  '.substr(strtoupper($guia[$i]['solicitud_id']), 0,50), 0);
				 
				 // Parte 1 Cuadro Centro - Remitente
				
				 $pdf->SetY(275);
				 $pdf->SetX(36);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(20, 3.5, "Remitente", 1);
				 $pdf->SetY(279);				 
				 $pdf->SetX(34.5);
				 $pdf->Cell(18, 5, substr(strtoupper($guia[$i]['remitente']), 0,50), 0);
				 $pdf->SetY(282);				 
				 $pdf->SetX(34.5);
				 $pdf->Cell(18, 5, substr(strtoupper($guia[$i]['direccion_remitente']), 0,60), 0);
				 $pdf->SetY(285);
				 $pdf->SetX(34.5);
				 $pdf->Cell(18, 5, 'Tel. '.substr(strtoupper($guia[$i]['telefono_remitente']), 0,22));
				 $pdf->SetY(288);
				 $pdf->SetX(34.5);
				 $pdf->Cell(18, 5, $guia[$i]['origen1'].'     Cod Pos Nal. '.$guia[$i]['postal_origen'], 0);
				 
				 // Parte 2 Cuadro Centro - Destinatario
				 $pdf->SetY(293);
				 $pdf->SetX(36);
				 $pdf->Cell(20, 3, "Destinatario", 1);
				 
				 $pdf->SetY(296);				 
				 $pdf->SetX(34.5);
				 $pdf->Cell(18, 5, substr(strtoupper($guia[$i]['destinatario']), 0,50), 0);
				 $pdf->SetY(299);				 
				 $pdf->SetX(34.5);
				 $pdf->Cell(18, 5, substr(strtoupper(trim(str_replace("OFICINA","OFI",$guia[$i]['direccion_destinatario']))), 0,60), 0);
				 $pdf->SetY(303);
				 $pdf->SetX(34.5);				 				 
				 $pdf->Cell(18, 5, 'Tel. '.substr(strtoupper($guia[$i]['telefono_destinatario']), 0,22), 0);
				 $pdf->SetY(305);
				 $pdf->SetX(34.5);				 				 
				 $pdf->Cell(18, 5, substr(strtoupper($guia[$i]['destino1']), 0,22).'     Cod Pos Nal. '.$guia[$i]['postal_destino'], 0);
				 $pdf->SetY(309);
				 $pdf->SetX(34.5);
				 $pdf->SetFont('Arial','',5);
				 $pdf->Cell(18,3, 'PESO '.substr(utf8_decode($guia[$i]['peso']).' '.$guia[$i]['medida'], 0,20),'',0);
				 $pdf->SetY(312);
				 $pdf->SetX(34.5);
				 $pdf->SetFont('Arial','',5);
				 $pdf->Cell(18,3, 'VR. ENVIO '.number_format($guia[$i]['valor_total'],0,',','.'),0,0);
				 
				 // Cuadro Devolucion
				 $pdf->SetY(315);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(32,14,'',1);

 				 $pdf->SetY(315);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(8,2,'DEVOL',1);

 				 $pdf->SetY(319);	 	
				 $pdf->SetX(34);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(13,2,'DESCONOCIDO',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(11,2,'REHUSADO',0);
				 
				 $pdf->SetY(322);	 	
				 $pdf->SetX(34);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(13,2,'NO RESIDE',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(14,2,'DIR INCOMPLETA',0);
				 
				 $pdf->SetY(325);	 	
				 $pdf->SetX(34);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(13,2,'DIR ERRADA',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(10,2,'OTRO',0);
				 
				 // Cuadro Devolucion
				 $pdf->SetY(315);	 	
				 $pdf->SetX(65);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(34,14,'',1);
				 
				 $pdf->SetY(326);	 	
				 $pdf->SetX(66);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(14,2,'RECIBIDO POR',1);
				 
				 $pdf->SetY(327);	 	
				 $pdf->SetX(82);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Impreso '. date("Y-m-d"),0);
				 
				 
				 //FIN PARTE DE CENTRO

 				 //FIN CUADRO DERECHO FECHA HORA CODIGO MENSAJERO
				 // Fin Fila 1 Columna 1
			 	 			
			}
			
			if($j==7){
				
								 
				 //Lado Derecho
				 $pdf->SetX(114);
				 $pdf->SetY(259);
				 $pdf->Image($guia[$i]['logo'],114,262,10,7); 
				 $pdf->Image($guia[$i]['codbar'],172,262,37,7); 
				 $pdf->Image($guia[$i]['logo'],144,262,10,7);
				 $pdf->SetFont('Arial','',4);	 
				 $pdf->Cell(165,8,"NIT. $nit_empresa",0,0,'R');		 
				 $pdf->Ln(3);	 
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(167,6,$guia[$i]['pagina_web'],0,0,'R');		 	 
				 $pdf->Ln(3);	 
				 $pdf->SetFont('Arial','B',7);		 	 	 
				 $pdf->Cell(385,12,$guia[$i]['numero_guia_bar'],0,0,'C');		 	 	 
				 $pdf->Ln(9);

				 // Fila 1 Columna 2
				 $pdf->SetY(274);	 	
				 $pdf->SetX(114);
				 $pdf->Cell(27,20,null,1,0,'C');
				 $pdf->Cell(1,1,null,0,0,'C');	
				 
				 // Cuadro 1 Marco Centro
				 $pdf->Cell(42,10,null,0,0,'C');
				 
				  //Espacio Entre Marcos
				 $pdf->Cell(1,1,null,0,0,'C');
				 
				 //Espacio Entre Marcos
				 $pdf->Cell(4,4,null,0,0,'C');
				 
				 // Direccion y Telefono Encabezado Izquierda
				 $pdf->SetY(262);
				 $pdf->SetX(124);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, "Cra. 26 A No. 1D - 53", 0);
				 $pdf->SetY(265);
				 $pdf->SetX(124);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(20, 5, "Tels.: 2012415 - 3513534", 0);
				 
   				 // Cod Cliente Izquierda
	 			 $pdf->SetY(269);
				 $pdf->SetX(113);
				 $pdf->SetFont('Arial','',6);	
				 $pdf->Cell(20, 5,$guia[$i]['orden_despacho'], 0);	
				 
 				 // Numero de Orden de Servicio Izquierda
	 			 $pdf->SetY(273);
				 $pdf->SetX(130);
				 $pdf->SetFont('Arial','',6);	
				 $pdf->Cell(18, 5,'O.S.  '.substr(strtoupper($guia[$i]['solicitud_id']), 0,50), 0);
				 
				  // Numero de Guia Izquierda
	 			 $pdf->SetY(273);
				 $pdf->SetX(113);
				 $pdf->SetFont('Arial','',6);	
				 $pdf->Cell(20, 5,$guia[$i]['numero_guia_bar'], 0);

				 
				 //Encabezado Central
				 $pdf->SetY(272);	 	
				 $pdf->SetX(143);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Res. MINTIC 4304 de 2013',0);
				 					 
				 $pdf->SetY(266);	 	
				 $pdf->SetX(162);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,($guia[$i]['tipo_servicio']),0);
				 if(!empty($guia[$i]['orden_despacho'])){
					 $pdf->SetY(269);	 	
					 $pdf->SetX(143);
					 $pdf->Cell(14,2,'Doc. Cliente: '.$guia[$i]['orden_despacho'],0);
  				  	 $pdf->SetY(272);	 	
					 $pdf->SetX(155);
					 //$pdf->Cell(14,2,$t,0);
				  }
				 $pdf->SetY(266);	 	
				 $pdf->SetX(155);
				 $pdf->Cell(14,2,$t,0);
				 // Fila 1 Cuadro 1 Remitente Izquierda
				 $pdf->SetY(277);
				 $pdf->SetX(114);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(20, 6, "Remitente :", 0);
				 
				 // Fila 2 Cuadro 1 Remitente Izquierda
				 $pdf->SetY(279);
				 $pdf->SetX(114);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['remitente']), 0,23), 0);
				 $pdf->SetY(281);
				 $pdf->SetX(114);
				 $pdf->Cell(18, 5, substr(strtoupper($guia[$i]['remitente']), 23,22), 0);
				 $pdf->SetY(284);
				 $pdf->SetX(114);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['direccion_remitente']), 0,30), 0);
				 $pdf->SetY(287);
				 $pdf->SetX(114);
				 $pdf->Cell(18, 6, 'Tel. '.substr(strtoupper($guia[$i]['telefono_remitente']), 0,22), 0);
				 $pdf->SetY(290);
				 $pdf->SetX(114);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['origen1']), 0,22), 0);
				

				 
				 // Cuadro 2 Remitente Izquierda - Cuadro Codigo Mensajeria
				 $pdf->SetY(294);	 	
				 $pdf->SetX(114);
				 $pdf->Cell(27,18,null,1,0,'C');
				 //Espacio Entre Marcos
				 $pdf->Cell(1,1,null,0,0,'C');
				 //$pdf->Cell(42,7,null,1,0,'C');
				 
				 //Cuadro Inferior
				 $pdf->SetY(305);	 
				 $pdf->SetX(114);
				 $pdf->Cell(27,24,null,1,0,'C');  
				 $pdf->SetY(305);
				 $pdf->SetX(114);
				 
     			 // Fila 1 Cuadro 3 Destinatario Izquierda
				 $pdf->SetY(311);
				 $pdf->SetX(114);
				 $pdf->Cell(20, 6, "Destinatario :", 0); 	 	 	 
				 
				 // Fila 2 Cuadro 3 Destinatario Izquierda
				 $pdf->SetY(314);
				 $pdf->SetX(114);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['destinatario']), 0,23), 0);
				 $pdf->SetY(316);
				 $pdf->SetX(114);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['destinatario']), 23,22), 0);
				 $pdf->SetY(319);
				 $pdf->SetX(114);
				 $pdf->Cell(18, 6, substr(strtoupper(str_replace("OFICINA","OFI",$guia[$i]['direccion_destinatario'])), 0,30), 0);
				 $pdf->SetY(322);
				 $pdf->SetX(114);
				 $pdf->Cell(18, 6, 'Tel. '.substr(strtoupper($guia[$i]['telefono_destinatario']), 0,22), 0);
				 $pdf->SetY(325);
				 $pdf->SetX(114);
				 $pdf->Cell(18, 6, substr(strtoupper($guia[$i]['destino1']), 0,22), 0);

				 //CUADRO IZQUIERDO FECHA HORA CODIGO MENSAJERO
 				 $pdf->SetY(294);	 	
				 $pdf->SetX(114);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(17,5,'FECHA',1);
 				 $pdf->SetY(294);	 	
				 $pdf->SetX(131);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(10,5,'HORA',1);

 				 $pdf->SetY(299);	 	
				 $pdf->SetX(114);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(17,6,'',1);
 				 $pdf->SetY(299);	 	
				 $pdf->SetX(131);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(10,6,'',1);
 				 $pdf->SetY(304);	 	
				 $pdf->SetX(113);
				 $pdf->SetFont('Arial','',4.5);	
				 $pdf->Cell(10,5,'COD. MENS',0);
				 
			 
     			 //PARTE DE CENTRO
 				 $pdf->SetY(274);	 	
				 $pdf->SetX(143);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(66,55,'',1);

				 // Numero de Orden de Servicio
				 $pdf->SetY(273);				 
				 $pdf->SetX(198);
				 $pdf->SetFont('Arial','',6);
				 $pdf->Cell(18, 5,'O.S.  '.substr(strtoupper($guia[$i]['solicitud_id']), 0,50), 0);
				 
				 // Parte 1 Cuadro Centro - Remitente
				
				 $pdf->SetY(275);
				 $pdf->SetX(146);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(20, 3.5, "Remitente", 1);
				 $pdf->SetY(279);				 
				 $pdf->SetX(144.5);
				 $pdf->Cell(18, 5, substr(strtoupper($guia[$i]['remitente']), 0,50), 0);
				 $pdf->SetY(282);				 
				 $pdf->SetX(144.5);
				 $pdf->Cell(18, 5, substr(strtoupper($guia[$i]['direccion_remitente']), 0,60), 0);
				 $pdf->SetY(285);
				 $pdf->SetX(144.5);
				 $pdf->Cell(18, 5, 'Tel. '.substr(strtoupper($guia[$i]['telefono_remitente']), 0,22));
				 $pdf->SetY(288);
				 $pdf->SetX(144.5);
				 $pdf->Cell(18, 5, $guia[$i]['origen1'].'     Cod Pos Nal. '.$guia[$i]['postal_origen'], 0);
				 
				 // Parte 2 Cuadro Centro - Destinatario
				 $pdf->SetY(293);
				 $pdf->SetX(146);
				 $pdf->Cell(20, 3, "Destinatario", 1);
				 
				 $pdf->SetY(296);				 
				 $pdf->SetX(144.5);
				 $pdf->Cell(18, 5, substr(strtoupper($guia[$i]['destinatario']), 0,50), 0);
				 $pdf->SetY(299);				 
				 $pdf->SetX(144.5);
				 $pdf->Cell(18, 5, substr(strtoupper(trim(str_replace("OFICINA","OFI",$guia[$i]['direccion_destinatario']))), 0,60), 0);
				 $pdf->SetY(302);
				 $pdf->SetX(144.5);				 				 
				 $pdf->Cell(18, 5, 'Tel. '.substr(strtoupper($guia[$i]['telefono_destinatario']), 0,22), 0);
				 $pdf->SetY(305);
				 $pdf->SetX(144.5);				 				 
				 $pdf->Cell(18, 5, substr(strtoupper($guia[$i]['destino1']), 0,22).'     Cod Pos Nal. '.$guia[$i]['postal_destino'], 0);
				 $pdf->SetY(309);
				 $pdf->SetX(144.5);
				 $pdf->SetFont('Arial','',5);
				 $pdf->Cell(18,3, 'PESO '.substr(utf8_decode($guia[$i]['peso']).' '.$guia[$i]['medida'], 0,20),'',0);
				 $pdf->SetY(312);
				 $pdf->SetX(144.5);
				 $pdf->SetFont('Arial','',5);
				 $pdf->Cell(18,3, 'VR. ENVIO '.number_format($guia[$i]['valor_total'],0,',','.'),0,0);
				 
				 // Cuadro Devolucion
				 $pdf->SetY(315);	 	
				 $pdf->SetX(143);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(32,14,'',1);

 				 $pdf->SetY(315);	 	
				 $pdf->SetX(143);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(8,2,'DEVOL',1);

 				 $pdf->SetY(319);	 	
				 $pdf->SetX(144);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(13,2,'DESCONOCIDO',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(11,2,'REHUSADO',0);
				 
				 $pdf->SetY(322);	 	
				 $pdf->SetX(144);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(13,2,'NO RESIDE',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(14,2,'DIR INCOMPLETA',0);
				 
				 $pdf->SetY(325);	 	
				 $pdf->SetX(144);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(13,2,'DIR ERRADA',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(10,2,'OTRO',0);
				 
				 // Cuadro Devolucion
				 $pdf->SetY(315);	 	
				 $pdf->SetX(175);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(34,14,'',1);
				 
				 $pdf->SetY(326);	 	
				 $pdf->SetX(176);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(14,2,'RECIBIDO POR',1);
				 
				 $pdf->SetY(327);	 	
				 $pdf->SetX(192);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Impreso '. date("Y-m-d"),0);
				 
				 
				 //FIN PARTE DE CENTRO

 				 //FIN CUADRO DERECHO FECHA HORA CODIGO MENSAJERO
				 // Fin Fila 1 Columna 1
					
			
			}

			
			if($j == 7){ $pdf->AddPage('P','Legal','mm'); $j=0;}else{ $j++; } 

		  }	 	
			
		  $pdf->Output(); //Env�a como salida del documento  
	 			
		}
 	 }	
}

new Imp_GuiaCRM();

?>