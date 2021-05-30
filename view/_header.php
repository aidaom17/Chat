<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Druga zadaća  </title>

<style>
    table { border-collapse: collapse; margin-left: 20px;}
    td, th {padding: 15px;}
    h1      {background-color: hsla(0, 90%, 40%, 0.5); 
            color:white; 
            padding: 10px;
            font-family: verdana; 
            margin-left: 10px;}
    h2{     margin-left:20px;}     
    th {    background-color: hsla(0, 20%, 40%, 0.3);}
    body {  font-family: verdana;}  
    input{  width: 20%;
            padding: 7px 7px;
            margin: 2px 0;
            box-sizing: border-box;}
    input[type=button]
    {
            background-color: #4CAF50;
            border: none;
            padding: 16px 32px;
            margin: 4px 2px;
    }
    a{      color:black}
    a:hover{color:hsla(0, 100%, 30%, 0.5);}
    li {    background-color:hsla(0, 90%, 40%, 0.3); padding: 10px;
            display: inline;
            margin-right: 20px; }
</style>
</head>
<body>
<h1>Chat!</h1>

    
        <ul>
            <li>
            <a href="index.php?rt=channels/myChannels">My channels </a>
            </li> 
            <li>
            <a href="index.php?rt=channels/index">All channels </a>
            </li>
            <li>
            <a href="index.php?rt=channels/create">New channel</a>
            </li> 
            <li>
            <a href="index.php?rt=messages/myMessages">My messages</a>
            </li>
            <li>
            <a href="index.php?rt=users/logOut">Log Out</a>
            </li>
        </ul>

    <hr>
    <h2> <?php echo $title; ?></h2>