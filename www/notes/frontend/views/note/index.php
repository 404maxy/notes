<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Заметки';
?>

<div class="site-index">

  <div class="body-content">

    <div class="row">

      <div class="col-md-2">
        <button class="btn btn-success w-100" id="add-tag-button">Добавить тэг</button>
        <ul id="tags-list" class="list-group pt-1">
          <li class="list-group-item">Идёт загрузка списка тэгов...</li>
        </ul>
      </div>

      <div class="col-md-3">
        <button class="btn btn-success w-100" id="add-note-button">Добавить заметку</button>
        <ul id="notes-list" class="list-group pt-1">
          <li class="list-group-item">Идёт загрузка списка заметок...</li>
        </ul>
      </div>

      <div class="col-md-7">

        <div id="note">

          <h2 id="title">Заметки</h2>
          <div id="body">Сервис для управления своими заметками.</div>

          <div class="pt-3">
            <div class="row">
              <div class="col">
                <button class="btn btn-primary float-start" id="edit-button">Редактировать</button>
              </div>
              <div class="col">
                <button class="btn btn-danger float-end" id="delete-button">Удалить</button>
              </div>
            </div>
          </div>

        </div>

        <form action="/note/create" method="post" id="form" class="d-none">
          <div class="mb-3">
            <label for="form-title" class="form-label">Заголовок</label>
            <input type="text" name="title" class="form-control" id="form-title" placeholder="Новая заметка">
            <!--TODO: вывести поле с текстом ошибки -->
          </div>

          <div class="mb-3">
            <label for="form-body" class="form-label">Текст</label>
            <textarea class="form-control" name="body" id="form-body" rows="3"
                      placeholder="В этот прекрасный день..."></textarea>
            <!--TODO: вывести поле с текстом ошибки -->
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
