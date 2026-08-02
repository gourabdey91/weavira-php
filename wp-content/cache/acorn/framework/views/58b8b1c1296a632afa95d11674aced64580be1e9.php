<?php $__env->startSection('content'); ?>
    <?php if(!have_posts()): ?>
        <section class="wild-wedding-section mb-0 pb-0">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 bg-1 bdr-30 position-relative">
                        <div class="row  justify-content-center">
                            <div class="col-lg-7">
                                <div class="p-4 p-lg-5" data-aos="fade-down">
                                    <h1 class="text-center"><?php echo get_field('arc_options_404_sub_page_heading', 'option'); ?></h1>
                                    <?php if(get_field('arc_options_404_page_heading', 'option')): ?>
                                        <h2 class="text-center title mb-lg-5 mb-4"><?php echo get_field('arc_options_404_page_heading', 'option'); ?></h2>
                                    <?php endif; ?>
                                    <?php echo get_field('arc_options_404_page_heading_details', 'option'); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u908449413/domains/weavira.com/public_html/wp-content/themes/weavira/resources/views/404.blade.php ENDPATH**/ ?>