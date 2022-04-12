<?php
$hostname = "localhost";
$database = "siandsi_application_si";
$username = "siandsi_applisi";
$password = "w**i5hM+(1r)";

$site_link = mysql_connect($hostname, $username, $password) or trigger_error(mysqli_error()); 
mysql_select_db($database,$site_link);






			$select ="SELECT *
						FROM puc
						WHERE puc_puc_id NOT
						IN (
						
						SELECT puc_id
						FROM puc
						WHERE nivel =4
						)
						AND nivel =4
						";
			$select ="SELECT *
FROM `puc`
WHERE `puc_puc_id` =939987
						";	
						//echo $select;
					/*	$select ="SELECT * FROM manifiesto WHERE manifiesto
						IN (
							251567,219610,219604,251358
						)";*/
						
						
			$resultado= mysql_query($select) or die(mysqli_error());
			
			for($i = 0; $Row = mysqli_fetch_assoc($resultado); $i++){				
		      $data[$i] = $Row;
		    }

			
			foreach($data as $items){
				
				/*require_once("ManifiestosClass.php");
    			$manifiestos = new Manifiestos();
				*/
				
				/*$manifiesto_id = $items[manifiesto_id];
				$fecha_mc = $items[fecha_mc];
				
				$manifiestos -> getContabilizar($manifiesto_id,$fecha_mc);*/
				
				
				/*$query ="UPDATE cuenta_concepto_exogena SET puc_id = (SELECT puc_id FROM puc WHERE puc_puc_id = $items[puc_id] LIMIT 0,1) WHERE cuenta_concepto_exogena_id = $items[cuenta_concepto_exogena_id]";
				mysql_query($query)or die($query.mysqli_error());
				
				echo $query."<br><br>";
				
				$querty = "UPDATE item_factura_proveedor SET puc_id = (SELECT puc_id FROM puc WHERE puc_puc_id = $items[puc_id]) WHERE item_factura_proveedor_id = $items[item_factura_proveedor_id]";
				mysql_query($querty);
				*/
				
				//$puc_id = $this -> DbgetMaxConsecutive("puc","puc_id",$Conex,true,1);
				
				$puc_nuevo = $items[codigo_puc].'01';
				
				$query ="INSERT INTO puc 
				(puc_puc_id,empresa_id,codigo_puc,nombre,naturaleza,nivel,requiere_centro_costo,requiere_sucursal,requiere_tercero,codigo_dian,movimiento,corriente,estado)
				VALUES
				($items[puc_id],$items[empresa_id],$puc_nuevo,'$items[nombre]','$items[naturaleza]',5,$items[requiere_centro_costo],$items[requiere_sucursal],$items[requiere_tercero],'$items[codigo_dian]',$items[movimiento],$items[corriente],'$items[estado]')";
				echo $query;
				mysql_query($query)or die($query.mysqli_error());
				
				
				$query ="UPDATE puc SET requiere_centro_costo=0,requiere_sucursal=0,requiere_tercero=0,movimiento=0 WHERE puc_id =$items[puc_id] ";
				mysql_query($query)or die($query.mysqli_error());
				
				
			}
			
		 

?>