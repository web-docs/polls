<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<style>

  .btn {
    width: 20em;
    height: 2.2em;
    border-radius: 20px;
    background: #00ff80;
    box-shadow: 4px 2px 2px 0px #fff inset, 2px 2px 3px black;
    cursor: pointer;
    text-transform: uppercase;
    font-size: 30px;
  }
  button:active {
    box-shadow: none;
  }
</style>
<body>
<div>
  <button class="btn">Generate a random number</button>
  <p class="reply"> The random number is <span class='nbr'>...</span></p>
</div>
<script src="assets/js/jquery-2.0.3.min.js"></script>
<script>
    $(document).ready(function () {
        $('.btn').click(function () {
            let min = Math.round(1);
            let max = Math.round(200);
            $('.nbr').html('');
            if (min < max) {
                let random = randomInt(min, max);
                $('.nbr').html(random + '!');
            } else {
                $('.nbr').html('invalid :&#40;');
            }
        });

        function randomInt(min, max) {
            return Math.floor(Math.random() * (max - min + 1) + min);
        }
    });
</script>
</body>
</html>