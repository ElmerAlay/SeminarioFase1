<?php
$json = file_get_contents('http://18.224.229.65:4000/productos');
$obj = json_decode($json);

$longitud = count($obj);


/*{
    echo $obj[$i]->nombre;
	echo "<br>";
}*/
//echo $obj[0]->nombre;
?>


    <!DOCTYPE html>
    <html>

    <head>
        <title>Ecommerce</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o" crossorigin="anonymous"></script>

    </head>

    <body>
        <div>
            <div>
                <h1 align="center" class="text-primary">LISTADO DE PRODUCTOS</h1>
            </div>
            <div class="col-8 mx-auto">
                <table class="table table-striped">
                    <thead class="bg-warning">
                        <tr align="center" class="text-primary">
                            <th scope="col">Codigo</th>
                            <th scope="col">Producto</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php 
                                for($i=0; $i<$longitud; $i++){
                                ?>
                        <tr>
                            <td>
                                <?php echo $obj[$i]->idproducto ?>
                            </td>
                            <td>
                                <?php echo $obj[$i]->nombre ?>
                            </td>
                        </tr>
                        <?php   
                                }
                            ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>

    </html>
