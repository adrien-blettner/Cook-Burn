<?php

class Route
{
    private $url;
    private $fonction;
    private $correspondances;

    public function __construct($url, callable $fonction)
    {
        $this->url = trim ($url, '/');
        $this->fonction = $fonction;
    }

    public function match ($url)
    {
        $url = trim ($url, '/');
        $chemin = preg_replace('#:([\w]+)#', '([^/]+)', $this->url);
        $regex = "#^$chemin$#i";

        if (!preg_match($regex, $url, $correspondances))
            return false;

        array_shift($correspondances);
        $this->correspondances = $correspondances;
        return true;
    }

    public function call ()
    {
        return call_user_func_array($this->fonction, $this->correspondances);
    }
}