<div class="custom-slider">
  <?php
  $slider_query = new WP_Query(array(
    'post_type'         => 'post',
    'posts_per_page'    => 3,
  ));

  if ($slider_query->have_posts()) :
  ?>
    <div class="slider-content">
      <?php
      while ($slider_query->have_posts()) : $slider_query->the_post();
      ?>
        <div class="slide">
          <h2 class="slide-title" ><a href="<?php the_permalink(); ?>" ><?php the_title(); ?></a></h2>
          <p class="slide-content"><?php the_excerpt(); ?></p>
          <div class="slider-bottom">
            <a href="<?php the_permalink(); ?>" class="slide-button">Saber Mais</a>
      <?php
      echo '<div class= "slide-bullets"> ';
      for ($i = 1; $i <= $slider_query->post_count; $i++) {
        $dataIndex = $i -1;
        echo '<span data-index =' . $dataIndex . ' class="slider-bullet">' .$i. '</span>';
      }
      echo '</div>';
      ?>
    </div>
        </div>
      <?php
      endwhile;
      wp_reset_postdata();
      ?>
    </div>

  <?php
  endif;
  ?>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/custom-slider/slider.js"></script>
