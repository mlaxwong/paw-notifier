<?php
namespace paw\notifier\base;

use yii\base\Component;

abstract class BaseChannel extends Component
{
    public $recipient;
    public $notification;

    abstract public static function getID();

    abstract public function send();

    public function tryToSend()
    {
        if (!$this->beforeSend()) {
            return false;
        }

        if (!$this->send()) {
            if (YII_DEBUG) {
                throw new \Exception('Notification not sent');
            }
            return false;
        }

        $this->afterSend();

        return true;
    }

    public function beforeSend() 
    {
        return true;
    }

    public function afterSend() {}
}