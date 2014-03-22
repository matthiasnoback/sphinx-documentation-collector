<?php

namespace Matthias\SphinxDocumentation;

class Path
{
    public static function directory($path)
    {
        return rtrim($path, '/').'/';
    }
}
