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

use Exception;
use Magento\Cms\Api\BlockRepositoryInterface;

class Parser
{
    protected BlockRepositoryInterface $_blockRepository;

    public function __construct(
        BlockRepositoryInterface $blockRepository
    ) {
        $this->_blockRepository = $blockRepository;
    }

    public function getBlockContentById(int $id): string
    {
        try {
            $_block = $this->_blockRepository->getById($id);

            return html_entity_decode($_block->getContent() ?? '');
        } catch (Exception $e) {
            return '';
        }
    }
}
