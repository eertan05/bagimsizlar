<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the file is uploaded and the form data is sent
if (isset($_FILES['photo']) && isset($_POST['targetFileName']) ) {
    // Get the uploaded file and form data
    $fileTmpPath = $_FILES['photo']['tmp_name'];  // Temporary file path
    $fileName = $_FILES['photo']['name'];  // Original file name
    $fileType = $_FILES['photo']['type'];  // MIME type of the file

    // Get form data
    $targetFileName = $_POST['targetFileName'];

    // Validate that form fields are not empty
    if (empty($targetFileName)) {
        echo json_encode(["error" => "o_id and o_name are required."]);
        exit;
    }

    // Define the target directory for saving the converted image
    $targetDir = __DIR__ . "/uploads/";

    // Sanitize and generate a unique filename
    $uniqueName = $targetFileName . '.png';
    $targetFilePath = $targetDir . $uniqueName;

    // Check the file MIME type and validate it
    $allowedFileTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/bmp'];
    if (!in_array($fileType, $allowedFileTypes)) {
        echo json_encode(['error' => 'Invalid file type. Only JPG, PNG, GIF, and BMP are allowed.']);
        exit;
    }

    // Create image resource from the uploaded file based on MIME type
    switch ($fileType) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($fileTmpPath);
            break;
        case 'image/png':
            $image = imagecreatefrompng($fileTmpPath);
            break;
        case 'image/gif':
            $image = imagecreatefromgif($fileTmpPath);
            break;
        case 'image/bmp':
            $image = imagecreatefrombmp($fileTmpPath);
            break;
        default:
            echo json_encode(['error' => 'Unsupported file type.']);
            exit;
    }

    // Ensure the target directory exists, or create it
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    // Convert the image to PNG and save it
    if (imagepng($image, $targetFilePath)) {
        imagedestroy($image); // Free memory
        echo json_encode(['success' => 'Image successfully uploaded and converted to PNG.', 'file_path' => $uniqueName]);
    } else {
        imagedestroy($image); // Free memory if error occurs
        echo json_encode(['error' => 'Failed to save the PNG image.']);
    }
} else {
    echo json_encode(['error' => 'No file or form data provided.']);
}

/**
 * Clean function to sanitize inputs for file names or other uses
 */
function clean($string) {
    return preg_replace('/[^a-zA-Z0-9_-]/', '', $string);  // Allow only alphanumeric, underscores, and hyphens
}
?>
