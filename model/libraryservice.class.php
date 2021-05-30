<?php
require_once __DIR__ . '/../app/database/db.class.php';
require_once __DIR__ . '/user.class.php'; 
require_once __DIR__ . '/channel.class.php'; 
require_once __DIR__ . '/message.class.php'; 

class LibraryService
{
    public function getAllChannels()
    {
        $channels = [];

        $db = DB::getConnection();

        $st = $db->prepare( 'SELECT * FROM dz2_channels');
        $st->execute();

        $svi_retci = $st->fetchAll();
        foreach( $svi_retci as $row)
        {
            $c = new Channel( $row['id'], $row['id_user'], $row['name']);
            $channels[] = $c; 
        }
        return $channels;
    }

    public function getChannelsByUser( $username) 
    {
        $channels =[];
    
        $db = DB::getConnection();

        $st = $db->prepare( 'SELECT id FROM dz2_users WHERE username=:us_name');
        $st->execute(['us_name'=> $username]);
        $row = $st->fetch();
        $id_user = $row['id'];

    
        $st = $db->prepare( 'SELECT * FROM dz2_channels WHERE id_user=:id_us');
        $st->execute(['id_us'=> $id_user]);

    
        $svi_retci = $st->fetchAll();
        foreach( $svi_retci as $row)
        {

            $c = new Channel( $row['id'], $row['id_user'], $row['name']);
            $channels[] = $c;  
        }
        return $channels;
    }
    public function getMessagesByUser( $username) 
    {
        $messages =[];
    
        $db = DB::getConnection();

        $st = $db->prepare( 'SELECT id FROM dz2_users WHERE username=:us_name');
        $st->execute(['us_name'=> $username]);
        $row = $st->fetch();
        $id_user = $row['id'];
        
        $st = $db->prepare( 'SELECT * FROM dz2_messages WHERE id_user=:id_us ORDER BY date DESC');
        $st->execute(['id_us'=> $id_user]);
    
        $svi_retci = $st->fetchAll();
        foreach( $svi_retci as $row)
        {
            $m = new Message( $row['id'], $row['id_user'], $row['id_channel'],
                            $row['content'], $row['thumbs_up'], $row['date']);
            $messages[] = $m;  
        }
        return $messages;
    }
    public function getMessagesByChannel($id_channel)
    {
        $messages =[];
    
        $db = DB::getConnection();
        $st = $db->prepare( 'SELECT * FROM dz2_messages WHERE id_channel=:id_ch ORDER BY date');
        $st->execute(['id_ch'=> $id_channel]);

    
        $svi_retci = $st->fetchAll();
        foreach( $svi_retci as $row)
        {
            $m = new Message( $row['id'], $row['id_user'], $row['id_channel'],
                            $row['content'], $row['thumbs_up'], $row['date']);
            $messages[] = $m; 
        }
        return $messages;

    }
    public function getUsersByMessages( $messageList)
    {
        $users = [];

        $db = DB::getConnection();

        foreach( $messageList as $message)
        {
            $st = $db->prepare( 'SELECT username FROM dz2_users WHERE id=:id_us');
            $st->execute(['id_us'=> $message->id_user]); 

            $row = $st->fetch();
            $users[] = $row['username'];
        }
        return $users;
    }

    public function addNewChannel( $name)
    {
        $db = DB::getConnection();

        $st = $db->prepare('SELECT id FROM dz2_users WHERE username=:user');
        $st->execute(['user'=> $_SESSION['username']]);
        $row = $st->fetch();
        $id = $row['id'];

        try
        {
            $st = $db->prepare( 'INSERT INTO dz2_channels(id_user, name) VALUES (:id_user, :name)' );
            $st->execute( array( 'id_user' => $id, 'name' => $name ) ); 
        }
        catch( PDOException $e ) { exit( "PDO error [dz2_channels]: " . $e->getMessage() ); }
    }

    public function getChannelByMessage($message_id)
    {
        $db = DB::getConnection();
    
        $st = $db->prepare('SELECT id_channel FROM dz2_messages WHERE id=:mess_id');
        $st->execute(['mess_id'=> $message_id]);
        $row = $st->fetch();
        $id_ch = $row['id_channel'];

        $st = $db->prepare('SELECT * FROM dz2_channels WHERE id=:ch_id');
        $st->execute(['ch_id'=> $id_ch]);
        $row = $st->fetch();

        $channel = new Channel($row['id'], $row['id_user'], $row['name']);

        return $channel;
    }
    public function logIn($username, $password)
    {
        $db = DB::getConnection();
    
        $st = $db->prepare('SELECT username,password_hash FROM dz2_users WHERE username=:user');
        $st->execute(['user'=> $username]);

        if( $st->rowCount() !== 1)
        {
            echo 'Taj korisnik ne postoji, pokušaj ponovno!<br><hr>';
            unset($_SESSION['username']);
            require_once __DIR__ . '/../view/users_start.php';
            return;
        }
        //u bazi smo postavili na username atribut=unique td ne mogu postojati 2 korisnika s istim usernameom
        $row = $st->fetch();
        $password_hash = $row['password_hash'];
        if( password_verify( $password, $password_hash ) )
            return;
        else
        {
            echo 'Korisnicko ime ili password nisu ispravani';
            unset($_SESSION['username']);
            require_once __DIR__ . '/../view/users_start.php';
            return;
        }
    }
    public function addLike($message_id)
    {
        $db = DB::getConnection();
        $st = $db->prepare('SELECT thumbs_up FROM dz2_messages WHERE id=:mess_id');
        $st->execute(['mess_id' => $message_id]);

        $row = $st->fetch();
        $koliko = $row['thumbs_up'] + 1;

        $st = $db->prepare('UPDATE dz2_messages SET thumbs_up=:t_up WHERE id=:mess_id');
        $st->execute(['t_up'=> $koliko, 'mess_id'=>$message_id]);
        
        return;
    }
    public function addMessage($content)
    {
        $db = DB::getConnection();

        
        $st = $db->prepare( 'SELECT id FROM dz2_users WHERE username=:us_name');
        $st->execute(['us_name'=> $_SESSION['username']]);
        $row = $st->fetch();
        $id_user = $row['id'];
        
        $st = $db->prepare( 'SELECT id FROM dz2_channels WHERE name=:chan_name');
        $st->execute(['chan_name'=> $_SESSION['ch_name']]);
        $row = $st->fetch();
        $chan_id = $row['id'];
        //podaci
        $thumbs = 0;
        $date = date("Y-m-d");
        $time = date("h:i:s");
        $today = $date .' '.$time;
        echo $today;

        $st = $db->prepare( 'INSERT INTO dz2_messages(id_user, id_channel, thumbs_up, content, date) VALUES (:user, :chann_id, :thumbs, :cont, :today)');
        $st->execute(['user' => $id_user, 'chann_id' => $chan_id, 'thumbs' => $thumbs, 'cont'=> $content, 'today'=>$today]);
        
        return $chan_id;

    }
}


?>