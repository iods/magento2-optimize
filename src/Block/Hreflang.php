<?php
/**
 * A SEO library for getting the most out of Magento Catalog data.
 *
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright (c) 2021, Rye Miller (https://ryemiller.io)
 * @license   See LICENSE for license details.
 */
declare(strict_types=1);

namespace Iods\Optimize\Block;

use Iods\Optimize\Service\Hreflang\AlternativeUrlService;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\Group;
use Magento\Store\Model\Store;
use Magento\Store\Model\Website;

class Hreflang extends Template
{
    protected AlternativeUrlService $_alternativeUrlService;

    public function __construct(
        AlternativeUrlService $alternativeUrlService,
        Context $context,
        array $data = []
    ) {
        $this->_alternativeUrlService = $alternativeUrlService;
        parent::__construct($context, $data);
    }

    private function _getLocaleCode(Store $store): string
    {
        /** @var string $localeCode */
        $localeCode = $this->_scopeConfig->getValue('seo/hreflang/locale_code', 'stores', $store->getId())
            ?: $this->_scopeConfig->getValue('general/locale/code', 'stores', $store->getId());
        return str_replace('_', '-', strtolower($localeCode));
    }


    private function _isCurrentStore(Store $store): bool
    {
        return $store->getId() == $this->_storeManager->getStore()->getId();
    }


    protected function _getStoreUrl(Store $store): string
    {
        return $this->_alternativeUrlService->getAlternativeUrl($store);
    }

    protected function _getStores(): array
    {
        if ($this->_scopeConfig->isSetFlag('seo/hreflang/same_website')) {
            return $this->_getStoresSameWebsite();
        }
        return $this->_storeManager->getStores();
    }

    protected function _getStoresSameWebsite(): array
    {
        $stores = [];
        /** @var Website $website */
        $website = $this->_storeManager->getWebsite();
        foreach ($website->getGroups() as $g) {
            /** @var Group $g */
            foreach ($g->getStores() as $s) {
                $stores [] = $s;
            }
        }
        return $stores;
    }


    // return alternates
    public function getAlternates(): array
    {
        /** @var string[] $data */
        $data = [];

        /** @var Store $store */
        foreach ($this->_getStores() as $s) {
            /** @var string $url */
            $url = $this->_getStoreUrl($store);
            if ($url) {
                $data[$this->_getLocaleCode($s)] = $url;
            }
        }
        return $data;
    }

}

