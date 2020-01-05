<?php
namespace paw\notifier\services;

use Yii;
use yii\base\Component;
use yii\helpers\ArrayHelper;
use yii\base\InvalidParamException;
use paw\notifier\models\Notification;

class Notifier extends Component implements \yii\base\BootstrapInterface
{
    public $channels = [];

    public function bootstrap($app) 
    {
        // foreach ($this->channels as $index => $channel) 
        // {
            // print_r($channel);
        //     $class = ArrayHelper::remove($channel, 'class');
        //     echo "$class - ";
        //     echo (new $class) instanceof \paw\notifier\base\BaseChannel ? 'yes' : 'no';
        // }
        // die;
    }

    public function send($recipients, $notification, $channels = null)
    {
        if (!is_array($recipients)) {
            $recipients = [$recipients];
        }

        if (is_array($notification) && !isset($notification['class'])) {
            $notification['class'] = Notification::class;
            $notification = Yii::createObject($notification);
        }

        if (!$notification instanceof Notification) {
            throw new InvalidParamException(Yii::t('app', 'Invalid notification type'));
        }

        if ($channels === null) {
            $channels = $this->channels;
        }

        foreach ($recipients as $recipient) {
            $channerParams = $recipient->notifierChannelParams;
            foreach ($channels as $channelId => $channelConfig) {

                $notification = $this->handleNotification($recipient, $notification);

                $channelConfig = ArrayHelper::merge(
                    $channelConfig, 
                    isset($channerParams[$channelId]) ? $channerParams[$channelId] : [],
                    [
                        'recipient' => $recipient,
                        'notification' => $notification,
                    ]
                );
                $channel = Yii::createObject($channelConfig);
                $channel->tryTosend();
            }
        }
    }

    protected function handleNotification($recipient, $notification)
    {
        if ($notification->user_id === null) {
            $notification->user_id = $recipient->id;
        } else if ($notification->user_id != $recipient->id) {
            $cloneNotification = new Notification;
            $cloneNotification->attributes = $notification->attributes;
            $cloneNotification->user_id = $recipient->user_id;
            $notification = $cloneNotification;
        }

        if ($notification->isNewRecord) {
            $notification->save();
        }
        return $notification;
    }

    public function totalUnseen()
    {
        $count = 0;
        if (Yii::$app instanceof \yii\web\Application && !Yii::$app->user->isGuest) {
            $count = Notification::find()
                ->andWhere(['user_id' => Yii::$app->user->id])
                ->andWhere(['is_seen' => true])
                ->count();
            ;
        }
        return $count;
    }

    public function getNotificationQuery()
    {
        return Notification::find()
            ->andWhere(['user_id' => Yii::$app->user->id])
            ->orderBy([
                'level' => SORT_ASC,
                'created_at' => SORT_DESC,
            ]);
    }

    public function getAllSeen()
    {
        return $this->getNotificationQuery()
            ->andWhere(['is_seen' => true])
            ->all();
    }

    public function getAllUnSeen()
    {
        return $this->getNotificationQuery()
            ->andWhere(['is_seen' => false])
            ->all();
    }

    public function getAll()
    {
        return $this->getNotificationQuery()->all();
    }
}