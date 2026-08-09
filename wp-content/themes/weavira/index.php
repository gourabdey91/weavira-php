<!doctype html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="theme-color" content="#26a85d">

  <?php wp_head(); ?>
</head>

<body <?php body_class('inner'); ?>>
  <?php wp_body_open(); ?>
  <?php do_action('get_header'); ?>
  <?php echo view(app('sage.view'), app('sage.data'))->render(); ?>
  <?php do_action('get_footer'); ?>
  <?php wp_footer(); ?>
</body>

</html>