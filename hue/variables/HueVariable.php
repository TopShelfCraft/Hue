<?php
namespace Craft;

class HueVariable
{
	/**
	 * Creates a color from a hex value.
	 *
	 * @param string $hex
	 * @return Hue_ColorModel|null
	 */
	public function createColorFromHex($hex)
	{
		if (empty($hex))
		{
			return null;
		}
		else
		{
			$model = new Hue_ColorModel();
			$model->setColor($hex);
			return $model;
		}
	}
}
