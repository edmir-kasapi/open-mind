<?php

require_once('Repositories/UserRepository.php');
require_once('Repositories/PostRepository.php');

class AdminService
{
    private $userRepository;
    private $postRepository;

    public function __construct()
    {
        $this -> userRepository = new UserRepository();
        $this -> postRepository = new PostRepository();
    }

    public function getUserData($id, $currentPage, $options)
    {
        $users = $this -> userRepository -> getAllUsersForAdmin($id, $currentPage, $options);
        $userData = [];

        foreach($users as $user)
        {
            $userData[] = $this -> userRepository -> getUserInfo($user -> __get('user_id'));
        }

        return  $userData;
    }

    public function getUserCount($id, $options)
    {
        return $this -> userRepository -> getAllUsersCount($id, $options);
    }

    public function getStats($id)
    {
        $totalUsercount = $this -> userRepository -> getAllUsersCount($id);
        $adminCount = $this -> userRepository -> getAdminUsersCount($id);
        $normalUsersCount = $this -> userRepository -> getNormalUserscount($id);
        $totalPostCount = $this -> postRepository -> getAllPostsCount($id);
        $profilePicturesCount = $this -> userRepository -> getProfilePicturesCount($id);
        $postPicturesCount = $this -> postRepository -> getPostPicturesCount($id);
        $totalPictureCount = $profilePicturesCount[0]['value'] + $postPicturesCount[0]['value'];

        $stats = [
            'total_registered' => $totalUsercount[0]['value'],
            'total_admins' => $adminCount[0]['value'],
            'total_users' => $normalUsersCount[0]['value'],
            'total_posts' => $totalPostCount[0]['value'],
            'total_profile_pictures' => $profilePicturesCount[0]['value'],
            'total_post_pictures' => $postPicturesCount[0]['value'],
            'total_pictures' => $totalPictureCount
        ];

        return $stats;
    }
}

?>