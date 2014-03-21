<?php

namespace Matthias\SphinxDocumentation\Tests;

use Matthias\SphinxDocumentation\Builder;
use Matthias\SphinxDocumentation\ServiceContainer;

class ServiceContainerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_creates_a_builder_successfully()
    {
        $serviceContainer = new ServiceContainer(__DIR__, __DIR__, array(__DIR__), true);

        $this->assertTrue($serviceContainer->getBuilder() instanceof Builder);
    }
}
