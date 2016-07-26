<?php get_header(); ?>
    <main class="main">
      <section class="page-content">
        <div class="grid">
          <?php wp_reset_query(); the_content(); ?>
        </div>
      </section>
    </div>
<?php get_footer(); ?>
