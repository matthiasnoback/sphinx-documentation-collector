<?php

namespace Matthias\SphinxDocumentation;

use Symfony\Component\Finder\Finder;

class DocumentationRootCollector implements DocumentationRootCollectorInterface
{
    private $projectDirectory;
    private $indexFile;
    private $documentationDirectory;
    private $libraryDirectories;

    public function __construct($projectDirectory, $indexFile, $documentationDirectory, array $libraryDirectories)
    {
        $this->projectDirectory = $projectDirectory;
        $this->indexFile = $indexFile;
        $this->documentationDirectory = $documentationDirectory;
        $this->libraryDirectories = $libraryDirectories;
    }

    public function collect()
    {
        $documentationDirectory = $this->documentationDirectory;
        $projectDocumentationDirectories = array_map(
            function ($directory) use ($documentationDirectory) {
                return $this->projectDirectory . $directory . $documentationDirectory;
            },
            $this->libraryDirectories
        );

        $indexFiles = Finder::create()->in($projectDocumentationDirectories)->files()->name($this->indexFile);

        $documentationRootDirectories = array();

        foreach ($indexFiles as $indexFile) {
            /** @var $indexFile \SplFileInfo */
            $documentationRootDirectory = $indexFile->getPath();
            $slug = $this->createSlugForRoot($documentationRootDirectory);
            $documentationRootDirectories[$slug] = $documentationRootDirectory;
        }

        return $documentationRootDirectories;
    }

    private function createSlugForRoot($documentationRootDirectory)
    {
        $libraryDirectory = substr($documentationRootDirectory, strlen($this->projectDirectory), -1 * strlen($this->documentationDirectory));

        $libraryDirectory = trim(preg_replace('#\/#', '-', $libraryDirectory), '-');

        return strtolower(preg_replace('~(?<=\\w)([A-Z])~', '-$1', $libraryDirectory));
    }
}
