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
        $buildDirectory = sys_get_temp_dir() . '/' . uniqid() . '/';
        $relativeLinksDirectory = 'links/';
        $filesystem = new Filesystem();
        $filesystem->mkdir($buildDirectory);

        $generator = new TableOfContentsGenerator($buildDirectory, $relativeLinksDirectory);
        $generator->generateFor(
            array(
                'fixtures-some-library' => 'path-is-irrelevant',
                'fixtures-some-other-library' => 'path-is-irrelevant'
            )
        );

        $expectedTableOfContents = <<<EOD
.. toctree::
   links/fixtures-some-library/index
   links/fixtures-some-other-library/index

EOD;

        $this->assertSame($expectedTableOfContents, file_get_contents($buildDirectory.'index.rst'));

        $filesystem->remove($buildDirectory);
    }
}
