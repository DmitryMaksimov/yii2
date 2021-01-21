<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%redirect}}`.
 */
class m210121_054714_create_redirect_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%redirect}}', [
            'id' => $this->primaryKey(),
            'alias' => $this->text()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%redirect}}');
    }
}
