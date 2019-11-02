<?php
namespace paw\notifier\migrations\db;

use paw\db\Migration;

class M191101085148CreateNotification extends Migration
{
    use \paw\db\TextTypesTrait;
    use \paw\db\DefaultColumn;

    public function safeUp()
    {
        $this->createTable('{{%notification}}', [
            'id' => $this->primaryKey()->unsigned(),
            'user_id' => $this->integer()->unsigned()->defaultValue(null),
            'level' => $this->integer()->defaultValue(0),
            'subject' => $this->string()->defaultValue(null),
            'message_text' => $this->longText()->defaultValue(null),
            'message_html' => $this->longText()->defaultValue(null),
            'from_email' => $this->string()->defaultValue(null),
            'from_email_name' => $this->string()->defaultValue(null),
            'params' => $this->longText()->defaultValue(null),
            'is_seen' => $this->boolean()->defaultValue(false),
            'seen_at' => $this->timestamp()->defaultValue(null),
            'is_sent' => $this->boolean()->defaultValue(false),
            'sent_at' => $this->timestamp()->defaultValue(null),
        ]);

        $this->addForeignKey('fk_notification_user_id',
            '{{%notification}}', 'user_id',
            '{{%user}}', 'id',
            'cascade', 'cascade'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_notification_user_id', '{{%notification}}');
        $this->dropTable('{{%notification}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M191101085148CreateNotification cannot be reverted.\n";

        return false;
    }
    */
}