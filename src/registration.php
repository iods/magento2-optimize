<?php
/**
 * A SEO library for getting the most out of Catalog data in Magento 2.
 *
 * @package   Iods\Optimize
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright © 2022, Rye Miller (https://ryemiller.io)
 * @license   See LICENSE for license details.
 */
declare(strict_types=1);

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Iods_Optimize',
    __DIR__
);
