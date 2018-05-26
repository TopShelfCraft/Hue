<?php
namespace Craft;

/**
 * HueFieldType
 *
 * @author    Aaron Waldon <aaron@causingeffect.com>
 * @copyright Copyright (c) 2018, Aaron Waldon
 * @license   MIT
 * @package   craft.plugins.hue
 * @since     1.0
 */
class Hue_ColorPaletteFieldType extends BaseFieldType implements IPreviewableFieldType
{

    /**
     * The fieldtype's name.
     *
     * @inheritDoc IComponentType::getName()
     *
     * @return string
     */
    public function getName()
    {
        return Craft::t('Hue Color Palette');
    }

    /**
     * The database column type.
     *
     * @inheritDoc IFieldType::defineContentAttribute()
     *
     * @return mixed
     */
    public function defineContentAttribute()
    {
        return array(AttributeType::String, 'required' => false);
    }

    /**
     * The plugin settings.
     *
     * @return array
     */
    protected function defineSettings()
    {
        return array(
            'palette' => AttributeType::String
        );
    }

    /**
     * The HTML for the settings.
     *
     * @return mixed
     * @throws Exception
     */
    public function getSettingsHtml()
    {
        $options = [];
        $palettes = craft()->config->get('palettes', 'hue');
        if (!empty($palettes) && is_array($palettes))
        {
            foreach ($palettes as $name => $colors)
            {
                $options[$name] = $name;
            }
        }

        return craft()->templates->render('hue/Hue_ColorPaletteFieldType/settings', array(
            'settings' => $this->getSettings(),
            'options' => $options
        ));
    }

    /**
     * Returns the fieldtype's input HTML.
     *
     * @param string $name
     * @param Hue_ColorPaletteColorModel|null $value
     *
     * @return string
     * @throws Exception
     */
    public function getInputHtml($name, $value)
    {
        //prep the id
        $id = craft()->templates->formatInputId($name);

        //get the colors
        $paletteColors = $this->getPaletteColors();

        //include the js and css
        craft()->templates->includeJsResource('hue/js/hue-palette-fields.js');
        craft()->templates->includeCssResource('hue/css/hue-palette-fields.css');

        //add the js to initialize this element
        craft()->templates->includeJs('new Craft.HueColorPalette("'.craft()->templates->namespaceInputId($name).'");');

        return craft()->templates->render('hue/Hue_ColorPaletteFieldType/input', array(
            'id'    => $id,
            'name'  => $name,
            'selectedModel' => $value,
            'colors' => $paletteColors
        ));
    }

    /**
     * Return the data that will be used in the templates and anytime this value is referenced.
     *
     * @param mixed $value
     * @return Hue_ColorPaletteColorModel|null
     */
    public function prepValue($value)
    {
        if (!empty($value))
        {
            $colorData = $this->getColorFromKey($value);

            if (!empty($colorData) && !empty($colorData['hex']))
            {
                $colorData['key'] = $value;
                return Hue_ColorPaletteColorModel::populateModel($colorData);
            }
        }

        return null;
    }

    /**
     * Returns a color preview field.
     *
     * @param Hue_ColorPaletteColorModel|null $value
     * @return string
     */
    public function getStaticHtml($value)
    {
        if (!is_null($value) && !empty($value->hex))
        {
            return HtmlHelper::encodeParams('<div class="color" style="cursor: default;"><div class="colorpreview" style="background-color: {bgColor};"></div></div><div class="colorhex code">{bgColor}</div>', array('bgColor' => $value->hex));
        }
        return ' ';
    }

    /**
     * Returns a color preview field.
     *
     * @param Hue_ColorPaletteColorModel|null $value
     *
     * @return string
     */
    public function getTableAttributeHtml($value)
    {
        if (!is_null($value) && !empty($value->hex))
        {
            return HtmlHelper::encodeParams('<div class="color small static"><div class="colorpreview" style="background-color: {bgColor};"></div></div><div class="colorhex code">{bgColor}</div>', array('bgColor' => $value->hex));
        }

        return ' ';
    }

    /**
     * Get the colors in this field's palette.
     *
     * @return array|null
     */
    private function getPaletteColors()
    {
        $colors = null;

        //get this field's palette
        $paletteKey = $this->getSettings()->palette;

        if (!is_null($paletteKey))
        {
            //get the config palettes
            $palettes = craft()->config->get('palettes', 'hue');

            //set the options
            if (!is_null($palettes) && is_array($palettes) && !empty($palettes[$paletteKey]))
            {
                $colors = (array) $palettes[$paletteKey];
            }
        }

       return $colors;
    }

    /**
     * Return a palette color by its key.
     *
     * @param $key
     * @return mixed|null
     */
    private function getColorFromKey($key)
    {
        if (!is_null($key))
        {
            $colors = $this->getPaletteColors();

            if (!is_null($colors) && is_array($colors) && isset($colors[$key]))
            {
                return $colors[$key];
            }
        }

        return null;
    }
}
