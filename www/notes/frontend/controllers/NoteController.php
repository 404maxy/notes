<?php

namespace frontend\controllers;

use common\models\Note;
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
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {
        $userId = Yii::$app->user->id;

        $notes = Note::findAll(['user_id' => $userId, 'is_deleted' => false]);

        if ($notes === null) {
            throw new NotFoundHttpException('Еще не создано ни одной записи.');
        }

        return $this->render('index', [
            'notes' => $notes,
            'note' => new Note
        ]);
    }

    /**
     * Отображение одной заметки
     *
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView(int $id)
    {
        $userId = Yii::$app->user->id;

        $note = Note::findOne(['id' => $id, 'user_id' => $userId, 'is_deleted' => false]);

        if ($note === null) {
            throw new NotFoundHttpException('Такой заметки не существует');
        }

        return $this->render('view', [
            'note' => $note,
        ]);
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

        return ['status' => 'success', 'message' => 'Заметка успешно добавлена.', 'data' => $note];
    }

    /**
     * Редактирование новой заметки
     *
     * @param int $id
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionUpdate(int $id)
    {
        $userId = Yii::$app->user->id;

        $note = Note::findOne(['id' => $id, 'user_id' => $userId, 'is_deleted' => false]);

        if ($note === null) {
            throw new NotFoundHttpException('Такой заметки не существует');
        }

        return ['status' => 'success', 'message' => 'Заметка успешно сохранена.', 'data' => $note];
    }
}
