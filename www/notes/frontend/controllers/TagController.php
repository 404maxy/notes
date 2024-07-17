<?php

namespace frontend\controllers;

use common\models\Tag;
use yii\db\StaleObjectException;
use yii\web\Response;
use Yii;
use yii\db\Exception;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

/**
 * Tag controller
 * Доступ возможен только после авторизации пользователя
 */
class TagController extends Controller
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
     * Отображение списка тэгов
     * @return array
     */
    public function actionList()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $userId = Yii::$app->user->id;

        $tags = Tag::find()
            ->where(['user_id' => $userId])
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

        return ['status' => 'success', 'message' => 'Список тэгов успешно получен.', 'data' => $tags ?? []];
    }

    /**
     * Добавление нового тэга
     *
     * @return array
     * @throws Exception
     */
    public function actionCreate()
    {
        $postData = Yii::$app->request->post();

        $tag = new Tag();
        $tag->user_id = Yii::$app->user->id;
        $tag->name = $postData['name'];

        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!$tag->save()) {
            return ['status' => 'error', 'message' => 'Ошибка в ходе добавлении тэга', 'errors' => $tag->errors];
        }

        return ['status' => 'success', 'message' => 'Тэг успешно добавлен.', 'data' => $tag];
    }

    /**
     * Удаление тэга
     *
     * @param int $id
     * @return array
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function actionDelete(int $id)
    {
        $userId = Yii::$app->user->id;
        $tag = Tag::findOne(['id' => $id, 'user_id' => $userId]);

        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($tag === null) {
            return ['status' => 'error', 'message' => 'Такого тэга не существует'];
        }

        $tag->delete();

        return ['status' => 'success', 'message' => 'Тэг успешно удален.'];
    }
}
