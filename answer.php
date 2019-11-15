<?php
session_start();

// ログイン状態チェック
if (!isset($_SESSION["NAME"])) {
    header("Location:./userlogin/logout.php");
    exit;
}
$user_id=$_SESSION["ID"];
$user_name=$_SESSION["NAME"];

?>

<!DOCTYPE html>
<html>

<head>
  <title>Mejiro</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <!-- <script type="text/javascript" src="js/jquery.min.js"></script> -->
  <!-- <script type="text/javascript" src="js/script.js"></script> -->
  <script src="https://use.fontawesome.com/0f942f413c.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.0/css/bulma.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/index.css">
  <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha256-k2WSCIexGzOj3Euiig+TlR8gA0EmPjuc79OEeY5L45g=" crossorigin="anonymous"></script> -->
  <!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
  <script type="text/javascript" src="js/jquery.xdomainajax.js"></script> -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/superagent/3.6.0/superagent.js"></script>
  <script type="text/javascript"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- <script type="text/javascript" src="js/jquery.min.js"></script> -->
  <!-- <script type="text/javascript" src="js/script.js"></script> -->
  <script src="https://use.fontawesome.com/0f942f413c.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.0/css/bulma.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/index.css">
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.0.0/jszip.js"></script> -->
  <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha256-k2WSCIexGzOj3Euiig+TlR8gA0EmPjuc79OEeY5L45g=" crossorigin="anonymous"></script> -->
  <!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script> -->
  <script type="text/javascript" src="js/jquery.xdomainajax.js"></script>
  <!-- <script type="module" src="js/main.js"></script> -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/superagent/3.6.0/superagent.js"></script>
  <script type="text/javascript"></script>
  <script src="js/FileSaver.min.js"></script>
  <script src="js/jszip.min.js"></script>
  </script>
  <style>
  </style>
  <main class="columns">
    <div class="column is-5 is-offset-3">
      <div id="title" class="notification is-primary column  is-offset-1">
        <h1 class="title"> Mejiro</h1>
      </div>
        <div  class="container is-fluid column  is-offset-1">
          <div class="columns">
              <div class="column">
                <h4>WELCOME   <u><?php echo htmlspecialchars($_SESSION["NAME"], ENT_QUOTES); ?></u></h4>
              </div>
              <div class="column is-8">
                <input class="button is-primary" value="Logout" onClick="location.href='./userlogin/logout.php'"></input>
              </div>  
          </div>
        <!-- <div id="app">
          <div v-if="!file">
            <div class="file">
            <label class="file-label">
              <input class="file-input" type="file" @change="onFileChange">
              <span class="file-cta">
                <span class="file-icon">
                  <i class="fa fa-upload"></i>
                </span>
                <span class="file-label">
                  Choose a file…
                </span>
              </span>
            </label>
          </div>
          </div>
          <div v-else>
            <img :src="image" />
            <button @click="removeImage">Remove image</button>
          </div>
        </div> -->
        <div id="word">
            <!-- <div class="field">
              <label class="label">INPUT TEXT</label>
              <div class="control">
                <textarea class="textarea" placeholder="Textarea"  v-model="doc_text"></textarea>
                <span class="icon is-small is-left"></i>
              </div>
            </div> -->
        <!-- <p><button v-on:click="getText()" id="wordbutton" class="button is-primary is-medium  fa fa-globe">　Start pronunciation practice!!</button></p> -->          <!-- input word >
        </div>
      </div>
          <div id="rec" v-cloak>
        <!-- <div id="word"> -->
            <div class="column  is-offset-1">
              <div class="content is-large " id="question">
                <article class="level-left">
                  <p>{{ question_index }}</p>
                </article>
                <article class="box media">
                  <p>{{ now_question }}</p>
                </article>
              <p><button id="nextbutton" class="button is-primary is-offset-one-quarter is-medium fa fa-forward "  v-bind:disabled="isButtonDisabled" v-on:click="nextbutton() ">　NEXT QUESTION</button></p>
              <!-- <p>
              <button id="chozen_question_button" class="button is-primary is-offset-one-quarter is-medium fa fa-forward "  v-bind:disabled="isButtonDisabled" v-on:click="chozen_question_button() ">Chozen question</button>
              Question number:
                <input type="number"  min="1" :max="cantnumber" v-model="Chozen_questionNumber" class="input-inline"></p> -->
              
              </p><button id="backbutton" class="button is-primary is-offset-one-quarter is-medium fa fa-forward "  v-bind:disabled="isButtonDisabled" v-on:click="backbutton() ">　Previous QUESTION</button></p>
              
            </p><button id="cansbutton" class="button is-primary is-offset-one-quarter is-medium fa fa-check-circle-o" v-bind:disabled="isButtonDisabled" v-on:click="ansbutton()">　CORRECT ANSWER</button></p>
            <div id="error_show" class="notification is-outlined">
                <div id="error">
                  <li class="fa is-bold" v-if="not_start"></li>
                  <li class="fa fa-circle-o is-bold" v-if="not_error"> Recognition success</li>
                  <li class="fa fa-close is-bold" v-if="recognition_error">Please speech again!!</li>
                  <!-- <li class="fa fa-close is-bold" v-if="recognition_error">Recording</li> -->
                  <!-- <li class="fa fa-close" v-if="record_error">Incorrect</li> -->
                </div>
              </div>  
            </div>
            <!-- <form action="http://www.example.com/search"> -->
                <!-- <div class="field"> -->
                    <textarea id ="answer"  v-model="output" class="input is-primary" type="text" placeholder=""></textarea>
                <!-- </div> -->
              <!-- </form> -->
              <div class="columns">
                <div class="column">
                  <div class="columns">
                    <div class="column">
                      <div id="recognition">
                        <button type="button"  id ="speak" class="button is-primary is-medium fa fa-microphone"  v-bind:disabled="isButtonDisabled" v-on:click="recbutton()">　click to Speak</button>
                      </div>
                    </div>
                    <div class="column is-8">
                        <div id="waittag" class=" is-danger button"  v-show="recwait">{{ wait }}</div>
                    </div>
                  </div>
                </div>
                <div class="column is-three-quarterv is-offset-one-quarter ">
                  <p>
                    <h1 id="error"></h1></p>
                </div>
              </div>
             
              <div id="result_area" class="notification is-outlined">
                <div id="result">
                  <li class="fa fa-flag" v-if="result"> Result</li>
                  <li class="fa fa-circle-o" v-if="correct">Correct</li>
                  <li class="fa fa-close" v-if="incorrect">Incorrect</li>
                </div>
              </div>
              <!--<button id="finishbutton" class="button is-primary is-offset-one-quarter is-medium"  @click="send_result">Finish</button> -->
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- <a id="download">Download</a> -->
    
    <script src="https://unpkg.com/vue/dist/vue.js"></script>
    <script src="js/main.js"></script>
    <script src="js/recorder.js"></script>
    <script type="text/javascript"> 
    let  user_id = "<?=$user_id ?>"; 
    let  user_name = "<?=$user_name ?>";
    </script>
      <!-- e-coin用追加 -->
    <!-- <script src="../../../e-coin/js/add_coin.js"></script> -->
    </body>
   <!-- v-bind:disabled="isFinButtonDisabled"-->