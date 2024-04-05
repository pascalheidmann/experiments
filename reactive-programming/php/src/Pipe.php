<?php

namespace Experiments\ReactivePhp;

class Pipe extends Observable
{
    public function __construct(?Observable $source)
    {
        parent::__construct($source);
    }
}