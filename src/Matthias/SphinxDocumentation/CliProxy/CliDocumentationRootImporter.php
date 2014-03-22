<?php

namespace Matthias\SphinxDocumentation\CliProxy;

use Matthias\SphinxDocumentation\DocumentationRootImporterInterface;
use Aura\Cli\Stdio;

class CliDocumentationRootImporter implements DocumentationRootImporterInterface
{
    private $documentRootImporter;
    private $stdio;

    public function __construct(DocumentationRootImporterInterface $documentRootImporter, Stdio $stdio)
    {
        $this->documentRootImporter = $documentRootImporter;
        $this->stdio = $stdio;
    }

    public function import(array $documentationRoots)
    {
        foreach ($documentationRoots as $name => $path) {
            $this->stdio->outln(
                sprintf(
                    'Create symlink <<yellow>>%s<<reset>> to <<yellow>>%s<<reset>>',
                    $name,
                    $this->shortenedPath($path, 60)
                )
            );
        }

        $this->documentRootImporter->import($documentationRoots);
    }

    private function shortenedPath($path, $maxLength)
    {
        if (strlen($path) <= $maxLength) {
            return $path;
        }

        return '...' . substr($path, -1 * ($maxLength - 3));
    }
}
