<?php

/*
 * This file is part of the RequestIdBundle package.
 * (c) HostMe <contact@hostme.fr>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HostMe\RequestIdBundle\EventListener\Response;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ResponseListener implements EventSubscriberInterface
{
    protected $requestStack;

    private $headerName;

    public function __construct(
        RequestStack $requestStack,
        string $headerName
    ) {
        $this->requestStack = $requestStack;
        $this->headerName = $headerName;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::RESPONSE => [
                ['onKernelResponse', 0],
            ],
        ];
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        $request = $this->requestStack->getCurrentRequest();
        $requestId = $request->headers->get($this->headerName);

        if (null !== $requestId) {
            $event->getResponse()->headers->set($this->headerName, $requestId);
        }
    }
}
