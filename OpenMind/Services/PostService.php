<?php

require_once('Repositories/PostRepository.php');
require_once('Repositories/UserRepository.php');

require_once('CustomExceptions/ValidationException.php');

class PostService
{
    private $postRepository;

    public function __construct()
    {
        $this -> postRepository = new PostRepository();
        $this -> userRepository = new UserRepository();
    }

    public function createPost($id, $content, $pictures)
    {
        //it is structured in a way that validation happpens before uploading and database entry
        $this -> validatePostcontent($content); //since validating post content is trivial, it is done first to save time
        $postPhotos = $this -> uploadPostPictures($pictures); //the pictures are validated and uploaded to the storage
        var_dump($postPhotos);
        $this -> postRepository -> createUserPost($id, $content, $postPhotos);
    }

    public function getAllPostsData()
    {
        $posts = $this -> postRepository -> getAllPosts();

        $postData = [];

        foreach($posts as $post)
        {
            $postUser = $this -> userRepository -> getUserInfo($post['user_id']);
            $postPictures = $this -> postRepository -> getPostPhotos($post['post_id']);

            $postData[] = array(
                "post_info" => $post,
                "post_user" => $postUser,
                "post_pictures" => $postPictures
            );
        }

        return $postData;

    }

    public function getPostInfo($id)
    {
        $post = $this -> postRepository -> getPostInfo($id);

        if(!$post)
        {
            return false;
        }

        $postUser = $this -> userRepository -> getUserInfo($post['user_id']);
        $postPictures = $this -> postRepository -> getPostPhotos($id);

        return array(
                "post_info" => $post,
                "post_user" => $postUser,
                "post_pictures" => $postPictures
            );
    }

    public function editPostContent($idPost, $idUser, $content)
    {
        $this -> validatePostContent($content);
        $this -> postRepository -> updatePostContent($idPost, $idUser, $content);
    }

    public function addPostPhotos($id, $pictures)
    {
        $postPhotos = $this -> uploadPostPictures($pictures); //the pictures are validated and uploaded to the storage
        $this -> postRepository -> insertPostPhotos($id, $postPhotos);

    }

    public function removePostImage($idPhoto, $idPost)
    {
        $image = $this -> validatePhotoID($idPhoto, $idPost);
        $this -> removePostPicture( $image['photo_hash_name'] .'.'. $image['photo_extension'] );
        $this -> postRepository -> removePhoto($idPhoto, $idPost);

    }

    public function deletePost($post, $idUser)
    {
        foreach($post['post_pictures'] as $image)
        {
            $this -> removePostImage($image['photo_id'], $post['post_info']['post_id']);
        }
        
        $this -> postRepository -> deletePost($post['post_info']['post_id'], $idUser);
    }

    private function validatePostContent($content)
    {
        $errors = [];

        if(trim($content) == '' )
        {
            $errors[] = 'Post content cannot be empty.';
        }

        if(strlen($content) > 500)
        {
            $errors[] = 'Post content must not exceed 500 characters.';
        }

        if(!empty($errors))
        {
            throw new ValidationException(implode(' ', $errors));
        }

    }

    private function uploadPostPictures($pictures) : array
    {
        //var_dump($pictures);
        $uploadsInfo = []; //the picture info will be saved here

        if(empty($pictures['tmp_name']))
        {
            return $uploadsInfo; //If no file was uploaded, the temp folder will be empty, so we return an empty array
        }

        $fileNum = count($pictures['name']);

        //each picture is validated first before being uploaded
        for ($i = 0; $i < $fileNum; $i++)
        {
             //file errors are checked here
            if ($pictures["error"][$i] !== UPLOAD_ERR_OK) {
                switch ($pictures["error"][$i]) {
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

            //picture types are checked here
            $mime_types = ["image/gif", "image/png", "image/jpeg", "image/webp"];

            if (!in_array($pictures["type"][$i], $mime_types)) {
                throw new FileUploadException("Invalid file type entered.");
            }

        }

        //each picture is uploaded here
        for ($i = 0; $i < $fileNum; $i++)
        {
            $pathinfo = pathinfo($pictures["name"][$i]);
            $base = bin2hex(random_bytes(32));
            $base = preg_replace("/[^\w-]/", "_", $base);

            $filename = $base . "." . $pathinfo["extension"];

            $destination = "Pictures/Uploads/Post_Pictures/" . $filename;

            $j = 1;

            while (file_exists($destination)) {
                $base = $base . "($j).";
                $filename = $base . $pathinfo["extension"];
                $destination = "Pictures/Uploads/Post_Pictures/" . $filename;
                $i++;
            }

            if (!move_uploaded_file($pictures["tmp_name"][$i], $destination)) {
                throw new FileUploadException("Failed to upload file.");
            }

           $uploadsInfo[] = array(
                'original_name' => $pathinfo['filename'],
                'hashed_name' => $base,
                'extension' => $pathinfo['extension'],
                'size' => $pictures['size'][$i]
            );

        }

        return $uploadsInfo;
    }

    private function validatePhotoId($idPhoto, $idPost)
    {
        $result = $this -> postRepository -> getPostPhotoInfo($idPhoto, $idPost);
        
        if(!$result)
        {
            throw new ValidatioNexception("Invalid photo ID. Cannot delete.");
        }

        return $result;
    }

    private function removePostPicture($filename) : void
    {
        $destination = "Pictures/Uploads/Post_Pictures/";
        $destination .= $filename;

        if(file_exists($destination))
        {
            unlink($destination);
        }
    }

}

?>