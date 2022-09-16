<!--ヘッダー-->
<?php get_header(); ?>

<!--メニュー-->
<?php get_template_part('content', 'menu'); ?>
<div id="main">

    <!-- blog_list -->
    <section id="blog_list" class="site-width">
        <h1 class="title">BLOG</h1>
        <div id="content" class="article">

            <!--記事のループ-->
            <?php get_template_part('loop'); ?>

            <?php if (function_exists("pagination")) pagination($wp_query->max_num_pages); ?>
        </div>
        <!--サイドバー-->
        <?php get_sidebar(); ?>

    </section>


</div>

<!--footer-->
<?php get_footer(); ?>
