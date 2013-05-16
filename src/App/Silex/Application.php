<?php

namespace App\Silex;

use Aptoma\Silex\Application as BaseApplication;

class Application extends BaseApplication
{

    public function __construct(array $values = array())
    {
        parent::__construct($values);

        $this->registerLogger($this);
        $this->registerTwig($this);
    }
}
