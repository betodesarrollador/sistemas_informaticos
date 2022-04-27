<?php
require_once "../../../framework/clases/DbClass.php";
require_once "../../../framework/clases/PermisosFormClass.php";
final class DetallesParametrosModel extends Db
{
    private $Permisos;

    public function getTipo($formato_exogena_id, $puc_id, $Conex)
    {

        if ($formato_exogena_id != '') {

            $select = "SELECT tipo_formato FROM formato_exogena WHERE formato_exogena_id=$formato_exogena_id";

            $result = $this->DbFetchAll($select, $Conex, true);

            return $result[0]['tipo_formato'];
        }

        if ($puc_id != '') {

            $select = "SELECT tipo_formato FROM formato_exogena f, cuenta_exogena c
                       WHERE f.formato_exogena_id=c.formato_exogena_id AND c.puc_id = $puc_id";

            $result = $this->DbFetchAll($select, $Conex, true);

            return $result[0]['tipo_formato'];
        }
    }

    public function getCentro($Conex)
    {
        $select = "SELECT centro_de_costo_id AS value,  CONCAT(codigo,'-',nombre) AS text FROM centro_de_costo";

        $result = $this->DbFetchAll($select, $Conex, true);

        return $result;
    }
    
    public function setInsertDetalleExogena($camposArchivo,$formato_exogena_id,$Conex){

        /* Posiciones del array
        [0] => CTA_PUC
        [1] => CATEGORIA_EXOGENA
        [2] => BASE_CATEGORIA_EXOGENA
        [3] => CONCEPTO_EXOGENA
        [4] => TIPO_SUMATORIA
        [5] => CENTRO_COSTO
        [6] => ESTADO
        */
    
        foreach($camposArchivo as $valor){
            
            if($valor[0]!='CTA_PUC'){
            
                $cuenta_exogena_id = $this -> DbgetMaxConsecutive("cuenta_exogena","cuenta_exogena_id",$Conex,false,1);
               
                $codigo_puc	            = trim($valor[0]);
                $categoria_exogena	    = trim($valor[1]);
                $base_categoria_exogena	= trim($valor[2]);
                $concepto_exogena 	    = trim($valor[3]);
                $tipo_sumatoria         = strtoupper(trim($valor[4]));
                $centro_costo	        = trim($valor[5]);
                $estado		            = trim($valor[6]);
             
    
                if($valor[0] != ''){
                    
                    $bandera = true;
                    $mensaje = "";
                    
                    //validacion para categoria
                    $select ="SELECT categoria_exogena_id FROM categoria_exogena WHERE codigo     = '$categoria_exogena'";
                    $result = $this->DbFetchAll($select, $Conex,true);
                    $categoria_exogena_id = $result[0]['categoria_exogena_id'];
                    
                    if($categoria_exogena_id ==''){
                        $bandera = false;
                       $mensaje .= '<br>Codigo de categoria exogena invalido : <b>'.$categoria_exogena.'.</b> Por favor verifique que el codigo se encuentre parametrizado';
                    }
                    
                    
                    //validacion para base categoria
                    
                    $base_categoria_exogena_id ='null';
                    
                    if($base_categoria_exogena!=''){
                        
                        $select ="SELECT categoria_exogena_id FROM categoria_exogena WHERE codigo     = '$base_categoria_exogena'";
                        $result = $this->DbFetchAll($select, $Conex,true);
                        $base_categoria_exogena_id = $result[0]['categoria_exogena_id'];
                        
                        if($base_categoria_exogena_id ==''){
                            $bandera = false;
                           $mensaje .= '<br>Codigo de base categoria exogena invalido : <b>'.$base_categoria_exogena.'.</b> Por favor verifique que el codigo se encuentre parametrizado';
                        }
                    }
                    
                     //validacion para concepto
                    $select ="SELECT concepto_exogena_id  FROM concepto_exogena  WHERE codigo     = '$concepto_exogena'";
                    $result = $this->DbFetchAll($select, $Conex,true);
                    
                    $concepto_exogena_id = $result[0]['concepto_exogena_id'];
                    
                    if($concepto_exogena_id ==''){
                        $bandera = false;
                       $mensaje .= '<br>Codigo de concepto exogena invalido : <b>'.$concepto_exogena.'</b>. Por favor verifique que el codigo se encuentre parametrizado';
                    }
                    
                     //validacion para puc
                    $select ="SELECT puc_id FROM puc WHERE codigo_puc = '$codigo_puc'";
                    $result = $this->DbFetchAll($select, $Conex,true);
                    
                    $puc_id = $result[0]['puc_id'];
                    
                    if($puc_id ==''){
                        $bandera = false;
                       $mensaje .= '<br>Codigo puc invalido : <b>'.$codigo_puc.'</b>. Por favor verifique que el codigo se encuentre parametrizado';
                    }
                    
                     //validacion para tipo sumatoria
                     
                     $array[0]['tipo_sumatoria'] = "SDP";
                     $array[1]['tipo_sumatoria'] = "SCP";
                     $array[2]['tipo_sumatoria'] = "DCP";
                     $array[3]['tipo_sumatoria'] = "CDP";
                     $array[4]['tipo_sumatoria'] = "SCC";
                     $array[5]['tipo_sumatoria'] = "DCC";
                     $array[6]['tipo_sumatoria'] = "CDC";
                     
                     if(array_search($tipo_sumatoria, array_column($array, 'tipo_sumatoria')) === false) {

                        $bandera = false;
                        $mensaje .= "<br>Codigo de 'tipo de sumatoria' invalido : <b>".$tipo_sumatoria."</b>. Por favor verifique que el codigo sea correcto";
                       
                       }
                     
                     //validacion para centro de costo
                     
                     $centro_de_costo_id = 'null';
                     
                     if($centro_costo != ''){
                         
                         $select ="SELECT centro_de_costo_id   FROM centro_de_costo   WHERE codigo  = '$centro_costo'";
                         $result = $this->DbFetchAll($select, $Conex,true);
                         
                         $centro_de_costo_id = $result[0]['centro_de_costo_id'];
                         
                         if($centro_de_costo_id == ''){
                            
                            $bandera = false;
                            $mensaje .= '<br>Codigo de centro de costo : <b>'.$centro_costo.'</b>. Por favor verifique que el codigo se encuentre parametrizado';
                            
                         }
                         
                     }
                     
                     
                      //validacion para estado
                      
                      if($estado != 'A' && $estado != 'I' && $estado != 'a' && $estado != 'i'){
                        $bandera = false;
                        $mensaje .= '<br>Codigo de estado incorrecto: <b>'.$estado.'</b>. Por favor digite un estado correcto (A/I)';
                      }
                      
                    
                     if($bandera){
                         
                        //validacion para existencia de registros
                        
                        $consul_centro_costo = $centro_de_costo_id == 'null' ? ' AND 
                        centro_de_costo_id IS NULL ' : " AND centro_de_costo_id = $centro_de_costo_id ";
                        
                        $consul_base_categoria = $base_categoria_exogena_id == 'null' ? ' AND 
                        base_categoria_exogena_id IS NULL ' : " AND base_categoria_exogena_id = $base_categoria_exogena_id ";
                        
                        $select ="SELECT * FROM cuenta_exogena  WHERE
                        formato_exogena_id        =  $formato_exogena_id AND
                        categoria_exogena_id      =  $categoria_exogena_id
                        $consul_base_categoria AND
                        concepto_exogena_id       =  $concepto_exogena_id AND
                        tipo_sumatoria            = '$tipo_sumatoria' 
                        $consul_centro_costo   AND
                        puc_id                    =  $puc_id";
                        
                        $result = $this->DbFetchAll($select, $Conex,true);
                        
                        if(count($result) == 0){
                            
                        $insert = "INSERT INTO cuenta_exogena(cuenta_exogena_id, formato_exogena_id, categoria_exogena_id,base_categoria_exogena_id, concepto_exogena_id, puc_id, tipo_sumatoria, centro_de_costo_id, estado) VALUES 
                        ($cuenta_exogena_id,$formato_exogena_id,$categoria_exogena_id,$base_categoria_exogena_id,$concepto_exogena_id,$puc_id,'$tipo_sumatoria',
                        $centro_de_costo_id,'$estado')";
                        
                        $this -> query($insert,$Conex,true);
                        
                        }
                         
                     
                    }
    
    
                }
            }
        } 
        
        if(strlen($mensaje)>0){
            exit("Errores encontrados : <br><br> ".$mensaje);
        }else{
            exit("true");
        }
        
     }

         public function setInsertDetalleExogenaPC($camposArchivo,$puc_id,$Conex){
    
        foreach($camposArchivo as $valor){
            
            if($valor[0]!='TIPO_FORMATO'){
            
                $cuenta_exogena_id = $this -> DbgetMaxConsecutive("cuenta_exogena","cuenta_exogena_id",$Conex,false,1);
               
                $tipo_formato	        = trim($valor[0]);
                $categoria_exogena	    = trim($valor[1]);
                $base_categoria_exogena	= trim($valor[2]);
                $concepto_exogena 	    = trim($valor[3]);
                $tipo_sumatoria         = strtoupper(trim($valor[4]));
                $centro_costo	        = trim($valor[5]);
                $estado		            = trim($valor[6]);
                
    
                if($valor[0] != ''){
                    
                    $bandera = true;
                    $mensaje = "";
                    
                    //validacion para categoria
                    $select ="SELECT categoria_exogena_id FROM categoria_exogena WHERE codigo  = '$categoria_exogena'";
                    $result = $this->DbFetchAll($select, $Conex,true);
                    $categoria_exogena_id = $result[0]['categoria_exogena_id'];
                    
                    if($categoria_exogena_id ==''){
                        $bandera = false;
                       $mensaje .= '<br>Codigo de categoria exogena invalido : <b>'.$categoria_exogena.'.</b> Por favor verifique que el codigo se encuentre parametrizado';
                    }
                    
                    //validacion para base categoria
                    
                    $base_categoria_exogena_id ='null';
                    
                    if($base_categoria_exogena!=''){
                        
                        $select ="SELECT categoria_exogena_id FROM categoria_exogena WHERE codigo     = '$base_categoria_exogena'";
                        $result = $this->DbFetchAll($select, $Conex,true);
                        $base_categoria_exogena_id = $result[0]['categoria_exogena_id'];
                        
                        if($base_categoria_exogena_id ==''){
                            $bandera = false;
                           $mensaje .= '<br>Codigo de base categoria exogena invalido : <b>'.$base_categoria_exogena.'.</b> Por favor verifique que el codigo se encuentre parametrizado';
                        }
                    }
                    
                     //validacion para concepto
                    $select ="SELECT concepto_exogena_id  FROM concepto_exogena  WHERE codigo  = '$concepto_exogena'";
                    $result = $this->DbFetchAll($select, $Conex,true);
                    
                    $concepto_exogena_id = $result[0]['concepto_exogena_id'];
                    
                    if($concepto_exogena_id ==''){
                        $bandera = false;
                       $mensaje .= '<br>Codigo de concepto exogena invalido : <b>'.$concepto_exogena.'</b>. Por favor verifique que el codigo se encuentre parametrizado';
                    }
                    
                     //validacion para tipo formato
                    $select ="SELECT formato_exogena_id FROM formato_exogena WHERE tipo_formato = '$tipo_formato'";
                    $result = $this->DbFetchAll($select, $Conex,true);
                    
                    $formato_exogena_id = $result[0]['formato_exogena_id'];
                    
                    if($formato_exogena_id ==''){
                        $bandera = false;
                        $mensaje .= '<br>Tipo Formato invalido : <b>'.$tipo_formato.'</b>. Por favor verifique que el tipo formato se encuentre parametrizado';
                    }
                    
                     //validacion para tipo sumatoria
                     
                     $array[0]['tipo_sumatoria'] = "SDP";
                     $array[1]['tipo_sumatoria'] = "SCP";
                     $array[2]['tipo_sumatoria'] = "DCP";
                     $array[3]['tipo_sumatoria'] = "CDP";
                     $array[4]['tipo_sumatoria'] = "SCC";
                     $array[5]['tipo_sumatoria'] = "DCC";
                     $array[6]['tipo_sumatoria'] = "CDC";
                     
                     if(array_search($tipo_sumatoria, array_column($array, 'tipo_sumatoria')) === false) {

                        $bandera = false;
                        $mensaje .= "<br>Codigo de 'tipo de sumatoria' invalido : <b>".$tipo_sumatoria."</b>. Por favor verifique que el codigo sea correcto";
                       
                       }
                     
                     //validacion para centro de costo
                     
                     $centro_de_costo_id = 'null';
                     
                     if($centro_costo != ''){
                         
                         $select ="SELECT centro_de_costo_id   FROM centro_de_costo   WHERE codigo  = '$centro_costo'";
                         $result = $this->DbFetchAll($select, $Conex,true);
                         
                         $centro_de_costo_id = $result[0]['centro_de_costo_id'];
                         
                         if($centro_de_costo_id == ''){
                            
                            $bandera = false;
                            $mensaje .= '<br>Codigo de centro de costo : <b>'.$centro_costo.'</b>. Por favor verifique que el codigo se encuentre parametrizado';
                            
                         }
                         
                     }
                     
                     
                      //validacion para estado
                      
                      if($estado != 'A' && $estado != 'I' && $estado != 'a' && $estado != 'i'){
                        $bandera = false;
                        $mensaje .= '<br>Codigo de estado incorrecto: <b>'.$estado.'</b>. Por favor digite un estado correcto (A/I)';
                      }
                      
                    
                      if($bandera){
                         
                        //validacion para existencia de registros
                        
                        $consul_centro_costo = $centro_de_costo_id == 'null' ? ' AND 
                        centro_de_costo_id IS NULL ' : " AND centro_de_costo_id = $centro_de_costo_id ";
                        
                        $consul_base_categoria = $base_categoria_exogena_id == 'null' ? ' AND 
                        base_categoria_exogena_id IS NULL ' : " AND base_categoria_exogena_id = $base_categoria_exogena_id ";
                        
                        $select ="SELECT * FROM cuenta_exogena  WHERE
                        formato_exogena_id        =  $formato_exogena_id AND
                        categoria_exogena_id      =  $categoria_exogena_id
                        $consul_base_categoria AND
                        concepto_exogena_id       =  $concepto_exogena_id AND
                        tipo_sumatoria            = '$tipo_sumatoria' 
                        $consul_centro_costo   AND
                        puc_id                    =  $puc_id";
                        
                        $result = $this->DbFetchAll($select, $Conex,true);
                        
                        if(count($result) == 0){
                            
                        $insert = "INSERT INTO cuenta_exogena(cuenta_exogena_id, formato_exogena_id, categoria_exogena_id,base_categoria_exogena_id, concepto_exogena_id, puc_id, tipo_sumatoria, centro_de_costo_id, estado) VALUES 
                        ($cuenta_exogena_id,$formato_exogena_id,$categoria_exogena_id,$base_categoria_exogena_id,$concepto_exogena_id,$puc_id,'$tipo_sumatoria',
                        $centro_de_costo_id,'$estado')";
                        
                        $this -> query($insert,$Conex,true);
                        
                        }
                         
                     
                    }
    
    
                }
            }
        } 
        
        if(strlen($mensaje)>0){
            exit("Errores encontrados : <br><br> ".$mensaje);
        }else{
            exit("true");
        }
        
     }
    
    public function getDetallesExcel($formato_exogena_id,$Conex){
        
        $select = "SELECT p.codigo_puc AS CTA_PUC, ce.codigo AS CATEGORIA_EXOGENA,
       
                (SELECT bc.codigo FROM categoria_exogena bc WHERE bc.categoria_exogena_id=c.base_categoria_exogena_id) AS BASE_CATEGORIA_EXOGENA, co.codigo AS CONCEPTO_EXOGENA, c.tipo_sumatoria AS TIPO_SUMATORIA,
        
                (SELECT cc.codigo FROM centro_de_costo cc WHERE cc.centro_de_costo_id = c.centro_de_costo_id) AS CENTRO_COSTO,
        
                c.estado AS ESTADO

        FROM cuenta_exogena c, puc p, categoria_exogena ce, concepto_exogena co WHERE p.puc_id= c.puc_id AND  ce.categoria_exogena_id = c.categoria_exogena_id AND co.concepto_exogena_id=c.concepto_exogena_id AND c.formato_exogena_id =$formato_exogena_id";

        $result = $this->DbFetchAll($select, $Conex,true);

        if(count($result)==0){
           $select="SELECT ''AS CTA_PUC, ''AS CATEGORIA_EXOGENA,''AS BASE_CATEGORIA_EXOGENA, ''AS CONCEPTO_EXOGENA, ''AS TIPO_SUMATORIA, ''AS CENTRO_COSTO,''AS ESTADO";
           $result = $this->DbFetchAll($select, $Conex,true);
        }

        return $result;
        
    }

    public function getDetallesExcelPC($puc_id,$Conex){
        
        $select = "SELECT f.tipo_formato AS FORMATO,
        
                   ce.codigo AS CATEGORIA_EXOGENA,
                  
                   (SELECT bc.codigo FROM categoria_exogena bc WHERE bc.categoria_exogena_id=c.base_categoria_exogena_id) AS BASE_CATEGORIA_EXOGENA,
                  
                   co.codigo AS CONCEPTO_EXOGENA,
                  
                   c.tipo_sumatoria AS TIPO_SUMATORIA,
        
                   (SELECT cc.codigo FROM centro_de_costo cc WHERE cc.centro_de_costo_id = c.centro_de_costo_id) AS CENTRO_COSTO,
        
                   c.estado AS ESTADO

                  FROM cuenta_exogena c, formato_exogena f, categoria_exogena ce, concepto_exogena co WHERE ce.categoria_exogena_id = c.categoria_exogena_id AND co.concepto_exogena_id=c.concepto_exogena_id AND f.formato_exogena_id = c.formato_exogena_id AND c.puc_id=$puc_id";

        $result = $this->DbFetchAll($select, $Conex,true);

        if(count($result)==0){
           $select="SELECT ''AS FORMATO, ''AS CATEGORIA_EXOGENA,''AS BASE_CATEGORIA_EXOGENA, ''AS CONCEPTO_EXOGENA, ''AS TIPO_SUMATORIA, ''AS CENTRO_COSTO,''AS ESTADO";
           $result = $this->DbFetchAll($select, $Conex,true);
        }

        return $result;
        
    }
    

    public function getDetalles($formato_exogena_id, $puc_id, $Conex)
    {
        if ($formato_exogena_id != '') {
            if (is_numeric($formato_exogena_id)) {

                $select = "SELECT c.cuenta_exogena_id,
                                c.formato_exogena_id,
                                c.tipo_sumatoria,
                                c.estado,
                                (SELECT UPPER(CONCAT_WS('-',bc.codigo,bc.descripcion)) FROM categoria_exogena bc WHERE bc.categoria_exogena_id=c.base_categoria_exogena_id) AS base_categoria_exogena,
                                c.base_categoria_exogena_id,
                                CONCAT_WS('-',p.codigo_puc,p.nombre) AS codigo_puc,
                                p.puc_id,
                                c.categoria_exogena_id,
                                UPPER(CONCAT_WS('-',ce.codigo,ce.descripcion)) AS categoria_exogena,
                                (SELECT cc.centro_de_costo_id FROM centro_de_costo cc WHERE cc.centro_de_costo_id = c.centro_de_costo_id) AS centro_de_costo_id,
                                c.concepto_exogena_id,
                                UPPER(CONCAT_WS('-',co.codigo,co.nombre)) AS concepto_exogena

                    FROM cuenta_exogena c, puc p, categoria_exogena ce, concepto_exogena co WHERE p.puc_id= c.puc_id AND  ce.categoria_exogena_id = c.categoria_exogena_id AND co.concepto_exogena_id=c.concepto_exogena_id AND c.formato_exogena_id =$formato_exogena_id";

                $result = $this->DbFetchAll($select, $Conex,true);

            } else {
                $result = array();
            }
        }

        if ($puc_id != '') {
            if (is_numeric($puc_id)) {

                $select = "SELECT c.cuenta_exogena_id,
                                f.formato_exogena_id,
                                c.tipo_sumatoria,
                                c.estado,
                                f.tipo_formato AS formato,
                                (SELECT UPPER(CONCAT_WS('-',bc.codigo,bc.descripcion)) FROM categoria_exogena bc WHERE bc.categoria_exogena_id=c.base_categoria_exogena_id) AS base_categoria_exogena,
                                c.base_categoria_exogena_id,
                                c.puc_id,
                                c.categoria_exogena_id,
                                UPPER(CONCAT_WS('-',ce.codigo,ce.descripcion)) AS categoria_exogena,
                                (SELECT cc.centro_de_costo_id FROM centro_de_costo cc WHERE cc.centro_de_costo_id = c.centro_de_costo_id) AS centro_de_costo_id,
                                c.concepto_exogena_id,
                                UPPER(CONCAT_WS('-',co.codigo,co.nombre)) AS concepto_exogena

                    FROM cuenta_exogena c, formato_exogena f, categoria_exogena ce, concepto_exogena co WHERE ce.categoria_exogena_id = c.categoria_exogena_id AND co.concepto_exogena_id=c.concepto_exogena_id AND f.formato_exogena_id = c.formato_exogena_id AND c.puc_id=$puc_id";

                $result = $this->DbFetchAll($select, $Conex,true);

            } else {
                $result = array();
            }
        }
        return $result;
    }

    public function Save($Campos, $Conex)
    {

        $this->Begin($Conex);

        $cuenta_exogena_id          = $this->DbgetMaxConsecutive("cuenta_exogena", "cuenta_exogena_id", $Conex, true, 1);
        $formato_exogena_id         = $this->requestDataForQuery('formato_exogena_id', 'integer');
        $categoria_exogena_id       = $this->requestDataForQuery('categoria_exogena_id', 'integer');
        $base_categoria_exogena_id  = $this->requestDataForQuery('base_categoria_exogena_id', 'integer');
        $concepto_exogena_id        = $this->requestDataForQuery('concepto_exogena_id', 'integer');
        $puc_id                     = $this->requestDataForQuery('puc_id', 'integer');
        $tipo_sumatoria             = $this->requestDataForQuery('tipo_sumatoria', 'text');
        $centro_de_costo_id         = $this->requestDataForQuery('centro_de_costo_id', 'integer');
        $estado                     = $this->requestDataForQuery('estado', 'text');

        $insert = "INSERT INTO cuenta_exogena(cuenta_exogena_id, formato_exogena_id, categoria_exogena_id, base_categoria_exogena_id,concepto_exogena_id, puc_id, tipo_sumatoria, centro_de_costo_id,estado) VALUES
		($cuenta_exogena_id,$formato_exogena_id,$categoria_exogena_id,$base_categoria_exogena_id,$concepto_exogena_id,$puc_id,$tipo_sumatoria,$centro_de_costo_id,$estado)";
       
        $this->query($insert, $Conex, true);

        $this->Commit($Conex);
        return $cuenta_exogena_id;

    }
    
    public function Update($Campos, $Conex)
    {

        $this->Begin($Conex);

        $cuenta_exogena_id          = $this->requestDataForQuery('cuenta_exogena_id', 'integer');
        $categoria_exogena_id       = $this->requestDataForQuery('categoria_exogena_id', 'integer');
        $base_categoria_exogena_id  = $this->requestDataForQuery('base_categoria_exogena_id', 'integer');
        $concepto_exogena_id        = $this->requestDataForQuery('concepto_exogena_id', 'integer');
        $formato_exogena_id         = $this->requestDataForQuery('formato_exogena_id', 'integer');
        $puc_id                     = $this->requestDataForQuery('puc_id', 'integer');
        $tipo_sumatoria             = $this->requestDataForQuery('tipo_sumatoria', 'text');
        $centro_de_costo_id         = $this->requestDataForQuery('centro_de_costo_id', 'integer');
        $estado                     = $this->requestDataForQuery('estado', 'text');

        $update = "UPDATE cuenta_exogena SET

		categoria_exogena_id 	 = $categoria_exogena_id,
        base_categoria_exogena_id= $base_categoria_exogena_id,
		concepto_exogena_id  	 = $concepto_exogena_id,
        formato_exogena_id	     = $formato_exogena_id,
		puc_id				  	 = $puc_id,
		tipo_sumatoria		  	 = $tipo_sumatoria,
		centro_de_costo_id	  	 = $centro_de_costo_id,
		estado				     = $estado
        WHERE cuenta_exogena_id = $cuenta_exogena_id";
        
        $this->query($update, $Conex, true);

        $this->Commit($Conex);

    }

    public function Delete($Campos, $Conex)
    {

        $cuenta_exogena_id = $this->requestDataForQuery('cuenta_exogena_id', 'integer');

        $delete = "DELETE FROM cuenta_exogena WHERE cuenta_exogena_id=$cuenta_exogena_id ";

        $this->query($delete, $Conex, true);

    }
}
