<?php
/**
 * A SEO library for getting the most out of Magento Catalog data.
 *
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright (c) 2021, Rye Miller (https://ryemiller.io)
 * @license   See LICENSE for license details.
 */
declare(strict_types=1);

namespace Iods\Optimize\Model;

use Iods\Optimize\Api\Data\AdapterInterface;
use Iods\Optimize\Api\Data\PropertyInterface;

class Adapter implements AdapterInterface
{
    protected array $_adapters = [];

    protected PropertyInterface $_property;

    public function __construct(
        PropertyInterface $property,
        array $_adapters = []
    ) {
        $this->_adapters = $_adapters;
        $this->_property = $property;
    }

    public function getProperty(): PropertyInterface
    {
        foreach ($this->_adapters as $a) {
            /** @var Property $property */
            $property = $a->getProperty();
            if ($property->hasData()) {
                return $property;
            }
        }
        return $this->_property;
    }
}
