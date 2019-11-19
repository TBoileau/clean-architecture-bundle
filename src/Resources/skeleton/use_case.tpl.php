<?= "<?php\n" ?>

namespace <?= $namespace ?>;

use TBoileau\CleanArchitecture\BusinessRules\Annotation\UseCase;
use TBoileau\CleanArchitecture\BusinessRules\Request\RequestInterface;
use TBoileau\CleanArchitecture\BusinessRules\UseCase\UseCaseInterface;

/**
 * Class <?= $class_name ?>
 * @UseCase(
 *     request="<?= $request ?>",
 *     response="<?= $response ?>"
 * )
 */
class <?= $class_name ?> implements UseCaseInterface
{
    /**
     * @inheritDocs
     */
    public function execute(RequestInterface $request): array
    {
        return [];
    }
}
