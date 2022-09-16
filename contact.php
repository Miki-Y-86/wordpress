<?php
//Template Name: contact 〜コンタクト
?>
<!--ヘッダー-->
<?php get_header(); ?>
    <!--メニュー-->
<?php get_template_part('content', 'menu'); ?>
    <!-- Contact -->
    <section id="contact" class="site-width">
        <h1 class="title"><?php echo get_the_title(); ?></h1>
        <?php if (have_posts()) : //WordPress ループ
            while (have_posts()) : the_post(); //繰り返し処理開始 ?>
                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <?php the_content(); ?>
                </div>
            <?php endwhile; //繰り返し処理終了
        else : //ここから記事が見つからなかった場合の処理 ?>
            <div class="post">
                <h2>記事はありません</h2>
                <p>お探しの記事は見つかりませんでした。</p>
            </div>
        <?php endif; //WordPress ループ終了 ?>
    </section>

<div id="main">
<!--Contact-->
    <section id="contact" class="site-width">
        <h1 class="title">お問合せ</h1>
        <form>
            <div class="form-group">
                <label>名前：任意<span class="help-block"></span>
                    <input type="text" name="name" class="valid-text">
                </label>
            </div>
            <div class="form-group">
                <label>E-mail: *必須<span class="help-block"></span>
                    <input type="text" name="email" class="valid-email">
                </label>
            </div>
            <div class="form-group">
                <label>内容：＊必須<span class="help-block"></span>
                    <textarea name="comment" class="valid-textarea" cols="1000" rows="10"></textarea>
                </label>
            </div>
            <input type="submit" name="submit" value="送信">
        </form>
    </section>

</div>

<!--フッター-->
<?php get_footer(); ?>
