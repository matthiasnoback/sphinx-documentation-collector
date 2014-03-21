<?php

namespace Matthias\SphinxDocumentation;

class TableOfContentsGenerator implements TableOfContentsGeneratorInterface
{
    private $buildDirectory;
    /**
     * @var int
     */
    private $maxDepth;

    public function __construct($buildDirectory, $maxDepth = 2)
    {
        $this->buildDirectory = $buildDirectory;
        $this->maxDepth = $maxDepth;
    }

    public function generateFor(array $documentRoots)
    {
        $tableOfContents = '.. toctree::'."\n";
        foreach (array_keys($documentRoots) as $name) {
            $tableOfContents .= '   '.$name.'/index'."\n";
        }

        file_put_contents($this->buildDirectory.'/index.rst', $tableOfContents);
    }
}
