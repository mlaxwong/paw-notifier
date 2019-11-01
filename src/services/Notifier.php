<?php
namespace paw\notifier\services;

use yii\base\Componnet;

class Notifier extends Componnet
{
    public $channels = [];

    public function send($recipients, $notifications, $channels = null)
    {
        if (!is_array($recipients)) {
            $recipients = [$recipients];
        }

        if ($channels === null) {
            $channels = $this->channels;
        } else {

        }

        foreach ($recipients as $recipient) {
            foreach ($channels as $channelId => $channelConfig) {
                
            }
        }
    }
}