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
        $this->projectDirectory = Path::directory($projectDirectory);
        $this->indexFile = $indexFile;
        $this->documentationDirectory = Path::directory($documentationDirectory);
        $this->libraryDirectories = $libraryDirectories;
    }

    public function collect()
    {
        $indexFiles = $this->findIndexFiles();

        $documentationRootDirectories = $this->getDocumentationRootsFor($indexFiles);

        return $documentationRootDirectories;
    }

    private function createSafeNameForRoot($documentationRootDirectory)
    {
        return substr(md5($documentationRootDirectory), 0, 8);
    }

    private function findIndexFiles()
    {
        $documentationDirectory = $this->documentationDirectory;
        $projectDocumentationDirectories = array_map(
            function ($directory) use ($documentationDirectory) {
                return Path::directory($this->projectDirectory . $directory . $documentationDirectory);
            },
            $this->libraryDirectories
        );

        $indexFiles = Finder::create()
            ->in($projectDocumentationDirectories)
            ->files()
            ->name($this->indexFile);

        return $indexFiles;
    }

    private function getDocumentationRootsFor($indexFiles)
    {
        $documentationRootDirectories = array();

        foreach ($indexFiles as $indexFile) {
            /** @var $indexFile \SplFileInfo */
            $documentationRootDirectory = $indexFile->getPath();
            $safeName = $this->createSafeNameForRoot($documentationRootDirectory);
            $documentationRootDirectories[$safeName] = $documentationRootDirectory;
        }
        return $documentationRootDirectories;
    }
}
