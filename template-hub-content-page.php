<?php
/*
Template Name: Hub content page
*/
?>

<?php get_header(); ?>

<?php get_template_part( 'part', 'breadcrumbs' ); 
?>

<div class="wrap">

  <?php get_sidebar('nav'); ?>

  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <section class="main">
      <h1><?php the_title(); ?></h1>
   <?php if (has_post_thumbnail()) : ?>
        <div style="text-align:center;">
          <?php the_post_thumbnail('full'); ?>
        </div>
      <?php endif; ?>
          <?php the_content(); ?>
	
        

  
  
    </section>
  <?php endwhile; endif; ?>

  <?php get_sidebar(); ?>

</div>
	
<?php if (get_field('upcoming_events')) : ?>
  <?php $events = hub_feed(get_field('upcoming_events'), '3', 'events'); ?>
  <?php if ($events) : ?>
    <section class="feed">
      <div class="wrap">
        <hr>
        <h2 class="heading--serif heading--centered">Upcoming Election Events</h2>
        <ul>
          <?php foreach ($events as $event) : ?>
            <li>
              <div class="feed__item">
                <a class="feed__icon icon-button icon-button--hub" href="http://hub.jhu.edu/"><span>HUB</span></a>
                <p class="feed__date"><?php echo date('F j, Y', strtotime($event->start_date)); ?></p>
                <h3><?php echo $event->name; ?></h3>
                <p class="feed__more"><a href="<?php echo $event->url; ?>">Read More...</a></p>
              </div>
            </li>
          <?php endforeach; ?>
        </ul>
		<a class="button button--blue"" href="http://hub.jhu.edu/<?php if (get_field('see_more_events')) : the_field('see_more_events'); endif; ?>" style="display: block; margin: 0 auto 2rem auto; width:22%; text-align:center; min-width:180px;">View All Upcoming Events</a>
		      </div>
			  
    </section>
 
  <?php endif; ?>
<?php endif; ?>

<section class="feed feed--gray" id="news-announcements">
  <div class="wrap">
    <hr class="hr--transparent">
    <h2 class="heading--serif heading--centered">Election News</h2>
    <ul>
      <?php $query = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => '9', 'category__not_in' => array(get_category_by_slug('archived')->term_id),  'category__in' => array(1,3) ) ); ?>
      <?php $count = $query->post_count; $hub_count = 9 - $count; ?>
     
      <?php wp_reset_postdata(); ?>
      <?php if (get_field('news_&_announcements') && $hub_count > 0) : ?>
        <?php $news = hub_feed(get_field('news_&_announcements'), '3', 'articles'); ?>
        <?php if ($news) : ?>
          <?php $hub_items = 0; ?>
          <?php foreach ($news as $article) : ?>
            <?php if ($hub_items < $hub_count) : ?>
            <?php $image = $article->_embedded->image_thumbnail; ?>
              <li>
                <div class="feed__item <?php if ($image !== null) { echo 'feed__item--media'; } else { echo 'feed__item--gray'; }; ?>">
                  <a class="feed__icon icon-button icon-button--hub" href="http://hub.jhu.edu/"><span>HUB</span></a>
                  <?php if ($image !== null) : ?>
                    <div class="feed__image" style="background-image: url(<?php echo $article->_embedded->image_thumbnail[0]->sizes->landscape; ?>);"></div>
                  <?php endif; ?>
                  <div class="feed__item__content">
                    <h4><?php echo $article->alt_headline; ?></h4>
                    <p><?php echo $article->excerpt; ?></p>
                    <p class="feed__more"><a href="<?php echo $article->url; ?>">Read More...</a></p>
                  </div>
                </div>
              </li>
              <?php $hub_items++; ?>
          <?php endif; ?>
          <?php endforeach; ?>
        <?php endif; ?>
      <?php endif; ?>
    </ul>
	<a class="button button--blue"" href="http://hub.jhu.edu/<?php if (get_field('news_&_announcements')) : the_field('news_&_announcements'); endif; ?>" style="display: block; margin: 0 auto 2rem auto; width:22%; text-align:center; min-width:180px;">View All Articles</a>
  </div>
</section>

<?php get_template_part( 'part', 'related-links' ); ?>

<?php get_template_part( 'part', 'resource-finder' ); ?>

<?php get_footer(); ?>