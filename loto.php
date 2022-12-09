<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Loto</title>
</head>
<style>
  .generate {
    /* Remove button styles */
    border: none;
    background: transparent;
    outline: none;
    /*overflow: none;*/
    /* Make 'clickable' */
    cursor: pointer;
  }

  .number {
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

  /*.options {*/
  /*  background-color: #555;*/
  /*  border-radius: 5px;*/
  /*  color: #efefef;*/
  /*  padding: 10px 20px;*/
  /*  position: absolute;*/
  /*  cursor: pointer;*/
  /*}*/
  .options input, .options label {
    display: none;
  }
  .options:hover input, .options:hover label {
    display: inline;
  }
  .options input {
    background-color: #efefef;
    padding: 10px;
    margin: 5px 15px;
  }
  
  #results_block{
      background:#ffcc00;
      font-size:48px;
      width:200px;
      padding:10px;
      margin:10px;
      
  }
  
</style>
<body>
<button class="generate number">START</button>

<div id="results_block">
    <span id="results"></span>
</div>


<script>
    var generator = {
        min: 1,
        max: 150,

        /**
         * Сгенерировать случайное число
         */
        getRandom: function () {
            return Math.round(Math.random() * (this.max - this.min) + this.min);
        },

        /**
         * Установите нижнюю границу числа
         */
        setMin: function (newMin) {
            this.min = parseInt(newMin);
        },

        /**
         * Установите верхнюю границу числа
         */
        setMax: function (newMax) {
            this.max = parseInt(newMax);
        }
    };

    var number = document.querySelector('.number');
    var k=0;
    var numbers = [];
    var results = document.querySelector('#results');
    document.querySelector('.generate').onclick = function () {
        number.textContent = generator.getRandom();
        var time = 3000;
        var delay = 100;
        var timerId ;
        timerId = setInterval(function random(){
           time-=delay; 
           num = generator.getRandom();
           while( numbers.indexOf(num) >= 0 ){
               num = generator.getRandom();               
           }
           
           number.textContent = num;
           
           if(time<=0) {               
               clearInterval(timerId);
               k++;
               results.innerHTML+= k+'. <b>' + num +'</b><br>'; 
           }
        }, delay);
        
    };

    var options = document.querySelector('.options');

    options.querySelector('#min').onchange = function () {
        generator.setMin(this.value);
    };

    options.querySelector('#max').onchange = function () {
        generator.setMax(this.value);
    };


</script>
</body>
</html>