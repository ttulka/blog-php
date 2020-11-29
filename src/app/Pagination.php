<?php

namespace blog;

class Pagination {

    private $currentPage;
    private $entriesCount;
    private $entriesOnPage;
    private $params;

    public function __construct($currentPage, $entriesCount, $entriesOnPage, $params) {
        $this->currentPage = $currentPage;
        $this->entriesCount = $entriesCount;
        $this->entriesOnPage = $entriesOnPage;
        $this->params = $params;
    }

    public final function hasNext() {
        return $this->currentPage + 1 < $this->entriesCount / $this->entriesOnPage;
    }

    public final function hasPrevious() {
        return $this->currentPage > 0;
    }

    public final function nextUrl() {
        return '?' . $this->query($this->params, $this->currentPage + 1 > 0 ? 'page=' . ($this->currentPage + 1) : '');
    }

    public final function previousUrl() {
        return '?' . $this->query($this->params, $this->currentPage - 1 > 0 ? 'page=' . ($this->currentPage - 1) : '');
    }

    private function query($params, $suffixQuery) {
        $query = '';
        if (!empty($params)) {
            foreach ($params as $k => $v) {
                if ($k === 'page') {
                    continue;
                }
                $v = urlencode($v);
                $query .= "&{$k}={$v}";
            }
        }
        if (!empty($suffixQuery)) {
            $query .= "&{$suffixQuery}";
        }
        return $query[0] === '&' ? substr($query, 1, strlen($query) - 1) : $query;
    }
}