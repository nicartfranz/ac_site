'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

if (!window.fbControls) window.fbControls = new Array();
window.fbControls.push(function (controlClass) {

  var controlstartPageMarker = function (_controlClass) {
    _inherits(controlstartPageMarker, _controlClass);

    function controlstartPageMarker() {
      _classCallCheck(this, controlstartPageMarker);

      return _possibleConstructorReturn(this, (controlstartPageMarker.__proto__ || Object.getPrototypeOf(controlstartPageMarker)).apply(this, arguments));
    }

    _createClass(controlstartPageMarker, [{
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
        //{"enableSnapshot":"true","id":"startPageMarker-1591886614471"}
        var isRandomized = (this.config.randomize == 'true') ? '<span>Randomize: True</span>' : '<span>Randomize: False</span>';
        var hasTimer = (this.config.setTimer >= 0) ? '<span>Set Time: '+this.config.setTimer+' minute(s)</span>' : '<span>Set Time: None</span>';
        var codeOnTimerTimesUp = (this.config.onTimerTimesUp != '') ? '<span>Run JS, On timer times up: '+this.config.onTimerTimesUp+' </span>' : '<span>Run JS, On timer times up: None</span>';
        var isEnableSnapshot = (this.config.enableSnapshot == 'true') ? '<span>Enable Snapshot: True</span>' : '<span>Enable Snapshot: False</span>';
        var html_value = this.config.value || '<div class="startpage-marker bg-primary text-white">\n\
<span>NEW PAGE</span><br>\n\
'+isRandomized+'<br>\n\
'+hasTimer+'<br>\n\
'+codeOnTimerTimesUp+'<br>\n\
'+isEnableSnapshot+'<br>\n\
</div>';
        //remove the label
        $('.formbuilder-startPageMarker-label').remove();
        $('div#' + this.config.name).html(html_value);
        console.log(JSON.stringify(this.config));
      }
    }]);

    return controlstartPageMarker;
  }(controlClass);

  // register this control for the following types & text subtypes

  controlClass.register('startPageMarker', controlstartPageMarker);
  return controlstartPageMarker;
});

