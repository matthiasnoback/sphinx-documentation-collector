# Sphinx documentation collector

This library provides a tool for collecting different documentation roots from all over your project and combine
them into one table of contents file, which will be your project documentation.

## Installing Sphinx

- Install Python if necessary (at least version 2.6)
- Install the ``easy_install`` for Python eggs (https://pypi.python.org/pypi/setuptools)
- Run ``easy_install sphinx``
- Run ``easy_install rst2pdf``

## Usage

    php bin/collect.php build/documentation --library-dir=src/Acme/*/ --library-dir=vendor/acme/*/

The first argument should be the Sphinx documentation directory. Then you need to supply one or more ``--library-dir``
options. Those will be used to scan for ``/meta/doc`` directories containing an ``index.rst`` file. For each of these
"documentation roots" a symlink will be created in the build directory. Finally a fresh table of contents is
automatically generated: it collects all the ``index.rst`` files from all over the project.
