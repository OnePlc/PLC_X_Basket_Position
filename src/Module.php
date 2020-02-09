<?php
/**
 * Module.php - Module Class
 *
 * Module Class File for Basket Position Plugin
 *
 * @category Config
 * @package Basket\Position
 * @author Verein onePlace
 * @copyright (C) 2020  Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

namespace OnePlace\Basket\Position;

use Application\Controller\CoreEntityController;
use Laminas\Mvc\MvcEvent;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\EventManager\EventInterface as Event;
use Laminas\ModuleManager\ModuleManager;
use OnePlace\Basket\Model\BasketTable;
use OnePlace\Basket\Position\Controller\PositionController;

class Module {
    /**
     * Module Version
     *
     * @since 1.0.0
     */
    const VERSION = '1.0.0';

    /**
     * Load module config file
     *
     * @since 1.0.0
     * @return array
     */
    public function getConfig() : array {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap(Event $e)
    {
        // This method is called once the MVC bootstrapping is complete
        $application = $e->getApplication();
        $container    = $application->getServiceManager();
        $oDbAdapter = $container->get(AdapterInterface::class);
        $tableGateway = $container->get(BasketTable::class);
        $aPluginTables = [];
        $aPluginTables['position'] = $container->get(Model\PositionTable::class);

        # Register Filter Plugin Hook
        CoreEntityController::addHook('basket-view-before',(object)['sFunction'=>'attachPosition','oItem'=>new PositionController($oDbAdapter,$tableGateway,$container,$aPluginTables)]);
        //CoreEntityController::addHook('contacthistory-add-before-save',(object)['sFunction'=>'attachPositionToBasket','oItem'=>new PositionController($oDbAdapter,$tableGateway,$container)]);
    }

    /**
     * Load Models
     */
    public function getServiceConfig() : array {
        return [
            'factories' => [
                # Position Plugin - Base Model
                Model\PositionTable::class => function($container) {
                    $tableGateway = $container->get(Model\PositionTableGateway::class);
                    return new Model\PositionTable($tableGateway,$container);
                },
                Model\PositionTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Position($dbAdapter));
                    return new TableGateway('basket_position', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    /**
     * Load Controllers
     */
    public function getControllerConfig() : array {
        return [
            'factories' => [
                # Plugin Example Controller
                Controller\PositionController::class => function($container) {
                    $oDbAdapter = $container->get(AdapterInterface::class);
                    $tableGateway = $container->get(BasketTable::class);

                    # hook start
                    # hook end
                    return new Controller\PositionController(
                        $oDbAdapter,
                        $tableGateway,
                        $container
                    );
                },
            ],
        ];
    }
}
