///**
// * SliderTemplate class - show slider 0 - 5 step by 1
// */
//
//// configure the class for runtime loading
//if (!window.fbControls) window.fbControls = [];
//window.fbControls.push(function(controlClass) {
//  /**
//   * Star rating class
//   */
//  class controlSliderTemplate extends controlClass {
//
//    /**
//     * Class configuration - return the icons & label related to this control
//     * @returndefinition object
//     */
//    static get definition() {
//      return {
//        icon: '',
//        i18n: {
//          default: 'Slider Template'
//        }
//      };
//    }
//
//    /**
//     * javascript & css to load
//     */
//    configure() {
//      this.js = '';
//      this.css = '';
//    }
//
//    /**
//     * build a text DOM element, supporting other jquery text form-control's
//     * @return {Object} DOM Element to be injected into the form.
//     */
//    build() {
//      return this.markup('input', null, {id: this.config.name});
//    }
//
//    /**
//     * onRender callback
//     */
//    onRender() {
//      const value = this.config.value || 0;
//      $('input#' + this.config.name).attr({
//          type:'range',
//          class:'custom-range',
//          min:0,
//          max:5,
//          value:value,
//      });
//    }
//  }
//
//  // register this control for the following types & text subtypes
//  controlClass.register('sliderTemplate', controlSliderTemplate);
//  return controlSliderTemplate;
//});


'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

if (!window.fbControls) window.fbControls = new Array();
window.fbControls.push(function (controlClass) {

  var controlSliderTemplate = function (_controlClass) {
    _inherits(controlSliderTemplate, _controlClass);

    function controlSliderTemplate() {
      _classCallCheck(this, controlSliderTemplate);

      return _possibleConstructorReturn(this, (controlSliderTemplate.__proto__ || Object.getPrototypeOf(controlSliderTemplate)).apply(this, arguments));
    }

    _createClass(controlSliderTemplate, [{
      key: 'configure',
      value: function configure() {
        this.js = '';
        this.css = '';
      }

      /**
       * build a text DOM element, supporting other jquery text form-control's
       * @return DOM Element to be injected into the form.
       */

    }, {
      key: 'build',
      value: function build() {
        return this.markup('input', null, {id: this.config.name});
      }
    }, {
      key: 'onRender',
      value: function onRender() {
        const value = this.config.value || 0;
        $('input#' + this.config.name).attr({
            type:'range',
            class:'custom-range',
            min:0,
            max:5,
            value:value,
        });
      }
    }]);

    return controlSliderTemplate;
  }(controlClass);

  // register this control for the following types & text subtypes

  controlClass.register('sliderTemplate', controlSliderTemplate);
  return controlSliderTemplate;
});

