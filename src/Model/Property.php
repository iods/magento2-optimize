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

use Iods\Optimize\Api\Data\PropertyInterface;

final class Property implements PropertyInterface
{
    const META_DATA_GROUP = '_data';
    const DEFAULT_GROUP = 'default';
    const DEFAULT_PROPERTIES = [];
    const DEFAULT_PREFIX = '';
    const DEFAULT_ATTRIBUTE_NAME = 'name';
    const MAX_DESCRIPTION_LENGTH = 200;

    private string $_attribute = self::DEFAULT_ATTRIBUTE_NAME;

    private string $_prefix = self::DEFAULT_PREFIX;

    private array $_properties = self::DEFAULT_PROPERTIES;

    private array $_validImgFormats = [
        'gif',
        'jpg',
        'jpeg',
        'png',
        'svg',
        'webp'
    ];


    public function addProperty(string $key, $value, string $group = self::DEFAULT_GROUP): Property
    {
        $this->_properties[$group][$key] = $value;
        return $this;
    }


    public function getProperty(string $key, string $group = self::DEFAULT_GROUP)
    {
        return $this->_properties[$group][$key] ?? '';
    }


    public function hasData(string $group = self::DEFAULT_GROUP): bool
    {
        if ($this->_properties[$group] ?? false) {
            return true;
        }
        return false;
    }


    public function removeProperty(string $key, string $group = self::DEFAULT_GROUP): Property
    {
        unset($this->_properties[$group][$key]);
        return $this;
    }


    public function setDescription(string $description): Property
    {
        $description = $this->_getFilteredInput($description);
        if (strlen($description) >= self::MAX_DESCRIPTION_LENGTH) {
            $description = substr($description, 0, (self::MAX_DESCRIPTION_LENGTH -4)) . ' ...';
        }
        return $this->addProperty('description', $description);
    }


    public function setImage(string $image): Property
    {
        $ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        if (in_array($ext, $this->_validImgFormats)) {
            return $this->addProperty('image', $image);
        }
        throw new \LogicException(sprintf(
            'Invalid image format provided: [%s], please use one of the following [%s]',
            $ext,
            implode(',', $this->_validImgFormats)
        ));
    }


    public function setImageAlt(string $imageAlt): Property
    {
        return $this->addProperty('image:alt', htmlentities(strip_tags($imageAlt)));
    }


    public function setMetaAttributeName(string $attribute): Property
    {
        $this->_attribute = $attribute;
        return $this;
    }


    public function setPrefix(string $prefix): Property
    {
        $this->_prefix = $prefix;
        return $this;
    }

    public function setTitle(string $title): Property
    {
        return $this->addProperty('title', $this->_getFilteredInput($title));
    }


    public function setUrl(string $url): Property
    {
        if (filter_var($url, FILTER_VALIDATE_URL) !== false) {
            return $this->addProperty('url', $url);
        }
        throw new \LogicException(sprintf(
            'Not a valid URL: [%s]',
            $url
        ));
    }


    public function toHtml(string $group = self::DEFAULT_GROUP): string
    {
        $html = $this->_renderProperties($this->_properties, $group);
        $this->_resetValues($group);
        return $html;
    }

    // privates

    private function _getFilteredInput(string $input): string
    {
        $input = trim(strip_tags(str_replace(["\r\n", "\r", "\n"], "", $input)));
        return preg_replace('/\s+/', ' ', $input);
    }


    private function _getMetaTag(string $key, string $value): string
    {
        return sprintf(
            '<meta %s="%s%s" content="%s" />%s',
            $this->_attribute,
            $this->_prefix,
            strip_tags($key),
            strip_tags($value),
            PHP_EOL
        );
    }


    private function _renderProperties(array $properties, string $group = self::DEFAULT_GROUP): string
    {
        $html = [];

        if (isset($properties[$group])) {
            $properties = $properties[$group];
        }

        foreach ($properties as $p => $v) {
            if ($p === self::META_DATA_GROUP) {
                continue;
            }
            if (is_array($v)) {
                $list = $this->_renderProperties($v);
                $html[] = $list;
            } else {
                if (empty($v)) {
                    continue;
                }
                $html[] = $this->_getMetaTag($p, $v);
            }
        }
        return implode($html);
    }


    private function _resetValues(string $group = self::DEFAULT_GROUP)
    {
        $this->_properties[$group] = self::DEFAULT_PROPERTIES;
        $this->_prefix = self::DEFAULT_PREFIX;
        $this->_attribute = self::DEFAULT_ATTRIBUTE_NAME;
    }
}
