<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		{$JAVASCRIPT}
		{$CSSSYSTEM}
	</head>
	<body>
		{assign var="x" value=0}
		<fieldset>
			<iframe src="ManifiestosClass.php?ACTIONCONTROLER=onclickPrint&manifiesto_id={$MANIFIESTO}" width="100%" height="300"></iframe>
			<input type="submit" onClick="window.frames[{$x}].print()" value="Imprimir Manifiesto">
			{assign var="x" value=$x+1}
		</fieldset>
		{assign var="k" value=0}
		<fieldset>
			{section name=reme loop=$REMESAS}
				<fieldset>
					<iframe src="RemesasMasivoClass.php?ACTIONCONTROLER=onclickPrint&rango_desde={$REMESAS[$k].numero_remesa}&rango_hasta={$REMESAS[$k].numero_remesa}" width="100%" height="300"></iframe>
					<input type="submit" onClick="window.frames[{$x}].print()" value="Imprimir Remesa {$REMESAS[$k].numero_remesa}">
					{assign var="k" value=$k+1}
					{assign var="x" value=$x+1}
				</fieldset>
			{/section}
		</fieldset>
		{assign var="x" value=$x}
		{assign var="k" value=0}
		<fieldset>
			{section name=anti loop=$ANTICIPOS}
				<fieldset>
					<iframe src="AnticiposClass.php?ACTIONCONTROLER=viewDocAnticipo&encabezado_registro_id={$ANTICIPOS[$k].encabezado_registro_id}"  width="100%" height="300"></iframe>
					<input type="submit" onClick="window.frames[{$x}].print()" value="Imprimir Anticipo">
					{assign var="x" value=$x+1}
					{assign var="k" value=$k+1}
				</fieldset>
			{/section}
		</fieldset>
		{assign var="x" value=$x}
		{assign var="k" value=0}
		<fieldset>
			{section name=orden loop=$ORDENCOMPRA}
				<fieldset>
					<iframe src="../../../proveedores/ordencompra/clases/OrdenClass.php?ACTIONCONTROLER=onclickPrint&orden_compra_id={$ORDENCOMPRA[$k].orden_compra_id}"  width="100%" height="300"></iframe>
					<input type="submit" onClick="window.frames[{$x}].print()" value="Imprimir Orden de Compra">
					{assign var="x" value=$x+1}
					{assign var="k" value=$k+1}
				</fieldset>
			{/section}
		</fieldset>
	</body>
</html>
