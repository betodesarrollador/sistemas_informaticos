<?php

final class Imp_Documento{

  private $Conex;
  
  public function __construct(){    
       
  }

  public function printOut($Conex){  
    	
      require_once("Imp_DocumentoLayoutClass.php");
      require_once("../../../framework/clases/fpdf/fpdf.php");		 
      require_once("Imp_DocumentoModelClass.php");
		
      $Layout = new Imp_DocumentoLayout();
      $Model  = new Imp_DocumentoModel();		
	
	  $encabezado_registro_id = $_REQUEST['encabezado_registro_id'];
	  
      $encabezado   = $Model -> getEncabezado($encabezado_registro_id,$this -> Conex);	  
      $imputaciones = $Model -> getimputaciones($encabezado_registro_id,$this -> Conex);  
      $total        = $Model -> getTotal($encabezado_registro_id,$this -> Conex);  
      $valor_letras = $Model -> getTotales($encabezado_registro_id,$this -> Conex);

      $pdf=new FPDF();
      $pdf->AddPage('P','Letter','mm');
      $pdf->SetFont('Arial','B',8); 

      $pdf->SetMargins(7, 5 , 5);
      $pdf->SetAutoPageBreak(true,1); 
	  
	  	   if(trim($encabezado[0]['formapago'])=="CHEQUE"){
		  			
		  $pdf->Ln(4);	
		  $pdf->SetFont('Arial','B',11);	 	 	 	  
		  $pdf->Cell(15,6,null,0,0,'R');		 
		  $pdf->Cell(85,6,null,0,0,'L');  
		  $pdf->Cell(15,6,$encabezado[0]['anio'],0,0,'L');
		  if ($encabezado[0]['mes']<10) {
		  		$pdf->Cell(10,6,'0'.$encabezado[0]['mes'],0,0,'L');
		  }else{
		  		$pdf->Cell(10,6,$encabezado[0]['mes'],0,0,'L');
		  }
		  if ($encabezado[0]['dia']<10) {
		  		$pdf->Cell(10,6,'0'.$encabezado[0]['dia'],0,0,'L');
		  }else{
		  		$pdf->Cell(10,6,$encabezado[0]['dia'],0,0,'L');
		  }
		  $pdf->Cell(30,6,number_format($total[0]['total_debito'],2,',','.'),0,0,'R');

		  
		  $pdf->Ln(5);	
		  $pdf->SetFont('Arial','B',11);	 	 	 	  
		  $pdf->Cell(40,5,null,0,0,'R');		 
		  $pdf->Cell(70,10,utf8_decode($encabezado[0]['primer_nombre'].' '.$encabezado[0]['segundo_nombre'].' '.$encabezado[0]['primer_apellido'].' '.$encabezado[0]['segundo_apellido'].' '.$encabezado[0]['razon_social']),0,0,'L');  
		  
		  if(substr($Layout -> num2letras($valor_letras[0]['total']),65,65)!='')  $valor_letras1=''; else $valor_letras1=' PESOS M/CTE';
		  $pdf->Ln(10);	
		  $pdf->SetFont('Arial','B',11);	 	 	 
		  $pdf->Cell(25,5,null,0,0,'R');		 
		  $pdf->Cell(200,10,''.strtoupper(substr($Layout -> num2letras($valor_letras[0]['total']),0,65)).$valor_letras1,0,0,'L');
  		  $pdf->Ln(7);	
		  if(substr($Layout -> num2letras($valor_letras[0]['total']),65,60)!=''){
			  $pdf->SetFont('Arial','B',11);	 	 	 
			  $pdf->Cell(15,5,null,0,0,'R');
			  $pdf->Cell(200,10,''.strtoupper(substr($Layout -> num2letras($valor_letras[0]['total']),65,60)).' PESOS M/CTE',0,0,'L');
		  }

		  $pdf->SetX(50);
		  $pdf->SetY(85);	
		  $pdf->Image($encabezado[0]['logo'],14,83,40,15);
		  
      $pdf->SetFont('Arial','B',9);	         
	  $pdf->Cell(47,5,null,0,0,'R');		 
	  $pdf->Cell(85,5,utf8_decode(substr($encabezado[0]['razon_social_emp'],0,25)),0,0,'L');

	  $pdf->Ln(4);	
      $pdf->SetFont('Arial','B',9);	 	 	 	  
	  $pdf->Cell(47,5,null,0,0,'R');
	  $pdf->Cell(85,5,utf8_decode(substr($encabezado[0]['razon_social_emp'],25,50)),0,0,'L');
	  
	 
	  $pdf->Ln(4);
      $pdf->SetFont('Arial','B',9);	 	 	 	  
	  $pdf->Cell(47,5,null,0,0,'R');		 	 	 
	  $pdf->Cell(71,5,utf8_decode($encabezado[0]['nom_oficina'].' - '.$encabezado[0]['tipo_identificacion_emp'].':'.$encabezado[0]['numero_identificacion_emp']),0,0,'L');
	  $pdf->SetFont('Arial','B',8);
	  $pdf->Cell(50,5,utf8_decode($encabezado[0]['tipo_documento']),1,0,'C');
	  $pdf->SetFont('Arial','B',10);	 
	  $pdf->Cell(20,5,$encabezado[0]['consecutivo'],1,0,'C');
	  
	 
	  $pdf->Ln(10);
	  $pdf->SetY(103);
	  $pdf->SetX(14);
      $pdf->SetFont('Arial','B',10);	 	 	 	  
	  $pdf->Cell(30,5,'Fecha :',1,0,'L');	
	  $pdf->Cell(55,5,$encabezado[0]['fecha'],1,0,'L');	
	  $pdf->Cell(39,5,'Ciudad :',1,0,'L');	
	  $pdf->Cell(57,5,$encabezado[0]['ciudad_ofi'],1,0,'L');		 	 	 
	 
	  $pdf->Ln(5);	
	  $pdf->SetY(108);
	  $pdf->SetX(14);
      $pdf->SetFont('Arial','B',10);	 	 	 	  
	  $pdf->Cell(30,5,utf8_decode($encabezado[0]['texto_tercero']),1,0,'L');	
	  $pdf->Cell(85,5,utf8_decode($encabezado[0]['primer_nombre'].' '.$encabezado[0]['segundo_nombre'].' '.$encabezado[0]['primer_apellido'].' '.$encabezado[0]['segundo_apellido'].' '.$encabezado[0]['razon_social']),1,0,'L');	
	  $pdf->Cell(33,5,$encabezado[0]['tipo_identificacion_emp'],1,0,'L');	
	  $pdf->Cell(33,5,$encabezado[0]['numero_identificacion'],1,0,'L');	
	 
	  $pdf->Ln(5);	
	  $pdf->SetY(113);
	  $pdf->SetX(14);
      $pdf->SetFont('Arial','B',10);	 	 	 	  
	  $pdf->Cell(30,5,'Concepto :',1,0,'L');	
	  $pdf->Cell(151,5,substr(utf8_decode($encabezado[0]['concepto']),0,75),1,0,'L');	

	  if(strlen($encabezado[0]['concepto'])>75){
		  $pdf->Ln(5);	
		  $pdf->SetFont('Arial','B',10);	 	 	 	  
		  $pdf->Cell(30,5,'',1,0,'L');	
		  $pdf->Cell(151,5,substr(utf8_decode($encabezado[0]['concepto']),75,75),1,0,'L');	
	  }
	  $pdf->Ln(5);
  	  $pdf->SetY(118);
	  $pdf->SetX(14);
      $pdf->SetFont('Arial','B',10);	 	 	 	  
	  $pdf->Cell(30,5,'Forma Pago :',1,0,'L');	
	  $pdf->Cell(72,5,$encabezado[0]['formapago'],1,0,'L');	
	  $pdf->Cell(39,5,$encabezado[0]['texto_soporte'],1,0,'L');	
	  $pdf->Cell(40,5,$encabezado[0]['numero_soporte'],1,0,'L');	 
	 
	  $pdf->Ln(10);	
   	  $pdf->SetY(128);
	  $pdf->SetX(14);
      $pdf->SetFont('Arial','B',10);	 	 	 	  
	  $pdf->Cell(20,5,'CODIGO',1,0,'C');	
	  $pdf->Cell(26,5,'TERCERO',1,0,'C');	
	  $pdf->Cell(10,5,'CC',1,0,'C');	
	  $pdf->Cell(69,5,'DETALLE',1,0,'C');	
	  $pdf->Cell(28,5,'DEBITO',1,0,'C');	
	  $pdf->Cell(28,5,'CREDITO',1,0,'C');	
	 	
	  for($i=0; $i < count($imputaciones); $i++){
		if(strlen($imputaciones[$i]['descripcion'])>60){  

		   $pdf->Ln(15);
		   $pdf->SetX(14);
		   $pdf->SetFont('Arial','B',10);	 	 	 	  
		   $pdf->Cell(20,15,$imputaciones[$i]['puc_cod'],1,0,'C');	
			//$pdf->Cell(40,15,$imputaciones[$i]['numero_identificacion'],1,0,'C');	
		   $pdf->Cell(26,15,$imputaciones[$i]['identificacion_tercero'].'ss',1,0,'C');	
			//$pdf->Cell(15,15,$imputaciones[$i]['codigo_centro_costo'],1,0,'C');		   
		   $pdf->Cell(10,15,$imputaciones[$i]['codigo_cento'],1,0,'C');		   
		   $pdf->Cell(69,15,substr($imputaciones[$i]['descripcion'],0,30).'\n'.substr($imputaciones[$i]['descripcion'],30,30).'\n'.substr($imputaciones[$i]['descripcion'],60,30),1,0,'L');	
		   $pdf->Cell(28,15,number_format($imputaciones[$i]['debito'],2,',','.'),1,0,'R');	
		   $pdf->Cell(28,15,number_format($imputaciones[$i]['credito'],2,',','.'),1,0,'R');	 
		   
		}elseif(strlen($imputaciones[$i]['descripcion'])>30  && strlen($imputaciones[$i]['descripcion'])<61){

		   $pdf->Ln(10);
		   $pdf->SetX(14);
		   $pdf->SetFont('Arial','B',10);	 	 	 	  
		   $pdf->Cell(20,10,$imputaciones[$i]['puc_cod'],1,0,'C');	
			//$pdf->Cell(40,10,$imputaciones[$i]['numero_identificacion'],1,0,'C');	
		   $pdf->Cell(26,10,$imputaciones[$i]['identificacion_tercero'].'ss',1,0,'C');	
			//$pdf->Cell(15,10,$imputaciones[$i]['codigo_centro_costo'],1,0,'C');		   
		   $pdf->Cell(10,10,$imputaciones[$i]['codigo_cento'],1,0,'C');		   
		   $pdf->Cell(69,10,substr($imputaciones[$i]['descripcion'],0,30).'\n'.substr($imputaciones[$i]['descripcion'],30,30),1,0,'L');	
		   $pdf->Cell(28,10,number_format($imputaciones[$i]['debito'],2,',','.'),1,0,'R');	
		   $pdf->Cell(28,10,number_format($imputaciones[$i]['credito'],2,',','.'),1,0,'R');	   


		}elseif(strlen($imputaciones[$i]['descripcion'])<31){
		   $pdf->Ln(5);
		   $pdf->SetX(14);
		   $pdf->SetFont('Arial','B',10);	 	 	 	  
		   $pdf->Cell(20,5,$imputaciones[$i]['puc_cod'],1,0,'C');	
			//$pdf->Cell(40,5,$imputaciones[$i]['numero_identificacion'],1,0,'C');	
		   $pdf->Cell(26,5,$imputaciones[$i]['identificacion_tercero'].'ss',1,0,'C');	
			//$pdf->Cell(15,5,$imputaciones[$i]['codigo_centro_costo'],1,0,'C');		   
		   $pdf->Cell(10,5,$imputaciones[$i]['codigo_cento'],1,0,'C');		   
		   $pdf->Cell(69,5,substr($imputaciones[$i]['descripcion'],0,30),1,0,'L');	
		   $pdf->Cell(28,5,number_format($imputaciones[$i]['debito'],2,',','.'),1,0,'R');	
		   $pdf->Cell(28,5,number_format($imputaciones[$i]['credito'],2,',','.'),1,0,'R');	   
			
		}
	  }
	 
	  $pdf->Ln(10);	
	  $pdf->SetX(14);
      $pdf->SetFont('Arial','B',10);	 	 	 	  
	  $pdf->Cell(125,5,'SUMAS IGUALES',1,0,'C');	
	  $pdf->Cell(28,5,number_format($total[0]['total_debito'],2,',','.'),1,0,'R');	
	  $pdf->Cell(28,5,number_format($total[0]['total_credito'],2,',','.'),1,0,'R');			   	  	  	  
	  
		  
	  }else{
		  $pdf->SetX(40);
		  $pdf->SetY(10);	
	      $pdf->Image($encabezado[0]['logo'],8,8,40,15);  
		  
		         
	  $pdf->Cell(45,5,null,0,0,'R');		 
	  $pdf->Cell(85,5,utf8_decode(substr($encabezado[0]['razon_social_emp'],0,25)),0,0,'C');
	  $pdf->SetFont('Arial','B',8);
	  $pdf->Cell(50,5,utf8_decode($encabezado[0]['tipo_documento']),1,0,'C');	
      $pdf->SetFont('Arial','B',10);	 
	  $pdf->Cell(20,5,$encabezado[0]['consecutivo'],1,0,'C');		

	  $pdf->Ln(4);	
      $pdf->SetFont('Arial','B',10);	 	 	 	  
	  $pdf->Cell(45,5,null,0,0,'R');
	  $pdf->Cell(85,5,utf8_decode(substr($encabezado[0]['razon_social_emp'],25,50)),0,0,'C');
	  
	 
	  $pdf->Ln(4);	
      $pdf->SetFont('Arial','B',10);	 	 	 	  
	  $pdf->Cell(45,5,null,0,0,'R');		 	 	 
	  $pdf->Cell(85,5,utf8_decode($encabezado[0]['nom_oficina'].' - '.$encabezado[0]['tipo_identificacion_emp'].':'.$encabezado[0]['numero_identificacion_emp']),0,0,'C'); 
	  
	 
	  $pdf->Ln(10);	
      $pdf->SetFont('Arial','B',10);	 	 	 	  
	  $pdf->Cell(35,5,'Fecha :',1,0,'L');	
	  $pdf->Cell(80,5,$encabezado[0]['fecha'],1,0,'L');	
	  $pdf->Cell(39,5,'Ciudad :',1,0,'L');	
	  $pdf->Cell(46,5,$encabezado[0]['ciudad_ofi'],1,0,'L');		 	 	 
	 
	  $pdf->Ln(5);	
      $pdf->SetFont('Arial','B',10);	 	 	 	  
	  $pdf->Cell(35,5,utf8_decode($encabezado[0]['texto_tercero']),1,0,'L');	
	  $pdf->Cell(80,5,utf8_decode($encabezado[0]['primer_nombre'].' '.$encabezado[0]['segundo_nombre'].' '.$encabezado[0]['primer_apellido'].' '.$encabezado[0]['segundo_apellido'].' '.$encabezado[0]['razon_social']),1,0,'L');	
	  $pdf->Cell(39,5,$encabezado[0]['tipo_identificacion_emp'],1,0,'L');	
	  $pdf->Cell(46,5,$encabezado[0]['numero_identificacion'],1,0,'L');	
	 
	  $pdf->Ln(5);	
      $pdf->SetFont('Arial','B',10);	 	 	 	  
	  $pdf->Cell(35,5,'Concepto :',1,0,'L');	
	  $pdf->Cell(165,5,substr(utf8_decode($encabezado[0]['concepto']),0,75),1,0,'L');	

	  if(strlen($encabezado[0]['concepto'])>75){
		  $pdf->Ln(5);	
		  $pdf->SetFont('Arial','B',10);	 	 	 	  
		  $pdf->Cell(35,5,'',1,0,'L');	
		  $pdf->Cell(165,5,substr(utf8_decode($encabezado[0]['concepto']),75,75),1,0,'L');	
	  }
	  $pdf->Ln(5);	
      $pdf->SetFont('Arial','B',10);	 	 	 	  
	  $pdf->Cell(35,5,'Forma Pago :',1,0,'L');	
	  $pdf->Cell(80,5,$encabezado[0]['formapago'],1,0,'L');	
	  $pdf->Cell(39,5,$encabezado[0]['texto_soporte'],1,0,'L');	
	  $pdf->Cell(46,5,$encabezado[0]['numero_soporte'],1,0,'L');	 
	 
	  $pdf->Ln(10);	
      $pdf->SetFont('Arial','B',10);	 	 	 	  
	  $pdf->Cell(20,5,'CODIGO',1,0,'C');	
	  $pdf->Cell(40,5,'TERCERO',1,0,'C');	
	  $pdf->Cell(15,5,'CC',1,0,'C');	
	  $pdf->Cell(69,5,'DETALLE',1,0,'C');	
	  $pdf->Cell(28,5,'DEBITO',1,0,'C');	
	  $pdf->Cell(28,5,'CREDITO',1,0,'C');	
	 	
	  for($i=0; $i < count($imputaciones); $i++){

		if(strlen($imputaciones[$i]['descripcion'])>60){  

		   $pdf->Ln(5);

		   //$pdf->SetX(14);
		   $pdf->SetFont('Arial','B',10);	 	 	 	  
		   $pdf->Cell(20,15,'',1,0,'C');	
			//$pdf->Cell(40,15,'',1,0,'C');	
		   $pdf->Cell(40,15,'',1,0,'C');	
			//$pdf->Cell(15,15,'',1,0,'C');		   
		   $pdf->Cell(15,15,'',1,0,'C');		   
		   $pdf->Cell(69,15,'',1,0,'L');	
		   $pdf->Cell(28,15,'',1,0,'R');	
		   $pdf->Cell(28,15,'',1,0,'R');	 
		   
		   $pdf->Ln(0);
		   //$pdf->SetX(14);
		   $pdf->SetFont('Arial','B',10);	 	 	 	  
		   $pdf->Cell(20,5,$imputaciones[$i]['puc_cod'],0,0,'C');	
			//$pdf->Cell(40,5,$imputaciones[$i]['numero_identificacion'],0,0,'C');	
		   $pdf->Cell(40,5,$imputaciones[$i]['identificacion_tercero'],0,0,'C');	
			//$pdf->Cell(15,5,$imputaciones[$i]['codigo_centro_costo'],0,0,'C');		   
		   $pdf->Cell(15,5,$imputaciones[$i]['codigo_cento'],0,0,'C');		   
		   $pdf->Cell(69,5,substr($imputaciones[$i]['descripcion'],0,30),0,0,'L');	
		   $pdf->Cell(28,5,number_format($imputaciones[$i]['debito'],2,',','.'),0,0,'R');	
		   $pdf->Cell(28,5,number_format($imputaciones[$i]['credito'],2,',','.'),0,0,'R');	 

		   $pdf->Ln(5);
		   //$pdf->SetX(14);
		   $pdf->SetFont('Arial','B',10);	 	 	 	  
		   $pdf->Cell(20,5,'',0,0,'C');	
			//$pdf->Cell(40,5,$imputaciones[$i]['numero_identificacion'],0,0,'C');	
		   $pdf->Cell(40,5,'',0,0,'C');	
			//$pdf->Cell(15,5,$imputaciones[$i]['codigo_centro_costo'],0,0,'C');		   
		   $pdf->Cell(15,5,'',0,0,'C');		   
		   $pdf->Cell(69,5,substr($imputaciones[$i]['descripcion'],30,30),0,0,'L');	
		   $pdf->Cell(28,5,'',0,0,'R');	
		   $pdf->Cell(28,5,'',0,0,'R');	 

		   $pdf->Ln(5);
		   //$pdf->SetX(14);
		   $pdf->SetFont('Arial','B',10);	 	 	 	  
		   $pdf->Cell(20,5,'',0,0,'C');	
			//$pdf->Cell(40,5,$imputaciones[$i]['numero_identificacion'],0,0,'C');	
		   $pdf->Cell(40,5,'',0,0,'C');	
			//$pdf->Cell(15,5,$imputaciones[$i]['codigo_centro_costo'],0,0,'C');		   
		   $pdf->Cell(15,5,'',0,0,'C');		   
		   $pdf->Cell(69,5,substr($imputaciones[$i]['descripcion'],60,30),0,0,'L');	
		   $pdf->Cell(28,5,'',0,0,'R');	
		   $pdf->Cell(28,5,'',0,0,'R');	 

		}elseif(strlen($imputaciones[$i]['descripcion'])>30  && strlen($imputaciones[$i]['descripcion'])<61){

		   $pdf->Ln(5);

		   //$pdf->SetX(14);
		   $pdf->SetFont('Arial','B',10);	 	 	 	  
		   $pdf->Cell(20,10,'',1,0,'C');	
			//$pdf->Cell(40,10,'',1,0,'C');	
		   $pdf->Cell(40,10,'',1,0,'C');	
			//$pdf->Cell(15,10,'',1,0,'C');		   
		   $pdf->Cell(15,10,'',1,0,'C');		   
		   $pdf->Cell(69,10,'',1,0,'L');	
		   $pdf->Cell(28,10,'',1,0,'R');	
		   $pdf->Cell(28,10,'',1,0,'R');	 

		   $pdf->Ln(0);
		   //$pdf->SetX(14);
		   $pdf->SetFont('Arial','B',10);	 	 	 	  
		   $pdf->Cell(20,5,$imputaciones[$i]['puc_cod'],0,0,'C');	
			//$pdf->Cell(40,5,$imputaciones[$i]['numero_identificacion'],0,0,'C');	
		   $pdf->Cell(40,5,$imputaciones[$i]['identificacion_tercero'],0,0,'C');	
			//$pdf->Cell(15,5,$imputaciones[$i]['codigo_centro_costo'],0,0,'C');		   
		   $pdf->Cell(15,5,$imputaciones[$i]['codigo_cento'],0,0,'C');		   
		   $pdf->Cell(69,5,substr($imputaciones[$i]['descripcion'],0,30),0,0,'L');	
		   $pdf->Cell(28,5,number_format($imputaciones[$i]['debito'],2,',','.'),0,0,'R');	
		   $pdf->Cell(28,5,number_format($imputaciones[$i]['credito'],2,',','.'),0,0,'R');	 

		   $pdf->Ln(5);
		   //$pdf->SetX(14);
		   $pdf->SetFont('Arial','B',10);	 	 	 	  
		   $pdf->Cell(20,5,'',0,0,'C');	
			//$pdf->Cell(40,5,$imputaciones[$i]['numero_identificacion'],0,0,'C');	
		   $pdf->Cell(40,5,'',0,0,'C');	
			//$pdf->Cell(15,5,$imputaciones[$i]['codigo_centro_costo'],0,0,'C');		   
		   $pdf->Cell(15,5,'',0,0,'C');		   
		   $pdf->Cell(69,5,substr($imputaciones[$i]['descripcion'],30,30),0,0,'L');	
		   $pdf->Cell(28,5,'',0,0,'R');	
		   $pdf->Cell(28,5,'',0,0,'R');	 


		}elseif(strlen($imputaciones[$i]['descripcion'])<31){
		   $pdf->Ln(5);
		   //$pdf->SetX(14);
		   $pdf->SetFont('Arial','B',10);	 	 	 	  
		   $pdf->Cell(20,5,$imputaciones[$i]['puc_cod'],1,0,'C');	
			//$pdf->Cell(40,5,$imputaciones[$i]['numero_identificacion'],1,0,'C');	
		   $pdf->Cell(40,5,$imputaciones[$i]['identificacion_tercero'],1,0,'C');	
			//$pdf->Cell(15,5,$imputaciones[$i]['codigo_centro_costo'],1,0,'C');		   
		   $pdf->Cell(15,5,$imputaciones[$i]['codigo_cento'],1,0,'C');		   
		   $pdf->Cell(69,5,substr($imputaciones[$i]['descripcion'],0,30),1,0,'L');	
		   $pdf->Cell(28,5,number_format($imputaciones[$i]['debito'],2,',','.'),1,0,'R');	
		   $pdf->Cell(28,5,number_format($imputaciones[$i]['credito'],2,',','.'),1,0,'R');	   
			
		} 
/*
	   $pdf->Ln(5);	
       $pdf->SetFont('Arial','B',10);	 	 	 	  
	   $pdf->Cell(20,5,$imputaciones[$i]['puc_cod'],1,0,'C');	
//	   $pdf->Cell(40,5,$imputaciones[$i]['numero_identificacion'],1,0,'C');	
	   $pdf->Cell(40,5,$imputaciones[$i]['identificacion_tercero'],1,0,'C');	
//	   $pdf->Cell(15,5,$imputaciones[$i]['codigo_centro_costo'],1,0,'C');		   
	   $pdf->Cell(15,5,$imputaciones[$i]['codigo_cento'],1,0,'C');	
	   $pdf->Cell(69,5,substr($imputaciones[$i]['descripcion'],0,30),1,0,'L');	   
	   $pdf->Cell(28,5,number_format($imputaciones[$i]['debito'],2,',','.'),1,0,'R');	
	   $pdf->Cell(28,5,number_format($imputaciones[$i]['credito'],2,',','.'),1,0,'R');	   */
	 
	  }
	 
	  $pdf->Ln(10);	
      $pdf->SetFont('Arial','B',10);	 	 	 	  
	  $pdf->Cell(144,5,'SUMAS IGUALES',1,0,'C');	
	  $pdf->Cell(28,5,number_format($total[0]['total_debito'],2,',','.'),1,0,'R');	
	  $pdf->Cell(28,5,number_format($total[0]['total_credito'],2,',','.'),1,0,'R');	
	  
	  $pdf->Ln(10);	
      $pdf->SetFont('Arial','B',10);	 	 	 	  
	  $pdf->Cell(200,10,'Valor en Letras : '.$Layout -> num2letras($valor_letras[0]['total']).' Pesos M/CTE',1,0,'C');	
	  
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
	  
		  
	  }	   	  	  	  
	  
	  $pdf->Output();	  
	  
	  
  }
  
  
}
new Imp_Documento();

?>