
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <link rel="stylesheet" href="sistemas_informaticos/framework/css/bootstrap.css">
  <link rel="stylesheet" href="sistemas_informaticos/framework/css/animate.css">
 <link rel="stylesheet" href="sistemas_informaticos/bodega/reportes/css/ReporteSeguimientoProductoResult.css"> 
</head>

	
<page orientation="portrait" >
 
  {* {if $PRODUCTO neq ''}
  <div class="container-fluid">
    <div class="row animated zoomIn">
      <div class="col-sm"></div>
      <div class="col-sm-10">
        <div style="margin: 25% auto;width: 80%; border: #ebccd1 solid;border-radius: 0.5em;">
          <div class="panel-heading" style="color:#b94a48;background-color:#f2dede;border-radius: 0.5em;">
            <h3 class="panel-title">¡ATENCI&Oacute;N!</h3>
          </div>
          <div class="panel-body">
            <h6 style="font-weight: bold; color: black; text-align: center;">ESTA PERSONA NO CUENTA CON UN CONTRATO REALIZADO, POR FAVOR VERIFIQUE CON OTRO TERCERO.</h6>
          </div>
        </div>
      </div>
      <div class="col-sm"></div>
    </div>
  </div>
  {else} *}
 

  <div class="container-fluid">
    <div class="row animated zoomIn">
      <div class="col-sm"></div>
      <div class="col-sm-10">

        <!-- Datos principales-->
        {if $PRODUCTO[0].datos_principales|@count > 0}
         <table style="width: 100%;">

          <thead class="thead">
            <th style="text-align: center; font-size:19px; font-family: 'Courier New', Courier, monospace;" colspan="5">Producto</th>
         </thead>

          <thead class="thead">

            <th  style="border: none; text-align:center;" colspan="5"><div class="animated flash">{if $PRODUCTO[0].datos_principales[0].imagen eq ''}<img src="../../../framework/media/images/general/sin_producto.jpg" width="190" height="140" />{else} <img src="{$PRODUCTO[0].datos_principales[0].imagen}" width="190" height="140" /> {/if}</div></th>
           
          </thead>

           <tr>
           <td><br></td>
          </tr>
      
          <tbody class="table table-striped table-hover table-sm table-bordered">
       
            <tr style="background-color: #e6eee3;">
              <td width="25%" style="text-align : center"><b>Producto</b></td>
              <td width="25%" style="text-align : center"><b>Serial N°</b></td>
              <td width="25%" style="text-align : center"><b>Codigo de barra</b></td>
              <td width="25%" style="text-align : center"><b>Estado actual</b></td>
            </tr>
            <tr>
              <td width="25%" style="text-align : center">{$PRODUCTO[0].datos_principales[0].producto}</td>
              <td width="25%" style="text-align : center">{$PRODUCTO[0].datos_principales[0].serial}</td>
              <td width="25%" style="text-align : center">{$PRODUCTO[0].datos_principales[0].codigo_barra}</td>
              <td width="25%" style="text-align : center">{$PRODUCTO[0].datos_principales[0].estado}</td>
            </tr>
          
          </tbody>
        </table>
        {/if}

          <!--Enturnamiento-->

        <br><br>
        {if $PRODUCTO[0].datos_enturnamiento|@count > 0}
         <table  style="width: 100%;" class="table table-striped table-hover table-sm table-bordered">
          <thead class="thead">
            <th style="text-align: center; font-size:19px; font-family: 'Courier New', Courier, monospace;" colspan="5">Enturnamiento</th>
         </thead>
         <thead>
            <th style="text-align: center;" colspan="5"><div class="animated flash">{if $PRODUCTO[0].datos_enturnamiento[0].imagen eq ''}<img src="../../../framework/media/images/general/sin_vehiculo.png " width="190" height="140" />{else} <img src="{$PRODUCTO[0].datos_enturnamiento[0].imagen}" width="190" height="140" /> {/if}</div></th>
          </thead>

          <tbody>
         
            <tr style="background-color: #e6eee3;">
            <td width="30%" style="text-align : center"><b>Placa</b></td>
            <td width="5%" style="text-align : center"><b>N° Turno</b></td>
            <td width="15%" style="text-align : center"><b>Conductor</b></td>
            <td width="15%" style="text-align : center"><b>Fecha / Hora</b></td>
            <td width="20%" style="text-align : center"><b>Usuario registra</b></td>
            
              
            </tr>
            <tr>
            <td width="20%" style="text-align : center">{$PRODUCTO[0].datos_enturnamiento[0].placa}</td>
            <td width="20%" style="text-align : center">{$PRODUCTO[0].datos_enturnamiento[0].numero_turno}</td>
              <td width="20%" style="text-align : center">{$PRODUCTO[0].datos_enturnamiento[0].nombre_conductor}</td>
              <td width="20%" style="text-align : center">{$PRODUCTO[0].datos_enturnamiento[0].fecha_registro}</td>
              <td width="20%" style="text-align : center">{$PRODUCTO[0].datos_enturnamiento[0].usuario}</td>
              
            </tr>
          
          </tbody>
        </table>
        {/if}

          <!--Muelle-->

        <br><br>
         {if $PRODUCTO[0].datos_muelle|@count > 0}
         <table  style="width: 100%;" class="table table-striped table-hover table-sm table-bordered">
          <thead class="thead">
            <th style="text-align: center; font-size:19px; font-family: 'Courier New', Courier, monospace;" colspan="6">Muelle</th>
          </thead>

          <tbody>
         
            <tr style="background-color: #e6eee3;">
              <td width="33,3%" style="text-align : center"><b>N° Muelle</b></td>
              <td width="33,3%" style="text-align : center"><b>Nombre</b></td>
              <td width="33,3%" style="text-align : center"><b>Bodega</b></td>
              <td width="33,3%" style="text-align : center"><b>Fecha / Hora</b></td>
              <td width="33,3%" style="text-align : center"><b>Usuario registra</b></td>
              <td width="33,3%" style="text-align : center"><b>Estado</b></td>
            </tr>
            <tr>
              <td width="33,3%" style="text-align : center">{$PRODUCTO[0].datos_muelle[0].numero_muelle}</td>
              <td width="33,3%" style="text-align : center">{$PRODUCTO[0].datos_muelle[0].nombre}</td>
              <td width="33,3%" style="text-align : center">{$PRODUCTO[0].datos_muelle[0].bodega}</td>
              <td width="33,3%" style="text-align : center">{$PRODUCTO[0].datos_muelle[0].fecha_registro}</td>
              <td width="33,3%" style="text-align : center">{$PRODUCTO[0].datos_muelle[0].usuario}</td>
              <td width="33,3%" style="text-align : center">{$PRODUCTO[0].datos_muelle[0].estado}</td>
            </tr>
          
          </tbody>
        </table>
        {/if}

          <!--Recepcion-->

        <br><br>
        {if $PRODUCTO[0].datos_recepcion|@count > 0}
         <table  style="width: 100%;" class="table table-striped table-hover table-sm table-bordered">
          <thead class="thead">
            <th style="text-align: center; font-size:19px; font-family: 'Courier New', Courier, monospace;" colspan="4">Recepción</th>
          </thead>

          <tbody>
         
            <tr style="background-color: #e6eee3;">
              <td width="33,3%" style="text-align : center"><b>Codigo Recepcion</b></td>
              <td width="33,3%" style="text-align : center"><b>Fecha / Hora</b></td>
              <td width="33,3%" style="text-align : center"><b>Usuario registra</b></td>
               <td width="33,3%" style="text-align : center"><b>Estado</b></td>
            </tr>
            <tr>
              <td width="33,3%" style="text-align : center">{$PRODUCTO[0].datos_recepcion[0].codigo_recepcion}</td>
              <td width="33,3%" style="text-align : center">{$PRODUCTO[0].datos_recepcion[0].fecha_registro}</td>
              <td width="33,3%" style="text-align : center">{$PRODUCTO[0].datos_recepcion[0].usuario}</td>
              <td width="33,3%" style="text-align : center">{$PRODUCTO[0].datos_recepcion[0].estado}</td>
            </tr>
          
          </tbody>
        </table>
        {/if}

          <!--Legalizacion-->

        <br><br>
        {if $PRODUCTO[0].datos_legalizacion|@count > 0}
         <table  style="width: 100%;" class="table table-striped table-hover table-sm table-bordered">
          <thead class="thead">
            <th style="text-align: center; font-size:19px; font-family: 'Courier New', Courier, monospace;" colspan="4">Legalización</th>
          </thead>
          <tbody>
         
            <tr style="background-color: #e6eee3;">
            <td  width="33,3%" style="text-align : center"><b>Codigo</b></td>
              <td  width="33,3%" style="text-align : center"><b>Fecha / Hora</b></td>
              <td  width="33,3%" style="text-align : center"><b>Usuario registra</b></td>
              <td width="33,3%" style="text-align : center"><b>Estado</b></td>
            </tr>
            
            {foreach from=$PRODUCTO[0].datos_legalizacion item=i}
            <tr>
              <td  width="33,3%" style="text-align : center">{$i.recepcion_id}</td>
              <td  width="33,3%" style="text-align : center">{$i.fecha_registro}</td>
              <td  width="33,3%" style="text-align : center">{$i.usuario}</td>
              <td  width="33,3%" style="text-align : center">{$i.estado}</td>
            </tr>
            {/foreach}
          </tbody>
        </table>
        {/if}



          <!--Entrada a inventario-->

        <br><br>
        
         <table  style="width: 100%;" class="table table-striped table-hover table-sm table-bordered">
          <thead class="thead">
            <th style="text-align: center; font-size:19px; font-family: 'Courier New', Courier, monospace;" colspan="6">Entrada a inventario</th>
          </thead>

          <tbody>
         
            <tr style="background-color: #e6eee3;">
              <td  width="10%" style="text-align : center"><b>Fecha / Hora</b></td>
              <td  width="20%" style="text-align : center"><b>Ubicacion</b></td>
              <td  width="20%" style="text-align : center"><b>Bodega</b></td>
              <td  width="20%" style="text-align : center"><b>Posicion</b></td>
              <td  width="10%" style="text-align : center"><b>Estado producto</b></td>
              <td  width="20%" style="text-align : center"><b>Usuario registra</b></td>
            </tr>
            {if $PRODUCTO[0].datos_inventario[0] neq ''}
              {foreach from=$PRODUCTO[0].datos_inventario item=i}
                <tr>
                  <td  width="10%" style="text-align : center">{$i.fecha_registro}</td>
                  <td  width="20%" style="text-align : center">{$i.ubicacion_bodega}</td>
                  <td  width="20%" style="text-align : center">{$i.bodega}</td>
                  <td  width="20%" style="text-align : center">{$i.posicion}</td>
                  <td  width="10%" style="text-align : center">{$i.estado}</td>
                  <td  width="20%" style="text-align : center">{$i.usuario}</td>
                </tr>
              {/foreach}
            {else}
               <tr>
                  <td style="text-align: center;  color: #F15558; font-size:19px; font-family: 'Courier New', Courier, monospace;" colspan="6">¡Este producto no se encuentra en inventario!</td>
               </tr>
            {/if}
          </tbody>
        </table>
        



        <!--Traslados -->

        <br><br>
        {if $PRODUCTO[0].datos_traslados|@count > 0}
         <table  style="width: 100%;" class="table table-striped table-hover table-sm table-bordered">
          <thead class="thead">
            <th style="text-align: center; font-size:19px; font-family: 'Courier New', Courier, monospace;" colspan="7">Traslados</th>
          </thead>

          <tbody>
         
            <tr style="background-color: #e6eee3;">
              <td  width="10%" style="text-align : center"><b>Fecha / Hora</b></td>
              <td  width="20%" style="text-align : center"><b>Ubicacion</b></td>
              <td  width="10%" style="text-align : center"><b>Bodega</b></td>
              {* <td  width="20%" style="text-align : center"><b>Posicion</b></td> *}
              <td  width="10%" style="text-align : center"><b>Estado producto</b></td>
              <td  width="20%" style="text-align : center"><b>Usuario registra</b></td>
              <td  width="10%" style="text-align : center"><b>1 o varios</b></td>
            </tr>

            <tr>
              <td  width="10%" style="text-align : center">{$PRODUCTO[0].datos_traslados[0].fecha_registro}</td>
              <td  width="20%" style="text-align : center">{$PRODUCTO[0].datos_traslados[0].ubicacion}</td>
              <td  width="10%" style="text-align : center">{$PRODUCTO[0].datos_traslados[0].nombre_bodega}</td>
              {* <td  width="10%" style="text-align : center">{$PRODUCTO[0].datos_traslados[0].posicion}</td> *}
              <td  width="20%" style="text-align : center">{$PRODUCTO[0].datos_traslados[0].estado}</td>
              <td  width="20%" style="text-align : center">{$PRODUCTO[0].datos_traslados[0].usuario}</td>
              <td  width="10%" style="text-align : center"></td>
            </tr>
          
          </tbody>
        </table>
        {/if}
        <!--Alistamiento salida-->

        <br><br>
        {if $PRODUCTO[0].datos_alistamiento_salida|@count > 0}
         <table  style="width: 100%;" class="table table-striped table-hover table-sm table-bordered">
          <thead class="thead">
            <th style="text-align: center; font-size:19px; font-family: 'Courier New', Courier, monospace;" colspan="6">Alistamiento salida</th>
          </thead>

          <tbody>
         
            <tr style="background-color: #e6eee3;">
              <td  width="10%" style="text-align : center"><b>Codigo</b></td>
              <td  width="10%" style="text-align : center"><b>Turno</b></td>
              <td  width="20%" style="text-align : center"><b>Muelle</b></td>
              <td  width="20%" style="text-align : center"><b>Fecha / Hora</b></td>
              <td  width="20%" style="text-align : center"><b>Usuario registra</b></td>
              <td  width="20%" style="text-align : center"><b>Estado</b></td>
            </tr>
            <tr>
              <td  width="10%" style="text-align : center">{$PRODUCTO[0].datos_alistamiento_salida[0].alistamiento_salida_id}</td>
              <td  width="10%" style="text-align : center" {if $PRODUCTO[0].datos_alistamiento_salida[0].turno eq ''} class="turno_no" {else} class="turno_si" {/if} >{if $PRODUCTO[0].datos_alistamiento_salida[0].turno eq ''}PENDIENTE{else}{$PRODUCTO[0].datos_alistamiento_salida[0].turno}{/if}</td>
              <td  width="20%" style="text-align : center">{$PRODUCTO[0].datos_alistamiento_salida[0].muelle}</td>
              <td  width="20%" style="text-align : center">{$PRODUCTO[0].datos_alistamiento_salida[0].fecha_registro}</td>
              <td  width="20%" style="text-align : center">{$PRODUCTO[0].datos_alistamiento_salida[0].usuario}</td>
              <td  width="20%" style="text-align : center">{$PRODUCTO[0].datos_alistamiento_salida[0].estado}</td>
            </tr>
          
          </tbody>
        </table>
        {/if}

        <!--Despacho-->

        <br><br>
        {if $PRODUCTO[0].datos_despacho|@count > 0}
         <table  style="width: 100%;"  class="table table-striped table-hover table-sm table-bordered">
          <thead class="thead">
            <th style="text-align: center; font-size:19px; font-family: 'Courier New', Courier, monospace;" colspan="5">Despacho</th>
          </thead>
           <thead>
            <th style="text-align: center;" colspan="5"><div class="animated flash">{if $PRODUCTO[0].datos_despacho[0].imagen eq ''}<img src="../../../framework/media/images/general/sin_vehiculo.png " width="190" height="140" />{else} <img src="{$PRODUCTO[0].datos_despacho[0].imagen}" width="190" height="140" /> {/if}</div></th>
          </thead>

          <tbody>
         
            <tr style="background-color: #e6eee3;">
              <td  width="10%" style="text-align : center"><b>N° Despacho</b></td>
              <td  width="20%" style="text-align : center"><b>Placa</b></td>
              <td  width="30%" style="text-align : center"><b>Conductor</b></td>
              <td  width="20%" style="text-align : center"><b>Fecha / Hora</b></td>
              <td  width="20%" style="text-align : center"><b>Usuario registra</b></td>
            </tr>
            <tr>
              <td  width="10%" style="text-align : center">{$PRODUCTO[0].datos_despacho[0].numero_despacho}</td>
              <td  width="20%" style="text-align : center">{$PRODUCTO[0].datos_despacho[0].placa}</td>
              <td  width="30%" style="text-align : center">{$PRODUCTO[0].datos_despacho[0].nombre_conductor}</td>
              <td  width="20%" style="text-align : center">{$PRODUCTO[0].datos_despacho[0].fecha_registro}</td>
              <td  width="20%" style="text-align : center">{$PRODUCTO[0].datos_despacho[0].usuario}</td>
            </tr>
          
          </tbody>
        </table>
        {/if}

        <!--Entrega -->

        <br><br>
        {if $PRODUCTO[0].datos_entrega|@count > 0}
         <table  style="width: 100%;"  class="table table-striped table-hover table-sm table-bordered">
          <thead class="thead">
            <th style="text-align: center; font-size:19px; font-family: 'Courier New', Courier, monospace;" colspan="3">Entrega</th>
          </thead>

          <tbody>
         
            <tr style="background-color: #e6eee3;">
              <td  width="30%" style="text-align : center"><b>Fecha / Hora Entrega</b></td>
               <td  width="30%" style="text-align : center"><b>Observacion</b></td>
              <td  width="70%" style="text-align : center"><b>Usuario registra</b></td>
            </tr>
            <tr>
              <td  width="30%" style="text-align : center">{$PRODUCTO[0].datos_entrega[0].fecha_entrega}</td>
              <td  width="30%" style="text-align : center">{$PRODUCTO[0].datos_entrega[0].observacion_entrega}</td>
              <td  width="70%" style="text-align : center">{$PRODUCTO[0].datos_entrega[0].usuario}</td>
            </tr>
          
          </tbody>
        </table>
        {/if}
  
      </div>
      <div class="col-sm"></div>
    </div>
  </div>
  
  
 {*  {/if} *}
</page>

<!--  -->
