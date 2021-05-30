<?php

require_once __DIR__ . '/../model/libraryservice.class.php';

class UsersController
{
    
    public function start()
    {
        require_once __DIR__ . '/../view/users_start.php';
        
    }
    public function startResults()
    {
        $ls = new LibraryService();
        if( isset( $_POST['ulogiraj_se']))
            $ls->logIn($_POST['username'], $_POST['password']);
        
        $title = 'My channels';
        $channelList = $ls->getChannelsByUser($_SESSION['username']);

        require_once __DIR__ . '/../view/channels_index.php';
    }
    public function logOut()
    {
        session_unset();
        session_destroy();
        require_once __DIR__ . '/../view/users_start.php';

    }
}
?>