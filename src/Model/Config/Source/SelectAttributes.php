<?php
/**
 * A SEO library for getting the most out of Magento Catalog data.
 *
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright (c) 2021, Rye Miller (https://ryemiller.io)
 * @license   See LICENSE for license details.
 */
declare(strict_types=1);

namespace Iods\Optimize\Model\Config\Source;

use Magento\Eav\Model\Entity\Attribute\Set;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\Collection;
use Magento\Framework\Data\OptionSourceInterface;

class SelectAttributes implements OptionSourceInterface
{
    protected Collection $_collection;

    public function __construct(
        Collection $collection
    ) {
        $this->_collection = $collection;
    }

    public function toOptionArray(): array
    {
        $this->_collection
            ->addFieldToFilter(Set::KEY_ENTITY_TYPE_ID, 4)
            ->addFieldToFilter('frontend_input', 'select');

        $attrs = $this->_collection->load()->getItems();
        $arr = [];
        foreach ($attrs as $attr) {
            $arr[] = [
                'value' => $attr['attribute_code'],
                'label' => $attr['frontend_label'] . ' (' . $attr['attribute_code'] . ')'
            ];
        }
        return $arr;
    }
}
