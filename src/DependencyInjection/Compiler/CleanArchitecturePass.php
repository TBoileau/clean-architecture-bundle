<?php

namespace TBoileau\Bundle\CleanArchitectureBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\{
    CompilerPassInterface,
    ServiceLocatorTagPass
};
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use TBoileau\CleanArchitecture\BusinessRules\Request\{
    RequestFactory,
    RequestFactoryInterface
};
use TBoileau\CleanArchitecture\BusinessRules\Resolver\UseCaseResolver;
use TBoileau\CleanArchitecture\BusinessRules\Response\{
    ResponseFactory,
    ResponseFactoryInterface
};
use TBoileau\CleanArchitecture\BusinessRules\UseCase\{
    UseCaseFactory,
    UseCaseFactoryInterface
};

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
        $resolver = $container->register("t_boileau.use_case_resolver", UseCaseResolver::class);

        $responseFactory = $container->register("t_boileau.response_factory", ResponseFactory::class);
        $responseFactory->addArgument($this->processByTagName($container, 't_boileau.response'));
        $container->setAlias(ResponseFactoryInterface::class, "t_boileau.response_factory");

        $requestFactory = $container->register("t_boileau.request_factory", RequestFactory::class);
        $requestFactory->addArgument($this->processByTagName($container, 't_boileau.request'));
        $container->setAlias(RequestFactoryInterface::class, "t_boileau.request_factory");

        $useCaseFactory = $container->register("t_boileau.use_case_factory", UseCaseFactory::class);
        $useCaseFactory->addArgument($this->processByTagName($container, 't_boileau.use_case'));
        $useCaseFactory->addArgument($requestFactory);
        $useCaseFactory->addArgument($responseFactory);
        $useCaseFactory->addArgument($resolver);
        $container->setAlias(UseCaseFactoryInterface::class, "t_boileau.use_case_factory");
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
