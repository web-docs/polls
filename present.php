<?php

require 'init.php';

if( isset($_POST['num']) && isset($_POST['ajax']) ) {
    return ['status' => Present::out($_POST['num'],$_POST['quantity'])];
}

include("header.php");
?>


<div class="lotto">
    <div class="container">
        <div class="lotto-wrap">

            <div class="lotto-title">
                <div class="lotto-dotted"></div>
                <div class="border">
                    <svg width="672.96" height="45.825" viewBox="0 0 672.96 45.825" xmlns="http://www.w3.org/2000/svg">
                        <g id="svgGroup" stroke-linecap="round" fill-rule="evenodd" font-size="9pt" stroke="#000" stroke-width="0.25mm" fill="none" style="stroke:#000;stroke-width:0.25mm;fill:none">
                            <path
                                    d="M 21.376 45.312 L 0 45.312 L 0 0.512 L 20.096 0.512 Q 25.178 0.512 28.717 1.849 A 13.332 13.332 0 0 1 32 3.616 A 9.85 9.85 0 0 1 36.093 10.768 A 12.862 12.862 0 0 1 36.16 12.096 A 13.514 13.514 0 0 1 35.875 14.945 A 9.69 9.69 0 0 1 34.528 18.24 Q 32.896 20.736 30.144 22.08 Q 27.392 23.424 24.192 23.424 L 25.344 21.504 A 18.682 18.682 0 0 1 28.854 21.82 A 14.331 14.331 0 0 1 32.128 22.848 Q 35.072 24.192 36.8 26.784 A 9.981 9.981 0 0 1 38.243 30.302 A 14.13 14.13 0 0 1 38.528 33.216 Q 38.528 38.976 34.208 42.144 A 14.067 14.067 0 0 1 30.193 44.136 Q 26.563 45.312 21.376 45.312 Z M 6.4 5.696 L 6.4 40.128 L 21.12 40.128 A 25.306 25.306 0 0 0 24.125 39.962 Q 25.609 39.784 26.827 39.416 A 9.734 9.734 0 0 0 29.248 38.336 Q 32.064 36.544 32.064 32.704 A 8.52 8.52 0 0 0 31.789 30.471 A 5.751 5.751 0 0 0 29.248 27.008 Q 27.271 25.75 24.063 25.375 A 25.432 25.432 0 0 0 21.12 25.216 L 5.824 25.216 L 5.824 20.032 L 19.52 20.032 Q 22.712 20.032 24.967 19.261 A 9.07 9.07 0 0 0 27.072 18.24 Q 29.76 16.448 29.76 12.864 A 7.551 7.551 0 0 0 29.442 10.612 A 5.709 5.709 0 0 0 27.072 7.488 A 9.383 9.383 0 0 0 24.529 6.328 Q 23.336 5.973 21.9 5.817 A 22.146 22.146 0 0 0 19.52 5.696 L 6.4 5.696 Z"
                                    id="0" vector-effect="non-scaling-stroke"/>
                            <path
                                    d="M 48.064 25.984 L 48.064 0.512 L 54.464 0.512 L 54.464 25.728 A 27.041 27.041 0 0 0 54.725 29.621 Q 55.016 31.619 55.634 33.219 A 10.314 10.314 0 0 0 57.76 36.672 A 10.737 10.737 0 0 0 63.06 39.672 Q 64.772 40.1 66.8 40.127 A 20.626 20.626 0 0 0 67.072 40.128 A 17.128 17.128 0 0 0 70.843 39.738 Q 73.404 39.16 75.276 37.726 A 10.163 10.163 0 0 0 76.448 36.672 A 10.414 10.414 0 0 0 78.642 33.039 Q 79.744 30.057 79.744 25.728 L 79.744 0.512 L 85.952 0.512 L 85.952 25.984 Q 85.952 35.712 80.928 40.768 A 16.535 16.535 0 0 1 72.902 45.171 Q 70.289 45.804 67.207 45.824 A 31.08 31.08 0 0 1 67.008 45.824 Q 58.176 45.824 53.12 40.768 A 16.111 16.111 0 0 1 49.175 34.078 Q 48.376 31.538 48.152 28.468 A 34.057 34.057 0 0 1 48.064 25.984 Z"
                                    id="1" vector-effect="non-scaling-stroke"/>
                            <path
                                    d="M 136.192 6.976 L 132.032 11.008 A 17.091 17.091 0 0 0 127.879 7.776 A 15.745 15.745 0 0 0 126.272 7.008 A 17.847 17.847 0 0 0 119.538 5.697 A 20.223 20.223 0 0 0 119.424 5.696 A 19.59 19.59 0 0 0 114.383 6.329 A 17.567 17.567 0 0 0 112.416 6.976 Q 109.184 8.256 106.816 10.56 Q 104.448 12.864 103.136 16.032 A 17.478 17.478 0 0 0 101.85 21.879 A 20.384 20.384 0 0 0 101.824 22.912 A 18.429 18.429 0 0 0 102.498 27.954 A 16.657 16.657 0 0 0 103.136 29.792 Q 104.448 32.96 106.816 35.264 Q 109.184 37.568 112.416 38.848 A 18.469 18.469 0 0 0 118.257 40.097 A 21.561 21.561 0 0 0 119.424 40.128 A 17.93 17.93 0 0 0 125.971 38.936 A 17.26 17.26 0 0 0 126.272 38.816 A 15.913 15.913 0 0 0 131.216 35.577 A 18.782 18.782 0 0 0 132.032 34.752 L 136.192 38.784 Q 133.12 42.24 128.736 44.032 A 24.316 24.316 0 0 1 121.438 45.732 A 29.128 29.128 0 0 1 119.104 45.824 A 27.023 27.023 0 0 1 112.764 45.103 A 23.546 23.546 0 0 1 109.664 44.128 Q 105.344 42.432 102.176 39.328 Q 99.008 36.224 97.216 32.064 A 22.181 22.181 0 0 1 95.498 24.906 A 26.486 26.486 0 0 1 95.424 22.912 A 24.202 24.202 0 0 1 96.159 16.858 A 21.137 21.137 0 0 1 97.216 13.76 Q 99.008 9.6 102.208 6.496 Q 105.408 3.392 109.728 1.696 A 24.76 24.76 0 0 1 116.966 0.081 A 29.423 29.423 0 0 1 119.168 0 A 26.761 26.761 0 0 1 125.627 0.758 A 23.53 23.53 0 0 1 128.736 1.76 Q 133.12 3.52 136.192 6.976 Z"
                                    id="2" vector-effect="non-scaling-stroke"/>
                            <path d="M 177.472 45.312 L 177.472 0.512 L 183.872 0.512 L 183.872 45.312 L 177.472 45.312 Z M 151.744 0.512 L 151.744 45.312 L 145.344 45.312 L 145.344 0.512 L 151.744 0.512 Z M 178.048 19.776 L 178.048 25.344 L 151.104 25.344 L 151.104 19.776 L 178.048 19.776 Z" id="3" vector-effect="non-scaling-stroke"/>
                            <path d="M 203.712 6.08 L 203.712 39.744 L 229.824 39.744 L 229.824 45.312 L 197.312 45.312 L 197.312 0.512 L 228.928 0.512 L 228.928 6.08 L 203.712 6.08 Z M 203.136 25.28 L 203.136 19.84 L 226.176 19.84 L 226.176 25.28 L 203.136 25.28 Z" id="4" vector-effect="non-scaling-stroke"/>
                            <path
                                    d="M 253.516 44.97 A 26.683 26.683 0 0 0 260.352 45.824 A 29.423 29.423 0 0 0 262.554 45.743 A 24.76 24.76 0 0 0 269.792 44.128 Q 274.112 42.432 277.344 39.328 Q 280.576 36.224 282.336 32.064 Q 284.096 27.904 284.096 22.912 A 26.868 26.868 0 0 0 284.012 20.768 A 22.462 22.462 0 0 0 282.336 13.76 Q 280.576 9.6 277.344 6.496 Q 274.112 3.392 269.792 1.696 A 23.546 23.546 0 0 0 266.692 0.722 A 27.023 27.023 0 0 0 260.352 0 A 29.513 29.513 0 0 0 258.046 0.089 A 24.707 24.707 0 0 0 250.816 1.728 Q 246.464 3.456 243.264 6.56 Q 240.064 9.664 238.272 13.824 A 21.206 21.206 0 0 0 237.326 16.504 A 23.685 23.685 0 0 0 236.48 22.912 A 26.163 26.163 0 0 0 236.524 24.434 A 22.24 22.24 0 0 0 238.272 32 Q 240.064 36.16 243.264 39.264 Q 246.464 42.368 250.848 44.096 A 23.913 23.913 0 0 0 253.516 44.97 Z M 260.352 40.128 A 18.899 18.899 0 0 0 265.303 39.496 A 16.953 16.953 0 0 0 267.232 38.848 Q 270.4 37.568 272.736 35.232 Q 275.072 32.896 276.384 29.76 Q 277.696 26.624 277.696 22.912 A 18.381 18.381 0 0 0 277.104 18.184 A 16.326 16.326 0 0 0 276.384 16.064 Q 275.072 12.928 272.736 10.592 Q 270.4 8.256 267.232 6.976 A 17.814 17.814 0 0 0 261.499 5.728 A 20.825 20.825 0 0 0 260.352 5.696 A 19.442 19.442 0 0 0 255.764 6.222 A 16.887 16.887 0 0 0 253.408 6.976 Q 250.24 8.256 247.872 10.592 Q 245.504 12.928 244.192 16.064 Q 242.88 19.2 242.88 22.912 A 18.381 18.381 0 0 0 243.472 27.64 A 16.326 16.326 0 0 0 244.192 29.76 Q 245.504 32.896 247.872 35.232 Q 250.24 37.568 253.408 38.848 A 17.746 17.746 0 0 0 258.729 40.067 A 21.173 21.173 0 0 0 260.352 40.128 Z"
                                    id="5" vector-effect="non-scaling-stroke"/>
                            <path d="M 300.288 45.312 L 293.888 45.312 L 293.888 0.512 L 299.136 0.512 L 328.768 37.312 L 326.016 37.312 L 326.016 0.512 L 332.416 0.512 L 332.416 45.312 L 327.168 45.312 L 297.536 8.512 L 300.288 8.512 L 300.288 45.312 Z" id="6" vector-effect="non-scaling-stroke"/>
                            <path d="M 369.216 45.312 L 363.072 45.312 L 363.072 0.512 L 368.32 0.512 L 388.416 34.368 L 385.6 34.368 L 405.44 0.512 L 410.688 0.512 L 410.752 45.312 L 404.608 45.312 L 404.544 10.176 L 406.016 10.176 L 388.352 39.872 L 385.408 39.872 L 367.616 10.176 L 369.216 10.176 L 369.216 45.312 Z" id="8" vector-effect="non-scaling-stroke"/>
                            <path d="M 424 45.312 L 417.408 45.312 L 437.696 0.512 L 444.032 0.512 L 464.384 45.312 L 457.664 45.312 L 439.552 4.096 L 442.112 4.096 L 424 45.312 Z M 454.848 34.112 L 426.048 34.112 L 427.776 28.992 L 452.992 28.992 L 454.848 34.112 Z" id="9" vector-effect="non-scaling-stroke"/>
                            <path
                                    d="M 507.52 6.976 L 503.36 11.008 A 17.091 17.091 0 0 0 499.207 7.776 A 15.745 15.745 0 0 0 497.6 7.008 A 17.847 17.847 0 0 0 490.866 5.697 A 20.223 20.223 0 0 0 490.752 5.696 A 19.59 19.59 0 0 0 485.711 6.329 A 17.567 17.567 0 0 0 483.744 6.976 Q 480.512 8.256 478.144 10.56 Q 475.776 12.864 474.464 16.032 A 17.478 17.478 0 0 0 473.178 21.879 A 20.384 20.384 0 0 0 473.152 22.912 A 18.429 18.429 0 0 0 473.826 27.954 A 16.657 16.657 0 0 0 474.464 29.792 Q 475.776 32.96 478.144 35.264 Q 480.512 37.568 483.744 38.848 A 18.469 18.469 0 0 0 489.585 40.097 A 21.561 21.561 0 0 0 490.752 40.128 A 17.93 17.93 0 0 0 497.299 38.936 A 17.26 17.26 0 0 0 497.6 38.816 A 15.913 15.913 0 0 0 502.544 35.577 A 18.782 18.782 0 0 0 503.36 34.752 L 507.52 38.784 Q 504.448 42.24 500.064 44.032 A 24.316 24.316 0 0 1 492.766 45.732 A 29.128 29.128 0 0 1 490.432 45.824 A 27.023 27.023 0 0 1 484.092 45.103 A 23.546 23.546 0 0 1 480.992 44.128 Q 476.672 42.432 473.504 39.328 Q 470.336 36.224 468.544 32.064 A 22.181 22.181 0 0 1 466.826 24.906 A 26.486 26.486 0 0 1 466.752 22.912 A 24.202 24.202 0 0 1 467.487 16.858 A 21.137 21.137 0 0 1 468.544 13.76 Q 470.336 9.6 473.536 6.496 Q 476.736 3.392 481.056 1.696 A 24.76 24.76 0 0 1 488.294 0.081 A 29.423 29.423 0 0 1 490.496 0 A 26.761 26.761 0 0 1 496.955 0.758 A 23.53 23.53 0 0 1 500.064 1.76 Q 504.448 3.52 507.52 6.976 Z"
                                    id="10" vector-effect="non-scaling-stroke"/>
                            <path d="M 548.8 45.312 L 548.8 0.512 L 555.2 0.512 L 555.2 45.312 L 548.8 45.312 Z M 523.072 0.512 L 523.072 45.312 L 516.672 45.312 L 516.672 0.512 L 523.072 0.512 Z M 549.376 19.776 L 549.376 25.344 L 522.432 25.344 L 522.432 19.776 L 549.376 19.776 Z" id="11" vector-effect="non-scaling-stroke"/>
                            <path d="M 575.04 45.312 L 568.64 45.312 L 568.64 0.512 L 575.04 0.512 L 575.04 45.312 Z" id="12" vector-effect="non-scaling-stroke"/>
                            <path d="M 594.88 45.312 L 588.48 45.312 L 588.48 0.512 L 593.728 0.512 L 623.36 37.312 L 620.608 37.312 L 620.608 0.512 L 627.008 0.512 L 627.008 45.312 L 621.76 45.312 L 592.128 8.512 L 594.88 8.512 L 594.88 45.312 Z" id="13" vector-effect="non-scaling-stroke"/>
                            <path d="M 646.848 6.08 L 646.848 39.744 L 672.96 39.744 L 672.96 45.312 L 640.448 45.312 L 640.448 0.512 L 672.064 0.512 L 672.064 6.08 L 646.848 6.08 Z M 646.272 25.28 L 646.272 19.84 L 669.312 19.84 L 669.312 25.28 L 646.272 25.28 Z" id="14" vector-effect="non-scaling-stroke"/>
                        </g>
                    </svg>
                </div>
            </div>
            <div class="lotto-count">
                <div class="lotto-count__bg">
                    <div class="bingo prise">!BINGO!</div>


                    <div class="spinner">

                        <div class="present">
                            <img id="results_1" src="assets/img/presents/x.png">
                        </div>
                        <div class="present">
                            <img id="results_2" src="assets/img/presents/x.png">
                        </div>
                        <div class="present">
                            <img id="results_3" src="assets/img/presents/x.png">
                        </div>

                    </div>
                </div>
                <div class="lotto-start">
                    <div class="lotto-bg__start">
                        <a class="lotto-start__btn__press generate">
                            <?= __('СТАРТ') ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>


<?php
include("footer.php");
?>


<script>


    var numbers = <?= Present::off() ?>;
    var presents = <?= Present::on() ?>;
    var presentsAll = <?=Present::all() ?>;

    var min = 0;
    var max = presentsAll.length -1;


    var results = document.querySelector('#result_list');

    var path = 'assets/img/presents/';

    var results_1 = document.querySelector('#results_1');
    var results_2 = document.querySelector('#results_2');
    var results_3 = document.querySelector('#results_3');

    var is_running = false;
    var oldn = 0;

    if (presents.length == 0) {
        $('.lotto-start__btn__press').text('THE END');
    }

    document.querySelector('.generate').onclick = function () {
        var time = 2000;
        var delay = 80;
        var timerId;
        if(is_running) {
            // console.log('is_running');
            return false;
        }
        is_running = true;

        if (presents.length == 0) {
            results_1.src = path + 'x.png';
            results_2.src = path + 'x.png';
            results_3.src = path + 'x.png';
            is_running = false;
            $('.bingo').text('!BINGO!');
            //console.log('THE END')
            $('.lotto-start__btn__press').text('THE END')

            return false;
        }

        $('.bingo').text('!BINGO!');

        // console.log(min + ' ' + max + ' ' + presents.length);

        max = presentsAll.length - 1;

        timerId = setInterval(function random() {
            time -= delay;
            results_1.src = path + 'presents_' + presentsAll[getRandom()].type + '.png';
            results_2.src = path + 'presents_' +presentsAll[getRandom()].type + '.png';
            results_3.src = path + 'presents_' +presentsAll[getRandom()].type + '.png';
            //console.log(time);

            if (time <= 0) {
                clearInterval(timerId);
                is_running = false;
                max = presents.length - 1;
                num = getRandom();
                k=0;
                while (numbers.indexOf(num) >= 0) {
                    /*if (numbers.length == presents.length) {
                        num = 0;
                        break;
                    } */
                    num = getRandom();
                    k++;
                    if(k>5) {
                        num=0;
                        break;
                    }
                }

                if(presents.length==1) num=0;

                console.log(num + ' ' + presents.length);
                results_1.src = path + 'presents_' +presents[num].type + '.png';
                results_2.src = path + 'presents_' +presents[num].type + '.png';
                results_3.src = path + 'presents_' +presents[num].type + '.png';


                $('.bingo').text(presents[num].title);

                if(presents) {
                    numbers.push(num);

                    presents[num].quantity-=1;
                    presentOff(presents[num].id,presents[num].quantity);

                    if(presents[num].quantity==0) {
                        presents.splice(num, 1);
                    }

                    if(presents.length==0){
                        $('.generate').removeClass('generate');
                        //$('.bingo').text('!BINGO!');
                        $('.lotto-start__btn__press').text('THE END')
                    }

                } else {
                    max = 0;
                    $('.generate').css('display', 'none');
                }

            }
        }, delay);

    }

    function getRandom() {
        n = Math.round(Math.random() * (max - min) + min);
        /* k=0;
        while(n ==oldn){
            n=Math.round(Math.random() * (max - min) + min);
            k++;
            if(k>3) break;
        } */
        return n;
    }

    function correctNumber(num) {
        if (num < 10) {
            num = '00' + num;
        } else if (num >= 10 && num < 100) {
            num = '0' + num;
        }
        return ("" + num).split("");
    }

    function presentOff(num,quantity) {

        $.ajax({
            type: 'post',
            url: '/present.php',
            data: {num: num,quantity: quantity, ajax: true},
            beforeSend: function (xhr) {
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            },
            success: function (response) {
                if (response.status = false) {
                    alert('error')
                }
            },
            error: function (e) {
                alert(e)
            }
        });

    }
    function setTextAnimation(delay, duration, strokeWidth, timingFunction, strokeColor, repeat) {
        let paths = document.querySelectorAll("path");
        let mode = repeat ? 'infinite' : 'forwards'
        for (let i = 0; i < paths.length; i++) {
            const path = paths[i];
            const length = path.getTotalLength();
            path.style["stroke-dashoffset"] = `${length}px`;
            path.style["stroke-dasharray"] = `${length}px`;
            path.style["stroke-width"] = `${strokeWidth}px`;
            path.style["stroke"] = `${strokeColor}`;
            path.style["animation"] = `${duration}s svg-text-anim ${mode} ${timingFunction}`;
            path.style["animation-delay"] = `${i * delay}s`;
        }
    }


    setTextAnimation(0.2, 4.8, 1, 'linear', '#fff', true);

</script>



