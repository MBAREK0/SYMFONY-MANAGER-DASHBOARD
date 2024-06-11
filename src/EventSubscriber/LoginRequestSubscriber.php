<?php

// src/EventSubscriber/LoginRequestSubscriber.php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class LoginRequestSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        // $request->request->set('_username', 'fh@gmail.com');
        // dd($request->request->get('_username'));
        // if($request->isMethod('POST'))
        // if($request->request->get('_username') !== null)
        // dd($request->request->get('_username'));

        // Check if the request is for the login route and is a POST request
        if ($request->attributes->get('_route') === 'app_auth') {
            // Modify the _username parameter
        }
    }
}
