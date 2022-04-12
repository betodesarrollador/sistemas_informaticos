<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class InformeDiarioModel extends Db{

  private $usuario_id;
  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($PqrId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($PqrId,$Permiso,$Conex);
  }

  public function getNovedades($Conex)
  {

      $select = "SELECT novedad_informe_diario_id AS value, nombre AS text FROM novedad_informe_diario WHERE estado = 'A'";

      $result = $this->DbFetchAll($select, $Conex, $ErrDb = false);

      return $result;

  }

  public function Save($Campos,$usuario_id,$Conex){

    $this -> Begin($Conex);

    $this->assignValRequest('usuario_id', $usuario_id);  
    $this->DbInsertTable("informe_diario",$Campos,$Conex,true,false);

    $informe_id = $this -> DbgetMaxConsecutive("informe_diario","informe_id",$Conex,false,0);

    $array_novedades = explode(",",$_REQUEST['novedad_informe_diario_id']);

    $novedades = count($array_novedades);

    for ($i=0; $i < $novedades; $i++) { 
     
      $novedad_informe_diario_id = $array_novedades[$i];

      $insert = "INSERT INTO detalle_novedades_informe (novedad_informe_diario_id,informe_id) VALUES ($novedad_informe_diario_id,$informe_id)";

      $this -> query($insert,$Conex,true);		

    }

    $this -> Commit($Conex);

  }

  public function Update($Campos,$usuario_id,$Conex){

    $this -> Begin($Conex);
    $usuario = '"'.$_REQUEST['usuario'].'"';
    $this->assignValRequest('usuario_id', $usuario_id);  
    $this->assignValRequest('usuario', $usuario);  
    $this->DbUpdateTable("informe_diario",$Campos,$Conex,true,false);

    $informe_id = $_REQUEST['informe_id'];

    $delete = "DELETE FROM detalle_novedades_informe WHERE informe_id = $informe_id";

    $this -> query($delete,$Conex,true);		
    
    $array_novedades = explode(",",$_REQUEST['novedad_informe_diario_id']);

    $novedades = count($array_novedades);

    for ($i=0; $i < $novedades; $i++) { 
     
      $novedad_informe_diario_id = $array_novedades[$i];

      $insert = "INSERT INTO detalle_novedades_informe (novedad_informe_diario_id,informe_id) VALUES ($novedad_informe_diario_id,$informe_id)";

      $this -> query($insert,$Conex,true);		

    }


    $this -> Commit($Conex);

  }


  public function SelectInforme($informe_id,$Conex){

    $select= "SELECT i.*,(SELECT GROUP_CONCAT(n.novedad_informe_diario_id) FROM novedad_informe_diario n,detalle_novedades_informe d WHERE d.novedad_informe_diario_id = n.novedad_informe_diario_id AND d.informe_id = i.informe_id) AS novedad_informe_diario_id FROM informe_diario i WHERE i.informe_id = $informe_id";

    $result = $this->DbFetchAll($select,$Conex,true);

    return $result;

  }

}


?>