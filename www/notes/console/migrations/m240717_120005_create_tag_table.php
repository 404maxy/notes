<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tag}}`.
 */
class m240717_120005_create_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('{{%tag}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string(40)->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull()
        ]);

        $this->createIndex(
            'idx-tag-user_id',
            '{{%tag}}',
            'user_id'
        );

        //TODO: можно отказаться от внешнего ключа, если требуется сохранение записей удаленных пользователей
        $this->addForeignKey(
            'fk-tag-user_id',
            '{{%tag}}',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk-tag-user_id',
            '{{%tag}}'
        );

        // drops index for column `author_id`
        $this->dropIndex(
            'idx-tag-user_id',
            '{{%tag}}'
        );

        $this->dropTable('{{%tag}}');
    }
}
