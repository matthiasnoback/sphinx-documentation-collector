<?php

namespace Matthias\SphinxDocumentation;

interface TableOfContentsGeneratorInterface
{
    public function generateFor(array $documentRoots);
}
