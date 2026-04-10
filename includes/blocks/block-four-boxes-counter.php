<?php $section = get_field('four_box-count'); if (empty($section['disable_section'])): ?>
<section class="four__boxes-counter" aria-label="Counter Box Number">
    <div class="container">
        <?php render_section_header($section); ?>
        <div class="row">
            <div class="box col-lg-3 col-sm-3">
                <div class="box__wrap">
                    <div class="countdown" data-target="<?php echo ( get_field('four_box-count')['title1'] );?>"></div>
                    <p><?php echo ( get_field('four_box-count')['sub1'] );?></p>
                </div>
            </div>
            <div class="box col-lg-3 col-sm-3">
                <div class="box__wrap">
                    <div class="countdown" data-target="<?php echo ( get_field('four_box-count')['title2'] );?>"></div>
                    <p><?php echo ( get_field('four_box-count')['sub2'] );?></p>
                </div>
            </div>
            <div class="box col-lg-3 col-sm-3">
                <div class="box__wrap">
                    <div class="countdown" data-target="<?php echo ( get_field('four_box-count')['title3'] );?>"></div>
                    <p><?php echo ( get_field('four_box-count')['sub3'] );?></p>
                </div>
            </div>
            <div class="box col-lg-3 col-sm-3">
                <div class="box__wrap">
                    <div class="countdown" data-target="<?php echo ( get_field('four_box-count')['title4'] );?>"></div>
                    <p><?php echo ( get_field('four_box-count')['sub4'] );?></p>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Get all elements with the class 'countdown'
    var countdowns = document.querySelectorAll('.countdown');

    // Function to update the countdown for each element
    function updateCountdown(element) {
        var target = parseInt(element.getAttribute('data-target'), 10);
        var current = 0;

        var intervalId = setInterval(function() {
            // Increment the current value
            current++;

            // Update the content of the element with a "+" after the number
            element.textContent = current + "+";

            // Check if we have reached the target
            if (current === target) {
                clearInterval(intervalId);
            }
        }, 20); // Adjust the interval as needed
    }

    // Loop through each countdown element and update it
    countdowns.forEach(function(countdownElement) {
        updateCountdown(countdownElement);
    });
});
</script>