<HTML>
<HEAD>
	
	<META HTTP-EQUIV="CONTENT-TYPE" CONTENT="text/html; charset=utf-8">
	
</HEAD>
<BODY>
<TABLE CELLSPACING="0" cellpadding="0"  BORDER="0" width="90%" align="center">
	<TR>
		<TD  COLSPAN=2 ROWSPAN=3 HEIGHT="62" ALIGN="CENTER"><FONT COLOR="#000000">LOGO</FONT></TD>
		<TD  COLSPAN=4 ALIGN="CENTER"><FONT COLOR="#000000">ONLINE TOOLS SAS</FONT></TD>
		<TD  COLSPAN=2 ALIGN="CENTER"><FONT COLOR="#000000">NOMBRE DOCUMENTO</FONT></TD>
		</TR>
	<TR>
		<TD  COLSPAN=4 ALIGN="CENTER"><FONT COLOR="#000000">NIT. 900,452,978-1</FONT></TD>
		<TD  COLSPAN=2 ALIGN="CENTER"><u><FONT COLOR="#000000">No.{$CONSECUTIVO}</FONT></u></TD>
		</TR>
	<TR>
		<TD COLSPAN=4 ALIGN="CENTER"><FONT COLOR="#000000">Agencia: {$OFICINA}</FONT></TD>
		<TD colspan="2" ALIGN="LEFT">&nbsp;</TD>
	</TR>
	<TR>
		<TD HEIGHT="20" colspan="8" ALIGN="LEFT" >&nbsp;</TD>
	</TR>
	<TR>
		<TD  HEIGHT="21" ALIGN="LEFT">Fecha:</TD>
		<TD colspan="2" ALIGN="LEFT" >{$FECHA}</TD>
		<TD ALIGN="LEFT"><FONT COLOR="#000000"><BR></FONT></TD>
		<TD ALIGN="LEFT"><FONT COLOR="#000000">Ciudad:</FONT></TD>
		<TD colspan="3" ALIGN="LEFT" >{$CIUDAD}</TD>
		</TR>
	<TR>
		<TD  HEIGHT="21" ALIGN="LEFT">{$TEXTOTERCERO}</TD>
		<TD colspan="3" ALIGN="LEFT" >{$TERCERO}</TD>
		<TD ALIGN="LEFT"><FONT COLOR="#000000">CC o Nit.</FONT></TD>
		<TD  ALIGN="LEFT"><FONT COLOR="#000000">{$IDENTIFICACION}<BR>
		</FONT></TD>
		<TD ALIGN="LEFT"><FONT COLOR="#000000">Telefono:</FONT></TD>
		<TD  ALIGN="LEFT"><FONT COLOR="#000000">
		  {$TELEFONO}</FONT></TD>
	</TR>
	<TR>
		<TD  HEIGHT="21" ALIGN="LEFT"><FONT COLOR="#000000">Concepto:</FONT></TD>
		<TD colspan="7" ALIGN="LEFT" >{$CONCEPTO}</TD>
	</TR>
	<TR>
		<TD  HEIGHT="21" ALIGN="LEFT"><FONT COLOR="#000000">Forma Pago:</FONT></TD>
		<TD  ALIGN="LEFT"><FONT COLOR="#000000">{$FPAGO}<BR></FONT></TD>
		<TD ALIGN="LEFT"><FONT COLOR="#000000">Cod. Puc:</FONT></TD>
		<TD  ALIGN="LEFT"><FONT COLOR="#000000">{$PUC}
            <label></label>
        <BR></FONT></TD>
		<TD ALIGN="LEFT">{$TEXTOSOPORTE}</TD>
		<TD  ALIGN="LEFT"><FONT COLOR="#000000">{$NUMSOPORTE}<BR></FONT></TD>
		<TD ALIGN="LEFT"><FONT COLOR="#000000">Valor:</FONT></TD>
		<TD  ALIGN="LEFT">{$VALOR}</TD>
	</TR>
	<TR>
		<TD  HEIGHT="20" ALIGN="LEFT"><FONT COLOR="#000000"><BR></FONT></TD>
		<TD ALIGN="LEFT"><FONT COLOR="#000000"><BR></FONT></TD>
		<TD ALIGN="LEFT"><FONT COLOR="#000000"><BR></FONT></TD>
		<TD ALIGN="LEFT"><FONT COLOR="#000000"><BR></FONT></TD>
		<TD ALIGN="LEFT"><FONT COLOR="#000000"><BR></FONT></TD>
		<TD ALIGN="LEFT"><FONT COLOR="#000000"><BR></FONT></TD>
		<TD ALIGN="LEFT"><FONT COLOR="#000000"><BR></FONT></TD>
		<TD  ALIGN="LEFT"><FONT COLOR="#000000"><BR></FONT></TD>
	</TR>
	<TR>
		<TD  HEIGHT="21" ALIGN="LEFT"><FONT COLOR="#000000">V/r. Letras:</FONT></TD>
		<TD colspan="7" ALIGN="LEFT" >{$VALORTEXTO}</TD>
	</TR>
	<TR>
		<TD HEIGHT="21" colspan="8" ALIGN="LEFT" >&nbsp;</TD>
	</TR>
	<TR>
		<TD  COLSPAN=8 HEIGHT="20" ALIGN="CENTER"><B><FONT COLOR="#000000">DETALLE MOVIMIENTOS</FONT></B></TD>
		</TR>
	<TR>
		<TD  HEIGHT="20" ALIGN="CENTER"><FONT COLOR="#000000">Cta. PUC</FONT></TD>
		<TD  ALIGN="CENTER"><FONT COLOR="#000000">Tercero</FONT></TD>
		<TD  ALIGN="CENTER"><FONT COLOR="#000000">Centro</FONT></TD>
		<TD  ALIGN="CENTER"><FONT COLOR="#000000">Base</FONT></TD>
		<TD  COLSPAN=2 ALIGN="CENTER"><FONT COLOR="#000000">Descripcion</FONT></TD>
		<TD  ALIGN="CENTER"><FONT COLOR="#000000">Debito</FONT></TD>
		<TD  ALIGN="CENTER"><FONT COLOR="#000000">Credito</FONT></TD>
	</TR>
	
	
	{foreach name=detalles from=$IMPUTACIONES item=i}
	<TR>
		<TD  HEIGHT="20" ALIGN="LEFT"><FONT COLOR="#000000">{$i.puc}<BR></FONT></TD>
		<TD  ALIGN="LEFT"><FONT COLOR="#000000">{$i.tercero}<BR></FONT></TD>
		<TD  ALIGN="LEFT"><FONT COLOR="#000000">{$i.centro_de_costo}<BR></FONT></TD>
		<TD  ALIGN="LEFT"><FONT COLOR="#000000">{$i.base}<BR></FONT></TD>
		<TD  COLSPAN=2 ALIGN="CENTER"><FONT COLOR="#000000">{$i.descripcion}<BR></FONT></TD>
		<TD  ALIGN="LEFT"><FONT COLOR="#000000">{$i.debito}<BR></FONT></TD>
		<TD  ALIGN="LEFT"><FONT COLOR="#000000">{$i.credito}</FONT></TD>
	</TR>
	{/foreach}
	
	
	<TR>
		<TD  COLSPAN=6 HEIGHT="21" ALIGN="RIGHT"><B><FONT COLOR="#000000">Sumas Iguales</FONT></B></TD>
		<TD  ALIGN="LEFT"><FONT COLOR="#000000">$</FONT></TD>
		<TD  ALIGN="LEFT"><FONT COLOR="#000000">$</FONT></TD>
	</TR>
	<TR>
		<TD  COLSPAN=2 HEIGHT="81" ALIGN="CENTER"><FONT COLOR="#000000">Elaboro</FONT></TD>
		<TD  COLSPAN=2 ALIGN="CENTER"><FONT COLOR="#000000">Reviso</FONT></TD>
		<TD  COLSPAN=3 ALIGN="CENTER"><FONT COLOR="#000000">Recibe: C.C.</FONT></TD>
		<TD  ALIGN="CENTER"><FONT COLOR="#000000">Huella</FONT></TD>
	</TR>
</TABLE>
<!-- ************************************************************************** -->
</BODY>
</HTML>