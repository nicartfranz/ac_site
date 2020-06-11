'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

if (!window.fbControls) window.fbControls = new Array();
window.fbControls.push(function (controlClass) {

  var controlsliderQuestion = function (_controlClass) {
    _inherits(controlsliderQuestion, _controlClass);

    function controlsliderQuestion() {
      _classCallCheck(this, controlsliderQuestion);

      return _possibleConstructorReturn(this, (controlsliderQuestion.__proto__ || Object.getPrototypeOf(controlsliderQuestion)).apply(this, arguments));
    }

    _createClass(controlsliderQuestion, [{
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
        return this.markup('div', null, {id: this.config.name});
      }
    }, {
      key: 'onRender',
      value: function onRender() {
        var html_value = this.config.value || "\n\
  <div class='sliderTypeQuestion'>\n\
    <div>\n\
      Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book\n\
    </div>\n\
    <br>\n\
    <div class='sliderTypeQuestion_text' id='q_sl_1'><span>Neutral</span></div>\n\
    <br>\n\
    <div class='sliderTypeQuestion_choice' id='q_sl_1'>\n\
    <input type='range' class='custom-range' min='1' max='5' step='1' id='sliderTypeQuestion_range' name='q_sl_1'>\n\
  </div>";
        //remove the label
        $('.formbuilder-sliderQuestion-label').remove();
        $('div#' + this.config.name).html(html_value);  
      }
    }]);

    return controlsliderQuestion;
  }(controlClass);

  // register this control for the following types & text subtypes

  controlClass.register('sliderQuestion', controlsliderQuestion);
  return controlsliderQuestion;
});

