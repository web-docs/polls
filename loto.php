<?php

$count = isset($_GET['c']) ? $_GET['c'] : 150;

?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Loto</title>
</head>
<style>


  .number{
      /* Remove button styles */
      border: none;
      background: transparent;
      outline: none;
      /*overflow: none;*/
      /* Make 'clickable' */
      cursor: pointer;

    text-shadow: 0 0 5px #bbb;
    /* Make it big */
    font-weight: 900;
    font-size: 250px;
    /* Center it */
    width: 50%;
    min-height: 50%;
    overflow: auto;
    margin: auto;
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
  }

  .spinner{
      text-shadow: 0 0 5px #bbb;
      /* Make it big */
      font-weight: 900;
      font-size: 250px;
      /* Center it */
      width: 50%;
      min-height: 50%;
      overflow: auto;
      margin: auto;
      position: absolute;
      top: 0;
      left: 0;
      bottom: 0;
      right: 0;
  }
  #results{
      background:#ffcc00;
      font-size:48px;
      width:200px;
      padding:10px;
      margin:10px;
      
  }
  #results_1,
  #results_2,
  #results_3{
      border: 1px solid #ccc;
      margin: 2px;
  }
</style>
<body>

<div class="spinner">
    <span id="results_1">0</span>
    <span id="results_2">0</span>
    <span id="results_3">0</span>
</div>

<button class="generate number">
    START
</button>


<div id="results">
    <span id="result_list"></span>

</div>
<?php /*
<a href="/loto.php?c=999">Пример задания диапазона пользователей от 1 до 999  ?c=999 </a>
*/ ?>

<script>
    var min = 1;
    var max = '<?=$count ?>';
    var k=0;
    var numbers = [];
    var results = document.querySelector('#result_list');
    var results_1 = document.querySelector('#results_1');
    var results_2 = document.querySelector('#results_2');
    var results_3 = document.querySelector('#results_3');

    document.querySelector('.generate').onclick = function () {
        var time = 5000;
        var delay = 80;
        var timerId ;
        var res= [];
        timerId = setInterval(function random(){
           time-=delay; 
           num = getRandom();

            res = correctNumber(num);
            results_1.innerHTML= res[0];
            results_2.innerHTML= res[1];
            results_3.innerHTML= res[2];

           if(time<=0) {               
               clearInterval(timerId);
               k++;

               while (numbers.indexOf(num) >= 0) {

                   if(numbers.length==max) {
                       num=0;
                       break;
                   }
                   num = getRandom();
               }
               res = correctNumber(num);
               results_1.innerHTML = res[0];
               results_2.innerHTML = res[1];
               results_3.innerHTML = res[2];
               if(num>0) {
                   numbers.push(num);
                   results.innerHTML += k + '. <b>' + num + '</b><br>';
               }
           }
        }, delay);

    };

    function getRandom(){
        return Math.round(Math.random() * (max - min) + min);
    }

    function correctNumber(num){
        if(num<10){
            num = '00' + num;
        }else if(num>=10 && num <100){
            num = '0' + num;
        }
        return (""+num).split("");
    }

</script>
</body>
</html>