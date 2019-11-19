<?= "<?php\n" ?>

namespace <?= $namespace ?>;

use <?= $useCase->getFullName() ?>;
use <?= $request->getFullName() ?>;
use <?= $response->getFullName() ?>;
use TBoileau\CleanArchitecture\BusinessRules\Request\RequestInterface;
use TBoileau\CleanArchitecture\BusinessRules\Response\ResponseInterface;
use TBoileau\CleanArchitecture\BusinessRules\UseCase\{
    TestUseCase,
    UseCaseInterface
};

/**
 * Class <?= $class_name ?>
 */
class <?= $class_name ?> extends TestUseCase
{
    /**
     * @inheritDoc
     */
    public function getUseCase(): UseCaseInterface
    {
        return new <?= $useCase->getShortName() ?>();
    }

    /**
     * @inheritDoc
     */
    public function getResponse(): ResponseInterface
    {
        return new <?= $response->getShortName() ?>();
    }

    /**
     * @inheritDoc
     */
    public function getRequest(): RequestInterface
    {
        return new <?= $request->getShortName() ?>();
    }


    /**
     * @inheritDoc
     */
    public function getRequestData(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function assertions(ResponseInterface $response)
    {
        return $this->assertEquals([], $response->getData());
    }
}
