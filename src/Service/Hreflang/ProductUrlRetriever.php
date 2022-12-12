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

use Iods\Optimize\Api\Data\ProductUrlRetrieverInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product;
use Magento\CatalogUrlRewrite\Model\ProductUrlPathGenerator;

class ProductUrlRetriever implements ProductUrlRetrieverInterface
{
    protected ProductRepositoryInterface $_productRepository;

    protected ProductUrlPathGenerator $_productUrlPathGenerator;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        ProductUrlPathGenerator $productUrlPathGenerator
    ) {
        $this->_productRepository = $productRepository;
        $this->_productUrlPathGenerator = $productUrlPathGenerator;
    }

    public function getUrl($id, $store): string
    {
        /** @var Product $product */
        $product = $this->_productRepository->getById($id, false, $store->getId());
        if ($product->isDisabled()) {
            return '';
        }
        $path = $this->_productUrlPathGenerator->getUrlPathWithSuffix($product, $store->getId());
        return $store->getBaseUrl() . $path;
    }
}
