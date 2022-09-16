<?php
//カスタムヘッダー画像の設置
$custom_header_defaults = array(
    'default-image' => get_bloginfo('template_url').'/img1/logo.jpeg',
    'header-text' => false, //ヘッダー画像上にテキストをかぶせる
);
//カスタムヘッダー機能を有効にする
add_theme_support( 'custom-header', $custom_header_defaults );

//カスタムメニュー使用
register_nav_menu('mainmenu', 'メインメニュー');

//ページネーション
function pagination($pages = '', $range = 2)
{
    $showitems = ($range * 2) + 1; //表示するページ数（５ページを表示）

    global $paged; //現在のページ値
    if (empty($paged)) $paged = 1; //デフォルトのページ

    if ($pages == '') {
        global $wp_query;
        $pages = $wp_query->max_num_pages; //全ページ数を取得
        if (!$pages) //全ページ数が空の場合は、１とする
        {
            $pages = 1;
        }
    }

    if (1 != $pages) //全ページが１出ない場合はページネーションを表示する
    {
        echo "<div class=\"pagenation\">\n";
        echo "<ul>\n";
        //Prev 現在のページ値が１より大きい場合は表示
        if ($paged > 1) echo "<li class=\"prev\"><a href='" . get_pagenum_link($paged - 1) . "'>Prev</a></li>\n";

        for ($i = 1; $i <= $pages; $i++) {
            if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems)) {
                //三項演算子での条件分岐
                echo ($paged == $i) ? "<li class=\"active\">" . $i . "</li>\n" : "<li><a href='" . get_pagenum_link($i) . "'>" . $i . "</a></li>\n";
            }
        }
//Next 総ページ数より現在のページ数が小さい場合は表示
        if ($paged < $pages) echo "<li class=\"next\"><a href=\"" . get_pagenum_link($paged + 1) . "\">Next</a></li>\n";
        echo "</ul>\n";
        echo "</div>\n";
    }
}
//================================
// カスタムフィールド
//================================
//投稿ページへ表示するカスタムボックスを定義する。第二引数はこれから使う適当な関数、第一引数は必ずこれになる
add_action('admin_menu', 'add_custom_inputbox');
//追加した表示項目のデータ更新・保存のためのアクションフック
add_action('save_post', 'save_custom_postdata');

//入力項目がどの投稿タイプのページに表示されるのかの設定
function add_custom_inputbox() {
    //第一引数：編集画面のhtmlに挿入されるid属性
    //第二引数：管理画面に表示されるカスタムフィールド名
    //第三引数：メタボックスの中に出力される関数名
    //第四引数：管理画面に表示するカスタムフィールドの場所(postなら投稿、pageなら固定ページ）
    //第五引数：配置される順序
    add_meta_box( 'about_id','ABOUT入力欄', 'custom_area', 'page', 'normal' );
    add_meta_box( 'recruit_id','RECRUIT入力欄', 'custom_area2', 'page', 'normal' );
    add_meta_box( 'map_id','map入力欄','custom_area3','page', 'normal');
}

//管理画面に表示される内容
function custom_area(){
    global $post;

    echo 'コメント :<textarea cols="50" rows="5" name="about_msg">'.get_post_meta($post->ID,'about',true).'</textarea><br>';
}
function custom_area2(){
    global $post;

    echo '<table>';
    for($i = 1; $i <= 8 ; $i++){
        echo '<tr><td>info'.$i.':</td><td><input cols="50" rows="5" name="recruit_info'.$i.'" value="'.get_post_meta($post->ID,'recruit_info'.$i,true).'"</td></tr>';
    }
    echo '</table>';
}
function custom_area3(){
    global $post;

    echo 'マップ :<textarea cols="50" rows="5" name="about_msg">'.get_post_meta($post->ID,'map',true).'</textarea><br>';
}
//投稿ボタンを押した際のデータ更新と保存
function save_custom_postdata($post_id){
    $about_msg = '';
    $recruit_data = '';
    $map = '';

    //カスタムフィールドに入力された情報を取り出す
    if(isset($_POST['about_msg'])){
        $about_msg = $_POST['about_msg'];
    }

    //内容が変わっていた場合、保存していた情報を更新する
    if( $about_msg != get_post_meta($post_id, 'about', true)){
        update_post_meta($post_id, 'about',$about_msg);
    }elseif($about_msg == ''){
        delete_post_meta($post_id, 'about', get_post_meta($post_id, 'about', true));
    }

    //RECRUIT
    for($i = 1 ; $i <= 8 ; $i++){
        if(isset($_POST['recruit_info'.$i])){
            $recruit_data = $_POST['recruit_info'.$i];
        }
        if( $recruit_data != get_post_meta($post_id, 'recruit_info'.$i, true)){
            update_post_meta($post_id, 'recruit_info'.$i,$recruit_data);
        }elseif($recruit_data == ''){
            delete_post_meta($post_id, 'recruit_info'.$i,get_post_meta($post_id, 'recruit_info'.$i,true));
        }
    }
//MAP
if(isset($_POST['map'])){
    $map = $_POST['map'];
}
if( $map != get_post_meta($post_id, 'map', true)){
    update_post_meta($post_id, 'map', $map);
}elseif($map == ''){
    delete_post_meta($post_id, 'map', get_post_meta($post_id,'map',true));
}
}
//カスタムウィジェット
function theme_slug_widgets_init() {
    register_sidebar( array(
            'name' => 'メリットエリア', //ウィジェットの名前を入力
            'id' => 'widget_merit',  //ウィジェットにつけるid名を入力
            'before_widget' => '<div>', //ウィジェットエリアを囲むエリアを最初と最後を何で囲むか指定
            'after_widget' => '</div>'
    ));
}
add_action( 'widgets_init', 'theme_slug_widgets_init' );
?>

