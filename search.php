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
                               //POST CONTENT TO GO HERE SUCH AS EXCERPT FEATURED IMAGE ETC
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
