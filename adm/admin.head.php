<?php
if (!defined('_GNUBOARD_')) exit;

$g5_debug['php']['begin_time'] = $begin_time = get_microtime();

$files = glob(G5_ADMIN_PATH.'/css/admin_extend_*');
if (is_array($files)) {
    foreach ((array) $files as $k=>$css_file) {
        
        $fileinfo = pathinfo($css_file);
        $ext = $fileinfo['extension'];
        
        if( $ext !== 'css' ) continue;
        
        $css_file = str_replace(G5_ADMIN_PATH, G5_ADMIN_URL, $css_file);
        add_stylesheet('<link rel="stylesheet" href="'.$css_file.'">', $k);
    }
}

include_once(G5_PATH.'/head.sub.php');

function print_menu1($key, $no='')
{
    global $menu;

    $str = print_menu2($key, $no);

    return $str;
}

function print_menu2($key, $no='')
{
    global $menu, $auth_menu, $is_admin, $auth, $g5, $sub_menu;

    $str = "<ul>";
    for($i=1; $i<count($menu[$key]); $i++)
    {
        if( ! isset($menu[$key][$i]) ){
            continue;
        }

        if ($is_admin != 'super' && (!array_key_exists($menu[$key][$i][0],$auth) || !strstr($auth[$menu[$key][$i][0]], 'r')))
            continue;
        
        $gnb_grp_div = $gnb_grp_style = '';

        if (isset($menu[$key][$i][4])){
            if (($menu[$key][$i][4] == 1 && $gnb_grp_style == false) || ($menu[$key][$i][4] != 1 && $gnb_grp_style == true)) $gnb_grp_div = 'gnb_grp_div';

            if ($menu[$key][$i][4] == 1) $gnb_grp_style = 'gnb_grp_style';
        }

        $current_class = '';

        if ($menu[$key][$i][0] == $sub_menu){
            $current_class = ' on';
        }

        $str .= '<li data-menu="'.$menu[$key][$i][0].'"><a href="'.$menu[$key][$i][2].'" class="gnb_2da '.$gnb_grp_style.' '.$gnb_grp_div.$current_class.'">'.$menu[$key][$i][1].'</a></li>';

        $auth_menu[$menu[$key][$i][0]] = $menu[$key][$i][1];
    }
    $str .= "</ul>";

    return $str;
}

$adm_menu_cookie = array(
'container' => '',
'gnb'       => '',
'btn_gnb'   => '',
);

if( ! empty($_COOKIE['g5_admin_btn_gnb']) ){
    $adm_menu_cookie['container'] = 'container-small';
    $adm_menu_cookie['gnb'] = 'gnb_small';
    $adm_menu_cookie['btn_gnb'] = 'btn_gnb_open';
}
?>
<link href="<?=G5_ADMIN_URL?>/css/scss/include/adm_head.css" rel="stylesheet">
<link href="<?=G5_ADMIN_URL?>/css/scss/include/new_default.css" rel="stylesheet">
<script>
var tempX = 0;
var tempY = 0;

function imageview(id, w, h)
{

    menu(id);

    var el_id = document.getElementById(id);

    //submenu = eval(name+".style");
    submenu = el_id.style;
    submenu.left = tempX - ( w + 11 );
    submenu.top  = tempY - ( h / 2 );

    selectBoxVisible();

    if (el_id.style.display != 'none')
        selectBoxHidden(id);
}
</script>

<div id="to_content"><a href="#container">?????? ????????????</a></div>

<header id="hd">
    <h1><?php echo $config['cf_title'] ?></h1>
    <div id="hd_top">
        <button type="button" id="btn_gnb" class="btn_gnb_close <?php echo $adm_menu_cookie['btn_gnb'];?>">??????</button>
        <div id="logo">
           <a href="<?php echo correct_goto_url(G5_ADMIN_URL); ?>">ADMINISTRATOR</a>
           <a href="<?php echo correct_goto_url(G5_ADMIN_URL); ?>"><img src="<?=G5_ADMIN_URL?>/img/logcompany_logo.png" alt="" style="height:35px; margin:0 20px;"></a>
        </div>

        <div class="hd_info_wrap">
            <ul>
                <li>2021/07/16 10:24:10</li>
                <li><a href="<?=G5_ADMIN_URL?>/service.php"><img src="<?=G5_ADMIN_URL?>/img/bell.png" alt=""></a></li>
                <li><a href="<?=G5_ADMIN_URL?>/config_form.php"><img src="<?=G5_ADMIN_URL?>/img/setting.png" alt=""></a></li>
                <li><a href="<?php echo G5_BBS_URL ?>/logout.php"><img src="<?=G5_ADMIN_URL?>/img/logout.png" alt=""></a></li>
            </ul>
        </div>
    </div>
    <nav id="gnb" class="gnb_large <?php echo $adm_menu_cookie['gnb']; ?>">
        <h2>????????? ?????????</h2>
        <ul class="gnb_ul">
            <?php
            $jj = 1;
            foreach($amenu as $key=>$value) {
                $href1 = $href2 = '';

                if (isset($menu['menu'.$key][0][2]) && $menu['menu'.$key][0][2]) {
                    $href1 = '<a href="'.$menu['menu'.$key][0][2].'" class="gnb_1da">';
                    $href2 = '</a>';
                } else {
                    continue;
                }

                $current_class = "";
                if (isset($sub_menu) && (substr($sub_menu, 0, 3) == substr($menu['menu'.$key][0][0], 0, 3)))
                    $current_class = " on";

                $button_title = $menu['menu'.$key][0][1];
            ?>
            <li class="gnb_li<?php echo $current_class;?>">
                <button type="button" class="btn_op menu-<?php echo $key; ?> menu-order-<?php echo $jj; ?>" title="<?php echo $button_title; ?>"><?php echo $button_title;?></button>
                <div class="gnb_oparea_wr">
                    <div class="gnb_oparea">
                        <h3><?php echo $menu['menu'.$key][0][1];?></h3>
                        <?php echo print_menu1('menu'.$key, 1); ?>
                    </div>
                </div>
            </li>
            <?php
            $jj++;
            }     //end foreach
            ?>
        </ul>
    </nav>

</header>
<script>
jQuery(function($){

    var menu_cookie_key = 'g5_admin_btn_gnb';

    $(".tnb_mb_btn").click(function(){
        $(".tnb_mb_area").toggle();
    });

    $("#btn_gnb").click(function(){
        
        var $this = $(this);

        try {
            if( ! $this.hasClass("btn_gnb_open") ){
                set_cookie(menu_cookie_key, 1, 60*60*24*365);
            } else {
                delete_cookie(menu_cookie_key);
            }
        }
        catch(err) {
        }

        $("#container").toggleClass("container-small");
        $("#gnb").toggleClass("gnb_small");
        $this.toggleClass("btn_gnb_open");

    });

    $(".gnb_ul li .btn_op" ).click(function() {
        $(this).parent().addClass("on").siblings().removeClass("on");
    });

});
</script>


<div id="wrapper">

    <div id="container" class="<?php echo $adm_menu_cookie['container']; ?>">

    <div id="container_title">
            <h1><?php echo $g5['title'] ?></h1>
            <nav id="gnbs" class="content-box gnb_large <?php echo $adm_menu_cookie['gnb']; ?>">
                <ul class="gnb_ul">
                    <?php
                    $jj = 1;
                    foreach($amenu as $key=>$value) {
                        $href1 = $href2 = '';
                        
                        if (isset($menu['menu'.$key][0][2]) && $menu['menu'.$key][0][2]) {
                            $href1 = '<a href="'.$menu['menu'.$key][0][2].'" class="gnb_1da">';
                            $href2 = '</a>';
                        } else {
                            continue;
                        }
                        
                        $current_class = "";
                        if (isset($sub_menu) && (substr($sub_menu, 0, 3) == substr($menu['menu'.$key][0][0], 0, 3)))
                            $current_class = " on";

                        $button_title = $menu['menu'.$key][0][1];
                    ?>
                    
                    <li class="gnb_li<?php echo $current_class;?>">
                        <div class="gnb_oparea_wr">
                            <div class="gnb_oparea">
                                <div class="menu_btn"><i class="ri-menu-line"></i>Menu</div>
                                <?php echo print_menu1('menu'.$key, 1); ?>
                            </div>
                        </div>
                    </li>
                    <?php
                    $jj++;
                    }     //end foreach
                    ?>
                </ul>
            </nav>
        </div>
        <div class="container_wr">

        <!-- ????????????????????? nav?????? -->
        <script>
            $(function() {
                if($('#container_title').find('h1').text() == '???????????????') {
                    $('#gnbs').hide();
                }
            });

            $(function() {
                $('#gnbs').find('div.gnb_oparea ul').addClass('gnbs_ul');
            });
            
        </script>
