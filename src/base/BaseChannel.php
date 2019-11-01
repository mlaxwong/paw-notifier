<?php
namespace app\notifier\base;

use yii\base\Component;

abstract class BaseChannel extends Component
{
    abstract public function send($recipients, $notifications);
}