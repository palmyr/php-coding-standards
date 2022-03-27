<?php declare(strict_types=1);

namespace Palmyr\CodingStandards\Console\Command;

use Palmyr\CommonUtils\Shell\Factory\ShellCommandFactoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;


abstract class AbstractBaseCommand extends Command
{

    protected ShellCommandFactoryInterface $shellCommandFactory;

    public function __construct(
        ShellCommandFactoryInterface $shellCommandFactory,
        string $name = null
    ) {
        $this->shellCommandFactory = $shellCommandFactory;
        parent::__construct($name);
    }

    protected function configure()
    {
        parent::configure();
        $this->addArgument('path', InputArgument::REQUIRED, 'The coding path to use');
    }
}