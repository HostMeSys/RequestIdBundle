<?php

/*
 * This file is part of the RequestIdBundle package.
 * (c) HostMe <contact@hostme.fr>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HostMe\RequestIdBundle\EventListener\Request;

use Ramsey\Uuid\Uuid;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RequestListener implements EventSubscriberInterface
{
    private $requestStack;

    private $headerName;

    private $trustHeader;

    public function __construct(
        RequestStack $requestStack,
        string $headerName,
        bool $trustHeader
    ) {
        $this->requestStack = $requestStack;
        $this->headerName = $headerName;
        $this->trustHeader = $trustHeader;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [
                ['onKernelRequest', 255],
            ],
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $this->requestStack->getCurrentRequest();

        $requestId = true === $this->trustHeader ? $request->headers->get($this->headerName) : null;
        if (null === $requestId) {
            $requestId = Uuid::uuid4();
        }

        $event->getRequest()->headers->set($this->headerName, $requestId);
    }
}
