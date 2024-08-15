<?php
require_once "./Bootstrap.php";
$DB = new DBConnection();
$QB = new QueryBuilder($DB->getPDO());

// Then get DATA
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // First get text data
    $name = $_POST["name"] ?? null;
    $email = $_POST["email"] ?? null;
    $phone = $_POST["phone"] ?? null;
    $position = $_POST["position"] ?? null;
    $description = $_POST["description"] ?? null;

    if (!isset($email, $email, $phone, $position, $description)) {
        echo "Formulario incompleto, por favor revisar  y llenarlo de nuevo";
        return;
    }

    // So we have to do many validations of the file
    if (!isset($_FILES['image_file']) || $_FILES['image_file']['error'] !== 0) {
        echo "El archivo no se ha subido correctamente, por favor revisar el tamaño de la imagen y que se haya subido al formulario";
        return;
    }

    $APP_PATH = $_SERVER["DOCUMENT_ROOT"]; // Path of the project
    $filename = $_FILES['image_file']['name']; // Get the file of the name uploaded
    $sanitizedFilename = sanitizeFileName($filename); // Clean the name of the file
    $uploadDir = $APP_PATH . "/development/drop-zone-test/users-images/";  // Directory to save the files
    $uploadFile = $uploadDir . $sanitizedFilename; // Route to save the file
    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg']; // Only avalible types of the file in this case

    // Validate Size
    if ($_FILES['image_file']['size'] > 3145728) {
        echo "El archivo es demasiado grande.";
        return;
    }

    // Validate extension
    if (!in_array($_FILES['image_file']['type'], $allowedTypes)) {
        echo "El tipo de archivo no está permitido.";
        return;
    }

    // MIME validation
    $allowed_mime_types = ['image/jpeg', 'image/png', 'image/gif'];
    $file_mime = mime_content_type($_FILES['image_file']['tmp_name']);
    //die(var_dump(mime_content_type($_FILES['image_file']['tmp_name'])));

    if (!in_array($file_mime, $allowed_mime_types)) {
        echo "El tipo de archivo no está permitido.";
        return;
    }

    // Additional valitaion with the size

    $image_info = getimagesize($_FILES['image_file']['tmp_name']);
    if ($image_info === false) {
        echo "El tipo de archivo como imagen no es válido";
        return;
    }


    if (move_uploaded_file($_FILES['image_file']['tmp_name'], $uploadFile)) {

        $data = [
            "name" => $name,
            "email" => $email,
            "position" => $position,
            "file_image_name" => $sanitizedFilename,
            "description" => $description
        ];

        $result = $QB->create("users", $data);
        if ($result) {
            echo "<h1>Insertado correctamente</h1>";
        } else {
            echo "<h1>ERROR!</h1>";
        }

        return;
    } else {
        echo var_dump($uploadFile);
        echo "Error al mover el archivo subido al directorio indicado";
        return;
    }
} else {
    echo "<h1>NO RECIBÍ UNA PETICIÓN POST";
    return;
}
