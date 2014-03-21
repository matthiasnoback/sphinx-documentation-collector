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
        $documentRootCollector = new DocumentationRootCollector(__DIR__.'/fixtures', 'index.rst', '/meta/doc', array('/*'));

        $this->assertSame(array(
            'some-library' => __DIR__.'/fixtures/SomeLibrary/meta/doc',
            'some-other-library' => __DIR__.'/fixtures/SomeOtherLibrary/meta/doc'
        ), $documentRootCollector->collect());
    }
}
