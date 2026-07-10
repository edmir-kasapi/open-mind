<?php

require_once('Repository.php');
require_once('Models/Post.php');

class PostRepository extends Repository
{
    function createUserPost($id, $content, $photos)
    {
        $postId = Post::store([
            'user_id' => $id,
            'post_content' => $content,
            'date_created' =>  date("Y/m/d")
        ]);

        $this -> insertPostPhotos($postId, $photos);
    }

    public function getAllPosts()
    {
        $postData = Post::all();

        return $postData;
    }

    public function getUserPosts($id)
    {
        $result = Post::where('user_id', '=', $id)
                ->getAllModels();;

        return $result;
    }

    public function getPostInfo($id)
    {
        $result = Post::find($id);

        return $result;
    }

    public function getPostPhotos($id)
    {
        $result =Photo::where('post_id', '=', $id)
                ->getAllModels();

        return $result;
    }

    public function updatePostContent($idPost, $idUser, $content)
    {
        Post::update(['post_content' => $content])
            -> where('post_id', '=', $idPost)
            -> where('user_id', '=', $idUser)
            -> execute(); 
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
        $result = Photo::find($idPhoto);

        return $result;
    }

    public function removePhoto($idPhoto, $idPost)
    {
        Photo::destroy($idPhoto);
    }

    public function deletePost($idPost, $idUser)
    {
        Post::destroy($idPost);
    }

    private function addPostPhoto($id, $picture)
    {
       Photo::store([
                "photo_hash_name" => $picture['hashed_name'],
                "photo_original_name" => $picture['original_name'],
                "photo_extension" => $picture['extension'],
                "photo_size" => $picture['size'],
                "photo_type" => 'POST',
                "post_id" => $id
            ]);
    }

    public function getAllPostsCount($id)
    {
        $result = Post::count('post_id')
            -> where('user_id', '!=', $id)
            -> getAll();

        return $result;
    }

    public function getPostPicturesCount($id)
    {
        $result = Photo::count('photo_id')
            -> join('posts', 'posts.post_id', '=', 'photos.post_id')
            -> where('photo_type', '=', 'POST')
            -> where('posts.user_id', '!=', $id)
            -> getAll();

        return $result;
    }
}

?>