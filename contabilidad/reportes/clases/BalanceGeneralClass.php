<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Balancegeneral extends Controler{

  public function __construct(){
	parent::__construct(3);
  }

  public function Main(){
	     
    $this -> noCache();
    
	require_once("BalanceGeneralLayoutClass.php");
	require_once("BalanceGeneralModelClass.php");
	require_once("../../../framework/clases/UtilidadesContablesModelClass.php");		
	
	$Layout              = new BalancegeneralLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model               = new BalancegeneralModel();
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
  
	require_once("BalanceGeneralLayoutClass.php");
	require_once("BalanceGeneralModelClass.php");
	
	$Layout  = new BalancegeneralLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model   = new BalancegeneralModel();	
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
  
   
	require_once("BalanceGeneralModelClass.php");
    require_once("../../../framework/clases/ListaDependiente.php");
		
    $Model     = new BalancegeneralModel();  
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
  
  protected function getBalanceGeneralNivel1($opcierre,$hasta,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,$utilidadesContables,$Conex){
  
	  $result1 = $Model->getSaldoCuentasBalance($opcierre,$hasta,$centro_de_costo_id,$opciones_centros,$empresa_id,$utilidadesContables,$Conex);
	  
	  $saldo_utilidad_perdida=$Model->getSaldoUtilidadPerdidaNivel1($opcierre,$hasta,$centro_de_costo_id,$opciones_centros,$empresa_id,$utilidadesContables,$Conex);  	  

	  $aplica_suma = $Model->aplica_suma($hasta,$Conex);

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
        if($cuentaAnalizar == 3 && ($opcierre=='S' || ($opcierre=='N' && $aplica_suma=='N')) ){
			
			$saldoUtilidadPerdida = $saldo_utilidad_perdida; 		  
			$saldoCuenta3         = $saldo + $saldoUtilidadPerdida;
			
		 $saldos[$i]['saldo'] = $saldoCuenta3;
		  	 	  
	     }	 
	  
	   }
	   
	 
	  
	   return $saldos;	 	  
  
  }
  
  protected function onclickGenerarBalance(){
    
	require_once("BalanceGeneralLayoutClass.php");
	require_once("BalanceGeneralModelClass.php");
    require_once("../../../framework/clases/UtilidadesContablesModelClass.php");	
		
	
	$Layout              = new BalancegeneralLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model               = new BalancegeneralModel();	
	$utilidadesContables = new UtilidadesContablesModel();			

	$empresa_id			= $this -> getEmpresaId();
	$opciones_centros	= $this -> requestData('opciones_centros');
	$opcierre			= $this -> requestData('opciones_cierre');
	$desde              = $this -> requestData('desde'); 
	$hasta              = $this -> requestData('hasta');
	$centro_de_costo_id = $this -> requestData('centro_de_costo_id');
	$oficina_id         = $this -> requestData('oficina_id');
	$opciones_tercero   = $this -> requestData('opciones_tercero');
	$nivel              = $this -> requestData('nivel');
	$download           = $this -> requestData('download');	
	
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
	  
	   $arrayResult=$this->getBalanceGeneralNivel1($opcierre,$hasta,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,$utilidadesContables,$Conex);   
		
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
		
	  break;
	  
	  case 2:

	    $arrayReporte = array();
		$contLineas   = 0;

		$arrayResult  = $this -> getBalanceGeneralNivel1($opcierre,$hasta,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,$utilidadesContables,$Conex);	
																												
        $saldoUtilidadPerdida = $Model -> getSaldoUtilidadPerdidaNivel1($opcierre,$hasta,$centro_de_costo_id,$opciones_centros,$empresa_id,$utilidadesContables,$Conex);
																	
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
		        $saldo_cuenta = $Model -> getSaldoCuenta($opcierre,$puc_id,$hasta,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,
			                                             $utilidadesContables,$Conex);
	           }
						
			 if(is_numeric($saldo_cuenta) && $saldo_cuenta != 0){
			
		      $arrayReporte[$contLineas]['codigo'] = $sub_cuentas[$j]['codigo_puc'];		  
		      $arrayReporte[$contLineas]['cuenta'] = $sub_cuentas[$j]['nombre'];		  		  
		      $arrayReporte[$contLineas]['saldo']  = $saldo_cuenta;
		      $arrayReporte[$contLineas]['tipo']   = 'GRUPO';					
			  						
			  if($puc_id != $pucIdUtilidadPerdida && $movimiento == '1' && $opciones_tercero == 'S'){
			  
			    $terceros=$Model->selectSaldoTercerosBalance($opcierre,$empresa_id,$puc_id,$opciones_centros,$centro_de_costo_id,$hasta,$utilidadesContables
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
		  
	  break;
	  
	  case 3:
	  
	    $arrayReporte = array();
		$contLineas   = 0;
	  
		$arrayResult = $this -> getBalanceGeneralNivel1($opcierre,$hasta,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,$utilidadesContables,
		                                                $Conex);	
																												
        $saldoUtilidadPerdida = $Model -> getSaldoUtilidadPerdidaNivel1($opcierre,$hasta,$centro_de_costo_id,$opciones_centros,$empresa_id,    
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
		        $saldo_cuenta = $Model -> getSaldoCuenta($opcierre,$puc_id,$hasta,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,
			                                             $utilidadesContables,$Conex);
	           }
			
			$sub_cuentas[$j]['saldo'] = $saldo_cuenta;					
						
			 if(is_numeric($saldo_cuenta) && $saldo_cuenta != 0){
			
		      $arrayReporte[$contLineas]['codigo'] = $sub_cuentas[$j]['codigo_puc'];		  
		      $arrayReporte[$contLineas]['cuenta'] = $sub_cuentas[$j]['nombre'];		  		  
		      $arrayReporte[$contLineas]['saldo']  = $sub_cuentas[$j]['saldo'];
		      $arrayReporte[$contLineas]['tipo']   = 'GRUPO';					
						
			  if($puc_id != $pucIdUtilidadPerdida2 && $movimiento == '1' && $opciones_tercero == 'S'){
			  
			    $terceros=$Model->selectSaldoTercerosBalance($opcierre,$empresa_id,$puc_id,$opciones_centros,$centro_de_costo_id,$hasta,$utilidadesContables
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
		        $saldo_cuenta3 = $Model -> getSaldoCuenta($opcierre,$puc3_id,$hasta,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,
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
			  
			    $terceros=$Model->selectSaldoTercerosBalance($opcierre,$empresa_id,$puc3_id,$opciones_centros,$centro_de_costo_id,$hasta,$utilidadesContables
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
	  
	  break;
	  
	  case 4:
	  
	    $arrayReporte = array();
		$contLineas   = 0;
	  
		
		$arrayResult = $this -> getBalanceGeneralNivel1($opcierre,$hasta,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,$utilidadesContables,
		$Conex);
			
		
																												
        $saldoUtilidadPerdida = $Model -> getSaldoUtilidadPerdidaNivel1($opcierre,$hasta,$centro_de_costo_id,$opciones_centros,$empresa_id,    
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
		        $saldo_cuenta = $Model -> getSaldoCuenta($opcierre,$puc_id,$hasta,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,
			                                             $utilidadesContables,$Conex);
	           }
			
			$sub_cuentas[$j]['saldo'] = $saldo_cuenta;					
			
			 if(is_numeric($saldo_cuenta) && $saldo_cuenta != 0){
			
		      $arrayReporte[$contLineas]['codigo'] = $sub_cuentas[$j]['codigo_puc'];		  
		      $arrayReporte[$contLineas]['cuenta'] = $sub_cuentas[$j]['nombre'];		  		  
		      $arrayReporte[$contLineas]['saldo']  = $sub_cuentas[$j]['saldo'];
		      $arrayReporte[$contLineas]['tipo']   = 'GRUPO';					
						
			  if($puc_id != $pucIdUtilidadPerdida2 && $movimiento == '1' && $opciones_tercero == 'S'){
			  
			    $terceros=$Model->selectSaldoTercerosBalance($opcierre,$empresa_id,$puc_id,$opciones_centros,$centro_de_costo_id,$hasta,$utilidadesContables
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
		        $saldo_cuenta3 = $Model -> getSaldoCuenta($opcierre,$puc3_id,$hasta,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,
			                                             $utilidadesContables,$Conex);
	           }
			
			 $sub_cuentas3[$k]['saldo'] = $saldo_cuenta3;			
			 
			 if(is_numeric($saldo_cuenta3) && $saldo_cuenta3 != 0){
			
		      $arrayReporte[$contLineas]['codigo'] = $sub_cuentas3[$k]['codigo_puc'];		  
		      $arrayReporte[$contLineas]['cuenta'] = $sub_cuentas3[$k]['nombre'];		  		  
		      $arrayReporte[$contLineas]['saldo']  = $sub_cuentas3[$k]['saldo'];
		      $arrayReporte[$contLineas]['tipo']   = 'CUENTA';								
			
			  if($puc3_id != $pucIdUtilidadPerdida3 && $movimiento == '1' && $opciones_tercero == 'S'){
			  
			    $terceros=$Model->selectSaldoTercerosBalance($opcierre,$empresa_id,$puc3_id,$opciones_centros,$centro_de_costo_id,$hasta,$utilidadesContables
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
		        $saldo_cuenta4 = $Model -> getSaldoCuenta($opcierre,$puc4_id,$hasta,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,
			                                             $utilidadesContables,$Conex);
	           }
			
			 $sub_cuentas4[$l]['saldo'] = $saldo_cuenta4;			
			 
			 if(is_numeric($saldo_cuenta4) && $saldo_cuenta4 != 0){
			
		      $arrayReporte[$contLineas]['codigo'] = $sub_cuentas4[$l]['codigo_puc'];		  
		      $arrayReporte[$contLineas]['cuenta'] = $sub_cuentas4[$l]['nombre'];		  		  
		      $arrayReporte[$contLineas]['saldo']  = $sub_cuentas4[$l]['saldo'];
		      $arrayReporte[$contLineas]['tipo']   = 'SUBCUENTA';								
			
			  if($puc4_id != $pucIdUtilidadPerdida4 && $movimiento == '1' && $opciones_tercero == 'S'){
			  
			    $terceros=$Model->selectSaldoTercerosBalance($opcierre,$empresa_id,$puc4_id,$opciones_centros,$centro_de_costo_id,$hasta,$utilidadesContables
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
						 	  
	  
	  break;
	  
	  case 5:
	   
	    $arrayReporte = array();
		$contLineas   = 0;
	  
		$arrayResult = $this -> getBalanceGeneralNivel1($opcierre,$hasta,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,
		                                                $utilidadesContables,$Conex);	
		
	
																												
        $saldoUtilidadPerdida = $Model -> getSaldoUtilidadPerdidaNivel1($opcierre,$hasta,$centro_de_costo_id,$opciones_centros,$empresa_id,    
		                                                                $utilidadesContables,$Conex);
		//die(print_r($saldoUtilidadPerdida));

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
		
		  $codigo_puc  = $arrayResult[$i]['codigo'];		  		  		  
		  $sub_cuentas = $Model -> selectSubCuentas($codigo_puc,$Conex);

		  
		  		  
		  for($j = 0; $j < count($sub_cuentas); $j++){
		  	  
		    $puc_id = $sub_cuentas[$j]['puc_id']; 
			$movimiento = $sub_cuentas[$j]['movimiento'];			
			
			if($puc_id == $pucIdUtilidadPerdida2){ 
			  $saldo_cuenta = $saldoUtilidadPerdida;
			}else{
		        $saldo_cuenta = $Model -> getSaldoCuenta($opcierre,$puc_id,$hasta,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,
			                                             $utilidadesContables,$Conex);
	           }
			
			$sub_cuentas[$j]['saldo'] = $saldo_cuenta;					
			
			 if(is_numeric($saldo_cuenta) && $saldo_cuenta != 0){
			
		      $arrayReporte[$contLineas]['codigo'] = $sub_cuentas[$j]['codigo_puc'];		  
		      $arrayReporte[$contLineas]['cuenta'] = $sub_cuentas[$j]['nombre'];		  		  
		      $arrayReporte[$contLineas]['saldo']  = $sub_cuentas[$j]['saldo'];
		      $arrayReporte[$contLineas]['tipo']   = 'GRUPO';								
			
			  if($puc_id != $pucIdUtilidadPerdida2 && $movimiento == '1' && $opciones_tercero == 'S'){
			  
			    $terceros=$Model->selectSaldoTercerosBalance($opcierre,$empresa_id,$puc_id,$opciones_centros,$centro_de_costo_id,$hasta,$utilidadesContables
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
		        $saldo_cuenta3 = $Model -> getSaldoCuenta($opcierre,$puc3_id,$hasta,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,
			                                             $utilidadesContables,$Conex);
	           }
			
			 $sub_cuentas3[$k]['saldo'] = $saldo_cuenta3;			
			 
			 if(is_numeric($saldo_cuenta3) && $saldo_cuenta3 != 0){
			
		      $arrayReporte[$contLineas]['codigo'] = $sub_cuentas3[$k]['codigo_puc'];		  
		      $arrayReporte[$contLineas]['cuenta'] = $sub_cuentas3[$k]['nombre'];		  		  
		      $arrayReporte[$contLineas]['saldo']  = $sub_cuentas3[$k]['saldo'];
		      $arrayReporte[$contLineas]['tipo']   = 'CUENTA';								
			
			  if($puc3_id != $pucIdUtilidadPerdida3 && $movimiento == '1' && $opciones_tercero == 'S'){
			  
			    $terceros=$Model->selectSaldoTercerosBalance($opcierre,$empresa_id,$puc3_id,$opciones_centros,$centro_de_costo_id,$hasta,$utilidadesContables
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
		         $saldo_cuenta4 = $Model -> getSaldoCuenta($opcierre,$puc4_id,$hasta,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,
			                                             $utilidadesContables,$Conex);
				 
	            }
			
			  $sub_cuentas4[$l]['saldo'] = $saldo_cuenta4;			
			 
			 if(is_numeric($saldo_cuenta4) && $saldo_cuenta4 != 0){
			
		      $arrayReporte[$contLineas]['codigo'] = $sub_cuentas4[$l]['codigo_puc'];		  
		      $arrayReporte[$contLineas]['cuenta'] = $sub_cuentas4[$l]['nombre'];		  		  
		      $arrayReporte[$contLineas]['saldo']  = $sub_cuentas4[$l]['saldo'];
		      $arrayReporte[$contLineas]['tipo']   = 'SUBCUENTA';								
			
			  if($puc4_id != $pucIdUtilidadPerdida4 && $movimiento == '1' && $opciones_tercero == 'S'){
			  
			    $terceros=$Model->selectSaldoTercerosBalance($opcierre,$empresa_id,$puc4_id,$opciones_centros,$centro_de_costo_id,$hasta,$utilidadesContables
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
					 $saldo_cuenta5 = $Model -> getSaldoCuenta($opcierre,$puc5_id,$hasta,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,
															 $utilidadesContables,$Conex);
					}
				  
				
				
				  $sub_cuentas5[$m]['saldo'] = $saldo_cuenta5;			
				 
			 if(is_numeric($saldo_cuenta5) && $saldo_cuenta5 != 0){
			
		      $arrayReporte[$contLineas]['codigo'] = $sub_cuentas5[$m]['codigo_puc'];		  
		      $arrayReporte[$contLineas]['cuenta'] = $sub_cuentas5[$m]['nombre'];		  		  
		      $arrayReporte[$contLineas]['saldo']  = $sub_cuentas5[$m]['saldo'];
		      $arrayReporte[$contLineas]['tipo']   = 'AUX';								
			
			  if($puc5_id != $pucIdUtilidadPerdida5 && $movimiento == '1' && $opciones_tercero == 'S'){
			  
			    $terceros=$Model->selectSaldoTercerosBalance($opcierre,$empresa_id,$puc5_id,$opciones_centros,$centro_de_costo_id,$hasta,$utilidadesContables
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
	  
	  break;	  	  	  	  	  
	  
	
	}
    
    $desde = $utilidadesContables -> getCondicionSaldosBalanceGeneral($empresa_id);    

    $Layout -> setCssInclude("../../../framework/css/reset.css");			
    $Layout -> setCssInclude("../css/reportes.css");						
    $Layout -> setCssInclude("../css/reportes.css","print");
	$Layout -> setJsInclude("../../../framework/js/jquery-1.4.4.min.js");    	
	$Layout -> setJsInclude("../../../framework/js/funciones.js");
    $Layout -> assign("CSSSYSTEM",$Layout -> getCssInclude());		
    $Layout -> assign("JAVASCRIPT",$Layout -> getJsInclude());				
    $Layout -> setVar('NIVEL',$nivel);		
    $Layout -> setVar('EMPRESA',$empresa);	
    $Layout -> setVar('NIT',$nitEmpresa);	
    $Layout -> setVar('CENTROS',$centrosTxt);													
    $Layout -> setVar('HASTA',$hasta);															
    $Layout -> setVar('parametros',$parametros);    									
	$Layout -> setVar('arrayResult',$arrayReporte);	
	//die(print_r($arrayReporte));
    $Layout -> setVar('documentos',$this -> getTiposDocumentoContable($utilidadesContables,$Conex));														
    $Layout -> setVar('centro_de_costo_id',$centro_de_costo_id);														
    $Layout -> setVar('opciones_centros',$opciones_centros);															
    $Layout -> setVar('opciones_tercero','T');																	
    $Layout -> setVar('EMPRESAID',$empresa_id);																																	
    $Layout -> setVar('hasta',$hasta);															    
    		
	if($download == 'true'){
	    $Layout -> exportToExcel('balancegeneralExcel.tpl'); 		
	}else{
		
		$Layout->RenderLayout('balancegeneralReporte.tpl');

	}	  
	  

  } 
  
  
  protected function getTiposDocumentoContable($utilidadesContables,$Conex){
  
    $documentosTxt = null;
	$documentos    = $utilidadesContables -> getDocumentos($Conex);  
  
    for($i = 0; $i < count($documentos); $i++){
	  $documentosTxt .= $documentos[$i]['value'].',';
	}
		
	$documentosTxt = substr($documentosTxt,0,strlen($documentosTxt) -1);
	
	return $documentosTxt;  

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
		Boostrap=>'si',
		required=>'yes',
		options	=>array(),
		multiple=>'yes',
		size    =>'3',		
	    datatype=>array(
			type	=>'integer',
			length	=>'9')
	);		
		
	$this -> Campos[desde] = array(
		name	=>'desde',
		id		=>'desde',
		type	=>'text',
		required=>'yes',
        value   =>date("Y-m-d"),
		datatype=>array(
			type	=>'date')
	);
	
	$this -> Campos[hasta] = array(
		name	=>'hasta',
		id		=>'hasta',
		type	=>'text',
		Boostrap=>'si',
		required=>'yes',
        value   =>date("Y-m-d"),
		datatype=>array(
			type	=>'date')
	);	
	
	$this -> Campos[nivel] = array(
		name	=>'nivel',
		id		=>'nivel',
		type	=>'select',
		Boostrap=>'si',
		selected=>'1',
		required=>'yes',
		size    =>'3',
		datatype=>array(type=>'integer')
	);	
	
	$this -> Campos[opciones_tercero] = array(
		name	=>'opciones_tercero',
		id		=>'opciones_tercero',
		type	=>'select',
		Boostrap=>'si',
		required=>'yes',
		size    =>'3',
		options =>array(array(value=>'S',text=>'SI'),array(value=>'N',text=>'NO')),
		selected=>'N',		
		datatype=>array(type=>'alpha')
	);	

	$this -> Campos[opciones_cierre] = array(
		name	=>'opciones_cierre',
		id		=>'opciones_cierre',
		type	=>'select',
		Boostrap=>'si',
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
      name    =>'imprimir',
      id      =>'imprimir',
      type    =>'button',
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

$MovimientosContables = new Balancegeneral();

?>