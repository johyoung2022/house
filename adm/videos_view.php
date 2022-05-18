<?php
$sub_menu = "600100";
include_once('./_common.php');


auth_check_menu($auth, $sub_menu, 'w');
switch ($w)
{
    case "u":
            $sql = " select * from {$g5['video_table']} where idx = TRIM('$vidx') ";

            $video = run_replace('', sql_fetch($sql), $vidx,'*', false);

           //print_r($video);
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
<form name="fvideo" id="fvideo"   method="post" >
<input type="hidden" name="w" id="w" value="<?php echo $w ?>">
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
    <p></p>
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
                        <input type="radio"  <?php echo $video['thunbnail_states']=='Y'? 'checked':'' ;?> disabled>
                    </td>
                    <td>
                        <input type="radio" <?php echo $video['thunbnail_states']=='E'? 'checked':'' ;?> disabled>
                    </td>
                    <td>
                        <input type="radio" <?php echo $video['thunbnail_states']=='N'? 'checked':'' ;?> disabled>
                    </td>
                    <td >
                        <img src="<?php echo $video['thumbnail1'] ?>">
                    </td>
                    <td >
                       <?php 
                            if ( $video['thumbnail_edit'] !='')
                            {
                                echo "<img src='{$video['thumbnail_edit']}'>";                                 
                            } 
                        ?>
                    </td>
                </tr>

                <tr>
                    <td >제목</td>
                    <td>
                        <input type="radio" <?php echo $video['title_states']=='Y'? 'checked':'' ;?> disabled>
                    </td>
                    <td>
                        <input type="radio" <?php echo $video['title_states']=='E'? 'checked':'' ;?> disabled>
                    </td>
                    <td>
                        <input type="radio" <?php echo $video['title_states']=='N'? 'checked':'' ;?> disabled>
                    </td>
                    <td >
                        <?php echo $video['title'] ?>
                    </td>
                    <td >
                        <?php echo $video['title_edit'] ?>
                    </td>
                </tr>

                <tr>
                    <td >동영상</td>
                    <td>
                        <input type="radio" <?php echo $video['link_states']=='Y'? 'checked':'' ;?> disabled>
                    </td>
                    <td>
                        <input type="radio" <?php echo $video['link_states']=='E'? 'checked':'' ;?> disabled>
                    </td>
                    <td>
                        <input type="radio" <?php echo $video['link_states']=='N'? 'checked':'' ;?> disabled>
                    </td>
                    <td >
                        <iframe width="200" height="100" src="https://www.youtube.com/embed/<?php echo $video['video_key'];?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </td>
                    <td >
                        <iframe width="200" height="100" src="https://www.youtube.com/embed/<?php echo $video['video_key'];?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </td>
                </tr>

                <tr>
                    <td >체널명</td>
                    <td>
                        <input type="radio" <?php echo $video['channel_name_states']=='Y'? 'checked':'' ;?> disabled>
                    </td>
                    <td>
                        <input type="radio" <?php echo $video['channel_name_states']=='E'? 'checked':'' ;?> disabled>
                    </td>
                    <td>
                        <input type="radio" <?php echo $video['channel_name_states']=='N'? 'checked':'' ;?> disabled>
                    </td>
                    <td >
                        <?php echo $video['channel_name'] ?>
                    </td>
                    <td >
                        <?php echo $video['channel_name_edit'] ?>
                    </td>
                </tr>

                <tr>
                    <td >조회수</td>
                    <td>
                        <input type="radio" <?php echo $video['viewcount_states']=='Y'? 'checked':'' ;?> disabled>
                    </td>
                    <td>
                        <input type="radio" <?php echo $video['viewcount_states']=='E'? 'checked':'' ;?> disabled>
                    </td>
                    <td>
                        <input type="radio" <?php echo $video['viewcount_states']=='N'? 'checked':'' ;?> disabled>
                    </td>
                    <td >
                        <?php echo number_format($video['viewcount']); ?>
                    </td>
                    <td >
                        <?php echo number_format($video['viewcount_edit']); ?>
                    </td>
                </tr>

                <tr>
                    <td >등록일자</td>
                    <td>
                        <input type="radio" <?php echo $video['regdate_states']=='Y'? 'checked':'' ;?> disabled >
                    </td>
                    <td>
                        <input type="radio" <?php echo $video['regdate_states']=='E'? 'checked':'' ;?> disabled >
                    </td>
                    <td>
                        <input type="radio" <?php echo $video['regdate_states']=='N'? 'checked':'' ;?> disabled >
                    </td>
                    <td >
                        <?php echo $video['regdate'] ?>
                    </td>
                    <td >
                        <?php echo $video['regdate_edit'] ?>
                    </td>
                </tr>

                <tr>
                    <td >url</td>
                    <td>
                        <input type="radio" <?php echo $video['link_states']=='Y'? 'checked':'' ;?> disabled >
                    </td>
                    <td>
                        <input type="radio" <?php echo $video['link_states']=='E'? 'checked':'' ;?> disabled >
                    </td>
                    <td>
                        <input type="radio" <?php echo $video['link_states']=='N'? 'checked':'' ;?> disabled >
                    </td>
                    <td >
                        <a href="<?php echo $video['link']?>" target="_black"><?php echo $video['link']?></a>
                    </td>
                    <td >
                       <?php
                            if( $video['link_edit'])
                            {
                                echo "<a href='{$video['link_edit']}' target='_black'>{$video['link_edit']}</a>";
                            }
                        ?>     
                    </td>
                </tr>

                <tr>
                    <td >태그</td>
                    <td>
                        <input type="radio" <?php echo $video['tags_states']=='Y'? 'checked':'' ;?> disabled >
                    </td>
                    <td>
                        <input type="radio" <?php echo $video['tags_states']=='E'? 'checked':'' ;?> disabled >
                    </td>
                    <td>
                        <input type="radio" <?php echo $video['tags_states']=='N'? 'checked':'' ;?> disabled >
                    </td>
                    <td >
                        <?php echo $video['tags'] ?>
                    </td>
                    <td >
                        <?php echo $video['tags_edit'] ?>
                    </td>
                </tr>
                <tr>
                    <td >상세정보<br>(Description)</td>
                    <td>
                        <input type="radio" <?php echo $video['description_states']=='Y'? 'checked':'' ;?> disabled >
                    </td>
                    <td>
                        <input type="radio" <?php echo $video['description_states']=='E'? 'checked':'' ;?> disabled >
                    </td>
                    <td>
                        <input type="radio" <?php echo $video['description_states']=='N'? 'checked':'' ;?> disabled >
                    </td>
                    <td >
                       <textarea readonly="readonly"><?php echo $video['description'];?></textarea>
                    </td>
                    <td >
                        <textarea readonly="readonly"><?php echo $video['description_edit'];?></textarea>
                    </td>
                </tr>

                <tr>
                    <td >체널ID</td>
                    <td>
                        <input type="radio" <?php echo $video['channelid_states']=='Y'? 'checked':'' ;?> disabled >
                    </td>
                    <td>
                        <input type="radio" <?php echo $video['channelid_states']=='E'? 'checked':'' ;?> disabled >
                    </td>
                    <td>
                        <input type="radio" <?php echo $video['channelid_states']=='N'? 'checked':'' ;?> disabled >
                    </td>
                    <td >
                        <?php echo $video['channelid'];?>
                    </td>
                    <td >
                        <?php echo $video['channelid_deit'];?>
                    </td>
                </tr>


                <tr>
                    <td >영상ID</td>
                    <td>
                        <input type="radio" <?php echo $video['video_key_states']=='Y'? 'checked':'' ;?> disabled >
                    </td>
                    <td>
                        <input type="radio" <?php echo $video['video_key_states']=='E'? 'checked':'' ;?> disabled >
                    </td>
                    <td>
                        <input type="radio" <?php echo $video['video_key_states']=='N'? 'checked':'' ;?> disabled >
                    </td>
                    <td >
                        <?php echo $video['video_key'];?>
                    </td>
                    <td >
                        <?php echo $video['video_key_edit'];?>
                    </td>
                </tr>



        </tbody>
    </table>   
</div>
<div class="btn_confirm01 btn_confirm">
	<a href="javascript:go_edit();">수정</a>
    <a href="javascript:go_list();">목록</a>
    <a href="javascript:go_del();">삭제</a>
</div>


</form>


<script language="javascript">
  var go_list = function(){
      $("#fvideo #w").remove();
      $("#fvideo #vidx").remove();
      $("#fvideo").attr("method", "get");
      $("#fvideo").attr("action", "videos_list.php");
      $("#fvideo").submit();
  };

  var go_edit = function(){
    $("#fvideo").attr("action", "videos_edit.php");
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


</script>

<?php

include_once('./admin.tail.php');