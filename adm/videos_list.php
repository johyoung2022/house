<?php
$sub_menu = "600100";
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$fr_date = isset($_REQUEST['fr_date']) ? preg_replace('/[^0-9 :\-]/i', '', $_REQUEST['fr_date']) : G5_TIME_YMD;
$to_date = isset($_REQUEST['to_date']) ? preg_replace('/[^0-9 :\-]/i', '', $_REQUEST['to_date']) : G5_TIME_YMD;

$g5['title'] = '비디오관리';
include_once('./admin.head.php');

include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');

if (empty($fr_date) || ! preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $fr_date) ) $fr_date = G5_TIME_YMD;
if (empty($to_date) || ! preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $to_date) ) $to_date = G5_TIME_YMD;

$colspan = "6";

$qstr = "fr_date=".$fr_date."&amp;to_date=".$to_date;
$query_string = $qstr ? '?'.$qstr : '';

$sql_common = " from {$g5['video_table']} ";
$sql_search = " where states < 3 and date_format(regdate,'%Y-%m-%d') between '{$fr_date}' and '{$to_date}' ";


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
            order by regdate desc
            limit {$from_record}, {$rows} ";
//echo $sql;
$result = sql_query($sql);

?>
<form name="fvisit" id="fvisit" class="local_sch03 local_sch" method="get">
<div class="sch_last">
    <strong>기간별검색</strong>
    <input type="text" name="fr_date" value="<?php echo $fr_date ?>" id="fr_date" class="frm_input" size="11" maxlength="10">
    <label for="fr_date" class="sound_only">시작일</label>
    ~
    <input type="text" name="to_date" value="<?php echo $to_date ?>" id="to_date" class="frm_input" size="11" maxlength="10">
    <label for="to_date" class="sound_only">종료일</label>
    <input type="submit" value="검색" class="btn_submit">
</div>
</form>


<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col">
            <label for="chkall" class="sound_only">영상 전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>    
        <th scope="col">동영상</th>
        <th scope="col">등록일</th>
        <th scope="col">상태</th>
        <th scope="col">비고</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        $link = '';
        $link2 = '';
        $referer = '';
        $title = '';
        

        $title = str_replace(array('<', '>', '&'), array("&lt;", "&gt;", "&amp;"), $row['title']);
        $link = '<a href="'.get_text($row['video_key']).'" target="_blank">';
        $link = str_replace('&', "&amp;", $link);
        $link2 = '</a>';
        
        $bg = 'bg'.($i%2);
    ?>
    <tr class="<?php echo $bg; ?>">
        <td>
            <input type="hidden" name="mb_id[<?php echo $i ?>]" value="<?php echo $row['video_key'] ?>" id="mb_id_<?php echo $i ?>">
            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
        </td>
        <td>
            <img src="<?php echo $row['thumbnail1'] ?>">
            <a href="<?php echo $row['link'] ?>" target="_blank"><?php echo $title ?></a><br>
            <?php echo $row['channel_name'] ?><br>
            tags:[<?php echo $row['tags'] ?>]<br>
            <!--<a href="#" class="btn btn_03">더보기</a>-->
        </td>
        
        
        <td class="td_datetime">
            <?php echo str_replace(array('T', 'Z'),array(" ", ""),$row['regdate']) ?> <br>
            <?php
                $dt = new DateTime($row['regdate'], new DateTimeZone('Asia/Seoul'));
                $dt->setTimezone(new DateTimeZone('KST'));
                echo $dt->format('Y-m-d H:i:s');
            ?><br>
            (한국시간)
        </td>
        <td class="td_datetime">
            <?php
                if ($row['states']=='0')
                {
                    echo '등록대기';
                }else{
                    echo '공개중';
                }
            ?>  
        </td>
        <td >
            <a href="#" class="btn btn_03">수정</a>
        </td>

    </tr>
    <tr >
        <td colspan="<?=$colspan?>">
                <? echo nl2br(conv_unescape_nl(stripslashes($row['description'])))?>
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
    <input type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value" class="btn btn_02">
    <input type="submit" name="act_button" value="선택공개" onclick="document.pressed=this.value" class="btn btn_02">
</div>
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
</script>
<?
include_once('./admin.tail.php');