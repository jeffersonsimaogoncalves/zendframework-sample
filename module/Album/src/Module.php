<?php
/**
 * Created by PhpStorm.
 * User: Jefferson Simão Gonçalves
 * Email: gerson.simao.92@gmail.com
 * Date: 20/06/2018
 * Time: 15:07
 */

namespace Album;


use Album\Controller\AlbumController;
use Album\Model\Album;
use Album\Model\AlbumTable;
use Album\Model\AlbumTableGateway;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                AlbumTable::class => function ($container) {
                    $tableGateway = $container->get(AlbumTableGateway::class);

                    return new AlbumTable($tableGateway);
                },
                AlbumTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Album());

                    return new TableGateway('album', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                AlbumController::class => function ($container) {
                    return new AlbumController($container->get(AlbumTable::class));
                },
            ],
        ];
    }
}