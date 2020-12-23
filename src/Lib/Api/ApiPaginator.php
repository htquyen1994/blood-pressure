<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Lib\Api;

use \Cake\Controller\Controller;
use \Cake\Http\ServerRequest;

class ApiPaginator {
    private $Controller;
    private $page = 1;
    private $limit = 25;
    private $count = 0;
    private $pages = 1;
    private $current = 0;
    
    public function __construct(Controller $controller, ServerRequest $request) {
        $this->Controller = $controller;
        $this->limit = 25;
        
        $page = $request->getQuery('page');
        if (is_numeric($page)) {
            
        }
    }
    
    /**
     * @param int $page
     */
    public function setPage($page) {
        $this->page = $page;
    }

    /**
     * @param int $limit
     */
    public function setLimit($limit) {
        $this->limit = $limit;
    }

    /**
     * @param $current
     */
    public function setCurrent($current) {
        $this->current = $current;
    }

    /**
     * @return int
     */
    public function getPage() {
        return $this->page;
    }
    
    
    public function getOffset() {
        if ($this->page == 1) {
            return 0;
        } else {
            return (int)($this->limit * ($this->page - 1));
        }
    }
    
    /**
     * @return int
     */
    public function getLimit() {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function getPages() {
        return $this->pages;
    }
    
    public function setCountResult($count) {
        $this->count = $count;
        if($count == 0) {
            $this->pages = 1;
        } else {
            $this->pages = ceil($count/$this->limit);
        }
    }
    
    private function hasPrevPage() {
        return ($this->page !== 1);
    }
    
    private function hasNextPage() {
        return ($this->page * $this.$this->limit) > $this->count;
    }
    
    public function getPaginator() {
        return [
            'page'       => (int)$this->page,
            'current'    => $this->current,
            'count'      => $this->count,
            'prevPage'   => $this->hasPrevPage(),
            'nextPage'   => $this->hasNextPage(),
            'pageCount'  => $this->pages,
            'limit'      => $this->limit,
            'options'    => [],
            'paramType'  => "named",
            'queryScope' => null,
        ];
    }
    
    
    public function paginator() {
        $this->Controller->set('paging', $this->getPaginator());
    }
}