<?php

namespace Matthias\SphinxDocumentation;

class Builder
{
    private $documentationRootCollector;
    private $documentationRootImporter;
    private $tableOfContentsGenerator;

    public function __construct(
        DocumentationRootCollectorInterface $documentationRootCollector,
        DocumentationRootImporterInterface $documentationRootImporter,
        TableOfContentsGeneratorInterface $tableOfContentsGenerator
    ) {
        $this->documentationRootCollector = $documentationRootCollector;
        $this->documentationRootImporter = $documentationRootImporter;
        $this->tableOfContentsGenerator = $tableOfContentsGenerator;
    }

    public function build()
    {
        $documentationRoots = $this->documentationRootCollector->collect();

        $this->documentationRootImporter->import($documentationRoots);

        $this->tableOfContentsGenerator->generateFor($documentationRoots);
    }
}
