<?php

namespace Matthias\SphinxDocumentation;

use Symfony\Component\Filesystem\Filesystem;

class DocumentationRootImporter implements DocumentationRootImporterInterface
{
    private $buildDirectory;
    private $filesystem;

    public function __construct($buildDirectory, Filesystem $filesystem)
    {
        $this->buildDirectory = $buildDirectory;
        $this->filesystem = $filesystem;
    }

    public function import(array $documentationRoots)
    {
        foreach ($documentationRoots as $name => $sourceDirectory) {
            $targetDirectory = $this->buildDirectory . '/' . $name;
            $this->filesystem->symlink($sourceDirectory, $targetDirectory, true);
        }
    }
}
