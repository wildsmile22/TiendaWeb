<?php
//Iniciamos o continuamos sesion
session_start();

$titulo = "Tienda Web";
include("conecta.php");
include("meta_tags.php");
include("cabecera.php");


/* Recuperamos los productos del carro de la compra */

function recuperar_productos() {
    $contador = 0;
    //recorremos el array de SESION hasta el final
    foreach ($_SESSION['carro'] as $id => $x) {
        $contador++; //Numero de item que despues usaremos en el atribute name de los inputs 
        $resultado = mysql_query("SELECT id, producto, precio FROM productos WHERE id=$id");
        $mifila = mysql_fetch_array($resultado);
        $id = $mifila['id'];
        $producto = $mifila['producto'];
        //acortamos el nombre del producto a 40 caracteres
        $producto = substr($producto, 0, 40);
        $precio = $mifila['precio'];
        ?>
        <input name="item_number_<?php echo $contador; ?>" type="hidden" value="<?php echo $id; ?>">
        <input name="item_name_<?php echo $contador; ?>" type="hidden" value="<?php echo $producto; ?>"> 
        <input name="amount_<?php echo $contador; ?>" type="hidden" value="<?php echo $precio; ?>"> 
        <input name="quantity_<?php echo $contador; ?>" type="hidden" value="<?php echo $x; ?>"> 
        <?php
    }
}
?>
<div id="derecha">

    <h1>Conectando con Paypal ...... </h1>

    <div class='text-border'>
        <!-- La direccion de llamada del formulario de pruebas es https://www.sandbox.paypal.com/cgi-bin/webscr 
             pero al pasar a ventas reales deberemos indicar https://www.paypal.com/cgi-bin/webscr
                 
                 
        -->
        <form name='formTpv' method='post' action='https://www.sandbox.paypal.com/cgi-bin/webscr' style="border: 1px solid #CECECE;padding-left: 10px;">
            <input name="cmd" type="hidden" value="_cart"> 
            <input name="upload" type="hidden" value="1">
            <input name="business" type="hidden" value="luisfelizj8-facilitator@gmail.com">
            <input name="shopping_url" type="hidden" value="http://localhost/varios/paypal/carro/productos.php">
            <input name="currency_code" type="hidden" value="EUR">
            <input name="return" type="hidden" value="http://localhost/TiendaWeb/exito.php">
            <input type='hidden' name='cancel_return' value='http://localhost/varios/paypal/carro/errorPaypal.php'>
            <input name="notify_url" type="hidden" value="http://localhost/varios/paypal/carro/paypalipn.php">
            <input name="rm" type="hidden" value="2">

            <?php
            recuperar_productos();
            ?>
            <!-- VARIABLES PAYPAL UTILIZADAS
                  cmd > indica el tipo de fichero que va a recoger PayPal 
                  _cart : varios items
                  _donations : donaciones
                  _xclick : boton de compra
                  business > indica el identificador del negocio registrado en paypal. Ejemplo : buyer_1265883185_biz@gmail.com
                  shopping_url > la direccion de nuestra tienda online .
                  currency_code > el tipo de moneda (USD , EUR ...)
                  return > sera el enlace de vuelta a nuestro negocio que ofrece paypal
                  notify_url > en esta pagina es donde recogeremos el estado del pago y un gran numeros de variables con informacion adicional en nuestro caso lo hemos llamado paypal_ipn.php
                  rm > Indica el metodo que se va a utilizar para enviar la informacion de vuelta a nuestro sitio. RM=1 informacion enviada por GET , RM=2 informacion enviada por POST
                  (En este caso usamos este metodo porque es un script php el que recoge los datos).
                  item_number_X > identificador del producto
                  item_name_X > nombre del producto
                  amount_X > precio del producto
                  quantity_X > cantidad del producto
            -->
        </form>
        <!-- Esto hara que se envie la informacion sin necesidad de hacer clic en ningon boton -->
        <script type='text/javascript'>
            document.formTpv.submit();
        </script>
    </div> <!-- Cierro text-border -->
</div> <!-- Cierro derecha -->

<?php
include("pie.php");
include("cerrar_etiquetas.php");
?>