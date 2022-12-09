<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
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
</style>
<body>
<button class="generate number">start</button>

<!--<form class="options">-->
<!--    <legend>Options</legend>-->
<!---->
<!--    <label for="min">Min</label>-->
<!--    <input type="number" value="0" id="min" name="min">-->
<!---->
<!--    <label for="max">Max</label>-->
<!--    <input type="number" value="10" id="max" name="max">-->
<!--</form>-->
<script>
    var generator = {
        min: 0,
        max: 100,

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

    document.querySelector('.generate').onclick = function () {
        number.textContent = generator.getRandom();
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