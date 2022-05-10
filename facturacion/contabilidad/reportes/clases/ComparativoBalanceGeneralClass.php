<?php
require_once("../../../framework/clases/ControlerClass.php");
final class ComparativoBalanceGeneral extends Controler{
  public function __construct(){
	parent::__construct(3);
  }
  public function Main(){
	     
    $this -> noCache();
    
	require_once("ComparativoBalanceGeneralLayoutClass.php");
	require_once("ComparativoBalanceGeneralModelClass.php");
	require_once("../../../framework/clases/UtilidadesContablesModelClass.php");		
	
	$Layout              = new ComparativoBalancegeneralLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model               = new ComparativoBalancegeneralModel();
    $utilidadesContables = new UtilidadesContablesModel(); 	
    
    $Model  -> SetUsuarioId		($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU
	$Layout -> setOficinas($utilidadesContables -> getOficinas($this -> getEmpresaId(),$this -> getConex()));
	$Layout -> setCentrosCosto($utilidadesContables -> getCentrosCosto($this -> getEmpresaId(),$this -> getConex()));
	$Layout -> setNivelesPuc($utilidadesContables -> getNivelesPuc($this -> getConex()));
			
	$Layout -> RenderMain();	  
	  
  }
  
  protected function getEmpresas(){
  
	require_once("ComparativoBalanceGeneralLayoutClass.php");
	require_once("ComparativoBalanceGeneralModelClass.php");
	
	$Layout  = new ComparativoBalancegeneralLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model   = new ComparativoBalancegeneralModel();	
	$reporte = trim($_REQUEST['reporte']);
	
	if($reporte == 'E'){
  	  $field[empresa_id] = array(
		  name	=>'empresa_id',
		  id		=>'empresa_id',
		  type	=>'select',
		  required=>'yes',
		  options	=> $Model -> getEmpresas($this -> getUsuarioId(),$this -> getConex()),
		  tabindex=>'2',
	      datatype=>array(
			 type	=>'integer',
			  length	=>'9')
	  );
	  
	}else if($reporte == 'O'){
	
	  $field[empresa_id] = array(
		  name	=>'empresa_id',
		  id		=>'empresa_id',
		  type	=>'select',
		  required=>'yes',
		  options	=> $Model -> getEmpresas($this -> getUsuarioId(),$this -> getConex()),
		  tabindex=>'2',
	      datatype=>array(
			  type	=>'integer',
			  length	=>'9'),
          setoptionslist=>array(childId=>'oficina_id')
	  );	
	  
	 }else if($reporte == 'C'){
	 
	     $field[empresa_id] = array(
		   name	=>'empresa_id',
		   id		=>'empresa_id',
		   type	=>'select',
		   required=>'yes',
		   options	=> $Model -> getEmpresas($this -> getUsuarioId(),$this -> getConex()),
		   tabindex=>'2',
	       datatype=>array(
			  type	=>'integer',
			  length	=>'9'),
          setoptionslist=>array(childId=>'centro_de_costo')
	     );	 
	 
	   }
	
	print $Layout -> getObjectHtml($field[empresa_id]);
  
  }
  
   
  protected function onchangeSetOptionList(){
  
   
	require_once("ComparativoBalanceGeneralModelClass.php");
    require_once("../../../framework/clases/ListaDependiente.php");
		
    $Model     = new ComparativoBalancegeneralModel();  
    $listChild = $_REQUEST['listChild'];
	
	if($listChild == 'oficina_id'){
  	  $list = new ListaDependiente($this -> getConex(),'oficina_id',array(table=>'oficina',value=>'oficina_id',text=>
                                   'codigo_centro,nombre',concat=>'-',order=>'codigo_centro,nombre'),$this -> Campos,
								   $Model -> getConditionOficina($this -> getUsuarioId()));		
    }else{
  	     $list = new ListaDependiente($this -> getConex(),'centro_de_costo_id',array(table=>'centro_de_costo',value=>'centro_de_costo_id',text=>
                                   'codigo,nombre',concat=>'-',order=>'codigo,nombre'),$this -> Campos,
								   $Model -> getConditionCentroCosto($this -> getUsuarioId()));			
	  }
	
	$list -> getList();
	  
  }   
  
  protected function getBalanceGeneralNivel1($hasta1,$desde1,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,$utilidadesContables,$Conex){
  
	  
      $result1 = $Model->getSaldoCuentasBalance($hasta1,$desde1,$centro_de_costo_id,$opciones_centros,$empresa_id,$utilidadesContables,$Conex);	 	 	       
	 
	  $saldo_utilidad_perdida=$Model->getSaldoUtilidadPerdidaNivel1($hasta1,$desde1,$centro_de_costo_id,$opciones_centros,$empresa_id,$utilidadesContables,$Conex);  	  
	 
	   $saldos = array(
	               array(codigo => '1', cuenta => 'ACTIVO',     tipo => 'CLASE',saldo => '0'),
				   array(codigo => '2', cuenta => 'PASIVO',     tipo => 'CLASE',saldo => '0'),
				   array(codigo => '3', cuenta => 'PATRIMONIO', tipo => 'CLASE',saldo => '0')
				 );	  
       for($i = 0; $i < count($saldos); $i++){
	 	
		$codigoSaldo =  $saldos[$i]['codigo'];
				 
   	    for($j = 0; $j < count($result1); $j++){
	   
	      $cuentaSaldoCalculado = $result1[$j]['cuenta'];
		  		  
		  if($cuentaSaldoCalculado == $codigoSaldo){
	    	 $saldos[$i]['saldo']  = $result1[$j]['saldo'];
			 break;
		  }
	   
	     }
	   
	   }
	 
	   $saldoCuenta3 = 0;
	  	  
       for($i = 0; $i < count($saldos); $i++){
	 
	    $cuentaAnalizar = $saldos[$i]['codigo'];
		$saldo          = $saldos[$i]['saldo'];
	    
        if($cuentaAnalizar == 3){
		 $saldoUtilidadPerdida = $saldo_utilidad_perdida; 		  
		 $saldoCuenta3         = $saldo + $saldoUtilidadPerdida;
	
		 $saldos[$i]['saldo'] = $saldoCuenta3;
		   	  
	     }	 
	  
	   }
	   
	   return $saldos;	 	  
  
  }
  
  protected function onclickGenerarBalance(){
    
	require_once("ComparativoBalanceGeneralLayoutClass.php");
	require_once("ComparativoBalanceGeneralModelClass.php");
    include_once("../../../framework/clases/UtilidadesContablesModelClass.php");	
		
	
	$Layout              = new ComparativoBalancegeneralLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model               = new ComparativoBalancegeneralModel();	
	$utilidadesContables = new UtilidadesContablesModel();
	$download           = $this -> requestData('download');
	$empresa_id         = $this -> getEmpresaId();
	
    $opciones_centros   = $this -> requestData('opciones_centros');
    $desde1             = $this -> requestData('desde1'); 
    $hasta1             = $this -> requestData('hasta1');
    $desde2             = $this -> requestData('desde2'); 
    $hasta2             = $this -> requestData('hasta2');
    $centro_de_costo_id = $this -> requestData('centro_de_costo_id');
    $oficina_id         = $this -> requestData('oficina_id');
    $opciones_tercero   = $this -> requestData('opciones_tercero');
    $nivel              = $this -> requestData('nivel');
	
    $arrayReport        = array();
	$Conex              = $this  -> getConex();	
	
	$parametros         = $utilidadesContables -> getParametrosReportes($Conex);
	$empresa            = $this -> getEmpresaNombre();
	$nitEmpresa         = $this -> getEmpresaIdentificacion();
	$centrosTxt         = $utilidadesContables -> getCentrosCostoTxt($centro_de_costo_id,$opciones_centros,$this  -> getConex());
	
	switch($nivel){
	
	  case 1:
	  
	   $arrayReporte = array();
	   $contLineas   = 0;	  
	  
	   $arrayResult=$this->getBalanceGeneralNivel1($hasta1,$desde1,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,$utilidadesContables,$Conex);   
  
       for($i = 0; $i < count($arrayResult); $i++){
	   
		  $arrayReporte[$contLineas]['codigo'] = $arrayResult[$i]['codigo'];
		  $arrayReporte[$contLineas]['cuenta'] = $arrayResult[$i]['cuenta'];
		  $arrayReporte[$contLineas]['saldo']  = $arrayResult[$i]['saldo'];
		  $arrayReporte[$contLineas]['tipo']   = 'CLASE';
		  $contLineas++;
		  	   
	      $subtotal['texto'] = 'TOTAL '.$arrayResult[$i]['cuenta'];
	      $subtotal['total'] = $arrayResult[$i]['saldo'];
	      $arrayReporte[$contLineas]['subtotal'] = $subtotal;
	      $contLineas++;	   
	   }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	   $arrayReporte1 = array();
	   $contLineas1   = 0;	  
	  
	   $arrayResult1=$this->getBalanceGeneralNivel1($hasta2,$desde2,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,$utilidadesContables,$Conex);   
  
       for($i = 0; $i < count($arrayResult1); $i++){
	   
		  $arrayReporte1[$contLineas1]['codigo'] = $arrayResult1[$i]['codigo'];		  
		  $arrayReporte1[$contLineas1]['cuenta'] = $arrayResult1[$i]['cuenta'];		  		  
		  $arrayReporte1[$contLineas1]['saldo']  = $arrayResult1[$i]['saldo'];	
		  $arrayReporte1[$contLineas1]['tipo']   = 'CLASE';			  			  
		  
		  $contLineas1++;
		  	   
	      $subtotal1['texto'] = 'TOTAL '.$arrayResult1[$i]['cuenta'];		 
	      $subtotal1['total'] = $arrayResult1[$i]['saldo'];		 
	   
	      $arrayReporte1[$contLineas1]['subtotal'] = $subtotal1;			
		  $contLineas1++;
	   
	   }
		
	  break;
	  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	  
	  case 2:
	    $arrayReporte = array();
		$contLineas   = 0;
		$arrayResult  = $this -> getBalanceGeneralNivel1($hasta1,$desde1,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,$utilidadesContables,$Conex);	
																												
        $saldoUtilidadPerdida = $Model -> getSaldoUtilidadPerdidaNivel1($hasta1,$desde1,$centro_de_costo_id,$opciones_centros,$empresa_id,    
		                                                                $utilidadesContables,$Conex);
																	
        $pucIdUtilidadPerdida = $Model -> getCodigoPucUtilidadPerdida($nivel,$saldoUtilidadPerdida,$utilidadesContables,$Conex);																																
			  			
		for($i = 0; $i < count($arrayResult); $i++){
		
		  $codigo_puc  = $arrayResult[$i]['codigo'];		  
		  $sub_cuentas = $Model -> selectSubCuentas($codigo_puc,$Conex);
		  
		  $arrayReporte[$contLineas]['codigo'] = $arrayResult[$i]['codigo'];		  
		  $arrayReporte[$contLineas]['cuenta'] = $arrayResult[$i]['cuenta'];		  		  
		  $arrayReporte[$contLineas]['saldo']  = $arrayResult[$i]['saldo'];	
		  $arrayReporte[$contLineas]['tipo']   = 'CLASE';
		  
		  $contLineas++;
		  
		  for($j = 0; $j < count($sub_cuentas); $j++){
		  
		    $puc_id     = $sub_cuentas[$j]['puc_id'];
			$movimiento = $sub_cuentas[$j]['movimiento'];
			
			if($puc_id == $pucIdUtilidadPerdida){
			  $saldo_cuenta = $saldoUtilidadPerdida;
			}else{
		        $saldo_cuenta = $Model -> getSaldoCuenta($puc_id,$hasta1,$desde1,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,
			                                             $utilidadesContables,$Conex);
	           }
						
			 if(is_numeric($saldo_cuenta) && $saldo_cuenta != 0){
			
		      $arrayReporte[$contLineas]['codigo'] = $sub_cuentas[$j]['codigo_puc'];		  
		      $arrayReporte[$contLineas]['cuenta'] = $sub_cuentas[$j]['nombre'];		  		  
		      $arrayReporte[$contLineas]['saldo']  = $saldo_cuenta;
		      $arrayReporte[$contLineas]['tipo']   = 'GRUPO';					
			  						
			  if($puc_id != $pucIdUtilidadPerdida && $movimiento == '1' && $opciones_tercero == 'S'){
			  
			    $terceros=$Model->selectSaldoTercerosBalance($empresa_id,$puc_id,$opciones_centros,$centro_de_costo_id,$hasta1,$desde1,$utilidadesContables
				,$Conex);
				
		        $arrayReporte[$contLineas]['cuenta']   = ucfirst(strtolower($arrayReporte[$contLineas]['cuenta']));					
		        $arrayReporte[$contLineas]['terceros'] = $terceros;								  								
				
			  }
			  
		      $contLineas++;			  
			
			}
		  
		  }
		  
	    $subtotal['texto'] = 'TOTAL '.$arrayResult[$i]['cuenta'];		 
	    $subtotal['total'] = $arrayResult[$i]['saldo'];		 
	   
	    $arrayReporte[$contLineas]['subtotal'] = $subtotal;			
		$contLineas++;
	
		}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$arrayReporte1 = array();
		$contLineas1  = 0;
		$arrayResult1  = $this -> getBalanceGeneralNivel1($hasta2,$desde2,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,$utilidadesContables,$Conex);	
																												
        $saldoUtilidadPerdida1 = $Model -> getSaldoUtilidadPerdidaNivel1($hasta2,$desde2,$centro_de_costo_id,$opciones_centros,$empresa_id,    
		                                                                $utilidadesContables,$Conex);
																	
        $pucIdUtilidadPerdida1 = $Model -> getCodigoPucUtilidadPerdida($nivel,$saldoUtilidadPerdida1,$utilidadesContables,$Conex);																																
			  			
		for($i = 0; $i < count($arrayResult1); $i++){
		
		  $codigo_puc1  = $arrayResult1[$i]['codigo'];		  
		  $sub_cuentas1 = $Model -> selectSubCuentas($codigo_puc1,$Conex);
		  
		  $arrayReporte1[$contLineas1]['codigo'] = $arrayResult1[$i]['codigo'];		  
		  $arrayReporte1[$contLineas1]['cuenta'] = $arrayResult1[$i]['cuenta'];		  		  
		  $arrayReporte1[$contLineas1]['saldo']  = $arrayResult1[$i]['saldo'];	
		  $arrayReporte1[$contLineas1]['tipo']   = 'CLASE';
		  
		  $contLineas1++;
		  
		  for($j = 0; $j < count($sub_cuentas1); $j++){
		  
		    $puc_id     = $sub_cuentas1[$j]['puc_id'];
			$movimiento = $sub_cuentas1[$j]['movimiento'];
			
			if($puc_id == $pucIdUtilidadPerdida1){
			  $saldo_cuenta = $saldoUtilidadPerdida1;
			}else{
		        $saldo_cuenta = $Model -> getSaldoCuenta($puc_id,$hasta2,$desde2,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,$utilidadesContables,$Conex);
	           }
						
			 if(is_numeric($saldo_cuenta) && $saldo_cuenta != 0){
			
		      $arrayReporte1[$contLineas1]['codigo'] = $sub_cuentas1[$j]['codigo_puc'];		  
		      $arrayReporte1[$contLineas1]['cuenta'] = $sub_cuentas1[$j]['nombre'];		  		  
		      $arrayReporte1[$contLineas1]['saldo']  = $saldo_cuenta;
		      $arrayReporte1[$contLineas1]['tipo']   = 'GRUPO';					
			  						
			  if($puc_id != $pucIdUtilidadPerdida1 && $movimiento == '1' && $opciones_tercero == 'S'){
			  
			    $terceros1=$Model->selectSaldoTercerosBalance($empresa_id,$puc_id,$opciones_centros,$centro_de_costo_id,$hasta2,$desde2,$utilidadesContables
				,$Conex);
				
		        $arrayReporte1[$contLineas1]['cuenta']   = ucfirst(strtolower($arrayReporte1[$contLineas1]['cuenta']));					
		        $arrayReporte1[$contLineas1]['terceros'] = $terceros1;								  								
				
			  }
			  
		      $contLineas1++;			  
			
			}
		  
		  }
		  
	    $subtotal1['texto'] = 'TOTAL '.$arrayResult1[$i]['cuenta'];		 
	    $subtotal1['total'] = $arrayResult1[$i]['saldo'];		 
	   
	    $arrayReporte1[$contLineas1]['subtotal'] = $subtotal1;			
		$contLineas1++;
	
		}
		  
	  break;
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	  
	  case 3:
	  
	    $arrayReporte = array();
		$contLineas   = 0;
	  
		$arrayResult = $this -> getBalanceGeneralNivel1($hasta1,$desde1,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,$utilidadesContables,
		                                                $Conex);	
																												
        $saldoUtilidadPerdida = $Model -> getSaldoUtilidadPerdidaNivel1($hasta1,$desde1,$centro_de_costo_id,$opciones_centros,$empresa_id,    
		                                                                $utilidadesContables,$Conex);
        $pucIdUtilidadPerdida2 = $Model -> getCodigoPucUtilidadPerdida(2,$saldoUtilidadPerdida,$utilidadesContables,$Conex);																		
        $pucIdUtilidadPerdida3 = $Model -> getCodigoPucUtilidadPerdida(3,$saldoUtilidadPerdida,$utilidadesContables,$Conex);																																
				
		for($i = 0; $i < count($arrayResult); $i++){
		
		  $arrayReporte[$contLineas]['codigo'] = $arrayResult[$i]['codigo'];		  
		  $arrayReporte[$contLineas]['cuenta'] = $arrayResult[$i]['cuenta'];		  		  
		  $arrayReporte[$contLineas]['saldo']  = $arrayResult[$i]['saldo'];	
		  $arrayReporte[$contLineas]['tipo']   = 'CLASE';			  	
		  
		  $contLineas++;  		  		  
		
		  $codigo_puc  = $arrayResult[$i]['codigo'];		  
		  $sub_cuentas = $Model -> selectSubCuentas($codigo_puc,$Conex);
		  $contNivel2  = 0;
		  
		  for($j = 0; $j < count($sub_cuentas); $j++){
		  
		    $puc_id = $sub_cuentas[$j]['puc_id'];
			$movimiento = $sub_cuentas[$j]['movimiento'];			
			
			if($puc_id == $pucIdUtilidadPerdida2){
			  $saldo_cuenta = $saldoUtilidadPerdida;
			}else{
		        $saldo_cuenta = $Model -> getSaldoCuenta($puc_id,$hasta1,$desde1,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,
			                                             $utilidadesContables,$Conex);
	           }
			
			$sub_cuentas[$j]['saldo'] = $saldo_cuenta;					
			 if(is_numeric($saldo_cuenta) && $saldo_cuenta != 0){
			
		      $arrayReporte[$contLineas]['codigo'] = $sub_cuentas[$j]['codigo_puc'];		  
		      $arrayReporte[$contLineas]['cuenta'] = $sub_cuentas[$j]['nombre'];		  		  
		      $arrayReporte[$contLineas]['saldo']  = $sub_cuentas[$j]['saldo'];
		      $arrayReporte[$contLineas]['tipo']   = 'GRUPO';					
						
			  if($puc_id != $pucIdUtilidadPerdida2 && $movimiento == '1' && $opciones_tercero == 'S'){
			  
			    $terceros=$Model->selectSaldoTercerosBalance($empresa_id,$puc_id,$opciones_centros,$centro_de_costo_id,$hasta1,$desde1,$utilidadesContables
				,$Conex);
				
		        $arrayReporte[$contLineas]['cuenta']   = ucfirst(strtolower($arrayReporte[$contLineas]['cuenta']));									
		        $arrayReporte[$contLineas]['terceros'] = $terceros;								  								
				
			  }
			  
			  $contLineas++;				  
			
			}			
						
		    $codigo_puc3  = $sub_cuentas[$j]['codigo_puc'];  
		    $sub_cuentas3 = $Model -> selectSubCuentas($codigo_puc3,$Conex);
		    $contNivel3   = 0;			
			
			for($k = 0; $k < count($sub_cuentas3); $k++){
			
			
		     $puc3_id = $sub_cuentas3[$k]['puc_id'];
 			$movimiento = $sub_cuentas3[$k]['movimiento'];
			
			 if($puc3_id == $pucIdUtilidadPerdida3){
			  $saldo_cuenta3 = $saldoUtilidadPerdida;
			 }else{
		        $saldo_cuenta3 = $Model -> getSaldoCuenta($puc3_id,$hasta1,$desde1,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,
			                                             $utilidadesContables,$Conex);
	           }
			
			 $sub_cuentas3[$k]['saldo'] = $saldo_cuenta3;			
			 $contNivel3;				 								 		
			
			 if(is_numeric($saldo_cuenta3) && $saldo_cuenta3 != 0){
		      $arrayReporte[$contLineas]['codigo'] = $sub_cuentas3[$k]['codigo_puc'];		  
		      $arrayReporte[$contLineas]['cuenta'] = $sub_cuentas3[$k]['nombre'];		  		  
		      $arrayReporte[$contLineas]['saldo']  = $sub_cuentas3[$k]['saldo'];	
		      $arrayReporte[$contLineas]['tipo']   = 'CUENTA';			
			  if($puc3_id != $pucIdUtilidadPerdida3 && $movimiento == '1' && $opciones_tercero == 'S'){
			    $terceros=$Model->selectSaldoTercerosBalance($empresa_id,$puc3_id,$opciones_centros,$centro_de_costo_id,$hasta1,$desde1,$utilidadesContables
				,$Conex);
		        $arrayReporte[$contLineas]['cuenta']   = ucfirst(strtolower($arrayReporte[$contLineas]['cuenta']));									
		        $arrayReporte[$contLineas]['terceros'] = $terceros;								  								
			  }
		      $contLineas++;			  
			}			
			}
		  }
	    $subtotal['texto'] = 'TOTAL '.$arrayResult[$i]['cuenta'];		 
	    $subtotal['total'] = $arrayResult[$i]['saldo'];		 
	    $arrayReporte[$contLineas]['subtotal'] = $subtotal;			
		$contLineas++;		
		} 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$arrayReporte1 = array();
		$contLineas1   = 0;
	  
		$arrayResult1 = $this -> getBalanceGeneralNivel1($hasta2,$desde2,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,$utilidadesContables,
		                                                $Conex);	
																												
        $saldoUtilidadPerdida = $Model -> getSaldoUtilidadPerdidaNivel1($hasta2,$desde2,$centro_de_costo_id,$opciones_centros,$empresa_id,    
		                                                                $utilidadesContables,$Conex);
        $pucIdUtilidadPerdida2 = $Model -> getCodigoPucUtilidadPerdida(2,$saldoUtilidadPerdida,$utilidadesContables,$Conex);																		
        $pucIdUtilidadPerdida3 = $Model -> getCodigoPucUtilidadPerdida(3,$saldoUtilidadPerdida,$utilidadesContables,$Conex);																																
				
		for($i = 0; $i < count($arrayResult1); $i++){
		
		  $arrayReporte1[$contLineas1]['codigo'] = $arrayResult1[$i]['codigo'];		  
		  $arrayReporte1[$contLineas1]['cuenta'] = $arrayResult1[$i]['cuenta'];		  		  
		  $arrayReporte1[$contLineas1]['saldo']  = $arrayResult1[$i]['saldo'];	
		  $arrayReporte1[$contLineas1]['tipo']   = 'CLASE';			  	
		  
		  $contLineas1++;  		  		  
		
		  $codigo_puc  = $arrayResult1[$i]['codigo'];		  
		  $sub_cuentas = $Model -> selectSubCuentas($codigo_puc,$Conex);
		  $contNivel2  = 0;
		  
		  for($j = 0; $j < count($sub_cuentas); $j++){
		  
		    $puc_id = $sub_cuentas[$j]['puc_id'];
			$movimiento = $sub_cuentas[$j]['movimiento'];			
			
			if($puc_id == $pucIdUtilidadPerdida2){
			  $saldo_cuenta = $saldoUtilidadPerdida;
			}else{
		        $saldo_cuenta = $Model -> getSaldoCuenta($puc_id,$hasta2,$desde2,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,
			                                             $utilidadesContables,$Conex);
	           }
			
			$sub_cuentas[$j]['saldo'] = $saldo_cuenta;					
			 if(is_numeric($saldo_cuenta) && $saldo_cuenta != 0){
			
		      $arrayReporte1[$contLineas1]['codigo'] = $sub_cuentas[$j]['codigo_puc'];		  
		      $arrayReporte1[$contLineas1]['cuenta'] = $sub_cuentas[$j]['nombre'];		  		  
		      $arrayReporte1[$contLineas1]['saldo']  = $sub_cuentas[$j]['saldo'];
		      $arrayReporte1[$contLineas1]['tipo']   = 'GRUPO';					
						
			  if($puc_id != $pucIdUtilidadPerdida2 && $movimiento == '1' && $opciones_tercero == 'S'){
			  
			    $terceros=$Model->selectSaldoTercerosBalance($empresa_id,$puc_id,$opciones_centros,$centro_de_costo_id,$hasta2,$desde2,$utilidadesContables
				,$Conex);
				
		        $arrayReporte1[$contLineas1]['cuenta']   = ucfirst(strtolower($arrayReporte1[$contLineas1]['cuenta']));									
		        $arrayReporte1[$contLineas1]['terceros'] = $terceros;								  								
				
			  }
			  
			  $contLineas1++;				  
			
			}			
						
		    $codigo_puc3  = $sub_cuentas[$j]['codigo_puc'];  
		    $sub_cuentas3 = $Model -> selectSubCuentas($codigo_puc3,$Conex);
		    $contNivel3   = 0;			
			
			for($k = 0; $k < count($sub_cuentas3); $k++){
			
			
		     $puc3_id = $sub_cuentas3[$k]['puc_id'];
 			$movimiento = $sub_cuentas3[$k]['movimiento'];
			
			 if($puc3_id == $pucIdUtilidadPerdida3){
			  $saldo_cuenta3 = $saldoUtilidadPerdida;
			 }else{
		        $saldo_cuenta3 = $Model -> getSaldoCuenta($puc3_id,$hasta2,$desde2,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,
			                                             $utilidadesContables,$Conex);
	           }
			
			 $sub_cuentas3[$k]['saldo'] = $saldo_cuenta3;			
			 $contNivel3;				 								 		
			
			 if(is_numeric($saldo_cuenta3) && $saldo_cuenta3 != 0){
		      $arrayReporte1[$contLineas1]['codigo'] = $sub_cuentas3[$k]['codigo_puc'];		  
		      $arrayReporte1[$contLineas1]['cuenta'] = $sub_cuentas3[$k]['nombre'];		  		  
		      $arrayReporte1[$contLineas1]['saldo']  = $sub_cuentas3[$k]['saldo'];	
		      $arrayReporte1[$contLineas1]['tipo']   = 'CUENTA';			
			  if($puc3_id != $pucIdUtilidadPerdida3 && $movimiento == '1' && $opciones_tercero == 'S'){
			    $terceros=$Model->selectSaldoTercerosBalance($empresa_id,$puc3_id,$opciones_centros,$centro_de_costo_id,$hasta2,$desde2,$utilidadesContables
				,$Conex);
		        $arrayReporte1[$contLineas1]['cuenta']   = ucfirst(strtolower($arrayReporte1[$contLineas1]['cuenta']));									
		        $arrayReporte1[$contLineas1]['terceros'] = $terceros;								  								
			  }
		      $contLineas1++;			  
			}			
			}
		  }
	    $subtotal['texto'] = 'TOTAL '.$arrayResult1[$i]['cuenta'];		 
	    $subtotal['total'] = $arrayResult1[$i]['saldo'];		 
	    $arrayReporte1[$contLineas1]['subtotal'] = $subtotal;			
		$contLineas1++;		
		} 
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	  
	  break;
	  
	  case 4:
	  
	    $arrayReporte = array();
		$contLineas   = 0;
	  
		$arrayResult = $this -> getBalanceGeneralNivel1($hasta1,$desde1,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,$utilidadesContables,
		                                                $Conex);	
																												
        $saldoUtilidadPerdida = $Model -> getSaldoUtilidadPerdidaNivel1($hasta1,$desde1,$centro_de_costo_id,$opciones_centros,$empresa_id,    
		                                                                $utilidadesContables,$Conex);
        $pucIdUtilidadPerdida2 = $Model -> getCodigoPucUtilidadPerdida(2,$saldoUtilidadPerdida,$utilidadesContables,$Conex);																		
        $pucIdUtilidadPerdida3 = $Model -> getCodigoPucUtilidadPerdida(3,$saldoUtilidadPerdida,$utilidadesContables,$Conex);																																
        $pucIdUtilidadPerdida4 = $Model -> getCodigoPucUtilidadPerdida(4,$saldoUtilidadPerdida,$utilidadesContables,$Conex);																																		
				
		for($i = 0; $i < count($arrayResult); $i++){
		
		  $arrayReporte[$contLineas]['codigo'] = $arrayResult[$i]['codigo'];		  
		  $arrayReporte[$contLineas]['cuenta'] = $arrayResult[$i]['cuenta'];		  		  
		  $arrayReporte[$contLineas]['saldo']  = $arrayResult[$i]['saldo'];	
		  $arrayReporte[$contLineas]['tipo']   = 'CLASE';			  	
		  
		  $contLineas++;  		  		  
		
		  $codigo_puc  = $arrayResult[$i]['codigo'];		  
		  $sub_cuentas = $Model -> selectSubCuentas($codigo_puc,$Conex);
		  
		  for($j = 0; $j < count($sub_cuentas); $j++){
		  
		    $puc_id = $sub_cuentas[$j]['puc_id'];
			$movimiento = $sub_cuentas[$j]['movimiento'];			
			
			if($puc_id == $pucIdUtilidadPerdida2){
			  $saldo_cuenta = $saldoUtilidadPerdida;
			}else{
		        $saldo_cuenta = $Model -> getSaldoCuenta($puc_id,$hasta1,$desde1,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,
			                                             $utilidadesContables,$Conex);
	           }
			
			$sub_cuentas[$j]['saldo'] = $saldo_cuenta;					
			
			 if(is_numeric($saldo_cuenta) && $saldo_cuenta != 0){
			
		      $arrayReporte[$contLineas]['codigo'] = $sub_cuentas[$j]['codigo_puc'];		  
		      $arrayReporte[$contLineas]['cuenta'] = $sub_cuentas[$j]['nombre'];		  		  
		      $arrayReporte[$contLineas]['saldo']  = $sub_cuentas[$j]['saldo'];
		      $arrayReporte[$contLineas]['tipo']   = 'GRUPO';					
						
			  if($puc_id != $pucIdUtilidadPerdida2 && $movimiento == '1' && $opciones_tercero == 'S'){
			  
			    $terceros=$Model->selectSaldoTercerosBalance($empresa_id,$puc_id,$opciones_centros,$centro_de_costo_id,$hasta1,$desde1,$utilidadesContables
				,$Conex);
				
		        $arrayReporte[$contLineas]['cuenta']   = ucfirst(strtolower($arrayReporte[$contLineas]['cuenta']));									
		        $arrayReporte[$contLineas]['terceros'] = $terceros;								  								
				
			  }
			  
			  $contLineas++;				  
			
			}
						
		    $codigo_puc3  = $sub_cuentas[$j]['codigo_puc'];  
		    $sub_cuentas3 = $Model -> selectSubCuentas($codigo_puc3,$Conex);	
			
			for($k = 0; $k < count($sub_cuentas3); $k++){
						
		     $puc3_id = $sub_cuentas3[$k]['puc_id'];
			$movimiento = $sub_cuentas3[$k]['movimiento'];			 
			
			 if($puc3_id == $pucIdUtilidadPerdida3){
			  $saldo_cuenta3 = $saldoUtilidadPerdida;
			 }else{
		        $saldo_cuenta3 = $Model -> getSaldoCuenta($puc3_id,$hasta1,$desde1,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,
			                                             $utilidadesContables,$Conex);
	           }
			
			 $sub_cuentas3[$k]['saldo'] = $saldo_cuenta3;			
			 
			 if(is_numeric($saldo_cuenta3) && $saldo_cuenta3 != 0){
			
		      $arrayReporte[$contLineas]['codigo'] = $sub_cuentas3[$k]['codigo_puc'];		  
		      $arrayReporte[$contLineas]['cuenta'] = $sub_cuentas3[$k]['nombre'];		  		  
		      $arrayReporte[$contLineas]['saldo']  = $sub_cuentas3[$k]['saldo'];
		      $arrayReporte[$contLineas]['tipo']   = 'CUENTA';								
			
			  if($puc3_id != $pucIdUtilidadPerdida3 && $movimiento == '1' && $opciones_tercero == 'S'){
			  
			    $terceros=$Model->selectSaldoTercerosBalance($empresa_id,$puc3_id,$opciones_centros,$centro_de_costo_id,$hasta1,$desde1,$utilidadesContables
				,$Conex);
				
		        $arrayReporte[$contLineas]['cuenta']   = ucfirst(strtolower($arrayReporte[$contLineas]['cuenta']));									
		        $arrayReporte[$contLineas]['terceros'] = $terceros;								  								
				
			  }
			  
			  $contLineas++;				  
			
			}
			
		    $codigo_puc4  = $sub_cuentas3[$k]['codigo_puc'];  
		    $sub_cuentas4 = $Model -> selectSubCuentas($codigo_puc4,$Conex);
		    $contNivel4   = 0;			
			
			for($l = 0; $l < count($sub_cuentas4); $l++){
						
		     $puc4_id = $sub_cuentas4[$l]['puc_id'];
			$movimiento = $sub_cuentas4[$l]['movimiento'];			 
			
			 if($puc4_id == $pucIdUtilidadPerdida4){
			  $saldo_cuenta4 = $saldoUtilidadPerdida;
			 }else{
		        $saldo_cuenta4 = $Model -> getSaldoCuenta($puc4_id,$hasta1,$desde1,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,
			                                             $utilidadesContables,$Conex);
	           }
			
			 $sub_cuentas4[$l]['saldo'] = $saldo_cuenta4;			
			 
			 if(is_numeric($saldo_cuenta4) && $saldo_cuenta4 != 0){
			
		      $arrayReporte[$contLineas]['codigo'] = $sub_cuentas4[$l]['codigo_puc'];		  
		      $arrayReporte[$contLineas]['cuenta'] = $sub_cuentas4[$l]['nombre'];		  		  
		      $arrayReporte[$contLineas]['saldo']  = $sub_cuentas4[$l]['saldo'];
		      $arrayReporte[$contLineas]['tipo']   = 'SUBCUENTA';								
			
			  if($puc4_id != $pucIdUtilidadPerdida4 && $movimiento == '1' && $opciones_tercero == 'S'){
			  
			    $terceros=$Model->selectSaldoTercerosBalance($empresa_id,$puc4_id,$opciones_centros,$centro_de_costo_id,$hasta1,$desde1,$utilidadesContables
				,$Conex);
				
		        $arrayReporte[$contLineas]['cuenta']   = ucfirst(strtolower($arrayReporte[$contLineas]['cuenta']));									
		        $arrayReporte[$contLineas]['terceros'] = $terceros;								  								
				
			  }
			  
			  $contLineas++;				  
			
			}
			
			}			
			
			}
			
			
		  
		  }
		  
	    $subtotal['texto'] = 'TOTAL '.$arrayResult[$i]['cuenta'];		 
	    $subtotal['total'] = $arrayResult[$i]['saldo'];		 
	   
	    $arrayReporte[$contLineas]['subtotal'] = $subtotal;			
		$contLineas++;			
		}
		
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$arrayReporte1 = array();
		$contLineas1   = 0;
	  
		$arrayResult1 = $this -> getBalanceGeneralNivel1($hasta2,$desde2,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,$utilidadesContables,
		                                                $Conex);	
																												
        $saldoUtilidadPerdida = $Model -> getSaldoUtilidadPerdidaNivel1($hasta2,$desde2,$centro_de_costo_id,$opciones_centros,$empresa_id,    
		                                                                $utilidadesContables,$Conex);
        $pucIdUtilidadPerdida2 = $Model -> getCodigoPucUtilidadPerdida(2,$saldoUtilidadPerdida,$utilidadesContables,$Conex);																		
        $pucIdUtilidadPerdida3 = $Model -> getCodigoPucUtilidadPerdida(3,$saldoUtilidadPerdida,$utilidadesContables,$Conex);																																
        $pucIdUtilidadPerdida4 = $Model -> getCodigoPucUtilidadPerdida(4,$saldoUtilidadPerdida,$utilidadesContables,$Conex);																																		
				
		for($i = 0; $i < count($arrayResult1); $i++){
		
		  $arrayReporte1[$contLineas1]['codigo'] = $arrayResult1[$i]['codigo'];		  
		  $arrayReporte1[$contLineas1]['cuenta'] = $arrayResult1[$i]['cuenta'];		  		  
		  $arrayReporte1[$contLineas1]['saldo']  = $arrayResult1[$i]['saldo'];	
		  $arrayReporte1[$contLineas1]['tipo']   = 'CLASE';			  	
		  
		  $contLineas1++;  		  		  
		
		  $codigo_puc  = $arrayResult1[$i]['codigo'];		  
		  $sub_cuentas = $Model -> selectSubCuentas($codigo_puc,$Conex);
		  
		  for($j = 0; $j < count($sub_cuentas); $j++){
		  
		    $puc_id = $sub_cuentas[$j]['puc_id'];
			$movimiento = $sub_cuentas[$j]['movimiento'];			
			
			if($puc_id == $pucIdUtilidadPerdida2){
			  $saldo_cuenta = $saldoUtilidadPerdida;
			}else{
		        $saldo_cuenta = $Model -> getSaldoCuenta($puc_id,$hasta2,$desde2,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,
			                                             $utilidadesContables,$Conex);
	           }
			
			$sub_cuentas[$j]['saldo'] = $saldo_cuenta;					
			
			 if(is_numeric($saldo_cuenta) && $saldo_cuenta != 0){
			
		      $arrayReporte1[$contLineas1]['codigo'] = $sub_cuentas[$j]['codigo_puc'];		  
		      $arrayReporte1[$contLineas1]['cuenta'] = $sub_cuentas[$j]['nombre'];		  		  
		      $arrayReporte1[$contLineas1]['saldo']  = $sub_cuentas[$j]['saldo'];
		      $arrayReporte1[$contLineas1]['tipo']   = 'GRUPO';					
						
			  if($puc_id != $pucIdUtilidadPerdida2 && $movimiento == '1' && $opciones_tercero == 'S'){
			  
			    $terceros=$Model->selectSaldoTercerosBalance($empresa_id,$puc_id,$opciones_centros,$centro_de_costo_id,$hasta2,$desde2,$utilidadesContables
				,$Conex);
				
		        $arrayReporte1[$contLineas1]['cuenta']   = ucfirst(strtolower($arrayReporte1[$contLineas1]['cuenta']));									
		        $arrayReporte1[$contLineas1]['terceros'] = $terceros;								  								
				
			  }
			  
			  $contLineas1++;				  
			
			}
						
		    $codigo_puc3  = $sub_cuentas[$j]['codigo_puc'];  
		    $sub_cuentas3 = $Model -> selectSubCuentas($codigo_puc3,$Conex);	
			
			for($k = 0; $k < count($sub_cuentas3); $k++){
						
		     $puc3_id = $sub_cuentas3[$k]['puc_id'];
			$movimiento = $sub_cuentas3[$k]['movimiento'];			 
			
			 if($puc3_id == $pucIdUtilidadPerdida3){
			  $saldo_cuenta3 = $saldoUtilidadPerdida;
			 }else{
		        $saldo_cuenta3 = $Model -> getSaldoCuenta($puc3_id,$hasta2,$desde2,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,
			                                             $utilidadesContables,$Conex);
	           }
			
			 $sub_cuentas3[$k]['saldo'] = $saldo_cuenta3;			
			 
			 if(is_numeric($saldo_cuenta3) && $saldo_cuenta3 != 0){
			
		      $arrayReporte1[$contLineas1]['codigo'] = $sub_cuentas3[$k]['codigo_puc'];		  
		      $arrayReporte1[$contLineas1]['cuenta'] = $sub_cuentas3[$k]['nombre'];		  		  
		      $arrayReporte1[$contLineas1]['saldo']  = $sub_cuentas3[$k]['saldo'];
		      $arrayReporte1[$contLineas1]['tipo']   = 'CUENTA';								
			
			  if($puc3_id != $pucIdUtilidadPerdida3 && $movimiento == '1' && $opciones_tercero == 'S'){
			  
			    $terceros=$Model->selectSaldoTercerosBalance($empresa_id,$puc3_id,$opciones_centros,$centro_de_costo_id,$hasta2,$desde2,$utilidadesContables
				,$Conex);
				
		        $arrayReporte1[$contLineas1]['cuenta']   = ucfirst(strtolower($arrayReporte1[$contLineas1]['cuenta']));									
		        $arrayReporte1[$contLineas1]['terceros'] = $terceros;								  								
				
			  }
			  
			  $contLineas1++;				  
			
			}
			
		    $codigo_puc4  = $sub_cuentas3[$k]['codigo_puc'];  
		    $sub_cuentas4 = $Model -> selectSubCuentas($codigo_puc4,$Conex);
		    $contNivel4   = 0;			
			
			for($l = 0; $l < count($sub_cuentas4); $l++){
						
		     $puc4_id = $sub_cuentas4[$l]['puc_id'];
			$movimiento = $sub_cuentas4[$l]['movimiento'];			 
			
			 if($puc4_id == $pucIdUtilidadPerdida4){
			  $saldo_cuenta4 = $saldoUtilidadPerdida;
			 }else{
		        $saldo_cuenta4 = $Model -> getSaldoCuenta($puc4_id,$hasta2,$desde2,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,
			                                             $utilidadesContables,$Conex);
	           }
			
			 $sub_cuentas4[$l]['saldo'] = $saldo_cuenta4;			
			 
			 if(is_numeric($saldo_cuenta4) && $saldo_cuenta4 != 0){
			
		      $arrayReporte1[$contLineas1]['codigo'] = $sub_cuentas4[$l]['codigo_puc'];		  
		      $arrayReporte1[$contLineas1]['cuenta'] = $sub_cuentas4[$l]['nombre'];		  		  
		      $arrayReporte1[$contLineas1]['saldo']  = $sub_cuentas4[$l]['saldo'];
		      $arrayReporte1[$contLineas1]['tipo']   = 'SUBCUENTA';								
			
			  if($puc4_id != $pucIdUtilidadPerdida4 && $movimiento == '1' && $opciones_tercero == 'S'){
			  
			    $terceros=$Model->selectSaldoTercerosBalance($empresa_id,$puc4_id,$opciones_centros,$centro_de_costo_id,$hasta2,$desde2,$utilidadesContables
				,$Conex);
				
		        $arrayReporte1[$contLineas1]['cuenta']   = ucfirst(strtolower($arrayReporte1[$contLineas1]['cuenta']));							
		        $arrayReporte1[$contLineas1]['terceros'] = $terceros;								  								
				
			  }
			  
			  $contLineas1++;				  
			
			}
			
			}			
			
			}
			
			
		  
		  }
		  
	    $subtotal['texto'] = 'TOTAL '.$arrayResult1[$i]['cuenta'];		 
	    $subtotal['total'] = $arrayResult1[$i]['saldo'];		 
	   
	    $arrayReporte1[$contLineas1]['subtotal'] = $subtotal;			
		$contLineas1++;			
		}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	 	  
	  
	  break;
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	  case 5:
	  
	    $arrayReporte = array();
		$contLineas   = 0;
	  
		$arrayResult = $this -> getBalanceGeneralNivel1($hasta1,$desde1,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,
		                                                $utilidadesContables,$Conex);	
																												
        $saldoUtilidadPerdida = $Model -> getSaldoUtilidadPerdidaNivel1($hasta1,$desde1,$centro_de_costo_id,$opciones_centros,$empresa_id,    
		                                                                $utilidadesContables,$Conex);
        $pucIdUtilidadPerdida2 = $Model -> getCodigoPucUtilidadPerdida(2,$saldoUtilidadPerdida,$utilidadesContables,$Conex);																		
        $pucIdUtilidadPerdida3 = $Model -> getCodigoPucUtilidadPerdida(3,$saldoUtilidadPerdida,$utilidadesContables,$Conex);																																
        $pucIdUtilidadPerdida4 = $Model -> getCodigoPucUtilidadPerdida(4,$saldoUtilidadPerdida,$utilidadesContables,$Conex);																																
        $pucIdUtilidadPerdida5 = $Model -> getCodigoPucUtilidadPerdida(5,$saldoUtilidadPerdida,$utilidadesContables,$Conex);																																
				
		for($i = 0; $i < count($arrayResult); $i++){
		
		    $arrayReporte[$contLineas]['codigo'] = $arrayResult[$i]['codigo'];		  
		    $arrayReporte[$contLineas]['cuenta'] = $arrayResult[$i]['cuenta'];		  		  
		    $arrayReporte[$contLineas]['saldo']  = $arrayResult[$i]['saldo'];	
		    $arrayReporte[$contLineas]['tipo']   = 'CLASE';			  	
		  
		    $contLineas++;  		
		
			 if(is_numeric($saldo_cuenta) && $saldo_cuenta != 0){
			
		      $arrayReporte[$contLineas]['codigo'] = $sub_cuentas[$i]['codigo_puc'];		  
		      $arrayReporte[$contLineas]['cuenta'] = $sub_cuentas[$i]['nombre'];		  		  
		      $arrayReporte[$contLineas]['saldo']  = $sub_cuentas[$i]['saldo'];
		      $arrayReporte[$contLineas]['tipo']   = 'CLASE';								
			
			  if($movimiento == '1' && $opciones_tercero == 'S'){
			  
			    $terceros=$Model->selectSaldoTercerosBalance($empresa_id,$puc_id,$opciones_centros,$centro_de_costo_id,$hasta1,$desde1,$utilidadesContables
				,$Conex);
				
		        $arrayReporte[$contLineas]['cuenta']   = ucfirst(strtolower($arrayReporte[$contLineas]['cuenta']));									
		        $arrayReporte[$contLineas]['terceros'] = $terceros;								  								
				
			  }
			  
			  $contLineas++;				  
			
			} 		  		  
		
		  $codigo_puc  = $arrayResult[$i]['codigo'];		  		  		  
		  $sub_cuentas = $Model -> selectSubCuentas($codigo_puc,$Conex);
		  		  
		  for($j = 0; $j < count($sub_cuentas); $j++){
		  	  
		    $puc_id = $sub_cuentas[$j]['puc_id'];
			$movimiento = $sub_cuentas[$j]['movimiento'];			
			
			if($puc_id == $pucIdUtilidadPerdida2){
			  $saldo_cuenta = $saldoUtilidadPerdida;
			}else{
		        $saldo_cuenta = $Model -> getSaldoCuenta($puc_id,$hasta1,$desde1,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,
			                                             $utilidadesContables,$Conex);
	           }
			
			$sub_cuentas[$j]['saldo'] = $saldo_cuenta;					
			
			 if(is_numeric($saldo_cuenta) && $saldo_cuenta != 0){
			
		      $arrayReporte[$contLineas]['codigo'] = $sub_cuentas[$j]['codigo_puc'];		  
		      $arrayReporte[$contLineas]['cuenta'] = $sub_cuentas[$j]['nombre'];		  		  
		      $arrayReporte[$contLineas]['saldo']  = $sub_cuentas[$j]['saldo'];
		      $arrayReporte[$contLineas]['tipo']   = 'GRUPO';								
			
			  if($puc_id != $pucIdUtilidadPerdida2 && $movimiento == '1' && $opciones_tercero == 'S'){
			  
			    $terceros=$Model->selectSaldoTercerosBalance($empresa_id,$puc_id,$opciones_centros,$centro_de_costo_id,$hasta1,$desde1,$utilidadesContables
				,$Conex);
				
		        $arrayReporte[$contLineas]['cuenta']   = ucfirst(strtolower($arrayReporte[$contLineas]['cuenta']));									
		        $arrayReporte[$contLineas]['terceros'] = $terceros;								  								
				
			  }
			  			  
			  $contLineas++;				  
			
			}
						
		    $codigo_puc3  = $sub_cuentas[$j]['codigo_puc'];  
		    $sub_cuentas3 = $Model -> selectSubCuentas($codigo_puc3,$Conex);	
			
			for($k = 0; $k < count($sub_cuentas3); $k++){
			
			
		     $puc3_id = $sub_cuentas3[$k]['puc_id'];
			$movimiento = $sub_cuentas3[$k]['movimiento'];			 
			
			 if($puc3_id == $pucIdUtilidadPerdida3){
			  $saldo_cuenta3 = $saldoUtilidadPerdida;
			 }else{
		        $saldo_cuenta3 = $Model -> getSaldoCuenta($puc3_id,$hasta1,$desde1,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,
			                                             $utilidadesContables,$Conex);
	           }
			
			 $sub_cuentas3[$k]['saldo'] = $saldo_cuenta3;			
			 
			 if(is_numeric($saldo_cuenta3) && $saldo_cuenta3 != 0){
			
		      $arrayReporte[$contLineas]['codigo'] = $sub_cuentas3[$k]['codigo_puc'];		  
		      $arrayReporte[$contLineas]['cuenta'] = $sub_cuentas3[$k]['nombre'];		  		  
		      $arrayReporte[$contLineas]['saldo']  = $sub_cuentas3[$k]['saldo'];
		      $arrayReporte[$contLineas]['tipo']   = 'CUENTA';								
			
			  if($puc3_id != $pucIdUtilidadPerdida3 && $movimiento == '1' && $opciones_tercero == 'S'){
			  
			    $terceros=$Model->selectSaldoTercerosBalance($empresa_id,$puc3_id,$opciones_centros,$centro_de_costo_id,$hasta1,$desde1,$utilidadesContables
				,$Conex);
				
		        $arrayReporte[$contLineas]['cuenta']   = ucfirst(strtolower($arrayReporte[$contLineas]['cuenta']));									
		        $arrayReporte[$contLineas]['terceros'] = $terceros;								  								
				
			  }
			  
			  $contLineas++;				  
			
			}
			
		    $codigo_puc4  = $sub_cuentas3[$k]['codigo_puc'];  
		    $sub_cuentas4 = $Model -> selectSubCuentas($codigo_puc4,$Conex);
			
			 for($l = 0; $l < count($sub_cuentas4); $l++){
						
		      $puc4_id = $sub_cuentas4[$l]['puc_id'];
			$movimiento = $sub_cuentas4[$l]['movimiento'];			  
			
			  if($puc4_id == $pucIdUtilidadPerdida4){
			   $saldo_cuenta4 = $saldoUtilidadPerdida;
			  }else{
		         $saldo_cuenta4 = $Model -> getSaldoCuenta($puc4_id,$hasta1,$desde1,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,
			                                             $utilidadesContables,$Conex);
	            }
			
			  $sub_cuentas4[$l]['saldo'] = $saldo_cuenta4;			
			 
			 if(is_numeric($saldo_cuenta4) && $saldo_cuenta4 != 0){
			
		      $arrayReporte[$contLineas]['codigo'] = $sub_cuentas4[$l]['codigo_puc'];		  
		      $arrayReporte[$contLineas]['cuenta'] = $sub_cuentas4[$l]['nombre'];		  		  
		      $arrayReporte[$contLineas]['saldo']  = $sub_cuentas4[$l]['saldo'];
		      $arrayReporte[$contLineas]['tipo']   = 'SUBCUENTA';								
			
			  if($puc4_id != $pucIdUtilidadPerdida4 && $movimiento == '1' && $opciones_tercero == 'S'){
			  
			    $terceros=$Model->selectSaldoTercerosBalance($empresa_id,$puc4_id,$opciones_centros,$centro_de_costo_id,$hasta1,$desde1,$utilidadesContables
				,$Conex);
				
		        $arrayReporte[$contLineas]['cuenta']   = ucfirst(strtolower($arrayReporte[$contLineas]['cuenta']));									
		        $arrayReporte[$contLineas]['terceros'] = $terceros;								  								
				
			  }
			  
			  $contLineas++;				  
			
			}
			  
			  
				$codigo_puc5  = $sub_cuentas4[$l]['codigo_puc'];  
				$sub_cuentas5 = $Model -> selectSubCuentas($codigo_puc5,$Conex);
				$contNivel5   = 0;			
				
				 for($m = 0; $m < count($sub_cuentas5); $m++){
							
				  $puc5_id = $sub_cuentas5[$m]['puc_id'];
			$movimiento = $sub_cuentas5[$m]['movimiento'];				  
				
				  if($puc5_id == $pucIdUtilidadPerdida5){
				   $saldo_cuenta5 = $saldoUtilidadPerdida;
				  }else{
					 $saldo_cuenta5 = $Model -> getSaldoCuenta($puc5_id,$hasta1,$desde1,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,
															 $utilidadesContables,$Conex);
					}
				
				  $sub_cuentas5[$m]['saldo'] = $saldo_cuenta5;			
				 
			 if(is_numeric($saldo_cuenta5) && $saldo_cuenta5 != 0){
			
		      $arrayReporte[$contLineas]['codigo'] = $sub_cuentas5[$m]['codigo_puc'];		  
		      $arrayReporte[$contLineas]['cuenta'] = $sub_cuentas5[$m]['nombre'];		  		  
		      $arrayReporte[$contLineas]['saldo']  = $sub_cuentas5[$m]['saldo'];
		      $arrayReporte[$contLineas]['tipo']   = 'AUX';								
			
			  if($puc5_id != $pucIdUtilidadPerdida5 && $movimiento == '1' && $opciones_tercero == 'S'){
			  
			    $terceros=$Model->selectSaldoTercerosBalance($empresa_id,$puc5_id,$opciones_centros,$centro_de_costo_id,$hasta1,$desde1,$utilidadesContables
				,$Conex);
				
		        $arrayReporte[$contLineas]['cuenta']   = ucfirst(strtolower($arrayReporte[$contLineas]['cuenta']));									
		        $arrayReporte[$contLineas]['terceros'] = $terceros;								  								
				
			  }
			  
			  $contLineas++;				  
			
			}
				
				 }					  
			  
			
			 }			
			
			}
			
			
		  
		  }
		  
	    $subtotal['texto'] = 'TOTAL '.$arrayResult[$i]['cuenta'];		 
	    $subtotal['total'] = $arrayResult[$i]['saldo'];		 
	   
	    $arrayReporte[$contLineas]['subtotal'] = $subtotal;			
		$contLineas++;			
		}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$arrayReporte1 = array();
		$contLineas1   = 0;
	  
		$arrayResult1 = $this -> getBalanceGeneralNivel1($hasta2,$desde2,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,
		                                                $utilidadesContables,$Conex);	
																												
        $saldoUtilidadPerdida = $Model -> getSaldoUtilidadPerdidaNivel1($hasta2,$desde2,$centro_de_costo_id,$opciones_centros,$empresa_id,    
		                                                                $utilidadesContables,$Conex);
        $pucIdUtilidadPerdida2 = $Model -> getCodigoPucUtilidadPerdida(2,$saldoUtilidadPerdida,$utilidadesContables,$Conex);																		
        $pucIdUtilidadPerdida3 = $Model -> getCodigoPucUtilidadPerdida(3,$saldoUtilidadPerdida,$utilidadesContables,$Conex);																																
        $pucIdUtilidadPerdida4 = $Model -> getCodigoPucUtilidadPerdida(4,$saldoUtilidadPerdida,$utilidadesContables,$Conex);																																
        $pucIdUtilidadPerdida5 = $Model -> getCodigoPucUtilidadPerdida(5,$saldoUtilidadPerdida,$utilidadesContables,$Conex);																																
				
		for($i = 0; $i < count($arrayResult1); $i++){
		
		    $arrayReporte1[$contLineas1]['codigo'] = $arrayResult1[$i]['codigo'];		  
		    $arrayReporte1[$contLineas1]['cuenta'] = $arrayResult1[$i]['cuenta'];		  		  
		    $arrayReporte1[$contLineas1]['saldo']  = $arrayResult1[$i]['saldo'];	
		    $arrayReporte1[$contLineas1]['tipo']   = 'CLASE';			  	
		  
		    $contLineas1++;  		
		
			 if(is_numeric($saldo_cuenta) && $saldo_cuenta != 0){
			
		      $arrayReporte1[$contLineas1]['codigo'] = $sub_cuentas[$i]['codigo_puc'];		  
		      $arrayReporte1[$contLineas1]['cuenta'] = $sub_cuentas[$i]['nombre'];		  		  
		      $arrayReporte1[$contLineas1]['saldo']  = $sub_cuentas[$i]['saldo'];
		      $arrayReporte1[$contLineas1]['tipo']   = 'CLASE';								
			
			  if($movimiento == '1' && $opciones_tercero == 'S'){
			  
			    $terceros=$Model->selectSaldoTercerosBalance($empresa_id,$puc_id,$opciones_centros,$centro_de_costo_id,$hasta2,$desde2,$utilidadesContables
				,$Conex);
				
		        $arrayReporte1[$contLineas1]['cuenta']   = ucfirst(strtolower($arrayReporte1[$contLineas1]['cuenta']));									
		        $arrayReporte1[$contLineas1]['terceros'] = $terceros;								  								
				
			  }
			  
			  $contLineas1++;				  
			
			} 		  		  
		
		  $codigo_puc  = $arrayResult1[$i]['codigo'];		  		  		  
		  $sub_cuentas = $Model -> selectSubCuentas($codigo_puc,$Conex);
		  		  
		  for($j = 0; $j < count($sub_cuentas); $j++){
		  	  
		    $puc_id = $sub_cuentas[$j]['puc_id'];
			$movimiento = $sub_cuentas[$j]['movimiento'];			
			
			if($puc_id == $pucIdUtilidadPerdida2){
			  $saldo_cuenta = $saldoUtilidadPerdida;
			}else{
		        $saldo_cuenta = $Model -> getSaldoCuenta($puc_id,$hasta2,$desde2,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,
			                                             $utilidadesContables,$Conex);
	           }
			
			$sub_cuentas[$j]['saldo'] = $saldo_cuenta;					
			
			 if(is_numeric($saldo_cuenta) && $saldo_cuenta != 0){
			
		      $arrayReporte1[$contLineas1]['codigo'] = $sub_cuentas[$j]['codigo_puc'];		  
		      $arrayReporte1[$contLineas1]['cuenta'] = $sub_cuentas[$j]['nombre'];		  		  
		      $arrayReporte1[$contLineas1]['saldo']  = $sub_cuentas[$j]['saldo'];
		      $arrayReporte1[$contLineas1]['tipo']   = 'GRUPO';								
			
			  if($puc_id != $pucIdUtilidadPerdida2 && $movimiento == '1' && $opciones_tercero == 'S'){
			  
			    $terceros=$Model->selectSaldoTercerosBalance($empresa_id,$puc_id,$opciones_centros,$centro_de_costo_id,$hasta2,$desde2,$utilidadesContables
				,$Conex);
				
		        $arrayReporte1[$contLineas1]['cuenta']   = ucfirst(strtolower($arrayReporte1[$contLineas1]['cuenta']));									
		        $arrayReporte1[$contLineas1]['terceros'] = $terceros;								  								
				
			  }
			  			  
			  $contLineas1++;				  
			
			}
						
		    $codigo_puc3  = $sub_cuentas[$j]['codigo_puc'];  
		    $sub_cuentas3 = $Model -> selectSubCuentas($codigo_puc3,$Conex);	
			
			for($k = 0; $k < count($sub_cuentas3); $k++){
			
			
		     $puc3_id = $sub_cuentas3[$k]['puc_id'];
			$movimiento = $sub_cuentas3[$k]['movimiento'];			 
			
			 if($puc3_id == $pucIdUtilidadPerdida3){
			  $saldo_cuenta3 = $saldoUtilidadPerdida;
			 }else{
		        $saldo_cuenta3 = $Model -> getSaldoCuenta($puc3_id,$hasta2,$desde2,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,
			                                             $utilidadesContables,$Conex);
	           }
			
			 $sub_cuentas3[$k]['saldo'] = $saldo_cuenta3;			
			 
			 if(is_numeric($saldo_cuenta3) && $saldo_cuenta3 != 0){
			
		      $arrayReporte1[$contLineas1]['codigo'] = $sub_cuentas3[$k]['codigo_puc'];		  
		      $arrayReporte1[$contLineas1]['cuenta'] = $sub_cuentas3[$k]['nombre'];		  		  
		      $arrayReporte1[$contLineas1]['saldo']  = $sub_cuentas3[$k]['saldo'];
		      $arrayReporte1[$contLineas1]['tipo']   = 'CUENTA';								
			
			  if($puc3_id != $pucIdUtilidadPerdida3 && $movimiento == '1' && $opciones_tercero == 'S'){
			  
			    $terceros=$Model->selectSaldoTercerosBalance($empresa_id,$puc3_id,$opciones_centros,$centro_de_costo_id,$hasta2,$desde2,$utilidadesContables
				,$Conex);
				
		        $arrayReporte1[$contLineas1]['cuenta']   = ucfirst(strtolower($arrayReporte1[$contLineas1]['cuenta']));									
		        $arrayReporte1[$contLineas1]['terceros'] = $terceros;								  								
				
			  }
			  
			  $contLineas1++;				  
			
			}
			
		    $codigo_puc4  = $sub_cuentas3[$k]['codigo_puc'];  
		    $sub_cuentas4 = $Model -> selectSubCuentas($codigo_puc4,$Conex);
			
			 for($l = 0; $l < count($sub_cuentas4); $l++){
						
		      $puc4_id = $sub_cuentas4[$l]['puc_id'];
			$movimiento = $sub_cuentas4[$l]['movimiento'];			  
			
			  if($puc4_id == $pucIdUtilidadPerdida4){
			   $saldo_cuenta4 = $saldoUtilidadPerdida;
			  }else{
		         $saldo_cuenta4 = $Model -> getSaldoCuenta($puc4_id,$hasta2,$desde2,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,
			                                             $utilidadesContables,$Conex);
	            }
			
			  $sub_cuentas4[$l]['saldo'] = $saldo_cuenta4;			
			 
			 if(is_numeric($saldo_cuenta4) && $saldo_cuenta4 != 0){
			
		      $arrayReporte1[$contLineas1]['codigo'] = $sub_cuentas4[$l]['codigo_puc'];		  
		      $arrayReporte1[$contLineas1]['cuenta'] = $sub_cuentas4[$l]['nombre'];		  		  
		      $arrayReporte1[$contLineas1]['saldo']  = $sub_cuentas4[$l]['saldo'];
		      $arrayReporte1[$contLineas1]['tipo']   = 'SUBCUENTA';								
			
			  if($puc4_id != $pucIdUtilidadPerdida4 && $movimiento == '1' && $opciones_tercero == 'S'){
			  
			    $terceros=$Model->selectSaldoTercerosBalance($empresa_id,$puc4_id,$opciones_centros,$centro_de_costo_id,$hasta2,$desde2,$utilidadesContables
				,$Conex);
				
		        $arrayReporte1[$contLineas1]['cuenta']   = ucfirst(strtolower($arrayReporte1[$contLineas1]['cuenta']));									
		        $arrayReporte1[$contLineas1]['terceros'] = $terceros;								  								
				
			  }
			  
			  $contLineas1++;				  
			
			}
			  
			  
				$codigo_puc5  = $sub_cuentas4[$l]['codigo_puc'];  
				$sub_cuentas5 = $Model -> selectSubCuentas($codigo_puc5,$Conex);
				$contNivel5   = 0;			
				
				 for($m = 0; $m < count($sub_cuentas5); $m++){
							
				  $puc5_id = $sub_cuentas5[$m]['puc_id'];
			$movimiento = $sub_cuentas5[$m]['movimiento'];				  
				
				  if($puc5_id == $pucIdUtilidadPerdida5){
				   $saldo_cuenta5 = $saldoUtilidadPerdida;
				  }else{
					 $saldo_cuenta5 = $Model -> getSaldoCuenta($puc5_id,$hasta2,$desde2,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,
															 $utilidadesContables,$Conex);
					}
				
				  $sub_cuentas5[$m]['saldo'] = $saldo_cuenta5;			
				 
			 if(is_numeric($saldo_cuenta5) && $saldo_cuenta5 != 0){
			
		      $arrayReporte1[$contLineas1]['codigo'] = $sub_cuentas5[$m]['codigo_puc'];		  
		      $arrayReporte1[$contLineas1]['cuenta'] = $sub_cuentas5[$m]['nombre'];		  		  
		      $arrayReporte1[$contLineas1]['saldo']  = $sub_cuentas5[$m]['saldo'];
		      $arrayReporte1[$contLineas1]['tipo']   = 'AUX';								
			
			  if($puc5_id != $pucIdUtilidadPerdida5 && $movimiento == '1' && $opciones_tercero == 'S'){
			  
			    $terceros=$Model->selectSaldoTercerosBalance($empresa_id,$puc5_id,$opciones_centros,$centro_de_costo_id,$hasta2,$desde2,$utilidadesContables
				,$Conex);
				
		        $arrayReporte1[$contLineas1]['cuenta']   = ucfirst(strtolower($arrayReporte1[$contLineas1]['cuenta']));									
		        $arrayReporte1[$contLineas1]['terceros'] = $terceros;								  								
				
			  }
			  
			  $contLineas1++;				  
			
			}
				
				 }					  
			  
			
			 }			
			
			}
			
			
		  
		  }
		  
	    $subtotal['texto'] = 'TOTAL '.$arrayResult1[$i]['cuenta'];		 
	    $subtotal['total'] = $arrayResult1[$i]['saldo'];		 
	   
	    $arrayReporte1[$contLineas1]['subtotal'] = $subtotal;			
		$contLineas1++;			
		}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	  break;	  	  	  	  	  
	  
	
	}

	$mayor=max((count($arrayReporte)), (count($arrayReporte1)));
	$array1=array();
	$array2=array();
	$array3=array();
	$array4=array();
	$j=0;
	$l=0;
	for($i=0;$i<$mayor;$i++){
		if($arrayReporte1[$i][codigo]==$arrayReporte[$i][codigo] && $arrayReporte[$i][codigo]!=''){
			if(array_search($arrayReporte[$i][codigo],$array2)===false){
				$array1[$j][codigo]=$arrayReporte[$i][codigo];
				$array1[$j][cuenta]=$arrayReporte[$i][cuenta];
				$array1[$j][tipo]=$arrayReporte[$i][tipo];
				$array1[$j][saldo]=$arrayReporte[$i][saldo];
				$array1[$j][saldo1]=$arrayReporte1[$i][saldo];
				
				$array2[$j]=$arrayReporte[$i][codigo];
				$j++;
			}
		}elseif($arrayReporte1[$i][subtotal][texto]==$arrayReporte[$i][subtotal][texto] && $arrayReporte[$i][subtotal][texto]!=''){
			if(array_search($arrayReporte[$i][codigo],$array4)===false){
				$array3[$l][subtotal][texto]=$arrayReporte[$i][subtotal][texto];
				$array3[$l][subtotal][total]=$arrayReporte[$i][subtotal][total];
				$array3[$l][subtotal][total1]=$arrayReporte1[$i][subtotal][total];
				
				$array4[$l]=$arrayReporte[$i][subtotal][texto];
				$l++;
			}
			
		}else{
			if(array_search($arrayReporte[$i][codigo],$array2)===false && $arrayReporte[$i][codigo]!=''){
				$array1[$j][codigo]=$arrayReporte[$i][codigo];
				$array1[$j][cuenta]=$arrayReporte[$i][cuenta];
				$array1[$j][tipo]=$arrayReporte[$i][tipo];	
				$array1[$j][saldo]=$arrayReporte[$i][saldo];
				$array1[$j][saldo1]=0;
				$array2[$j]=$arrayReporte[$i][codigo];
				$j++;
				
			}elseif($arrayReporte[$i][codigo]!=''){
				$array1[array_search($arrayReporte[$i][codigo],$array2)][saldo]=$arrayReporte[$i][saldo];
			}
			if(array_search($arrayReporte1[$i][codigo],$array2)===false && $arrayReporte1[$i][codigo]!=''){
				$array1[$j][codigo]=$arrayReporte1[$i][codigo];
				$array1[$j][cuenta]=$arrayReporte1[$i][cuenta];
				$array1[$j][tipo]=$arrayReporte1[$i][tipo];	
				$array1[$j][saldo]=0;
				$array1[$j][saldo1]=$arrayReporte1[$i][saldo];

				$array2[$j]=$arrayReporte1[$i][codigo];
				$j++;
			}elseif($arrayReporte1[$i][codigo]!=''){
				$array1[array_search($arrayReporte1[$i][codigo],$array2)][saldo1]=$arrayReporte1[$i][saldo];
			}
			if (array_search($arrayReporte[$i][subtotal][texto], $array4)===false && $arrayReporte[$i][subtotal][texto]!='') {
				$array3[$l][subtotal][texto]=$arrayReporte[$i][subtotal][texto];
				$array3[$l][subtotal][total]=$arrayReporte[$i][subtotal][total];
				$array3[$l][subtotal][total1]=0;
				$array4[$l]=$arrayReporte[$i][subtotal][texto];
				$l++;
			}elseif($arrayReporte[$i][subtotal][texto]!=''){
				$array3[array_search($arrayReporte[$i][subtotal][texto], $array4)][subtotal][total]=$arrayReporte[$i][subtotal][total];
			}
			if (array_search($arrayReporte1[$i][subtotal][texto], $array4)===false && $arrayReporte1[$i][subtotal][texto]!='') {
				$array3[$l][subtotal][texto]=$arrayReporte1[$i][subtotal][texto];
				$array3[$l][subtotal][total]=0;
				$array3[$l][subtotal][total1]=$arrayReporte1[$i][subtotal][total];
				$array4[$l]=$arrayReporte1[$i][subtotal][texto];
				$l++;
			}elseif($arrayReporte1[$i][subtotal][texto]!=''){
				$array3[array_search($arrayReporte1[$i][subtotal][texto], $array4)][subtotal][total1]=$arrayReporte1[$i][subtotal][total];
			}
		}
	}
	$array1 = $Model -> sortResultByField($array1,'codigo',SORT_STRING);

    $Layout -> setCssInclude("../../../framework/css/reset.css");			
    $Layout -> setCssInclude("../css/reportes.css");						
    $Layout -> setCssInclude("../css/reportes.css","print");	
    $Layout -> assign("CSSSYSTEM",$Layout -> getCssInclude());	
    $Layout -> setVar('NIVEL',$nivel);		
    $Layout -> setVar('EMPRESA',$empresa);	
    $Layout -> setVar('NIT',$nitEmpresa);	
    $Layout -> setVar('CENTROS',$centrosTxt);
    $Layout -> setVar('DESDE1',$desde1);
    $Layout -> setVar('HASTA1',$hasta1);
    $Layout -> setVar('DESDE2',$desde2);
    $Layout -> setVar('HASTA2',$hasta2);
    $Layout -> setVar('parametros',$parametros);
    $Layout -> setVar('arrayResult',$array1);
    $Layout -> setVar('parametros1',$parametros);
    $Layout -> setVar('arrayResult1',$array3);
    
    if($download == 'true'){
    	$Layout -> exportToExcel('comparativobalancegeneralReporte.tpl');   
 	}else{   
   		$Layout -> RenderLayout('comparativobalancegeneralReporte.tpl');
	}
	
}  
    
  protected function setCampos(){
    /*****************************************
            	 datos sesion
	*****************************************/  
	$this -> Campos[empresa_id] = array(
		name	=>'empresa_id',
		id		=>'empresa_id',
		type	=>'select',
		required=>'yes',
		options	=>array(),
	    datatype=>array(
			type	=>'integer',
			length	=>'9')
	);
	
	$this -> Campos[oficina_id] = array(
		name	=>'oficina_id',
		id		=>'oficina_id',
		type	=>'select',
		options	=>array(),
		multiple=>'yes',
		size    =>'3',		
	    datatype=>array(
			type	=>'integer',
			length	=>'9')
	);	
	
	$this -> Campos[opciones_centros] = array(
		name	=>'opciones_centros',
		id		=>'opciones_centros',
		type	=>'checkbox',
		value   =>'U',
	    datatype=>array(type=>'text')
	);		
	
	$this -> Campos[centro_de_costo_id] = array(
		name	=>'centro_de_costo_id',
		id		=>'centro_de_costo_id',
		type	=>'select',
		required=>'yes',
		options	=>array(),
		multiple=>'yes',
		size    =>'3',		
	    datatype=>array(
			type	=>'integer',
			length	=>'9')
	);		
		
	$this -> Campos[desde1] = array(
		name	=>'desde1',
		id		=>'desde1',
		type	=>'text',
		required=>'yes',
        value   =>date("Y-m-d"),
		datatype=>array(
			type	=>'date')
	);
	
	$this -> Campos[hasta1] = array(
		name	=>'hasta1',
		id		=>'hasta1',
		type	=>'text',
		required=>'yes',
        value   =>date("Y-m-d"),
		datatype=>array(
			type	=>'date')
	);	
	$this -> Campos[desde2] = array(
		name	=>'desde2',
		id		=>'desde2',
		type	=>'text',
		required=>'yes',
        value   =>date("Y-m-d"),
		datatype=>array(
			type	=>'date'),
		onblur =>'(this.form)'
	);
	
	$this -> Campos[hasta2] = array(
		name	=>'hasta2',
		id		=>'hasta2',
		type	=>'text',
		required=>'yes',
        value   =>date("Y-m-d"),
		datatype=>array(
			type	=>'date')
	);
	
	$this -> Campos[nivel] = array(
		name	=>'nivel',
		id		=>'nivel',
		type	=>'select',
		selected=>'1',
		required=>'yes',
		size    =>'3',
		datatype=>array(type=>'integer')
	);	
	
	$this -> Campos[opciones_tercero] = array(
		name	=>'opciones_tercero',
		id		=>'opciones_tercero',
		type	=>'select',
		required=>'yes',
		size    =>'3',
        options =>array(array(value=>'S',text=>'SI'),array(value=>'N',text=>'NO')),
        selected=>'N',		
		datatype=>array(type=>'alpha')
	);	
	
	//botones
	
   	$this -> Campos[generar] = array(
		name	=>'generar',
		id		=>'generar',
		type	=>'button',
		value	=>'Generar',
		onclick =>'onclickGenerarBalance(this.form)'
	);		
	
    $this -> Campos[imprimir] = array(
    name   =>'imprimir',
    id   =>'imprimir',
    type   =>'button',
    value   =>'Imprimir',
	onclick =>'beforePrint(this.form)'
    );
	$this -> Campos[descargar] = array(
	  name   =>'descargar',
	  id   =>'descargar',
	  type   =>'button',
	  value   =>'Descargar Excel',
	  onclick =>'descargarexcel(this.form)'
	);	
	
	$this -> SetVarsValidate($this -> Campos);
  }
	
	
}
$MovimientosContables = new ComparativoBalancegeneral();
?>