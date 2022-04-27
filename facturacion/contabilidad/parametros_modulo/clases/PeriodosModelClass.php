<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class PeriodosModel extends Db{

  public function SetUsuarioId($usuario_id,$oficina_id){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  		
  public function Save($Campos,$Conex,$anio){	

    $select_valida="SELECT periodo_contable_id FROM periodo_contable WHERE anio = $anio";
    $result_valida = $this -> DbFetchAll($select_valida,$Conex,true);
    if ($result_valida=='') {
      $this -> DbInsertTable("periodo_contable",$Campos,$Conex,true,false);
    }else {
      Exit('Ya hay un periodo contable creado para el año <b>'.$anio.'</b> Por favor digite el año en el campo de busqueda.');
    }	
  }

  public function CrearMeses($Campos,$Conex,$periodo_contable_id,$empresa_id,$anio){
 
    $select_valida="SELECT periodo_contable_id FROM periodo_contable WHERE periodo_contable_id = $periodo_contable_id AND estado =1";
    $result_valida = $this -> DbFetchAll($select_valida,$Conex,true);  

    if ($result_valida>0) {

       $select_valida_mes="SELECT mes_contable_id FROM mes_contable WHERE periodo_contable_id = $periodo_contable_id AND estado =1";
    $result_mes = $this -> DbFetchAll($select_valida_mes,$Conex,true);  



    
          $select_oficina = "SELECT o.oficina_id
          FROM oficina o 
          WHERE o.empresa_id = $empresa_id";
          $result = $this -> DbFetchAll($select_oficina,$Conex,true);  

          $total_oficina =((count($result))*12);
          
  if (count($result_mes)==$total_oficina || count($result_mes)>$total_oficina) {
    Exit('Este periodo ya cuenta meses contables creados, por favor verifique en el formulario de mes contable.');
  }else{
          for ($i=0; $i < count($result) ; $i++) { 
            
            $select_mes_creado = "SELECT * FROM mes_contable WHERE periodo_contable_id = $periodo_contable_id AND oficina_id = ".$result[$i]['oficina_id']."";
            $result_mes_creado = $this -> DbFetchAll($select_mes_creado,$Conex,true);  
                
                for ($j=0; $j < 12 ; $j++) { 
                  $mes=$j+1;
                  if ($result_mes_creado[$j]['mes']!=$mes) {
                  $year=$anio;
                  $dia = date("d", mktime(0,0,0, $j+2,0, $year));
                  setlocale(LC_TIME, 'es_ES');
                  

                  $fech = DateTime::createFromFormat('!m', $mes);
                  $nombre_mes = strftime("%B", $fech->getTimestamp());

                  if($mes>9){
                    
                    $fecha_final = $year.'-'.$mes.'-'.$dia;
                    $fecha_inicio = $year.'-'.$mes.'-'.'01';
                  }else{
                    $fecha_final = $year.'-'.'0'.$mes.'-'.$dia;
                    $fecha_inicio = $year.'-'.'0'.$mes.'-'.'01';
                  }

                  $mes_contable_id = $this -> DbgetMaxConsecutive("mes_contable","mes_contable_id",$Conex);  
                  $mes_contable_id = ($mes_contable_id + 1);
                  $insert = "INSERT INTO mes_contable 
                  (mes_contable_id,periodo_contable_id,empresa_id,oficina_id,mes,fecha_inicio,fecha_final,nombre,estado,mes_trece) 
                  VALUES ($mes_contable_id,$periodo_contable_id,$empresa_id,".$result[$i]['oficina_id'].",".$mes.",'".$fecha_inicio."','".$fecha_final."',UPPER('".$nombre_mes."'),1,0)";
                  $this -> query($insert,$Conex);
                } else{

                  $update="UPDATE mes_contable SET estado=1 WHERE periodo_contable_id = $periodo_contable_id AND oficina_id = $i AND mes = ".$result_mes_creado[$j]['mes']."";
  
                  $this -> query($update,$Conex);
                } 
               }
          
          } 
      } 
    }else {
      Exit('Este periodo contable se encuentra en estado Cerrado, por favor seleccione uno que esté activo.');
    }


  

  if(strlen(trim($this -> GetError())) > 0){
    exit($this-> GetError()."\n".$insert);
  }else{
    echo('true');
  }

}
	
  public function Update($Campos,$Conex){	

    $this -> DbUpdateTable("periodo_contable",$Campos,$Conex,true,false);

  }

  public function validarCierre($periodo_contable_id,$Conex){
    $select = "SELECT encabezado_registro_id,consecutivo FROM encabezado_de_registro WHERE tipo_documento_id = (SELECT tipo_documento_id FROM tipo_de_documento WHERE de_cierre = 1) AND estado = 'C' AND periodo_contable_id = $periodo_contable_id ";
    
    $result = $this->DbFetchAll($select,$Conex,true);
    return $result;
  }
	
  public function Delete($Campos,$Conex){
 
   	$this -> DbDeleteTable("periodo_contable",$Campos,$Conex,true,false);
	
  }	
		
   public function ValidateRow($Conex,$Campos){
   
	 require_once("../../../framework/clases/ValidateRowClass.php");
		
	 $Data = new ValidateRow($Conex,"periodo_contable",$Campos);
	 
	 return $Data -> GetData();
   }
   
	 	
   public function getEmpresas($usuario_id,$Conex){
   
     $select = "SELECT e.empresa_id AS value,
	 CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS text FROM empresa e,tercero t 
	 WHERE t.tercero_id = e.tercero_id AND e.empresa_id IN (SELECT empresa_id FROM empresa WHERE empresa_id IN (SELECT empresa_id FROM 
	 opciones_actividad WHERE usuario_id = $usuario_id))";
	 
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);    
	 
	 return $result;
   
   }
     
    public function GetQueryEmpresasGrid(){
	   	   
   $Query = "SELECT (SELECT razon_social FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id 
   = p.empresa_id)) AS empresa,fecha_cierre,anio,IF(estado = 0,'CERRADO','DISPONIBLE') AS estado FROM periodo_contable p";
   
   return $Query;
   }
   
   
 
}





?>