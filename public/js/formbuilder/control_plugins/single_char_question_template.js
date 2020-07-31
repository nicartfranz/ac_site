'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

if (!window.fbControls) window.fbControls = new Array();
window.fbControls.push(function (controlClass) {

  var controlsingle_char_question_template = function (_controlClass) {
    _inherits(controlsingle_char_question_template, _controlClass);

    function controlsingle_char_question_template() {
      _classCallCheck(this, controlsingle_char_question_template);

      return _possibleConstructorReturn(this, (controlsingle_char_question_template.__proto__ || Object.getPrototypeOf(controlsingle_char_question_template)).apply(this, arguments));
    }

    _createClass(controlsingle_char_question_template, [{
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
          
        var required = this.config.required;
        var html_value = this.config.value;
          
        //remove the label
        $('.formbuilder-single_char_question_template-label').remove();
        $('div#' + this.config.name).html(html_value);
        if(required == 'required'){
            $('div#' + this.config.name + ' input').attr({
                'required' : 'required',
            });
        }          
      }
    }]);

    return controlsingle_char_question_template;
  }(controlClass);

  // register this control for the following types & text subtypes

  controlClass.register('single_char_question_template', controlsingle_char_question_template);
  return controlsingle_char_question_template;
});

