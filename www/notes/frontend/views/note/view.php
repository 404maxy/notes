<?php
/* @var $note common\models\Note */

$this->title = $note->title;
?>

<h2><?= $note->title; ?></h2>
<div><?= $note->body; ?></div>