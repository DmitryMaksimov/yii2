<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m210116_110722_create_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%post}}', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'created' => $this->datetime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated' => $this->datetime()->defaultExpression('NULL')->append('ON UPDATE NOW()'),
            'title' => $this->string(),
            'body' => $this->text(),
        ]);

        // creates index for column `author_id`
        $this->createIndex(
            '{{%idx-post-author_id}}',
            '{{%post}}',
            'author_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-post-author_id}}',
            '{{%post}}',
            'author_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-post-author_id}}',
            '{{%post}}'
        );

        // drops index for column `author_id`
        $this->dropIndex(
            '{{%idx-post-author_id}}',
            '{{%post}}'
        );

        $this->dropTable('{{%post}}');
    }
}
