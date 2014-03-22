<?php

namespace Matthias\SphinxDocumentation;

class TableOfContentsGenerator implements TableOfContentsGeneratorInterface
{
    private $linksDirectory;
    private $maxDepth;

    public function __construct($linksDirectory, $maxDepth = 2)
    {
        $this->linksDirectory = $linksDirectory;
        $this->maxDepth = $maxDepth;
    }

    public function generateFor(array $documentRoots)
    {
        $tableOfContents = '.. toctree::' . "\n";

        foreach (array_keys($documentRoots) as $name) {
            $tableOfContents .= '   ' . $name . '/index' . "\n";
        }

        file_put_contents($this->linksDirectory . 'index.rst', $tableOfContents);
    }
}
