<?php

namespace Matthias\SphinxDocumentation\Tests;

use Matthias\SphinxDocumentation\TableOfContentsGenerator;
use Symfony\Component\Filesystem\Filesystem;

class TableOfContentsGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_creates_a_table_of_contents_file()
    {
        $linksDirectory = sys_get_temp_dir() . '/' . uniqid() . '/';
        $filesystem = new Filesystem();
        $filesystem->mkdir($linksDirectory);

        $generator = new TableOfContentsGenerator($linksDirectory);
        $generator->generateFor(
            array(
                'fixtures-some-library' => 'path-is-irrelevant',
                'fixtures-some-other-library' => 'path-is-irrelevant'
            )
        );

        $expectedTableOfContents = <<<EOD
.. toctree::
   fixtures-some-library/index
   fixtures-some-other-library/index

EOD;

        $this->assertSame($expectedTableOfContents, file_get_contents($linksDirectory.'index.rst'));

        $filesystem->remove($linksDirectory);
    }
}
