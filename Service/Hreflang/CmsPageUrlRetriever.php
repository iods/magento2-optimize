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

use Iods\Optimize\Api\Data\CmsPageUrlRetrieverInterface;
use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Cms\Model\ResourceModel\Page;
use Magento\CmsUrlRewrite\Model\CmsPageUrlPathGenerator;
use Magento\Framework\Exception\LocalizedException;

class CmsPageUrlRetriever implements CmsPageUrlRetrieverInterface
{
    protected CmsPageUrlPathGenerator $_cmsPageUrlPathGenerator;

    protected Page $_page;

    protected PageRepositoryInterface $_pageRepository;

    public function __construct(
        CmsPageUrlPathGenerator $cmsPageUrlPathGenerator,
        Page $page,
        PageRepositoryInterface $pageRepository
    ) {
        $this->_cmsPageUrlPathGenerator = $cmsPageUrlPathGenerator;
        $this->_page = $page;
        $this->_pageRepository = $pageRepository;
    }

    public function getUrl($id, $store): string
    {
        try {
            $page = $this->_pageRepository->getById($id);
            $pageId = $this->_page->checkIdentifier($page->getIdentifier(), $store->getId());
            $storePage = ($id === $pageId) ? $page : $this->_pageRepository->getById($pageId);
            $path = $this->_cmsPageUrlPathGenerator->getUrlPath($storePage);
            return $store->getBaseUrl() . $path;
        } catch (LocalizedException $exception) {
            return '';
        }
    }
}
