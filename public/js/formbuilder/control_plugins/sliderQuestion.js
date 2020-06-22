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
        var question_type = this.config.question_type;
        var slider_options = this.config.slider_options;
        
        if(slider_options == '1'){
            var data_options_key = '1:2:3:4:5';
            var data_options_val = 'Strongly Disagree:Disagree:Neutral:Agree:Strongly Agree';
            var data_options_default = 'Neutral';
            var data_default_val = '3';
        } else if (slider_options == '2'){
            var data_options_key = '1:2:3:4:5:6:7';
            var data_options_val = 'Very Untrue of Me:Untrue of Me:Somewhat Untrue of Me:Neither True or Untrue:Somewhat True of Me:True of Me:Very True of Me';
            var data_options_default = 'Neither True or Untrue';
            var data_default_val = '4';
        } else {
            slider_options = '1';
            var data_options_key = '1:2:3:4:5';
            var data_options_val = 'Strongly Disagree:Disagree:Neutral:Agree:Strongly Agree';
            var data_options_default = 'Neutral';
            var data_default_val = '3';
        }
        var data_options_key_arr = data_options_key.split(':');
        
        var html_value = this.config.value || "\n\
  <div class='sliderTypeQuestion'>\n\
    <div>\n\
      Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book\n\
    </div>\n\
    <br>\n\
    <div class='sliderTypeQuestion_text' id='q_sl_1'><span>Neutral</span></div>\n\
    <br>\n\
    <div class='sliderTypeQuestion_choice' id='q_sl_1'>\n\
    <input type='range' class='custom-range' min='1' max='"+data_options_key_arr.length+"' step='1' id='sliderTypeQuestion_range' name='q_sl_1'>\n\
  </div>";
        //remove the label
        $('.formbuilder-sliderQuestion-label').remove();
        $('div#' + this.config.name).html(html_value); 
        $('div#'+this.config.name+ ' input#sliderTypeQuestion_range').attr('data-options-key', data_options_key);
        $('div#'+this.config.name+ ' input#sliderTypeQuestion_range').attr('data-options-val', data_options_val);
        $('div#'+this.config.name+ ' input#sliderTypeQuestion_range').attr('data-options-type', slider_options);
        $('div#'+this.config.name+ ' input#sliderTypeQuestion_range').attr('max', data_options_key_arr.length);
        $('div#'+this.config.name+ ' input#sliderTypeQuestion_range').attr('value', data_default_val);
        $('div#'+this.config.name+ ' .sliderTypeQuestion_text  > span').text(data_options_default);
      }
    }]);

    return controlsliderQuestion;
  }(controlClass);

  // register this control for the following types & text subtypes

  controlClass.register('sliderQuestion', controlsliderQuestion);
  return controlsliderQuestion;
});

