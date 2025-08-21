<?php
namespace IgniterWire;

class Pagination
{
    public $perPage = 10;
    public $currentPage = 1;
    public $total = 0;
    public $baseUrl = '';

    public function __construct($total, $perPage = 10, $currentPage = 1, $baseUrl = '')
    {
        $this->total = $total;
        $this->perPage = $perPage;
        $this->currentPage = $currentPage;
        $this->baseUrl = $baseUrl;
    }

    public function links()
    {
        $pageCount = (int) ceil($this->total / $this->perPage);
        $html = '<ul class="igniter-pagination">';
        for ($i = 1; $i <= $pageCount; $i++) {
            $active = $i == $this->currentPage ? 'active' : '';
            $html .= '<li class="' . $active . '"><a href="#" igniter:click="gotoPage" data-page="' . $i . '">' . $i . '</a></li>';
        }
        $html .= '</ul>';
        return $html;
    }
}
