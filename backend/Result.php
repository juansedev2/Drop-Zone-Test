<?php
require_once "./Bootstrap.php";
$DB = new DBConnection();
$QB = new QueryBuilder($DB->getPDO());
$results = $QB->selectAll("users");
$results = $results[0];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado</title>
</head>
<body>
    <header>
        <?php
            var_dump($results);
        ?>
    </header>
    <main>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Cargo</th>
                    <th>Imagen</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?=$results["name"]?></td>
                </tr>
                <tr>
                    <td><?=$results["email"]?></td>
                </tr>
                <tr>
                    <td><?=$results["position"]?></td>
                </tr>
                <tr>
                    <?php
                    ?>
                    <td><img src="../users-images/<?=$results['file_image_name']?>" alt="No se encontró la imagen"></td>
                </tr>
                <tr>
                    <td><?=$results["description"]?></td>
                </tr>
            </tbody>
        </table>
    </main>
</body>
</html>