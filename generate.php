<?php

include('header.php') ?>
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
  <div>
    <button class="btn"><?= __('Сгенерировать случайное число') ?></button>
    <p class="reply"> <?= __('Случайное число') ?> <span class='nbr'>...</span></p>
  </div>
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
<?php
include('footer.php')
?>