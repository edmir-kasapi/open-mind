<?php

require_once('Repository.php');

class PostRepository extends Repository
{
    function createUserPost($id, $content, $photos)
    {
        $query = "INSERT INTO posts(user_id, post_content, date_created)
                  VALUES ( :userID, :content, CURRENT_TIMESTAMP() );";
        $statement = $this -> pdo -> prepare($query);

        $statement -> execute([
            ":userID" => $id,
            ":content" => $content
            ]);

        $postId = $this -> pdo ->lastInsertID();

        $this -> insertPostPhotos($postId, $photos);
        
    }

    public function getAllPosts()
    {
        $query = "SELECT * FROM posts;";
        $statement = $this -> pdo -> prepare($query);

        $statement -> execute();

        $postData = $statement -> fetchAll(PDO::FETCH_ASSOC);
        return $postData;
    }

    public function getPostInfo($id)
    {
        $query = "SELECT * FROM posts WHERE post_id = :postId;;";
        $statement = $this -> pdo -> prepare($query);

        $statement -> execute([
            ":postId" => $id
        ]);

        $result = $statement -> fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getPostPhotos($id)
    {
        $query = "SELECT * FROM photos WHERE post_id = :postId";
        $statement = $this -> pdo -> prepare($query);

        $statement -> execute([
            ":postId" => $id
        ]);

        $result = $statement -> fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function updatePostContent($idPost, $idUser, $content)
    {
        $query = "UPDATE posts SET post_content = :postContent WHERE post_id = :postId AND user_id = :userId";
        $statement = $this -> pdo -> prepare($query);

        $statement -> execute([
            ":postContent" => $content,
            ":postId" => $idPost,
            ":userId" => $idUser
        ]);
    }

    public function insertPostPhotos($id, $photos)
    {
        foreach($photos as $photo)
        {
            $this -> addPostPhoto($id, $photo);
        }
    }

    public function getPostPhotoInfo($idPhoto, $idPost)
    {
        $query = "SELECT * FROM photos WHERE photo_id = :photoId AND post_id = :postId";
        $statement = $this -> pdo -> prepare($query);

        $statement -> execute([
            ":photoId" => $idPhoto,
            ":postId" => $idPost
        ]);

        $result = $statement -> fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public function removePhoto($idPhoto, $idPost)
    {
        $query = "DELETE FROM photos WHERE photo_id = :photoId AND post_id = :postId";
        $statement = $this -> pdo -> prepare($query);

        $statement -> execute([
            ":photoId" => $idPhoto,
            ":postId" => $idPost
        ]);
    }

    public function deletePost($idPost, $idUser)
    {
        $query = "DELETE FROM posts WHERE post_id = :postId AND user_id = :userId";
        $statement = $this -> pdo -> prepare($query);

        $statement -> execute([
            ":postId" => $idPost,
            ":userId" => $idUser
        ]);
    }

    private function addPostPhoto($id, $picture)
    {
        $query2 = "INSERT INTO photos(photo_hash_name, photo_original_name, photo_extension, photo_size, photo_type, post_id)
                   VALUES (:photoHashName, :photoOriginalName, :photoExtension, :photoSize, :photoType, :postId);";
        $statement2 = $this -> pdo -> prepare($query2);
        $statement2 -> execute([
            ":photoHashName" => $picture['hashed_name'],
            ":photoOriginalName" => $picture['original_name'],
            ":photoExtension" => $picture['extension'],
            ":photoSize" => $picture['size'],
            ":photoType" => 'POST',
            ":postId" => $id
        ]);
    }

}

?>