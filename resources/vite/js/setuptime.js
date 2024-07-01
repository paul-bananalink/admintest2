/**
check for support and then add class to not style
color input for unsupported browsers
*/
(function() {
    var color = document.querySelector('[type="color"]');
    var i = document.createElement('input');
    i.setAttribute('type', 'color');

    if (i.type === 'text') {
        color.classList.add('unsupported')
    }
})();

(function() {
    var color = document.querySelector('[type="week"]');
    var i = document.createElement('input');
    i.setAttribute('type', 'week');

    if (i.type === 'text') {
        color.classList.add('unsupported')
    }
})();

/**
A quick list of what's exposed to Webkit:

Hook to style the file upload button
::-webkit-file-upload-button


Hook to style the Color swatch wrapper
::-webkit-color-swatch-wrapper
::-webkit-color-swatch


Number and Search input inner wrappers
::-webkit-textfield-decoration-container


Range
::-webkit-slider-runnable-track
::-webkit-slider-thumb


Dates and times
::-webkit-datetime-edit
::-webkit-datetime-edit-fields-wrapper
::-webkit-datetime-edit-month-field
::-webkit-datetime-edit-day-field
::-webkit-datetime-edit-text
::-webkit-datetime-edit-year-field
::-webkit-datetime-edit-week-field
::-webkit-datetime-edit-ampm-field
::-webkit-datetime-edit-minute-field


Inner input buttons:
Calendar popup buttons
::-webkit-calendar-picker-indicator

clear buttons
::-webkit-clear-button

spinner buttons
::-webkit-inner-spin-button


And here's Firefox's User Agent stylesheet for forms.
You must be view this in Firefox:
resource://gre-resources/forms.css

Here are the major selectors of note:
::-moz-color-swatch

input[type=range]::-moz-range-track 
    input[type=range][orient=block]::-moz-range-track 
    input[type=range][orient=horizontal]::-moz-range-track 
    input[type=range][orient=vertical]::-moz-range-track
input[type=range]::-moz-range-progress 
input[type=range]::-moz-range-thumb 


::-moz-meter-bar
    :-moz-meter-optimum::-moz-meter-bar
    :-moz-meter-sub-optimum::-moz-meter-bar
    :-moz-meter-sub-sub-optimum::-moz-meter-bar
::-moz-progress-bar

input::placeholder,
textarea::placeholder
  
input[type="color"]:-moz-focusring::-moz-focus-inner,
input[type=range]::-moz-focus-outer 
  
// can't appear to style
input[type=number]::-moz-number-wrapper
input[type=number]::-moz-number-text
input[type=number]::-moz-number-spin-box
input[type=number]::-moz-number-spin-up
input[type=number]::-moz-number-spin-down

*/



/*
  -ms- specific

::-ms-browse - file upload browse button
::-ms-clear  - text field
::-ms-reveal - password
::-ms-check  - checkboxes and radios

::-ms-expand - selects

::-ms-fill - progress

range slider
::-ms-fill-upper
::-ms-fill-lower 
::-ms-thumb
::-ms-ticks-after
::-ms-ticks-before
::-ms-track
::-ms-tooltip   -- only display and visibility
::-ms-value

*/




(function(w, doc, undefined) {
    'use strict';
    var A11yToggleButton;

    A11yToggleButton = function() {
        /**
         * Author: Scott O'Hara
         * Version: 0.1.0
         * License: https://github.com/scottaohara/a11y_styled_form_controls/blob/master/LICENSE
         */
        var el;

        /**
         * Initialize the instance, run all setup functions
         * and attach the necessary events.
         */
        this.init = function(elm) {
            el = elm;
            checkState(el);
            setPressed(el);
            setButton(el);
            setClasses(el);
            setSwitchUI(el);
            attachEvents(el);
        };

        /**
         * Check default state of element:
         * A toggle button is not particularly useful without JavaScript,
         * so ideally such a button would be set to hidden or disabled, if JS wasn't
         * around to make it function.
         */
        var checkState = function(el) {
            // Unless a toggle button is specifically meant to be disabled,
            // when JS is available, remove the disabled attribute so these
            // buttons can be used.
            if (el.getAttribute('data-toggle-btn') !== "disabled") {
                el.removeAttribute('disabled');
            }

            // reveal any hidden instances
            el.removeAttribute('hidden');
        };

        /**
         * A toggle button won't register as a toggle button if an aria-pressed
         * isn't present prior to user interaction.
         *
         * e.g. a button that is pressed, and then acquires an aria-pressed='true'
         * attribute will NOT always be announced as a toggle button.
         *
         * Check for the presence of aria-pressed and if not there, run additional
         * checks to determine if this button should be set to true or false by default.
         */
        var setPressed = function(el) {
            if (!el.hasAttribute('aria-pressed')) {
                el.setAttribute('aria-pressed', el.hasAttribute('data-toggle-btn-pressed'))
            }
        }

        /**
         * Enhance elements to buttons
         * If the element is not a button, then add a role button.
         * If it is not an a[href], or already have a tabindex, then
         * provide a tabindex=0 so it can be keyboard focusable.
         */
        var setButton = function(el) {
            if (el.tagName !== 'BUTTON') {
                el.setAttribute('role', 'button');

                if (!el.hasAttribute('href') && !el.hasAttribute('disabled')) {
                    el.tabIndex = 0;
                }
            }
        }

        /**
         * Create Switch UI
         * If a button is missing an inner element to
         * wrap the accessible name and serve as the
         * basis for the switch UI, then create a span
         * and append it to the button element.
         */
        var setSwitchUI = function(el) {
            var switchUI = el.querySelector('[data-toggle-btn-ui]') || el.querySelector('.toggle-switch__ui');

            if (!switchUI) {
                var newUI = doc.createElement('span');
                el.appendChild(newUI);
                switchUI = el.querySelector('span');
            }

            if (!switchUI.classList.contains('toggle-switch__ui')) {
                switchUI.classList.add('toggle-switch__ui');
            }

            // after confirming a switchUI element exists:
            switchUI.setAttribute('aria-hidden', 'true');
        };

        /**
         * Setup the classes for the toggle buttons
         */
        var setClasses = function(el) {
            // if the default class for this component doesn't exist, add it
            if (!el.classList.contains('toggle-switch')) {
                el.classList.add('toggle-switch');
            }

            // if a switch ui should display the text 'on' and 'off'
            if (el.hasAttribute('data-switch-btn-labels') || el.classList.contains('toggle-switch--labels')) {
                el.classList.add('toggle-switch--labels');
            };
        }

        /**
         * Toggle the Button's state (aria-pressed=t/f)
         */
        var toggleState = function(e) {
            this.setAttribute('aria-pressed', this.getAttribute('aria-pressed') === 'true' ? 'false' : 'true');
        };

        /**
         * Attach keyEvents to toggle buttons
         */
        var keyEvents = function(e) {
            var keyCode = e.keyCode || e.which;

            /**
             * If the element is not a real button, then
             * map the appropriate key commands.  If it is,
             * well buttons' already know how to do this then :)
             */
            if (e.target.tagName !== 'BUTTON') {
                switch (keyCode) {
                    case 32:
                    case 13:
                        e.stopPropagation();
                        e.preventDefault();
                        e.target.click();
                        break;

                    default:
                        break;
                }
            }
        };

        /**
         * Events for toggle buttons
         */
        var attachEvents = function(el) {
            el.addEventListener('click', toggleState, false);
            el.addEventListener('keypress', keyEvents, false);
        };

        return this;
    }; // A11yToggleButton()

    w.A11yToggleButton = A11yToggleButton;
})(window, document);