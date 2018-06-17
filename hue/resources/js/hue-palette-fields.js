/**
 * Highly inspired by Button Box (MIT License)
 * https://github.com/supercool/buttonbox/blob/master/LICENSE.md
 *
 * @author Aaron Waldon <aaron@causingeffect.com
 * @copyright Copyright (c) 2018, Aaron Waldon
 * @license   MIT
 */
(function($) {
    /**
     * HueColorPalette Class
     */
    Craft.HueColorPalette = Garnish.Base.extend({
        $select: null,
        $menu: null,
        $btn: null,

        init: function(id) {
            var $elem = $('#'+id);
            this.$select = $elem.find('select');
            this.$btn = $elem.find('button');

            var menuBtn = new Garnish.MenuBtn(this.$btn, {
                onOptionSelect: $.proxy(this, 'menuOptionSelected')
            });
            this.$menu = menuBtn.menu.$container;
        },

        /**
         * Called when a menu option is selected.
         *
         * @param option The selected menu option.
         */
        menuOptionSelected: function(option) {
            var $option = $(option);
            if (!$option.hasClass('disabled')) {
                //remove sel class from previous, if applicable
                this.$menu.find('.sel').removeClass('sel');

                //add the menu sel class
                $option.addClass('sel');

                //select the select item
                this.$select.val($option.data('value'));

                //update the button appearance
                this.updateButtonAppearance();
            }
        },

        /**
         * Updates the menu button's appearance.
         */
        updateButtonAppearance: function() {
            //find the selected option
            var $option = this.$select.find(':selected');

            //the default text
            var buttonHtml = 'Pick a color';

            if ($option.length) {
                //the new text
                var isDisabled = $option.prop('disabled');
                buttonHtml = '<span class="huePaletteColors-color'+(isDisabled?' disabled': '')+'" style="background-color: '+$option.data('hex')+'"></span><span class="huePaletteColors-label'+(isDisabled?' disabled':'')+'">'+$option.text()+'</span>';
            }

           //update the button text
            this.$btn.html(buttonHtml);
        }
    });
})(jQuery);
