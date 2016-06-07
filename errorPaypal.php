<?php
session_start();

$titulo = "Tienda Web";
include("conecta.php");
include("meta_tags.php");
include("cabecera.php");
?>
<div id="derecha">
    <div class='text-border'>
        <h1 style="color:red">No se ha podido realizar la compra. Por favor revise su cuenta Paypal e intentelo de nuevo</h1>
    </div>
</div>
<?php
include("pie.php");
include("cerrar_etiquetas.php");
?>