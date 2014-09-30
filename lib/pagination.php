<?php
class Pagination
{
/** 
 * Pagination (Page Manipulation) 
 */
    const MAX_ROWS = 5;
    public function getPage($rows) 
    {
    /**
     * Establish page number
     * Only number can be the value of $pagenum
     */
        if(!isset($pagenum)) {
            $pagenum = 1;
        } 
        if (isset($_GET['pn'])) {
            $pagenum = preg_replace('#[^0-9]#', '', $_GET['pn']);   
        }
    
        /**
         * Page number of the last page
         */
        $last_page = ceil($rows/self::MAX_ROWS);
    
        /**
         * Makes sure that the last page cannot
         * be less than 1
         */
        if ($last_page < 1) {
            $last_page = 1;
        }

        /**
         * Makes sure that $pagenum cannot
         * be < 1 or $last_page > 1
         */
        if ($pagenum < 1) {
            $pagenum = 1;
        } elseif ($pagenum > $last_page) {
            $pagenum = $last_page;
        }
        $page = array(
            'pagenum'         => $pagenum,
            'last_page'       => $last_page
        );
        return $page;
    }    
    /**
     * Sets the range of rows (ex. Prev 1 2 Next) Only
     */
    public function rangeRows($pagenum, $last_page)
    {   
        $current_page = array();
        $max = 'limit ' .($pagenum - 1) * self::MAX_ROWS.',' .self::MAX_ROWS;
        $link_page =& $current_page['pn'];
    
        /**
         * Sets the range of rows
         */
        $paginationCtrls = "";
        if ($last_page != 1) {
            if ($pagenum > 1) {
                $link_page = $pagenum - 1;
                $paginationCtrls .= "<a href='" . url('', $current_page) . "'> Previous </a> &nbsp; &nbsp;";
            /**
             * Clickable number links
             */
                for ($i = $pagenum - 4; $i < $pagenum; $i++) {
                    $link_page = $i;
                    if ($i > 0) {
                        $paginationCtrls .= "<a href='".url('', $current_page)."'> $i </a> &nbsp; ";
                    }
                }
            }
            /**
             * Page number without a link (Current page)
             */
            $paginationCtrls .= ''.$pagenum.' &nbsp; ';
        }
    /**
     * Page number on the right of the Current page
     */
        for ($i = $pagenum + 1; $i <= $last_page; $i++) {
            $link_page = $i;
            $paginationCtrls .= "<a href='".url('', $current_page)."'> $i </a> &nbsp; ";
            if ($i >= $pagenum + 3) {
                break;
            }
        }
        if ($pagenum != $last_page) {
            $link_page = $pagenum + 1;
            $paginationCtrls .= " &nbsp; &nbsp; <a href='".url('', $current_page)."'> Next </a>";
        }
    
        $pagination = array(
            'max'             => $max,
            'last_page'       => $last_page,
            'pagenum'         => $pagenum,
            'paginationCtrls' => $paginationCtrls,
        );
        return $pagination;
    }
}