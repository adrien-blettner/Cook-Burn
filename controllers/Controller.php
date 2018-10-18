<?php

abstract class Controller
{
    abstract protected function __construct($args);

    abstract function render ();
}