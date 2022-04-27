<?php /* Smarty version 2.6.26, created on 2021-04-21 09:15:11
         compiled from Alertas.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'math', 'Alertas.tpl', 66, false),array('modifier', 'count', 'Alertas.tpl', 66, false),)), $this); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <?php print $this->_tpl_vars['JAVASCRIPT']; ?>

    <?php print $this->_tpl_vars['TABLEGRIDJS']; ?>

    <?php print $this->_tpl_vars['CSSSYSTEM']; ?>

    <?php print $this->_tpl_vars['TABLEGRIDCSS']; ?>

    <?php print $this->_tpl_vars['TITLETAB']; ?>

    <link rel="stylesheet" href="sistemas_informaticos/bodega/bases/css/bootstrap1.css">
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
</head>

<body>
   <?php print $this->_tpl_vars['FORM1']; ?>

    <fieldset>
    
        <legend><?php print $this->_tpl_vars['TITLEFORM']; ?>
</legend>
        <div id="table_find" align="center">
        <fieldset class="section">
            <table>
            <tr>
             <td><label>MENSAJE</label></td>
             <td><label>&emsp;</label></td>
             <td><label>MODULOS</label></td>
             
            </tr>
                <tr>
                    
                    <td><?php print $this->_tpl_vars['MENSAJE']; ?>
&emsp;&emsp;</td>
                    <td><a href="#" onclick="limpiar();"><img src="../../../framework/media/images/forms/suggest.png"></a></td>
                   
                    <td><?php print $this->_tpl_vars['ALLMODULOS']; ?>
<br><?php print $this->_tpl_vars['SELECTMODULOS']; ?>
<?php print $this->_tpl_vars['MODULOS']; ?>
&emsp;&emsp;</td>    
                               
                </tr>
                <tr>
                   <td><a href="../../../framework/ayudas/archivoBase.docx" download="ArchivoBase"><img src="../../../framework/media/images/general/word.png" width="25" height="25"/></a>&nbsp;&nbsp;&nbsp;&nbsp;<?php print $this->_tpl_vars['ARCHIVO']; ?>
</td>
                </tr>
                <tr>
                
                <table align="left">
                       
                <tr>
                
                    <td><label>FECHA INICIO</label>&emsp;<?php print $this->_tpl_vars['FECHAINICIO']; ?>
&emsp;&emsp;&emsp;&emsp;</td>
                    <td><label>FECHA FIN</label>&emsp;<?php print $this->_tpl_vars['FECHAFIN']; ?>
&emsp;&emsp;&emsp;&emsp;</td>
                    <td><label>LINK VIDEO</label>&emsp;<?php print $this->_tpl_vars['LINKVIDEO']; ?>
</td>
                
                </tr>
                </table>
                
                </tr>
               
               
            </table>
             <input type="checkbox" onclick="check_all(this)"/>&emsp;<span style="font-size: 11pt; font-weight: bold; color:red;">Aplicar para todas las empresas</span>
        </fieldset>
        </div>
    </fieldset>
 
    <fieldset class="section">  
        <table align="center">       

       <?php unset($this->_sections['k']);
$this->_sections['k']['name'] = 'k';
$this->_sections['k']['loop'] = is_array($_loop=7) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['k']['step'] = ((int)-1) == 0 ? 1 : (int)-1;
$this->_sections['k']['show'] = true;
$this->_sections['k']['max'] = $this->_sections['k']['loop'];
$this->_sections['k']['start'] = $this->_sections['k']['step'] > 0 ? 0 : $this->_sections['k']['loop']-1;
if ($this->_sections['k']['show']) {
    $this->_sections['k']['total'] = min(ceil(($this->_sections['k']['step'] > 0 ? $this->_sections['k']['loop'] - $this->_sections['k']['start'] : $this->_sections['k']['start']+1)/abs($this->_sections['k']['step'])), $this->_sections['k']['max']);
    if ($this->_sections['k']['total'] == 0)
        $this->_sections['k']['show'] = false;
} else
    $this->_sections['k']['total'] = 0;
if ($this->_sections['k']['show']):

            for ($this->_sections['k']['index'] = $this->_sections['k']['start'], $this->_sections['k']['iteration'] = 1;
                 $this->_sections['k']['iteration'] <= $this->_sections['k']['total'];
                 $this->_sections['k']['index'] += $this->_sections['k']['step'], $this->_sections['k']['iteration']++):
$this->_sections['k']['rownum'] = $this->_sections['k']['iteration'];
$this->_sections['k']['index_prev'] = $this->_sections['k']['index'] - $this->_sections['k']['step'];
$this->_sections['k']['index_next'] = $this->_sections['k']['index'] + $this->_sections['k']['step'];
$this->_sections['k']['first']      = ($this->_sections['k']['iteration'] == 1);
$this->_sections['k']['last']       = ($this->_sections['k']['iteration'] == $this->_sections['k']['total']);
?>

            <?php $this->assign('num_columnas', $this->_sections['k']['index']); ?>

            <?php print smarty_function_math(array('assign' => 'multiplo','equation' => "x / y",'x' => count($this->_tpl_vars['DATABASES']),'y' => $this->_tpl_vars['num_columnas']), $this);?>


            <?php if (is_int ( $this->_tpl_vars['multiplo'] )): ?><?php break; ?><?php endif; ?>
       
       <?php endfor; endif; ?> 



      <?php $this->assign('contador', -1); ?>

      <?php print smarty_function_math(array('assign' => 'array','equation' => "x / y",'x' => count($this->_tpl_vars['DATABASES']),'y' => $this->_tpl_vars['num_columnas']), $this);?>


      <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['start'] = (int)0;
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['array']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
if ($this->_sections['i']['start'] < 0)
    $this->_sections['i']['start'] = max($this->_sections['i']['step'] > 0 ? 0 : -1, $this->_sections['i']['loop'] + $this->_sections['i']['start']);
else
    $this->_sections['i']['start'] = min($this->_sections['i']['start'], $this->_sections['i']['step'] > 0 ? $this->_sections['i']['loop'] : $this->_sections['i']['loop']-1);
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = min(ceil(($this->_sections['i']['step'] > 0 ? $this->_sections['i']['loop'] - $this->_sections['i']['start'] : $this->_sections['i']['start']+1)/abs($this->_sections['i']['step'])), $this->_sections['i']['max']);
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
      
      <tr> 
      <td id="loading">&nbsp;</td>
      </tr>

      <tr>

       <?php unset($this->_sections['j']);
$this->_sections['j']['name'] = 'j';
$this->_sections['j']['start'] = (int)0;
$this->_sections['j']['loop'] = is_array($_loop=$this->_tpl_vars['num_columnas']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['j']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['j']['show'] = true;
$this->_sections['j']['max'] = $this->_sections['j']['loop'];
if ($this->_sections['j']['start'] < 0)
    $this->_sections['j']['start'] = max($this->_sections['j']['step'] > 0 ? 0 : -1, $this->_sections['j']['loop'] + $this->_sections['j']['start']);
else
    $this->_sections['j']['start'] = min($this->_sections['j']['start'], $this->_sections['j']['step'] > 0 ? $this->_sections['j']['loop'] : $this->_sections['j']['loop']-1);
if ($this->_sections['j']['show']) {
    $this->_sections['j']['total'] = min(ceil(($this->_sections['j']['step'] > 0 ? $this->_sections['j']['loop'] - $this->_sections['j']['start'] : $this->_sections['j']['start']+1)/abs($this->_sections['j']['step'])), $this->_sections['j']['max']);
    if ($this->_sections['j']['total'] == 0)
        $this->_sections['j']['show'] = false;
} else
    $this->_sections['j']['total'] = 0;
if ($this->_sections['j']['show']):

            for ($this->_sections['j']['index'] = $this->_sections['j']['start'], $this->_sections['j']['iteration'] = 1;
                 $this->_sections['j']['iteration'] <= $this->_sections['j']['total'];
                 $this->_sections['j']['index'] += $this->_sections['j']['step'], $this->_sections['j']['iteration']++):
$this->_sections['j']['rownum'] = $this->_sections['j']['iteration'];
$this->_sections['j']['index_prev'] = $this->_sections['j']['index'] - $this->_sections['j']['step'];
$this->_sections['j']['index_next'] = $this->_sections['j']['index'] + $this->_sections['j']['step'];
$this->_sections['j']['first']      = ($this->_sections['j']['iteration'] == 1);
$this->_sections['j']['last']       = ($this->_sections['j']['iteration'] == $this->_sections['j']['total']);
?>

       <?php print smarty_function_math(array('assign' => 'contador','equation' => "x + y",'x' => $this->_tpl_vars['contador'],'y' => 1), $this);?>


       <?php if ($this->_tpl_vars['DATABASES'][$this->_tpl_vars['contador']]['logo'] != ''): ?>

          <td>
            <img src="<?php print $this->_tpl_vars['DATABASES'][$this->_tpl_vars['contador']]['logo']; ?>
" width="10%" >&emsp;<input type="checkbox" name="procesar" value="<?php print $this->_tpl_vars['DATABASES'][$this->_tpl_vars['contador']]['db']; ?>
" onclick="getEmpresas()"/>&emsp;<?php print $this->_tpl_vars['DATABASES'][$this->_tpl_vars['contador']]['empresa']; ?>

          </td>

       <?php endif; ?>
       
       <?php endfor; endif; ?> 
         
      </tr> 	  
         
        <?php endfor; endif; ?> 

        

            <tr>
                <td><br><br></td>
            </tr>
            <tr>
                <td align="center" colspan="6"><?php print $this->_tpl_vars['GUARDAR']; ?>
<?php print $this->_tpl_vars['EMPRESAS']; ?>
</td>
            </tr>
            <tr>
               <td align="center" colspan="6"><span>Nota. Cantidad de empresas ACTIVAS : <?php print count($this->_tpl_vars['DATABASES']); ?>
</span></td>
            </tr>
        </table>
    </fieldset>  
   <?php print $this->_tpl_vars['FORM1END']; ?>

</body>
</html>