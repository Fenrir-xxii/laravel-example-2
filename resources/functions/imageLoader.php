<?php
namespace Functions\Images;

define("UPLOAD_FOLDER", dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'public/uploads' . DIRECTORY_SEPARATOR);

function uploadFile(array $uploadedFile): ?string
{
    $ext = pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);
    $localFileName = uniqid() . '.' . $ext;
    $localFile = UPLOAD_FOLDER  . $localFileName;

    if (move_uploaded_file($uploadedFile['tmp_name'], $localFile)) {
        return $localFileName;
    } else {
        return null;
    }
}
function deleteUploadedFile(string $filename): void
{
    @unlink(UPLOAD_FOLDER . $filename);
}