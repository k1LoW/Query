<?php
App::uses('AppController', 'Controller');

/**
 * QueryController
 *
 */
class QueryController extends AppController {

    public $uses = array('Query.Query');
    public $components = array('Session',
                               'Security'
                               );
    public $helpers = array('Html', 'Form');

    /**
     * beforeFilter
     *
     */
    public function beforeFilter(){
        if (Configure::read('debug') < 2) {
            throw new NotFoundException(__('Invalid Access'));
        }
    }

    /**
     * beforeRender
     *
     */
    public function beforeRender(){
        $source = $this->Query->getDataSourceInfo();
        $tables = $this->Query->getTableNames();
        $this->set(compact('source', 'tables'));
    }

    /**
     * index
     *
     */
    public function index(){
        try {
            $result = $this->Query->execute($this->request->data);
        } catch (QueryException $e) {
            $this->Session->setFlash(__d('Query', 'Invalid Query'));
        } catch (PDOException $e) {
            $this->Session->setFlash(__d('Query', 'Invalid Query: ') . $e->getMessage());
        }
        if (empty($result)) {
            $this->set('queries', $this->Query->findRecentQueries());
        }
        $this->set(compact('result'));
    }

    /**
     * queries
     *
     */
    public function queries(){
        $this->set('queries', $this->paginate());
    }

    /**
     * add
     *
     * @param $arg
     */
    public function add(){
        try {
            $this->Query->add($this->request->data);
            $this->Session->setFlash(__d('Query', 'Query has been saved'));
            $this->redirect(array('action' => 'queries'));
        } catch (QueryException $e) {
            $this->Session->setFlash(__d('Query', 'Invalid Query'));
            $this->redirect(array('action' => 'index'));
        } catch (Exception $e) {
            $this->Session->setFlash(__d('Query', 'Invalid Query: ') . $e->getMessage());
            $this->redirect(array('action' => 'index'));
        }
     }

    /**
     * delete
     *
     */
    public function delete($id, $from_action  = 'index'){
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Query->id = $id;
        if (!$this->Query->exists()) {
            throw new NotFoundException(__d('Query', 'Invalid Query'));
        }
        if ($this->Query->delete()) {
            $this->Session->setFlash(__d('Query', 'Query deleted'));
            $this->redirect(array('action' => $from_action));
        }
        $this->Session->setFlash(__d('Query', 'Query was not deleted'));
        $this->redirect(array('action' => $from_action));
    }
}