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
        return $rgb['r'];
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
        return $rgb['g'];
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
        return $rgb['b'];
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
        
        $shorthand = (strlen($hex) == 4);

        list($r, $g, $b) = $shorthand? sscanf($hex, "#%1s%1s%1s") : sscanf($hex, "#%2s%2s%2s");
        
        $rgb = [
            "r" => hexdec($shorthand? "$r$r" : $r),
            "g" => hexdec($shorthand? "$g$g" : $g),
            "b" => hexdec($shorthand? "$b$b" : $b)
        ];
        
        return $returnAsArray ? $rgb : implode(",", $rgb);

    }

	/**
	 * Get brightness of an image. Values closer to 0 are darker, closer to 1 are lighter.
	 *
	 * @see http://stackoverflow.com/a/12228906/1136822 Stack Overflow answer.
	 * @see https://en.wikipedia.org/wiki/Luma_(video) Luma
	 *
	 * @return float
	 */
    public function luma()
	{
		$rgb = $this->hexToRgb($this->color, true);
		$r = $rgb['r'];
		$g = $rgb['g'];
		$b = $rgb['b'];

		return (0.2126*$r + 0.7152*$g + 0.0722*$b)/255;
	}
}
