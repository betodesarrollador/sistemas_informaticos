<?php
$host = 'localhost';
$usuario = 'siandsi_siandsi1';
$contrasenia = 'oYNazfVrqAl+';
$base_de_datos = 'siandsi_sistemas_informaticos';
$mysqli = new mysqli($host, $usuario, $contrasenia, $base_de_datos);
if ($mysqli->connect_errno) {
    exit('Falló la conexión a MySQL: (' .
        $mysqli->connect_errno .
        ') ' .
        $mysqli->connect_error);
}

$resultado = $mysqli->query("SELECT a.actividad_programada_id,a.nombre,a.descripcion,a.fecha_inicial,a.fecha_final,a.estado,a.responsable_id,t.primer_nombre,t.primer_apellido,t.email, CURDATE() FROM actividad_programada a
INNER JOIN tercero t
 ON a.responsable_id = t.tercero_id where  a.fecha_final < CURDATE() AND a.estado = 1
AND a.responsable_id is not null AND tipo_tarea_id = 1");
$tareas = $resultado->fetch_all(MYSQLI_ASSOC);

$mail_subject = "Notificacion de tareas represadas";

require_once "../framework/clases/MailClass.php";
$enviar_mail = new Mail();

foreach ($tareas as $tarea) {

    $body = '

<table width="95%" cellspacing="1">
    <tr>
        <td align="left" colspan="2">
            Tarea sin entregar.<br><br>
        </td>
    </tr>

    <tr>
        <td align="left">Codigo :</td>
        <td align="left">' . $tarea['actividad_programada_id'] . '</td>
    </tr>

    <tr>
        <td align="left">Tarea :</td>
        <td align="left">' . $tarea['nombre'] . '</td>
    </tr>

    <tr>
        <td align="left">Descripion :</td>
        <td align="left">' . $tarea['descripcion'] . '</td>
    </tr>

    <tr>
        <td align="left">Desarrollador :</td>
        <td align="left">' . $tarea['primer_nombre'] . '  ' . $tarea['primer_apellido'] . '</td>
    </tr>

    <tr>
        <td align="left">Fecha inicial :</td>
        <td align="left">' . $tarea['fecha_inicial'] . '</td>
    </tr>

    <tr>
        <td align="left">Fecha final :</td>
        <td align="left">' . $tarea['fecha_final'] . '</td>
    </tr>
</table>
';
    $enviar_mail->sendMail($tarea['email'], $mail_subject, $body);

    if (!$enviar_mail) {

        die('error enviando correo :' . $enviar_mail);

    } else {
        echo "correo enviado :" . $tarea['email'] . "<br>";
    }
}
