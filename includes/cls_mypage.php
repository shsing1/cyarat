<?
/* 自定義換頁風格 */
require_once ('cls_page.php');
class mypage extends page
{
    function mypage($array)
    {
        parent::page($array);
//        $this->first_page = '第一頁';
//       	$this->last_page = '最後一頁';
        $this->set('format_left', '');
        $this->set('format_right', '');
    }
	/**
    * 為指定的頁面返回位址值
    *
    * @param int $pageno
    * @return string $url
    */
    function _get_url($pageno = 1)
    {
        return $pageno;
    }

//    function show()
//    {
//        $pagestr = '<div class="pagenavi" id="lopage">頁:';
//        $pagestr .= $this->first_page() . ' ';
//        $pagestr .= $this->nowbar('', 'curr');
//        $pagestr .= '<span class="break">...</span>';
//        $pagestr .= $this->last_page();
//        $pagestr .= '   (總計<span class="num">' . $this->totalpage . '</span>頁) </div>';
//        $pagestr .= '</div>';
//        return $pagestr;
//    }
}
?>
