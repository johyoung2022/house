<?php
$sub_menu = "600100";
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$fr_date = isset($_REQUEST['fr_date']) ? preg_replace('/[^0-9 :\-]/i', '', $_REQUEST['fr_date']) : "";
$to_date = isset($_REQUEST['to_date']) ? preg_replace('/[^0-9 :\-]/i', '', $_REQUEST['to_date']) : "";

$g5['title'] = '비디오관리';
include_once('./admin.head.php');

include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');

if (empty($fr_date) || ! preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $fr_date) ) $fr_date = "";
if (empty($to_date) || ! preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $to_date) ) $to_date = "";

$colspan = "11";




$sql_common = " from {$g5['video_table']} ";
//states < 3 은 삭제되는  매물 관련 입니다. 나중에 유튜브에서 가져올때 안가져 오기 위해  상태 값 3을 만듬
$sql_search = " where states < 3"; 

$qstr = $_SERVER['QUERY_STRING'];

if($states != "")
{
    $sql_search .= " and states = '".$states."'"; 
} 


if($fr_date)
{
    $sql_search .= " and date_format(regdate,'%Y-%m-%d') >= '".$fr_date."'";
}



if($to_date)
{
    $sql_search .= " and date_format(regdate,'%Y-%m-%d') <= '".$to_date."'";
}

///and date_format(regdate,'%Y-%m-%d') between '{$fr_date}' and '{$to_date}'


if ($stx) {
    $sql_search .= " and ( ";
    $sql_search .= " {$sfl} like '%{$stx}%'";
    $sql_search .= " ) ";
}


if($vcount > 0){
    switch($vcount)
    {
        case "1":
            $sql_search .= " and viewcount <= 100000";
            break;
        case "2":
            $sql_search .= " and viewcount > 100000  and viewcount <= 1000000 ";
            break;
        case "3":
            $sql_search .= " and viewcount > 1000000 ";
            break;
    }
}




if (!$sst)  {
    $sst  = "regdate";
    $sod = "desc";
}
$sql_order = "order by $sst $sod";



$query_string = $qstr ? '?'.$qstr : '';




$sql = " select count(*) as cnt
            {$sql_common}
            {$sql_search} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select *
            {$sql_common}
            {$sql_search}
            $sql_order
            limit {$from_record}, {$rows} ";
$result = sql_query($sql);


//echo $sql 
?>
<form name="fvisit" id="fvisit" class="local_sch03 local_sch" method="get">
<input type='hidden' name ='vcount' id='vcount' value='<?php echo $vcount?>'/>
<div class="sch_last">
    <label for="states" class="sound_only">공개상태</label>
    <select name="states" id="states">
        <option value=""<?php echo get_selected($states, ""); ?>>전체</option>
        <option value="0"<?php echo get_selected($states, "0"); ?>>대기</option>
        <option value="1"<?php echo get_selected($states, "1"); ?>>공개</option>
        <option value="2"<?php echo get_selected($states, "2"); ?>>비공개</option>
    </select>

    <strong>기간별검색</strong>
    <input type="text" name="fr_date" value="<?php echo $fr_date ?>" id="fr_date" class="frm_input" size="11" maxlength="10">
    <label for="fr_date" class="sound_only">시작일</label>
    ~
    <input type="text" name="to_date" value="<?php echo $to_date ?>" id="to_date" class="frm_input" size="11" maxlength="10">
    <label for="to_date" class="sound_only">종료일</label>
    <label for="sfl" class="sound_only">검색대상</label>
    <select name="sfl" id="sfl">
        <option value="sale_key"<?php echo get_selected($sfl, "sale_key"); ?>>매물ID</option>
        <option value="title"<?php echo get_selected($sfl, "title"); ?>>title</option>
        <option value="channel_name"<?php echo get_selected($sfl, "channel_name"); ?>>채널명</option>        
        <option value="tags"<?php echo get_selected($sfl, "tags"); ?>>tags</option>
        <option value="description"<?php echo get_selected($sfl, "description"); ?>>상세설명</option>
    </select>
    <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
    <input type="text" name="stx" value="<?php echo $stx ?>" id="stx"  class="frm_input">
    <input type="submit" class="btn_submit" value="검색">    
</div>
<div class="sch_last">
    <label for="sfl" class="sound_only">조회수</label>
    <span onclick='count_search(0);'>전체</span>|
    <span onclick='count_search(1);'>~10만</span>|
    <span onclick='count_search(2);'>10만~100만</span>|
    <span onclick='count_search(3);'>100만~</span>
</div>
</form>

<form name="fvideoslist" id="fvideoslist" action="./videos_update.php" onsubmit="return fvideoslist_submit(this);" method="post">
<input type='hidden' name ='w' />
<input type='hidden' name ='vcount'value='<?php echo $vcount?>'/>
<input type="hidden" name="states" value="<?php echo $states ?>">
<input type="hidden" name="fr_date" value="<?php echo $fr_date ?>">
<input type="hidden" name="to_date" value="<?php echo $to_date ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">
<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col" rowspan="2">
            <label for="chkall" class="sound_only">영상 전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>    
        <th scope="col" rowspan="2" >NO</th>
        <th scope="col" rowspan="2" >매물ID</th>
        <th scope="col">유튜브data</th>
        <th scope="col">썸네일<br>이미지</th>
        <th scope="col"><?php echo subject_sort_link('title', $qstr, 1) ?>제목</a></th>
        <th scope="col"><?php echo subject_sort_link('channel_name', $qstr, 1) ?>체널명</a></th>
        <th scope="col"><?php echo subject_sort_link('viewcount', $qstr, 1) ?>조회수</a></th>
        <th scope="col"><?php echo subject_sort_link('regdate', $qstr, 1) ?>등록일</a></th>
        <th scope="col">url</th>
        <th scope="col" rowspan="2" >공개여부</th>
    </tr>
    <tr>
        <th scope="col">수정data</th>
        <th scope="col">썸네일<br>이미지</th>
        <th scope="col">제목</th>
        <th scope="col">체널명</th>
        <th scope="col">조회수</th>
        <th scope="col">등록일</th>
        <th scope="col">url</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {

        
        $num = number_format($total_count - ($page - 1) * $config['cf_page_rows'] - $i);

        $title = str_replace(array('<', '>', '&'), array("&lt;", "&gt;", "&amp;"), $row['title']);
        $link = '<a href="./videos_view.php?'.$qstr.'&w=u&vidx='.$row['idx'].'">';
        $link = str_replace('&', "&amp;", $link);
        $link2 = '</a>';
        
        $bg = 'bg'.($i%2);
    ?>
    <tr class="<?php echo $bg; ?>">
        <td class="td_chk" rowspan="2">
            <input type="hidden" name="vidx[<?php echo $i ?>]" value="<?php echo $row['idx'] ?>" id="vidx<?php echo $i ?>">
            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
        </td>
        <td class="td_num_c" rowspan="2"><?php echo $num ?></td>
        <td class="td_mng_m" rowspan="2"><?php echo $row['sale_key'] ?></td>        
        <td class="td_mng_m"><?php echo $row['video_key'] ?></td>
        <td class="td_img"><img src="<?php echo $row['thumbnail1'] ?>"></td>
        <td ><?php echo $link;?><?php echo $row['title'] ?><?php echo $link2; ?></td>
        <td class="td_id"><?php echo $row['channel_name'] ?></td>
        <td class="td_num_c3"><?php number_format($row['viewcount']) ?></td>
        <td class="td_datetime">
            <?php echo str_replace(array('T', 'Z'),array(" ", ""),$row['regdate']) ?> <br>
        </td>
        <td class="td_mng_m">
            <a href="<?php echo $row['link']?>" target="_blank">열기</a>
        </td>
        <td class="td_mng_s" rowspan="2">
            <?php
                switch ($row['states'])
                {
                    case "0":
                            echo "등록대기";
                        break;
                    case "1":
                            echo "공개";
                        break;
                    case "2":
                            echo "비공개";
                        break;
                }
            ?>  
        </td>
    </tr>
    <tr class="<?php echo $bg; ?>">
        <td class="td_mng_m"><?php echo $row['sale_key'] ?></td>        
         <td class="td_img">
            <?php if(file_exists(G5_DATA_PATH.'/video/'.$row['idx'].'.gif')){?>
            <img src="<?php echo  G5_URL.'/data/video/'.$row['idx'].'.gif';?>">
            <?php }?>
         </td>
        <td ><?php echo $row['title_edit'] ?></td>
        <td class="td_id"><?php echo $row['channel_name_edit'] ?></td>
        <td class="td_num_c3"><?php number_format($row['viewcount_edit']) ?></td>
        <td class="td_datetime">
            <?php echo $row['regdate_edit']; ?>
        </td>
        <td class="td_mng_m" >
               <?php if ($row['link_edit']){?>
                <a href="<?php echo $row['link_edit']?>" target="_blank">열기</a>
               <?php } ?>
        </td>
    </tr>
    <?php
    }
    if ($i == 0)
        echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없거나 관리자에 의해 삭제되었습니다.</td></tr>';
    ?>
    </tbody>
    </table>
</div>
<div class="btn_fixed_top">
    <input type="submit" name="act_button" value="등록하기" onclick="document.pressed=this.value" class="btn btn_02">
    <input type="submit" name="act_button" value="공개" onclick="document.pressed=this.value" class="btn btn_02">
    <input type="submit" name="act_button" value="비공개" onclick="document.pressed=this.value" class="btn btn_02">
    <input type="submit" name="act_button" value="삭제" onclick="document.pressed=this.value" class="btn btn_02">
</div>
</form>
<?php
if (isset($domain))
    $qstr .= "&amp;domain=$domain";
$qstr .= "&amp;page=";

$pagelist = get_paging($config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr");
echo $pagelist;
?>

<script>
$(function(){
    $("#fr_date, #to_date").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99", maxDate: "+0d" });
});

function fvisit_submit(act)
{
    var f = document.fvisit;
    f.action = act;
    f.submit();
}

function count_search(param){
	$('#fvisit #vcount').val(param);
	$('#fvisit').submit();
}

function fvideoslist_submit(f)
{
    var chk_count = 0;
    if(document.pressed=="등록하기")
    {
        alert("준비 중입니다.");
        return false;
    }

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk[]" && f.elements[i].checked)
            chk_count++;
    }


    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }


    if(document.pressed=="공개")
    {
        f.w.value = 'AO';
        f.submit();
    }

    if(document.pressed=="비공개")
    {
        f.w.value = 'AP';
        f.submit();
    }

    if(document.pressed=="삭제")
    {
        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다."))
            return false;
        f.w.value = 'AD';
        f.submit();
    }

    

}

</script>
<?
include_once('./admin.tail.php');