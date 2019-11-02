<?php
namespace paw\notifier\models;

use yii\db\ActiveRecord;
use paw\models\User;

class Notification extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%notification}}';
    }

    public function rules()
    {
        return [
            [['subject', 'message_text', 'message_html'], 'string'],
            [['user_id'], 'integer'],
            [['is_seen', 'is_sent'], 'boolean'],
            [['params'], 'safe'],
        ];
    }

    public function setRecipient(User $recipient)
    {
        $this->user_id = $recipient->id;
    }

    public function recordSentAt()
    {
        $this->sent_at = new \yii\db\Expression('NOW()');
        $this->save(false);
    }

    public function setMessage($message)
    {
        $this->message_text = $message;
        $this->message_html = "<p>$message</p>";
    }
}