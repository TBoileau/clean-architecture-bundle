<?php

namespace TBoileau\Bundle\CleanArchitectureBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use TBoileau\Bundle\CleanArchitectureBundle\DependencyInjection\Compiler\CleanArchitecturePass;

/**
 * Class TBoileauCleanArchitectureBundle
 * @package TBoileau\Bundle\CleanArchitectureBundle
 * @author Thomas Boileau <t-boileau@email.com>
 */
class TBoileauCleanArchitectureBundle extends Bundle
{
    /**
     * @inheritDoc
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new CleanArchitecturePass());
    }
}
