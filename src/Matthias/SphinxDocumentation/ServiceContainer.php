<?php

namespace Matthias\SphinxDocumentation;

use Aura\Cli\CliFactory;
use Matthias\SphinxDocumentation\CliProxy\CliDocumentationRootImporter;
use Matthias\SphinxDocumentation\CliProxy\CliTableOfContentsGenerator;
use Symfony\Component\Filesystem\Filesystem;

class ServiceContainer extends \Pimple
{
    public function __construct($projectDirectory, $buildDirectory, array $libraryDirectories, $cli)
    {
        $this['project_directory'] = $projectDirectory;
        $this['build_directory'] = $buildDirectory;
        $this['index_file_name'] = 'index.rst';
        $this['library_directories'] = $libraryDirectories;
        $this['documentation_directory'] = '/meta/doc';

        $servicePrefix = $cli ? 'cli_' : '';

        $this['cli_factory'] = $this->share(
            function () {
                return new CliFactory();
            }
        );

        $this['stdio'] = $this->share(
            function (ServiceContainer $serviceContainer) {
                return $serviceContainer->getCliFactory()->newStdio();
            }
        );

        $this['builder'] = $this->share(
            function (ServiceContainer $serviceContainer) use ($servicePrefix) {
                return new Builder(
                    $serviceContainer[$servicePrefix . 'documentation_root_collector'],
                    $serviceContainer[$servicePrefix . 'documentation_root_importer'],
                    $this[$servicePrefix . 'table_of_contents_generator']
                );
            }
        );

        $this['documentation_root_collector'] = $this->share(
            function (ServiceContainer $serviceContainer) {
                return new DocumentationRootCollector(
                    $serviceContainer['project_directory'],
                    $serviceContainer['index_file_name'],
                    $serviceContainer['documentation_directory'],
                    $serviceContainer['library_directories']
                );
            }
        );

        $this['cli_documentation_root_collector'] = $this['documentation_root_collector'];

        $this['documentation_root_importer'] = $this->share(
            function (ServiceContainer $serviceContainer) {
                return new DocumentationRootImporter($serviceContainer['build_directory'], $serviceContainer['filesystem']);
            }
        );

        $this['cli_documentation_root_importer'] = $this->share(
            function (ServiceContainer $serviceContainer) {
                return new CliDocumentationRootImporter($serviceContainer['documentation_root_importer'], $serviceContainer['stdio']);
            }
        );

        $this['table_of_contents_generator'] = $this->share(
            function (ServiceContainer $serviceContainer) {
                return new TableOfContentsGenerator($serviceContainer['build_directory']);
            }
        );


        $this['cli_table_of_contents_generator'] = $this->share(
            function (ServiceContainer $serviceContainer) {
                return new CliTableOfContentsGenerator($serviceContainer['table_of_contents_generator'], $serviceContainer['stdio']);
            }
        );

        $this['filesystem'] = $this->share(
            function () {
                return new Filesystem();
            }
        );
    }

    /**
     * @return Builder;
     */
    public function getBuilder()
    {
        return $this['builder'];
    }

    /**
     * @return CliFactory
     */
    public function getCliFactory()
    {
        return $this['cli_factory'];
    }
}
