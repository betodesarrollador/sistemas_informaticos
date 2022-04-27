<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class EstadoModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){ 
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  ////
	public function seleccionar_remesa($guia_id,$estado,$Conex){
		$this -> Begin($Conex);
			if($estado == 6){
				$sql = "SELECT detalle_entrega_id FROM detalle_entrega WHERE guia_id = (SELECT guia_id FROM guia WHERE numero_guia = $guia_id)";
				$result = $this -> DbFetchAll($sql,$Conex);
				foreach ($result as $key) {
					$detalle = $key[detalle_entrega_id];
					$sql = "DELETE FROM detalle_entrega WHERE detalle_entrega_id = $detalle";
					$this -> query($sql,$Conex);
				}
				$update = "UPDATE guia SET estado_mensajeria_id=4 WHERE numero_guia=$guia_id ";
				$this -> query($update,$Conex,true);
			}elseif ($estado == 7) {
				// echo "string";
				$sql = "SELECT detalle_devolucion_id FROM detalle_devolucion WHERE guia_id = (SELECT guia_id FROM guia WHERE numero_guia = $guia_id)";
				$result = $this -> DbFetchAll($sql,$Conex);
				foreach ($result as $key) {
					$detalle = $key[detalle_devolucion_id];
					$sql = "DELETE FROM detalle_devolucion WHERE detalle_devolucion_id = $detalle";
					$this -> query($sql,$Conex);
				}
				$update = "UPDATE guia SET estado_mensajeria_id=4 WHERE numero_guia=$guia_id ";
				$this -> query($update,$Conex,true);
			}
		$this -> Commit($Conex);
	}

	public function seleccionar_remesa1($guia_id,$estado,$Conex){
		$this -> Begin($Conex);
			if($estado == 6){
				$sql = "SELECT detalle_entrega_id FROM detalle_entrega WHERE guia_interconexion_id = (SELECT guia_interconexion_id FROM guia_interconexion WHERE numero_guia = $guia_id)";
				$result = $this -> DbFetchAll($sql,$Conex);
				foreach ($result as $key) {
					$detalle = $key[detalle_entrega_id];
					$sql = "DELETE FROM detalle_entrega WHERE detalle_entrega_id = $detalle";
					$this -> query($sql,$Conex);
				}
				$update = "UPDATE guia_interconexion SET estado_mensajeria_id=4 WHERE numero_guia=$guia_id ";
				$this -> query($update,$Conex,true);
			}elseif ($estado == 7) {
				// echo "string";
				$sql = "SELECT detalle_devolucion_id FROM detalle_devolucion WHERE guia_interconexion_id = (SELECT guia_interconexion_id FROM guia_interconexion WHERE numero_guia = $guia_id)";
				$result = $this -> DbFetchAll($sql,$Conex);
				foreach ($result as $key) {
					$detalle = $key[detalle_devolucion_id];
					$sql = "DELETE FROM detalle_devolucion WHERE detalle_devolucion_id = $detalle";
					$this -> query($sql,$Conex);
				}
				$update = "UPDATE guia_interconexion SET estado_mensajeria_id=4 WHERE numero_guia=$guia_id ";
				$this -> query($update,$Conex,true);
			}
		$this -> Commit($Conex);
	}

  public function getEstadoReex($entrega_id,$Conex){
    $select = "SELECT 
	estado
	FROM entrega r 
	WHERE r.entrega_id=$entrega_id";

    $result = $this-> DbFetchAll($select,$Conex,true);
    return $result[0][estado];
 }

  public function getEstadoDisReex($entrega_id,$Conex){
    $select = "SELECT 
	COUNT(*) AS movimientos
	FROM entrega r, detalle_entrega dg, guia g
	WHERE r.entrega_id=$entrega_id AND dg.entrega_id=r.entrega_id 
	AND g.guia_id=dg.guia_id AND g.estado_mensajeria_id != 6 ";

    $result = $this-> DbFetchAll($select,$Conex,true);
    return $result[0][movimientos]!='' ? $result[0][movimientos] : 0;
 }

  public function setLeerCodigobar($guia,$Conex){
    $select = "SELECT 
	g.guia_id,
	g.numero_guia,
	g.remitente,
	g.destinatario,
	(SELECT referencia_producto FROM detalle_guia WHERE guia_id=g.guia_id) AS descripcion_producto,
	(SELECT peso FROM detalle_guia WHERE guia_id=g.guia_id) AS peso,
	(SELECT cantidad FROM detalle_guia WHERE guia_id=g.guia_id) AS cantidad,
	g.estado_mensajeria_id
	FROM guia g 
	WHERE g.numero_guia=$guia ";
    $result = $this-> DbFetchAll($select,$Conex,true);
    return $result;
 }

  public function setLeerCodigobar1($guia,$Conex){
    $select = "SELECT 
	g.guia_interconexion_id,
	g.numero_guia,
	g.remitente,
	g.destinatario,
	(SELECT peso FROM detalle_guia_interconexion WHERE guia_interconexion_id=g.guia_interconexion_id) AS peso,
	(SELECT cantidad FROM detalle_guia_interconexion WHERE guia_interconexion_id=g.guia_interconexion_id) AS cantidad,
	g.estado_mensajeria_id
	FROM guia_interconexion g 
	WHERE g.numero_guia=$guia ";
    $result = $this-> DbFetchAll($select,$Conex,true);
    return $result;
 }


  public function entregaTieneGuias($entrega_id,$Conex){  
    $select = "SELECT COUNT(*) AS num_guia FROM detalle_entrega WHERE entrega_id = $entrega_id";
	$result = $this -> DbFetchAll($select,$Conex,true);	
	if($result[0]['num_guia'] > 0){
	  return true;
	}else{
	     return false;
	  }	  
  }  
 


  
	public function Update($Conex){ 

		$entrega_id=$_REQUEST['entrega_id'];
		$obser_ent=$_REQUEST['obser_ent'];

		$update="UPDATE
					entrega d
				SET
					d.obser_ent='$obser_ent'
				WHERE
					d.entrega_id=$entrega_id
				";

		$this -> query($update,$Conex,true);
		if($this -> GetNumError() > 0){
			return false;
		}else{
			return array(entrega_id => $entrega_id);
		}


	}
}

?>