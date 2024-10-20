<div class="container pt-5" id="counters">
    <div class="row text-center py-5">
        <div class="col-md-4">
            <div class="counter bg-primary text-white">
                <div class="number">
                    <?php if ( get_field('counters_1_number') ) : ?>
                        <?php echo get_field('counters_1_number'); ?>
                    <?php endif; ?>
                </div>
                <div class="title">
                    <?php if ( get_field('counters_1_title') ) : ?>
                        <?php echo get_field('counters_1_title'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="counter bg-secondary text-primary">
                <div class="number">
                    <?php if ( get_field('counters_2_number') ) : ?>
                        <?php echo get_field('counters_2_number'); ?>
                    <?php endif; ?>
                </div>
                <div class="title">
                    <?php if ( get_field('counters_2_title') ) : ?>
                        <?php echo get_field('counters_2_title'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="counter bg-primary text-white">
                <div class="number">
                    <?php if ( get_field('counters_3_number') ) : ?>
                        <?php echo get_field('counters_3_number'); ?>
                    <?php endif; ?>
                </div>
                <div class="title">
                    <?php if ( get_field('counters_3_title') ) : ?>
                        <?php echo get_field('counters_3_title'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>