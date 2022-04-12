<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetalleReportePresupuestoModel extends Db{

  public function movimientos($mes){
    return "(SELECT (CASE WHEN p.naturaleza = 'D' THEN SUM(debito-credito) ELSE SUM(credito-debito) END) AS m FROM imputacion_contable WHERE puc_id = p.puc_id AND encabezado_registro_id IN (SELECT encabezado_registro_id FROM encabezado_de_registro WHERE periodo_contable_id = pp.periodo_contable_id AND mes_contable_id IN (SELECT mes_contable_id FROM mes_contable WHERE mes = $mes AND periodo_contable_id = pp.periodo_contable_id)) GROUP BY puc_id)";
  }
 
  public function selectDetalleReportePresupuesto($presupuesto_id,$Conex){

    $cond_movimientos = "";
    $cond_movimientos .= $_REQUEST['enero'] == 'true' ?      " AND (".$this->movimientos('1').  " > 0 OR dp.enero      > 0)  " : "";
    $cond_movimientos .= $_REQUEST['febrero'] == 'true' ?    " AND (".$this->movimientos('2').  " > 0 OR dp.febrero    > 0)  " : "";
    $cond_movimientos .= $_REQUEST['marzo'] == 'true' ?      " AND (".$this->movimientos('3').  " > 0 OR dp.marzo      > 0)  " : "";
    $cond_movimientos .= $_REQUEST['abril'] == 'true' ?      " AND (".$this->movimientos('4').  " > 0 OR dp.abril      > 0)  " : "";
    $cond_movimientos .= $_REQUEST['mayo'] == 'true' ?       " AND (".$this->movimientos('5').  " > 0 OR dp.mayo       > 0)  " : "";
    $cond_movimientos .= $_REQUEST['junio'] == 'true' ?      " AND (".$this->movimientos('6').  " > 0 OR dp.junio      > 0)  " : "";
    $cond_movimientos .= $_REQUEST['julio'] == 'true' ?      " AND (".$this->movimientos('7').  " > 0 OR dp.julio      > 0)  " : "";
    $cond_movimientos .= $_REQUEST['agosto'] == 'true' ?     " AND (".$this->movimientos('8').  " > 0 OR dp.agosto     > 0)  " : "";
    $cond_movimientos .= $_REQUEST['septiembre'] == 'true' ? " AND (".$this->movimientos('9').  " > 0 OR dp.septiembre > 0)  " : "";
    $cond_movimientos .= $_REQUEST['octubre'] == 'true' ?    " AND (".$this->movimientos('10'). " > 0 OR dp.octubre    > 0)  " : "";
    $cond_movimientos .= $_REQUEST['noviembre'] == 'true' ?  " AND (".$this->movimientos('11'). " > 0 OR dp.noviembre  > 0)  " : "";
    $cond_movimientos .= $_REQUEST['diciembre'] == 'true' ?  " AND (".$this->movimientos('12'). " > 0 OR dp.diciembre  > 0)  " : ""; 
        
    $select = "SELECT (SELECT logo FROM empresa) AS logo,(SELECT p2.nombre FROM puc p2 WHERE p2.codigo_puc = SUBSTRING(a.codigo_puc, 1, 1)) AS titulo_total,a.codigo_puc,a.cuenta,SUM(a.p_enero) AS p_enero ,SUM(a.m_enero) AS m_enero ,SUM(a.dif_enero) AS dif_enero,SUM(a.pr_enero) AS pr_enero , 
    SUM(a.p_febrero) AS p_febrero ,SUM(a.m_febrero) AS m_febrero ,SUM(a.dif_febrero) AS dif_febrero ,SUM(a.pr_febrero) AS pr_febrero ,
    SUM(a.p_marzo) AS p_marzo ,SUM(a.m_marzo) AS m_marzo  ,SUM(a.dif_marzo) AS  dif_marzo,
    SUM(a.p_abril) AS  p_abril,SUM(a.m_abril) AS m_abril, SUM(a.dif_abril) AS  dif_abril,
    SUM(a.p_mayo) AS p_mayo, SUM(a.m_mayo) AS m_mayo, SUM(a.dif_mayo) AS dif_mayo ,SUM(a.pr_mayo) AS  pr_mayo,
    SUM(a.p_junio) AS  p_junio,SUM(a.m_junio) AS m_junio ,SUM(a.dif_junio) AS  dif_junio,SUM(a.pr_junio) AS  pr_junio,
    SUM(a.p_julio) AS  p_julio,SUM(a.m_julio) AS m_julio ,SUM(a.dif_julio) AS dif_julio, SUM(a.pr_julio) AS pr_julio,
    SUM(a.p_agosto) AS  p_agosto, SUM(a.m_agosto) AS m_agosto, SUM(a.dif_agosto) AS dif_agosto, SUM(a.pr_agosto) AS pr_agosto,
    SUM(a.p_septiembre) AS p_septiembre, SUM(a.m_septiembre) AS m_septiembre, SUM(a.dif_septiembre) AS dif_septiembre, SUM(a.pr_septiembre) AS  pr_septiembre,
    SUM(a.p_octubre) AS  p_octubre,SUM(a.m_octubre) AS m_octubre, SUM(a.dif_octubre) AS dif_octubre, SUM(a.pr_octubre) AS pr_octubre,
    SUM(a.p_noviembre) AS p_noviembre, SUM(a.m_noviembre) AS m_noviembre, SUM(a.dif_noviembre) AS dif_noviembre, SUM(a.pr_noviembre) AS pr_noviembre,
    SUM(a.p_diciembre) AS  p_diciembre,SUM(a.m_diciembre) AS m_diciembre,SUM(a.dif_diciembre) AS  dif_diciembre,SUM(a.pr_diciembre) AS pr_diciembre

    FROM (SELECT 
    t.codigo_puc,t.cuenta,
    t.p_enero,t.m_enero,
    ABS(ABS(IFNULL(t.p_enero,0))-ABS(IFNULL(t.m_enero,0))) AS dif_enero,
    round((t.m_enero*100)/t.p_enero) AS pr_enero,         
    t.p_febrero,t.m_febrero,
    ABS(ABS(IFNULL(t.p_febrero,0))-ABS(IFNULL(t.m_febrero,0))) AS dif_febrero,
    round((t.m_febrero*100)/t.p_febrero) AS pr_febrero,
    t.p_marzo,t.m_marzo,
    ABS(ABS(IFNULL(t.p_marzo,0))-ABS(IFNULL(t.m_marzo,0))) AS dif_marzo,
    round((t.m_marzo*100)/t.p_marzo) AS p_marzo1,
    t.p_abril,t.m_abril,
    ABS(ABS(IFNULL(t.p_abril,0))-ABS(IFNULL(t.m_abril,0))) AS dif_abril,
    round((t.m_abril*100)/t.p_abril) AS p_abril1,         
    t.p_mayo,t.m_mayo,
    ABS(ABS(IFNULL(t.p_mayo,0))-ABS(IFNULL(t.m_mayo,0))) AS dif_mayo,
    round((t.m_mayo*100)/t.p_mayo) AS pr_mayo,
    t.p_junio,t.m_junio,
    ABS(ABS(IFNULL(t.p_junio,0))-ABS(IFNULL(t.m_junio,0))) AS dif_junio,
    round((t.m_junio*100)/t.p_junio) AS pr_junio,
    t.p_julio,t.m_julio,
    ABS(ABS(IFNULL(t.p_julio,0))-ABS(IFNULL(t.m_julio,0))) AS dif_julio,
    round((t.m_julio*100)/t.p_julio) AS pr_julio,         
    t.p_agosto,t.m_agosto,
    ABS(ABS(IFNULL(t.p_agosto,0))-ABS(IFNULL(t.m_agosto,0))) AS dif_agosto,
    round((t.m_agosto*100)/t.p_agosto) AS pr_agosto,
    t.p_septiembre,t.m_septiembre,
    ABS(ABS(IFNULL(t.p_septiembre,0))-ABS(IFNULL(t.m_septiembre,0))) AS dif_septiembre,
    round((t.m_septiembre*100)/t.p_septiembre) AS pr_septiembre,          
    t.p_octubre,t.m_octubre,
    ABS(ABS(IFNULL(t.p_octubre,0))-ABS(IFNULL(t.m_octubre,0))) AS dif_octubre,
    round((t.m_octubre*100)/t.p_octubre) AS pr_octubre,
    t.p_noviembre,t.m_noviembre,
    ABS(ABS(IFNULL(t.p_noviembre,0))-ABS(IFNULL(t.m_noviembre,0))) AS dif_noviembre,
    round((t.m_noviembre*100)/t.p_noviembre) AS pr_noviembre,          
    t.p_diciembre,t.m_diciembre,
    ABS(ABS(IFNULL(t.p_diciembre,0))-ABS(IFNULL(t.m_diciembre,0))) AS dif_diciembre,
    round((t.m_diciembre*100)/t.p_diciembre) AS pr_diciembre
    FROM 
   (SELECT (SELECT logo FROM empresa) AS logo,(SELECT p2.nombre FROM puc p2 WHERE p2.codigo_puc = SUBSTRING(p.codigo_puc, 1, 1)) AS titulo_total,p.codigo_puc,p.nombre AS cuenta,dp.enero AS p_enero,
   ".$this->movimientos('1')."  AS m_enero,
   dp.febrero AS p_febrero,
   ".$this->movimientos('2'). " AS m_febrero,    
   dp.marzo AS p_marzo,
   ".$this->movimientos('3')." AS m_marzo,    
   dp.abril AS p_abril,
   ".$this->movimientos('4')." AS m_abril,  
   dp.mayo AS p_mayo,
   ".$this->movimientos('5')." AS m_mayo,        		
   dp.junio AS p_junio,
   ".$this->movimientos('6')." AS m_junio,        		
   dp.julio AS p_julio,
   ".$this->movimientos('7')." AS m_julio,   
   dp.agosto AS p_agosto,
   ".$this->movimientos('8')." AS m_agosto,     
   dp.septiembre AS p_septiembre,
   ".$this->movimientos('9')." AS m_septiembre,    
   dp.octubre AS p_octubre,
   ".$this->movimientos('10')." AS m_octubre,        		
   dp.noviembre AS p_noviembre,
   ".$this->movimientos('111')." AS m_noviembre,    
   dp.diciembre AS p_diciembre,
   ".$this->movimientos('12')." AS m_diciembre
   FROM presupuesto pp,detalle_presupuesto dp,puc p 
   WHERE 
   pp.presupuesto_id = $presupuesto_id AND pp.presupuesto_id = dp.presupuesto_id 
   AND dp.puc_id = p.puc_id $cond_movimientos) AS t) as a 
   GROUP BY SUBSTR(a.codigo_puc,1,1),a.codigo_puc WITH ROLLUP";       
    
   $result = $this -> DbFetchAll($select,$Conex,true);    
    
   return $result;               
    
  } 
  
}

?>