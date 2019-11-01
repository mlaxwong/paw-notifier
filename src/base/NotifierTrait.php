<?php
namespace paw\notifier\base;

trait NotifierTrait
{
    protected $_notifierChannelParams;

    public function setNotifierChannerParams($notifierChannelParams = []) 
    {
        $this->_notifierChannelParams = $notifierChannelParams;
    }

    public function getNotifierChannerParams()
    {
        return $this->_notifierChannelParams;
    }

    public function send($recipients, $channels = null)
    {

    }
}