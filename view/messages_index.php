<?php require_once __DIR__ . '/_header.php' ?>

<table>
    <tr> 
        <th>Messages </th>
    </tr>

    <?php
    foreach( $messageList as $message)
    {
        echo '<tr>';
        echo '<td>'. $message->content. '</td>';
        echo '</tr>';
    }
    ?>

</table>

<?php require_once __DIR__ . '/footer.php' ?>
