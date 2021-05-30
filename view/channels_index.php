<?php require_once __DIR__ . '/_header.php'; ?>

<table>
    <tr> 
        <th>Channel name</th>
        <th>Channel ID</th>
    </tr>

    <?php
    foreach( $channelList as $channel)
    {
        echo '<tr>';
        echo '<td><a href="index.php?ch_id='.$channel->id.' ">'. $channel->name . '</a></td>';
        echo '<td>'. $channel->id . '</td>';
        echo '</tr>';
    }
    ?>

</table>

<?php require_once __DIR__ . '/footer.php'; ?>
