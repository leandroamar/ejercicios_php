<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$aEmpleados= array();
$aEmpleados[] = array("dni" => "33300123",
                   "nombre" => "David García",
                   "bruto" => "7055025",
);

$aEmpleados[] = array("dni" => "40874456",
                   "nombre" => "Ana del Valle",
                   "bruto" => "7470000",
);

$aEmpleados[] = array("dni" => "67567565",
                   "nombre" => "Andrés Perez",
                   "bruto" => "83000000",
);

$aEmpleados[] = array("dni" => "75744545",
                   "nombre" => "Victoria Luz",
                   "bruto" => "5810000",
);


function calcularNeto($bruto) {
    return $bruto - ($bruto * 0.17);
}

?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Listado de empleados</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="htdocs\php\estilos.css">   
    </head>
    <body>
        <main class="container">
                <div class="row">
                    <div class="col-12 py-5">
                        <h1 class="text-center">Listado de Empleados</h1>
                    </div>
                </div>
            <table class="table border table-hover">
                <tr>
                    <th>DNI</th>
                    <th>Nombre</th>
                    <th>Sueldo</th>
                </tr>
                    <?php
                    foreach ($aEmpleados as $empleado) { ?>
                        </tr>
                            <td><?php echo $empleado["dni"]; ?></td>
                            <td><?php echo strtoupper($empleado["nombre"]); ?></td>
                            <td><?php echo "$" . number_format(calcularNeto($empleado["bruto"]), 2, ",", "."); ?></td>
                        </tr>
                    <?php } ?>
            </table>
            <?php
          function contar($aEmpleados) {
           $contador = 0;
           foreach ($aEmpleados as $item){
             $contador++;
           }
           return $contador;
        }
            echo "Cantidad de empleados activos : " . contar($aEmpleados); ?>
        </main>
    </body>
</html>