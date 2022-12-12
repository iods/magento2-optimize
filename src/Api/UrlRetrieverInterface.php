<?php
/**
 * A SEO library for getting the most out of Magento Catalog data.
 *
 * @package   Iods_Optimize
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright (c) 2021, Rye Miller (https://ryemiller.io)
 * @license   See LICENSE for license details.
 */
declare(strict_types=1);

namespace Iods\Optimize\Api;

interface UrlRetrieverInterface
{
    public function getUrl($id, $store): string;
}
