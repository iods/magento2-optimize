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

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Framework\Data\OptionSourceInterface;

class Robots extends AbstractSource implements OptionSourceInterface
{
    public const VALUES = [
        'INDEX, FOLLOW',
        'NOINDEX, FOLLOW',
        'INDEX, NOFOLLOW',
        'NOINDEX, NOFOLLOW'
    ];

    public function getAllOptions(): array
    {
        $arr = [];
        $arr[] = [
            'value' => '',
            'label' => ' '
        ];
        foreach (self::VALUES as $v) {
            $arr[] = [
                'value' => $v,
                'label' => $v
            ];
        }
        return $arr;
    }
}

