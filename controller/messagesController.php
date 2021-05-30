<?php

require_once __DIR__ . '/../model/libraryservice.class.php';

class MessagesController
{
    public function myMessages()
    {
        $ls = new LibraryService();

        $title = 'My messages';
        $messageList = $ls->getMessagesByUser($_SESSION['username']);
        
        require_once __DIR__ . '/../view/messages_and_channel.php';
    }
    public function searchResults($channel_id)
    {
        $ls = new LibraryService();
        $messageList = $ls->getMessagesByChannel($channel_id);

        $title = 'Messages';

        require_once __DIR__ . '/../view/messages_index.php'; 
    }
    public function searchAndSpecialPrint( $channel)
    {
        $ls = new LibraryService();
        $messageList = $ls->getMessagesByChannel($channel->id);
        $userList = $ls->getUsersByMessages( $messageList); 
         
        $title = $channel->name;
        $_SESSION['ch_name'] = $channel->name;

        require_once __DIR__ . '/../view/messages_special.php'; 

    }
    public function update($message_id)
    {
        $ls = new LibraryService();

        $ls->addLike( $message_id);
        $channel = $ls->getChannelByMessage($message_id);
        $messageList = $ls->getMessagesByChannel($channel->id);
        $userList = $ls->getUsersByMessages( $messageList);
        
        $title = $_SESSION['ch_name'];

        require_once __DIR__ . '/../view/messages_special.php'; 
    }
    public function update_mess($content)
    {
        $ls = new LibraryService();
        $channel_id = $ls->addMessage($content);
        $messageList = $ls->getMessagesByChannel($channel_id);
        $userList = $ls->getUsersByMessages( $messageList);

        $title = $_SESSION['ch_name'];

        require_once __DIR__ . '/../view/messages_special.php'; 

    }
}
?>