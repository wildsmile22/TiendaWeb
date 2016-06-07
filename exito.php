<?php
//session_start(); No hace falta incluir la sesión puesto que ya se ha efectuado la compra.

$titulo = "Carrito de Compra ";
//include("conecta.php"); No hace falta incluir la conexión puesto que no accedemos a base de datos
include("meta_tags.php");
include("cabecera.php");
?>
<div id="derecha">
    <div class='text-border'>
        <h1>Compra realizada con éxito, por favor revisa su correo para ver la notificación.</h1>

        <h3>Volver a la <a href="productos.php">tienda Web</a></h3>
        <?php
        //recogemos los valores del cliente y de la compra.
        //****************************************************
        //Con print-r podremos ver todos los valores que nos devuelve PayPal mediante POST
        //para después elegir los que queramos utilizar en nuestra aplicación.
        //print_r($_POST);

        $nombre = $_POST['first_name'];
        $apellido = $_POST['last_name'];
        $email_client = $_POST['payer_email'];
        $calle_client = $_POST['address_name'];
        $ciudad_client = $_POST['address_city'];
        $pais_client = $_POST['address_country'];
        $zonaRes_client = $_POST['residence_country'];
        $total_pedido = $_POST['mc_gross'];


        //2. Creamos el HTML que se enviará por e-mail
       
        $email = $email_client;

        $asunto = 'Tienda Web - Resumen de tu pedido';
        $html .= "<div style='width:80%;padding: 100px; background: #E4EDF6;border:10px solid #000000;'>
                                                <h1>COMPRA PRODUCTOS TIENDA WEB</h1>
                                                <p>Hola <b>$nombre</b>,</p>
                                                <p>Tu solicitud de compra ha sido realizada con éxito.
                                                Gracias por comprar en tienda web. Aquí te adjuntamos el resumen de tu pedido.</p>";

        $html .= "<h3>Datos del Comprador</h3>";
        $html .= "<b>Nombre</b>                   : " . $nombre . "<br>";
        $html .= "<b>Apellido</b>                 : " . $apellido . "<br>";
        $html .= "<b>E-mail del comprador</b>     : " . $email_client . "<br>";
        $html .= "<b>Calle del comprador</b>      : " . $calle_client . "<br>";
        $html .= "<b>Ciudad del comprador</b>     : " . $ciudad_client . "<br>";
        $html .= "<b>País del comprador</b>       : " . $pais_client . "<br>";
        $html .= "<b>Zona Residencia comprador</b>: " . $zonaRes_client . "<br>";
        $html .= "<hr>";
        $html .= "<b>Total de la compra</b>       : <b><span style='font-size:14px;'>" . $total_pedido . "€</span></b><br>";



        $cabeceras = "Content-type: text/html\r\n";

        /* Si no funciona enviar el mail desde localhost, probamos a imprimir en
          pantalla la información que se enviara al mail del cliente. */
        echo "</br>$html</br>";

        //llamamos a una función para enviar el mail con la factura al cliente.
        mail($email, $asunto, $html, $cabeceras);
        ?>
    </div>
</div>
        <?php
        include("pie.php");
        include("cerrar_etiquetas.php");
        ?>