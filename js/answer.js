const request = window.superagent;
let qword = ["title"]
let text=[];
let vm = new Vue({
  el: '#rec',
  data: {
      Question: "",
      result: true,
      correct: false,
      incorrect: false,
      output:" ",
      isButtonDisabled: true,
      index: 0,
      recwait: false,
      wait: "",
  },
  computed: {
    now_question: function () {
      return this.Question;
    },
    question_index: function () {
      if(this.index==0){
          return 'Question is displayed here';
      }else{
        return 'Question' + this.index;
      }
    }
  },
  methods: {
    nextbutton: function () {
      console.log(qword.length);
      if(this.index+1<qword.length){
        this.index++;
        this.correct = false;
        this.incorrect = false;
        this.output=" ";
        this.Question = qword[this.index];
        console.log(this.index);
      }
    },
    ansbutton: function (){
       console.log(this.index);
       let msg = new SpeechSynthesisUtterance();
       msg.text = qword[this.index];
       msg.lang = 'en-US';
       msg.rate = 0.5;
       speechSynthesis.speak(msg);
    },
    recbutton: function (){
       recognition.start();
       this.recwait = true;
       console.log("recording");
       this.wait= "Recording now";
    },
  },
})

let vm3 = new Vue({
  el: '#get_selection',
  data: {
      link:"",
      res:" ",
      generate: "URL",
  },
  methods: {
    get_question : function () {
      request
        .get("./php/pdo.php/selection")
        .end((err,res) => {
          let jsons =JSON.parse(res.text);
          for(let j of jsons){
           qword.push(j);
           cosole.log(j);
         }
          vm.isButtonDisabled=false;
        });
    }
  }
})



window.SpeechRecognition = window.SpeechRecognition || webkitSpeechRecognition;
let recognition = new webkitSpeechRecognition();
recognition.lang = 'en-US';

recognition.addEventListener('result', function(event){
    text[vm.index]= event.results.item(0).item(0).transcript;

    console.log(text[vm.index]);
    vm.output = text[vm.index];
    vm.recwait = false

    let regexpa =/[^a-zA-Z0-9|| ]/g
    // let regexpa = /[?!.()]/g;
    let q = qword[vm.index].replace(regexpa,"");
    console.log(q);

    if(text[vm.index].toLowerCase() === q.toLowerCase()){
      vm.result = false;
      vm.correct = true;
    }else{
      vm.result =  false;
      vm.incorrect = true;
    }
}, false);
