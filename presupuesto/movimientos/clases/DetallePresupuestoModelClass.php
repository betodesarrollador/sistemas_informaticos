<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetallePresupuestoModel extends Db{
 
  public function selectDetallePresupuesto($presupuesto_id,$Conex){
    
    $select = "SELECT dt.detalle_presupuesto_id,puc.puc_id,puc.nombre AS nombre_cuenta,puc.codigo_puc,dt.enero,dt.febrero,dt.marzo,dt.abril,
               dt.mayo,dt.junio,dt.julio,dt.agosto,dt.septiembre,dt.octubre,dt.noviembre,dt.diciembre,
               (dt.enero+dt.febrero+dt.marzo+dt.abril+
               dt.mayo+dt.junio+dt.julio+dt.agosto+dt.septiembre+dt.octubre+dt.noviembre+dt.diciembre) AS 
               total_cuenta FROM puc LEFT JOIN (SELECT * FROM detalle_presupuesto WHERE presupuesto_id = 
               $presupuesto_id) dt ON puc.puc_id = dt.puc_id WHERE puc.presupuestar = 1 ORDER BY puc.codigo_puc ASC";
               
    $result = $this -> DbFetchAll($select,$Conex);    
    
    return $result;               
    
  }
  
  public function Save($presupuesto_id,$presupuesto,$Conex){
                
    for($i = 0; $i < count($presupuesto); $i++){
        
        $puc_id = $presupuesto[$i]['puc_id'];
        
        $select = "SELECT * FROM detalle_presupuesto WHERE presupuesto_id = $presupuesto_id
                   AND puc_id = $puc_id;";
                   
        $dataPresupuesto = $this ->  DbFetchAll($select,$Conex,true);

        $enero      = $this->removeFormatCurrency($presupuesto[$i]['enero']);
        $febrero    = $this->removeFormatCurrency($presupuesto[$i]['febrero']);
        $marzo      = $this->removeFormatCurrency($presupuesto[$i]['marzo']);
        $abril      = $this->removeFormatCurrency($presupuesto[$i]['abril']);
        $mayo       = $this->removeFormatCurrency($presupuesto[$i]['mayo']);
        $junio      = $this->removeFormatCurrency($presupuesto[$i]['junio']);
        $julio      = $this->removeFormatCurrency($presupuesto[$i]['julio']);
        $agosto     = $this->removeFormatCurrency($presupuesto[$i]['agosto']);
        $septiembre = $this->removeFormatCurrency($presupuesto[$i]['septiembre']);
        $octubre    = $this->removeFormatCurrency($presupuesto[$i]['octubre']);
        $noviembre  = $this->removeFormatCurrency($presupuesto[$i]['noviembre']);
        $diciembre  = $this->removeFormatCurrency($presupuesto[$i]['diciembre']);                                                                                                                                                              
        
        if(count($dataPresupuesto) > 0){
       
         $query = "UPDATE detalle_presupuesto SET 
                        enero      = $enero,
                        febrero    = $febrero,
                        marzo      = $marzo,
                        abril      = $abril,
                        mayo       = $mayo,
                        junio      = $junio,
                        julio      = $julio,
                        agosto     = $agosto,
                        septiembre = $septiembre,
                        octubre    = $octubre,
                        noviembre  = $noviembre,
                        diciembre  = $diciembre                                                                                                                         
                     WHERE presupuesto_id = $presupuesto_id AND puc_id = $puc_id";      
              
        }else{
            
              $detalle_presupuesto_id = $this ->  DbgetMaxConsecutive('detalle_presupuesto','detalle_presupuesto_id',$Conex,true,1);
            
              $query = "INSERT INTO detalle_presupuesto 
                         (detalle_presupuesto_id,
                          presupuesto_id,
                          puc_id,
                          enero,
                          febrero,
                          marzo,
                          abril,
                          mayo,
                          junio,
                          julio,
                          agosto,
                          septiembre,
                          octubre,
                          noviembre,
                          diciembre)
                         VALUES
                         ($detalle_presupuesto_id,
                          $presupuesto_id,
                          $puc_id,
                          $enero,
                          $febrero,
                          $marzo,
                          $abril,
                          $mayo,
                          $junio,
                          $julio,
                          $agosto,
                          $septiembre,
                          $octubre,
                          $noviembre,
                          $diciembre)";
            
         }
         
         $this -> query($query,$Conex);                           
        
     }    
    
  }
  
  public function Delete($detalle_presupuesto_id,$Conex){
  
   $delete = "DELETE FROM detalle_presupuesto WHERE detalle_presupuesto_id = $detalle_presupuesto_id";
   $this -> query($delete,$Conex);                              
  
  } 
  
}


?>