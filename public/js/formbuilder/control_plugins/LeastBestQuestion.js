'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

if (!window.fbControls) window.fbControls = new Array();
window.fbControls.push(function (controlClass) {

  var controlLeastBestQuestion = function (_controlClass) {
    _inherits(controlLeastBestQuestion, _controlClass);

    function controlLeastBestQuestion() {
      _classCallCheck(this, controlLeastBestQuestion);

      return _possibleConstructorReturn(this, (controlLeastBestQuestion.__proto__ || Object.getPrototypeOf(controlLeastBestQuestion)).apply(this, arguments));
    }

    _createClass(controlLeastBestQuestion, [{
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
        var html_value = this.config.value || "\n\
<p>Least - Best Question (PCA)</p>\n\
<div class='least-best-div' id='q1'>\n\
  <div class='least-best-checkbox'>\n\
    CHOICE 1\n\
    <input type='checkbox' name='q1[]' value='1' "+required+">\n\
  </div>\n\
  <div class='least-best-checkbox'>\n\
    CHOICE 2\n\
    <input type='checkbox' name='q1[]' value='2' "+required+">\n\
  </div>\n\
  <div class='least-best-checkbox'>\n\
    CHOICE 3\n\
    <input type='checkbox' name='q1[]' value='3' "+required+">\n\
  </div>\n\
  <div class='least-best-checkbox'>\n\
    CHOICE 4\n\
    <input type='checkbox' name='q1[]' value='4' "+required+">\n\
  </div>\n\
</div>";
        var q_id = $('input[type="checkbox"]', html_value).attr('name');   
        //remove the label
        $('.formbuilder-LeastBestQuestion-label').remove();
        $('div#' + this.config.name).html(html_value); 
        if(required == 'required'){
            $('input[name="'+q_id+'"]').attr({
                'required' : 'required',
                'oninvalid' : '$(this).parent().css("border", "1px solid red");',
            });
        } 
      }
    }]);

    return controlLeastBestQuestion;
  }(controlClass);

  // register this control for the following types & text subtypes

  controlClass.register('LeastBestQuestion', controlLeastBestQuestion);
  return controlLeastBestQuestion;
});



