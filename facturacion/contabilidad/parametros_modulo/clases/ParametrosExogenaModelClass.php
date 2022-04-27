<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");
final class ParametrosExogenaModel extends Db{
		
  private $UserId;
  private $Permisos;
  
  public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function selectDatosParametrosExogenaId($formato_exogena_id,$Conex){
     $select    = "SELECT f.formato_exogena_id, f.* FROM formato_exogena f WHERE f.formato_exogena_id = $formato_exogena_id";
     $result    = $this -> DbFetchAll($select,$Conex);
     return $result;		  
  }  
  
   public function getFormato($Conex){
   
     $select = "SELECT formato_exogena_id AS value,
	 CONCAT_WS(' ','Formato: ',tipo_formato,'-', 'Version: ',version,'-', 'Resol: ',resolucion) AS text 
	 FROM formato_exogena ";
	 
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);    
	 
	 return $result;
   
   }
  
  public function Save($Campos,$Conex){	
      $this -> Begin($Conex);					
	  $formato_exogena_id    = $this -> DbgetMaxConsecutive("formato_exogena","formato_exogena_id",$Conex,true,1);
	
      $this -> assignValRequest('formato_exogena_id',$formato_exogena_id);
      $this -> DbInsertTable("formato_exogena",$Campos,$Conex,true,false);  
	  if(!strlen(trim($this -> GetError())) > 0){
	  	$this -> Commit($Conex);		 
  	  	return $formato_exogena_id;
	  }
  }
  
  public function Update($Campos,$Conex){		
    $this -> DbUpdateTable("formato_exogena",$Campos,$Conex,true,false);	
  }  
  
  public function Delete($Campos,$Conex){
  	$this -> DbDeleteTable("formato_exogena",$Campos,$Conex,true,false);
  }	

  public function duplicar($Conex){
	 
	$this -> Begin($Conex);
	  $formato_base  	= $this -> requestDataForQuery('formato_base','integer');
	  $tipo_formato_n   = $this -> requestDataForQuery('tipo_formato_n','text');
	  $version_n  		= $this -> requestDataForQuery('version_n','integer');
	  $resolucion_n    	= $this -> requestDataForQuery('resolucion_n','text');

	  $cuantia_minima_n   = $this -> requestDataForQuery('cuantia_minima_n','numeric');
	  $ano_gravable_n  	  = $this -> requestDataForQuery('ano_gravable_n','integer');
	  $fecha_resolucion_n = $this -> requestDataForQuery('fecha_resolucion_n','date');
	  $select = "SELECT * FROM formato_exogena WHERE formato_exogena_id=$formato_base";
	  $result	=	$this -> DbFetchAll($select,$Conex,true);		  
	  $formato_exogena_id			= $this	->	DbgetMaxConsecutive("formato_exogena","formato_exogena_id",$Conex,true,1);
	  $insert 	= "INSERT INTO formato_exogena (formato_exogena_id,resolucion,fecha_resolucion,ano_gravable, tipo_formato,version,montos_ingresos,
				montos_ingresospj,cuantia_minima,cuantias_menores,tipo_doc,nit_extranjeros,nombre_tercero,tipo) 
				VALUES ($formato_exogena_id,$resolucion_n,$fecha_resolucion_n,$ano_gravable_n,$tipo_formato_n,$version_n,".$result[0]['montos_ingresos'].",
				".$result[0]['montos_ingresospj'].",$cuantia_minima_n,".$result[0]['cuantias_menores'].",'".$result[0]['tipo_doc']."','".$result[0]['nit_extranjeros']."',
				'".$result[0]['nombre_tercero']."','".$result[0]['tipo']."')";	
	 $this -> query($insert,$Conex,true);

	  
	  $insert 	= "INSERT INTO cuenta_exogena (`formato_exogena_id`, `categoria_exogena_id`, `base_categoria_exogena_id`, 				  					 `concepto_exogena_id`, `puc_id`, `tipo_sumatoria`, `centro_de_costo_id`, `estado`) 
					SELECT  $formato_exogena_id, `categoria_exogena_id`, `base_categoria_exogena_id`, `concepto_exogena_id`, `puc_id`, `tipo_sumatoria`, `centro_de_costo_id`, `estado`
					FROM 	cuenta_exogena WHERE formato_exogena_id = $formato_base";	
		
	  $this -> query($insert,$Conex,true);
	  $this -> Commit($Conex);	  
  }
   public function ValidateRow($Conex,$Campos){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($Conex,"formato_exogena",$Campos);
	 return $Data -> GetData();
   }
   public function getQueryParametrosExogenaGrid(){	   	   
     $Query = "SELECT f.resolucion, f.fecha_resolucion, f.ano_gravable, f.tipo_formato, f.version,f.montos_ingresos,f.montos_ingresospj
	 FROM formato_exogena f ORDER BY f.tipo_formato ASC";
     return $Query;	 
   } 
   
}
?>