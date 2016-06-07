
<div id="cabecera">

    <?php
    //nos devuelve la pagina donde estamos
    $a = explode('/', $_SERVER ['PHP_SELF']);
    $b = count($a);
    $pagina = $a[$b - 1];
    //echo "estoy en ". $pagina . "<br>";
    if ($pagina == 'productos.php') {
        ?>
        <a href="logout.php?logout">Sign Out</a>
        <!-- Informacion de la cesta-->
        <div id="totales" style="float:right;padding:10px 25px 0 100px; background-color: gainsboro">
            <table>

                <tr align="right">
                    <td><strong>Cantidad de Productos:</strong></td>
                    <td align="left"><?php
                        if (isset($_SESSION["cantidadTotal"]))
                            echo $_SESSION["cantidadTotal"];
                        else {
                            echo "Carro vacio";
                            $_SESSION["totalcoste"] = 0;
                        }
                        ?>
                    </td>
                </tr>
                <tr align="right">
                    <td><strong>Total Compra:</strong></td>
                    <td><?php echo $_SESSION["totalcoste"]; ?> </td>
                </tr>

                <tr>
                    <td align:right colspan=2>Ver <a href="carro.php?id=1&action=mostrar" title='lista de compra'>cesta de la compra</a></td>
                </tr>
            </table>
        </div>
        <!-- FIN CESTA-->
        <?php
    }
    ?>
</div>

