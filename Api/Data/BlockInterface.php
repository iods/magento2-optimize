<?php
/**
 * A SEO library for getting the most out of Magento Catalog data.
 *
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright (c) 2021, Rye Miller (https://ryemiller.io)
 * @license   See LICENSE for license details.
 */
declare(strict_types=1);

namespace Iods\Optimize\Api\Data;

/**
 * Interface BlockInterface
 * @package Iods\Optimize\Api\Data
 */
interface BlockInterface
{
    /** @return string */
    public function getSeoMetaData(): string;
}
