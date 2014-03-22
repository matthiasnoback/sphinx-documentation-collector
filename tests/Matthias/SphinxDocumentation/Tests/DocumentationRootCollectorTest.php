<?php

namespace Matthias\SphinxDocumentation\Tests;

use Matthias\SphinxDocumentation\DocumentationRootCollector;

class DocumentationRootCollectorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_collects_documentation_roots_based_on_an_index_rst_file_in_directories_named_meta_doc()
    {
        $documentRootCollector = new DocumentationRootCollector(__DIR__.'/fixtures', 'index.rst', 'meta/doc/', array('*/'));

        $documentationRoot1 = __DIR__.'/fixtures/SomeLibrary/meta/doc';
        $documentationRoot2 = __DIR__.'/fixtures/SomeOtherLibrary/meta/doc';
        $this->assertSame(array(
             $this->getExpectedLinkName($documentationRoot1) => $documentationRoot1,
             $this->getExpectedLinkName($documentationRoot2) => $documentationRoot2,
        ), $documentRootCollector->collect());
    }

    private function getExpectedLinkName($directory)
    {
        return substr(md5($directory), 0, 8);
    }
}
