<?php
$this->title = 'Заметки';
?>

<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-md-4">
                <button class="btn btn-primary w-100">Добавить заметку</button>
                <ul class="list-group pt-1">
                  <?php foreach ($content->notes as $note)  { ?>
                  <li class="list-group-item"><a href="<?= $note->id ?>"><?= $note->title ?></a></li>
                  <?php } ?>
                </ul>
            </div>
            <div class="col-md-8">
              <h2>Название заметки</h2>
              <div>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</div>
            </div>
        </div>

    </div>
</div>
