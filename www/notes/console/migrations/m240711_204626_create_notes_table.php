<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%notes}}`.
 */
class m240711_204626_create_notes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('{{%notes}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'title' => $this->string(),
            'body' => $this->text(), //TODO: можно будет вынести в отдельную таблицу на движке Sphinx для полнотекстового поиска
        ]);

        $this->createIndex(
            'idx-post-user_id',
            '{{%notes}}',
            'user_id'
        );

        //TODO: можно отказаться от внешнего ключа, если требуется сохранение записей удаленных пользователей
        $this->addForeignKey(
            'fk-notes-user_id',
            '{{%notes}}',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        //TODO: для поиска потребуется полнотекстовый индекс

        //TODO: добавить посев фикстурных данных
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk-notes-user_id',
            '{{%notes}}'
        );

        // drops index for column `author_id`
        $this->dropIndex(
            'idx-post-user_id',
            '{{%notes}}'
        );

        $this->dropTable('{{%notes}}');
    }
}
