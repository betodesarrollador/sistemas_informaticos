<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class SoporteModel extends Db{

  private $usuario_id;
  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }

  public function selectBarrio($ubicacion_id,$barrio_id,$Conex){
    
   $select = "SELECT b.barrio_id AS value, b.nombre AS text,$barrio_id AS selected FROM barrio b WHERE b.comuna_id IN(SELECT comuna_id FROM comuna WHERE ubicacion_id=$ubicacion_id)ORDER BY b.nombre ASC ";
           
      $resul = $this->DbFetchAll($select,$Conex,true);          
    
    return $resul;
    
  }   
  		
  public function Save($Campos,$UsuarioId,$Conex){
    $this -> assignValRequest('usuario_id',$UsuarioId);
    $this -> assignValRequest('fecha_registro',date('Y-m-d g-i-s'));
    $this -> DbInsertTable("soporte",$Campos,$Conex,true,false);

    $select="SELECT MAX(soporte_id) AS id FROM soporte";
    $result = $this->DbFetchAll($select,$Conex,true); 
    $soporte_id = $result[0]['id'];
    echo "soporte: ".$soporte_id;
    if($soporte_id > 0){
        
        $insert="INSERT INTO usuario_soporte (soporte_id,usuario_id) VALUES ($soporte_id,$UsuarioId)";

        $this -> query($insert,$Conex,true);
    }
  }

	
  public function Update($Soporte_id,$Campos,$UsuarioId,$Conex){	

    $select = "SELECT fecha_registro,usuario_id  FROM soporte WHERE soporte_id = $Soporte_id";
             
    $resul = $this->DbFetchAll($select,$Conex,true);  

    $this -> assignValRequest('usuario_actualiza_id',$UsuarioId);
    $this -> assignValRequest('fecha_actualiza',date('Y-m-d g-i-s'));	
    $usuario_id = $resul[0]['usuario_id'];
    $fecha_registro = $resul[0]['fecha_registro'];
    $this -> assignValRequest('usuario_id',$usuario_id);
    $this -> assignValRequest('fecha_registro',$fecha_registro);

    $this -> DbUpdateTable("soporte",$Campos,$Conex,true,false);	
  }
	
  public function Delete($Campos,$Conex){
  
  	$this -> DbDeleteTable("soporte",$Campos,$Conex,true,false);
	
  }				 	
   
   public function selectSoporte($soporte_id,$Conex){
      
      //$Soporte_id = $this -> requestDataForQuery('soporte_id','integer');

      $select         = "SELECT m.soporte_id,m.nombre,m.descripcion,m.estado,m.fecha_inicial,m.fecha_final,
                        (SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido)AS cliente FROM tercero t,cliente c WHERE t.tercero_id=c.tercero_id AND c.cliente_id=m.cliente_id)AS cliente,
                        (SELECT c.cliente_id FROM tercero t,cliente c WHERE t.tercero_id=c.tercero_id AND c.cliente_id=m.cliente_id)AS cliente_id FROM soporte m WHERE m.soporte_id = $soporte_id";	 
      $result         = $this -> DbFetchAll($select,$Conex,$ErrDb = false);

     
   
      return $result;
      
   }

   public function getQuerySoporteGrid(){
         
     $Query = "SELECT m.soporte_id,m.nombre,m.fecha_inicial,m.fecha_final,
              (SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido)AS cliente FROM tercero t,cliente c WHERE t.tercero_id=c.tercero_id AND c.cliente_id=m.cliente_id)AS cliente,
                IF(m.estado='1','ACTIVO','INACTIVO')AS estado 
                FROM soporte m ORDER BY m.soporte_id DESC";
    
     return $Query;
   
   }
   

}


?>