<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

include_once(G5_THEME_PATH.'/head.sub.php');

/***************************************************************************************** 
 ■ 경고! 수정하면 제대로 작동하지 않을 수 있으니 주의해 주세요.
*****************************************************************************************/

// 로고 이미지
$tset['logo_img'] = ($tset['logo_img']) ? $tset['logo_img'] : '../img/logo.png';
$tset['logo_img'] = na_url($tset['logo_img']);

// 로고 텍스트
$tset['logo_text'] = ($tset['logo_text']) ? $tset['logo_text'] : '아미나';

// 사이트 너비
$tset['size'] = (int)$tset['size'];
if($tset['size'] > 0) {
	$tset['size'] = $tset['size'];
} else {
	$tset['size'] = (G5_IS_MOBILE) ? 1200 : 1100;
}

?>
<style>
	.nt-container { max-width:<?php echo $tset['size'];?>px; }
	.no-responsive .wrapper { min-width:<?php echo ($tset['size'] + 40);?>px; }
</style>
<?php
// 필수 : 헤더,테일 사용안함
if($tset['page_sub'])
	return;

//---------------------------------------------------------------------------------
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');

//그누 스킨을 사용하려면 아래 주석을 풀어 주세요.
//include_once(G5_LIB_PATH.'/outlogin.lib.php');
//include_once(G5_LIB_PATH.'/visit.lib.php');
//include_once(G5_LIB_PATH.'/connect.lib.php');
//include_once(G5_LIB_PATH.'/popular.lib.php');
//---------------------------------------------------------------------------------

// 페이지 설정
$nt_side_url = $nt_side_path = $nt_title_url = $nt_title_path = '';
if($is_index) { //인덱스는 와이드 고정
	$is_content_col = 13;
	$is_page_col = '';
} else {
	// 페이지 타이틀
	$page_title = na_page_title($tset);
	list($nt_title_url, $nt_title_path) = na_layout_content('title', $tset['title'], 'title-basic');

	// 페이지 칼럼(다단)
	$is_content_col = (int)$tset['page'];
	$is_content_col = ($is_content_col) ? $is_content_col : 9;
	if($is_content_col == 13) {
		$is_page_col = ''; // wide
	} else if($is_content_col == 12) { //One Column
		$is_page_col = 'one';
	} else { // Two Column
		$is_page_col = 'two';
		list($nt_side_url, $nt_side_path) = na_layout_content('side', $tset['page_side'], 'side-basic');
	}
}

// 영역별 컨텐츠 경로
list($nt_top_url, $nt_top_path) = na_layout_content('top', $tset['top']);
list($nt_lnb_url, $nt_lnb_path) = na_layout_content('lnb', $tset['lnb'], 'lnb-basic');
list($nt_header_url, $nt_header_path) = na_layout_content('header', $tset['header'], 'header-basic');
list($nt_menu_url, $nt_menu_path) = na_layout_content('menu', $tset['menu'], 'menu-basic');
list($nt_wing_url, $nt_wing_path) = na_layout_content('wing', $tset['wing']);
list($nt_footer_url, $nt_footer_path) = na_layout_content('footer', $tset['footer'], 'footer-basic');
list($nt_sidebar_url, $nt_sidebar_path) = na_layout_content('sidebar', $tset['sidebar'], 'sidebar-basic');

// 필수 : 메뉴 및 현재위치 정보 불러오기 - 전역변수로 사용됨
list($menu, $tnav) = na_menu('bbs', $pset['mid']);

// 필수 : 메뉴수 - 전역변수로 사용됨
$menu_cnt = is_array($menu) ? count($menu) : 0;

// 회원정보 재가공
$member = na_member($member);

// 사이트 통계
$stats = na_stats($tset['stats']);

// 팝업레이어는 index에서만 실행
if($is_index) {
	include G5_BBS_PATH.'/newwin.inc.php';
}

// TOP
if($nt_top_path)
	@include_once ($nt_top_path.'/top.php');
?>
<div class="wrapper m-auto overflow-hidden">
	<div id="nt_header">
		<div id="nt_sticky">
		<?php
		// LNB
		if($nt_lnb_path)
			@include_once ($nt_lnb_path.'/lnb.php');

		// HEADER
		if($nt_header_path)
			@include_once ($nt_header_path.'/header.php');

		// MENU
		if($nt_menu_path)
			@include_once ($nt_menu_path.'/menu.php');
		?>
		</div>
		<?php
		// PAGE TITLE
		if($nt_title_path)
			@include_once ($nt_title_path.'/title.php');

		// WING
		if($is_wing && $nt_wing_path)
			@include_once ($nt_wing_path.'/wing.php');
		?>
	</div><!-- #nt_header -->

	<div id="nt_body" class="nt-body px-0 px-sm-4">
	<?php if($is_page_col) { ?>
		<div class="nt-container py-3 py-sm-4">
		<?php if($is_page_col == "two") { ?>
			<div class="row na-row">
				<div class="col-md-<?php echo $is_content_col ?><?php echo ($tset['left_side']) ? ' order-md-2' : '';?> na-col">
		<?php } ?>
	<?php } ?>
