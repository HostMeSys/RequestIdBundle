<?php

/*
 * This file is part of the RequestIdBundle package.
 * (c) HostMe <contact@hostme.fr>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HostMe\RequestIdBundle;

use HostMe\RequestIdBundle\DependencyInjection\RequestIdExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class RequestIdBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new RequestIdExtension();
    }
}
