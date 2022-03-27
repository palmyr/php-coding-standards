<?php

declare(strict_types=1);

namespace Palmyr\CodingStandards\Console;

use Palmyr\CodingStandards\Console\Command;
use Palmyr\CommonUtils\FileSystem\FileSystem;
use Palmyr\CommonUtils\Shell\Factory\ShellCommandFactory;
use Symfony\Component\Console\Application as BaseApplication;

class Application extends BaseApplication
{
    public function __construct(string $name = 'UNKNOWN', string $version = 'UNKNOWN')
    {
        parent::__construct($name, $version);
        $shellCommandFactory = new ShellCommandFactory(new FileSystem());
        $this->add(new Command\FixCodeCommand($shellCommandFactory));
        $this->add(new Command\ValidateCodeCommand());
    }
}
