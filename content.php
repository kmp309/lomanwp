<?php
global $kippis_is_smartphone;
global $kippis_options;
global $kippis_the_first_post;
?>
        <article>
          <div id="post-<?php the_ID(); ?>" <?php post_class('article'); ?>>
            <header class="entry-header">
              <?php
              if (is_sticky()) {
                ?>
                <hgroup>
                  <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s','kippis'),the_title_attribute('echo=0')); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                  <h3 class="entry-format"><?php _e('Featured','kippis'); ?></h3>
                </hgroup>
                <?php
              }
              else {
                ?>
                <h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s','kippis'),the_title_attribute( 'echo=0')); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
                <?php
              }
              ?>
              <?php if ('post' == get_post_type()) : ?>
                <div class="entry-meta">
                  <?php kippis_posted_on(); ?>
                </div><!-- .entry-meta -->
              <?php endif; ?>
              <?php if (comments_open() && !post_password_required()) : ?>
                <?php /* if (!$kippis_is_smartphone) { */ ?>
                <?php if (false) { ?>
                  <div class="comments-link">
                    <?php comments_popup_link('<span class="leave-reply">' . __('Reply','kippis') . '</span>',_x('1','comments number','kippis'),_x('%','comments number','kippis')); ?>
                  </div>
                <?php } ?>
              <?php endif; ?>
            </header><!-- .entry-header -->

            <div class="entry-content">
              <?php
                $show_the_excerpt = $kippis_is_smartphone;
                if (!$show_the_excerpt) {
                  if (($wp_query->is_archive == '1') && ($wp_query->is_author != '1')) {
                    $show_the_excerpt = $kippis_options['kippis_excerpt_archive_enable'] == 'on';
                  }
                  else if (get_post_type() == 'post') {
                    $show_the_excerpt = $kippis_options['kippis_excerpt_posts_enable'] == 'on';
                    if ($show_the_excerpt && $kippis_the_first_post) {
                      if ($kippis_options['kippis_excerpt_firstpost_disable'] == 'on') {
                        $show_the_excerpt = false;
                      }
                    }
                  }
                }
                if ($show_the_excerpt) {
                  if (has_post_thumbnail()) {
                    echo '<a href="'. get_permalink($post->ID) . '">';
                    the_post_thumbnail('pic-icon');
                    echo '</a>';
                  }
                  the_excerpt();
                }
                else the_content(__('Continue reading <span class="meta-nav">&rarr;</span>','kippis'));
                if (is_page()) {
                  if ($kippis_options['kippis_parent_child_links_enable'] == 'on') {
                    if ($post->post_parent) $children = wp_list_pages(array('title_li' => 'kippis_tmp','child_of' => $post->post_parent,'echo' => 0));
                    else                    $children = wp_list_pages(array('title_li' => 'kippis_tmp','child_of' => $post->ID         ,'echo' => 0));
                    if ($children) {
                      echo str_replace('kippis_tmp','<a href="' . get_permalink($post->post_parent) . '">' . get_the_title($post->post_parent) . '</a>',$children);
                    }
                  }
                }
              ?>
              <?php wp_link_pages(array('before' => '<div class="page-link"><span>' . __('Pages:','kippis') . '</span>','after' => '</div>')); ?>
            </div><!-- .entry-content -->

            <footer class="entry-meta">
            <?php
              if (!$kippis_is_smartphone) {
                if ('post' == get_post_type()) {
                  if ($kippis_options['kippis_posts_cats_tags_enable'] == 'on') {
                    $categories_list = get_the_category_list(__(', ','kippis'));  // There is a space after the comma (used between list items).
                    if ($categories_list) {
                      echo '<div class="cat-links">';
                      printf(__('<span class="%1$s">Posted in</span> %2$s','kippis'),'entry-utility-prep entry-utility-prep-cat-links',$categories_list);
                      echo '</div>';
                    }
                    $tags_list = get_the_tag_list('',__(', ','kippis'));  // There is a space after the comma (used between list items).
                    if ($tags_list) {
                      echo '<div class="tag-links">';
                      printf( __('<span class="%1$s">Tagged</span> %2$s','kippis'),'entry-utility-prep entry-utility-prep-tag-links',$tags_list);
                      echo '</div>';
                    }
                  }
                }
                if (comments_open()) {
                  echo '<div class="comments-link">';
                  comments_popup_link('<span class="leave-reply">' . __('Leave a reply','kippis') . '</span>',__('<b>1</b> Reply','kippis'),__('<b>%</b> Replies','kippis'));
                  echo '</div>';
                }
                edit_post_link(__('Edit','kippis'),'<span class="edit-link">','</span>');
              }
            ?>
            </footer><!-- #entry-meta -->

          </div><!-- article - #post-<?php the_ID(); ?> -->
        </article>
