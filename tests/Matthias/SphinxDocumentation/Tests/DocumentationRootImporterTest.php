<?php

namespace Matthias\SphinxDocumentation\Tests;

use Matthias\SphinxDocumentation\DocumentationRootImporter;
use Symfony\Component\Filesystem\Filesystem;

class DocumentationRootImporterTest extends \PHPUnit_Framework_TestCase
{
    private $linksDirectory;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var DocumentationRootImporter
     */
    private $importer;

    protected function setUp()
    {
        $this->filesystem = new Filesystem();

        $this->linksDirectory = sys_get_temp_dir() . '/' . uniqid() . '/links/';
        $this->filesystem->mkdir($this->linksDirectory);

        $this->importer = new DocumentationRootImporter($this->linksDirectory, $this->filesystem);
    }

    protected function tearDown()
    {
        $this->filesystem->remove($this->linksDirectory);
    }

    /**
     * @test
     */
    public function it_imports_documentation_roots_by_creating_symlinks_to_them_in_the_build_directory()
    {
        $documentationRoots = array(
            'fixtures-some-library' => __DIR__ . '/fixtures/SomeLibrary/meta/doc',
            'fixtures-some-other-library' => __DIR__ . '/fixtures/SomeOtherLibrary/meta/doc'
        );

        $this->importer->import($documentationRoots);

        $this->linkHasBeenCreatedForDocumentationRoots($documentationRoots);

        // import again: remove existing links
        $otherDocumentationRoots = array(
            'fixtures-some-library' => __DIR__ . '/fixtures/SomeLibrary/meta/doc'
        );
        $this->importer->import($otherDocumentationRoots);
        $this->linkHasBeenCreatedForDocumentationRoots($otherDocumentationRoots);
        $this->linkHasBeenRemovedForDocumentationRoots(array_diff($documentationRoots, $otherDocumentationRoots));
    }

    private function linkHasBeenCreatedForDocumentationRoots(array $documentationRoots)
    {
        foreach ($documentationRoots as $name => $documentationRoot) {
            $this->assertTrue(is_link($this->linksDirectory . $name));
        }
    }

    private function linkHasBeenRemovedForDocumentationRoots(array $documentationRoots)
    {
        foreach ($documentationRoots as $name => $documentationRoot) {
            $this->assertFalse(is_link($this->linksDirectory . $name));
        }
    }
}
