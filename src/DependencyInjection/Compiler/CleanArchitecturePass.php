<?php

namespace TBoileau\Bundle\CleanArchitectureBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Compiler\ServiceLocatorTagPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use TBoileau\CleanArchitecture\BusinessRules\Request\RequestFactoryInterface;
use TBoileau\CleanArchitecture\BusinessRules\Request\RequestInterface;
use TBoileau\CleanArchitecture\BusinessRules\Response\ResponseFactoryInterface;
use TBoileau\CleanArchitecture\BusinessRules\Response\ResponseInterface;
use TBoileau\CleanArchitecture\BusinessRules\UseCase\UseCaseFactoryInterface;
use TBoileau\CleanArchitecture\BusinessRules\UseCase\UseCaseInterface;

/**
 * Class CleanArchitecturePass
 * @package TBoileau\Bundle\CleanArchitectureBundle\DependencyInjection\Compiler
 * @author Thomas Boileau <t-boileau@email.com>
 */
class CleanArchitecturePass implements CompilerPassInterface
{
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        $container->registerForAutoconfiguration(UseCaseInterface::class)->addTag('t_boileau.use_case');
        $container->registerForAutoconfiguration(ResponseInterface::class)->addTag('t_boileau.response');
        $container->registerForAutoconfiguration(RequestInterface::class)->addTag('t_boileau.request');

        $useCaseFactory = $container->getDefinition(UseCaseFactoryInterface::class);
        $useCaseFactory->replaceArgument(0, $this->processByTagName($container, 't_boileau.use_case'));

        $useCaseFactory = $container->getDefinition(ResponseFactoryInterface::class);
        $useCaseFactory->replaceArgument(0, $this->processByTagName($container, 't_boileau.response'));

        $useCaseFactory = $container->getDefinition(RequestFactoryInterface::class);
        $useCaseFactory->replaceArgument(0, $this->processByTagName($container, 't_boileau.request'));
    }

    /**
     * @param ContainerBuilder $container
     * @param string $tagName
     * @return Reference
     */
    private function processByTagName(ContainerBuilder $container, string $tagName): Reference
    {
        /** @var Reference[] $servicesMap */
        $servicesMap = [];

        $taggedServices = $container->findTaggedServiceIds($tagName);

        /**
         * @var string $serviceId
         * @var array $taggedServiceId
         */
        foreach ($taggedServices as $serviceId => $taggedServiceId) {
            $servicesMap[$container->getDefinition($serviceId)->getClass()] = new Reference($serviceId);
        }
        return ServiceLocatorTagPass::register($container, $servicesMap);
    }
}
