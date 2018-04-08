<?php

/* @var $this yii\web\View */

$this->title = 'Bitcoin Bot Users that already joined!';
?>
<div class="site-index">

    <div class="jumbotron">

        <h1><?= count($users)?> users already joined us!</h1>

        <p class="lead">Bitcoin assistant users</p>

        <center>

        <table>
        <tr>

        <?php
        foreach ($users as $key => $user) {

            if ($key % 6 == 0) {
                echo '</tr><tr>';
            }

            echo '<td style="padding: 10px">';
            echo '<img src="'.$user['pic'].'" height="150px">'."<BR>";
            echo $user['firstname'].' '.$user['lastname'].', '.strtoupper(substr($user['locale'], 0, 2))."<BR>";
            echo '</td>';

        }
        ?>

        </tr>
        </table>
        </center>

    </div>

</div>
