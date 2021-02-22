<?php


namespace App;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use stdClass;

class SomaHelpers
{
    public static function getNextSequenceValuePadded($current)
    {
        return str_pad($current + 1, 4, '0', STR_PAD_LEFT);
    }

    public static function generatePagination(LengthAwarePaginator $paginator)
    {
        $pagination = new stdClass();

        $pagination->currentPage = $paginator->currentPage();
        $pagination->nextPage = $pagination->currentPage + 1;
        $pagination->previousPage = null;
        if($pagination->currentPage > 1){
            $pagination->previousPage = $pagination->currentPage - 1;
        }
        $pagination->pages = $paginator->lastPage();
        $pagination->firstPage = 1;
        $pagination->lastPage = $paginator->lastPage();
        $pagination->from = $paginator->firstItem();
        $pagination->to = $paginator->lastItem();
        $pagination->perPage = $paginator->perPage();
        $pagination->total = $paginator->total();
        $pagination->hasMorePages = $paginator->hasMorePages();
        $pagination->hasPages = $pagination->currentPage != 1 || $pagination->hasMorePages;

        return $pagination;
    }
}
