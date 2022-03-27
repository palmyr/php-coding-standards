<?php

declare(strict_types=1);

namespace Palmyr\CodingStandards\Console\Command;

use Palmyr\CommonUtils\Shell\Factory\ShellCommandFactoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class FixCodeCommand extends Command
{
    protected ShellCommandFactoryInterface $shellCommandFactory;

    public function __construct(
        ShellCommandFactoryInterface $shellCommandFactory
    ) {
        $this->shellCommandFactory = $shellCommandFactory;
        parent::__construct('fix');
    }

    protected function configure()
    {
        parent::configure();
        $this->addArgument('path', InputArgument::REQUIRED, 'The coding path to fix');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Fixing code');

        $commands = [
            'php vendor/bin/php-cs-fixer fix %s',
            'php vendor/bin/phpcbf %s',
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
