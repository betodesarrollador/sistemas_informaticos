<?php /* Smarty version 2.6.26, created on 2021-03-01 10:38:10
         compiled from Soporte.tpl */ ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <link rel="stylesheet" href="sistemas_informaticos/framework/css/bootstrap.css">
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
                <td><label>Cliente: </label></td>
                <td><?php print $this->_tpl_vars['CLIENTEID']; ?>
<?php print $this->_tpl_vars['CLIENTE']; ?>
</td>
                <td><label>Fecha Inicial : </label></td>
                <td><?php print $this->_tpl_vars['FECHAINI']; ?>
</td>
                <td><label>Fecha Final: </label></td>
                <td><?php print $this->_tpl_vars['FECHAFIN']; ?>
</td>
            </tr>
            <tr>
                <td><label>Estado : </label></td>
                <td><?php print $this->_tpl_vars['ESTADO']; ?>
</td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="8" align="center"><?php print $this->_tpl_vars['GUARDAR']; ?>
&nbsp;<?php print $this->_tpl_vars['ACTUALIZAR']; ?>
&nbsp;<?php print $this->_tpl_vars['BORRAR']; ?>
&nbsp;<?php print $this->_tpl_vars['LIMPIAR']; ?>
</td>
            </tr>
        </table>
    </fieldset>  
   
       
        <fieldset>
             
        <?php print $this->_tpl_vars['GRIDSoporte']; ?>

       
    </fieldset>
   
</body>
</html>