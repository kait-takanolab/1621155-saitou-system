
const request = window.superagent;
// 'use strict';
// import {pluralize} from 'https://cdnjs.cloudflare.com/ajax/libs/pluralize/7.0.0/pluralize.min.js'
// pluralize = pluralize();
var script = document.createElement("script");
script.type = "text/javascript";
script.src = "js/pluralize.js";
let qword = ["title"];
let text = [];
let results = [];
let report = {};
let load_question;
let mode_id = 1;
let Question_word=""
let wav_filename=""
document.write(
  "<script type='text/javascript' src='js/pluralize.js'></script>"
);

// let sign_in = new Vue({
//   el: "#sign",
//   data: {
//     name: " "
//   },
//   methods: {
//     send_name: function() {
//       const s = this.name;
//       request
//         .post("./php/pdo.php/name")
//         .type("form")
//         .send({ s: s })
//         .end((err, res) => {
//           // console.log(res.text);
//         });
//       // location.href = 'index.html';
//     }
//   }
// });
// setIntervalを使う方法
function sleep(waitSec, callbackFunc) {
 
  // 経過時間（秒）
  var spanedSec = 0;

  // 1秒間隔で無名関数を実行
  var id = setInterval(function () {

      spanedSec++;

      // 経過時間 >= 待機時間の場合、待機終了。
      if (spanedSec >= waitSec) {

          // タイマー停止
          clearInterval(id);

          // 完了時、コールバック関数を実行
          if (callbackFunc) callbackFunc();
      }
  }, 1000);

}

function getUrlquery() {
  var query = [],
    max = 0,
    hash = "",
    array = "";
  var url = window.location.search;
  hash = url.slice(1).split("&");
  max = hash.length;
  for (var i = 0; i < max; i++) {
    array = hash[i].split("=");
    query.push(array[0]);
    query[array[0]] = array[1];
  }
  console.log(query);
  return query;
}

let vm = new Vue({
  el: "#rec",
  data: {
    Question: "",
    result: true,
    not_start:true,
    not_error:false,
    recognition_error:false,
    // recording:false,
    correct: false,
    incorrect: false,
    output: " ",
    isButtonDisabled: true,
    isFinButtonDisabled: true,
    isButtonDisabled2: true,
    index: 0,
    recwait: false,
    wait: "",
    //超STATIC 問題数増えたら変更して
    questionCount:1125,
    Chozen_questionNumber: 1


  },
  computed: {
    /*send_result: function() {
      let cnt = 0;
      let report = results;
      for(let r of report){
        request
          .post("../php/received.php")
          .type('form')
          .send({r: r})
          .end((err,res) => {
            console.log(res.text);
          });
      }
    },*/
    cantnumber() {
      return this.questionCount;
    },
    now_question: function() {
      return this.Question;
    },
    question_index: function() {
      if (this.index == 0) {
        return "Question is displayed here";
      } else {
        return "Question" + this.index;
      }
    }
  },

  methods: {
    nextbutton: function() {
      console.log(qword.length);
      console.log(qword);
      vm.not_start=true
      vm.not_error=false
      vm.recognition_error=false
      if (this.index > 10000) {
        this.isButtonDisabled = true;
        this.isFinButtonDisabled = false;
      }
      if (this.index + 1 < qword.length) {
        this.index++;
        this.correct = false;
        this.incorrect = false;
        this.output = " ";
        this.Question = qword[this.index];
        console.log(this.index);
      }
    },
    backbutton: function() {
      console.log(qword.length);
      console.log(qword);
      vm.not_start=true
      vm.not_error=false
      vm.recognition_error=false
      if (this.index > 10000) {
        this.isButtonDisabled = true;
        this.isFinButtonDisabled = false;
      }
      if (this.index - 1 > 0) {
        this.index--;
        this.correct = false;
        this.incorrect = false;
        this.output = " ";
        this.Question = qword[this.index];
        console.log(this.index);
      }
    },

      ansbutton: function() {
      console.log(this.index);
      let msg = new SpeechSynthesisUtterance();
      msg.text = qword[this.index];
      msg.lang = "en-US";
      msg.rate = 0.5;
      speechSynthesis.speak(msg);
    },
    recbutton: function() {
      recognition.start();
      this.recwait = true;
      console.log("recording");
      this.wait = "Recording now";
      console.log("Send wav filename")
      Question_word=this.Question
      console.log(Question_word)
      navigator.mediaDevices.getUserMedia({ audio: true, video: false })
    .then(handleSuccess);
      
    },

    chozen_question_button: function(){

      vm.not_start=true
      vm.not_error=false
      vm.recognition_error=false

      if (this.index > 10000) {
        this.isButtonDisabled = true;
        this.isFinButtonDisabled = false;
      }
      this.Chozen_questionNumber=Number(this.Chozen_questionNumber)
      if (this.Chozen_questionNumber < this.questionCount) {
        this.index=this.Chozen_questionNumber;
        this.correct = false;
        this.incorrect = false;
        this.output = " ";
        this.Question = qword[this.index];
        console.log(this.index);
      }


    }
    // get_question: function() {
    //   this.isButtonDisabled = false;
    //   this.isButtonDisabled2 = false;
    // }
    /*send_result: function() {
      let cnt = 0;
      let report = results;
      for(let r of report){
        request
          .post("../php/received.php")
          .type('form')
          .send({r: r})
          .end((err,res) => {
            console.log(res.text);
          });
      }
    }*/
  }
});
let vm2 = new Vue({
  el: "#word",
  data: {
    link: "",
    res: " ",
    generate: "URL",
    doc_text: ""
  },

  methods: {
    getText: function() {
      // const query = getUrlquery();
      // console.log(query);
      // console.log(qword);
      // if (query[0] != "") {
      //   for (let q of query) {
      //     qword.push(q);
      //   }
      // }
      // console.log(qword);
      // console.log("hi");
      // const period = ".";
      // const leader = "…";
      // const space = " ";
      // let text = this.doc_text.replace("  ");
      // const sentence = text.split(period);
      // for (let s of sentence) {
      //   let regexpa = /[^a-zA-Z0-9|| ]/g;
      //   // if(s.length>=20){
      //   s = s.replace(regexpa, "");
      //   console.log(qword);
      //   console.log(s);
      //   if (s != "") {
      //     qword.push(s);
      //   }
      //   console.log(qword);
      //   // }
      // }
      //DBから問題を取得
      var formdata = new FormData();
      formdata.append("user_id",user_id)

      $.ajax({
        url: "./api/get_question.php",
        type: "POST",
        data: formdata,
        cache: false,
        contentType: false,
        processData: false
      }).done(data => {
        console.log(data);
        count=0;
        for(s of data){
          count=count+1
          console.log(s["word"])
          qword.push(s["word"]);
        }
        console.log(qword)
        console.log(count)
        this.questionCount=count
      });

      vm.isButtonDisabled = false;
      vm.isButtonDisabled2 = false;
    },
    // load_question: function() {
    //   $.ajax({
    //     url: "./api/load_question.php",
    //     type: "POST",
    //     processData: false,
    //     data: { user_name: user_name }
    //   }).done(data => {
    //     console.log(data);
    //     let question = data["word"];

    //     console.log(question);
    //     let ary = question.split(",");
    //     console.log(ary);
    //     for (let s in ary) {
    //       qword.push(ary[s]);
    //     }
    //     console.log(qword);
    //   });
    //   //incorrect_wordをロード下ので、モードを変更
    //   mode_id = 2;
    // },
    gethtml: function() {
      $("#container").load("http://google.com");
      $.ajax({
        url: this.link,
        type: "GET",
        cache: false,
        success: function(res) {
          console.log(res);
          let toString = Object.prototype.toString;
          let content = $(res.responseText)
            .text()
            .split("\n");
          for (let v of content) {
            const substring = "<h2";
            const title = "<title";
            if (v.includes(substring)) {
              let regexp = />(.+)</;
              let regexpa = /[a-zA-Z0-9]/g;
              let matchRes = v.match(regexp);
              if (matchRes) {
                let result = matchRes[1];
                qword.push(result);
                console.log(result);
                // vm.isButtonDisabled=false;
              }
            }
            if (v.includes(title)) {
              let regexp = />(.+)</;
              let matchRes = v.match(regexp);
              if (matchRes) {
                vm.Question = matchRes[1];
                console.log(matchRes[1]);
              }
            }
          }
        }
      });
    }
  }
});

let up_text = new Vue({
  el: "#app",
  data: {
    file: ""
  },
  methods: {
    onFileChange(e) {
      let file = e.target.files[0];
      if (file && file.name.match(/\.docx$/i)) {
        docx2txt(file);
      } else {
        pptx2txt(file);
      }
    }
  }
});

function pptx2txt(file) {
  let fr = new FileReader();
  fr.onload = function() {
    let xml, dom, txt, p, i, r, j, t, k;
    let count = 0;
    let dir = new JSZip(fr.result).file("ppt/slides");
    xml = new JSZip(fr.result).file("ppt/slides/slide2.xml").asText();
    dom = new DOMParser().parseFromString(xml, "application/xml");
    t = dom.getElementsByTagNameNS(
      "http://schemas.openxmlformats.org/drawingml/2006/main",
      "t"
    );
    data = " ";
    for (let i = 0; i < 10; i++) {
      data += t[i].textContent + "\n";
      console.log(t[i].textContent);
    }
    vm2.doc_text = data;
  };
  fr.readAsArrayBuffer(file);
}

function docx2txt(file) {
  let fr = new FileReader();
  fr.onload = function() {
    let xml, dom, txt, p, i, r, j, t, k;

    xml = new JSZip(fr.result).file("ppt/slides/slide1.xml").asText();
    dom = new DOMParser().parseFromString(xml, "application/xml");
    txt = "";
    p = dom.firstChild.firstChild.childNodes;
    console.log(dom);
    for (i = 0; i < p.length; i++) {
      if (p[i].nodeName !== "a:p") {
        continue;
      }
      r = p[i].childNodes;
      for (j = 0; j < r.length; j++) {
        if (r[j].nodeName !== "a:r") {
          continue;
        }
        t = r[j].childNodes;
        for (k = 0; k < t.length; k++) {
          if (txt[k].nodeName === "a:t") {
            txt += t[k].textContent;
          } else if (t[k].nodeName === "a:tab") {
            txt += "\t";
          }
        }
      }
      txt += "\n";
      console.log(txt);
      vm2.doc_text = txt;
    }
    vm2.doc_text = txt;
  };

  fr.onload = function() {
    console.log("aa");
    let xml, dom, txt, p, i, r, j, t, k;
    xml = new JSZip(fr.result).file("word/document.xml").asText();
    dom = new DOMParser().parseFromString(xml, "application/xml");
    txt = "";
    p = dom.firstChild.firstChild.childNodes;
    for (i = 0; i < p.length; i++) {
      if (p[i].nodeName !== "w:p") {
        continue;
      }
      r = p[i].childNodes;
      for (j = 0; j < r.length; j++) {
        if (r[j].nodeName !== "w:r") {
          continue;
        }
        t = r[j].childNodes;
        for (k = 0; k < t.length; k++) {
          if (t[k].nodeName === "w:t") {
            txt += t[k].textContent;
          } else if (t[k].nodeName === "w:tab") {
            txt += "\t";
          }
        }
      }
      txt += "\n";
    }
    vm2.doc_text = txt;
  };
  fr.readAsArrayBuffer(file);
}

window.SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
const recognition = new webkitSpeechRecognition();
recognition.lang = "en-US";

recognition.onresult=function(event) {
    text[vm.index] = event.results.item(0).item(0).transcript;

    // vm.not_start=false
    // vm.not_error=true
    // vm.recognition_error=false
    // vm.recording=false

    console.log(text[vm.index]);
    vm.output = text[vm.index];
    vm.recwait = false;

    let regexpa = /[^a-zA-Z0-9|| ]/g;
    // let regexpa = /[?!.()]/g;
    let q = qword[vm.index].replace(regexpa, "");
    console.log(q);
    console.log(q.length);
    let correct_value = 1;
    let incorrect_value = 0.5;
    let coin = 0;

    sleep(2,function(){
      //発音記号取
    var formdata = new FormData();
    formdata.append("output_word",text[vm.index])
    formdata.append("correct_word",q)
    formdata.append("user_id",user_id)
    console.log(wav_filename)
    formdata.append("filename",wav_filename)

    $.ajax({
      url: "./api/phoneme.php",
      type: "POST",
      data: formdata,
      cache: false,
      contentType: false,
      processData: false
    }).done(data => {
      console.log(data);

      console.log(data.output_phoneme["s_sign"])
      if(data.output_phoneme["s_sign"]==-1){
        vm.not_start=false
        vm.not_error=false
        vm.recognition_error=true
      }
      else if(data.check=="faild"){
        vm.not_start=false
        vm.not_error=false
        vm.recognition_error=true
      }
      else{
       vm.not_start=false
       vm.not_error=true
       vm.recognition_error=false
      // vm.recording=false
      }
    });
 
    
    // $output_phoneme=get_phonetic(text[vm.index].toLowerCase(),$phonetic_reration);
    // $correct_phoneme=get_phonetic(q.toLowerCase(),$phonetic_reration);


    if (text[vm.index].toLowerCase() === q.toLowerCase()) {
      vm.result = false;
      vm.correct = true;
      vm.incorrect = false;
      //results.push("0");
      results[0] = "0";

      //e-coin用追加
      // coin = q.length * correct_value;
      // if (mode_id == 1) {
      //   //      app_id,app_pass,app_login_id,num_coin
      //   add_coin(2, "kamimura", user_name, coin);
      // } else if (mode_id == 2) {
      //   add_coin(2, "kamimura", user_name, Math.ceil(coin * 1.5));
      // }
    } else {
      vm.result = false;
      vm.incorrect = true;
      vm.correct = false;
      //results.push("1");
      results[0] = "1";
    }
    })

      // coin = q.length * incorrect_value;

      // if (mode_id == 1) {
      //   //      app_id,app_pass,app_login_id,num_coin
      //   add_coin(2, "kamimura", user_name, coin);
      // } else if (mode_id == 2) {
      //   add_coin(2, "kamimura", user_name, Math.ceil(coin * 1.5));
      // }

    // let cnt = 0;
    // let report = results;

    // for (let r of report) {
    //   request
    //     .post("../php/received.php")
    //     .type("json")
    //     .send({
    //       r: r,
    //       word: q,
    //       user_name: user_name,
    //       mode_id: mode_id
    //     })
    //     .end((err, res) => {
    //       console.log(res.text);
    //     });
    // }

    // if (vm.index >= qword.length) {
    //   vm.isFinButtonDisabled = false;
    // }
  }

recognition.onerror = function(event) {
  console.log('Speech recognition error detected: ' + event.error);
  vm.not_start=false
  vm.not_error=false
  vm.recognition_error=true
  // vm.recording=false

}

recognition.onnomatch = function() {
  console.log('Speech not recognised');
}
