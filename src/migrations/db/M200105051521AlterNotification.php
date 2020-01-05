<?php
namespace paw\notifier\migrations\db;

use paw\db\Migration;

class M200105051521AlterNotification extends Migration
{
    use \paw\db\TextTypesTrait;
    use \paw\db\DefaultColumn;

    public function safeUp()
    {
        $this->addColumn('{{%notification}}', 'url', $this->longText()->defaultValue(null)->after('params'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%notification}}', 'url');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M200105051521AlterNotification cannot be reverted.\n";

        return false;
    }
    */
}