<?php

/*
 * This file is part of the RequestIdBundle package.
 * (c) HostMe <contact@hostme.fr>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HostMe\RequestIdBundle\DependencyInjection;

use HostMe\RequestIdBundle\EventListener\Request\RequestListener;
use HostMe\RequestIdBundle\EventListener\Response\ResponseListener;
use HostMe\RequestIdBundle\Logger\RequestIdProcessor;
use Monolog\Formatter\LineFormatter;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Parameter;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

class RequestIdExtension extends ConfigurableExtension
{
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        $container->setParameter('hostme_request_id.trust_request_header', $mergedConfig['trust_request_header']);
        $container->setParameter('hostme_request_id.response_header', $mergedConfig['response_header']);

        if (true === $mergedConfig['enable']) {
            $container
                ->register(RequestListener::class)
                ->addArgument(new Reference('request_stack'))
                ->addArgument(new Parameter('hostme_request_id.response_header'))
                ->addArgument(new Parameter('hostme_request_id.trust_request_header'))
                ->setPublic(false)
                ->addTag('kernel.event_subscriber')
            ;

            $container
                ->register(ResponseListener::class)
                ->addArgument(new Reference('request_stack'))
                ->addArgument(new Parameter('hostme_request_id.response_header'))
                ->setPublic(false)
                ->addTag('kernel.event_subscriber')
            ;

            if (true === $mergedConfig['enable_monolog']) {
                $container
                    ->register(RequestIdProcessor::class)
                    ->addArgument(new Reference('request_stack'))
                    ->addArgument(new Parameter('hostme_request_id.response_header'))
                    ->setPublic(false)
                    ->addTag('monolog.processor')
                ;

                $container
                    ->register('hostme_request_id.formatter.request_id')
                    ->setClass(LineFormatter::class)
                    ->addArgument("[%%datetime%%] [%%extra.request_id%%] %%channel%%.%%level_name%%: %%message%% %%context%% %%extra%%\n")
                    ->setPublic(false)
                ;
            }
        }
    }
}
