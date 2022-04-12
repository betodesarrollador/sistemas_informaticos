<?php /* Smarty version 2.6.26, created on 2021-04-05 16:38:20
         compiled from Actividad.tpl */ ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <link rel="stylesheet" href="sistemas_informaticos/framework/css/bootstrap1.css">
    <?php print $this->_tpl_vars['JAVASCRIPT']; ?>

    <?php print $this->_tpl_vars['TABLEGRIDJS']; ?>

    <?php print $this->_tpl_vars['CSSSYSTEM']; ?>

    <?php print $this->_tpl_vars['TABLEGRIDCSS']; ?>

    <?php print $this->_tpl_vars['TITLETAB']; ?>

</head>

<body>
    <fieldset>
        <legend><?php print $this->_tpl_vars['TITLEFORM']; ?>
</legend>
        <div id="table_find" align="center">
            <table>
                <tr>
                    <td><label>Busqueda : </label></td>
                    <td><?php print $this->_tpl_vars['BUSQUEDA']; ?>
</td>
                </tr>
            </table>
        </div>
    </fieldset>
    <?php print $this->_tpl_vars['FORM1']; ?>

    <fieldset class="section">  
        <table align="center">   
        <?php print $this->_tpl_vars['FECHAREGISTRO']; ?>
<?php print $this->_tpl_vars['USUARIOID']; ?>
<?php print $this->_tpl_vars['FECHAACT']; ?>
<?php print $this->_tpl_vars['USUARIOACT']; ?>
     
            <tr>
                <td><label>Codigo :</label></td>
                <td><?php print $this->_tpl_vars['PARAMID']; ?>
</td>
                <td><label>Nombre : </label></td>
                <td><?php print $this->_tpl_vars['NOMBRE']; ?>
</td>
                <td><label>Descripcion : </label></td>
                <td><?php print $this->_tpl_vars['DESCRIPCION']; ?>
</td>
            </tr>
            <tr>
                <td><label>Prioridad : </label></td>
                <td><?php print $this->_tpl_vars['PRIORIDAD']; ?>
</td>
                <td><label>Fase : </label></td>
                <td><?php print $this->_tpl_vars['FASEID']; ?>
</td>
                <td><label>Fecha Inicial :</label></td>
                <td><?php print $this->_tpl_vars['FECHAINI']; ?>
</td>
            </tr>
            <tr>
                <td><label>Fecha Final : </label></td>
                <td><?php print $this->_tpl_vars['FECHAFIN']; ?>
</td>
                <td><label>Fecha Inicial Real : </label></td>
                <td><?php print $this->_tpl_vars['FECHAINIREAL']; ?>
</td>
                 <td><label>Fecha Final Real : </label></td>
                <td><?php print $this->_tpl_vars['FECHAFINREAL']; ?>
</td>
            </tr>
            <tr>
                <td><label>Estado : </label></td>
                <td><?php print $this->_tpl_vars['ESTADO']; ?>
</td>
                <td> &nbsp;</td>
                <td id="adjuntover">&nbsp;</td>                
                <td><label>Adjunto max (4 MB):</label></td>
                <td id="fileUpload"><?php print $this->_tpl_vars['ARCHIVO']; ?>
</td>
            </tr>
            <tr>
              <td><label>Responsable :</label></td>
                <td><?php print $this->_tpl_vars['RESPONSABLEID']; ?>
<?php print $this->_tpl_vars['RESPONSABLE']; ?>
</td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="6" align="center"><?php print $this->_tpl_vars['GUARDAR']; ?>
&nbsp;<?php print $this->_tpl_vars['ACTUALIZAR']; ?>
&nbsp;<?php print $this->_tpl_vars['BORRAR']; ?>
&nbsp;<?php print $this->_tpl_vars['LIMPIAR']; ?>
&nbsp;<?php print $this->_tpl_vars['CERRAR']; ?>
</td>
            </tr>
        </table>
    </fieldset>  
   
       
        <fieldset>
             
        <?php print $this->_tpl_vars['GRIDActividad']; ?>

       
    </fieldset>
    <div id="divCierre">
			<form>
				<fieldset class="section">
					<table>       
                    <tr>
						<td><label>Fecha cierre real:</label></td>
						<td><?php print $this->_tpl_vars['FECHACIERREREAL']; ?>
</td>
					</tr>
                    <tr>
						<td><label>Observaci&oacute;n:</label></td>
						<td><?php print $this->_tpl_vars['OBSERVACION']; ?>
</td>
					</tr>
					<tr>
						<td colspan="2" align="center"><?php print $this->_tpl_vars['CERRAR']; ?>
</td>
					</tr>                    
					</table>
				</fieldset>
		</form>
    </div>
   
</body>
</html>