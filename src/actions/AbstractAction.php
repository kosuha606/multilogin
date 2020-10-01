<?php

namespace app\actions;

use app\Application;

abstract class AbstractAction
{
    /**
     * @var Application
     */
    protected $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * @throws \Exception
     * @return mixed
     */
    public function run($provider)
    {
        throw new \Exception('Empty action run');
    }
}