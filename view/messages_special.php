<?php require_once __DIR__ . '/_header.php' ?>


<form action="index.php" method="post">
    <table>
    <tr> 
        <th>User </th>
        <th>Date </th>
        <th>Message </th>
        <th>Thumbs-up </th>
    </tr>

    <?php
    $i = 0;
    foreach ($messageList as $message)
    {
        echo '<tr>';
        echo '<td>'. $userList[$i]. '</td>';
        echo '<td>'. $message->date. '</td>';
        echo '<td>'. $message->content. '</td>';
        echo '<td><button type="submit" name="like" value="' . $message->id.'">'. $message->thumbs_up. '</button></td>';
        echo '</tr>';
        $i++;
    }
    ?>

    </table>
<br><br>
<input type="text" name="new_mess" size="50" placeholder="Add new message">
<button type="submit" name="send_mess">Submit!</button>
</form>

<?php require_once __DIR__ . '/footer.php' ?>
