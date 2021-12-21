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

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Store\Model\StoreManagerInterface;

class Stores implements OptionSourceInterface
{
    protected StoreManagerInterface $_storeManager;

    public function __construct(
        StoreManagerInterface $storeManager
    ) {
        $this->_storeManager = $storeManager;
    }

    public function toOptionArray(): array
    {
        $final = [];
        $stores = $this->_storeManager->getStores();

        foreach ($stores as $s) {
            $final[] = [
                'value' => $s->getId(),
                'label' => $s->getName()
            ];
        }
        return $final;
    }
}

