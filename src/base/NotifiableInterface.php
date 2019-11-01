<?php
namespace paw\notifier\base;

interface NotifiableInterface
{
    public function setNotifierChannerParams($notifierChannelParams = []);
    public function getNotifierChannerParams();
}