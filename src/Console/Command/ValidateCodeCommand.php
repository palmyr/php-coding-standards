<?php

declare(strict_types=1);

namespace Palmyr\CodingStandards\Console\Command;

use Symfony\Component\Console\Command\Command;

class ValidateCodeCommand extends Command
{
    public function __construct()
    {
        parent::__construct('validate');
    }
}
