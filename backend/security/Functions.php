<?php

function sanitizeFileName($filename) {
    // Obtener la extensión del archivo
    $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);
    
    // Obtener el nombre del archivo sin la extensión
    $fileBaseName = pathinfo($filename, PATHINFO_FILENAME);
    
    // Reemplazar caracteres no alfanuméricos con un guion bajo
    $fileBaseName = preg_replace("/[^a-zA-Z0-9_-]/", "_", $fileBaseName);
    
    // Limitar la longitud del nombre del archivo (opcional, por ejemplo, 100 caracteres)
    $fileBaseName = substr($fileBaseName, 0, 100);
    
    // Recomponer el nombre del archivo con la extensión
    $sanitizedFileName = $fileBaseName . '.' . $fileExtension;
    
    return $sanitizedFileName;
}