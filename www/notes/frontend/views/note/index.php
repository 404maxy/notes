<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $notes common\models\Note[] */
/* @var $note common\models\Note */

$this->title = 'Заметки';
?>

<div class="site-index">

  <div class="body-content">

    <div class="row">

      <div class="col-md-4">
        <button class="btn btn-success w-100" id="add-form-button">Добавить заметку</button>
        <ul class="list-group pt-1">
            <?php foreach ($notes as $note): ?>
              <li class="list-group-item"><?= Html::a(Html::encode($note->title), ['view', 'id' => $note->id]) ?></li>
            <?php endforeach; ?>
        </ul>
      </div>

      <div class="col-md-8">

        <div id="note">

          <h2 id="header">Название заметки</h2>
          <div id="body">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
            labore et
            dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex
            ea
            commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat
            nulla pariatur.
          </div>

          <div class="pt-3">
            <div class="row">
              <div class="col">
                <button class="btn btn-primary float-start">Редактировать</button>
              </div>
              <div class="col">
                <button class="btn btn-danger float-end">Удалить</button>
              </div>
            </div>
          </div>

        </div>

        <form action="note/create" method="post" id="form" class="d-none">
          <div class="mb-3">
            <label for="title" class="form-label">Заголовок</label>
            <input type="text" name="title" class="form-control" id="title" placeholder="Новая заметка">
          </div>

          <div class="mb-3">
            <label for="body" class="form-label">Текст</label>
            <textarea class="form-control" name="body" id="body" rows="3"
                      placeholder="В этот прекрасный день..."></textarea>
          </div>

          <div class="pt-3">
            <div class="row">
              <div class="col">
                <button class="btn btn-danger float-start" id="cancel-button">Отмена</button>
              </div>
              <div class="col">
                <button class="btn btn-primary float-end">Сохранить</button>
              </div>
            </div>
          </div>

        </form>

      </div>
    </div>

  </div>
</div>
