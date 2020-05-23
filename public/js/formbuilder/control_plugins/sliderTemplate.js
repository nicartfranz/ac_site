/**
 * SliderTemplate class - show slider 0 - 5 step by 1
 */

// configure the class for runtime loading
if (!window.fbControls) window.fbControls = [];
window.fbControls.push(function(controlClass) {
  /**
   * Star rating class
   */
  class controlSliderTemplate extends controlClass {

    /**
     * Class configuration - return the icons & label related to this control
     * @returndefinition object
     */
    static get definition() {
      return {
        icon: '',
        i18n: {
          default: 'Slider Template'
        }
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
      return this.markup('input', null, {id: this.config.name});
    }

    /**
     * onRender callback
     */
    onRender() {
      const value = this.config.value || 0;
      $('input#' + this.config.name).attr({
          type:'range',
          class:'custom-range',
          min:0,
          max:5,
          value:value,
      });
    }
  }

  // register this control for the following types & text subtypes
  controlClass.register('sliderTemplate', controlSliderTemplate);
  return controlSliderTemplate;
});
