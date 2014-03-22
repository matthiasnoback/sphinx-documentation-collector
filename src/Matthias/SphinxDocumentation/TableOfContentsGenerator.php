<?php

namespace Matthias\SphinxDocumentation;

class TableOfContentsGenerator implements TableOfContentsGeneratorInterface
{
    private $buildDirectory;
    private $maxDepth;
    private $relativeLinksDirectory;

    public function __construct($buildDirectory, $relativeLinksDirectory, $maxDepth = 2)
    {
        $this->buildDirectory = $buildDirectory;
        $this->relativeLinksDirectory = $relativeLinksDirectory;
        $this->maxDepth = $maxDepth;
    }

    public function generateFor(array $documentRoots)
    {
        $tableOfContents = '.. toctree::' . "\n";

        foreach (array_keys($documentRoots) as $name) {
            $tableOfContents .= '   ' . $this->relativeLinksDirectory . $name . '/index' . "\n";
        }

        file_put_contents($this->buildDirectory . 'index.rst', $tableOfContents);
    }
}
