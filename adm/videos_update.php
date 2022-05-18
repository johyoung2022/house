<?php
$sub_menu = "600100";
include_once("./_common.php");
include_once(G5_LIB_PATH.'/thumbnail.lib.php');


auth_check_menu($auth, $sub_menu, 'w');

check_admin_token();





$vidx = isset($_POST['vidx']) ? trim($_POST['vidx']) : '';
$count_chk_id = (isset($_POST['chk']) && is_array($_POST['chk'])) ? count($_POST['chk']) : 0;

for ($i=0; $i<$count_chk_id; $i++) {
    $wr_id_val = isset($_POST['vidx'][$_POST['chk'][$i]]) ? preg_replace('/[^0-9]/', '', $_POST['vidx'][$_POST['chk'][$i]]) : 0;
    $wr_id_list .= $comma . $wr_id_val;
    $comma = ',';
}

if($w == 'AO' || $w == 'AD' || $w == 'AP')
{
    switch($w)
    {
        case 'AO':
            $states = '1';
        break;
        case 'AP':
            $states = '2';
            break;
        case 'AD':
            $states = '3';
            break;
    }

    $sql = " update {$g5['video_table']}
        set states ='{$states}'
        where idx in({$wr_id_list}) ";

    //echo $sql;
    sql_query($sql);
    goto_url('./videos_list.php?'.$qstr, false);
    exit();
}





$posts = array();
$check_keys = array(
'title_states',
'title_edit',
'channel_name_states',
'channel_name_edit',
'viewcount_states',
'viewcount_edit',
'regdate_states',
'regdate_edit',
'link_states',
'link_edit',
'tags_states',
'tags_edit',
'channelid_states',
'channelid_edit',
'video_key_states',
'video_key_edit'

);

foreach( $check_keys as $key ){
    $posts[$key] = isset($_POST[$key]) ? clean_xss_tags($_POST[$key], 1, 1) : '';
}



$sql_common = "  title_states = '{$posts['title_states']}'";
if($posts['title_states']=="E")
{
    $sql_common .= "  ,title_edit = '{$posts['title_edit']}'";
}



$sql_common .= "  ,channel_name_states = '{$posts['channel_name_states']}'";
if($posts['channel_name_states']=="E")
{
    $sql_common .= "  ,channel_name_edit = '{$posts['channel_name_edit']}'";
}


$sql_common .= "  ,viewcount_states = '{$posts['viewcount_states']}'";
if($posts['viewcount_states']=="E")
{
    $sql_common .= "  ,viewcount_edit = '{$posts['viewcount_edit']}'";
}


$sql_common .= "  ,regdate_states = '{$posts['regdate_states']}'";
if($posts['viewcount_states']=="E")
{
    $sql_common .= "  ,regdate_edit = '{$posts['regdate_edit']}'";
}

$sql_common .= "  ,link_states = '{$posts['link_states']}'";
if($posts['link_states']=="E")
{
    $sql_common .= "  ,link_edit = '{$posts['link_edit']}'";
}

$sql_common .= "  ,tags_states = '{$posts['tags_states']}'";
if($posts['tags_states']=="E")
{
    $sql_common .= "  ,tags_edit = '{$posts['tags_edit']}'";
}


$sql_common .= "  ,description_states = '{$_POST['description_states']}'";

$description_edit=str_replace("\r\n","<br />",trim($_POST['description_edit']));
if($_POST['description_states']=="E")
{
    $sql_common .= "  ,description_edit = '{$description_edit}'";
}


$sql_common .= "  ,channelid_states = '{$posts['channelid_states']}'";
if($posts['channelid_states']=="E")
{
    $sql_common .= "  ,channelid_edit = '{$posts['channelid_edit']}'";
}


$sql_common .= "  ,video_key_states = '{$posts['video_key_states']}'";
if($posts['video_key_states']=="E")
{
    $sql_common .= "  ,video_key_edit = '{$posts['video_key_edit']}'";
}



if ($w == 'u')
{
    $sql = " select * from {$g5['video_table']} where idx = TRIM('$vidx') ";

    $video = run_replace('', sql_fetch($sql), $vidx,'*', false);
    
    if (! (isset($video['idx']) && $video['idx']))
        alert('존재하지 않는 매물입니다.');

    $sql = " update {$g5['video_table']}
                set {$sql_common}
                where idx = '{$vidx}' ";
   
    sql_query($sql);
}


if( $w == '' || $w == 'u' ){

    
    $video_img = $vidx.'.gif';
    
     // 회원 아이콘 삭제
     if (isset($del_video_img) && $del_video_img)
        @unlink(G5_DATA_PATH.'/video/'.$video_img);

    $image_regex = "/(\.(gif|jpe?g|png))$/i";
    // 아이콘 업로드
    if (isset($_FILES['thumbnail']) && is_uploaded_file($_FILES['thumbnail']['tmp_name'])) {
        if (!preg_match($image_regex, $_FILES['thumbnail']['name'])) {
            alert($_FILES['thumbnail']['name'] . '은(는) 이미지 파일이 아닙니다.');
        }

    

        if (preg_match($image_regex, $_FILES['thumbnail']['name'])) {
            $video_dir = G5_DATA_PATH.'/video';
            @mkdir($video_dir, G5_DIR_PERMISSION);
            @chmod($video_dir, G5_DIR_PERMISSION);

            
            $dest_path = $video_dir.'/'.$video_img;

            move_uploaded_file($_FILES['thumbnail']['tmp_name'], $dest_path);
            chmod($dest_path, G5_FILE_PERMISSION);

            if (file_exists($dest_path)) {
                $size = @getimagesize($dest_path);
                if ($size[0] > 120 || $size[1] > 90) {
                    $thumb = null;
                    if($size[2] === 2 || $size[2] === 3) {
                        //jpg 또는 png 파일 적용
                        
                        $thumb = thumbnail($video_img, $video_dir, $video_dir, 120, 90, true, true);
                        if($thumb) {
                            @unlink($dest_path);
                            rename($video_dir.'/'.$thumb, $dest_path);
                        }
                    }
                    if( !$thumb ){
                        // 아이콘의 폭 또는 높이가 설정값 보다 크다면 이미 업로드 된 아이콘 삭제
                        @unlink($dest_path);
                    }
                }
            }
        }
    }
}

goto_url('./videos_edit.php?'.$qstr.'&amp;w=u&amp;vidx='.$vidx, false);


