<?= "<?php\n" ?>

namespace <?= $namespace ?>;

use Symfony\Component\OptionsResolver\OptionsResolver;
use TBoileau\CleanArchitecture\BusinessRules\Response\Response;

/**
 * Class <?= $class_name ?>
 */
class <?= $class_name ?> extends Response
{
    /**
     * @inheritDocs
     */
    public function configure(OptionsResolver $resolver): void
    {
        // TODO: Implement configure() method.
    }
}
