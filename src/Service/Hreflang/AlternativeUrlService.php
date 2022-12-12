<?php
/**
 * A SEO library for getting the most out of Magento Catalog data.
 *
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright (c) 2021, Rye Miller (https://ryemiller.io)
 * @license   See LICENSE for license details.
 */
declare(strict_types=1);

namespace Iods\Optimize\Service\Hreflang;

use Iods\Optimize\Api\Data\CategoryUrlRetrieverInterface;
use Iods\Optimize\Api\Data\CmsPageUrlRetrieverInterface;
use Iods\Optimize\Api\Data\ProductUrlRetrieverInterface;
use Magento\Framework\App\Request\Http;

class AlternativeUrlService {

    protected CategoryUrlRetrieverInterface $_categoryUrlRetriever;

    protected CmsPageUrlRetrieverInterface $_cmsPageUrlRetriever;

    protected Http $_httpRequest;

    protected ProductUrlRetrieverInterface $_productUrlRetriever;

    public function __construct(
        CategoryUrlRetrieverInterface $categoryUrlRetriever,
        CmsPageUrlRetrieverInterface $cmsPageUrlRetriever,
        Http $httpRequest,
        ProductUrlRetrieverInterface $productUrlRetriever
    ) {
        $this->_categoryUrlRetriever = $categoryUrlRetriever;
        $this->_cmsPageUrlRetriever = $cmsPageUrlRetriever;
        $this->_httpRequest = $httpRequest;
        $this->_productUrlRetriever = $productUrlRetriever;
    }

    public function getAlternativeUrl($store): string
    {
        $url = '';
        switch ($this->_httpRequest->getFullActionName()) {
            case 'catalog_category_view':
                $url = $this->_categoryUrlRetriever->getUrl(
                    $this->_httpRequest->getParam('id'),
                    $store
                );
                break;
            case 'catalog_product_view':
                $url = $this->_productUrlRetriever->getUrl(
                    $this->_httpRequest->getParam('id'),
                    $store
                );
                break;
            case 'cms_page_view':
                $url = $this->_cmsPageUrlRetriever->getUrl(
                    $this->_httpRequest->getParam('page_id'),
                    $store
                );
                break;
            case 'cms_index_index':
                $url = $store->getBaseUrl();
                break;
        }
        return $url;
    }
}
