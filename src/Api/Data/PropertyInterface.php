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

interface PropertyInterface
{
    public function addProperty(string $key, $value);

    public function setDescription(string $description);

    public function setImage(string $image);

    public function setImageAlt(string $imageAlt);

    public function setMetaAttributeName(string $attribute);

    public function setPrefix(string $prefix);

    public function setTitle(string $title);

    public function setUrl(string $url);
}
