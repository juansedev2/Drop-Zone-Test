<?php
require_once "./Bootstrap.php";
$DB = new DBConnection();
$QB = new QueryBuilder($DB->getPDO());

// Then get DATA
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // First get text data
    $name = $_POST["name"] ?? null;
    $email = $_POST["email"] ?? null;
    $phone = $_POST["phone"] ?? null;
    $position = $_POST["position"] ?? null;
    $description = $_POST["description"] ?? null;

    if(!isset($email, $email, $phone, $position, $description)){
        echo "Formulario incompleto, por favor revisar  y llenarlo de nuevo";
        return;
    }

    // Then validate the files
    if(isset($_FILES['image_file']) && $_FILES['image_file']['error'] === 0){

        $APP_PATH = $_SERVER["DOCUMENT_ROOT"];
        $filename = $_FILES['image_file']['name'];
        $sanitizedFilename = sanitizeFileName($filename);
        $uploadDir = $APP_PATH . "/drop-zone-test/users-images/";
        $uploadFile = $uploadDir . $sanitizedFilename;
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];


        if ($_FILES['image_file']['size'] > 3145728) {
            echo "El archivo es demasiado grande.\n";
            return;
        }

        if (!in_array($_FILES['image_file']['type'], $allowedTypes)) {
            echo "El tipo de archivo no está permitido.\n";
            return;
        }

        if (move_uploaded_file($_FILES['image_file']['tmp_name'], $uploadFile)) {
            echo "El archivo es válido y fue subido exitosamente";
            return;
        } else {
            echo var_dump($uploadFile);
            echo "Error al mover el archivo subido al directorio indicado";
            return;
        }

    }else{
        echo "El archivo no se ha subido correctamente, por favor revisar el tamaño de la imagen y que se haya subido al formulario";
    }

}else{
    echo "<h1>NO RECIBÍ UNA PETICIÓN POST";
}