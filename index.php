<?php
session_start();

if( isset( $_POST['username']))
    $_SESSION['username'] = $_POST['username'];
elseif ( !isset($_SESSION['username']) && !isset($_POST['ulogiraj_se']))
{
    require_once __DIR__ . '/controller/usersController.php';
    $con = new UsersController();
    $con->start();
    return;
}
elseif (isset($_SESSION['username']) && isset($_POST['ulogiraj_se']))
{
    require_once __DIR__ . '/controller/usersController.php';
    $con = new UsersController();
    $con->startResults();
}
if(isset($_POST['like'])) 
{
    require_once __DIR__ . '/controller/messagesController.php';
    $con = new MessagesController();
    $con->update( $_POST['like']); //dodaj jedan lajk na id poruke kojeg šaljemo
}
  
if ( isset($_GET['ch_id']))
{ 
    $_SESSION['ch_id'] = $_GET['ch_id'];
    echo $_SESSION['ch_id'];
    require_once __DIR__ . '/controller/messagesController.php';
    $con = new MessagesController();
    $con->searchResults( $_GET['ch_id']);
}
if( isset($_GET['mess_id']))
{
    $_SESSION['mess_id'] = $_GET['mess_id'];

    require_once __DIR__ . '/controller/channelsController.php';
    $con = new ChannelsController();
    $channel = $con->getChannel($_GET['mess_id']);
    
    require_once __DIR__ . '/controller/messagesController.php';
    $con = new MessagesController();
    $con->searchAndSpecialPrint( $channel);  
    
}
if (isset($_POST['new_mess']) && isset($_POST['send_mess']))
{
    require_once __DIR__ . '/controller/messagesController.php';
    $con = new MessagesController();
    $con->update_mess($_POST['new_mess']);
}

if ( !isset( $_GET['rt']) ) 
{

    $controller = 'channels'; 
    $action = 'myChannels'; 
}
else
{
    $parts = explode ('/', $_GET['rt']); 

    if( isset($parts[0]) && preg_match( '/^[A-Za-z0-9]+$/', $parts[0])) 
        $controller = $parts[0];
   
    else
        $controller = 'channels'; 

    //akcija
    if( isset($parts[1]) && preg_match( '/^[A-Za-z0-9]+$/', $parts[1])) 
        $action = $parts[1];
    else 
        $action = 'myChannels';
    
}
$controllerName = $controller . 'Controller';


if ( !file_exists(__DIR__ . '/controller/' . $controllerName . '.php')) //nepostoji
    error_404(); 

require_once __DIR__ . '/controller/' . $controllerName . '.php'; 


if ( !class_exists( $controllerName))
    error_404();

$con = new $controllerName();

if ( !method_exists( $con, $action)) 
    error_404();

$con->$action();
exit(0);

//--------------------------------------------

function error_404()
{
    require_once __DIR__ . '/controller/_404Controller.php'; 
    $con = new _404Controller();
    $con->index();
    exit(0);
    
}

?>