<?php
declare(strict_types = 1);

namespace LeaderBoard\Documentation\Console\Commands;

use LeaderBoard\Documentation\Services\SwaggerBuilder;
use Illuminate\Console\Command;

class BuildSwagger extends Command
{

    protected $signature = 'build:swagger';

    protected $description = 'Command glues together all swagger files';

    /**
     * @throws \LogicException
     */
    public function handle(SwaggerBuilder $swaggerBuilder): void
    {
        $swaggerBuilder->buildSwaggerJson();
    }
}
