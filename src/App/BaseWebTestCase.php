<?php

namespace App;

class BaseWebTestCase extends \Aptoma\TestToolkit\BaseWebTestCase
{
    public function setUp()
    {
        $this->pathToAppBootstrap = __DIR__.'/../../app/app.php';
        parent::setUp();
    }
}
