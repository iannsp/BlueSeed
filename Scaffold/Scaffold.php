<?php

namespace BlueSeed\Scaffold;

/**
 * @author iann
 *
 *
 */
use BlueSeed\ActiveRecord;
use BlueSeed\Request;
use BlueSeed\Crud\Crud;

class Scaffold {

    private $objData;
    private $request;
    private $template;

    function __construct(ActiveRecord $objData, Request $request, Template $tmpl) {
        $this->objData = $objData;
        $this->request = $request;
        $this->template = $tmpl;
    }

    public static function creator(ActiveRecord $objData, Request $request, Template $tmpl) {
        return New Scaffold($objData, $request, $tmpl);
    }

    public function create($newrecord = false) {
        
        if (!$newrecord) {
            $crud = New Crud($this->objData);
            $crud->create($this->request->getParams());
            $indexname = $this->objData->getIndexName();
            $this->objData->$indexname = null;
            $this->read();
        } else {
            $template = $this->template;
            $indexname = $this->objData->getIndexName();
            $template->setTemplateObject($this->objData);
            $template->setData(Array($this->objData));
            $template->form();
        }
    }

    public function read() {
        $template = $this->template;
        $indexname = $this->objData->getIndexName();
        if (!is_null($this->objData->$indexname)) {
            $template->setTemplateObject($this->objData);
            $template->setData(Array($this->objData));
            $template->form();
        } else {
            $template->setTemplateObject($this->objData);
            $template->setData($this->objData->fetchAll());
            $template->index();
        }
    }

    public function update() {
        echo "Em Atualizar<br/>";
        $crud = New Crud($this->objData);
        $crud->update($this->request->getParams());
        $indexname = $this->objData->getIndexName();
        $this->objData->$indexname = null;
        return $this->read();
    }

    public function delete() {
        echo "Em Apagar<br/>";
        $crud = New Crud($this->objData);
        $crud->delete($this->request->getParams());
        $indexname = $this->objData->getIndexName();
        $this->objData->$indexname = null;
        return $this->read();
    }

    public function make() {
        $indexname = $this->objData->getIndexName();
        $idxval = $this->request->getQuery(2);
        $idxname = $this->request->getQuery(1);
        if (!is_null($idxval)) {
            $this->objData = $this->objData->find($idxval);
        }
        if ($this->request->isPost()) {
            // bssop BlueSeed(bs) Scaffold (s) Operation (op) // a button
            if (!is_null($this->request->getParam('bssop'))) {
                $this->delete();
            } else if ($this->request->getParam($indexname) != "") {
                return $this->update();
            } else {
                return $this->create();
            }
        } else if ($idxname == $this->objData->getIndexName()
                && is_null($idxval)) {
            return $this->create(true);
        } else {
            return $this->read();
        }
    }

}

?>