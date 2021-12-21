<?php
/**
 * A SEO library for getting the most out of Magento Catalog data.
 *
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright (c) 2021, Rye Miller (https://ryemiller.io)
 * @license   See LICENSE for license details.
 */
declare(strict_types=1);

namespace Iods\Optimize\Model\Config\Source\Twitter;

use Magento\Framework\Data\OptionSourceInterface;

class CardType implements OptionSourceInterface
{
    protected const CARD_TYPE_APP = 'app';

    protected const CARD_TYPE_PLAYER = 'player';

    protected const CARD_TYPE_SUMMARY = 'summary';

    protected const CARD_TYPE_SUMMARY_IMAGE_LRG = 'summary_image_large';

    protected array $_options;


    public function toOptionArray(): array
    {
        if (!$this->_options) {
            $this->_options = [
                ['value' => self::CARD_TYPE_SUMMARY, 'label' => __('Summary')],
                ['value' => self::CARD_TYPE_SUMMARY_IMAGE_LRG, 'label' => __('Summary w/ Image')],
                ['value' => self::CARD_TYPE_APP, 'label' => __('App')],
                ['value' => self::CARD_TYPE_PLAYER, 'label' => __('Player')],
            ];
        }
        return $this->_options;
    }
}
