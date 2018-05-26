<?php
namespace Craft;

/**
 * Hue_ColorPaletteColorModel
 *
 * @author    Aaron Waldon <aaron@causingeffect.com
 * @copyright Copyright (c) 2018, Aaron Waldon
 * @license   MIT
 * @package   craft.plugins.hue
 * @since     1.0
 */
class Hue_ColorPaletteColorModel extends BaseModel
{
    /**
     * @return string
     */
    public function __toString()
    {
        return !is_null($this->value) ? $this->value : '';
    }

    /**
     * @return array
     */
    protected function defineAttributes()
    {
        return array(
            'key' => AttributeType::String,
            'value' => AttributeType::String,
            'label' => AttributeType::String,
            'hex' => AttributeType::String,
            'disabled' => AttributeType::Bool
        );
    }

    /**
     * Returns a color model.
     *
     * @return BaseModel
     */
    public function color()
    {
        return Hue_ColorModel::populateModel(['color' => $this->hex]);
    }
}