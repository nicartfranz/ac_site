'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

if (!window.fbControls) window.fbControls = new Array();
window.fbControls.push(function (controlClass) {

  var controlrankingQuestion = function (_controlClass) {
    _inherits(controlrankingQuestion, _controlClass);

    function controlrankingQuestion() {
      _classCallCheck(this, controlrankingQuestion);

      return _possibleConstructorReturn(this, (controlrankingQuestion.__proto__ || Object.getPrototypeOf(controlrankingQuestion)).apply(this, arguments));
    }

    _createClass(controlrankingQuestion, [{
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
          
        //console.log(JSON.stringify(this.config)); 
        var rn_question = this.config.rn_question;
        var required = this.config.required;
          
        var html_value = this.config.value || "\n\
<div class='container-fluid'>\n\
    <div class='row ranking-question'>\n\
        <div class='col-sm ranking-question-box-left' id='q1'>\n\
            <p>Which is most like you?<input type='hidden' id='q1_1' name='q1_1'></p>\n\
            <p>Which is least like you?<input type='hidden' id='q1_2' name='q1_2'></p>\n\
            <p>Of the remaining two, which is more like you?<input type='hidden' id='q1_3' name='q1_3'></p>\n\
        </div>\n\
        <div class='col-sm ranking-question-box-right'>\n\
        <div class='row ranking-choice-box' id='q1'>\n\
            <div class='col-xs ranking-choice c1_1'>Playful</div>\n\
            <div class='col-xs ranking-choice c1_2'>Strong-willed</div>\n\
            <div class='col-xs ranking-choice c1_3'>Intellectual</div>\n\
            <div class='col-xs ranking-choice c1_4'>Cooperative</div>\n\
        </div>\n\
        <br>\n\
        <p><b>Playful</b> - I am full of fun and good humor.</p>\n\
        <p><b>Strong-willed</b> - I am determined to have my way.</p>\n\
        <p><b>Intellectual</b> - I am intelligent or knowledgeable; I am an academic.</p>\n\
        <p><b>Cooperative</b> - I am obliging, helpful, and supportive.</p>\n\
    </div>\n\
</div>";
          
        var q_id = $('div.ranking-question-box-left', html_value).attr('id');
        var id = q_id.substring(1, q_id.length);
        //console.log(q_id + ' ' + id);
          
        var invisible_input_css = 'cursor:default;width:0px;height:0px;background:transparent;border:transparent;';
//         if(rn_question == '1'){
//
//            var ranking_question_html = "\
//<p>Which is most like you?<input type='text' style='"+invisible_input_css+"' id='q"+id+"_1' name='q"+id+"_1' "+required+" autocomplete='off' oninvalid='alert(\"Missing response on item "+id+".1\");'></p>\n\
//<p>Which is least like you?<input type='text' style='"+invisible_input_css+"' id='q"+id+"_2' name='q"+id+"_2' "+required+" autocomplete='off' oninvalid='alert(\"Missing response on item "+id+".2\");'></p>\n\
//<p>Of the remaining two, which is more like you?<input type='text' style='"+invisible_input_css+"' id='q"+id+"_3' name='q"+id+"_3' "+required+" autocomplete='off' oninvalid='alert(\"Missing response on item "+id+".3\");'></p>";
//             
//        } else if (rn_question == '2'){
//            
//            var ranking_question_html = "\
//<p>1-Least like you<input type='text' style='"+invisible_input_css+"' id='q"+id+"_1' name='q"+id+"_1' "+required+" autocomplete='off' oninvalid='alert(\"Missing response on item "+id+".1\");'></p>\n\
//<p>2-Next Least like you<input type='text' style='"+invisible_input_css+"' id='q"+id+"_2' name='q"+id+"_2' "+required+" autocomplete='off' oninvalid='alert(\"Missing response on item "+id+".2\");'></p>\n\
//<p>3-Next Most like you<input type='text' style='"+invisible_input_css+"' id='"+id+"_3' name='q"+id+"_3' "+required+" autocomplete='off' oninvalid='alert(\"Missing response on item "+id+".3\");'></p>\n\
//<p>4-Most like you<input type='text' style='"+invisible_input_css+"' id='"+id+"_4' name='q"+id+"_4' "+required+" autocomplete='off' oninvalid='alert(\"Missing response on item "+id+".4\");'></p>";
//
//        } else {
            
            var ranking_question_html = "\
<p>Which is most like you?<input onfocus='blur();' type='text' style='"+invisible_input_css+"' id='q"+id+"_1' name='q"+id+"_1' "+required+" autocomplete='off' oninvalid='validateRankingQuestion(this, \"Missing response on item "+id+".1\");'></p>\n\
<p>Which is least like you?<input onfocus='blur();' type='text' style='"+invisible_input_css+"' id='q"+id+"_2' name='q"+id+"_2' "+required+" autocomplete='off' oninvalid='validateRankingQuestion(this, \"Missing response on item "+id+".2\");'></p>\n\
<p>Of the remaining two, which is more like you?<input onfocus='blur();' type='text' style='"+invisible_input_css+"' id='q"+id+"_3' name='q"+id+"_3' "+required+" autocomplete='off' oninvalid='validateRankingQuestion(this, \"Missing response on item "+id+".3\");'></p>";
              
//        }  
          
        //remove the label
        $('.formbuilder-rankingQuestion-label').remove();
        $('div#' + this.config.name).html(html_value);
        $('div.ranking-question-box-left#q'+id).empty();
        $('div.ranking-question-box-left#q'+id).html(ranking_question_html);
      }
    }]);

    return controlrankingQuestion;
  }(controlClass);

  // register this control for the following types & text subtypes

  controlClass.register('rankingQuestion', controlrankingQuestion);
  return controlrankingQuestion;
});

