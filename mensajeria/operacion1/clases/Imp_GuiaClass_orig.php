<?php

final class Imp_Guia{

  private $Conex;
  
  public function __construct($Conex){  
    $this -> Conex = $Conex;  
  }

  public function printOut($usuario,$empresa_id,$oficina_id,$nit_empresa){
      	
      //require_once("Imp_GuiaLayoutClass.php");
      require_once("Imp_GuiaModelClass.php");
      require_once("../../../framework/clases/fpdf/fpdf.php");	  	  
      require_once("../../../framework/clases/barcode.php");	  
		
      //$Layout  = new Imp_GuiaLayout();
	  
		  
      $Model   = new Imp_GuiaModel();		
	  $barcode = new barcode();		
	  $guia = $Model -> getGuia($oficina_id,$this -> Conex);	
	
	  if(!count($guia)>0){
		  exit('Los filtros utilizados no arrojan ninguna Guia a imprimir <br> Por favor verifique');
		  
	  }
	  for($i = 0; $i < count($guia); $i++){	  
	    foreach($guia[$i] as $llave => $valor){		
		  if($llave == 'numero_guia'){
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
			$pdf->SetFont('Arial','B',10); //Establece la fuente a utilizar, el formato Negrita y el tamaño
		
			#Establecemos los márgenes izquierda, arriba y derecha:
			$pdf->SetMargins(10, 5 , 5);
		
			#Establecemos el margen inferior:
			$pdf->SetAutoPageBreak(true,1);  
		
			
			for($i = 0; $i < count($guia); $i++){	
			 if($i > 0) $pdf->AddPage('P','Letter','mm');
		
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
			 $pdf->Cell(39,3,null,0,0,'R');	
			 $pdf->Cell(10,3,'FACTURA DE VENTA',0,0,'R');
			 $pdf->Cell(30,3,$guia[$i]['numero_guia_bar'],0,0,'C');		 	 	 
			 $pdf->Ln(3.5);	 
		
			 // Cuadro 1	
			 $pdf->Cell(195,16,null,1,0,'C');
				 
			 // Fila 1 Cuadro 1
			 $pdf->SetX(40);
			 $pdf->SetY(20);
			 $pdf->Cell(18, 3, "Origen :", 0);
			 $pdf->Cell(65, 3, substr(utf8_decode($guia[$i]['origen']),0,34), 0);
			 $pdf->Cell(20, 3, "Destino :", 0);
			 $pdf->Cell(50, 3, substr(utf8_decode($guia[$i]['destino']),0,26), 0);	 	 	 	 	 
			 
			 // Fila 2 Cuadro 1
			 $pdf->SetX(40);
			 $pdf->SetY(24);
			 $pdf->Cell(18, 3, "Remitente :", 0);
			 $pdf->Cell(65, 3, substr(utf8_decode($guia[$i]['remitente']),0,34), 0);
			 $pdf->Cell(20, 3, "Destinatario :", 0);
			 $pdf->Cell(50, 3, substr(utf8_decode($guia[$i]['destinatario']),0,26), 0);	 
			 
			 // Fila 3 Cuadro 1
			 $pdf->SetX(40);
			 $pdf->SetY(28);
			 $pdf->Cell(18, 3, "Direccion :", 0);
			 $pdf->Cell(65, 3, substr(utf8_decode($guia[$i]['direccion_remitente']),0,34), 0);
			 $pdf->Cell(20, 3, "Direccion :", 0);
			 $pdf->Cell(50, 3, substr(utf8_decode($guia[$i]['direccion_destinatario']),0,26), 0);	 	 	 	 	 
		 
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
			 $pdf->Cell(15, 3, "Peso (Kg)", 0,0,'C');	
			 $pdf->Cell(20, 3, "Peso Vol", 0,0,'C');	
			 $pdf->Cell(25, 3, "Doc. Cliente", 0,0,'C');	 
			 $pdf->Cell(40, 3, "V/r. Declarado", 0,0,'C');	 	 
			 
			 $pdf->SetFont('Arial','B',6);
			 
			 $pdf->SetX(40);
			 $pdf->SetY(40);	 
			 $pdf->Cell(25, 3, $guia[$i]['detalles_guia'][0]['cantidad'], 0,0,'C');	 	 	
			 $pdf->Cell(80, 3, substr($guia[$i]['detalles_guia'][0]['referencia_producto'],0,60), 0,0,'C');	 	 	
			 $pdf->Cell(15, 3, $guia[$i]['detalles_guia'][0]['peso'], 0,0,'C');	
			 $pdf->Cell(20, 3, $guia[$i]['detalles_guia'][0]['peso_volumen'], 0,0,'C');	
			 $pdf->Cell(25, 3, $guia[$i]['detalles_guia'][0]['guia_cliente'], 0,0,'C');	 
			 $pdf->Cell(40, 3, number_format($guia[$i]['detalles_guia'][0]['valor'],0,',','.'), 0,0,'C');	  	
			 
			 $pdf->SetX(40);
			 $pdf->SetY(44);	 
			 $pdf->Cell(25, 3, $guia[$i]['detalles_guia'][1]['cantidad'], 0,0,'C');	 	 	
			 $pdf->Cell(80, 3, substr($guia[$i]['detalles_guia'][1]['referencia_producto'],0,60), 0,0,'C');	 	 	
			 $pdf->Cell(15, 3, $guia[$i]['detalles_guia'][1]['peso'], 0,0,'C');	
			 $pdf->Cell(20, 3, $guia[$i]['detalles_guia'][1]['peso_volumen'], 0,0,'C');	
			 $pdf->Cell(25, 3, $guia[$i]['detalles_guia'][1]['guia_cliente'], 0,0,'C');	 
			 $pdf->Cell(40, 3, number_format($guia[$i]['detalles_guia'][1]['valor'],0,',','.'), 0,0,'C');	
			
			 // Cuadro 3	 
			 $pdf->SetX(40);
			 $pdf->SetY(50);	 	
			 $pdf->Cell(195,15,null,1,0,'C');		 
			 
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
			 $pdf->Cell(15,5,"Vr. Manejo:",0,0,'L');
			 $pdf->Cell(10,5,number_format($guia[$i]['valor_manejo'],0,',','.')."",0,0,'L');	 
		
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
			 $pdf->Cell(39,3,null,0,0,'R');		 	 
			 $pdf->Cell(10,3,'FACTURA DE VENTA',0,0,'R');
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
			 $pdf->Cell(50, 3, substr(utf8_decode($guia[$i]['destino']),0,26), 0); 	 	 	 	 
			 
			 // Fila 2 Cuadro 1
			 $pdf->SetX(40);
			 $pdf->SetY(156);
			 $pdf->Cell(18, 3, "Remitente :", 0);
			 $pdf->Cell(65, 3, substr(utf8_decode($guia[$i]['remitente']),0,34), 0);
			 $pdf->Cell(20, 3, "Destinatario :", 0);
			 $pdf->Cell(50, 3, substr(utf8_decode($guia[$i]['destinatario']),0,26), 0);	 	
			 
			 // Fila 3 Cuadro 1
			 $pdf->SetX(40);
			 $pdf->SetY(160);
			 $pdf->Cell(18, 3, "Direccion :", 0);
			 $pdf->Cell(65, 3, substr(utf8_decode($guia[$i]['direccion_remitente']),0,34), 0);
			 $pdf->Cell(20, 3, "Direccion :", 0);
			 $pdf->Cell(50, 3, substr(utf8_decode($guia[$i]['direccion_destinatario']),0,26), 0);	
		 
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
			 $pdf->Cell(15, 3, "Peso (Kg)", 0,0,'C');	
			 $pdf->Cell(20, 3, "Peso Vol", 0,0,'C');	
			 $pdf->Cell(25, 3, "Doc. Cliente", 0,0,'C');	 
			 $pdf->Cell(40, 3, "V/r. Declarado", 0,0,'C');	 	 
			 
			 $pdf->SetFont('Arial','B',6);
			 
			 $pdf->SetX(40);
			 $pdf->SetY(171);	 
			 $pdf->Cell(25, 3, $guia[$i]['detalles_guia'][0]['cantidad'], 0,0,'C');	 	 	
			 $pdf->Cell(80, 3, substr($guia[$i]['detalles_guia'][0]['referencia_producto'],0,60), 0,0,'C');	 	 	
			 $pdf->Cell(15, 3, $guia[$i]['detalles_guia'][0]['peso'], 0,0,'C');
			 $pdf->Cell(20, 3, $guia[$i]['detalles_guia'][0]['peso_volumen'], 0,0,'C');
			 $pdf->Cell(25, 3, $guia[$i]['detalles_guia'][0]['guia_cliente'], 0,0,'C');	 
			 $pdf->Cell(40, 3, number_format($guia[$i]['detalles_guia'][0]['valor'],0,',','.'), 0,0,'C');	  	
			 
			 $pdf->SetX(40);
			 $pdf->SetY(174);	 
			 $pdf->Cell(25, 3, $guia[$i]['detalles_guia'][1]['cantidad'], 0,0,'C');	 	 	
			 $pdf->Cell(80, 3, substr($guia[$i]['detalles_guia'][1]['referencia_producto'],0,60), 0,0,'C');	 	 	
			 $pdf->Cell(15, 3, $guia[$i]['detalles_guia'][1]['peso'], 0,0,'C');	
			 $pdf->Cell(20, 3, $guia[$i]['detalles_guia'][1]['peso_volumen'], 0,0,'C');	
			 $pdf->Cell(25, 3, $guia[$i]['detalles_guia'][1]['guia_cliente'], 0,0,'C');	 
			 $pdf->Cell(40, 3, number_format($guia[$i]['detalles_guia'][1]['valor'],0,',','.'), 0,0,'C');		 
			
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
			 $pdf->Cell(15,5,"Vr. Manejo:",0,0,'L');
			 $pdf->Cell(10,5,number_format($guia[$i]['valor_manejo'],0,',','.')."",0,0,'L');	 
		
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
			 
			 // copia 3	 
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
			 $pdf->Cell(39,3,null,0,0,'R');		 	 
			 $pdf->Cell(10,3,'FACTURA DE VENTA',0,0,'R');
			 $pdf->Cell(30,3,$guia[$i]['numero_guia_bar'],0,0,'C');			 	 	 
			 $pdf->Ln(3.5);	 
		
			 // Cuadro 1	
			 $pdf->Cell(195,16,null,1,0,'C');
				 
			 // Fila 1 Cuadro 1
			 $pdf->SetX(40);
			 $pdf->SetY(86);
			 $pdf->Cell(18, 3, "Origen :", 0);
			 $pdf->Cell(65, 3, substr(utf8_decode($guia[$i]['origen']),0,34), 0);
			 $pdf->Cell(20, 3, "Destino :", 0);
			 $pdf->Cell(50, 3, substr(utf8_decode($guia[$i]['destino']),0,26), 0); 	 	 	 	 
			 
			 // Fila 2 Cuadro 1
			 $pdf->SetX(40);
			 $pdf->SetY(90);
			 $pdf->Cell(18, 3, "Remitente :", 0);
			 $pdf->Cell(65, 3, substr(utf8_decode($guia[$i]['remitente']),0,34), 0);
			 $pdf->Cell(20, 3, "Destinatario :", 0);
			 $pdf->Cell(50, 3, substr(utf8_decode($guia[$i]['destinatario']),0,26), 0);	
			 
			 // Fila 3 Cuadro 1
			 $pdf->SetX(40);
			 $pdf->SetY(94);
			 $pdf->Cell(18, 3, "Direccion :", 0);
			 $pdf->Cell(65, 3, substr(utf8_decode($guia[$i]['direccion_remitente']),0,34), 0);
			 $pdf->Cell(20, 3, "Direccion :", 0);
			 $pdf->Cell(50, 3, substr(utf8_decode($guia[$i]['direccion_destinatario']),0,26), 0); 	 	 	 	 
		 
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
			 $pdf->Cell(15, 3, "Peso (Kg)", 0,0,'C');	
			 $pdf->Cell(20, 3, "Peso Vol", 0,0,'C');	
			 $pdf->Cell(25, 3, "Doc. Cliente", 0,0,'C');	 
			 $pdf->Cell(40, 3, "V/r. Declarado", 0,0,'C');	 	 
			 
			 $pdf->SetFont('Arial','B',6);
			 
			 $pdf->SetX(40);
			 $pdf->SetY(105);	 
			 $pdf->Cell(25, 3, $guia[$i]['detalles_guia'][0]['cantidad'], 0,0,'C');	 	 	
			 $pdf->Cell(80, 3, substr($guia[$i]['detalles_guia'][0]['referencia_producto'],0,60), 0,0,'C');	 	 	
			 $pdf->Cell(15, 3, $guia[$i]['detalles_guia'][0]['peso'], 0,0,'C');	 
			 $pdf->Cell(20, 3, $guia[$i]['detalles_guia'][0]['peso_volumen'], 0,0,'C');	 
			 $pdf->Cell(25, 3, $guia[$i]['detalles_guia'][0]['guia_cliente'], 0,0,'C');	 
			 $pdf->Cell(40, 3, number_format($guia[$i]['detalles_guia'][0]['valor'],0,',','.'), 0,0,'C');	  	
			 
			 $pdf->SetX(40);
			 $pdf->SetY(108);	 
			 $pdf->Cell(25, 3, $guia[$i]['detalles_guia'][1]['cantidad'], 0,0,'C');	 	 	
			 $pdf->Cell(80, 3, substr($guia[$i]['detalles_guia'][1]['referencia_producto'],0,60), 0,0,'C');	 	 	
			 $pdf->Cell(15, 3, $guia[$i]['detalles_guia'][1]['peso'], 0,0,'C');	
			 $pdf->Cell(20, 3, $guia[$i]['detalles_guia'][1]['peso_volumen'], 0,0,'C');	
			 $pdf->Cell(25, 3, $guia[$i]['detalles_guia'][1]['guia_cliente'], 0,0,'C');	 
			 $pdf->Cell(40, 3, number_format($guia[$i]['detalles_guia'][1]['valor'],0,',','.'), 0,0,'C');		 
			
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
			 $pdf->Cell(15,5,"Vr. Manejo:",0,0,'L');
			 $pdf->Cell(10,5,number_format($guia[$i]['valor_manejo'],0,',','.')."",0,0,'L');	 
		
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
			 $pdf->Cell(195,3,"DESTINATARIO",0,0,'C');	
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
			 $pdf->Cell(39,3,null,0,0,'R');		 	 
			 $pdf->Cell(10,3,'FACTURA DE VENTA',0,0,'R');
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
			 $pdf->Cell(50, 3, substr(utf8_decode($guia[$i]['destino']),0,26), 0); 	 	 	 	 
			 
			 // Fila 2 Cuadro 1
			 $pdf->SetX(40);
			 $pdf->SetY(221);
			 $pdf->Cell(18, 3, "Remitente :", 0);
			 $pdf->Cell(65, 3, substr(utf8_decode($guia[$i]['remitente']),0,34), 0);
			 $pdf->Cell(20, 3, "Destinatario :", 0);
			 $pdf->Cell(50, 3, substr(utf8_decode($guia[$i]['destinatario']),0,26), 0);	
			 
			 // Fila 3 Cuadro 1
			 $pdf->SetX(40);
			 $pdf->SetY(225);
			 $pdf->Cell(18, 3, "Direccion :", 0);
			 $pdf->Cell(65, 3, substr(utf8_decode($guia[$i]['direccion_remitente']),0,34), 0);
			 $pdf->Cell(20, 3, "Direccion :", 0);
			 $pdf->Cell(50, 3, substr(utf8_decode($guia[$i]['direccion_destinatario']),0,26), 0);		 	 
		 
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
			 $pdf->Cell(15, 3, "Peso (Kg)", 0,0,'C');	 
			 $pdf->Cell(20, 3, "Peso Vol", 0,0,'C');	 
			 $pdf->Cell(25, 3, "Doc. Cliente", 0,0,'C');	 
			 $pdf->Cell(40, 3, "V/r. Declarado", 0,0,'C');	 	 
			 
			 $pdf->SetFont('Arial','B',6);
			 
			 $pdf->SetX(40);
			 $pdf->SetY(236);	 
			 $pdf->Cell(25, 3, $guia[$i]['detalles_guia'][0]['cantidad'], 0,0,'C');	 	 	
			 $pdf->Cell(80, 3, substr($guia[$i]['detalles_guia'][0]['referencia_producto'],0,60), 0,0,'C');	 	 	
			 $pdf->Cell(15, 3, $guia[$i]['detalles_guia'][0]['peso'], 0,0,'C');	 	 	
			 $pdf->Cell(20, 3, $guia[$i]['detalles_guia'][0]['peso_volumen'], 0,0,'C');
			 $pdf->Cell(25, 3, $guia[$i]['detalles_guia'][0]['guia_cliente'], 0,0,'C');	 
			 $pdf->Cell(40, 3, number_format($guia[$i]['detalles_guia'][0]['valor'],0,',','.'), 0,0,'C');	  	
			 
			 $pdf->SetX(40);
			 $pdf->SetY(239);	 
			 $pdf->Cell(25, 3, $guia[$i]['detalles_guia'][1]['cantidad'], 0,0,'C');	 	 	
			 $pdf->Cell(80, 3, substr($guia[$i]['detalles_guia'][1]['referencia_producto'],0,60), 0,0,'C');	 	 	
			 $pdf->Cell(15, 3, $guia[$i]['detalles_guia'][1]['peso'], 0,0,'C');	
			 $pdf->Cell(20, 3, $guia[$i]['detalles_guia'][1]['peso_volumen'], 0,0,'C');
			 $pdf->Cell(25, 3, $guia[$i]['detalles_guia'][1]['guia_cliente'], 0,0,'C');	 
			 $pdf->Cell(40, 3, number_format($guia[$i]['detalles_guia'][1]['valor'],0,',','.'), 0,0,'C');	
			 
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
			 $pdf->Cell(15,5,"Vr. Manejo:",0,0,'L');
			 $pdf->Cell(10,5,number_format($guia[$i]['valor_manejo'],0,',','.')."",0,0,'L');	 
		
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
			 $pdf->Cell(195,3,"ORIGINAL",0,0,'C');	
			// fin copia 4
			 }	 	
			
			$pdf->Output(); //Envía como salida del documento    
			
		}elseif($_REQUEST['formato']=='NO'){ //Inicia Impresion Masivo
		
			$pdf=new FPDF(); // Crea un objeto de la clase fpdf()
			$pdf->AddPage('P','Letter','mm'); // Agrega una hoja al documento.
			$pdf->SetFont('Arial','B',8); //Establece la fuente a utilizar, el formato Negrita y el tamaño
		
			#Establecemos los márgenes izquierda, arriba y derecha:
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
				 $pdf->Cell(55,7,"NIT. $nit_empresa",0,0,'R');		 
				 $pdf->Ln(3);	 
				 $pdf->SetFont('Arial','B',5);	
				 $pdf->Cell(60,7,$guia[$i]['pagina_web'],0,0,'R');		 	 
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
				
				 $pdf->SetY(27);
				 $pdf->SetX(76);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(20, 3, "Destinatario", 1);
				 $pdf->SetY(30);				 
				 $pdf->SetX(74.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,27), 0);
				 $pdf->SetY(33);				 
				 $pdf->SetX(74.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,30), 0);
				 $pdf->SetY(35);				 
				 $pdf->SetX(74.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 30,30), 0);
				 $pdf->SetY(38);
				 $pdf->SetX(74.5);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22));
				 $pdf->SetY(40);
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

 				 $pdf->SetY(18);	 	
				 $pdf->SetX(45);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Res. MINTIC No 4304 de 2013',0);
				 if($guia[$i]['orden_despacho']!='' && $guia[$i]['orden_despacho']!=0){
					 $pdf->SetY(20);	 	
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
				 $pdf->Cell(169,8,$guia[$i]['pagina_web'],0,0,'R');		 	 
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
				 $pdf->SetY(27);
				 $pdf->SetX(185);
				 $pdf->Cell(20, 3, "Destinatario", 1);
				 $pdf->SetY(30);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,27), 0);
				 $pdf->SetY(33);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,30), 0);
				 $pdf->SetY(35);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 30,30), 0);
				 $pdf->SetY(38);
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22), 0);
				 $pdf->SetY(40);
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

 				 $pdf->SetY(18);	 	
				 $pdf->SetX(154);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Res. MINTIC No 4304 de 2013',0);
				 if($guia[$i]['orden_despacho']!='' && $guia[$i]['orden_despacho']!=0){
					 $pdf->SetY(20);	 	
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
				 $pdf->Cell(55,0,"NIT. $nit_empresa",0,0,'R');	
				 $pdf->Ln(3);
				 $pdf->SetFont('Arial','B',5);	 
				 $pdf->Cell(60,-1,$guia[$i]['pagina_web'],0,0,'R');	
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
				
				 $pdf->SetY(78);
				 $pdf->SetX(76);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(20, 3, "Destinatario", 1);
				 $pdf->SetY(81);				 
				 $pdf->SetX(75);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,27), 0);
				 $pdf->SetY(84);				 
				 $pdf->SetX(75);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,30), 0);
				 $pdf->SetY(86);				 
				 $pdf->SetX(75);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 30,30), 0);
				 $pdf->SetY(89);				 
				 $pdf->SetX(75);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,30), 0);
				 $pdf->SetY(91);				 
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

 				 $pdf->SetY(70);	 	
				 $pdf->SetX(45);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Res. MINTIC No 4304 de 2013',0);
				 if($guia[$i]['orden_despacho']!='' && $guia[$i]['orden_despacho']!=0){
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
				 $pdf->Cell(169,16,$guia[$i]['pagina_web'],0,0,'R');		 	 
				 $pdf->Ln(3);	 
				 $pdf->SetFont('Arial','B',7);		 	 	 
				 $pdf->Cell(383,20,$guia[$i]['numero_guia_bar'],0,0,'C');		 	 	 				 	 	 
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
				 $pdf->SetY(78);
				 $pdf->SetX(185);
				 $pdf->Cell(20, 3, "Destinatario", 1);
				 $pdf->SetY(80);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,27), 0);
				 $pdf->SetY(84);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,30), 0);
				 $pdf->SetY(86);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 30,30), 0);
				 $pdf->SetY(89);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,30), 0);
				 $pdf->SetY(91);				 
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

 				 $pdf->SetY(70);	 	
				 $pdf->SetX(154);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Res. MINTIC No 4304 de 2013',0);
				 if($guia[$i]['orden_despacho']!='' && $guia[$i]['orden_despacho']!=0){
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
				 $pdf->Cell(55,27,"NIT. $nit_empresa",0,0,'R');	
				 $pdf->Ln(3);
				 $pdf->SetFont('Arial','B',5);	 
				 $pdf->Cell(60,27,$guia[$i]['pagina_web'],0,0,'R');	
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
				
				 $pdf->SetY(129);
				 $pdf->SetX(76);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(20, 3, "Destinatario", 1);
				 $pdf->SetY(132);				 
				 $pdf->SetX(74.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,27), 0);
				 $pdf->SetY(135);				 
				 $pdf->SetX(74.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,30), 0);
				 $pdf->SetY(137);				 
				 $pdf->SetX(74.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 30,30), 0);
				 $pdf->SetY(140);				 
				 $pdf->SetX(74.5);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,30), 0);
				 $pdf->SetY(142);				 
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
				 $pdf->Cell(42,9,'',1);


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

 				 $pdf->SetY(128);	 	
				 $pdf->SetX(62);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(12,2,'CONSECUTIVO',1);

 				 $pdf->SetY(145);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,8,'',1);

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
				 
 				 $pdf->SetY(145);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(42,9,'',1);

 				 $pdf->SetY(145);	 	
				 $pdf->SetX(33);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(8,2,'DEVOL',1);

 				 $pdf->SetY(148);	 	
				 $pdf->SetX(34);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(14,2,'DESCONOCIDO',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(11,2,'REHUSADO',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(10,2,'NO RESIDE',0);

 				 $pdf->SetY(151);	 	
				 $pdf->SetX(34);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(14,2,'DIR INCOMPLETA',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(11,2,'DIR ERRADA',0);
				 $pdf->Cell(2,2,'',1);
				 $pdf->Cell(10,2,'OTRO',0);
				 //FIN PARTE DE CENTRO

 				 $pdf->SetY(121);	 	
				 $pdf->SetX(45);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Res. MINTIC No 4304 de 2013',0);
				 if($guia[$i]['orden_despacho']!='' && $guia[$i]['orden_despacho']!=0){
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
				 $pdf->Cell(164,18,"NIT. $nit_empresa",0,0,'R');		 
				 $pdf->Ln(3);
				 $pdf->SetFont('Arial','B',5);	
				 $pdf->Cell(169,18,$guia[$i]['pagina_web'],0,0,'R');		 	 
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
				 $pdf->SetY(129);
				 $pdf->SetX(185);
				 $pdf->Cell(20, 3, "Destinatario", 1);
				 $pdf->SetY(132);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,27), 0);
				 $pdf->SetY(136);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,30), 0);
				 $pdf->SetY(138);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 30,30), 0);
				 $pdf->SetY(141);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,30), 0);
				 $pdf->SetY(143);				 
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


 				 $pdf->SetY(121);	 	
				 $pdf->SetX(154);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Res. MINTIC No 4304 de 2013',0);
				 if($guia[$i]['orden_despacho']!='' && $guia[$i]['orden_despacho']!=0){
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
				 $pdf->Cell(55,27,"NIT. $nit_empresa",0,0,'R');	
				 $pdf->Ln(3);
				 $pdf->SetFont('Arial','B',5);	 
				 $pdf->Cell(60,27,$guia[$i]['pagina_web'],0,0,'R');	
				 $pdf->Ln(3);	 
				 $pdf->SetFont('Arial','B',7);		 	 	 
				 $pdf->Cell(170,31,$guia[$i]['numero_guia_bar'],0,0,'C');		 	 	 
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
				
				 $pdf->SetY(180);
				 $pdf->SetX(76);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(20, 3, "Destinatario", 1);
				 $pdf->SetY(183);				 
				 $pdf->SetX(74.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,27), 0);
				 $pdf->SetY(186);				 
				 $pdf->SetX(74.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,30), 0);
				 $pdf->SetY(188);				 
				 $pdf->SetX(74.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 30,30), 0);
				 $pdf->SetY(191);				 
				 $pdf->SetX(74.5);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,30), 0);
				 $pdf->SetY(193);				 
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

 				 $pdf->SetY(172);	 	
				 $pdf->SetX(45);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Res. MINTIC No 4304 de 2013',0);
				 if($guia[$i]['orden_despacho']!='' && $guia[$i]['orden_despacho']!=0){
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
				 $pdf->Cell(164,16,"NIT. $nit_empresa",0,0,'R');		 
				 $pdf->Ln(3);
				 $pdf->SetFont('Arial','B',5);	
				 $pdf->Cell(169,16,$guia[$i]['pagina_web'],0,0,'R');		 	 
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

				 $pdf->SetY(180);
				 $pdf->SetX(185);
				 $pdf->Cell(20, 3, "Destinatario", 1);
				 $pdf->SetY(183);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,27), 0);
				 $pdf->SetY(186);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,30), 0);
				 $pdf->SetY(188);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 30,30), 0);
				 $pdf->SetY(191);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,30), 0);
				 $pdf->SetY(193);				 
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
				 $pdf->SetX(155);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(9,2,'REMISION',1);

 				 $pdf->SetY(179);	 	
				 $pdf->SetX(165);
				 $pdf->SetFont('Arial','',4);	
				 $pdf->Cell(6,2,'ZONA',1);

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

 				 $pdf->SetY(172);	 	
				 $pdf->SetX(154);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Res. MINTIC No 4304 de 2013',0);
				 if($guia[$i]['orden_despacho']!='' && $guia[$i]['orden_despacho']!=0){
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
				 $pdf->Cell(55,27,"NIT. $nit_empresa",0,0,'R');	
				 $pdf->Ln(3);
				 $pdf->SetFont('Arial','B',5);	 
				 $pdf->Cell(60,27,$guia[$i]['pagina_web'],0,0,'R');	
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
				
				 $pdf->SetY(232);
				 $pdf->SetX(76);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(20, 3, "Destinatario", 1);
				 $pdf->SetY(235);				 
				 $pdf->SetX(75);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,27), 0);
				 $pdf->SetY(238);				 
				 $pdf->SetX(75);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,30), 0);
				 $pdf->SetY(240);				 
				 $pdf->SetX(75);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']),30,30), 0);
				 $pdf->SetY(243);				 
				 $pdf->SetX(75);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,30), 0);
				 $pdf->SetY(245);				 
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

 				 $pdf->SetY(223);	 	
				 $pdf->SetX(45);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Res. MINTIC No 4304 de 2013',0);
				 if($guia[$i]['orden_despacho']!='' && $guia[$i]['orden_despacho']!=0){
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
				 $pdf->Cell(164,16,"NIT. $nit_empresa",0,0,'R');		 
				 $pdf->Ln(3);
				 $pdf->SetFont('Arial','B',5);	
				 $pdf->Cell(169,16,$guia[$i]['pagina_web'],0,0,'R');		 	 
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

				 $pdf->SetY(232);
				 $pdf->SetX(185);
				 $pdf->Cell(20, 3, "Destinatario", 1);
				 $pdf->SetY(235);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['destinatario']), 0,27), 0);
				 $pdf->SetY(238);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 0,30), 0);
				 $pdf->SetY(240);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, substr(utf8_decode($guia[$i]['direccion_destinatario']), 30,30), 0);
				 $pdf->SetY(243);				 
				 $pdf->SetX(183.5);
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,30), 0);
				 $pdf->SetY(245);				 
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

 				 $pdf->SetY(223);	 	
				 $pdf->SetX(154);
				 $pdf->SetFont('Arial','',5);	
				 $pdf->Cell(14,2,'Res. MINTIC No 4304 de 2013',0);
				 if($guia[$i]['orden_despacho']!='' && $guia[$i]['orden_despacho']!=0){
					 $pdf->SetY(225);	 	
					 $pdf->SetX(154);
					 $pdf->Cell(14,2,'Doc. Cliente: '.$guia[$i]['orden_despacho'],0);
				 }
				 

 				 //FIN CUADRO DERECHO FECHA HORA CODIGO MENSAJERO


				// Fin Fila 4 Columna 2
			}

			if($j == 9){ $pdf->AddPage('P','Letter','mm'); $j=0;  }else{ $j++; } 

		  }	 	
			
		  $pdf->Output(); //Envía como salida del documento  
	 	}elseif($_REQUEST['formato']=='RT'){
		 	//Inicia Impresion rotulos
		
			$pdf=new FPDF(); // Crea un objeto de la clase fpdf()
			$pdf->AddPage('P','Letter','mm'); // Agrega una hoja al documento.
			$pdf->SetFont('Arial','B',9); //Establece la fuente a utilizar, el formato Negrita y el tamaño
		
			#Establecemos los márgenes izquierda, arriba y derecha:
			$pdf->SetMargins(3, 4 , 3);
		
			#Establecemos el margen inferior:
			$pdf->SetAutoPageBreak(true,1);  
		
			$j=0;
			for($i = 0; $i < count($guia); $i++){	
			 
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
			 
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
			 
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
			 
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
			 
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
			 
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
			 
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
			 
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
			 
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
			 
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
			 
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
			 
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
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
				 $pdf->Cell(18, 5, 'Tel. '.substr(utf8_decode($guia[$i]['telefono_destinatario']), 0,22).' '.$guia[$i]['destino'], 0);
			}
			
			if($j == 47){ $pdf->AddPage('P','Letter','mm'); $j=0;  }else{ $j++; } 

		  }	 	
			
		  $pdf->Output(); //Envía como salida del documento  
	 				
		}
 	 }	
}

new Imp_Guia();

?>