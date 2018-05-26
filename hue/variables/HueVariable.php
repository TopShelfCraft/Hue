<?php

namespace Craft;

class HueVariable
{
    /**
     * Creates a color from a hex value.
     *
     * @author    Aaron Waldon <aaron@causingeffect.com
     * @copyright Copyright (c) 2018, Aaron Waldon
     * @license   MIT
     * @param string $hex
     * @return Hue_ColorModel|null
     */
    public function createColorFromHex($hex)
    {
        if (!empty($hex))
        {
            $model = new Hue_ColorModel();
            $model->setColor($hex);
            return $model;
        }

        return null;
    }
}
