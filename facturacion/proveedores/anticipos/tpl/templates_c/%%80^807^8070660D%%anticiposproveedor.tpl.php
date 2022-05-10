<?php /* Smarty version 2.6.30, created on 2022-02-17 09:36:47
         compiled from anticiposproveedor.tpl */ ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
   <link rel="stylesheet" href="/sistemas_informaticos/framework/css/bootstrap.css">
  <?php echo $this->_tpl_vars['JAVASCRIPT']; ?>

  <?php echo $this->_tpl_vars['TABLEGRIDJS']; ?>

  <?php echo $this->_tpl_vars['CSSSYSTEM']; ?>

  <?php echo $this->_tpl_vars['TABLEGRIDCSS']; ?>

  <?php echo $this->_tpl_vars['TITLETAB']; ?>
  
  </head>

  <body>
	<fieldset>
        <legend><?php echo $this->_tpl_vars['TITLEFORM']; ?>
</legend>
		        
        <?php echo $this->_tpl_vars['FORM1']; ?>

        <table align="center" width="100%">
          <tr>
            <td align="center">
            	<fieldset class="section">
			  <table>
			     <tr>
				 	<td><div><label>Proveedor :</label></td><td>&nbsp;<?php echo $this->_tpl_vars['PROVEEDOR']; ?>
<?php echo $this->_tpl_vars['PROVEEDORID']; ?>
</div></td>
					<td>&nbsp;</td><td>&nbsp;</td>
                 </tr>   
			    <tr>
				 	<td><div><label>Doc Identificaci&oacute;n : </label></td><td>&nbsp;<?php echo $this->_tpl_vars['PROVEEDORIDENTIFICACION']; ?>
</div></td>
                    <td>&nbsp;</td><td>&nbsp;</td>
                 </tr>   

			  </table>
			</fieldset>
          </tr>
		  <tr>
		    <td colspan="5" align="center">
			  <fieldset class="section">
			    <legend>Anticipos Proveedor</legend>
			     <iframe width="100%" name="frameAnticiposProveedor" id="frameAnticiposProveedor" src=""></iframe>
			  </fieldset>
			  <fieldset class="section">
			    <legend>Devoluciones Proveedor</legend>
			     <iframe width="100%" height="110px" name="frameDevolucionesPlaca" id="frameDevolucionesPlaca" src=""></iframe>
			  </fieldset>
              
			</td>
				 
	      </tr>
		  <tr><td colspan="5" align="center"><div align="center"><span style="display:none;"><?php echo $this->_tpl_vars['ANULAR']; ?>
<?php echo $this->_tpl_vars['BORRAR']; ?>
</span><?php echo $this->_tpl_vars['IMPRIMIR']; ?>
&nbsp;<?php echo $this->_tpl_vars['LIMPIAR']; ?>
</div></td></tr>
		  <tr>
		    <td colspan="5" align="center">
			  <fieldset class="section">
			    <legend>Registro contable<?php echo $this->_tpl_vars['ENCABEZADOREGISTROID']; ?>
</legend>
			      <div><iframe width="100%" name="frameRegistroContable" id="frameRegistroContable" src=""></iframe></div>
			  </fieldset>			
			</td>
	      </tr>	  
		  
    </table>
		 
	    <?php echo $this->_tpl_vars['FORM1END']; ?>

    </fieldset>
    
  </body>
</html>