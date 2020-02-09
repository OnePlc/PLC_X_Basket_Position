<?php
/**
 * module.config.php - Position Config
 *
 * Main Config File for Basket Position Plugin
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

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    # View Settings
    'view_manager' => [
        'template_path_stack' => [
            'basket-position' => __DIR__ . '/../view',
        ],
    ],
];