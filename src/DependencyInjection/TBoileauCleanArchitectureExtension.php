<?php

namespace TBoileau\Bundle\CleanArchitectureBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use TBoileau\CleanArchitecture\BusinessRules\Request\RequestInterface;
use TBoileau\CleanArchitecture\BusinessRules\Response\ResponseInterface;
use TBoileau\CleanArchitecture\BusinessRules\UseCase\UseCaseInterface;
use TBoileau\CleanArchitecture\BusinessRules\UserInterface\ViewModelInterface;

/**
 * Class TBoileauCleanArchitectureExtension
 * @package TBoileau\Bundle\CleanArchitectureBundle\DependencyInjection
 * @author Thomas Boileau <t-boileau@email.com>
 */
class TBoileauCleanArchitectureExtension extends Extension
{
    /**
     * @inheritDoc
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $container
            ->registerForAutoconfiguration(UseCaseInterface::class)
            ->addTag('t_boileau.use_case')
        ;

        $container
            ->registerForAutoconfiguration(ResponseInterface::class)
            ->addTag('t_boileau.response')
        ;

        $container
            ->registerForAutoconfiguration(RequestInterface::class)
            ->addTag('t_boileau.request')
        ;

        $container
            ->registerForAutoconfiguration(ViewModelInterface::class)
            ->addTag('t_boileau.view_model')
        ;
    }
}
