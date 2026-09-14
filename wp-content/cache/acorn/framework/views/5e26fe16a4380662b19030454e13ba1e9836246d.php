<main class="myaccount-page page-shell">

  <nav class="wl-breadcrumb" aria-label="Breadcrumb">
    <a href="<?php echo e(home_url('/')); ?>">Home</a>
    <span aria-hidden="true">&rsaquo;</span>
    <span aria-current="page">My Account</span>
  </nav>

  <h1 class="myaccount-title">My Account</h1>

  <div class="myaccount-layout">
    <div class="myaccount-nav">
      <?php do_action('woocommerce_account_navigation'); ?>
    </div>
    <div class="myaccount-content woocommerce-MyAccount-content">
      <?php do_action('woocommerce_account_content'); ?>
    </div>
  </div>

</main>
<?php /**PATH /home/u908449413/domains/weavira.com/public_html/wp-content/themes/weavira/resources/views/woocommerce/myaccount/layout.blade.php ENDPATH**/ ?>