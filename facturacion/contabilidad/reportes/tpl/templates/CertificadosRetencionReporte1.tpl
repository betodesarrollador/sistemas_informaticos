<html>
<head>
    <title>Libro Auxiliar</title>
    {$JAVASCRIPT}
    {$CSSSYSTEM} 	
</head>
  
<body onLoad="this.print()">
    <table>
        <tr>
            <td align="center">&nbsp;</td>
            <td align="center" valign="top"><img src="{$logo}" alt="logo" width="300" height="300"></td>
        </tr>        
        <tr>
            <td colspan="2" align="center" style="font-size:12px; font-family:'Times New Roman', Times, serif">{$data}</td>
        </tr>        
    </table>
    <br>
    <br>
    <table>
        <tr>
            <td align="center">&nbsp;</td>
            <td align="center" valign="top"><img src="{$logo}" alt="logo" width="300" height="300"></td>
        </tr>        
        <tr>
            <td colspan="2" align="center" style="font-size:12px; font-family:'Times New Roman', Times, serif">{$data}</td>
        </tr>        
    </table>

    <div style="page-break-after:always"></div>       
</body>
</html>