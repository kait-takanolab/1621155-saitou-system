


var qword = ["zero","hi", "pen","think","bard","bike","hope","man","woman"]
var qindex = 1;

window.SpeechRecognition = window.SpeechRecognition || webkitSpeechRecognition;
var recognition = new webkitSpeechRecognition();
recognition.lang = 'en-US';

// 録音終了時トリガー
recognition.addEventListener('result', function(event){
    var text = event.results.item(0).item(0).transcript;
    console.log(text);
    $("#output").html(text);
    if(text!=qword[qindex]){
        $("#result").append('<i class="fa fa-circle-o">Correct</i>');
    }else{
        $("#result").append('<i class="fa fa-close">Incorrect</i>');
    }
}, false);

// 録音開始
function record(){
    recognition.start();
}
// $(document).ready(function() {
//   $("#next").click(function() {
//     // $("#result").html('<i class="fa fa-close is-large">Incorrect</i>');
//      console.log(qindex);
//      $('#word').html('Question' + qindex + " : "+ qword[qindex] + '');
//      qindex++;
//   });
// });
