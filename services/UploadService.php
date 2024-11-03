<?php

class UploadService
{
    public static function uploadImage(array $image, ?string $uploadDir = "uploads/"): array
    {
        if ($image['error'] !== UPLOAD_ERR_OK) {
            return ["success" => false, "error" => "Грешка при качването на файла."];
        }

        $allowedMimeTypes = ['image/jpeg', 'image/png'];
        $fileMimeType = mime_content_type($image['tmp_name']);

        if (!in_array($fileMimeType, $allowedMimeTypes)) {
            return ["success" => false, "error" => "Разрешени са само JPG и PNG формати."];
        }

        $fileExtension = pathinfo($image['name'], PATHINFO_EXTENSION);
        $uniqueFileName = $image['name'] . "_" . uniqid() . '.' . $fileExtension;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $uploadFilePath = $uploadDir . $uniqueFileName;

        if (move_uploaded_file($image['tmp_name'], $uploadFilePath)) {
            return [
                "success" => true,
                "data" => [
                    "path" => $uploadFilePath,
                ]
            ];
        } else {
            return ["success" => false, "error" => "Неуспешно качване на файла."];
        }
    }
}
