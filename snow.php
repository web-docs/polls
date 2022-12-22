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
  .background.active {
    overflow: hidden !important;
    background: #000000ba !important;
    z-index: 10;
    position: fixed;
  }
  .background.active .snow-canvas {
    display: none;
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
