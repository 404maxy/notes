<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%note_tag}}`.
 */
class m240717_120248_create_note_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%note_tag}}', [
            'note_id' => $this->integer()->notNull(),
            'tag_id' => $this->integer()->notNull(),
            'PRIMARY KEY(note_id, tag_id)',
        ]);

        $this->createIndex(
            '{{%idx-note_tag-note_id}}',
            '{{%note_tag}}',
            'note_id'
        );

        $this->addForeignKey(
            '{{%fk-note_tag-note_id}}',
            '{{%note_tag}}',
            'note_id',
            '{{%note}}',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            '{{%idx-note_tag-tag_id}}',
            '{{%note_tag}}',
            'tag_id'
        );

        $this->addForeignKey(
            '{{%fk-note_tag-tag_id}}',
            '{{%note_tag}}',
            'tag_id',
            '{{%tag}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            '{{%fk-note_tag-note_id}}',
            '{{%note_tag}}'
        );

        $this->dropIndex(
            '{{%idx-note_tag-note_id}}',
            '{{%note_tag}}'
        );

        $this->dropForeignKey(
            '{{%fk-note_tag-tag_id}}',
            '{{%note_tag}}'
        );

        $this->dropIndex(
            '{{%idx-note_tag-tag_id}}',
            '{{%note_tag}}'
        );

        $this->dropTable('{{%note_tag}}');
    }
}
