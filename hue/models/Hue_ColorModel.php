<?php
namespace Craft;

/**
 * Hue_ColorModel
 *
 * @author    Top Shelf Craft <michael@michaelrog.com>
 * @copyright Copyright (c) 2016, Michael Rog
 * @license   http://topshelfcraft.com/license
 * @see       http://topshelfcraft.com
 * @package   craft.plugins.hue
 * @since     1.0
 */
class Hue_ColorModel extends BaseModel
{

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getHex();
    }

    /**
     * @return array
     */
    protected function defineAttributes()
    {
        return array(
            'color' => AttributeType::String,
        );
    }

    /**
     * @param $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * @return string
     */
    public function getHex()
    {
        return $this->color;
    }

    /**
     * @return string
     */
    public function getRgb()
    {
        return $this->hexToRgb($this->color);
    }


    /**
     * @return int
     */
    public function getRed()
    {
        $rgb = $this->hexToRgb($this->color, true);
        return $rgb['red'];
    }

    /**
     * @return int
     */
    public function r()
    {
        return $this->getRed();
    }

    /**
     * @return int
     */
    public function getGreen()
    {
        $rgb = $this->hexToRgb($this->color, true);
        return $rgb['green'];
    }

    /**
     * @return int
     */
    public function g()
    {
        return $this->getGreen();
    }

    /**
     * @return int
     */
    public function getBlue()
    {
        $rgb = $this->hexToRgb($this->color, true);
        return $rgb['blue'];
    }

    /**
     * @return int
     */
    public function b()
    {
        return $this->getBlue();
    }

    /**
     * @param $hex
     * @param bool $returnAsArray
     *
     * @return array|string
     */
    public function hexToRgb($hex, $returnAsArray = false)
    {

        $hex = str_replace("#", "", $hex);

        if(strlen($hex) == 3) {
            $r = hexdec(substr($hex,0,1).substr($hex,0,1));
            $g = hexdec(substr($hex,1,1).substr($hex,1,1));
            $b = hexdec(substr($hex,2,1).substr($hex,2,1));
        } else {
            $r = hexdec(substr($hex,0,2));
            $g = hexdec(substr($hex,2,2));
            $b = hexdec(substr($hex,4,2));
        }

        $rgb = array('r' => $r, 'g' => $g, 'b' => $b);

        return $returnAsArray ? $rgb : implode(",", $rgb);

    }

}