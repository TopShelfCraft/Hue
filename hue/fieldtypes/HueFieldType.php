<?php
namespace Craft;

/**
 * HueFieldType
 *
 * @author    Top Shelf Craft <michael@michaelrog.com>
 * @copyright Copyright (c) 2016, Michael Rog
 * @license   http://topshelfcraft.com/license
 * @see       http://topshelfcraft.com
 * @package   craft.plugins.hue
 * @since     1.0
 */
class HueFieldType extends BaseFieldType implements IPreviewableFieldType
{

    /**
     * @inheritDoc IComponentType::getName()
     *
     * @return string
     */
    public function getName()
    {
        return Craft::t('Hue Color Picker');
    }

    /**
     * @inheritDoc IFieldType::defineContentAttribute()
     *
     * @return mixed
     */
    public function defineContentAttribute()
    {
        return array(AttributeType::String, 'required' => false);
    }

    /**
     * @return array
     */
    protected function defineSettings()
    {
        return array(
            'defaultColor' => AttributeType::Mixed,
        );
    }

    /**
     * @return mixed
     */
    public function getSettingsHtml()
    {
        return craft()->templates->render('hue/HueFieldType/settings', array(
            'settings' => $this->getSettings()
        ));
    }

    /**
     * @param mixed $value
     *
     * @return Hue_ColorModel|null
     */
    public function prepValue($value)
    {

        if (empty($value))
        {
            return null;
        }
        else
        {
            $model = new Hue_ColorModel();
            $model->setColor($value);
            return $model;
        }

    }

    /**
     * @param mixed $value
     *
     * @return string|null
     */
    public function prepValueFromPost($value)
    {

        if (empty($value))
        {
            return null;
        }
        else
        {

            // TODO: I should be validating this properly.

            $value = str_replace('#', '', $value);

            if (strlen($value) == 3)
            {
                $r = substr($value,0,1);
                $g = substr($value,1,1);
                $b = substr($value,2,1);
                $value = $r.$r.$g.$g.$b.$b;
            }
            else
            {
                $value = substr($value, 0, 6);
                $value = str_pad($value, 6, '0');
            }

            return '#'.$value;

        }

    }

    /**
     * @inheritDoc IFieldType::getInputHtml()
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return string
     */
    public function getInputHtml($name, $value)
    {

        if (empty($value))
        {
            $value = $this->getSettings()->defaultColor;
        }

        $id = craft()->templates->formatInputId($name);
        $rando = StringHelper::randomString(100);

        return craft()->templates->render('hue/HueFieldType/input', array(
            'id'    => $id,
            'nsId'  => craft()->templates->namespaceInputId($id),
            'pickerId'  => $rando.'_picker',
            'inputId'  => $rando.'_input',
            'clearButtonId'  => $rando.'_clearButton',
            'name'  => $name,
            'value' => $value,
            'default' => $this->getSettings()->defaultColor,
        ));

    }

    /**
     * @inheritDoc IFieldType::getStaticHtml()
     *
     * @param mixed $value
     *
     * @return string
     */
    public function getStaticHtml($value)
    {
        if ($value)
        {
            return HtmlHelper::encodeParams('<div class="color" style="cursor: default;"><div class="colorpreview" style="background-color: {bgColor};"></div></div>'.
                '<div class="colorhex code">{bgColor}</div>', array('bgColor' => $value));
        }
    }

    /**
     * @inheritDoc IPreviewableFieldType::getTableAttributeHtml()
     *
     * @param mixed $value
     *
     * @return string
     */
    public function getTableAttributeHtml($value)
    {
        if (!empty($value))
        {
            return '<div class="color small static"><div class="colorpreview" style="background-color: '.$value.';"></div></div>'.
            '<div class="colorhex code">'.$value.'</div>';
        }
        else
        {
            return '&mdash;';
        }
    }

}
