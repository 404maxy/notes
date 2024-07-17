<?php

use yii\db\Migration;

/**
 * Class m240717_162616_add_vk_auth_fields_to_user_table
 */
class m240717_162616_add_vk_auth_fields_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'vk_id', $this->integer()->notNull()->unique());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'vk_id');
    }
}
