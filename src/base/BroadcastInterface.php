<?php
namespace paw\notifier\base;

interface BroadcastInterface
{
    public function send($recipients, $channels = null);
}