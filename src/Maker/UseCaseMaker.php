<?php

namespace TBoileau\Bundle\CleanArchitectureBundle\Maker;

use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;

/**
 * Class UseCaseMaker
 * @package TBoileau\Bundle\CleanArchitectureBundle\Maker
 * @author Thomas Boileau <t-boileau@email.com>
 */
class UseCaseMaker extends AbstractMaker
{
    /**
     * @inheritDoc
     */
    public static function getCommandName(): string
    {
        return 'make:use-case';
    }

    /**
     * @inheritDoc
     */
    public function configureCommand(Command $command, InputConfiguration $inputConfig)
    {
        $command
            ->setDescription('Create new use case')
            ->addArgument('domain', InputArgument::REQUIRED, 'Enter the domain of your user case.')
            ->addArgument('name', InputArgument::REQUIRED, 'Enter the name of your use case.')
        ;
    }

    /**
     * @inheritDoc
     */
    public function configureDependencies(DependencyBuilder $dependencies)
    {
    }

    /**
     * @inheritDoc
     */
    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator)
    {
        $useCaseClassNameDetails = $generator->createClassNameDetails(
            $input->getArgument('name'),
            sprintf('BusinessRules\\UseCase\\%s', $input->getArgument('domain'))
        );

        $requestClassNameDetails = $generator->createClassNameDetails(
            $input->getArgument('name'),
            sprintf('BusinessRules\\Request\\%s', $input->getArgument('domain')),
            'Request'
        );

        $responseClassNameDetails = $generator->createClassNameDetails(
            $input->getArgument('name'),
            sprintf('BusinessRules\\Response\\%s', $input->getArgument('domain')),
            'Response'
        );

        $unitTestClassNameDetails = $generator->createClassNameDetails(
            $input->getArgument('name'),
            sprintf('App\\Tests\\UnitTests\\%s', $input->getArgument('domain')),
            'Test'
        );

        $generator->generateClass(
            $useCaseClassNameDetails->getFullName(),
            __DIR__ . '/../Resources/skeleton/use_case.tpl.php',
            [
                'request' => $requestClassNameDetails->getFullName(),
                'response' => $responseClassNameDetails->getFullName(),
            ]
        );

        $generator->generateClass(
            $unitTestClassNameDetails->getFullName(),
            __DIR__ . '/../Resources/skeleton/unit_test.tpl.php',
            [
                'request' => $requestClassNameDetails,
                'response' => $responseClassNameDetails,
                'use_case' => $useCaseClassNameDetails
            ]
        );

        $generator->generateClass(
            $requestClassNameDetails->getFullName(),
            __DIR__ . '/../Resources/skeleton/request.tpl.php'
        );


        $generator->generateClass(
            $responseClassNameDetails->getFullName(),
            __DIR__ . '/../Resources/skeleton/response.tpl.php'
        );


        $generator->writeChanges();
        $this->writeSuccessMessage($io);
    }
}
