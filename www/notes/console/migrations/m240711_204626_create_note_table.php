<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%note}}`.
 */
class m240711_204626_create_note_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('{{%note}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'title' => $this->string(),
            'body' => $this->text(), //TODO: можно будет вынести в отдельную таблицу на движке Sphinx для полнотекстового поиска
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'is_deleted' => $this->boolean()->defaultValue(false),
        ]);

        $this->createIndex(
            'idx-post-user_id',
            '{{%note}}',
            'user_id'
        );

        //TODO: можно отказаться от внешнего ключа, если требуется сохранение записей удаленных пользователей
        $this->addForeignKey(
            'fk-note-user_id',
            '{{%note}}',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        //TODO: для поиска потребуется полнотекстовый индекс
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk-note-user_id',
            '{{%note}}'
        );

        // drops index for column `author_id`
        $this->dropIndex(
            'idx-post-user_id',
            '{{%note}}'
        );

        $this->dropTable('{{%note}}');
    }
}
