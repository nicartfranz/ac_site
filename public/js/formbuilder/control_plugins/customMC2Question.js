'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

if (!window.fbControls) window.fbControls = new Array();
window.fbControls.push(function (controlClass) {

  var controlcustomMC2Question = function (_controlClass) {
    _inherits(controlcustomMC2Question, _controlClass);

    function controlcustomMC2Question() {
      _classCallCheck(this, controlcustomMC2Question);

      return _possibleConstructorReturn(this, (controlcustomMC2Question.__proto__ || Object.getPrototypeOf(controlcustomMC2Question)).apply(this, arguments));
    }

    _createClass(controlcustomMC2Question, [{
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
          
        var q_id = $('input.custom_mc_checkbox', html_value).attr('name');
        var split_id = q_id.split('[')[0];
              
        //remove the label
        $('.formbuilder-customMC2Question-label').remove();
        $('div#' + this.config.name).html(html_value);
        if(required == 'required'){
            $('input[name="'+q_id+'"]').attr({
                'required' : 'required',
                'oninvalid' : 'validateCustomMCQuestion(this, \"Missing response on item '+q_id+'\")',
            });
            $('label.custom_mc_container.'+split_id).addClass('answer_required');
        }          
      }
    }]);

    return controlcustomMC2Question;
  }(controlClass);

  // register this control for the following types & text subtypes

  controlClass.register('customMC2Question', controlcustomMC2Question);
  return controlcustomMC2Question;
});

