<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Lib\Traits;

use Cake\ORM\Query;
use \App\Lib\Api\ApiPaginator;

trait PaginatorTrait {

    public function paginator(Query $query, ApiPaginator $ApiPaginator) {
        $ApiPaginator->setCountResult($query->count());
        $query->offset($ApiPaginator->getOffset());
        $query->limit($ApiPaginator->getLimit());
        $result = $this->emptyArrayIfNull($query->toArray());
        $ApiPaginator->setCurrent(sizeof($result));
        $ApiPaginator->paginator();
        return $result;
    }
    
    public function emptyArrayIfNull($result) {
        if ($result === null) {
            return [];
        }
        return $result;
    }
}