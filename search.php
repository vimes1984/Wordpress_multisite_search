<?php
get_header();
?>
<div class="CDblog single"> 
    <div class="breadcrumbs">
        <?php
        if (function_exists('bcn_display')) {
            bcn_display();
        }
        ?>
    </div>
<?php
        $xpagenr = 1;
    if ($_GET['page'] != "")
        $xpagenr = $_GET['page'];
    $posts_per_page = get_option('posts_per_page');
    $fpagenr = ($xpagenr - 1) * $posts_per_page;
    $fposts_per_page = $xpagenr * $posts_per_page;

              $posts_per_page = get_option('posts_per_page');
                 $searchfor = get_search_query(); // Get the search query for display in a headline
                 $query_string=esc_attr($query_string); // Escaping search queries to eliminate potential MySQL-injections
                 $blogs = wp_get_sites( 0,'all' );
                 $notfound = true;
                 $current_blogid=get_current_blog_id();
                 $blogs_ordered = array($current_blogid);
 
        foreach ( $blogs as $blog ):
                if ($blog['blog_id']!=$blogs_ordered['0']){
                        $blogs_ordered[]=$blog['blog_id'];
                }
        endforeach;

        foreach ( $blogs_ordered as $blogid ):
                switch_to_blog($blogid);
                              $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                              $search = new WP_Query(array('s' => get_search_query(), 'posts_per_page' => $posts_per_page, 'paged' => $xpagenr));               

                  if ($search->found_posts>0) {
                         foreach ( $search->posts as $post ) {
                                setup_postdata($post);
                                $author_data = get_userdata(get_the_author_meta('ID'));
                                $currentblog = $post->site_ID;
                                switch_to_blog($currentblog);
                                $fwpicture = cd_post_picture(616, 296,NULL,NULL,true);
                                $npicture = cd_post_picture(null, null,NULL,NULL,true);
                                $cd_get_permalink = get_permalink($post->ID);
                                $postx = $post;
                                $blog_details = get_blog_details($post->site_ID);
                                $getpostinfo = get_post($post->ID);
                                $cd_opo_full_width = get_post_meta($post->ID, 'cd_opo_full_width', true);
                                $cd_opo_video = get_post_meta($post->ID, 'cd_opo_video', true);
                                if (strpos($cd_opo_video, 'youtu') > 0) {
                                    $cd_opo_video = youtube_id_from_url($cd_opo_video);
                                    $cd_opo_video = '<iframe width="600" height="338" src="http://www.youtube.com/embed/' . $cd_opo_video . '" frameborder="0" allowfullscreen></iframe>';
                                }

                                $CD_class = '';
                                if ($cd_opo_full_width == "on") {
                                    $CD_class = " full-width ";
                                }
                                $xclass = " " . get_blog_option($post->site_ID, 'cd_op_color') . " ";
                                ?>

                                <div class="post <?php echo $xclass . $CD_class; ?>">
                                    <h1 class="title"><a href="<?php echo $cd_get_permalink; ?>"><?php the_title(); ?></a></h1>
                                    <div class="meta-options">Postet i 
                                        <a href="<?php echo $blog_details->siteurl ?>" class="child-blog"><?php echo strtolower($blog_details->blogname); ?></a> 
                                        <?php echo get_the_date(); ?> av <?php echo cd_get_author($post); ?></div>
                                    <?php get_template_part('social'); ?>
                                    <?php
                                    if ($cd_opo_full_width == "on") {
                                        if ($cd_opo_video == "") {

                                            echo $fwpicture;
                                        }else
                                            echo $cd_opo_video;
                                    }
                                    ?>
                                    <?php
                                    if ($cd_opo_full_width == "") {
                                        if ($cd_opo_video == "") {
                                            cd_post_picture();
                                        }else
                                            echo $cd_opo_video;
                                    }
                                    ?>
                                    <div class="text">
                                        <p class="desc">
                                            <?php the_excerpt();?>
                                        </p>
                                        <div class="more"><a href="<?php echo $cd_get_permalink; ?>">FORTSETT Å LESE ></a></div>
                                    </div>

                                </div>
                                <?php
                                $post = $postx;
                                wp_reset_postdata();
                            }
                        }
                 wp_reset_postdata();
                 endforeach;
                 $page_links_total =  $search->max_num_pages; 
                if ($page_links_total>1) :
                $search->query_vars['paged'] > 1 ? $current = $search->query_vars['paged'] : $current = 1;

            ?>
           <div class="navigation">
                            
            <div class="nav">
                <div class="left">
                    <?php if ($current > 1) { ?>
                        <a href="<?php echo get_site_url(1) . "/?s=" . get_search_query() . '&page=' . ($current - 1); ?>">< FORRIGE</a>
                <?php  } ?>
                </div>
            <div class='center'>Side <?php echo "$current/$page_links_total"; ?></div> 
                <div class="right">
                        <a href="<?php echo get_site_url(1) . "/?s=" . get_search_query() . '&page=' . ($current + 1); ?>">NESTE ></a>
                </div>
            </div>
        </div>

        <?php
        endif;   
?>
</div>
<?php
switch_to_blog(1);
get_sidebar();
?>
</div>
<?php
get_footer();
?>