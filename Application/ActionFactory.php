<?php

namespace Application;

use Reports\ReportsController;

class ActionFactory
{
    private $routeParams;
    private $routeConfig;

    const REPORT_CONTOLLER = 'reports';

    public function __construct()
    {
        $this->routeParams = $_SERVER['REQUEST_URI'];
    }

    public function actionCreator()
    {
        $uriArray = explode("/", $this->routeParams);

        if (isset($this->getRouteConfig()['routes'][$uriArray[1]])) {

            if (self::REPORT_CONTOLLER === $uriArray[1]) {
                $reportsController = new ReportsController();
                if (isset($this->routeConfig['routes'][$uriArray[1]][$uriArray[2]])) {
                    $reportsController->{$this->routeConfig['routes'][$uriArray[1]][$uriArray[2]]['action']}();
                } else {
                    throw new \Exception('Url not found');
                }
            } else {
                throw new \Exception('Url not found');
            }
        } else {
            throw new \Exception('Url not found');
        }
    }

    private function getRouteConfig()
    {
        if (!isset($this->routeConfig)) {
            $this->setRouteConfig();
        }

        return $this->routeConfig;
    }

    private function setRouteConfig()
    {
        if (!(include 'Configs/application.config.php')) {
            throw new \Exception('Application config configurations not found');
        }

        $this->routeConfig = include 'Configs/application.config.php';
    }
}
