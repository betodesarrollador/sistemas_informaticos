<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");
final class TerceroActaModel extends Db{
  private $Permisos;
    
  public function Save($Campos,$Conex,$usuario_id){
        $this -> DbInsertTable("acuerdos_compromisos",$Campos,$Conex,true,false); 

        $compromiso = $this->requestData('compromiso');
        $acta_id = $this->requestData('acta_id');
        $prioridad = $this->requestData('prioridad');

        $select = "SELECT *
                    FROM actas
                    WHERE acta_id = $acta_id";
        $result = $this->DbFetchAll($select, $Conex, true);

        $actividad_programada_id = $this->DbgetMaxConsecutive("actividad_programada", "actividad_programada_id", $Conex, true, 1);
        $cliente_id = $result[0]['cliente_id'];
        $fecha_inicial = substr($result[0]['fecha_registro'], 0, 10);
        // $fecha_final    = "(DATE_ADD('$fecha_inicial', INTERVAL 8 DAY))";
        $fecha_final    = date("Y-m-d",strtotime($fecha_inicial."+ 8 days")); 
        $fecha_registro = date("Y-m-d H:i:s");
        $nombre = 'No. Acta: '.$acta_id.' - '.$result[0]['asunto'];

        $insert = "INSERT INTO actividad_programada (actividad_programada_id, nombre, descripcion, fecha_inicial, fecha_final, prioridad, estado, fecha_registro, usuario_id,tipo_tarea_id,acta_id)
                    VALUES ($actividad_programada_id,'$nombre','$compromiso','$fecha_inicial','$fecha_final',$prioridad,1,'$fecha_registro',$usuario_id,1,$acta_id)";

                    //  exit ($insert);
        $this->query($insert, $Conex, true);

        $insertActividadCliente = "INSERT INTO actividad_programada_cliente(actividad_programada_id, cliente_id)
                    VALUES ($actividad_programada_id,$cliente_id)";

                    //  exit ($insert);
        $this->query($insertActividadCliente, $Conex, true);


		
		return $this -> getConsecutiveInsert();
  }
  public function Update($Campos,$Conex){
  
        $this -> DbUpdateTable("acuerdos_compromisos",$Campos,$Conex,true,false);  		
		
  }
  public function Delete($Campos,$Conex){	 
  	$this -> DbDeleteTable("acuerdos_compromisos",$Campos,$Conex,true,false);  
  }
    
  
  public function getTercerosActa($Conex){
  
	$acta_id  = $this -> requestDataForQuery('acta_id','integer');
	
	if(is_numeric($acta_id)){
	
		$select  = "SELECT c.* FROM  acuerdos_compromisos c 
		WHERE c.acta_id  = $acta_id";	
	  	$result  = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	  }
	return $result;
  }
  

   
}

?>