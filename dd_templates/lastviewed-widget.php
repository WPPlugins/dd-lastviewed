<?php
$vars_widget = $this->widget_vars;

$widgetID = $vars_widget['widgetID'];
$before_widget = $vars_widget['before_widget'];
$after_widget = $vars_widget['after_widget'];
$before_title = $vars_widget['before_title'];
$after_title = $vars_widget['after_title'];

$widget_title = $vars_widget['widget_title'];
$post_query = $vars_widget['post_query'];

$title = $vars_widget['title'];
$title_active = $title['active'];
$title_is_link = $title['is_link'];

$thumb = $vars_widget['thumb'];
$thumb_active = $thumb['active'];
$thumb_is_link = $thumb['is_link'];
$thumb_size = $thumb['size'];

$content = $vars_widget['content'];
$content_active = $content['active'];
$content_type = $content['type'];
$content_is_link = $content['is_link'];
$more_active = $content['more_active'];
$more_title = $content['more_title'];

$no_settings_set = !$title_active && !$content_active && !$thumb_active;

if ($post_query->have_posts()) :

    echo $before_widget;

    if ($widget_title) : echo $before_title . $widget_title . $after_title; endif;

    if ($no_settings_set): ?>
        <p>No options set yet! Set the options in the <a
                href="<?php echo esc_url(home_url('/wp-admin/widgets.php')); ?>">widget</a>.</p>
    <?php endif; ?>

    <ul class="lastViewedList">
        <?php while ($post_query->have_posts()) : $post_query->the_post();

            $id = get_the_ID();
            $title = get_the_title();
            $content = $this->contentfilter($id);
            
            $thumb = get_the_post_thumbnail($id, $thumb_size);
            $hasThumb = $thumb_active && has_post_thumbnail() ? $thumb_active : false;
            $perma = get_permalink();
            $class = $hasThumb ? "lastViewedItem clearfix" : "lastViewedItem";

            ?>
            <li class="<?php echo $class; ?>">
                <?php if ($hasThumb && !$thumb_is_link): ?>
                    <div class="lastViewedThumb"><?php echo $thumb; ?></div>
                <?php elseif ($hasThumb && $thumb_is_link) : ?>
                    <a class="lastViewedThumb" href="<?php echo $perma; ?>"><?php echo $thumb; ?></a>
                <?php endif; ?>

                <div class="lastViewedcontent">
                    <?php if ($title_active && $title_is_link) : ?>
                        <a class="lastViewedTitle" href="<?php echo $perma; ?>"><?php echo $title; ?></a>
                    <?php elseif ($title_active && !$title_is_link) : ?>
                        <h3 class="lastViewedTitle"><?php echo $title; ?></h3>
                    <?php endif; ?>

                    <?php if ($content_is_link && $content_active) : ?>
                        <a href="<?php echo $perma; ?>" class="lastViewedExcerpt">
                            <div>
                                <?php echo $content; ?>
                                <?php if ($more_active) : ?>
                                    <span class="more"><?php echo $more_title; ?></span>
                                <?php endif; ?>
                            </div>
                        </a>
                    <?php elseif (!$content_is_link && $content_active) : ?>
                        <div class='lastViewedExcerpt'>
                            <?php echo $content; ?>
                            <?php if ($more_active) : ?>
                                <a href="<?php echo $perma; ?>"
                                   class="more"><?php echo $more_title; ?></a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </li>
        <?php endwhile; ?>
    </ul>
    <?php echo $after_widget; ?>
<?php endif; ?>