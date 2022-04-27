<?php

	require_once("../../../framework/clases/DbClass.php");
	require_once("../../../framework/clases/PermisosFormClass.php");

	final class ParametrosGuiaEncomiendaModel extends Db{

		private $Permisos;

		public function SetUsuarioId($usuario_id,$oficina_id){
			$this -> Permisos = new PermisosForm();
			$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
		}

		public function getPermiso($ActividadId,$Permiso,$Conex){
			return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
		}

		public function getServicio($Conex){
			$select = "SELECT tipo_bien_servicio_factura_id AS value, nombre_bien_servicio_factura AS text FROM  	tipo_bien_servicio_factura 	WHERE estado='D'";
			$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
			return $result;
		}
		
		public function GetFormaPago($Conex){
			$result = $this -> DbFetchAll("SELECT forma_pago_mensajeria_id AS value,nombre AS text FROM forma_pago_mensajeria WHERE forma_pago_mensajeria_id != 2 ORDER BY nombre ASC",$Conex,false);
			return $result;
		} 

		public function Save($Campos,$Conex){
			$valida = $this -> validaRangoCrm($Conex);
			if ($valida > 0) {
				exit("Ya hay un rango asignado para este CRM");
			}else{
				$data = $this ->getDisponibleRango($Conex);
				if (empty($data)) {
					$rango_guia_encomienda_id = $this -> DbgetMaxConsecutive("rango_guia_encomienda","rango_guia_encomienda_id",$Conex,true,1);
					$this -> assignValRequest('rango_guia_encomienda_id',$rango_guia_encomienda_id);
					$this -> DbInsertTable("rango_guia_encomienda",$Campos,$Conex,true,false);
					exit("$rango_guia_encomienda_id");
				}else{
					exit("Ya hay un rango con este inicio y este fin");
				}
			}
		}

		public function Update($Campos,$Conex){
			$this -> DbUpdateTable("rango_guia_encomienda",$Campos,$Conex,true,false);
		}

		public function Delete($Campos,$Conex){
			// $this -> DbDeleteTable("rango_guia_encomienda",$Campos,$Conex,true,false);
			$rango_guia_encomienda_id = $_REQUEST['rango_guia_encomienda_id'];
			$sql = "UPDATE rango_guia_encomienda SET estado ='I' WHERE rango_guia_encomienda_id = $rango_guia_encomienda_id";
			$result = $this -> query($sql,$Conex);
		}

		public function getCRM($usuario_id,$Conex){
			$select = "SELECT e.oficina_id AS value, e.nombre AS text FROM oficina e WHERE e.sucursal = 1";
			$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
			return $result;
		}

		public function getDisponibleRango($Conex){
			$rango_guia_encomienda_ini = $_REQUEST['rango_guia_encomienda_ini'];
			$rango_guia_encomienda_fin = $_REQUEST['rango_guia_encomienda_fin'];
			$oficina_id = $_REQUEST['oficina_id'];
			$tipo = $_REQUEST['tipo'];
			$sql = "SELECT rango_guia_encomienda_id FROM rango_guia_encomienda WHERE tipo='$tipo' AND  oficina_id=$oficina_id AND rango_guia_encomienda_ini BETWEEN $rango_guia_encomienda_ini AND $rango_guia_encomienda_fin AND rango_guia_encomienda_fin BETWEEN $rango_guia_encomienda_ini AND $rango_guia_encomienda_fin";
			// echo $sql;
			$result = $this -> DbFetchAll($sql,$Conex);
			return $result[0][rango_guia_encomienda_id];
		}

		public function validaRangoCrm($Conex){
			$oficina_id  = $this -> requestDataForQuery('oficina_id','integer');
			$tipo  = $this -> requestDataForQuery('tipo','text');
			
			$select = "SELECT rango_guia_encomienda_id FROM rango_guia_encomienda WHERE oficina_id=$oficina_id AND tipo=$tipo AND estado='A'";
			$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
			return count($result) > 0 ? $result[0]['rango_guia_encomienda_id'] : 0;
		}

		//BUSQUEDA
		public function selectRangoGuia($Conex){
			$rango_guia_encomienda_id = $this -> requestDataForQuery('rango_guia_encomienda_id','integer');
			$Query = "SELECT r.*, 
			(SELECT r.total_rango_guia-r.utilizado_rango_guia_encomienda) AS saldo_rango_guia, 
			(SELECT CONCAT(p.codigo_puc,' - ',p.nombre) FROM puc p WHERE p.puc_id=r.puc1) AS codigo_puc1, 
			(SELECT CONCAT(p.codigo_puc,' - ',p.nombre) FROM puc p WHERE p.puc_id=r.puc2) AS codigo_puc2,
			(SELECT CONCAT(p.codigo_puc,' - ',p.nombre) FROM puc p WHERE p.puc_id=r.puc_costo) AS codigo_puc3, 
			(SELECT CONCAT(p.codigo_puc,' - ',p.nombre) FROM puc p WHERE p.puc_id=r.puc_banco) AS codigo_puc4,
			(SELECT CONCAT_WS(' ', t.numero_identificacion,'-',t.razon_social,t.primer_nombre,t.primer_apellido) FROM tercero t WHERE t.tercero_id=r.tercero_id) AS tercero			
			
			FROM rango_guia_encomienda r WHERE rango_guia_encomienda_id = $rango_guia_encomienda_id";
			$result =  $this -> DbFetchAll($Query,$Conex);
			return $result;
		}

		//// GRID ////
		public function getQueryRangoGuiaGrid(){
			$Query = "SELECT 
				(SELECT o.nombre FROM oficina o WHERE r.oficina_id=o.oficina_id) AS oficina,
				r.prefijo,
				r.fecha_rango_guia,
				r.rango_guia_encomienda_ini,
				r.rango_guia_encomienda_fin,
				r.total_rango_guia,
				r.utilizado_rango_guia_encomienda,
				(r.total_rango_guia - r.utilizado_rango_guia_encomienda) AS saldo_rango_guia_encomienda,
				r.numero_resolucion,
				r.puc1,
				r.puc2,
				r.estado
			FROM rango_guia_encomienda r";
			// echo $Query;
			return $Query;
		}
	}
?>