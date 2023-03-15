<?php

/*
 * This file is part of the RequestIdBundle package.
 * (c) HostMe <contact@hostme.fr>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HostMe\RequestIdBundle\Logger;

use Monolog\LogRecord;
use Symfony\Component\HttpFoundation\RequestStack;

class RequestIdProcessor
{
    private $requestStack;

    private $headerName;

    public function __construct(
        RequestStack $requestStack,
        string $headerName
    ) {
        $this->requestStack = $requestStack;
        $this->headerName = $headerName;
    }

    public function __invoke(LogRecord $record): LogRecord
    {
        $request = $this->requestStack->getCurrentRequest();
        if (null === $request) {
            return $record;
        }

        $requestId = $request->headers->get($this->headerName);
        if (null !== $requestId) {
            $record->extra['request_id'] = $requestId;
        }

        return $record;
    }
}
