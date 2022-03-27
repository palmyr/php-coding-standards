<?php

declare(strict_types=1);

namespace Palmyr\CodingStandards\Console\Command;

use Palmyr\CommonUtils\Shell\Factory\ShellCommandFactoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ValidateCodeCommand extends AbstractBaseCommand
{

    public function __construct(
        ShellCommandFactoryInterface $shellCommandFactory,
    )
    {
        parent::__construct($shellCommandFactory, 'validate');
    }

    protected function configure()
    {
        parent::configure();

        $this->setDescription('Compare code to coding standards');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Validating code...');

        $commands = [
            'php vendor/bin/phpstan analyse %s',
            'php vendor/bin/phpunit %s',
        ];

        $path = $input->getArgument('path');

        foreach ($commands as $command) {
            $result = $this->shellCommandFactory->build(sprintf($command, $path))->execute();

            if ($result->getCode() !== 0) {
                $io->error("Failed to execute command [Command: {$command} ] [Error: {$result} ]");
                return $result->getCode();
            }
        }

        return self::SUCCESS;
    }
}
