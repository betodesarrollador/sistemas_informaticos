  <?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");
final class ActaModel extends Db{
  private $usuario_id;
  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  		
  public function Save($Campos,$Conex,$usuario_id){	
    $this->assignValRequest('usuario_registra', $usuario_id);
    $this -> DbInsertTable("actas",$Campos,$Conex,true,false);	
  }
	
  public function Update($Campos,$Conex,$usuario_id){	
    $this->assignValRequest('usuario_actualiza', $usuario_id);
    $this -> DbUpdateTable("actas",$Campos,$Conex,true,false);	
  }
	
  public function Delete($Campos,$Conex){  
  	$this -> DbDeleteTable("actas",$Campos,$Conex,true,false);	
  }	
  
  public function getPQR($Conex){      
    $select = "SELECT pqr_id AS value,pqr_id AS text 
                FROM pqr 
                WHERE pqr_id NOT IN(SELECT pqr_id FROM actas)";	 
    $result = $this -> DbFetchAll($select,$Conex,true);   
    return $result;      
 }  

  public function selectCorreo($cliente_id,$Conex){      
    $select = "SELECT email_cliente 
                FROM cliente 
                WHERE cliente_id=$cliente_id";	 
    $result = $this -> DbFetchAll($select,$Conex,true);   
    return $result;      
 }  
   
   public function selectActa($acta_id,$Conex){      
      $acta_id = $this -> requestDataForQuery('acta_id','integer');
      $select         = "SELECT a.*,(SELECT u.nombre FROM ubicacion u WHERE u.ubicacion_id=a.ubicacion_id)AS ubicacion,(SELECT CONCAT_WS('-',t.numero_identificacion,t.digito_verificacion,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
                          FROM tercero t, cliente c 
                          WHERE t.tercero_id=c.tercero_id AND c.cliente_id=a.cliente_id)AS cliente FROM actas a WHERE a.acta_id = $acta_id";	 

      $result         = $this -> DbFetchAll($select,$Conex,true);   
      return $result;      
   }      
   
   public function getQueryActaGrid(){	   	   
     $Query = "SELECT codigo,nombre,IF(requiere_soporte = 0,'NO','SI') AS requiere_soporte,(SELECT CONCAT(codigo_puc,' - ',nombre) FROM puc 
	 WHERE puc_id = c.puc_id) AS puc,IF(c.cuenta_tipo_pago_natu = 'D','DEBITO','CREDITO') AS naturaleza,(SELECT nombre_banco FROM banco WHERE banco_id = c.banco_id) banco,IF(estado = 1,'ACTIVA','INACTIVA') AS 
	 estado FROM actas f, cuenta_tipo_pago c WHERE f.acta_id = c.acta_id ORDER BY nombre ASC";   
     return $Query;	 
   }   
}
?>