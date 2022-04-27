<?php

    sendBasesMintransporte();                                                                               
    
     function conexion(){

      $User   = "siandsi4_tranale";
	  $Pass   = "_mLmn!&Fd-;Y";					
	  $Dbname = 'siandsi4_trans_alejandria';
        
        $Conex = mysql_connect("$Host","$User","$Pass");
		   
        mysql_select_db($Dbname,$Conex);
        
        return $Conex;
        
    }
                                                 
    function sendBasesMintransporte(){
        
    require_once("../../webservice/WebServiceMinTranporteClass.php");	
    
    $conexion = conexion();
    
    $getConex = array('conex' => $conexion,'Rdbms' =>'MYSQL');

    $webService = new WebServiceMinTransporte($getConex);

    $dataConductor   =  getReporteConductores($getConex[conex]);
    $dataPropietario =  getReportePropietarios($getConex[conex]);	   
    $dataTenedor     =  getReporteTenedores($getConex[conex]);	   
    $dataRemolque    =  getReporteRemolques($getConex[conex]);	  
    $dataVehiculo    =  getReporteVehiculos($getConex[conex]); 
    $dataRemitente   =  getReporteRemitentes($getConex[conex]); 
    $dataDestinatario=  getReporteDestinatarios($getConex[conex]); 
    
    $msj = "Se encontraron las siguientes bases para reportar : <br><br><b>Conductor : </b>".count($dataConductor)."<br><b>Propietario : </b>".count($dataPropietario)."<br><b>Tenedor : </b>".count($dataTenedor)."<br> <b>Remolque : </b>".count($dataRemolque)."<br> <b>Vehiculo : </b>".count($dataVehiculo)."<br> <b>Remitente : </b>".count($dataRemitente)."<br> <b>Destinatario : </b>".count($dataDestinatario)."<br><br>";
    
    print $msj;
    
      #Tenedor

      for ($i=0; $i < count($dataTenedor); $i++) {          
        
        $data = array(	  
            tenedor_id                => $dataTenedor[$i]['tenedor_id'],
            tipo_identificacion_id    => $dataTenedor[$i]['tipo_identificacion_id'],
            numero_identificacion     => $dataTenedor[$i]['numero_identificacion'],
            nombre                    => $dataTenedor[$i]['primer_nombre'].' '.$dataTenedor[$i]['segundo_nombre'].' '.$dataTenedor[$i]['razon_social'],		
            nombre_sede               => $dataTenedor[$i]['primer_nombre'].' '.$dataTenedor[$i]['segundo_nombre'].' '.$dataTenedor[$i]['primer_apellido'].' '.$dataTenedor[$i]['segundo_apellido'].' '.$dataTenedor[$i]['razon_social'],		
            primer_apellido           => $dataTenedor[$i]['primer_apellido'],
            segundo_apellido          => $dataTenedor[$i]['segundo_apellido'],
            telefono                  => $dataTenedor[$i]['telefono'],
            direccion                 => $dataTenedor[$i]['direccion'],
            ubicacion_id              => $dataTenedor[$i]['ubicacion_id']
        ); 
        
        $webService -> sendTenedorMintransporte($data,null);
        
    }	
      

    #Conductor

    for ($i=0; $i < count($dataConductor); $i++) { 
                                
        $data = array(	  
            conductor_id              => $dataConductor[$i]['conductor_id'],
            numero_identificacion     => $dataConductor[$i]['numero_identificacion'],
            nombre                    => $dataConductor[$i]['primer_nombre'].' '.$dataConductor[$i]['segundo_nombre'],
            primer_apellido           => $dataConductor[$i]['primer_apellido'],
            segundo_apellido          => $dataConductor[$i]['segundo_apellido'],
            telefono                  => $dataConductor[$i]['telefono'],
            direccion                 => $dataConductor[$i]['direccion'],
            categoria_id              => $dataConductor[$i]['categoria_id'],
            numero_licencia_cond      => $dataConductor[$i]['numero_licencia_cond'],
            vencimiento_licencia_cond => $dataConductor[$i]['vencimiento_licencia_cond'],				
            ubicacion_id              => $dataConductor[$i]['ubicacion_id']
        );
        
        $webService -> sendConductorMintransporte($data,NULL);	
        
    }

    #Propietario

    for ($i=0; $i < count($dataPropietario); $i++) { 
                                
        $data = array(	  
            tercero_id                => $dataPropietario[$i]['tercero_id'],
            tipo_identificacion_id    => $dataPropietario[$i]['tipo_identificacion_id'],
            numero_identificacion     => $dataPropietario[$i]['numero_identificacion'],
            nombre                    => $dataPropietario[$i]['primer_nombre'].' '.$dataPropietario[$i]['segundo_nombre'].' '.$dataPropietario[$i]['razon_social'],		
            nombre_sede               => $dataPropietario[$i]['primer_nombre'].' '.$dataPropietario[$i]['segundo_nombre'].' '.$dataPropietario[$i]['primer_apellido'].' '.$dataPropietario[$i]['segundo_apellido'].' '.$dataPropietario[$i]['razon_social'],		
            primer_apellido           => $dataPropietario[$i]['primer_apellido'],
            segundo_apellido          => $dataPropietario[$i]['segundo_apellido'],
            telefono                  => $dataPropietario[$i]['telefono'],
            direccion                 => $dataPropietario[$i]['direccion'],
            ubicacion_id              => $dataPropietario[$i]['ubicacion_id']
        );


        $webService -> sendPropietarioMintransporte($data,NULL);	
        
    }	     

    #Remolque   

    for ($i=0; $i < count($dataRemolque); $i++) { 
                                
        $data = array(	  
            placa_remolque_id        => $dataRemolque[$i]['placa_remolque_id'],	
            placa_remolque           => $dataRemolque[$i]['placa_remolque'],
            tipo_remolque_id         => $dataRemolque[$i]['tipo_remolque_id'],
            marca_remolque_id        => $dataRemolque[$i]['marca_remolque_id'],
            carroceria_remolque_id   => $dataRemolque[$i]['carroceria_remolque_id'],
            modelo_remolque          => $dataRemolque[$i]['modelo_remolque'],
            peso_vacio_remolque      => $dataRemolque[$i]['peso_vacio_remolque'],
            capacidad_carga_remolque => $dataRemolque[$i]['capacidad_carga_remolque'],
            unidad_capacidad_carga   => $dataRemolque[$i]['unidad_capacidad_carga'],
            propietario_id           => $dataRemolque[$i]['propietario_id'],											
            tenedor_id               => $dataRemolque[$i]['tenedor_id']
        );
            
        $webService -> sendRemolqueMintransporte($data,NULL);
        
    }	 
        
    #Vehiculo   

    for ($i=0; $i < count($dataVehiculo); $i++) { 	   
        
        $data = array(	  
            placa_id               =>  $dataVehiculo[$i]['placa_id'],	
            placa                  =>  $dataVehiculo[$i]['placa'],
            configuracion          =>  $dataVehiculo[$i]['configuracion'],
            marca_id               =>  $dataVehiculo[$i]['marca_id'],
            linea_id               =>  $dataVehiculo[$i]['linea_id'],		
            numero_ejes            =>  $dataVehiculo[$i]['numero_ejes'],		
            modelo_vehiculo        =>  $dataVehiculo[$i]['modelo_vehiculo'],
            modelo_repotenciado    =>  $dataVehiculo[$i]['modelo_repotenciado'],
            color_id               =>  $dataVehiculo[$i]['color_id'],
            peso_vacio             =>  $dataVehiculo[$i]['peso_vacio'],
            capacidad              =>  $dataVehiculo[$i]['capacidad'],
            unidad_capacidad_carga =>  $dataVehiculo[$i]['unidad_capacidad_carga'],		
            carroceria_id          =>  $dataVehiculo[$i]['carroceria_id'],				
            chasis                 =>  $dataVehiculo[$i]['chasis'],	
            combustible_id         =>  $dataVehiculo[$i]['combustible_id'],			
            numero_soat            =>  $dataVehiculo[$i]['numero_soat'],					
            vencimiento_soat       =>  $dataVehiculo[$i]['vencimiento_soat'],							
            aseguradora_soat_id    =>  $dataVehiculo[$i]['aseguradora_soat_id'],									
            propietario_id         =>  $dataVehiculo[$i]['propietario_id'],											
            tenedor_id             =>  $dataVehiculo[$i]['tenedor_id']
        );
                
        $webService -> sendVehiculoMintransporte($data,NULL);
        
    }	    

    #Cliente   

    for ($i=0; $i < count($dataCliente); $i++) { 	   
        
        $data = array(	  
            remitente_destinatario_id => $dataCliente[$i]['remitente_destinatario_id'],
            tipo_identificacion_id    => $dataCliente[$i]['tipo_identificacion_id'],
            numero_identificacion     => $dataCliente[$i]['numero_identificacion'].$dataCliente[$i]['digito_verificacion'],
            nombre                    => $dataCliente[$i]['nombre'],	
            nombre_sede               => $dataCliente[$i]['nombre'],	
            primer_apellido           => $dataCliente[$i]['primer_apellido'],
            segundo_apellido          => $dataCliente[$i]['segundo_apellido'],
            telefono                  => $dataCliente[$i]['telefono'],
            direccion                 => $dataCliente[$i]['direccion'],
            ubicacion_id              => $dataCliente[$i]['ubicacion_id']
        );
        
        $webService -> sendRemitenteDestinatarioMintransporte($data,NULL);
        
    }	    
    #Remitente   

    for ($i=0; $i < count($dataRemitente); $i++) { 	   
        
        $data = array(	  
            remitente_destinatario_id => $dataRemitente[$i]['remitente_destinatario_id'],
            tipo_identificacion_id    => $dataRemitente[$i]['tipo_identificacion_id'],
            numero_identificacion     => $dataRemitente[$i]['numero_identificacion'].$dataCliente[$i]['digito_verificacion'],
            nombre                    => $dataRemitente[$i]['nombre'],	
            nombre_sede               => $dataRemitente[$i]['nombre'],	
            primer_apellido           => $dataRemitente[$i]['primer_apellido'],
            segundo_apellido          => $dataRemitente[$i]['segundo_apellido'],
            telefono                  => $dataRemitente[$i]['telefono'],
            direccion                 => $dataRemitente[$i]['direccion'],
            ubicacion_id              => $dataRemitente[$i]['ubicacion_id']
        );
        
        $webService -> sendRemitenteDestinatarioMintransporte($data,NULL);
        
    }	    
    #Destinatario   

    for ($i=0; $i < count($dataDestinatario); $i++) { 	   
        
        $data = array(	  
            remitente_destinatario_id => $dataDestinatario[$i]['remitente_destinatario_id'],
            tipo_identificacion_id    => $dataDestinatario[$i]['tipo_identificacion_id'],
            numero_identificacion     => $dataDestinatario[$i]['numero_identificacion'].$dataCliente[$i]['digito_verificacion'],
            nombre                    => $dataDestinatario[$i]['nombre'],	
            nombre_sede               => $dataDestinatario[$i]['nombre'],	
            primer_apellido           => $dataDestinatario[$i]['primer_apellido'],
            segundo_apellido          => $dataDestinatario[$i]['segundo_apellido'],
            telefono                  => $dataDestinatario[$i]['telefono'],
            direccion                 => $dataDestinatario[$i]['direccion'],
            ubicacion_id              => $dataDestinatario[$i]['ubicacion_id']
        );
        
        $webService -> sendRemitenteDestinatarioMintransporte($data,NULL);
        
    }	    

    
    }
    
    
     function DbFetchAll($sql,$Conex){
       
       $result = mysql_query($sql,$Conex) or die ($Table   = array());
            
        for($i = 0; $Row = mysqli_fetch_assoc($result); $i++){	
                                                                        
        $Table[$i] = $Row;
        
        }
              
       return $Table;
       
       }
    
     function getReporteConductores($Conex){
        
        $select = "SELECT c.*,t.*,(concat_ws(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido)) AS conductor  
        FROM conductor c, tercero t, manifiesto m
        WHERE t.tercero_id = c.tercero_id AND c.reportado_ministerio = 0 AND c.error_reportando_ministerio = 1 
        AND c.conductor_id = m.conductor_id AND c.estado = 'D' GROUP BY c.conductor_id LIMIT 0,200"; 
        
        $result  = DbFetchAll($select,$Conex);
     
     }
         
      function getReportePropietarios($Conex){
     
        $select = "SELECT p.*, 
        (concat_ws(' ',p.razon_social,p.primer_nombre,p.segundo_nombre,p.primer_apellido,p.segundo_apellido)) AS propietario 
         FROM tercero p WHERE p.reportado_ministerio = 0 AND 
        p.error_reportando_ministerio = 1 AND p.propietario_vehiculo = 1 LIMIT 0,200";
        
        $result  = DbFetchAll($select,$Conex);
            
      return $result;	
     
     }
         
      function getReporteTenedores($Conex){
     
        $select = "SELECT t.*, te.*,(concat_ws(' ',te.primer_nombre,te.segundo_nombre,te.primer_apellido,te.segundo_apellido)) AS tenedor  
        FROM tenedor t,tercero te, manifiesto m 
        WHERE te.tercero_id = t.tercero_id AND t.reportado_ministerio = 0 AND t.error_reportando_ministerio = 1  AND
        m.tenedor_id = t.tenedor_id  AND t.estado = 'D'  GROUP BY t.tenedor_id LIMIT 0,200";
        
           $result  = DbFetchAll($select,$Conex);
            
      return $result;	
     
     }
         
      function getReporteRemolques($Conex){
     
        $select = "SELECT * FROM remolque r, manifiesto m
        WHERE r.placa_remolque_id = m.placa_remolque_id AND r.estado = 'D' AND 
        r.reportado_ministerio = 0 AND r.error_reportando_ministerio = 1 GROUP BY r.placa_remolque_id LIMIT 0,200";
        
        $result  = DbFetchAll($select,$Conex);
            
      return $result;	
     
     }
                     
      function getReporteVehiculos($Conex){
     
        $select = "SELECT * FROM vehiculo v, manifiesto m
        WHERE v.placa_id = m.placa_id AND v.estado = 'D' AND 
        v.reportado_ministerio = 0 AND v.error_reportando_ministerio = 1 GROUP BY v.placa_id  LIMIT 0,200";
        
        $result  = DbFetchAll($select,$Conex);
            
        return $result;	
     
     }
                         
      function getReporteClientes($Conex){
     
        $select = "SELECT c.*,r.* FROM remitente_destinatario r, cliente c, tercero t WHERE c.cliente_id = r.cliente_id AND 
        c.reportado_ministerio = 0 AND c.error_reportando_ministerio = 1 AND r.cliente_id = c.cliente_id  LIMIT 0,200";
        
           $result  = DbFetchAll($select,$Conex);
            
      return $result;	
     
     }
                                 
      function getReporteRemitentes($Conex){
     
        $select = "SELECT r.* FROM remitente_destinatario r WHERE 
        reportado_ministerio = 0 AND error_reportando_ministerio = 1 AND r.tipo = 'R' AND estado = 'D' LIMIT 0,200";
       
        $result  = DbFetchAll($select,$Conex);
            
        return $result;	
     
     }
                             
      function getReporteDestinatarios($Conex){
     
    $select = "SELECT r.* FROM remitente_destinatario r WHERE 
    reportado_ministerio = 0 AND error_reportando_ministerio = 1 AND r.tipo = 'D' AND estado = 'D' LIMIT 0,200";
        
    $result  = DbFetchAll($select,$Conex);
            
      return $result;	
     
     }

?>