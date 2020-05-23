/**
 * SliderTemplate class - show slider 0 - 5 step by 1
 */

// configure the class for runtime loading
if (!window.fbControls) window.fbControls = [];
window.fbControls.push(function(controlClass) {
  /**
   * Star rating class
   */
  class controlcustomHTMLTemplate extends controlClass {

    /**
     * Class configuration - return the icons & label related to this control
     * @returndefinition object
     */
    static get definition() {
      return {
        icon: '',
        i18n: {
            default: 'Custom HTML Template',
//            type: 'textarea',
//            subtype: 'textarea',
        },
//        type: 'textarea',
//        subtype: 'textarea',
      };
    }

    /**
     * javascript & css to load
     */
    configure() {
      this.js = '';
      this.css = '';
    }

    /**
     * build a text DOM element, supporting other jquery text form-control's
     * @return {Object} DOM Element to be injected into the form.
     */
    build() {
      return this.markup('div', null, {id: this.config.name});
    }

    /**
     * onRender callback
     */
    onRender() {
        const html_value = this.config.value || '';
        //remove the label
        $('.formbuilder-customHTMLTemplate-label').remove();
        $('div#' + this.config.name).html(html_value);
    }
  }

  // register this control for the following types & text subtypes
  controlClass.register('customHTMLTemplate', controlcustomHTMLTemplate);
  return controlcustomHTMLTemplate;
});
