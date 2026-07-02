<?php

require_once('Repositories/UserRepository.php');

require_once('Customexceptions/ValidationException.php');
require_once('Customexceptions/UserNotFoundException.php');

class UserService
{
    private $userRepository;

    public function __construct()
    {
        $this -> userRepository = new UserRepository();
    }

    public function getUserInfoId($id)
    {
        $result = $this -> userRepository -> getUserInfo($id);
        var_dump($result);

        if(!$result){
            throw new UserNotFoundException('User with this Id does not exist');
        }

        return $result;
    }

    public function changeProfilePicture($id, $file, $originalPicture) : void
    {
        $profilePicture = $this -> uploadProfilePicture($file);
        $this -> userRepository -> changeUserProfile($id, $profilePicture);
        $this -> removeProfilePicture($originalPicture);
    }

    public function clearProfilePicture($id, $picture) : void
    {
        $this -> userRepository -> removeUserProfile($id);
        $this -> removeProfilePicture($picture);
    }

    public function removeorphanedPicture($filename) : void
    {
        $this -> removeProfilePicture($filename);
    }

    private function uploadProfilePicture($file) : array
    {
        if ($file["error"] !== UPLOAD_ERR_OK) {
            switch ($file["image"]["error"]) {
                case UPLOAD_ERR_PARTIAL:
                    throw new FileUploadException("File only partially uploaded.");
                    break;
                case UPLOAD_ERR_NO_FILE:
                    throw new FileUploadException("No file was uploaded.");
                    break;
                case UPLOAD_ERR_EXTENSION:
                    throw new FileUploadException("File stopped by a php extension.");
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    throw new FileUploadException("File exceeds maximum size.");
                    break;
                case UPLOAD_ERR_INI_SIZE:
                    throw new FileUploadException("File exceeds maximum size in php.ini.");
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    throw new FileUploadException("File exceeds maximum form size.");
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    throw new FileUploadException("Temporary folder not found");
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    throw new FileUploadException("Failed to write file.");
                    break;
                default:
                    throw new FileUploadException("Unknown file error.");
                    break;
            }
        }

        $mime_types = ["image/gif", "image/png", "image/jpeg", "image/webp"];

        if (!in_array($file["type"], $mime_types)) {
            throw new FileUploadException("Invalid file type entered.");
        }

        $pathinfo = pathinfo($file["name"]);

        $base = bin2hex(random_bytes(32));
        $base = preg_replace("/[^\w-]/", "_", $base);

        $filename = $base . "." . $pathinfo["extension"];

        $destination = "Pictures/Uploads/Profile_Pictures/" . $filename;

        $i = 1;

        while (file_exists($destination)) {
            $filename = $base . "($i)." . $pathinfo["extension"];
            $destination = "Pictures/Uploads/Profile_Pictures/" . $filename;
            $i++;
        }

        if (!move_uploaded_file($file["tmp_name"], $destination)) {
            throw new FileUploadException("Failed to upload file.");
        }

        return array(
            'original_name' => $pathinfo['filename'],
            'hashed_name' => $base,
            'extension' => $pathinfo['extension'],
            'size' => $file['size']
        );
    }

    private function removeProfilePicture($filename) : void
    {
        $destination = "Pictures/Uploads/Profile_Pictures/";
        $destination .= $filename;

        if(file_exists($destination))
        {
            unlink($destination);
        }
    }

}

?>