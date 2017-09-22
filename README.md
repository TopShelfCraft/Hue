# Hue

_A slightly better color picker for CraftCMS_

by Michael Rog  
[https://topshelfcraft.com](https://topshelfcraft.com)



### TL;DR.

The _Hue_ fieldtype works almost identically to Craft's native Color field, with some added bonuses:

- You can directly edit the color code as text.
- You can specify a default color in the field settings.
- You can clear (i.e. un-set) field values
- You can set the default color to be empty.
- The `ColorModel` gives you access to nice helper variables.

![Screenshot](hue/resources/screenshots/HueFieldTypePreview.png)

* * *



### Working with Hue fields

When you access a Hue field in your templates, its value will either be `null` (if there is no color set), or a _ColorModel_.



### Using Hue without a field

You can create a Hue _ColorModel_ instance in your templates and work with it just like you would a Hue field. To create a Hue instance in your template, simply pass a color to the `craft.hue.createColorFromHex( '#ff80ff' )` method.

Here's an example to determine whether a hex color is light or dark:

```twig
	{% set hex = '#ff80ff' %}
	{% set hueColor = craft.hue.createColorFromHex(hex) %}
	<p>The color "{{ hex }}" is {{ hueColor.luma > 0.5 ? 'light' : 'dark') }}.</p>
```



### ColorModel properties

A _ColorModel_ has the following methods/properties:

##### `getHex()` / `.hex`

Returns the _string_ representation of the color in hexidecimal format, including the `#` at the beginning.

##### `getRgb()` / `.rgb`

Returns the _string_ representation of the color in RGB format, i.e. `"0,255,0"` for blue.

##### `getRed()` / `.red`

Returns the _numeric_ value of the red channel, from 0-255.

##### `getGreen()` / `.green`

Returns the _numeric_ value of the green channel, from 0-255.

##### `getBlue()` / `.blue`

Returns the _numeric_ value of the blue channel, from 0-255.

##### `luma()` / `.luma`

Returns the _numeric_ brightness of an image, from 0-1. Values closer to 0 are darker, closer to 1 are lighter.



### What are the system requirements?

Craft 2.5+ and PHP 5.4+



### I found a bug.

Please open a GitHub Issue, submit a PR to the `dev` branch, or just email me to let me know.


* * *

#### Contributors:

  - Plugin development: [Michael Rog](http://michaelrog.com) / @michaelrog
  - Plugin development: [Steve V](https://github.com/dubcanada) / @dubcanada
  - Plugin development: [Aaron Waldon](https://github.com/aaronwaldon) / @aaronwaldon
