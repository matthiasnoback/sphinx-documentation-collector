<?php

namespace Matthias\SphinxDocumentation;

use Symfony\Component\Filesystem\Filesystem;

class DocumentationRootImporter implements DocumentationRootImporterInterface
{
    private $filesystem;
    private $linksDirectory;

    public function __construct($linksDirectory, Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
        $this->linksDirectory = Path::directory($linksDirectory);
    }

    public function import(array $documentationRoots)
    {
        $this->filesystem->remove($this->linksDirectory);
        $this->filesystem->mkdir($this->linksDirectory);

        foreach ($documentationRoots as $name => $sourceDirectory) {
            $targetDirectory = $this->linksDirectory . $name;
            $this->filesystem->symlink($sourceDirectory, $targetDirectory, true);
        }
    }
}
