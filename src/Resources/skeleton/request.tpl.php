<?= "<?php\n" ?>

namespace <?= $namespace ?>;

use Symfony\Component\OptionsResolver\OptionsResolver;
use TBoileau\CleanArchitecture\BusinessRules\Request\Request;

/**
 * Class <?= $class_name ?>
 */
class <?= $class_name ?> extends Request
{
    /**
     * @inheritDocs
     */
    public function configure(OptionsResolver $resolver): void
    {
        // TODO: Implement configure() method.
    }
}
