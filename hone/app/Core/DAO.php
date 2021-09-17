<?php

/*
 * Copyright 2021 Ludovic CHANGEON 
 * License : LGPL-3.0-or-later
 * 
 * This file is part of Hone Framework.
 *
 * Hone Framework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * Hone Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.

 * You should have received a copy of the GNU Lesser General Public License
 * along with Hone Framework.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace App\Core;

use App\Models as models;
use App\Core\Exceptions as exceptions;
use App\Core\QueryBuilder as qbuilder;

/**
 * DAO : DAO is thought as an interface to ensure all DAO objects will
 * presents the same skeleton. That's why mandatory methods have been
 * declared as abstract. 
 *
 */
abstract class DAO {
    
    protected $dbc = null;
    private $driver_option;
    private $fetch_style;
    private $qfactory;
    
    protected function DAO($dbConnection){
        $this->dbc = $dbConnection;
        $this->driver_option = array(\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY);
        $this->fetch_style = \PDO::FETCH_ASSOC;
        $this->qfactory = new qbuilder\QueryFactory(DRIVER, qbuilder\QueryFactory::COMMON);
    }

    protected function buildFilter($dataSet, $operators = array()){
        if(!empty($operators)){
                echo 'toto';
        }
        $data = implode(" AND ", array_map(
        function ($column) { 
            $operator = '=';
            if(!empty($operators)){
                if(array_key_exists($column, $operators)){
                    echo $column;
                }
                //echo $column;
            }
            return "`$column` $operator :$column"; },
        array_keys($dataSet)
        ));
        return $data;
    }
    
    protected function buildParam($dataSet){
        $data = implode(" , ", array_map(
        function ($column) { return "`$column`=:$column"; },
        array_keys($dataSet)
        ));
        return $data;
    }
    
    protected function buildOrdered($dataSet){
        $data = implode(" , ", array_map(
        function ($column) { return "`$column`"; },
        array_values($dataSet)
        ));
        $data = str_replace(', `ASC`', ' ASC', $data);
        $data = str_replace(', `DESC`', ' DESC', $data);
        return $data;
    }
 
    abstract function create($dataSet);
    abstract function delete($dataSet);
    //abstract function update($dataSet);
    abstract function find($dataSet);
    abstract function find_all($dataSet);

    /* -- singleRowPreprocSelect --
    * 
    */
    
    protected function newSelect(){
        return $this->qfactory->newSelect();
    }
    
    protected function newUpdate(){
        return $this->qfactory->newUpdate();
    }
    
    protected function newDelete(){
        return $this->qfactory->newDelete();
    }
    
    protected function newInsert(){
        return $this->qfactory->newInsert();
    }
    
    private function computeSelectStatement($table, &$dataSet){
        $qselect = $this->qfactory->newSelect();
        $qselect->from($table);
        
        foreach($dataSet as $key => $value){

            if(substr($key, 0, 1)=='!'){
                $effectiveKey = str_replace('!', '', $key);
                $dataSet[$effectiveKey] = $value;
                unset($dataSet[$key]);
                
                $qselect->where("`$effectiveKey` <> :$effectiveKey") ;
            } else {
                $qselect->where("`$key` = :$key") ;
            } 
           
        }
        
        $stmt = $this->dbc->prepare($qselect->getStatement(), $this->driver_option);  
        return $stmt;
    }
    
    private function singleRowSelect($className, $table, $dataSet){
    
        $stmt = $this->computeSelectStatement($table, $dataSet);
        $stmt->execute($dataSet);
        $row = $stmt->fetch($this->fetch_style);
        
        if($className==NULL){
            return $row;
        } else {
            $foundRow = NULL;
            if($row!==FALSE){
                $foundRow = new $className($row);
            }
            return $foundRow;
        }
    }
    
    protected function selectRow($table, $dataSet){
         return $this->singleRowSelect(NULL, $table, $dataSet);
    }
    
    protected function selectRowAsObject($className, $table, $dataSet){
         return $this->singleRowSelect($className, $table, $dataSet);
    }
    
    protected function multiRowsSelect($className, $table, $dataSet){

        $stmt = $this->computeSelectStatement($table, $dataSet);
        $stmt->execute($dataSet);
        
        $foundRows = array();
        while ($row = $stmt->fetch($this->fetch_style)) {
            
            if($className==NULL)
                $currentRow = $row;
            else
                $currentRow = new $className($row);
            
            array_push($foundRows, $currentRow);
        }
	return $foundRows; 
    }

    protected function selectMultiRows($table, $dataSet){
         return $this->multiRowsSelect(NULL, $table, $dataSet);
    }
    
    protected function selectMultiRowsAsObjects($className, $table, $dataSet){
         return $this->multiRowsSelect($className, $table, $dataSet);
    }
    
    private function singleRowPreBuildedSelect($className, $qselect){
        $stmt = $this->dbc->prepare($qselect->getStatement(), $this->driver_option);
        $stmt->execute($qselect->getBindValues());
        $row = $stmt->fetch($this->fetch_style);
        
        if($className==NULL){
            return $row;
        } else {
            $foundRow = NULL;
            if($row!==FALSE){
                $foundRow = new $className($row);
            }
            return $foundRow;
        }        
    }
    
    protected function selectRow_pb($qselect){
         return $this->singleRowPreBuildedSelect(NULL, $qselect);
    }
    
    protected function selectRowAsObject_pb($className, $qselect){
         return $this->singleRowPreBuildedSelect($className, $qselect);
    }

    private function multiRowsPreBuildedSelect($className, $qselect){
        $stmt = $this->dbc->prepare($qselect->getStatement(), $this->driver_option);
        $stmt->execute($qselect->getBindValues());
        $foundRows = array();
        while ($row = $stmt->fetch($this->fetch_style)) {
            
            if($className==NULL)
                $currentRow = $row;
            else
                $currentRow = new $className($row);
            
            array_push($foundRows, $currentRow);
        }
	return $foundRows;        
    }
    
    protected function selectMultiRows_pb($qselect){
         return $this->multiRowsPreBuildedSelect(NULL, $qselect);
    }
    
    protected function selectMultiRowsAsObject_pb($className, $qselect){
         return $this->multiRowsPreBuildedSelect($className, $qselect);
    }

    protected function update_pb($qupdate){
        
        $stmt = $this->dbc->prepare($qupdate->getStatement(), $this->driver_option);
        return $stmt->execute($qupdate->getBindValues());    
    }
    
    protected function insert_pb($qinsert){
        
        $stmt = $this->dbc->prepare($qinsert->getStatement(), $this->driver_option);
         
        if($stmt->execute($qinsert->getBindValues()))
            return $this->dbc->lastInsertId();
        else
            return FALSE;
    }
    
    protected  function deleteRows($table, $dataSet){
        $qdelete = $this->qfactory->newDelete();
        $qdelete->from($table);
        
        foreach($dataSet as $key => $value){
           $qdelete->where("`$key` = :$key") ;
        }

        $stmt = $this->dbc->prepare($qdelete->getStatement(), $this->driver_option);
        return $stmt->execute($dataSet);
        

    }
    
}
