<?php
/**
 * The template for displaying category
 *
 * @author WebDorado
 * @package Ecommerce WD
 */

get_header(); ?>
<div id="primary">
  <div id="content" role="main">
    <article>
      <header class="entry-header"></header>
      <div class="entry-content">
      <?php wde_front_end(array('type' => 'categories', 'layout' => 'displaycategory')); ?>
      </div>
    </article>
  </div><!-- #content -->
  <?php
  if (locate_template('sidebar-content.php', TRUE, FALSE)) {
    get_sidebar('content');
  }
  ?>
</div><!-- #primary -->

<?php get_footer(); ?>