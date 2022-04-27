<?php
final class Imp_Documento{
  private $Conex;
  
  public function __construct(){    
       
  }
  public function printOut($Conex,$modulo = 'Contabilidad'){
    	
      require_once("Imp_DocumentoLayoutClass.php");
      require_once("../../../framework/clases/fpdf/fpdf.php");		 
      require_once("Imp_DocumentoModelClass.php");
		
      $Layout = new Imp_DocumentoLayout();
      $Model  = new Imp_DocumentoModel(); $this -> Conex = $Conex;    		
	
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
      $pdf->SetX(40);
      $pdf->SetY(10);	
	  $pdf->Image($encabezado[0]['logo'],8,8,45,11); 
	//   $pdf->Image('../../../framework/media/images/general/supertransporte.png',8,15,35,11);
	  $pdf->Cell(45,5,null,0,0,'R');		 
	  $pdf->Cell(85,5,utf8_decode($encabezado[0]['razon_social_emp']),0,0,'C');	
	  $pdf->Cell(50,5,utf8_decode($encabezado[0]['tipo_documento']),1,0,'C');	
      $pdf->SetFont('Arial','B',10);	 
	  $pdf->Cell(20,5,$encabezado[0]['consecutivo'],1,0,'C');		
	  $pdf->Ln(4);	
      $pdf->SetFont('Arial','B',10);	 	 	 	  
	  $pdf->Cell(45,5,null,0,0,'R');		 
	  $pdf->Cell(85,5,utf8_decode($encabezado[0]['nom_oficina']),0,0,'C');
	 
	  $pdf->Ln(4);	
      $pdf->SetFont('Arial','B',10);	 	 	 	  
	  $pdf->Cell(45,5,null,0,0,'R');		 	 	 
	  $pdf->Cell(85,5,$encabezado[0]['tipo_identificacion_emp'].':'.$encabezado[0]['numero_identificacion_emp'],0,0,'C');
	 
	  $pdf->Ln(10);	
      $pdf->SetFont('Arial','B',10);	 	 	 	  
	  $pdf->Cell(35,5,'Fecha :',1,0,'L');	
	  $pdf->Cell(80,5,$encabezado[0]['fecha'],1,0,'L');	
	  $pdf->Cell(35,5,'Ciudad :',1,0,'L');	
	  $pdf->Cell(50,5,$encabezado[0]['ciudad_ofi'],1,0,'L');		 	 	 
	 
	  $pdf->Ln(5);	
      $pdf->SetFont('Arial','B',10);	 	 	 	  
	  $pdf->Cell(35,5,$encabezado[0]['texto_tercero'],1,0,'L');	
	  $pdf->Cell(80,5,utf8_decode($encabezado[0]['razon_social'].' '.$encabezado[0]['primer_nombre'].' '.$encabezado[0]['segundo_nombre'].' '.$encabezado[0]['primer_apellido'].' '.$encabezado[0]['segundo_apellido']),1,0,'L');	
	  $pdf->Cell(35,5,$encabezado[0]['tipo_identificacion_emp'],1,0,'L');	
	  $pdf->Cell(50,5,$encabezado[0]['numero_identificacion'],1,0,'L');	
	 
	  $pdf->Ln(5);	
      $pdf->SetFont('Arial','B',10);	 	 	 	  
	  $pdf->Cell(35,5,'Concepto :',1,0,'L');	
	  $pdf->Cell(165,5,substr($encabezado[0]['concepto'],0,80),1,0,'L');	
	  $pdf->Ln(5);	
      $pdf->SetFont('Arial','B',10);	 	 	 	  
	  $pdf->Cell(35,5,'Forma Pago :',1,0,'L');	
	  $pdf->Cell(80,5,$encabezado[0]['formapago'],1,0,'L');	
	  $pdf->Cell(35,5,substr($encabezado[0]['texto_soporte'],0,15),1,0,'L');	
	  $pdf->Cell(50,5,$encabezado[0]['numero_soporte'],1,0,'L');	 
	 
	  $pdf->Ln(10);	
      $pdf->SetFont('Arial','B',10);	 	 	 	  
	  $pdf->Cell(18,5,'CODIGO',1,0,'C');	
	  $pdf->Cell(18,5,'TERCERO',1,0,'C');	
	  $pdf->Cell(48,5,'NOMBRE',1,0,'C');	
	  $pdf->Cell(8,5,'CC',1,0,'C');	
	  $pdf->Cell(58,5,'DETALLE',1,0,'C');	
	  $pdf->Cell(25,5,'DEBITO',1,0,'C');	
	  $pdf->Cell(25,5,'CREDITO',1,0,'C');	
	 	
	  for($i=0; $i < count($imputaciones); $i++){
	   $pdf->Ln(5);	
       $pdf->SetFont('Arial','B',9);	 	 	 	  
	   $pdf->Cell(18,5,$imputaciones[$i]['puc_cod'],1,0,'C');	
//	   $pdf->Cell(40,5,$imputaciones[$i]['numero_identificacion'],1,0,'C');	
	   $pdf->Cell(18,5,$imputaciones[$i]['identificacion_tercero'],1,0,'C');
	   $pdf->Cell(48,5,substr($imputaciones[$i]['nombre'],0,20),1,0,'L');		
//	   $pdf->Cell(15,5,$imputaciones[$i]['codigo_centro_costo'],1,0,'C');		   
	   $pdf->Cell(8,5,$imputaciones[$i]['codigo_cento'],1,0,'C');		   
	   $pdf->Cell(58,5,substr($imputaciones[$i]['descripcion'],0,28),1,0,'L');	
	   $pdf->Cell(25,5,number_format($imputaciones[$i]['debito'],2,',','.'),1,0,'R');	
	   $pdf->Cell(25,5,number_format($imputaciones[$i]['credito'],2,',','.'),1,0,'R');	   
	 
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
	   
	   /* Nueva linea para mostrar modulo de procedencia */

	   $pdf->Ln(8);	
      $pdf->SetFont('Arial','I',8);	 	 	 	  
  	  $pdf->Cell(200,8,'Modulo de procedencia : '.$modulo,'',0,'C');	
  	 
	  
	  $pdf->Output();	  
	  
	  
  }
  
  
}
new Imp_Documento($Conex);
?>