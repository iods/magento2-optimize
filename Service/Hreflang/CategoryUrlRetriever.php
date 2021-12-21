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
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Model\Category;
use Magento\CatalogUrlRewrite\Model\CategoryUrlPathGenerator;

class CategoryUrlRetriever implements CategoryUrlRetrieverInterface
{
    protected CategoryRepositoryInterface $_categoryRepository;

    protected CategoryUrlPathGenerator $_categoryUrlPathGenerator;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        CategoryUrlPathGenerator $categoryUrlPathGenerator
    ) {
        $this->_categoryRepository = $categoryRepository;
        $this->_categoryUrlPathGenerator = $categoryUrlPathGenerator;
    }

    public function getUrl($id, $store): string
    {
        /** @var Category $category */
        $category = $this->_categoryRepository->get($id, $store->getId());
        if (!$category->getIsActive()) {
            return '';
        }
        $path = $this->_categoryUrlPathGenerator->getUrlPathWithSuffix($category);
        return $store->getBaseUrl() . $path;
    }
}
