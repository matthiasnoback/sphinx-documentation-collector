# Sphinx documentation collector

This library provides a tool for collecting different documentation roots from all over your project and combine
them into one table of contents file, which will be your project documentation.

## Installing Sphinx

- Install Python if necessary (at least version 2.6)
- Install the ``easy_install`` for Python eggs (https://pypi.python.org/pypi/setuptools)
- Run ``easy_install sphinx``

### Enable PDF

- Run ``easy_install rst2pdf`` (more about that on http://rst2pdf.ralsina.com.ar/)
- Configure Sphinx and ``rst2pdf`` (http://rst2pdf.ralsina.com.ar/handbook.html#sphinx)

### For PHP and/or Symfony-related documentation

Install Sphinx PHP extensions by Fabien Potencier (https://github.com/fabpot/sphinx-php) using Composer:

    composer require --dev fabpot/sphinx-php:1.*

Then add the extensions:

    # in config.py

    import sys

    ...

    sys.path.insert(0, os.path.abspath('../../vendor/fabpot/sphinx-php'))

    extensions = [..., 'sensio.sphinx.refinclude', 'sensio.sphinx.configurationblock', 'sensio.sphinx.phpcode']

Configure the PHP lexer to work for code samples without a PHP open tag:

    from sphinx.highlighting import lexers
    from pygments.lexers.web import PhpLexer

    # enable highlighting for PHP code not between ``<?php ... ?>`` by default
    lexers['php'] = PhpLexer(startinline=True)
    lexers['php-annotations'] = PhpLexer(startinline=True)

    primary_domain = 'php'

    # API URL
    api_url = 'http://api.symfony.com/master/%s'

## Usage

    php bin/collect.php build/documentation --library-dir=src/Acme/*/ --library-dir=vendor/acme/*/

The first argument should be the Sphinx documentation directory. Then you need to supply one or more ``--library-dir``
options. Those will be used to scan for ``/meta/doc`` directories containing an ``index.rst`` file. For each of these
"documentation roots" a symlink will be created in the build directory. Finally a fresh table of contents is
automatically generated: it collects all the ``index.rst`` files from all over the project.
