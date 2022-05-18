<?php
$sub_menu = "600100";
include_once('./_common.php');


auth_check_menu($auth, $sub_menu, 'w');


switch ($w)
{
    case "u":
            $sql = " select * from {$g5['video_table']} where idx = TRIM('$vidx') ";

            $video = run_replace('', sql_fetch($sql), $vidx,'*', false);
            if (!$video['idx'])
                alert('존재하지 않는 매물입니다.');
            
                

            $video['sale_key'] = get_text($mb['sale_key']);
               
               
             $html_title = '수정';
            
        
        break;
    default:
            alert('제대로 된 값이 넘어오지 않았습니다.');
        break;
}

$g5['title'] .= '비디오 '.$html_title;
include_once('./admin.head.php');

?>
<form name="fvideo" id="fvideo" action="./videos_update.php" onsubmit="return go_edit(this);" method="post" enctype="multipart/form-data">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="vidx"  id="vidx" value="<?php echo $vidx ?>">
<input type='hidden' name ='vcount'value='<?php echo $vcount?>'/>
<input type="hidden" name="states" value="<?php echo $states ?>">
<input type="hidden" name="fr_date" value="<?php echo $fr_date ?>">
<input type="hidden" name="to_date" value="<?php echo $to_date ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">
<div class="local_desc01 local_desc">
    <p>
		- 비디오를 수정 합니다.
	</p>
</div>
<div class="tbl_frm01 tbl_wrap content-box">
    <table>
        <caption><?php echo $g5['title']; ?></caption>
        <colgroup>
            <col class="grid_1">
            <col >
            <col >
            <col >
            <col class="grid_5">
            <col class="grid_5">
        </colgroup>
        <tbody>
                <tr>
                    <td ></td>
                    <td colspan="3">Front 공개여부</td>
                    <td rowspan="2">유튜브data</td>
                    <td rowspan="2">관리자수정data</td>
                </tr>
                <tr>
                    <td ></td>
                    <td class="td_num_c2">유튜브</td>
                    <td class="td_num_c2">관리자수정</td>
                    <td class="td_num_c2">비공개</td>
                </tr>


                <tr>
                    <td >매물ID</td>
                    <td colspan="3"></td>
                    <td colspan="2">
                        <input type="text" name="sale_key"  id="sale_key" value="<?php echo $video['sale_key']?>" class="frm_input">
                    </td>
                </tr>
                <tr>
                    <td >썸네일</td>
                    <td>
                        <input type="radio" name="mb_mailling" value="1" id="mb_mailling_yes" <?php echo $mb_mailling_yes; ?>>
                    </td>
                    <td>
                        <input type="radio" name="mb_mailling" value="1" id="mb_mailling_yes" <?php echo $mb_mailling_yes; ?>>
                    </td>
                    <td>
                        <input type="radio" name="mb_mailling" value="1" id="mb_mailling_yes" <?php echo $mb_mailling_yes; ?>>
                    </td>
                    <td >
                        <img src="<?php echo $video['thumbnail1'] ?>">
                    </td>
                    <td >
                        <?php echo help('이미지 크기는 <strong>넓이 120 픽셀 높이 90 픽셀</strong>로 해주세요.') ?>
                        <input type="file" name="thumbnail" id="thumbnail">
                        <?php
                        $mb_dir = substr($video['mb_id'],0,2);
                        $icon_file = G5_DATA_PATH.'/video/'.$mb_dir.'/'.$video['idx'].'.gif';
                        if (file_exists($icon_file)) {
                            $icon_url = G5_DATA_URL.'/video/'.$mb_dir.'/'.$video['idx'].'.gif';
                            echo '<img src="'.$icon_url.'" alt="">';
                            echo '<input type="checkbox" id="del_video_img" name="del_video_img" value="1">삭제';
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td >제목</td>
                    <td>
                        <input type="radio" name="title_states" value="Y" id="title_states" <?php echo $video['title_states']=='Y'? 'checked':'' ;?> onchange="set_change_radio('title_states');">
                    </td>
                    <td>
                        <input type="radio" name="title_states" value="E" id="title_states" <?php echo $video['title_states']=='E'? 'checked':'' ;?> onchange="set_change_radio('title_states');">
                    </td>
                    <td>
                        <input type="radio" name="title_states" value="N" id="title_states" <?php echo $video['title_states']=='N'? 'checked':'' ;?> onchange="set_change_radio('title_states');">
                    </td>
                    <td >
                        <?php echo $video['title']?>
                    </td>
                    <td >
                        <input type="text" name="title_edit"  id="title_edit" value="<?php echo $video['title_edit']?>"  <?php echo $video['title_states']=='E'? '':'disabled' ;?> class="frm_input_full">
                    </td>
                </tr>

                <tr>
                    <td >동영상</td>
                    <td>
                        <input type="radio" name="mb_mailling" value="1" id="mb_mailling_yes" <?php echo $mb_mailling_yes; ?>>
                    </td>
                    <td>
                        <input type="radio" name="mb_mailling" value="1" id="mb_mailling_yes" <?php echo $mb_mailling_yes; ?>>
                    </td>
                    <td>
                        <input type="radio" name="mb_mailling" value="1" id="mb_mailling_yes" <?php echo $mb_mailling_yes; ?>>
                    </td>
                    <td >
                        <input type="text" name="sale_key"  id="sale_key" value="<?php echo $video['sale_key']?>" class="frm_input">
                    </td>
                    <td >
                        <input type="text" name="sale_key"  id="sale_key" value="<?php echo $video['sale_key']?>" class="frm_input">
                    </td>
                </tr>

                <tr>
                    <td >체널명</td>
                    <td>
                        <input type="radio" name="channel_name_states" value="Y" id="channel_name_states" <?php echo $video['channel_name_states']=='Y'? 'checked':'' ;?> onchange="set_change_radio('channel_name_states');">
                    </td>
                    <td>
                        <input type="radio" name="channel_name_states" value="E" id="channel_name_states" <?php echo $video['channel_name_states']=='E'? 'checked':'' ;?> onchange="set_change_radio('channel_name_states');">
                    </td>
                    <td>
                        <input type="radio" name="channel_name_states" value="N" id="channel_name_states" <?php echo $video['channel_name_states']=='N'? 'checked':'' ;?> onchange="set_change_radio('channel_name_states');">
                    </td>
                    <td >
                        <?php echo $video['channel_name']?>
                    </td>
                    <td >
                        <input type="text" name="channel_name_edit"  id="channel_name_edit" value="<?php echo $video['channel_name_edit']?>" <?php echo $video['channel_name_states']=='E'? '':'disabled' ;?> class="frm_input">
                    </td>
                </tr>

                <tr>
                    <td >조회수</td>
                    <td>
                        <input type="radio" name="viewcount_states" value="Y" id="viewcount_states" <?php echo $video['viewcount_states']=='Y'? 'checked':'' ;?> onchange="set_change_radio('viewcount_states');">
                    </td>
                    <td>
                        <input type="radio" name="viewcount_states" value="E" id="viewcount_states" <?php echo $video['viewcount_states']=='E'? 'checked':'' ;?> onchange="set_change_radio('viewcount_states');">
                    </td>
                    <td>
                        <input type="radio" name="viewcount_states" value="N" id="viewcount_states" <?php echo $video['viewcount_states']=='N'? 'checked':'' ;?> onchange="set_change_radio('viewcount_states');">
                    </td>
                    <td >
                        <?php echo $video['viewcount']?>
                    </td>
                    <td >
                        <input type="text" name="viewcount_edit"  id="viewcount_edit" value="<?php echo $video['viewcount_edit']?>" <?php echo $video['viewcount_states']=='E'? '':'disabled' ;?> class="frm_input">
                    </td>
                </tr>

                <tr>
                    <td >등록일자</td>
                    <td>
                        <input type="radio" name="regdate_states" value="Y" id="regdate_states" <?php echo $video['regdate_states']=='Y'? 'checked':'' ;?> onchange="set_change_radio('regdate_states');">
                    </td>
                    <td>
                        <input type="radio" name="regdate_states" value="E" id="regdate_states" <?php echo $video['regdate_states']=='E'? 'checked':'' ;?> onchange="set_change_radio('regdate_states');">
                    </td>
                    <td>
                        <input type="radio" name="regdate_states" value="N" id="regdate_states" <?php echo $video['regdate_states']=='N'? 'checked':'' ;?> onchange="set_change_radio('regdate_states');">
                    </td>
                    <td >
                        <?php echo $video['regdate']?>
                    </td>
                    <td >
                        <input type="text" name="regdate_edit"  id="regdate_edit" value="<?php echo $video['regdate_edit']?>" <?php echo $video['regdate_states']=='E'? '':'disabled' ;?> class="frm_input">
                    </td>
                </tr>

                <tr>
                    <td >url</td>
                    <td>
                        <input type="radio" name="link_states" value="Y" id="link_states" <?php echo $video['link_states']=='Y'? 'checked':'' ;?> onchange="set_change_radio('link_states');">
                    </td>
                    <td>
                        <input type="radio"  name="link_states" value="E" id="link_states" <?php echo $video['link_states']=='E'? 'checked':'' ;?> onchange="set_change_radio('link_states');">
                    </td>
                    <td>
                        <input type="radio" name="link_states" value="N" id="link_states" <?php echo $video['link_states']=='N'? 'checked':'' ;?> onchange="set_change_radio('link_states');">
                    </td>
                    <td >
                        <?php echo $video['link']?>
                    </td>
                    <td >
                    <input type="text" name="link_edit"  id="link_edit" value="<?php echo $video['link_edit']?>" <?php echo $video['link_states']=='E'? '':'disabled' ;?> class="frm_input_full">
                    </td>
                </tr>

                <tr>
                    <td >태그</td>
                    <td>
                        <input type="radio" name="tags_states" value="Y" id="tags_states" <?php echo $video['tags_states']=='Y'? 'checked':'' ;?> onchange="set_change_radio('tags_states');" >
                    </td>
                    <td>
                        <input type="radio" name="tags_states" value="E" id="tags_states" <?php echo $video['tags_states']=='E'? 'checked':'' ;?> onchange="set_change_radio('tags_states');" >
                    </td>
                    <td>
                        <input type="radio" name="tags_states" value="N" id="tags_states" <?php echo $video['tags_states']=='N'? 'checked':'' ;?> onchange="set_change_radio('tags_states');" >
                    </td>
                    <td >
                        <?php echo $video['tags'] ?>
                    </td>
                    <td >
                        <input type="text" name="tags_edit"  id="tags_edit" value="<?php echo $video['tags_edit']?>" <?php echo $video['tags_states']=='E'? '':'disabled' ;?> class="frm_input_full">
                    </td>
                </tr>
                <tr>
                    <td >상세정보<br>(Description)</td>
                    <td>
                        <input type="radio" name="description_states" value="Y" id="description_states" <?php echo $video['description_states']=='Y'? 'checked':'' ;?> onchange="set_change_radio('description_states');" >
                    </td>
                    <td>
                        <input type="radio" name="description_states" value="E" id="description_states" <?php echo $video['description_states']=='E'? 'checked':'' ;?> onchange="set_change_radio('description_states');" >
                    </td>
                    <td>
                        <input type="radio" name="description_states" value="N" id="description_states" <?php echo $video['description_states']=='N'? 'checked':'' ;?> onchange="set_change_radio('description_states');" >
                    </td>
                    <td >
                       <textarea readonly><?php echo $video['description'];?></textarea>
                    </td>
                    <td >
                        <textarea name="description_edit" id="description_edit" <?php echo $video['description_states']=='E'? '':'disabled' ;?> ><?php echo str_replace("<br />","\r\n",$video['description_edit']);?></textarea>
                    </td>
                </tr>

                <tr>
                    <td >체널ID</td>
                    <td>
                        <input type="radio" name="channelid_states" value="Y" id="channelid_states" <?php echo $video['channelid_states']=='Y'? 'checked':'' ;?> onchange="set_change_radio('channelid_states');" >
                    </td>
                    <td>
                        <input type="radio" name="channelid_states" value="E" id="channelid_states" <?php echo $video['channelid_states']=='E'? 'checked':'' ;?> onchange="set_change_radio('channelid_states');" >
                    </td>
                    <td>
                        <input type="radio" name="channelid_states" value="N" id="channelid_states" <?php echo $video['channelid_states']=='N'? 'checked':'' ;?> onchange="set_change_radio('channelid_states');" >
                    </td>
                    <td >
                        <?php echo $video['channelid']?>
                    </td>
                    <td >
                    <input type="text" name="channelid_edit"  id="channelid_edit" value="<?php echo $video['channelid_edit']?>" <?php echo $video['channelid_states']=='E'? '':'disabled' ;?> class="frm_input">
                    </td>
                </tr>


                <tr>
                    <td >영상ID</td>
                    <td>
                        <input type="radio" name="video_key_states" value="Y" id="video_key_states" <?php echo $video['video_key_states']=='Y'? 'checked':'' ;?> onchange="set_change_radio('video_key_states');" >
                    </td>
                    <td>
                        <input type="radio" name="video_key_states" value="E" id="video_key_states" <?php echo $video['video_key_states']=='E'? 'checked':'' ;?> onchange="set_change_radio('video_key_states');" >
                    </td>
                    <td>
                        <input type="radio" name="video_key_states" value="N" id="video_key_states" <?php echo $video['video_key_states']=='N'? 'checked':'' ;?> onchange="set_change_radio('video_key_states');" >
                    </td>
                    <td >
                        <?php echo $video['video_key']?>
                    </td>
                    <td >
                    <input type="text" name="video_key_edit"  id="video_key_edit" value="<?php echo $video['video_key_edit']?>" <?php echo $video['video_key_states']=='E'? '':'disabled' ;?> class="frm_input">
                    </td>
                </tr>



        </tbody>
    </table>   
</div>
<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="확인" class="btn_submit" accesskey='s'>
    <a href="javascript:go_list();">목록</a>
    <a href="javascript:go_del();">삭제</a>
</div>


</form>
<form name="fvideolist" id="fvideolist" action="./videos_list.php"  method="get" >
<input type='hidden' name ='vcount'value='<?php echo $vcount?>'/>
<input type="hidden" name="states" value="<?php echo $states ?>">
<input type="hidden" name="fr_date" value="<?php echo $fr_date ?>">
<input type="hidden" name="to_date" value="<?php echo $to_date ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">
</form>


<script language="javascript">
  var go_list = function(){
      $("#fvideolist").submit();
  };

  var go_edit = function(f){
  
    $("#fvideo").submit();
  };

  var go_del  = function(){
    var vidx =  $("#vidx").val();
    if(confirm("한번 삭제한 자료는 복구할 방법이 없습니다.\n\n정말 삭제하시겠습니까?")) {
        $.ajax({
                    type: "POST",
                    url: g5_admin_url+"/ajax.videos.php",
                    data: { vidx: vidx },
                    cache: false,
                    async: false,
                    dataType: "json",
                    success: function(data) {
                        if(data.resutl=='ok')
                        {
                            alert(data.msg);
                            go_list();
                            return true;
                        }
                       // console.log(data.resutl);
                    }
    });
        return true;  
    }else{
        return false;
    } 
  };



  var set_change_radio = function(param){
        var getRadio =  eval("$(\"input[name='"+param+"']:checked\")");
        var getText =  eval("$('#"+param.replace('states','edit')+"')");
        getRadio.val() == "E"?getText.attr("disabled",false): getText.attr("disabled",true);
  }


</script>


<?php

include_once('./admin.tail.php');