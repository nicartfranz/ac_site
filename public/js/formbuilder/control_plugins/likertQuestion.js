'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

if (!window.fbControls) window.fbControls = new Array();
window.fbControls.push(function (controlClass) {

  var controllikertQuestion = function (_controlClass) {
    _inherits(controllikertQuestion, _controlClass);

    function controllikertQuestion() {
      _classCallCheck(this, controllikertQuestion);

      return _possibleConstructorReturn(this, (controllikertQuestion.__proto__ || Object.getPrototypeOf(controllikertQuestion)).apply(this, arguments));
    }

    _createClass(controllikertQuestion, [{
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
        var html_value = this.config.value || "\
<table class='table table-striped likert'>\n\
<thead>\n\
    <!-- LIKERT QUESTION -->\n\
    <tr>\n\
        <th></th>\n\
        <th><center>Strongly Disagree</center></th>\n\
        <th><center>Disagree</center></th>\n\
        <th><center>Neutral</center></th>\n\
        <th><center>Agree</center></th>\n\
        <th><center>Strongly Agree</center></th>\n\
    </tr>\n\
</thead>\n\
<tbody>\n\
    <tr>\n\
        <td>Question</td>\n\
        <td><center><input type='radio' name='q_lk_1_1' value='1' "+required+"></center></td>\n\
        <td><center><input type='radio' name='q_lk_1_1' value='2' "+required+"></center></td>\n\
        <td><center><input type='radio' name='q_lk_1_1' value='3' "+required+"></center></td>\n\
        <td><center><input type='radio' name='q_lk_1_1' value='4' "+required+"></center></td>\n\
        <td><center><input type='radio' name='q_lk_1_1' value='5' "+required+"></center></td>\n\
    </tr>\n\
</tbody>\n\
</table>";
        var q_id = $('input[type="radio"]', html_value).attr('name');  
        //remove the label
        $('.formbuilder-likertQuestion-label').remove();
        $('div#' + this.config.name).html(html_value);  
        if(required == 'required'){
            $('input[name="'+q_id+'"]').attr({
                'required' : 'required',
                'oninvalid' : '$(this).parents("tbody").css("border-bottom", "2px solid red");',
            });
        }     
      }
    }]);

    return controllikertQuestion;
  }(controlClass);

  // register this control for the following types & text subtypes

  controlClass.register('likertQuestion', controllikertQuestion);
  return controllikertQuestion;
});

