<style>
  .background {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    min-height: 100%;
  }
  .snow-canvas {
    pointer-events: none;
    position: absolute;
    width: 100%;
    height: 100%;
  }

  /* TEMPORAL */
  .debug-sliders {
    position: absolute;
    background-color: rgba(255,255, 255, .3);
    color: white;
    left: 0;
    top: 0;
    z-index: 10;
    display: flex;
    flex-direction: column;
  }

</style>

<div class="background">
  <canvas class="snow-canvas"></canvas>
</div>
<script src="assets/js/jquery-2.0.3.min.js"></script>
<script>
    $(document).ready(function() {

        initSnow();

        //------------AVALANCE CONFIG SLIDERS-------------//
        $('input[type="range"]').each(function() {
            $('span#' + $(this).attr('name')).html($(this).val());
        });
        $('input[type="range"]').on('input', function() {
            $('span#' + $(this).attr('name')).html($(this).val());
        })
        $('#go').click(function() {
            avalanche(
                $('input[name="flakes"').val(),
                $('input[name="speed"').val(),
                $('input[name="weight"').val(),
                $('input[name="weightReduction"').val(),
                $('input[name="cycles"').val(),
                $('input[name="delay"').val()
            );
            $('.content').addClass('animate');
        })
    });



    //------------SNOW ANIMATION-------------//
    /*
        snow Flakes are objects with set properties such as speed, weight, coordinates and also a radio/angle
        which is used to make them fall in oscillating parabolas. They also have a update animation which takes
        them to their next position based only on their individual properties. Theres a base number of flakes that when
        falling off the screen are sent back up, this is the constant snow animation. The avalanche animation inserts
        more Flakes into the flakes array which are temporary and are removed when they leave the screen.
    */
    const canvas = document.querySelector('.snow-canvas');
    const ctx = canvas.getContext('2d');
    let flakes = [];

    const snowOptions = {
        flakeCount: 100,
        speed: 0.8,
        weight: 4,
    };
    const avalancheOptions = {
        flakeCount: 27, // how many flakes are created each cycle
        speed: 26,  // falling speed of flakes
        initWeight: 30, // initial weight(size) of flakes
        weightReduction: .8, // weight reduction for flakes each cycle
        cycles: 23, // amount of cycles
        delay: 55, // delay between cycles in ms
    };

    function initSnow() {
        insertNewFlakes(
            snowOptions.flakeCount,
            snowOptions.weight,
            snowOptions.speed,
            false);
        loop();
    }

    function Flake(x, y, weight, speed, temporal) {
        this.x = x;
        this.y = y;
        this.r = randomBetween(0, 1);
        this.a = randomBetween(0, Math.PI);
        this.weight = randomBetween(temporal ? weight / 2 : 1, weight);
        this.alpha = (this.weight / weight);
        this.speed = (this.weight / weight) * speed;
        this.temporal = temporal;
    }

    Flake.prototype.update = function () {
        this.x += Math.cos(this.a) * this.r;
        this.a += 0.01;
        this.y += this.speed;
    }

    function insertNewFlakes(count, weight, speed, temporal) {
        let i = count, x, y;

        while (i--) {
            x = randomBetween(0, window.innerWidth, true);
            y = temporal ? 0 : randomBetween(0, window.innerHeight, true);
            flakes.push(new Flake(x, y, weight, speed, temporal));
        }
    }

    function loop() {
        // clear canvas
        canvas.width = $('.background').outerWidth();
        canvas.height = $('.background').outerHeight();
        ctx.save();
        ctx.setTransform(1, 0, 0, 1, 0, 0);
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.restore();

        // update flake coordinates and redraw it
        let i = flakes.length;
        while (i--) {
            let flake = flakes[i];
            flake.update();

            ctx.beginPath();
            ctx.arc(flake.x, flake.y, flake.weight, 0, 2 * Math.PI, false);
            ctx.fillStyle = 'rgba(255, 255, 255, ' + flake.alpha + ')';
            ctx.fill();

            // send flakes back up if not temporal
            if (flake.y >= canvas.height && flake.temporal) {
                flake.toRemove = true;
            } else if (flake.y >= canvas.height && !flake.temporal) {
                flake.y = -flake.weight;
                flake.x = randomBetween(0, canvas.width, true);
            }
            // remove temporal flakes that left screen
            flakes = flakes.filter(flake => !flake.toRemove);
        }
        requestAnimationFrame(loop);
    }

    function randomBetween(min, max, round) {
        const num = Math.random() * (max - min + 1) + min;
        if (round) {
            return Math.floor(num);
        } else {
            return num;
        }
    }

    function avalanche(flakes, speed, weight, weightReduction, cycles, delay) {
        insertNewFlakes(flakes, weight, speed, true);
        if(cycles) {
            $('.snow-canvas').css('z-index', '15');
            setTimeout(function() {
                const newWeight = weight - weightReduction > 0 ? weight - weightReduction : 2;
                avalanche(flakes, speed, newWeight, weightReduction, cycles - 1, delay)
            }, delay);
        } else {
            $('.snow-canvas').css('z-index', '1');
        }
    }
</script>


<!--<style>-->
<!--  .snow-wrap {-->
<!--    width: 100%;-->
<!--    height: 100vh;-->
<!--    margin: 0;-->
<!--    padding: 0;-->
<!--    overflow: hidden;-->
<!--    position: absolute;-->
<!--    z-index: -1;-->
<!--  }-->
<!--  .snow {-->
<!--    position: absolute;-->
<!--    width: 120vw;-->
<!--    height: 100vh;-->
<!--    left: -10vw;-->
<!--  }-->
<!---->
<!--  .snowflake {-->
<!--    position: absolute;-->
<!--    top: -5vmin;-->
<!--  }-->
<!--  .snowflake:nth-child(1) {-->
<!--    opacity: 0.3;-->
<!--    font-size: 9px;-->
<!--    left: 44.2vw;-->
<!--    animation: fall-1 50s -3s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(1) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-1 {-->
<!--    7.3333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 66.7vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(2) {-->
<!--    opacity: 0.44;-->
<!--    font-size: 12px;-->
<!--    left: 100.4vw;-->
<!--    animation: fall-2 20s -1.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(2) span {-->
<!--    animation: spin 9s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 3px #fff);-->
<!--  }-->
<!--  @keyframes fall-2 {-->
<!--    2.8333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 79vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(3) {-->
<!--    opacity: 0.74;-->
<!--    font-size: 6px;-->
<!--    left: 101.4vw;-->
<!--    animation: fall-3 40s -16.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(3) span {-->
<!--    animation: spin 3s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 3px #fff);-->
<!--  }-->
<!--  @keyframes fall-3 {-->
<!--    2.8333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 88.7vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(4) {-->
<!--    opacity: 0.73;-->
<!--    font-size: 9px;-->
<!--    left: 20.3vw;-->
<!--    animation: fall-4 30s -24s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(4) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 1px #fff);-->
<!--  }-->
<!--  @keyframes fall-4 {-->
<!--    3.3333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 21.5vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(5) {-->
<!--    opacity: 0.75;-->
<!--    font-size: 12px;-->
<!--    left: 22vw;-->
<!--    animation: fall-5 30s -6s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(5) span {-->
<!--    animation: spin 12s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-5 {-->
<!--    5% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 28.9vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(6) {-->
<!--    opacity: 0.06;-->
<!--    font-size: 15px;-->
<!--    left: 93.7vw;-->
<!--    animation: fall-6 40s -13.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(6) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 3px #fff);-->
<!--  }-->
<!--  @keyframes fall-6 {-->
<!--    5.6666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 60.7vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(7) {-->
<!--    opacity: 0.15;-->
<!--    font-size: 3px;-->
<!--    left: 54.1vw;-->
<!--    animation: fall-7 20s -3s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(7) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-7 {-->
<!--    2.3333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 73.4vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(8) {-->
<!--    opacity: 0.01;-->
<!--    font-size: 9px;-->
<!--    left: 106.8vw;-->
<!--    animation: fall-8 40s -1.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(8) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-8 {-->
<!--    5% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 20.6vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(9) {-->
<!--    opacity: 0.44;-->
<!--    font-size: 3px;-->
<!--    left: 94.5vw;-->
<!--    animation: fall-9 30s -30s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(9) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-9 {-->
<!--    6.8333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 104vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(10) {-->
<!--    opacity: 0.86;-->
<!--    font-size: 6px;-->
<!--    left: 105.1vw;-->
<!--    animation: fall-10 50s -37.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(10) span {-->
<!--    animation: spin 3s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-10 {-->
<!--    6.1666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 39.7vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(11) {-->
<!--    opacity: 0.38;-->
<!--    font-size: 15px;-->
<!--    left: 10.5vw;-->
<!--    animation: fall-11 40s -10.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(11) span {-->
<!--    animation: spin 3s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 3px #fff);-->
<!--  }-->
<!--  @keyframes fall-11 {-->
<!--    5.5% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 108vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(12) {-->
<!--    opacity: 0.67;-->
<!--    font-size: 6px;-->
<!--    left: 97.8vw;-->
<!--    animation: fall-12 10s -19.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(12) span {-->
<!--    animation: spin 12s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-12 {-->
<!--    8% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 87.4vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(13) {-->
<!--    opacity: 0.58;-->
<!--    font-size: 6px;-->
<!--    left: 66.2vw;-->
<!--    animation: fall-13 30s -9s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(13) span {-->
<!--    animation: spin 12s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 3px #fff);-->
<!--  }-->
<!--  @keyframes fall-13 {-->
<!--    4% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 82.3vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(14) {-->
<!--    opacity: 0.76;-->
<!--    font-size: 15px;-->
<!--    left: 85.1vw;-->
<!--    animation: fall-14 40s -33s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(14) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-14 {-->
<!--    0.1666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 108.9vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(15) {-->
<!--    opacity: 0.54;-->
<!--    font-size: 6px;-->
<!--    left: 117.6vw;-->
<!--    animation: fall-15 10s -31.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(15) span {-->
<!--    animation: spin 9s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-15 {-->
<!--    1.6666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 31.5vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(16) {-->
<!--    opacity: 0.53;-->
<!--    font-size: 9px;-->
<!--    left: 67.7vw;-->
<!--    animation: fall-16 40s -25.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(16) span {-->
<!--    animation: spin 9s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-16 {-->
<!--    2.3333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 108.3vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(17) {-->
<!--    opacity: 0.71;-->
<!--    font-size: 9px;-->
<!--    left: 35.6vw;-->
<!--    animation: fall-17 20s -25.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(17) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 3px #fff);-->
<!--  }-->
<!--  @keyframes fall-17 {-->
<!--    2.3333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 110.5vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(18) {-->
<!--    opacity: 0.55;-->
<!--    font-size: 9px;-->
<!--    left: 97.1vw;-->
<!--    animation: fall-18 40s -18s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(18) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 1px #fff);-->
<!--  }-->
<!--  @keyframes fall-18 {-->
<!--    2.6666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 116.9vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(19) {-->
<!--    opacity: 0.11;-->
<!--    font-size: 12px;-->
<!--    left: 14.7vw;-->
<!--    animation: fall-19 20s -10.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(19) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-19 {-->
<!--    4% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 37.8vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(20) {-->
<!--    opacity: 0.76;-->
<!--    font-size: 3px;-->
<!--    left: 7.3vw;-->
<!--    animation: fall-20 50s -6s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(20) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-20 {-->
<!--    2.6666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 107.9vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(21) {-->
<!--    opacity: 0.51;-->
<!--    font-size: 3px;-->
<!--    left: 97.1vw;-->
<!--    animation: fall-21 30s -12s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(21) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 1px #fff);-->
<!--  }-->
<!--  @keyframes fall-21 {-->
<!--    2.8333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 41.4vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(22) {-->
<!--    opacity: 0.73;-->
<!--    font-size: 3px;-->
<!--    left: 79.2vw;-->
<!--    animation: fall-22 20s -31.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(22) span {-->
<!--    animation: spin 3s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-22 {-->
<!--    8.3333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 86.1vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(23) {-->
<!--    opacity: 0.01;-->
<!--    font-size: 6px;-->
<!--    left: 34.8vw;-->
<!--    animation: fall-23 40s -13.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(23) span {-->
<!--    animation: spin 3s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-23 {-->
<!--    5.8333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 92.7vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(24) {-->
<!--    opacity: 0.09;-->
<!--    font-size: 3px;-->
<!--    left: 35.5vw;-->
<!--    animation: fall-24 10s -34.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(24) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-24 {-->
<!--    5.5% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 6.4vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(25) {-->
<!--    opacity: 0.36;-->
<!--    font-size: 12px;-->
<!--    left: 71.2vw;-->
<!--    animation: fall-25 10s -19.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(25) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-25 {-->
<!--    7.6666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 65vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(26) {-->
<!--    opacity: 0.65;-->
<!--    font-size: 9px;-->
<!--    left: 3.7vw;-->
<!--    animation: fall-26 50s -37.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(26) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-26 {-->
<!--    0.8333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 6.4vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(27) {-->
<!--    opacity: 0.76;-->
<!--    font-size: 3px;-->
<!--    left: 117.8vw;-->
<!--    animation: fall-27 30s -25.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(27) span {-->
<!--    animation: spin 9s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-27 {-->
<!--    1% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 16.1vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(28) {-->
<!--    opacity: 0.02;-->
<!--    font-size: 3px;-->
<!--    left: 56.3vw;-->
<!--    animation: fall-28 50s -31.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(28) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-28 {-->
<!--    3.5% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 22.9vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(29) {-->
<!--    opacity: 0.01;-->
<!--    font-size: 3px;-->
<!--    left: 116.2vw;-->
<!--    animation: fall-29 20s -1.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(29) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 3px #fff);-->
<!--  }-->
<!--  @keyframes fall-29 {-->
<!--    8.1666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 20.7vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(30) {-->
<!--    opacity: 0.4;-->
<!--    font-size: 9px;-->
<!--    left: 83.1vw;-->
<!--    animation: fall-30 10s -30s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(30) span {-->
<!--    animation: spin 9s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 3px #fff);-->
<!--  }-->
<!--  @keyframes fall-30 {-->
<!--    6.8333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 117.8vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(31) {-->
<!--    opacity: 0.41;-->
<!--    font-size: 3px;-->
<!--    left: 6vw;-->
<!--    animation: fall-31 40s -13.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(31) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 1px #fff);-->
<!--  }-->
<!--  @keyframes fall-31 {-->
<!--    6.6666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 74.9vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(32) {-->
<!--    opacity: 0.72;-->
<!--    font-size: 15px;-->
<!--    left: 25.8vw;-->
<!--    animation: fall-32 30s -30s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(32) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-32 {-->
<!--    5.6666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 51.9vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(33) {-->
<!--    opacity: 0.08;-->
<!--    font-size: 6px;-->
<!--    left: 101.8vw;-->
<!--    animation: fall-33 50s -4.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(33) span {-->
<!--    animation: spin 3s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 1px #fff);-->
<!--  }-->
<!--  @keyframes fall-33 {-->
<!--    6.8333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 108.5vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(34) {-->
<!--    opacity: 0.59;-->
<!--    font-size: 6px;-->
<!--    left: 92.1vw;-->
<!--    animation: fall-34 20s -33s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(34) span {-->
<!--    animation: spin 9s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-34 {-->
<!--    1.6666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 39.1vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(35) {-->
<!--    opacity: 0.78;-->
<!--    font-size: 9px;-->
<!--    left: 70.7vw;-->
<!--    animation: fall-35 50s -9s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(35) span {-->
<!--    animation: spin 9s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 1px #fff);-->
<!--  }-->
<!--  @keyframes fall-35 {-->
<!--    1% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 106.4vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(36) {-->
<!--    opacity: 0.08;-->
<!--    font-size: 15px;-->
<!--    left: 73.9vw;-->
<!--    animation: fall-36 50s -28.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(36) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-36 {-->
<!--    4.8333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 114.5vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(37) {-->
<!--    opacity: 0.74;-->
<!--    font-size: 12px;-->
<!--    left: 105.9vw;-->
<!--    animation: fall-37 10s -28.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(37) span {-->
<!--    animation: spin 9s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 1px #fff);-->
<!--  }-->
<!--  @keyframes fall-37 {-->
<!--    3.3333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 100.8vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(38) {-->
<!--    opacity: 0.48;-->
<!--    font-size: 15px;-->
<!--    left: 77vw;-->
<!--    animation: fall-38 30s -18s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(38) span {-->
<!--    animation: spin 3s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 1px #fff);-->
<!--  }-->
<!--  @keyframes fall-38 {-->
<!--    7.1666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 95.4vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(39) {-->
<!--    opacity: 0.5;-->
<!--    font-size: 15px;-->
<!--    left: 8.4vw;-->
<!--    animation: fall-39 40s -24s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(39) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-39 {-->
<!--    4% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 89.2vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(40) {-->
<!--    opacity: 0.16;-->
<!--    font-size: 3px;-->
<!--    left: 61.3vw;-->
<!--    animation: fall-40 30s -22.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(40) span {-->
<!--    animation: spin 9s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-40 {-->
<!--    4.5% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 30.3vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(41) {-->
<!--    opacity: 0.34;-->
<!--    font-size: 9px;-->
<!--    left: 19.7vw;-->
<!--    animation: fall-41 20s -4.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(41) span {-->
<!--    animation: spin 9s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 3px #fff);-->
<!--  }-->
<!--  @keyframes fall-41 {-->
<!--    2.6666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 84.1vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(42) {-->
<!--    opacity: 0.06;-->
<!--    font-size: 12px;-->
<!--    left: 104.5vw;-->
<!--    animation: fall-42 30s -1.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(42) span {-->
<!--    animation: spin 9s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-42 {-->
<!--    6.3333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 58.3vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(43) {-->
<!--    opacity: 0.11;-->
<!--    font-size: 15px;-->
<!--    left: 76.3vw;-->
<!--    animation: fall-43 30s -3s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(43) span {-->
<!--    animation: spin 3s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-43 {-->
<!--    5.3333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 14.2vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(44) {-->
<!--    opacity: 0.12;-->
<!--    font-size: 9px;-->
<!--    left: 51.3vw;-->
<!--    animation: fall-44 50s -25.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(44) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-44 {-->
<!--    3.1666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 78.6vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(45) {-->
<!--    opacity: 0.89;-->
<!--    font-size: 3px;-->
<!--    left: 51.7vw;-->
<!--    animation: fall-45 10s -4.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(45) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-45 {-->
<!--    1% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 106.2vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(46) {-->
<!--    opacity: 0.01;-->
<!--    font-size: 6px;-->
<!--    left: 58.3vw;-->
<!--    animation: fall-46 50s -34.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(46) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-46 {-->
<!--    3% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 66.2vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(47) {-->
<!--    opacity: 0.79;-->
<!--    font-size: 15px;-->
<!--    left: 19.1vw;-->
<!--    animation: fall-47 10s -12s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(47) span {-->
<!--    animation: spin 9s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-47 {-->
<!--    1.8333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 10.6vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(48) {-->
<!--    opacity: 0.07;-->
<!--    font-size: 15px;-->
<!--    left: 69.5vw;-->
<!--    animation: fall-48 30s -6s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(48) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 3px #fff);-->
<!--  }-->
<!--  @keyframes fall-48 {-->
<!--    1.6666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 14.2vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(49) {-->
<!--    opacity: 0.49;-->
<!--    font-size: 9px;-->
<!--    left: 85.1vw;-->
<!--    animation: fall-49 40s -37.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(49) span {-->
<!--    animation: spin 12s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 1px #fff);-->
<!--  }-->
<!--  @keyframes fall-49 {-->
<!--    8% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 57.1vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(50) {-->
<!--    opacity: 0.4;-->
<!--    font-size: 3px;-->
<!--    left: 79.1vw;-->
<!--    animation: fall-50 10s -3s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(50) span {-->
<!--    animation: spin 12s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-50 {-->
<!--    3.8333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 57.6vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(51) {-->
<!--    opacity: 0.83;-->
<!--    font-size: 6px;-->
<!--    left: 59.4vw;-->
<!--    animation: fall-51 50s -1.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(51) span {-->
<!--    animation: spin 9s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-51 {-->
<!--    0.1666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 63.5vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(52) {-->
<!--    opacity: 0.29;-->
<!--    font-size: 15px;-->
<!--    left: 94.1vw;-->
<!--    animation: fall-52 50s -6s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(52) span {-->
<!--    animation: spin 12s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 3px #fff);-->
<!--  }-->
<!--  @keyframes fall-52 {-->
<!--    6.6666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 17.8vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(53) {-->
<!--    opacity: 0.84;-->
<!--    font-size: 12px;-->
<!--    left: 11.9vw;-->
<!--    animation: fall-53 30s -4.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(53) span {-->
<!--    animation: spin 3s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 1px #fff);-->
<!--  }-->
<!--  @keyframes fall-53 {-->
<!--    6% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 4.9vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(54) {-->
<!--    opacity: 0.21;-->
<!--    font-size: 15px;-->
<!--    left: 74.3vw;-->
<!--    animation: fall-54 50s -4.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(54) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-54 {-->
<!--    5.8333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 17.9vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(55) {-->
<!--    opacity: 0.87;-->
<!--    font-size: 12px;-->
<!--    left: 0.5vw;-->
<!--    animation: fall-55 30s -21s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(55) span {-->
<!--    animation: spin 3s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 3px #fff);-->
<!--  }-->
<!--  @keyframes fall-55 {-->
<!--    8% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 55vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(56) {-->
<!--    opacity: 0.73;-->
<!--    font-size: 12px;-->
<!--    left: 78.4vw;-->
<!--    animation: fall-56 30s -36s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(56) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 1px #fff);-->
<!--  }-->
<!--  @keyframes fall-56 {-->
<!--    4.5% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 96.8vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(57) {-->
<!--    opacity: 0.53;-->
<!--    font-size: 6px;-->
<!--    left: 90.5vw;-->
<!--    animation: fall-57 30s -3s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(57) span {-->
<!--    animation: spin 12s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-57 {-->
<!--    3.8333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 34.5vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(58) {-->
<!--    opacity: 0.64;-->
<!--    font-size: 9px;-->
<!--    left: 72.5vw;-->
<!--    animation: fall-58 40s -37.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(58) span {-->
<!--    animation: spin 12s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 3px #fff);-->
<!--  }-->
<!--  @keyframes fall-58 {-->
<!--    3.8333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 94.1vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(59) {-->
<!--    opacity: 0.83;-->
<!--    font-size: 3px;-->
<!--    left: 29.5vw;-->
<!--    animation: fall-59 10s -27s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(59) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 3px #fff);-->
<!--  }-->
<!--  @keyframes fall-59 {-->
<!--    3.8333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 109.1vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(60) {-->
<!--    opacity: 0.09;-->
<!--    font-size: 15px;-->
<!--    left: 114.6vw;-->
<!--    animation: fall-60 40s -15s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(60) span {-->
<!--    animation: spin 3s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-60 {-->
<!--    4.1666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 55.9vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(61) {-->
<!--    opacity: 0.44;-->
<!--    font-size: 9px;-->
<!--    left: 8vw;-->
<!--    animation: fall-61 50s -15s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(61) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-61 {-->
<!--    2% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 54vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(62) {-->
<!--    opacity: 0.41;-->
<!--    font-size: 12px;-->
<!--    left: 13.3vw;-->
<!--    animation: fall-62 10s -3s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(62) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-62 {-->
<!--    6.5% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 78.3vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(63) {-->
<!--    opacity: 0.64;-->
<!--    font-size: 3px;-->
<!--    left: 105.9vw;-->
<!--    animation: fall-63 10s -3s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(63) span {-->
<!--    animation: spin 9s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 3px #fff);-->
<!--  }-->
<!--  @keyframes fall-63 {-->
<!--    5.5% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 116.1vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(64) {-->
<!--    opacity: 0.4;-->
<!--    font-size: 12px;-->
<!--    left: 108.5vw;-->
<!--    animation: fall-64 50s -9s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(64) span {-->
<!--    animation: spin 12s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-64 {-->
<!--    0.6666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 7.7vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(65) {-->
<!--    opacity: 0.78;-->
<!--    font-size: 6px;-->
<!--    left: 44.5vw;-->
<!--    animation: fall-65 30s -18s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(65) span {-->
<!--    animation: spin 12s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 3px #fff);-->
<!--  }-->
<!--  @keyframes fall-65 {-->
<!--    3.6666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 35.6vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(66) {-->
<!--    opacity: 0.5;-->
<!--    font-size: 3px;-->
<!--    left: 73.2vw;-->
<!--    animation: fall-66 50s -37.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(66) span {-->
<!--    animation: spin 12s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-66 {-->
<!--    0.5% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 99.5vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(67) {-->
<!--    opacity: 0.04;-->
<!--    font-size: 15px;-->
<!--    left: 66.7vw;-->
<!--    animation: fall-67 20s -22.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(67) span {-->
<!--    animation: spin 3s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-67 {-->
<!--    1% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 110.9vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(68) {-->
<!--    opacity: 0.16;-->
<!--    font-size: 3px;-->
<!--    left: 5.5vw;-->
<!--    animation: fall-68 50s -27s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(68) span {-->
<!--    animation: spin 12s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-68 {-->
<!--    5.1666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 112.3vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(69) {-->
<!--    opacity: 0.39;-->
<!--    font-size: 12px;-->
<!--    left: 41.5vw;-->
<!--    animation: fall-69 10s -9s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(69) span {-->
<!--    animation: spin 12s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 3px #fff);-->
<!--  }-->
<!--  @keyframes fall-69 {-->
<!--    3.8333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 72.2vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(70) {-->
<!--    opacity: 0.41;-->
<!--    font-size: 12px;-->
<!--    left: 91vw;-->
<!--    animation: fall-70 10s -9s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(70) span {-->
<!--    animation: spin 12s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 3px #fff);-->
<!--  }-->
<!--  @keyframes fall-70 {-->
<!--    8.3333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 49.5vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(71) {-->
<!--    opacity: 0.65;-->
<!--    font-size: 12px;-->
<!--    left: 31.9vw;-->
<!--    animation: fall-71 50s -15s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(71) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-71 {-->
<!--    8.1666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 4.5vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(72) {-->
<!--    opacity: 0.19;-->
<!--    font-size: 12px;-->
<!--    left: 22.5vw;-->
<!--    animation: fall-72 50s -25.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(72) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-72 {-->
<!--    1.6666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 77.6vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(73) {-->
<!--    opacity: 0.13;-->
<!--    font-size: 6px;-->
<!--    left: 52vw;-->
<!--    animation: fall-73 30s -10.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(73) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-73 {-->
<!--    3.6666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 51.9vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(74) {-->
<!--    opacity: 0.52;-->
<!--    font-size: 12px;-->
<!--    left: 114.2vw;-->
<!--    animation: fall-74 30s -27s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(74) span {-->
<!--    animation: spin 9s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-74 {-->
<!--    2.3333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 34.6vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(75) {-->
<!--    opacity: 0.65;-->
<!--    font-size: 15px;-->
<!--    left: 105.5vw;-->
<!--    animation: fall-75 20s -19.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(75) span {-->
<!--    animation: spin 9s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-75 {-->
<!--    1.8333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 46.9vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(76) {-->
<!--    opacity: 0.61;-->
<!--    font-size: 6px;-->
<!--    left: 27.1vw;-->
<!--    animation: fall-76 40s -21s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(76) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 1px #fff);-->
<!--  }-->
<!--  @keyframes fall-76 {-->
<!--    1.3333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 115.6vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(77) {-->
<!--    opacity: 0.67;-->
<!--    font-size: 6px;-->
<!--    left: 42.6vw;-->
<!--    animation: fall-77 30s -30s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(77) span {-->
<!--    animation: spin 12s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-77 {-->
<!--    7.8333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 46vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(78) {-->
<!--    opacity: 0.13;-->
<!--    font-size: 9px;-->
<!--    left: 28.9vw;-->
<!--    animation: fall-78 20s -37.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(78) span {-->
<!--    animation: spin 9s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 1px #fff);-->
<!--  }-->
<!--  @keyframes fall-78 {-->
<!--    1.5% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 109.8vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(79) {-->
<!--    opacity: 0.26;-->
<!--    font-size: 15px;-->
<!--    left: 109.8vw;-->
<!--    animation: fall-79 10s -16.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(79) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-79 {-->
<!--    6.3333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 80.7vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(80) {-->
<!--    opacity: 0.85;-->
<!--    font-size: 3px;-->
<!--    left: 99.1vw;-->
<!--    animation: fall-80 10s -6s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(80) span {-->
<!--    animation: spin 9s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 1px #fff);-->
<!--  }-->
<!--  @keyframes fall-80 {-->
<!--    8.3333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 42.6vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(81) {-->
<!--    opacity: 0.71;-->
<!--    font-size: 6px;-->
<!--    left: 7.9vw;-->
<!--    animation: fall-81 40s -28.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(81) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 1px #fff);-->
<!--  }-->
<!--  @keyframes fall-81 {-->
<!--    0.5% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 12.3vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(82) {-->
<!--    opacity: 0.26;-->
<!--    font-size: 12px;-->
<!--    left: 68.3vw;-->
<!--    animation: fall-82 40s -22.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(82) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-82 {-->
<!--    7.1666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 113.1vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(83) {-->
<!--    opacity: 0.52;-->
<!--    font-size: 9px;-->
<!--    left: 33.5vw;-->
<!--    animation: fall-83 40s -22.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(83) span {-->
<!--    animation: spin 3s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 1px #fff);-->
<!--  }-->
<!--  @keyframes fall-83 {-->
<!--    0.1666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 38.1vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(84) {-->
<!--    opacity: 0.48;-->
<!--    font-size: 3px;-->
<!--    left: 111.2vw;-->
<!--    animation: fall-84 20s -3s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(84) span {-->
<!--    animation: spin 9s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-84 {-->
<!--    4.1666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 58.1vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(85) {-->
<!--    opacity: 0.59;-->
<!--    font-size: 3px;-->
<!--    left: 6.5vw;-->
<!--    animation: fall-85 40s -21s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(85) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 1px #fff);-->
<!--  }-->
<!--  @keyframes fall-85 {-->
<!--    1.5% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 12.6vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(86) {-->
<!--    opacity: 0.26;-->
<!--    font-size: 3px;-->
<!--    left: 66.1vw;-->
<!--    animation: fall-86 50s -16.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(86) span {-->
<!--    animation: spin 3s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-86 {-->
<!--    0.5% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 47vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(87) {-->
<!--    opacity: 0.01;-->
<!--    font-size: 15px;-->
<!--    left: 74.2vw;-->
<!--    animation: fall-87 10s -13.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(87) span {-->
<!--    animation: spin 3s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-87 {-->
<!--    2.3333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 78.1vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(88) {-->
<!--    opacity: 0.57;-->
<!--    font-size: 6px;-->
<!--    left: 119.7vw;-->
<!--    animation: fall-88 20s -24s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(88) span {-->
<!--    animation: spin 3s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-88 {-->
<!--    2.6666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 27.9vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(89) {-->
<!--    opacity: 0.66;-->
<!--    font-size: 15px;-->
<!--    left: 53.4vw;-->
<!--    animation: fall-89 10s -16.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(89) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-89 {-->
<!--    8% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 24.1vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(90) {-->
<!--    opacity: 0.45;-->
<!--    font-size: 12px;-->
<!--    left: 20.2vw;-->
<!--    animation: fall-90 30s -4.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(90) span {-->
<!--    animation: spin 12s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 1px #fff);-->
<!--  }-->
<!--  @keyframes fall-90 {-->
<!--    3.5% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 67vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(91) {-->
<!--    opacity: 0.76;-->
<!--    font-size: 6px;-->
<!--    left: 13.7vw;-->
<!--    animation: fall-91 20s -18s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(91) span {-->
<!--    animation: spin 3s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-91 {-->
<!--    4.6666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 61vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(92) {-->
<!--    opacity: 0.59;-->
<!--    font-size: 15px;-->
<!--    left: 92.6vw;-->
<!--    animation: fall-92 30s -33s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(92) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-92 {-->
<!--    6.5% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 110.9vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(93) {-->
<!--    opacity: 0.15;-->
<!--    font-size: 12px;-->
<!--    left: 20.5vw;-->
<!--    animation: fall-93 50s -31.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(93) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-93 {-->
<!--    6.5% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 23.9vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(94) {-->
<!--    opacity: 0.07;-->
<!--    font-size: 6px;-->
<!--    left: 59.3vw;-->
<!--    animation: fall-94 10s -13.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(94) span {-->
<!--    animation: spin 12s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-94 {-->
<!--    8.3333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 34.4vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(95) {-->
<!--    opacity: 0.62;-->
<!--    font-size: 3px;-->
<!--    left: 52.2vw;-->
<!--    animation: fall-95 30s -36s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(95) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-95 {-->
<!--    5.8333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 88.3vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(96) {-->
<!--    opacity: 0.78;-->
<!--    font-size: 12px;-->
<!--    left: 68.9vw;-->
<!--    animation: fall-96 30s -25.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(96) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-96 {-->
<!--    3.8333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 35.2vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(97) {-->
<!--    opacity: 0.34;-->
<!--    font-size: 12px;-->
<!--    left: 35.7vw;-->
<!--    animation: fall-97 40s -31.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(97) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-97 {-->
<!--    1% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 117.3vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(98) {-->
<!--    opacity: 0.76;-->
<!--    font-size: 6px;-->
<!--    left: 6.4vw;-->
<!--    animation: fall-98 40s -34.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(98) span {-->
<!--    animation: spin 9s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 3px #fff);-->
<!--  }-->
<!--  @keyframes fall-98 {-->
<!--    3% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 14.1vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(99) {-->
<!--    opacity: 0.38;-->
<!--    font-size: 9px;-->
<!--    left: 26.1vw;-->
<!--    animation: fall-99 30s -36s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(99) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-99 {-->
<!--    8% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 8.4vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(100) {-->
<!--    opacity: 0.03;-->
<!--    font-size: 9px;-->
<!--    left: 8.5vw;-->
<!--    animation: fall-100 50s -37.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(100) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-100 {-->
<!--    1% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 2.8vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(101) {-->
<!--    opacity: 0.45;-->
<!--    font-size: 3px;-->
<!--    left: 1.3vw;-->
<!--    animation: fall-101 40s -3s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(101) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-101 {-->
<!--    8.3333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 56.1vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(102) {-->
<!--    opacity: 0.67;-->
<!--    font-size: 12px;-->
<!--    left: 31.8vw;-->
<!--    animation: fall-102 50s -22.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(102) span {-->
<!--    animation: spin 9s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-102 {-->
<!--    6.5% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 38.1vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(103) {-->
<!--    opacity: 0.11;-->
<!--    font-size: 3px;-->
<!--    left: 19.2vw;-->
<!--    animation: fall-103 20s -13.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(103) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-103 {-->
<!--    3.5% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 23.8vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(104) {-->
<!--    opacity: 0.4;-->
<!--    font-size: 3px;-->
<!--    left: 5.5vw;-->
<!--    animation: fall-104 40s -22.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(104) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 1px #fff);-->
<!--  }-->
<!--  @keyframes fall-104 {-->
<!--    4.6666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 24.3vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(105) {-->
<!--    opacity: 0.48;-->
<!--    font-size: 9px;-->
<!--    left: 36.1vw;-->
<!--    animation: fall-105 20s -9s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(105) span {-->
<!--    animation: spin 3s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 1px #fff);-->
<!--  }-->
<!--  @keyframes fall-105 {-->
<!--    7% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 39.4vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(106) {-->
<!--    opacity: 0.8;-->
<!--    font-size: 9px;-->
<!--    left: 38.3vw;-->
<!--    animation: fall-106 30s -16.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(106) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 1px #fff);-->
<!--  }-->
<!--  @keyframes fall-106 {-->
<!--    5.6666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 94.2vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(107) {-->
<!--    opacity: 0.78;-->
<!--    font-size: 12px;-->
<!--    left: 80.6vw;-->
<!--    animation: fall-107 20s -1.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(107) span {-->
<!--    animation: spin 3s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 1px #fff);-->
<!--  }-->
<!--  @keyframes fall-107 {-->
<!--    5.6666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 25.5vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(108) {-->
<!--    opacity: 0.32;-->
<!--    font-size: 12px;-->
<!--    left: 79vw;-->
<!--    animation: fall-108 40s -27s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(108) span {-->
<!--    animation: spin 3s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-108 {-->
<!--    1.1666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 58vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(109) {-->
<!--    opacity: 0.5;-->
<!--    font-size: 12px;-->
<!--    left: 66.5vw;-->
<!--    animation: fall-109 20s -3s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(109) span {-->
<!--    animation: spin 9s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-109 {-->
<!--    7% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 88.1vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(110) {-->
<!--    opacity: 0.56;-->
<!--    font-size: 9px;-->
<!--    left: 23.8vw;-->
<!--    animation: fall-110 50s -10.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(110) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 1px #fff);-->
<!--  }-->
<!--  @keyframes fall-110 {-->
<!--    1.3333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 22.5vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(111) {-->
<!--    opacity: 0.17;-->
<!--    font-size: 12px;-->
<!--    left: 11.5vw;-->
<!--    animation: fall-111 30s -34.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(111) span {-->
<!--    animation: spin 9s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-111 {-->
<!--    7.5% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 29.6vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(112) {-->
<!--    opacity: 0.46;-->
<!--    font-size: 6px;-->
<!--    left: 34.5vw;-->
<!--    animation: fall-112 50s -10.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(112) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-112 {-->
<!--    0.3333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 26.5vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(113) {-->
<!--    opacity: 0.67;-->
<!--    font-size: 6px;-->
<!--    left: 24.1vw;-->
<!--    animation: fall-113 40s -31.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(113) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-113 {-->
<!--    4.3333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 40.7vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(114) {-->
<!--    opacity: 0.81;-->
<!--    font-size: 15px;-->
<!--    left: 12.4vw;-->
<!--    animation: fall-114 10s -21s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(114) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-114 {-->
<!--    7.6666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 38.7vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(115) {-->
<!--    opacity: 0.48;-->
<!--    font-size: 15px;-->
<!--    left: 40.4vw;-->
<!--    animation: fall-115 30s -3s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(115) span {-->
<!--    animation: spin 3s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 1px #fff);-->
<!--  }-->
<!--  @keyframes fall-115 {-->
<!--    0.1666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 71.1vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(116) {-->
<!--    opacity: 0.53;-->
<!--    font-size: 9px;-->
<!--    left: 72.5vw;-->
<!--    animation: fall-116 50s -30s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(116) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-116 {-->
<!--    2.8333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 22.9vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(117) {-->
<!--    opacity: 0.57;-->
<!--    font-size: 6px;-->
<!--    left: 93.9vw;-->
<!--    animation: fall-117 20s -12s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(117) span {-->
<!--    animation: spin 3s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-117 {-->
<!--    5.6666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 92.9vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(118) {-->
<!--    opacity: 0.2;-->
<!--    font-size: 12px;-->
<!--    left: 87.8vw;-->
<!--    animation: fall-118 20s -34.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(118) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-118 {-->
<!--    5% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 7.3vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(119) {-->
<!--    opacity: 0.17;-->
<!--    font-size: 3px;-->
<!--    left: 64.7vw;-->
<!--    animation: fall-119 20s -9s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(119) span {-->
<!--    animation: spin 12s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 1px #fff);-->
<!--  }-->
<!--  @keyframes fall-119 {-->
<!--    7% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 32.3vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(120) {-->
<!--    opacity: 0.15;-->
<!--    font-size: 6px;-->
<!--    left: 19.1vw;-->
<!--    animation: fall-120 50s -28.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(120) span {-->
<!--    animation: spin 9s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 1px #fff);-->
<!--  }-->
<!--  @keyframes fall-120 {-->
<!--    5.3333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 88.5vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(121) {-->
<!--    opacity: 0.04;-->
<!--    font-size: 9px;-->
<!--    left: 4vw;-->
<!--    animation: fall-121 20s -12s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(121) span {-->
<!--    animation: spin 3s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-121 {-->
<!--    3% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 1.2vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(122) {-->
<!--    opacity: 0.45;-->
<!--    font-size: 6px;-->
<!--    left: 107.6vw;-->
<!--    animation: fall-122 10s -19.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(122) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 3px #fff);-->
<!--  }-->
<!--  @keyframes fall-122 {-->
<!--    7.1666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 46.8vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(123) {-->
<!--    opacity: 0.28;-->
<!--    font-size: 6px;-->
<!--    left: 111vw;-->
<!--    animation: fall-123 50s -19.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(123) span {-->
<!--    animation: spin 9s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 1px #fff);-->
<!--  }-->
<!--  @keyframes fall-123 {-->
<!--    2.6666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 116.7vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(124) {-->
<!--    opacity: 0.47;-->
<!--    font-size: 3px;-->
<!--    left: 1.1vw;-->
<!--    animation: fall-124 40s -33s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(124) span {-->
<!--    animation: spin 12s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-124 {-->
<!--    2.6666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 83.9vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(125) {-->
<!--    opacity: 0.65;-->
<!--    font-size: 6px;-->
<!--    left: 92.2vw;-->
<!--    animation: fall-125 50s -37.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(125) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-125 {-->
<!--    3.3333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 59.8vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(126) {-->
<!--    opacity: 0.51;-->
<!--    font-size: 9px;-->
<!--    left: 54.7vw;-->
<!--    animation: fall-126 20s -22.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(126) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 3px #fff);-->
<!--  }-->
<!--  @keyframes fall-126 {-->
<!--    4.8333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 11.9vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(127) {-->
<!--    opacity: 0.69;-->
<!--    font-size: 15px;-->
<!--    left: 65.2vw;-->
<!--    animation: fall-127 50s -12s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(127) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-127 {-->
<!--    0.6666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 87.4vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(128) {-->
<!--    opacity: 0.56;-->
<!--    font-size: 6px;-->
<!--    left: 16.2vw;-->
<!--    animation: fall-128 40s -36s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(128) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 1px #fff);-->
<!--  }-->
<!--  @keyframes fall-128 {-->
<!--    0.8333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 107.1vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(129) {-->
<!--    opacity: 0.5;-->
<!--    font-size: 9px;-->
<!--    left: 81.9vw;-->
<!--    animation: fall-129 20s -36s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(129) span {-->
<!--    animation: spin 3s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-129 {-->
<!--    1.6666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 32.7vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(130) {-->
<!--    opacity: 0.04;-->
<!--    font-size: 15px;-->
<!--    left: 41.4vw;-->
<!--    animation: fall-130 20s -1.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(130) span {-->
<!--    animation: spin 12s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-130 {-->
<!--    4.6666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 116.1vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(131) {-->
<!--    opacity: 0.34;-->
<!--    font-size: 3px;-->
<!--    left: 119vw;-->
<!--    animation: fall-131 30s -1.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(131) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-131 {-->
<!--    0.5% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 92.8vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(132) {-->
<!--    opacity: 0.76;-->
<!--    font-size: 15px;-->
<!--    left: 75.5vw;-->
<!--    animation: fall-132 30s -1.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(132) span {-->
<!--    animation: spin 9s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 3px #fff);-->
<!--  }-->
<!--  @keyframes fall-132 {-->
<!--    6.1666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 48.4vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(133) {-->
<!--    opacity: 0.49;-->
<!--    font-size: 9px;-->
<!--    left: 108.8vw;-->
<!--    animation: fall-133 50s -19.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(133) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-133 {-->
<!--    0.1666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 24.1vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(134) {-->
<!--    opacity: 0.85;-->
<!--    font-size: 3px;-->
<!--    left: 20.5vw;-->
<!--    animation: fall-134 50s -3s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(134) span {-->
<!--    animation: spin 12s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 1px #fff);-->
<!--  }-->
<!--  @keyframes fall-134 {-->
<!--    5% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 35.2vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(135) {-->
<!--    opacity: 0.9;-->
<!--    font-size: 9px;-->
<!--    left: 4.7vw;-->
<!--    animation: fall-135 10s -21s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(135) span {-->
<!--    animation: spin 12s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-135 {-->
<!--    6% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 69.4vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(136) {-->
<!--    opacity: 0.12;-->
<!--    font-size: 6px;-->
<!--    left: 16vw;-->
<!--    animation: fall-136 50s -9s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(136) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 3px #fff);-->
<!--  }-->
<!--  @keyframes fall-136 {-->
<!--    2% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 115.1vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(137) {-->
<!--    opacity: 0.39;-->
<!--    font-size: 12px;-->
<!--    left: 63.4vw;-->
<!--    animation: fall-137 30s -12s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(137) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 1px #fff);-->
<!--  }-->
<!--  @keyframes fall-137 {-->
<!--    3% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 30.8vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(138) {-->
<!--    opacity: 0.54;-->
<!--    font-size: 3px;-->
<!--    left: 75.4vw;-->
<!--    animation: fall-138 40s -1.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(138) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-138 {-->
<!--    1.8333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 100.9vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(139) {-->
<!--    opacity: 0.53;-->
<!--    font-size: 9px;-->
<!--    left: 27.5vw;-->
<!--    animation: fall-139 30s -10.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(139) span {-->
<!--    animation: spin 12s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-139 {-->
<!--    1.6666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 8.9vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(140) {-->
<!--    opacity: 0.29;-->
<!--    font-size: 6px;-->
<!--    left: 76.7vw;-->
<!--    animation: fall-140 20s -19.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(140) span {-->
<!--    animation: spin 3s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-140 {-->
<!--    4.5% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 112.8vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(141) {-->
<!--    opacity: 0.51;-->
<!--    font-size: 12px;-->
<!--    left: 82.2vw;-->
<!--    animation: fall-141 20s -27s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(141) span {-->
<!--    animation: spin 12s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 1px #fff);-->
<!--  }-->
<!--  @keyframes fall-141 {-->
<!--    3.8333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 92.5vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(142) {-->
<!--    opacity: 0.71;-->
<!--    font-size: 9px;-->
<!--    left: 6.9vw;-->
<!--    animation: fall-142 50s -31.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(142) span {-->
<!--    animation: spin 9s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-142 {-->
<!--    0.5% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 36.5vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(143) {-->
<!--    opacity: 0.14;-->
<!--    font-size: 6px;-->
<!--    left: 64vw;-->
<!--    animation: fall-143 50s -7.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(143) span {-->
<!--    animation: spin 12s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 3px #fff);-->
<!--  }-->
<!--  @keyframes fall-143 {-->
<!--    2.8333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 59.8vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(144) {-->
<!--    opacity: 0.79;-->
<!--    font-size: 12px;-->
<!--    left: 29.4vw;-->
<!--    animation: fall-144 30s -13.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(144) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-144 {-->
<!--    5% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 50.8vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(145) {-->
<!--    opacity: 0.87;-->
<!--    font-size: 9px;-->
<!--    left: 42.6vw;-->
<!--    animation: fall-145 20s -19.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(145) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-145 {-->
<!--    1.8333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 89.5vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(146) {-->
<!--    opacity: 0.31;-->
<!--    font-size: 12px;-->
<!--    left: 67.2vw;-->
<!--    animation: fall-146 40s -6s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(146) span {-->
<!--    animation: spin 12s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-146 {-->
<!--    6.6666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 18.8vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(147) {-->
<!--    opacity: 0.63;-->
<!--    font-size: 15px;-->
<!--    left: 10.8vw;-->
<!--    animation: fall-147 30s -4.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(147) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-147 {-->
<!--    2.8333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 9.6vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(148) {-->
<!--    opacity: 0.8;-->
<!--    font-size: 9px;-->
<!--    left: 50.1vw;-->
<!--    animation: fall-148 30s -15s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(148) span {-->
<!--    animation: spin 9s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-148 {-->
<!--    0.8333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 0.1vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(149) {-->
<!--    opacity: 0.56;-->
<!--    font-size: 9px;-->
<!--    left: 9.1vw;-->
<!--    animation: fall-149 40s -28.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(149) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-149 {-->
<!--    0.6666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 77.5vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(150) {-->
<!--    opacity: 0.8;-->
<!--    font-size: 9px;-->
<!--    left: 59.8vw;-->
<!--    animation: fall-150 10s -34.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(150) span {-->
<!--    animation: spin 12s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-150 {-->
<!--    3.1666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 98.4vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(151) {-->
<!--    opacity: 0.69;-->
<!--    font-size: 3px;-->
<!--    left: 8.2vw;-->
<!--    animation: fall-151 50s -3s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(151) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 1px #fff);-->
<!--  }-->
<!--  @keyframes fall-151 {-->
<!--    7.6666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 12.4vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(152) {-->
<!--    opacity: 0.43;-->
<!--    font-size: 6px;-->
<!--    left: 61.2vw;-->
<!--    animation: fall-152 10s -33s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(152) span {-->
<!--    animation: spin 12s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 1px #fff);-->
<!--  }-->
<!--  @keyframes fall-152 {-->
<!--    5% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 98.9vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(153) {-->
<!--    opacity: 0.61;-->
<!--    font-size: 9px;-->
<!--    left: 21.2vw;-->
<!--    animation: fall-153 40s -22.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(153) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-153 {-->
<!--    2.3333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 27.6vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(154) {-->
<!--    opacity: 0.57;-->
<!--    font-size: 15px;-->
<!--    left: 77.8vw;-->
<!--    animation: fall-154 40s -34.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(154) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 3px #fff);-->
<!--  }-->
<!--  @keyframes fall-154 {-->
<!--    5.3333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 74.6vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(155) {-->
<!--    opacity: 0.81;-->
<!--    font-size: 15px;-->
<!--    left: 28.6vw;-->
<!--    animation: fall-155 30s -33s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(155) span {-->
<!--    animation: spin 9s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-155 {-->
<!--    6.5% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 109.7vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(156) {-->
<!--    opacity: 0.64;-->
<!--    font-size: 9px;-->
<!--    left: 115.7vw;-->
<!--    animation: fall-156 30s -33s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(156) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-156 {-->
<!--    8% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 28.6vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(157) {-->
<!--    opacity: 0.23;-->
<!--    font-size: 6px;-->
<!--    left: 72.7vw;-->
<!--    animation: fall-157 30s -25.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(157) span {-->
<!--    animation: spin 12s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-157 {-->
<!--    4.6666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 1.6vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(158) {-->
<!--    opacity: 0.83;-->
<!--    font-size: 9px;-->
<!--    left: 35vw;-->
<!--    animation: fall-158 40s -27s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(158) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 1px #fff);-->
<!--  }-->
<!--  @keyframes fall-158 {-->
<!--    3.5% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 87vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(159) {-->
<!--    opacity: 0.13;-->
<!--    font-size: 3px;-->
<!--    left: 10.1vw;-->
<!--    animation: fall-159 50s -37.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(159) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 3px #fff);-->
<!--  }-->
<!--  @keyframes fall-159 {-->
<!--    5.6666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 113.4vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(160) {-->
<!--    opacity: 0.6;-->
<!--    font-size: 12px;-->
<!--    left: 100.1vw;-->
<!--    animation: fall-160 10s -27s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(160) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-160 {-->
<!--    2.5% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 9.9vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(161) {-->
<!--    opacity: 0.33;-->
<!--    font-size: 15px;-->
<!--    left: 71vw;-->
<!--    animation: fall-161 40s -37.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(161) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-161 {-->
<!--    4.8333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 22.8vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(162) {-->
<!--    opacity: 0.6;-->
<!--    font-size: 9px;-->
<!--    left: 51.3vw;-->
<!--    animation: fall-162 10s -30s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(162) span {-->
<!--    animation: spin 9s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 1px #fff);-->
<!--  }-->
<!--  @keyframes fall-162 {-->
<!--    2.1666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 112.7vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(163) {-->
<!--    opacity: 0.42;-->
<!--    font-size: 9px;-->
<!--    left: 106.4vw;-->
<!--    animation: fall-163 10s -9s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(163) span {-->
<!--    animation: spin 12s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-163 {-->
<!--    2.5% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 42.9vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(164) {-->
<!--    opacity: 0.09;-->
<!--    font-size: 12px;-->
<!--    left: 72.7vw;-->
<!--    animation: fall-164 30s -34.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(164) span {-->
<!--    animation: spin 12s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-164 {-->
<!--    1.8333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 106.9vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(165) {-->
<!--    opacity: 0.13;-->
<!--    font-size: 6px;-->
<!--    left: 66vw;-->
<!--    animation: fall-165 20s -25.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(165) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-165 {-->
<!--    4.5% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 108vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(166) {-->
<!--    opacity: 0.72;-->
<!--    font-size: 6px;-->
<!--    left: 35.3vw;-->
<!--    animation: fall-166 10s -6s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(166) span {-->
<!--    animation: spin 9s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-166 {-->
<!--    0.8333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 110.1vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(167) {-->
<!--    opacity: 0.68;-->
<!--    font-size: 9px;-->
<!--    left: 27vw;-->
<!--    animation: fall-167 30s -9s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(167) span {-->
<!--    animation: spin 3s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 3px #fff);-->
<!--  }-->
<!--  @keyframes fall-167 {-->
<!--    6% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 63.8vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(168) {-->
<!--    opacity: 0.27;-->
<!--    font-size: 15px;-->
<!--    left: 50.9vw;-->
<!--    animation: fall-168 10s -1.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(168) span {-->
<!--    animation: spin 9s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-168 {-->
<!--    5.5% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 87.7vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(169) {-->
<!--    opacity: 0.46;-->
<!--    font-size: 6px;-->
<!--    left: 86vw;-->
<!--    animation: fall-169 30s -6s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(169) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-169 {-->
<!--    7.1666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 25.4vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(170) {-->
<!--    opacity: 0.7;-->
<!--    font-size: 15px;-->
<!--    left: 47.2vw;-->
<!--    animation: fall-170 50s -22.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(170) span {-->
<!--    animation: spin 12s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-170 {-->
<!--    3.1666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 56.1vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(171) {-->
<!--    opacity: 0.18;-->
<!--    font-size: 3px;-->
<!--    left: 80.8vw;-->
<!--    animation: fall-171 30s -37.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(171) span {-->
<!--    animation: spin 12s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-171 {-->
<!--    0.1666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 45.5vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(172) {-->
<!--    opacity: 0.74;-->
<!--    font-size: 3px;-->
<!--    left: 63.8vw;-->
<!--    animation: fall-172 20s -34.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(172) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-172 {-->
<!--    7.6666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 47.2vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(173) {-->
<!--    opacity: 0.21;-->
<!--    font-size: 6px;-->
<!--    left: 54.8vw;-->
<!--    animation: fall-173 10s -27s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(173) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 3px #fff);-->
<!--  }-->
<!--  @keyframes fall-173 {-->
<!--    1% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 47vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(174) {-->
<!--    opacity: 0.37;-->
<!--    font-size: 15px;-->
<!--    left: 44.7vw;-->
<!--    animation: fall-174 40s -12s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(174) span {-->
<!--    animation: spin 3s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-174 {-->
<!--    0.1666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 114.2vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(175) {-->
<!--    opacity: 0.86;-->
<!--    font-size: 3px;-->
<!--    left: 37.1vw;-->
<!--    animation: fall-175 50s -27s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(175) span {-->
<!--    animation: spin 3s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-175 {-->
<!--    5.5% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 19.3vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(176) {-->
<!--    opacity: 0.29;-->
<!--    font-size: 9px;-->
<!--    left: 24.3vw;-->
<!--    animation: fall-176 50s -6s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(176) span {-->
<!--    animation: spin 3s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-176 {-->
<!--    2.5% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 12.3vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(177) {-->
<!--    opacity: 0.25;-->
<!--    font-size: 9px;-->
<!--    left: 114.7vw;-->
<!--    animation: fall-177 10s -12s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(177) span {-->
<!--    animation: spin 3s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-177 {-->
<!--    1.5% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 34.4vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(178) {-->
<!--    opacity: 0.33;-->
<!--    font-size: 15px;-->
<!--    left: 88.5vw;-->
<!--    animation: fall-178 10s -36s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(178) span {-->
<!--    animation: spin 3s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 3px #fff);-->
<!--  }-->
<!--  @keyframes fall-178 {-->
<!--    7.8333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 45.8vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(179) {-->
<!--    opacity: 0.04;-->
<!--    font-size: 6px;-->
<!--    left: 10.8vw;-->
<!--    animation: fall-179 30s -31.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(179) span {-->
<!--    animation: spin 9s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-179 {-->
<!--    5% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 22.9vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(180) {-->
<!--    opacity: 0.39;-->
<!--    font-size: 3px;-->
<!--    left: 67vw;-->
<!--    animation: fall-180 50s -13.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(180) span {-->
<!--    animation: spin 3s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-180 {-->
<!--    0.3333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 90.9vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(181) {-->
<!--    opacity: 0.41;-->
<!--    font-size: 9px;-->
<!--    left: 14.4vw;-->
<!--    animation: fall-181 30s -37.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(181) span {-->
<!--    animation: spin 12s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-181 {-->
<!--    7% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 3.5vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(182) {-->
<!--    opacity: 0.2;-->
<!--    font-size: 9px;-->
<!--    left: 45.4vw;-->
<!--    animation: fall-182 40s -18s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(182) span {-->
<!--    animation: spin 3s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-182 {-->
<!--    6.5% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 39.3vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(183) {-->
<!--    opacity: 0.48;-->
<!--    font-size: 15px;-->
<!--    left: 88.2vw;-->
<!--    animation: fall-183 20s -25.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(183) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-183 {-->
<!--    1.3333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 46.7vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(184) {-->
<!--    opacity: 0.8;-->
<!--    font-size: 6px;-->
<!--    left: 99.4vw;-->
<!--    animation: fall-184 30s -9s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(184) span {-->
<!--    animation: spin 3s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-184 {-->
<!--    1.5% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 45.2vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(185) {-->
<!--    opacity: 0.64;-->
<!--    font-size: 3px;-->
<!--    left: 67.4vw;-->
<!--    animation: fall-185 40s -33s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(185) span {-->
<!--    animation: spin 3s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-185 {-->
<!--    0.1666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 33.6vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(186) {-->
<!--    opacity: 0.36;-->
<!--    font-size: 6px;-->
<!--    left: 92.2vw;-->
<!--    animation: fall-186 40s -21s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(186) span {-->
<!--    animation: spin 12s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-186 {-->
<!--    6.1666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 76.4vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(187) {-->
<!--    opacity: 0.75;-->
<!--    font-size: 15px;-->
<!--    left: 116.6vw;-->
<!--    animation: fall-187 40s -33s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(187) span {-->
<!--    animation: spin 9s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-187 {-->
<!--    4.8333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 118.6vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(188) {-->
<!--    opacity: 0.74;-->
<!--    font-size: 15px;-->
<!--    left: 9.7vw;-->
<!--    animation: fall-188 20s -4.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(188) span {-->
<!--    animation: spin 9s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-188 {-->
<!--    1.3333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 54.5vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(189) {-->
<!--    opacity: 0.41;-->
<!--    font-size: 6px;-->
<!--    left: 34.4vw;-->
<!--    animation: fall-189 30s -16.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(189) span {-->
<!--    animation: spin 9s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 1px #fff);-->
<!--  }-->
<!--  @keyframes fall-189 {-->
<!--    0.6666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 85.1vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(190) {-->
<!--    opacity: 0.45;-->
<!--    font-size: 9px;-->
<!--    left: 86.3vw;-->
<!--    animation: fall-190 10s -9s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(190) span {-->
<!--    animation: spin 12s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-190 {-->
<!--    2.6666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 28.6vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(191) {-->
<!--    opacity: 0.5;-->
<!--    font-size: 3px;-->
<!--    left: 102.6vw;-->
<!--    animation: fall-191 50s -30s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(191) span {-->
<!--    animation: spin 9s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 3px #fff);-->
<!--  }-->
<!--  @keyframes fall-191 {-->
<!--    2.1666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 90.6vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(192) {-->
<!--    opacity: 0.21;-->
<!--    font-size: 12px;-->
<!--    left: 90.4vw;-->
<!--    animation: fall-192 40s -37.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(192) span {-->
<!--    animation: spin 9s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 1px #fff);-->
<!--  }-->
<!--  @keyframes fall-192 {-->
<!--    5.3333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 100.9vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(193) {-->
<!--    opacity: 0.02;-->
<!--    font-size: 9px;-->
<!--    left: 14.9vw;-->
<!--    animation: fall-193 30s -4.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(193) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-193 {-->
<!--    5.6666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 58.4vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(194) {-->
<!--    opacity: 0.07;-->
<!--    font-size: 6px;-->
<!--    left: 55.7vw;-->
<!--    animation: fall-194 30s -36s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(194) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-194 {-->
<!--    2.3333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 29.2vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(195) {-->
<!--    opacity: 0.13;-->
<!--    font-size: 12px;-->
<!--    left: 110.9vw;-->
<!--    animation: fall-195 40s -10.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(195) span {-->
<!--    animation: spin 12s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 4px #fff);-->
<!--  }-->
<!--  @keyframes fall-195 {-->
<!--    4.8333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 81vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(196) {-->
<!--    opacity: 0.3;-->
<!--    font-size: 3px;-->
<!--    left: 9.7vw;-->
<!--    animation: fall-196 40s -3s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(196) span {-->
<!--    animation: spin 12s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-196 {-->
<!--    7.1666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 72.9vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(197) {-->
<!--    opacity: 0.46;-->
<!--    font-size: 12px;-->
<!--    left: 14.5vw;-->
<!--    animation: fall-197 10s -31.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(197) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-197 {-->
<!--    5% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 47.2vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(198) {-->
<!--    opacity: 0.59;-->
<!--    font-size: 15px;-->
<!--    left: 73.6vw;-->
<!--    animation: fall-198 30s -33s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(198) span {-->
<!--    animation: spin 15s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 1px #fff);-->
<!--  }-->
<!--  @keyframes fall-198 {-->
<!--    2.8333333333% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 13.6vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(199) {-->
<!--    opacity: 0.69;-->
<!--    font-size: 9px;-->
<!--    left: 56.9vw;-->
<!--    animation: fall-199 10s -31.5s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(199) span {-->
<!--    animation: spin 6s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 5px #fff);-->
<!--  }-->
<!--  @keyframes fall-199 {-->
<!--    0.5% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 21vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake:nth-child(200) {-->
<!--    opacity: 0.65;-->
<!--    font-size: 3px;-->
<!--    left: 26.3vw;-->
<!--    animation: fall-200 40s -9s ease-in infinite;-->
<!--  }-->
<!--  .snowflake:nth-child(200) span {-->
<!--    animation: spin 3s linear 0s infinite;-->
<!--    filter: drop-shadow(0 0 2px #fff);-->
<!--  }-->
<!--  @keyframes fall-200 {-->
<!--    5.1666666667% {-->
<!--      transform: rotate(90deg) translateX(0);-->
<!--    }-->
<!--    to {-->
<!--      transform: rotate(90deg) translateX(calc(100vh + 5vmin));-->
<!--      left: 54.1vw;-->
<!--    }-->
<!--  }-->
<!--  .snowflake span {-->
<!--    display: block;-->
<!--    color: #fff;-->
<!--  }-->
<!--  .snowflake span:before {-->
<!--    content: "❄";-->
<!--  }-->
<!--  .snowflake:nth-child(3n+2) span:before {-->
<!--    content: "❅";-->
<!--  }-->
<!--  .snowflake:nth-child(3n+3) span:before {-->
<!--    content: "❇";-->
<!--  }-->
<!---->
<!--  @keyframes spin {-->
<!--    0% {-->
<!--      transform: rotate(0deg);-->
<!--    }-->
<!--    100% {-->
<!--      transform: rotate(360deg);-->
<!--    }-->
<!--  }-->
<!--</style>-->
<!---->
<!--   <div class="snow-wrap">-->
<!--     <div class="snow">-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--       <div class="snowflake"> <span> </span></div>-->
<!--     </div>-->
<!--   </div>-->
<!---->
