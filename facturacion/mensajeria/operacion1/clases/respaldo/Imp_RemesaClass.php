<?php

final class Imp_Remesa{

  private $Conex;
  
  public function __construct($Conex){  
    $this -> Conex = $Conex;  
  }

  public function printOut($usuario,$empresa_id,$oficina_id,$nit_empresa){
      	
      //require_once("Imp_RemesaLayoutClass.php");
      require_once("Imp_RemesaModelClass.php");
      require_once("../../../framework/clases/fpdf/fpdf.php");	  	  
      require_once("../../../framework/clases/barcode.php");	  
		
    //  $Layout  = new Imp_RemesaLayout();
      $Model   = new Imp_RemesaModel();		
	  $barcode = new barcode();
		
	  $remesas = $Model -> getRemesas($oficina_id,$this -> Conex);	
		
	  for($i = 0; $i < count($remesas); $i++){
	  
	    foreach($remesas[$i] as $llave => $valor){
		
		  if($llave == 'numero_remesa'){
	         $barcode -> setParams("$valor"); 
			 $remesas[$i]['codbar'] = $barcode -> getUrlImageCodBar();
		  }	    
		
		}
		
	  }	
	
//      $Layout -> setRemesas($remesas,$usuario);	
  //    $Layout -> setOficinas($Model -> getOficinas($empresa_id,$this -> Conex));	            
      
      //$Layout -> RenderMain();
	  
    $pdf=new FPDF(); // Crea un objeto de la clase fpdf()
    $pdf->AddPage('P','Letter','mm'); // Agrega una hoja al documento.
    $pdf->SetFont('Arial','B',10); //Establece la fuente a utilizar, el formato Negrita y el tamaño

    #Establecemos los márgenes izquierda, arriba y derecha:
    $pdf->SetMargins(10, 5 , 5);

    #Establecemos el margen inferior:
    $pdf->SetAutoPageBreak(true,1);  

	
	for($i = 0; $i < count($remesas); $i++){
	
     if($i > 0) $pdf->AddPage('P','Letter','mm');

	 // Copia 1
     $pdf->SetX(40);
     $pdf->SetY(10);	
	 $pdf->Image($remesas[$i]['logo'],10,8,41,11); 
	 $pdf->Image($remesas[$i]['codbar'],165,8,40,7); 	 
	 $pdf->Cell(40,3,null,0,0,'R');		 	 
     $pdf->SetFont('Arial','B',7);	 
	 $pdf->Cell(55,3,"NIT. $nit_empresa",0,0,'R');		 
	 
     $pdf->SetFont('Arial','B',5);	 
	 $pdf->Cell(30,3,'SERVICIO',0,0,'C');	
     $pdf->SetFont('Arial','B',10);		 	 
	 $pdf->Cell(25,3,$remesas[$i]['fecha_remesa'],0,0,'C');		 	 
	 $pdf->Ln(3);	 
	 $pdf->Cell(100,3,$remesas[$i]['pagina_web'],0,0,'R');		 	 	 
     $pdf->SetFont('Arial','B',5);		 	 	 	 
	 $pdf->Cell(15,3,'ENTREGA',0,0,'R');		 	 
	 $pdf->Ln(3);	 
	 $pdf->Cell(116,3,'INMEDIATA',0,0,'R');		 	 
     $pdf->SetFont('Arial','B',8);		 	 	 
	 $pdf->Cell(39,3,null,0,0,'R');		 	 
	 $pdf->Cell(40,3,$remesas[$i]['numero_remesa'],0,0,'C');		 	 	 
	 $pdf->Ln(3.5);	 

     // Cuadro 1	
	 $pdf->Cell(195,16,null,1,0,'C');
	 	 
     // Fila 1 Cuadro 1
     $pdf->SetX(40);
     $pdf->SetY(20);
     $pdf->Cell(18, 3, "Origen :", 0);
     $pdf->Cell(65, 3, substr(utf8_decode($remesas[$i]['origen']),0,34), 0);
     $pdf->Cell(20, 3, "Destino :", 0);
     $pdf->Cell(50, 3, substr(utf8_decode($remesas[$i]['destino']),0,26), 0);	 	 	 
     $pdf->Cell(17, 3, "Codigo :", 0);	 	 	 
     $pdf->Cell(25, 3, substr(utf8_decode($remesas[$i]['codigo']),0,15), 0);	 	 	 	 	 
	 
     // Fila 2 Cuadro 1
     $pdf->SetX(40);
     $pdf->SetY(24);
     $pdf->Cell(18, 3, "Remitente :", 0);
     $pdf->Cell(65, 3, substr(utf8_decode($remesas[$i]['remitente']),0,34), 0);
     $pdf->Cell(20, 3, "Destinatario :", 0);
     $pdf->Cell(50, 3, substr(utf8_decode($remesas[$i]['destinatario']),0,26), 0);	 	 	 
     $pdf->Cell(17, 3, "Naturaleza :", 0);	 	 	 
     $pdf->Cell(25, 3, substr(utf8_decode($remesas[$i]['naturaleza']),0,15), 0);	
	 
     // Fila 3 Cuadro 1
     $pdf->SetX(40);
     $pdf->SetY(28);
     $pdf->Cell(18, 3, "Direccion :", 0);
     $pdf->Cell(65, 3, substr(utf8_decode($remesas[$i]['direccion_remitente']),0,34), 0);
     $pdf->Cell(20, 3, "Direccion :", 0);
     $pdf->Cell(50, 3, substr(utf8_decode($remesas[$i]['direccion_destinatario']),0,26), 0);	 	 	 
     $pdf->Cell(17, 3, "Medida :", 0);	 	 	 
     $pdf->Cell(25, 3, substr(utf8_decode($remesas[$i]['medida']),0,15), 0);		  	 	 	 	 
 
     // Fila 4 Cuadro 1
     $pdf->SetX(40);
     $pdf->SetY(32);
     $pdf->Cell(18, 3, "Telefono :", 0);
     $pdf->Cell(65, 3, substr(utf8_decode($remesas[$i]['telefono_remitente']),0,34), 0);
     $pdf->Cell(20, 3, "Telefono :", 0);
     $pdf->Cell(50, 3, substr(utf8_decode($remesas[$i]['telefono_destinatario']),0,26), 0);	 	 	 
     $pdf->Cell(17, 3, "Empaque :", 0);	 	 	 
     $pdf->Cell(25, 3, substr(utf8_decode($remesas[$i]['empaque']),0,15), 0);	
	 
     // Cuadro 2
	 
     $pdf->SetX(40);
     $pdf->SetY(35);	 	
	 $pdf->Cell(195,16,null,1,0,'C');
     $pdf->SetX(40);
     $pdf->SetY(36);	 
     $pdf->Cell(25, 3, "Cantidad", 0,0,'C');	 	 	
     $pdf->Cell(80, 3, "Producto", 0,0,'C');	 	 	
     $pdf->Cell(15, 3, "Peso", 0,0,'C');	
	 $pdf->Cell(20, 3, "Peso Vol", 0,0,'C');	
     $pdf->Cell(25, 3, "Doc. Cliente", 0,0,'C');	 
     $pdf->Cell(40, 3, "V/r. Declarado", 0,0,'C');	 	 
	 
     $pdf->SetFont('Arial','B',6);
	 
     $pdf->SetX(40);
     $pdf->SetY(40);	 
     $pdf->Cell(25, 3, $remesas[$i]['detalles_remesa'][0]['cantidad'], 0,0,'C');	 	 	
     $pdf->Cell(80, 3, substr($remesas[$i]['detalles_remesa'][0]['descripcion_producto'],0,60), 0,0,'C');	 	 	
     $pdf->Cell(15, 3, $remesas[$i]['detalles_remesa'][0]['peso'], 0,0,'C');	
  	 $pdf->Cell(20, 3, $remesas[$i]['detalles_remesa'][0]['peso_volumen'], 0,0,'C');	
     $pdf->Cell(25, 3, $remesas[$i]['detalles_remesa'][0]['guia_cliente'], 0,0,'C');	 
     $pdf->Cell(40, 3, number_format($remesas[$i]['detalles_remesa'][0]['valor'],0,',','.'), 0,0,'C');	  	
	 
     $pdf->SetX(40);
     $pdf->SetY(44);	 
     $pdf->Cell(25, 3, $remesas[$i]['detalles_remesa'][1]['cantidad'], 0,0,'C');	 	 	
     $pdf->Cell(80, 3, substr($remesas[$i]['detalles_remesa'][1]['descripcion_producto'],0,60), 0,0,'C');	 	 	
     $pdf->Cell(15, 3, $remesas[$i]['detalles_remesa'][1]['peso'], 0,0,'C');	
  	 $pdf->Cell(20, 3, $remesas[$i]['detalles_remesa'][1]['peso_volumen'], 0,0,'C');	
     $pdf->Cell(25, 3, $remesas[$i]['detalles_remesa'][1]['guia_cliente'], 0,0,'C');	 
     $pdf->Cell(40, 3, number_format($remesas[$i]['detalles_remesa'][1]['valor'],0,',','.'), 0,0,'C');	
	 
	
     // Cuadro 3
	 
     $pdf->SetX(40);
     $pdf->SetY(51);	 	
	 $pdf->Cell(195,15,null,1,0,'C');	
	 
	 
     $pdf->SetX(40);
     $pdf->SetY(51);	 	
	 $pdf->Cell(90,5,"Observaciones :",0,0,'L');
	 $pdf->Cell(75,5,"Recibe a conformidad",0,0,'L');
	 $pdf->Cell(15,5,"V/R Flete:",0,0,'L');
	 $pdf->Cell(10,5,number_format($remesas[$i]['valor_flete'],0,',','.')."",0,0,'L');	 

     $pdf->SetX(40);
     $pdf->SetY(54);	 	
	 $pdf->Cell(90,5,"",0,0,'L');
	 $pdf->Cell(75,5,"",0,0,'L');
	 $pdf->Cell(15,5,"V/r Seguro:",0,0,'L');
	 $pdf->Cell(10,5,number_format($remesas[$i]['valor_seguro'],0,',','.')."",0,0,'L');	 

     $pdf->SetX(40);
     $pdf->SetY(57);	 	
	 $pdf->Cell(90,5,"",0,0,'L');
	 $pdf->Cell(75,5,"",0,0,'L');
	 $pdf->Cell(15,5,"Otros:",0,0,'L');
 	 $pdf->Cell(10,5,number_format($remesas[$i]['valor_otros'],0,',','.')."",0,0,'L');	 


     $pdf->SetX(40);
     $pdf->SetY(61);	 	
	 $pdf->Cell(90,5,"",0,0,'L');
	 $pdf->Cell(75,5,"",0,0,'L');
	 $pdf->Cell(15,5,"V/R. TOTAL",0,0,'L');
 	 $pdf->Cell(10,5,number_format($remesas[$i]['valor_total'],0,',','.')."",0,0,'L');	 

	 
     $pdf->SetX(40);
     $pdf->SetY(54);	 	
	 $pdf->Cell(90,5,substr($remesas[$i]['observaciones'],0,80),0,0,'L');	 
	 $pdf->Cell(95,5,null,0,0,'L');	 
	 
     $pdf->SetX(40);
     $pdf->SetY(57);	 	
	 $pdf->Cell(90,5,trim(substr($remesas[$i]['observaciones'],79,80)),0,0,'L');	 	 
	 $pdf->Cell(95,5,null,0,0,'L');	 
	 	 
     $pdf->SetX(40);
     $pdf->SetY(61);	 	
	 $pdf->Cell(90,5,$remesas[$i]['oficina_responsable'],0,0,'C');	 
	 $pdf->Cell(95,5,"Nombre legible, C.C, Firma, Sello y Fecha.",0,0,'L');	 
	 
 	 	 	 
	 
     $pdf->SetFont('Arial','B',6);		 
     $pdf->SetX(40);
     $pdf->SetY(66);	 	
	 $pdf->Cell(195,3,"TRANSPORTADORA",0,0,'C');
	 
	 // fin copia 1
	 
	 
	 // copia 3
	 
 	 $pdf->Ln(10);	 
     $pdf->SetFont('Arial','B',10); 	 
	 
	 $pdf->Image($remesas[$i]['logo'],10,140,41,11); 
	 $pdf->Image($remesas[$i]['codbar'],165,140,40,7); 	 
	 $pdf->Cell(40,3,null,0,0,'R');		 	 
     $pdf->SetFont('Arial','B',7);	 
	 $pdf->Cell(55,3,"NIT. $nit_empresa",0,0,'R');		 
	 
     $pdf->SetFont('Arial','B',5);	 
	 $pdf->Cell(30,3,'SERVICIO',0,0,'C');	
     $pdf->SetFont('Arial','B',10);		 	 
	 $pdf->Cell(25,3,$remesas[$i]['fecha_remesa'],0,0,'C');		 	 	 	 	 
	 $pdf->Ln(3);	 
	 $pdf->Cell(100,3,$remesas[$i]['pagina_web'],0,0,'R');		 	 	 
     $pdf->SetFont('Arial','B',5);		 	 	 	 
	 $pdf->Cell(15,3,'ENTREGA',0,0,'R');		 	 
	 $pdf->Ln(3);	 
	 $pdf->Cell(116,3,'INMEDIATA',0,0,'R');		 	 
     $pdf->SetFont('Arial','B',8);		 	 	 
	 $pdf->Cell(39,3,null,0,0,'R');		 	 
	 $pdf->Cell(40,3,$remesas[$i]['numero_remesa'],0,0,'C');		 	 	 
	 $pdf->Ln(3.5);	 

     // Cuadro 1	
	 $pdf->Cell(195,16,null,1,0,'C');
	 	 
     // Fila 1 Cuadro 1
     $pdf->SetX(40);
     $pdf->SetY(152);
     $pdf->Cell(18, 3, "Origen :", 0);
     $pdf->Cell(65, 3, substr(utf8_decode($remesas[$i]['origen']),0,34), 0);
     $pdf->Cell(20, 3, "Destino :", 0);
     $pdf->Cell(50, 3, substr(utf8_decode($remesas[$i]['destino']),0,26), 0);	 	 	 
     $pdf->Cell(17, 3, "Codigo :", 0);	 	 	 
     $pdf->Cell(25, 3, substr(utf8_decode($remesas[$i]['codigo']),0,15), 0);	 	 	 	 	 
	 
     // Fila 2 Cuadro 1
     $pdf->SetX(40);
     $pdf->SetY(156);
     $pdf->Cell(18, 3, "Remitente :", 0);
     $pdf->Cell(65, 3, substr(utf8_decode($remesas[$i]['remitente']),0,34), 0);
     $pdf->Cell(20, 3, "Destinatario :", 0);
     $pdf->Cell(50, 3, substr(utf8_decode($remesas[$i]['destinatario']),0,26), 0);	 	 	 
     $pdf->Cell(17, 3, "Naturaleza :", 0);	 	 	 
     $pdf->Cell(25, 3, substr(utf8_decode($remesas[$i]['naturaleza']),0,15), 0);	
	 
     // Fila 3 Cuadro 1
     $pdf->SetX(40);
     $pdf->SetY(160);
     $pdf->Cell(18, 3, "Direccion :", 0);
     $pdf->Cell(65, 3, substr(utf8_decode($remesas[$i]['direccion_remitente']),0,34), 0);
     $pdf->Cell(20, 3, "Direccion :", 0);
     $pdf->Cell(50, 3, substr(utf8_decode($remesas[$i]['direccion_destinatario']),0,26), 0);	 	 	 
     $pdf->Cell(17, 3, "Medida :", 0);	 	 	 
     $pdf->Cell(25, 3, substr(utf8_decode($remesas[$i]['medida']),0,15), 0);		  	 	 	 	 
 
     // Fila 4 Cuadro 1
     $pdf->SetX(40);
     $pdf->SetY(164);
     $pdf->Cell(18, 3, "Telefono :", 0);
     $pdf->Cell(65, 3, substr(utf8_decode($remesas[$i]['telefono_remitente']),0,34), 0);
     $pdf->Cell(20, 3, "Telefono :", 0);
     $pdf->Cell(50, 3, substr(utf8_decode($remesas[$i]['telefono_destinatario']),0,26), 0);	 	 	 
     $pdf->Cell(17, 3, "Empaque :", 0);	 	 	 
     $pdf->Cell(25, 3, substr(utf8_decode($remesas[$i]['empaque']),0,15), 0);	
	 
     // Cuadro 2
	 
     $pdf->SetX(40);
     $pdf->SetY(167);	 	
	 $pdf->Cell(195,16,null,1,0,'C');
     $pdf->SetX(40);
     $pdf->SetY(168);	 
     $pdf->Cell(25, 3, "Cantidad", 0,0,'C');	 	 	
     $pdf->Cell(80, 3, "Producto", 0,0,'C');	 	 	
     $pdf->Cell(15, 3, "Peso", 0,0,'C');	
	 $pdf->Cell(20, 3, "Peso Vol", 0,0,'C');	
     $pdf->Cell(25, 3, "Doc. Cliente", 0,0,'C');	 
     $pdf->Cell(40, 3, "V/r. Declarado", 0,0,'C');	 	 
	 
     $pdf->SetFont('Arial','B',6);
	 
     $pdf->SetX(40);
     $pdf->SetY(171);	 
     $pdf->Cell(25, 3, $remesas[$i]['detalles_remesa'][0]['cantidad'], 0,0,'C');	 	 	
     $pdf->Cell(80, 3, substr($remesas[$i]['detalles_remesa'][0]['descripcion_producto'],0,60), 0,0,'C');	 	 	
     $pdf->Cell(15, 3, $remesas[$i]['detalles_remesa'][0]['peso'], 0,0,'C');
	 $pdf->Cell(20, 3, $remesas[$i]['detalles_remesa'][0]['peso_volumen'], 0,0,'C');
     $pdf->Cell(25, 3, $remesas[$i]['detalles_remesa'][0]['guia_cliente'], 0,0,'C');	 
     $pdf->Cell(40, 3, number_format($remesas[$i]['detalles_remesa'][0]['valor'],0,',','.'), 0,0,'C');	  	
	 
     $pdf->SetX(40);
     $pdf->SetY(174);	 
     $pdf->Cell(25, 3, $remesas[$i]['detalles_remesa'][1]['cantidad'], 0,0,'C');	 	 	
     $pdf->Cell(80, 3, substr($remesas[$i]['detalles_remesa'][1]['descripcion_producto'],0,60), 0,0,'C');	 	 	
     $pdf->Cell(15, 3, $remesas[$i]['detalles_remesa'][1]['peso'], 0,0,'C');	
	 $pdf->Cell(20, 3, $remesas[$i]['detalles_remesa'][1]['peso_volumen'], 0,0,'C');	
     $pdf->Cell(25, 3, $remesas[$i]['detalles_remesa'][1]['guia_cliente'], 0,0,'C');	 
     $pdf->Cell(40, 3, number_format($remesas[$i]['detalles_remesa'][1]['valor'],0,',','.'), 0,0,'C');	
	 
	
     // Cuadro 3
	 
     $pdf->SetX(40);
     $pdf->SetY(117);	 	
	 $pdf->Cell(195,15,null,1,0,'C');	
	 
	 
     $pdf->SetX(40);
     $pdf->SetY(117);	 	
	 $pdf->Cell(90,5,"Observaciones :",0,0,'L');
	 $pdf->Cell(75,5,"Recibe a conformidad",0,0,'L');	 
	 $pdf->Cell(15,5,"V/R Flete:",0,0,'L');
	 $pdf->Cell(10,5,number_format($remesas[$i]['valor_flete'],0,',','.')."",0,0,'L');	 

     $pdf->SetX(40);
     $pdf->SetY(120);	 	
	 $pdf->Cell(90,5,"",0,0,'L');
	 $pdf->Cell(75,5,"",0,0,'L');
	 $pdf->Cell(15,5,"V/r Seguro:",0,0,'L');
	 $pdf->Cell(10,5,number_format($remesas[$i]['valor_seguro'],0,',','.')."",0,0,'L');	 

     $pdf->SetX(40);
     $pdf->SetY(123);	 	
	 $pdf->Cell(90,5,"",0,0,'L');
	 $pdf->Cell(75,5,"",0,0,'L');
	 $pdf->Cell(15,5,"Otros:",0,0,'L');
	 $pdf->Cell(10,5,number_format($remesas[$i]['valor_otros'],0,',','.')."",0,0,'L');	 

     $pdf->SetX(40);
     $pdf->SetY(127);	 	
	 $pdf->Cell(90,5,"",0,0,'L');
	 $pdf->Cell(75,5,"",0,0,'L');
	 $pdf->Cell(15,5,"V/R. TOTAL",0,0,'L');
	 $pdf->Cell(10,5,number_format($remesas[$i]['valor_total'],0,',','.')."",0,0,'L');

     $pdf->SetX(40);
     $pdf->SetY(120);	 	
	 $pdf->Cell(90,5,substr(utf8_decode($remesas[$i]['observaciones']),0,80),0,0,'L');	 	 
	 $pdf->Cell(95,5,null,0,0,'L');	 

     $pdf->SetX(40);
     $pdf->SetY(123);	 	
	 $pdf->Cell(90,5,trim(substr($remesas[$i]['observaciones'],79,80)),0,0,'L');	 	 
	 $pdf->Cell(95,5,null,0,0,'L');	 

	 	 
     $pdf->SetX(40);
     $pdf->SetY(127);	 	
	 $pdf->Cell(90,5,utf8_decode($remesas[$i]['oficina_responsable']),0,0,'C');	 
	 $pdf->Cell(95,5,"Nombre legible, C.C, Firma, Sello y Fecha.",0,0,'L');	 
	 
 	 	 	 
	 
     $pdf->SetFont('Arial','B',6);		 
     $pdf->SetX(40);
     $pdf->SetY(132);	 	
	 $pdf->Cell(195,3,"CLIENTE",0,0,'C');	 
	 
	 
	 // fin copia 2
	 
	 // copia 3
	 
 	 $pdf->Ln(10);	 
     $pdf->SetFont('Arial','B',10); 	 
	 
	 $pdf->Image($remesas[$i]['logo'],10,74,41,11); 
	 $pdf->Image($remesas[$i]['codbar'],165,74,40,7); 	 
	 $pdf->Cell(40,3,null,0,0,'R');		 	 
     $pdf->SetFont('Arial','B',7);	 
	 $pdf->Cell(55,3,"NIT. $nit_empresa",0,0,'R');		 
	 
     $pdf->SetFont('Arial','B',5);	 
	 $pdf->Cell(30,3,'SERVICIO',0,0,'C');	
     $pdf->SetFont('Arial','B',10);		 	 
	 $pdf->Cell(25,3,$remesas[$i]['fecha_remesa'],0,0,'C');		 	 	 	 	 
	 $pdf->Ln(3);	 
	 $pdf->Cell(100,3,$remesas[$i]['pagina_web'],0,0,'R');		 	 	 
     $pdf->SetFont('Arial','B',5);		 	 	 	 
	 $pdf->Cell(15,3,'ENTREGA',0,0,'R');	 	 
	 $pdf->Ln(3);	 
	 $pdf->Cell(116,3,'INMEDIATA',0,0,'R');		 	 
     $pdf->SetFont('Arial','B',8);		 	 	 
	 $pdf->Cell(39,3,null,0,0,'R');		 	 
	 $pdf->Cell(40,3,$remesas[$i]['numero_remesa'],0,0,'C');		 	 	 
	 $pdf->Ln(3.5);	 

     // Cuadro 1	
	 $pdf->Cell(195,16,null,1,0,'C');
	 	 
     // Fila 1 Cuadro 1
     $pdf->SetX(40);
     $pdf->SetY(86);
     $pdf->Cell(18, 3, "Origen :", 0);
     $pdf->Cell(65, 3, substr(utf8_decode($remesas[$i]['origen']),0,34), 0);
     $pdf->Cell(20, 3, "Destino :", 0);
     $pdf->Cell(50, 3, substr(utf8_decode($remesas[$i]['destino']),0,26), 0);	 	 	 
     $pdf->Cell(17, 3, "Codigo :", 0);	 	 	 
     $pdf->Cell(25, 3, substr(utf8_decode($remesas[$i]['codigo']),0,15), 0);	 	 	 	 	 
	 
     // Fila 2 Cuadro 1
     $pdf->SetX(40);
     $pdf->SetY(90);
     $pdf->Cell(18, 3, "Remitente :", 0);
     $pdf->Cell(65, 3, substr(utf8_decode($remesas[$i]['remitente']),0,34), 0);
     $pdf->Cell(20, 3, "Destinatario :", 0);
     $pdf->Cell(50, 3, substr(utf8_decode($remesas[$i]['destinatario']),0,26), 0);	 	 	 
     $pdf->Cell(17, 3, "Naturaleza :", 0);	 	 	 
     $pdf->Cell(25, 3, substr(utf8_decode($remesas[$i]['naturaleza']),0,15), 0);	
	 
     // Fila 3 Cuadro 1
     $pdf->SetX(40);
     $pdf->SetY(94);
     $pdf->Cell(18, 3, "Direccion :", 0);
     $pdf->Cell(65, 3, substr(utf8_decode($remesas[$i]['direccion_remitente']),0,34), 0);
     $pdf->Cell(20, 3, "Direccion :", 0);
     $pdf->Cell(50, 3, substr(utf8_decode($remesas[$i]['direccion_destinatario']),0,26), 0);	 	 	 
     $pdf->Cell(17, 3, "Medida :", 0);	 	 	 
     $pdf->Cell(25, 3, substr(utf8_decode($remesas[$i]['medida']),0,15), 0);		  	 	 	 	 
 
     // Fila 4 Cuadro 1
     $pdf->SetX(40);
     $pdf->SetY(98);
     $pdf->Cell(18, 3, "Telefono :", 0);
     $pdf->Cell(65, 3, substr(utf8_decode($remesas[$i]['telefono_remitente']),0,34), 0);
     $pdf->Cell(20, 3, "Telefono :", 0);
     $pdf->Cell(50, 3, substr(utf8_decode($remesas[$i]['telefono_destinatario']),0,26), 0);	 	 	 
     $pdf->Cell(17, 3, "Empaque :", 0);	 	 	 
     $pdf->Cell(25, 3, substr(utf8_decode($remesas[$i]['empaque']),0,15), 0);	
	 
     // Cuadro 2
	 
     $pdf->SetX(40);
     $pdf->SetY(101);	 	
	 $pdf->Cell(195,16,null,1,0,'C');
     $pdf->SetX(40);
     $pdf->SetY(102);	 
     $pdf->Cell(25, 3, "Cantidad", 0,0,'C');	 	 	
     $pdf->Cell(80, 3, "Producto", 0,0,'C');	 	 	
     $pdf->Cell(15, 3, "Peso", 0,0,'C');	
	 $pdf->Cell(20, 3, "Peso Vol", 0,0,'C');	
     $pdf->Cell(25, 3, "Doc. Cliente", 0,0,'C');	 
     $pdf->Cell(40, 3, "V/r. Declarado", 0,0,'C');	 	 
	 
     $pdf->SetFont('Arial','B',6);
	 
     $pdf->SetX(40);
     $pdf->SetY(105);	 
     $pdf->Cell(25, 3, $remesas[$i]['detalles_remesa'][0]['cantidad'], 0,0,'C');	 	 	
     $pdf->Cell(80, 3, substr($remesas[$i]['detalles_remesa'][0]['descripcion_producto'],0,60), 0,0,'C');	 	 	
     $pdf->Cell(15, 3, $remesas[$i]['detalles_remesa'][0]['peso'], 0,0,'C');	 
	 $pdf->Cell(20, 3, $remesas[$i]['detalles_remesa'][0]['peso_volumen'], 0,0,'C');	 
     $pdf->Cell(25, 3, $remesas[$i]['detalles_remesa'][0]['guia_cliente'], 0,0,'C');	 
     $pdf->Cell(40, 3, number_format($remesas[$i]['detalles_remesa'][0]['valor'],0,',','.'), 0,0,'C');	  	
	 
     $pdf->SetX(40);
     $pdf->SetY(108);	 
     $pdf->Cell(25, 3, $remesas[$i]['detalles_remesa'][1]['cantidad'], 0,0,'C');	 	 	
     $pdf->Cell(80, 3, substr($remesas[$i]['detalles_remesa'][1]['descripcion_producto'],0,60), 0,0,'C');	 	 	
     $pdf->Cell(15, 3, $remesas[$i]['detalles_remesa'][1]['peso'], 0,0,'C');	
	 $pdf->Cell(20, 3, $remesas[$i]['detalles_remesa'][1]['peso_volumen'], 0,0,'C');	
     $pdf->Cell(25, 3, $remesas[$i]['detalles_remesa'][1]['guia_cliente'], 0,0,'C');	 
     $pdf->Cell(40, 3, number_format($remesas[$i]['detalles_remesa'][1]['valor'],0,',','.'), 0,0,'C');	
	 
	
     // Cuadro 3
     $pdf->SetX(40);
     $pdf->SetY(183);	 	
	 $pdf->Cell(195,15,null,1,0,'C');	
	 
     $pdf->SetX(40);
     $pdf->SetY(182);	 	
	 $pdf->Cell(90,5,"Observaciones :",0,0,'L');
	 $pdf->Cell(75,5,"Recibe a conformidad",0,0,'L');	
     $pdf->Cell(15,5,"V/R Flete:",0,0,'L');
	 $pdf->Cell(10,5,number_format($remesas[$i]['valor_flete'],0,',','.')."",0,0,'L');

     $pdf->SetX(40);
     $pdf->SetY(185);	 	
	 $pdf->Cell(90,5,"",0,0,'L');
	 $pdf->Cell(75,5,"",0,0,'L');
	 $pdf->Cell(15,5,"V/r Seguro:",0,0,'L');
	 $pdf->Cell(10,5,number_format($remesas[$i]['valor_seguro'],0,',','.')."",0,0,'L');

     $pdf->SetX(40);
     $pdf->SetY(188);	 	
	 $pdf->Cell(90,5,"",0,0,'L');
	 $pdf->Cell(75,5,"",0,0,'L');
	 $pdf->Cell(15,5,"Otros:",0,0,'L');
	 $pdf->Cell(10,5,number_format($remesas[$i]['valor_otros'],0,',','.')."",0,0,'L');

     $pdf->SetX(40);
     $pdf->SetY(192);	 	
	 $pdf->Cell(90,5,"",0,0,'L');
	 $pdf->Cell(75,5,"",0,0,'L');
	 $pdf->Cell(15,5,"V/R. TOTAL",0,0,'L');
	 $pdf->Cell(10,5,number_format($remesas[$i]['valor_total'],0,',','.')."",0,0,'L');

     $pdf->SetX(40);
     $pdf->SetY(185);	 	
	 $pdf->Cell(90,5,substr($remesas[$i]['observaciones'],0,80),0,0,'L');	 	 
	 $pdf->Cell(95,5,null,0,0,'L');	 


     $pdf->SetX(40);
     $pdf->SetY(188);	 	
	 $pdf->Cell(90,5,trim(substr($remesas[$i]['observaciones'],79,80)),0,0,'L');	 	 
	 $pdf->Cell(95,5,null,0,0,'L');	 

     $pdf->SetX(40);
     $pdf->SetY(193);	 	
	 $pdf->Cell(90,5,$remesas[$i]['oficina_responsable'],0,0,'C');	 
	 $pdf->Cell(95,5,"Nombre legible, C.C, Firma, Sello y Fecha.",0,0,'L');	 
	 
     $pdf->SetFont('Arial','B',6);		 
     $pdf->SetX(40);
     $pdf->SetY(198);	 	
	 $pdf->Cell(195,3,"DESTINATARIO",0,0,'C');		 
 
	 
	 
	 // fin copia 3	 


	//copia 4

 	 $pdf->Ln(9);	 
     $pdf->SetFont('Arial','B',10); 	 
	 
	 $pdf->Image($remesas[$i]['logo'],10,205,41,11); 
	 $pdf->Image($remesas[$i]['codbar'],165,205,40,7); 	 
	 $pdf->Cell(40,3,null,0,0,'R');		 	 
     $pdf->SetFont('Arial','B',7);	 
	 $pdf->Cell(55,3,"NIT. $nit_empresa",0,0,'R');		 
	 
     $pdf->SetFont('Arial','B',5);	 
	 $pdf->Cell(30,3,'SERVICIO',0,0,'C');	
     $pdf->SetFont('Arial','B',10);		 	 
	 $pdf->Cell(25,3,$remesas[$i]['fecha_remesa'],0,0,'C');		 	 	 	 	 
	 $pdf->Ln(3);	 
	 $pdf->Cell(100,3,$remesas[$i]['pagina_web'],0,0,'R');		 	 	 
     $pdf->SetFont('Arial','B',5);		 	 	 	 
	 $pdf->Cell(15,3,'ENTREGA',0,0,'R');	 	 
	 $pdf->Ln(3);	 
	 $pdf->Cell(116,3,'INMEDIATA',0,0,'R');		 	 
     $pdf->SetFont('Arial','B',8);		 	 	 
	 $pdf->Cell(39,3,null,0,0,'R');		 	 
	 $pdf->Cell(40,3,$remesas[$i]['numero_remesa'],0,0,'C');		 	 	 
	 $pdf->Ln(3.5);	 

     // Cuadro 1	
	 $pdf->Cell(195,16,null,1,0,'C');
	 	 
     // Fila 1 Cuadro 1
     $pdf->SetX(40);
     $pdf->SetY(217);
     $pdf->Cell(18, 3, "Origen :", 0);
     $pdf->Cell(65, 3, substr(utf8_decode($remesas[$i]['origen']),0,34), 0);
     $pdf->Cell(20, 3, "Destino :", 0);
     $pdf->Cell(50, 3, substr(utf8_decode($remesas[$i]['destino']),0,26), 0);	 	 	 
     $pdf->Cell(17, 3, "Codigo :", 0);	 	 	 
     $pdf->Cell(25, 3, substr(utf8_decode($remesas[$i]['codigo']),0,15), 0);	 	 	 	 	 
	 
     // Fila 2 Cuadro 1
     $pdf->SetX(40);
     $pdf->SetY(221);
     $pdf->Cell(18, 3, "Remitente :", 0);
     $pdf->Cell(65, 3, substr(utf8_decode($remesas[$i]['remitente']),0,34), 0);
     $pdf->Cell(20, 3, "Destinatario :", 0);
     $pdf->Cell(50, 3, substr(utf8_decode($remesas[$i]['destinatario']),0,26), 0);	 	 	 
     $pdf->Cell(17, 3, "Naturaleza :", 0);	 	 	 
     $pdf->Cell(25, 3, substr(utf8_decode($remesas[$i]['naturaleza']),0,15), 0);	
	 
     // Fila 3 Cuadro 1
     $pdf->SetX(40);
     $pdf->SetY(225);
     $pdf->Cell(18, 3, "Direccion :", 0);
     $pdf->Cell(65, 3, substr(utf8_decode($remesas[$i]['direccion_remitente']),0,34), 0);
     $pdf->Cell(20, 3, "Direccion :", 0);
     $pdf->Cell(50, 3, substr(utf8_decode($remesas[$i]['direccion_destinatario']),0,26), 0);	 	 	 
     $pdf->Cell(17, 3, "Medida :", 0);	 	 	 
     $pdf->Cell(25, 3, substr(utf8_decode($remesas[$i]['medida']),0,15), 0);		  	 	 	 	 
 
     // Fila 4 Cuadro 1
     $pdf->SetX(40);
     $pdf->SetY(229);
     $pdf->Cell(18, 3, "Telefono :", 0);
     $pdf->Cell(65, 3, substr(utf8_decode($remesas[$i]['telefono_remitente']),0,34), 0);
     $pdf->Cell(20, 3, "Telefono :", 0);
     $pdf->Cell(50, 3, substr(utf8_decode($remesas[$i]['telefono_destinatario']),0,26), 0);	 	 	 
     $pdf->Cell(17, 3, "Empaque :", 0);	 	 	 
     $pdf->Cell(25, 3, substr(utf8_decode($remesas[$i]['empaque']),0,15), 0);	
	 
     // Cuadro 2
	 
     $pdf->SetX(40);
     $pdf->SetY(232);	 	
	 $pdf->Cell(195,16,null,1,0,'C');
     $pdf->SetX(40);
     $pdf->SetY(233);	 
     $pdf->Cell(25, 3, "Cantidad", 0,0,'C');	 	 	
     $pdf->Cell(80, 3, "Producto", 0,0,'C');	 	 	
     $pdf->Cell(15, 3, "Peso", 0,0,'C');	 
	 $pdf->Cell(20, 3, "Peso Vol", 0,0,'C');	 
     $pdf->Cell(25, 3, "Doc. Cliente", 0,0,'C');	 
     $pdf->Cell(40, 3, "V/r. Declarado", 0,0,'C');	 	 
	 
     $pdf->SetFont('Arial','B',6);
	 
     $pdf->SetX(40);
     $pdf->SetY(236);	 
     $pdf->Cell(25, 3, $remesas[$i]['detalles_remesa'][0]['cantidad'], 0,0,'C');	 	 	
     $pdf->Cell(80, 3, substr($remesas[$i]['detalles_remesa'][0]['descripcion_producto'],0,60), 0,0,'C');	 	 	
     $pdf->Cell(15, 3, $remesas[$i]['detalles_remesa'][0]['peso'], 0,0,'C');	 	 	
	 $pdf->Cell(20, 3, $remesas[$i]['detalles_remesa'][0]['peso_volumen'], 0,0,'C');
     $pdf->Cell(25, 3, $remesas[$i]['detalles_remesa'][0]['guia_cliente'], 0,0,'C');	 
     $pdf->Cell(40, 3, number_format($remesas[$i]['detalles_remesa'][0]['valor'],0,',','.'), 0,0,'C');	  	
	 
     $pdf->SetX(40);
     $pdf->SetY(239);	 
     $pdf->Cell(25, 3, $remesas[$i]['detalles_remesa'][1]['cantidad'], 0,0,'C');	 	 	
     $pdf->Cell(80, 3, substr($remesas[$i]['detalles_remesa'][1]['descripcion_producto'],0,60), 0,0,'C');	 	 	
     $pdf->Cell(15, 3, $remesas[$i]['detalles_remesa'][1]['peso'], 0,0,'C');	
	 $pdf->Cell(20, 3, $remesas[$i]['detalles_remesa'][1]['peso_volumen'], 0,0,'C');
     $pdf->Cell(25, 3, $remesas[$i]['detalles_remesa'][1]['guia_cliente'], 0,0,'C');	 
     $pdf->Cell(40, 3, number_format($remesas[$i]['detalles_remesa'][1]['valor'],0,',','.'), 0,0,'C');	
	 
     // Cuadro 3
	 
     $pdf->SetX(40);
     $pdf->SetY(248);	 	
	 $pdf->Cell(195,15,null,1,0,'C');	
	 
	 
     $pdf->SetX(40);
     $pdf->SetY(248);	 	
	 $pdf->Cell(90,5,"Observaciones :",0,0,'L');
	 $pdf->Cell(75,5,"Recibe a conformidad",0,0,'L');
	 $pdf->Cell(15,5,"V/R Flete:",0,0,'L');
	 $pdf->Cell(10,5,number_format($remesas[$i]['valor_flete'],0,',','.')."",0,0,'L');

     $pdf->SetX(40);
     $pdf->SetY(251);	 	
	 $pdf->Cell(90,5,"",0,0,'L');
	 $pdf->Cell(75,5,"",0,0,'L');
	 $pdf->Cell(15,5,"V/r Seguro:",0,0,'L');
	 $pdf->Cell(10,5,number_format($remesas[$i]['valor_seguro'],0,',','.')."",0,0,'L');

     $pdf->SetX(40);
     $pdf->SetY(254);	 	
	 $pdf->Cell(90,5,"",0,0,'L');
	 $pdf->Cell(75,5,"",0,0,'L');
	 $pdf->Cell(15,5,"Otros:",0,0,'L');
	 $pdf->Cell(10,5,number_format($remesas[$i]['valor_otros'],0,',','.')."",0,0,'L');

     $pdf->SetX(40);
     $pdf->SetY(258);	 	
	 $pdf->Cell(90,5,"",0,0,'L');
	 $pdf->Cell(75,5,"",0,0,'L');
	 $pdf->Cell(15,5,"V/R. TOTAL",0,0,'L');
	 $pdf->Cell(10,5,number_format($remesas[$i]['valor_total'],0,',','.')."",0,0,'L');

     $pdf->SetX(40);
     $pdf->SetY(251);	 	
	 $pdf->Cell(90,5,substr($remesas[$i]['observaciones'],0,80),0,0,'L');	 	 
	 $pdf->Cell(95,5,null,0,0,'L');	 

     $pdf->SetX(40);
     $pdf->SetY(254);	 	
	 $pdf->Cell(90,5,trim(substr($remesas[$i]['observaciones'],79,80)),0,0,'L');	 	 
	 $pdf->Cell(95,5,null,0,0,'L');	 

	 	 
     $pdf->SetX(40);
     $pdf->SetY(258);	 	
	 $pdf->Cell(90,5,$remesas[$i]['oficina_responsable'],0,0,'C');	 
	 $pdf->Cell(95,5,"Nombre legible, C.C, Firma, Sello y Fecha.",0,0,'L');	 
	 
 	 	 	 
	 
     $pdf->SetFont('Arial','B',6);		 
     $pdf->SetX(40);
     $pdf->SetY(263);	 	
	 $pdf->Cell(195,3,"ORIGINAL",0,0,'C');		 

	// fin copia 4

	 }	 	 

	
	$pdf->Output(); //Envía como salida del documento
    
  }
	
}

new Imp_Remesa();

?>