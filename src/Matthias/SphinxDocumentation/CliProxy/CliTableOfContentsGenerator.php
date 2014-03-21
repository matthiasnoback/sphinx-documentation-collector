<?php

namespace Matthias\SphinxDocumentation\CliProxy;

use Aura\Cli\Stdio;
use Matthias\SphinxDocumentation\TableOfContentsGeneratorInterface;

class CliTableOfContentsGenerator implements TableOfContentsGeneratorInterface
{
    private $tableOfContentsGenerator;
    private $stdio;

    public function __construct(TableOfContentsGeneratorInterface $tableOfContentsGenerator, Stdio $stdio)
    {
        $this->tableOfContentsGenerator = $tableOfContentsGenerator;
        $this->stdio = $stdio;
    }

    public function generateFor(array $documentRoots)
    {
        $this->stdio->outln('Generate table of contents');

        $this->tableOfContentsGenerator->generateFor($documentRoots);

        $this->stdio->outln('<<green>>Done<<reset>>');
    }
}
