<?php

namespace frontend\controllers;

use common\models\Note;
use Yii;
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
            'notes' => $notes
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
     * Отображение формы добавления новой заметки
     *
     * @return mixed
     */
    public function actionAdd()
    {
        echo 'Add Form';
        exit;
    }

    /**
     * Добавление новой заметки
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $userId = Yii::$app->user->id;

        echo 'Create Action';
        exit;
    }

    /**
     * Отображение формы редактирования заметки
     *
     * @return mixed
     */
    public function actionEdit()
    {
        $userId = Yii::$app->user->id;

        echo 'Edit Action';
        exit;
    }

    /**
     * Редактирование новой заметки
     *
     * @return mixed
     */
    public function actionUpdate(int $id)
    {
        $userId = Yii::$app->user->id;

        echo 'Update Action';
        exit;
    }
}
