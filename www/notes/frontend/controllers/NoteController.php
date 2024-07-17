<?php

namespace frontend\controllers;

use common\models\Note;
use common\models\Tag;
use yii\db\StaleObjectException;
use yii\web\Response;
use Yii;
use yii\db\Exception;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

/**
 * Notes controller
 * Доступ возможен только после авторизации пользователя
 */
class NoteController extends Controller
{

    /**
     * Настройка доступа
     * @return array|array[]
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['*'], // для всех действий
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], // только для авторизованных пользователей
                    ],
                ],
            ],
        ];
    }

    /**
     * Отображение списка заметок
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Отображение списка заметок
     * TODO: тело заметок тут получать не нужно
     * @return array
     */
    public function actionList()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $userId = Yii::$app->user->id;
        $getData = Yii::$app->request->get();

        $notesCondition = Note::find()
            ->where(['user_id' => $userId, 'is_deleted' => false])
            ->orderBy(['created_at' => SORT_DESC]);

        if(isset($getData['tagId']))
        {
            $tagId = (int)$getData['tagId'];
            $notesCondition->joinWith('tags')
                ->where(['tag.id' => $tagId]);
        }

        $notes = $notesCondition->all();

        return ['status' => 'success', 'message' => 'Список заметок успешно получен.', 'data' => $notes ?? []];
    }

    /**
     * Отображение одной заметки
     *
     * @param int $id
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     */
    public function actionView(int $id)
    {
        $userId = Yii::$app->user->id;
        $note = Note::findOne(['id' => $id, 'user_id' => $userId, 'is_deleted' => false]);

        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($note === null) {
            return ['status' => 'error', 'message' => 'Заметки не существует'];
        }

        return ['status' => 'success', 'message' => 'Заметка успешно получена', 'data' => [
            'note' => $note, 'tags' => $note->getTagNames()
        ]];
    }

    /**
     * Добавление новой заметки
     *
     * @return array
     * @throws Exception
     */
    public function actionCreate()
    {
        $postData = Yii::$app->request->post();

        $note = new Note();
        $note->user_id = Yii::$app->user->id;
        $note->title = $postData['title'];
        $note->body = $postData['body'];
        $note->is_deleted = false;

        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!$note->save()) {
            return ['status' => 'error', 'message' => 'Ошибка в ходе добавлении заметки', 'errors' => $note->errors];
        }

        //добавление тэгов
        foreach ($postData['tags'] as $tagId) {
            $tag = Tag::findOne(['id' => $tagId]);
            if ($tag) $note->link('tags', $tag);
        }

        return ['status' => 'success', 'message' => 'Заметка успешно добавлена.', 'data' => [
            'note' => $note, 'tags' => $note->getTagNames()]];
    }

    /**
     * Редактирование заметки
     *
     * @param int $id
     * @return array
     * @throws Exception
     */
    public function actionUpdate(int $id)
    {
        $userId = Yii::$app->user->id;
        $note = Note::findOne(['id' => $id, 'user_id' => $userId, 'is_deleted' => false]);

        $postData = Yii::$app->request->post();

        $note->title = $postData['title'];
        $note->body = $postData['body'];

        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!$note->save()) {
            return ['status' => 'error', 'message' => 'Ошибка в ходе сохранения заметки', 'errors' => $note->errors];
        }

        //добавление тэгов
        $note->unlinkAll('tags', true);

        foreach ($postData['tags'] as $tagId) {
            $tag = Tag::findOne(['id' => $tagId]);
            if ($tag) $note->link('tags', $tag);
        }

        return ['status' => 'success', 'message' => 'Заметка успешно сохранена.', 'data' => [
            'note' => $note, 'tags' => $note->getTagNames()]];
    }

    /**
     * Удаление заметки
     *
     * @param int $id
     * @return array
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function actionDelete(int $id)
    {
        $userId = Yii::$app->user->id;
        $note = Note::findOne(['id' => $id, 'user_id' => $userId, 'is_deleted' => false]);

        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($note === null) {
            return ['status' => 'error', 'message' => 'Такой заметки не существует'];
        }

        $note->delete();

        return ['status' => 'success', 'message' => 'Заметка успешно удалена.'];
    }
}
