<?php

namespace Matthias\SphinxDocumentation\Tests;

use Matthias\SphinxDocumentation\DocumentationRootImporter;
use Symfony\Component\Filesystem\Filesystem;

class DocumentationRootImporterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_imports_documentation_roots_by_creating_symlinks_to_them_in_the_build_directory()
    {
        $buildDirectory = sys_get_temp_dir() . '/' . uniqid() . '/';
        $filesystem = new Filesystem();
        $filesystem->mkdir($buildDirectory);

        $importer = new DocumentationRootImporter($buildDirectory, $filesystem);

        $documentationRoots = array(
            'fixtures-some-library' => __DIR__ . '/fixtures/SomeLibrary/meta/doc',
            'fixtures-some-other-library' => __DIR__ . '/fixtures/SomeOtherLibrary/meta/doc'
        );

        $importer->import($documentationRoots);

        foreach ($documentationRoots as $name => $documentationRoot) {
            $this->assertTrue(is_link($buildDirectory . '/' . $name));
        }

        $filesystem->remove($buildDirectory);
    }
}
