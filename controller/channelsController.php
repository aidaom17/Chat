<?php

require_once __DIR__ . '/../model/libraryservice.class.php';

class ChannelsController
{
    public function myChannels()
    {
        $ls = new LibraryService();

        $title = 'My channels';
        $channelList = $ls->getChannelsByUser($_SESSION['username']);

        require_once __DIR__ . '/../view/channels_index.php';
    }
    public function index()
    {
        //stvara novi libraryservice
        $ls = new LibraryService();

        $title = 'All channels';
        $channelList = $ls->getAllChannels();

        require_once __DIR__ . '/../view/channels_index.php';
    }
    public function create()
    {
        $title = 'Add new channel';

        //ispis forme za unos imena kanala
        require_once __DIR__ . '/../view/channels_create.php';
    }

    public function createResults()
    {
    
        if ( isset($_POST[ 'channel']) && preg_match('/^[A-Za-z0-9 .,]+$/', $_POST['channel']))
        {
            $ls = new LibraryService();

            $ls->addNewChannel($_POST['channel']); 
         
            $channelList = $ls->getAllChannels();

            $title = $_POST['channel'] . 'is added!';
            require_once __DIR__ . '/../view/channels_index.php';
        }
        else
        {
            $title = 'Try again';
            require_once __DIR__ . '/../view/channels_error.php'; 
        }
    }
    public function getChannel($mess_id)
    {
        $ls = new LibraryService();
        $channel = $ls->getChannelByMessage($mess_id);
         
        return $channel;
    }

}
?>