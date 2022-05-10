<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ConductoresModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function getEdadConductor($fecha_nacimiento_cond,$Conex){

    $select = "SELECT ((YEAR(CURDATE())-YEAR('$fecha_nacimiento_cond')) - (RIGHT(CURDATE(),5)<RIGHT('$fecha_nacimiento_cond',5))) AS edad";
 
    $result = $this -> DbFetchAll($select,$Conex);

    return $result[0]['edad'];

  }

  public function Save($Campos,$Conex){
  
    $this -> Begin($Conex);
					
	  $tercero_id             = $this -> DbgetMaxConsecutive("tercero","tercero_id",$Conex,true,1);
	  $ubicacion_id           = $this -> requestDataForQuery('ubicacion_id','integer');
	  $tipo_persona_id        = $this -> requestDataForQuery('tipo_persona_id','integer');
	  $tipo_identificacion_id = $this -> requestDataForQuery('tipo_identificacion_id','integer');
	  $numero_identificacion  = $this -> requestDataForQuery('numero_identificacion','bigint');
	  $digito_verificacion    = $this -> requestDataForQuery('digito_verificacion','integer');
	  $primer_apellido        = $this -> requestDataForQuery('primer_apellido','text');
	  $segundo_apellido       = $this -> requestDataForQuery('segundo_apellido','text');
	  $primer_nombre 	      = $this -> requestDataForQuery('primer_nombre','text');
	  $segundo_nombre 	      = $this -> requestDataForQuery('segundo_nombre','text');
	  $razon_social 	      = $this -> requestDataForQuery('razon_social','alphanum');
	  $sigla                  = $this -> requestDataForQuery('sigla','alphanum');
	  $telefono               = $this -> requestDataForQuery('telefono','alphanum');
	  $movil 	              = $this -> requestDataForQuery('movil','alphanum');
	  $direccion 	          = $this -> requestDataForQuery('direccion','alphanum');
	
	  $insert = "INSERT INTO tercero (tercero_id,ubicacion_id,tipo_persona_id,tipo_identificacion_id,numero_identificacion,digito_verificacion,primer_apellido,segundo_apellido, primer_nombre,segundo_nombre,razon_social,sigla,telefono,movil,direccion) 
	  VALUES  ($tercero_id,$ubicacion_id,$tipo_persona_id,$tipo_identificacion_id,$numero_identificacion,$digito_verificacion,$primer_apellido,$segundo_apellido,
	  $primer_nombre,$segundo_nombre,$razon_social,$sigla,$telefono,$movil,$direccion)"; 
	  
	  $this -> query($insert,$Conex);
	  	
      $this -> assignValRequest('tercero_id',$tercero_id);	 	  
      $this -> DbInsertTable("conductor",$Campos,$Conex,true,true);  
	  	  
	$this -> Commit($Conex);  
 
  }
  
  private function seRegistroConductor($Conex){
  
    $terceroId = $_REQUEST['tercero_id'];
    
    $select = "SELECT * FROM conductor WHERE tercero_id = $terceroId";
    
    $result = $this -> DbFetchAll($select,$Conex);
       
    if(count($result) > 0){
     return true;
    }else{
       return false;
     }
  
  }

  public function Update($Campos,$Conex){
  
    $this -> Begin($Conex);
     
      $this -> DbUpdateTable("tercero",$Campos,$Conex,true,false);
            
      if($this -> seRegistroConductor($Conex)){
        $this -> DbUpdateTable("conductor",$Campos,$Conex,true,false);
      }else{
          $this -> DbInsertTable("conductor",$Campos,$Conex,true,false);    
        }

     
    $this -> Commit($Conex);

  }

  public function Delete($Campos,$Conex){
  	$this -> DbDeleteTable("conductor",$Campos,$Conex,true,false);
  }

	//LISTA MENU
  public function GetTipoId($Conex){
	return $this  -> DbFetchAll("SELECT tipo_identificacion_id AS value,nombre AS text FROM tipo_identificacion WHERE tipo_identificacion_id != 2 AND ministerio = 1 ORDER BY nombre ASC",$Conex,$ErrDb = false);
  }
  
  public function GetGrupoSangre($Conex){
	return $this  -> DbFetchAll("SELECT tipo_sangre_id AS value,tipo_sangre AS text FROM tipo_sangre ORDER BY tipo_sangre ASC",$Conex,$ErrDb = false);
  }
  
  public function GetCategoriaLic($Conex){
	return $this  -> DbFetchAll("SELECT categoria_id AS value,categoria AS text FROM categoria_licencia ORDER BY categoria ASC",$Conex,$ErrDb = false);
  }

  public function GetEstadoCivil($Conex){
	return $this  -> DbFetchAll("SELECT estado_civil_id AS value,estado_civil AS text FROM estado_civil ORDER BY estado_civil ASC",$Conex,$ErrDb = false);
  }
  
  public function GetTipoPersona($Conex){
	return $this -> DbFetchAll("SELECT tipo_persona_id AS value,nombre AS text FROM tipo_persona ORDER BY nombre ASC",$Conex,$ErrDb = false);
   }



//BUSQUEDA
  public function selectConductoresporId($Id,$Conex){
  
  
   $select = "SELECT 
   					t.tercero_id,
					t.tipo_persona_id,
					t.tipo_identificacion_id,
					t.numero_identificacion,
					t.digito_verificacion,
					t.primer_apellido,
   					t.segundo_apellido,
					t.primer_nombre,
					t.segundo_nombre,
					t.razon_social,
					t.sigla,
					c.conductor_id,
					c.categoria_id,
					c.tipo_sangre_id,
					c.estado_civil_id,
   					c.nivel_educativo_id,
   					t.ubicacion_id,
					(SELECT nombre 
						FROM ubicacion 
						WHERE ubicacion_id=t.ubicacion_id) 
					AS ubicacion,
   					t.direccion,
					t.telefono,
					t.movil,					
					c.conductor_id,
					c.lugar_expedicion_cedula,
					c.estatura,
					c.senales_particulares,
					c.tipo_vivienda,
					c.barrio,
					c.tiempo_antiguedad_vivienda,
					c.personas_a_cargo,
					c.numero_hijos,
					c.arrendatario,
					c.telefono_arrendatario,
					c.empresa_cargo1,
					c.telefono_empresa_cargo1,
					c.ciudad_empresa_cargo1,
					c.nombre_persona_atendio1,
					c.cargo_persona_atendio1,
					c.tiempo_lleva_cargando1,
					c.rutas1,
					c.tipo_mercancia1,
					c.viajes_realizados1,
					c.empresa_cargo2,
					c.telefono_empresa_cargo2,
					c.ciudad_empresa_cargo2,
					c.nombre_persona_atendio2,
					c.cargo_persona_atendio2,
					c.tiempo_lleva_cargando2,
					c.rutas2,
					c.tipo_mercancia2,
					c.viajes_realizados2,
					c.empresa_cargo3,
					c.telefono_empresa_cargo3,
					c.ciudad_empresa_cargo3,
					c.nombre_persona_atendio3,
					c.cargo_persona_atendio3,
					c.tiempo_lleva_cargando3,
					c.rutas3,
					c.tipo_mercancia3,
					c.viajes_realizados3,
					c.referencia1,
					c.ciudad_referencia1_id,
					c.telefono_referencia1,
					c.referencia2,
					c.ciudad_referencia2_id,
					c.telefono_referencia2,
					c.referencia3,
					c.ciudad_referencia3_id,
					c.telefono_referencia3,
					c.categoria_id,
					c.tipo_sangre_id,
					c.estado_civil_id,
					c.nivel_educativo_id,
					c.fecha_ingreso_cond,
					c.numero_licencia_cond,
					c.vencimiento_licencia_cond,
					c.fecha_nacimiento_cond,
					c.libreta_mil_cond,
					c.distrito_mil_cond,
					c.eps_cond,
					c.arp_cond,
					c.antecedente_judicial_cond,
					c.contacto_cond,
					c.tel_contacto_cond,
					c.foto,
					c.cedulaescan,
					c.licenciaescan,
					c.pasadoescan,
					c.epsescan,
					c.arpescan,
					c.huellaindiceizq,
					c.huellapulgarizq,
					c.huellapulgarder,
					c.huellaindiceder,
					'B' AS estado,
					c.carga_por_primera_vez,
                                        ((YEAR(CURDATE())-YEAR(fecha_nacimiento_cond)) - (RIGHT(CURDATE(),5)<RIGHT(fecha_nacimiento_cond,5))) AS edad,
                                        (SELECT nombre FROM ubicacion WHERE ubicacion_id = c.ciudad_empresa_cargo1) AS ciudad_empresa_cargo1_txt,
                                        (SELECT nombre FROM ubicacion WHERE ubicacion_id = c.ciudad_empresa_cargo2) AS ciudad_empresa_cargo2_txt,
                                        (SELECT nombre FROM ubicacion WHERE ubicacion_id = c.ciudad_empresa_cargo3) AS ciudad_empresa_cargo3_txt,
                                        (SELECT nombre FROM ubicacion WHERE ubicacion_id = c.ciudad_referencia1_id) AS ciudad_referencia1_txt,
                                        (SELECT nombre FROM ubicacion WHERE ubicacion_id = c.ciudad_referencia2_id) AS ciudad_referencia2_txt,
                                        (SELECT nombre FROM ubicacion WHERE ubicacion_id = c.ciudad_referencia3_id) AS ciudad_referencia3_txt
					
   				FROM tercero t LEFT JOIN conductor c 
					ON t.tercero_id = c.tercero_id 
				WHERE t.tercero_id = $Id";
    
   $result =  $this -> DbFetchAll($select,$Conex,$ErrDb = false);
   
   return $result;
  }
  
  public function selectConductoresporNumId($Id,$Conex){
  
   $select = "SELECT 
   					t.tercero_id,
					t.tipo_persona_id,
					t.tipo_identificacion_id,
					t.numero_identificacion,
					t.digito_verificacion,
					t.primer_apellido,
   					t.segundo_apellido,
					t.primer_nombre,
					t.segundo_nombre,
					t.razon_social,
					t.sigla,
					c.conductor_id,
					c.categoria_id,
					c.tipo_sangre_id,
					c.estado_civil_id,
   					c.nivel_educativo_id,
   					t.ubicacion_id,
					(SELECT nombre 
						FROM ubicacion 
						WHERE ubicacion_id=t.ubicacion_id) 
					AS ubicacion,
   					t.direccion,
					t.telefono,
					t.movil,					
					c.conductor_id,
					c.lugar_expedicion_cedula,
					c.estatura,
					c.senales_particulares,
					c.tipo_vivienda,
					c.barrio,
					c.tiempo_antiguedad_vivienda,
					c.personas_a_cargo,
					c.numero_hijos,
					c.arrendatario,
					c.telefono_arrendatario,
					c.empresa_cargo1,
					c.telefono_empresa_cargo1,
					c.ciudad_empresa_cargo1,
					c.nombre_persona_atendio1,
					c.cargo_persona_atendio1,
					c.tiempo_lleva_cargando1,
					c.rutas1,
					c.tipo_mercancia1,
					c.viajes_realizados1,
					c.empresa_cargo2,
					c.telefono_empresa_cargo2,
					c.ciudad_empresa_cargo2,
					c.nombre_persona_atendio2,
					c.cargo_persona_atendio2,
					c.tiempo_lleva_cargando2,
					c.rutas2,
					c.tipo_mercancia2,
					c.viajes_realizados2,
					c.empresa_cargo3,
					c.telefono_empresa_cargo3,
					c.ciudad_empresa_cargo3,
					c.nombre_persona_atendio3,
					c.cargo_persona_atendio3,
					c.tiempo_lleva_cargando3,
					c.rutas3,
					c.tipo_mercancia3,
					c.viajes_realizados3,
					c.referencia1,
					c.ciudad_referencia1_id,
					c.telefono_referencia1,
					c.referencia2,
					c.ciudad_referencia2_id,
					c.telefono_referencia2,
					c.referencia3,
					c.ciudad_referencia3_id,
					c.telefono_referencia3,
					c.categoria_id,
					c.tipo_sangre_id,
					c.estado_civil_id,
					c.nivel_educativo_id,
					c.fecha_ingreso_cond,
					c.numero_licencia_cond,
					c.vencimiento_licencia_cond,
					c.fecha_nacimiento_cond,
					c.libreta_mil_cond,
					c.distrito_mil_cond,
					c.eps_cond,
					c.arp_cond,
					c.antecedente_judicial_cond,
					c.contacto_cond,
					c.tel_contacto_cond,
					c.foto,
					c.cedulaescan,
					c.licenciaescan,
					c.pasadoescan,
					c.epsescan,
					c.arpescan,
					c.huellaindiceizq,
					c.huellapulgarizq,
					c.huellapulgarder,
					c.huellaindiceder,
					'B' AS estado,
					c.carga_por_primera_vez,
                                        ((YEAR(CURDATE())-YEAR(fecha_nacimiento_cond)) - (RIGHT(CURDATE(),5)<RIGHT(fecha_nacimiento_cond,5))) AS edad,
                                        (SELECT nombre FROM ubicacion WHERE ubicacion_id = c.ciudad_empresa_cargo1) AS ciudad_empresa_cargo1_txt,
                                        (SELECT nombre FROM ubicacion WHERE ubicacion_id = c.ciudad_empresa_cargo2) AS ciudad_empresa_cargo2_txt,
                                        (SELECT nombre FROM ubicacion WHERE ubicacion_id = c.ciudad_empresa_cargo3) AS ciudad_empresa_cargo3_txt,
                                        (SELECT nombre FROM ubicacion WHERE ubicacion_id = c.ciudad_referencia1_id) AS ciudad_referencia1_txt,
                                        (SELECT nombre FROM ubicacion WHERE ubicacion_id = c.ciudad_referencia2_id) AS ciudad_referencia2_txt,
                                        (SELECT nombre FROM ubicacion WHERE ubicacion_id = c.ciudad_referencia3_id) AS ciudad_referencia3_txt
					
   				FROM tercero t LEFT JOIN conductor c 
					ON t.tercero_id = c.tercero_id 
				WHERE t.numero_identificacion = $Id";
    
   $result =  $this -> DbFetchAll($select,$Conex,$ErrDb = false);
   
   return $result;
  
  }


//// GRID ////
  public function getQueryConductoresGrid(){
	   	   
     $Query = "SELECT 
	 				(SELECT nombre 
						FROM tipo_identificacion 
						WHERE tipo_identificacion_id = t.tipo_identificacion_id) 
					AS tipo_identificacion,
	 				t.numero_identificacion,
					t.primer_apellido,
					t.segundo_apellido,
					t.primer_nombre,
					t.segundo_nombre,
	 				(SELECT categoria 
						FROM categoria_licencia 
						WHERE categoria_id = c.categoria_id) 
					AS categoria,
	 				(SELECT tipo_sangre 
						FROM tipo_sangre 
						WHERE tipo_sangre_id = c.tipo_sangre_id) 
					AS tipo_sangre,
	 				(SELECT estado_civil 
						FROM estado_civil 
						WHERE estado_civil_id = c.estado_civil_id) 
					AS estado_civil,
     				(SELECT descripcion 
						FROM nivel_educativo 
						WHERE nivel_educativo_id = c.nivel_educativo_id) 
					AS nivel_educativo,
	 				(SELECT nombre 
						FROM ubicacion 
						WHERE ubicacion_id = t.ubicacion_id) 
					AS ubicacion,
					t.direccion,
					t.telefono,
					t.movil,
	 				c.fecha_ingreso_cond,
					c.numero_licencia_cond,
					c.vencimiento_licencia_cond,
	 				c.fecha_nacimiento_cond,
					c.libreta_mil_cond,
					c.distrito_mil_cond,
	 				c.eps_cond,
					c.arp_cond,
					c.antecedente_judicial_cond,
	 				c.contacto_cond,
					c.tel_contacto_cond,
	 				c.estado
	 			FROM tercero t,conductor c 
				WHERE t.tercero_id = c.tercero_id";
    
        
     return $Query;
   }
   
}



?>