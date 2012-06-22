<?php
App::uses('AppModel', 'Model');
App::uses('QueryException', 'Query.Error');
/**
 * Query Model
 *
 */
class Query extends AppModel {

    public $order = array('Query.modified DESC');
    public $validate = array('query' => array('rule' => 'notEmpty'));

    /**
     * getDataSourceInfo
     *
     */
    public function getDataSourceInfo(){
        $db = ConnectionManager::getDataSource($this->useDbConfig);
        return '[' . $db->config['datasource'] . ']' . $db->config['login'] . '@' . $db->config['host'] . ':' . $db->config['port'] . '/' . $db->config['database'];
    }

    /**
     * listSources
     *
     */
    public function getTableNames(){
        $db = ConnectionManager::getDataSource($this->useDbConfig);
        return $db->listSources();
    }

    /**
     * findRecentQueries
     *
     */
    public function findRecentQueries(){
        $query = array();
        $query['limit'] = 5;
        $query['order'] = array('Query.modified DESC');
        return $this->find('all', $query);
    }

    /**
     * execute
     *
     * @param $data
     */
    public function execute($data){
        if (!empty($data)) {
            $this->set($data);
            if (!$this->validates()) {
                throw new QueryException();
            }
            $query = $data['Query']['query'];
            try {
                $result = $this->query($query);
                $this->add($data);
                return $result;
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    /**
     * add
     *
     * @param $data
     */
    public function add($data){
        if (!empty($data)) {
            $this->create();
            $this->set($data);
            $result = $this->validates();
            if ($result === false) {
                throw new QueryException();
            }
            $query = $data['Query']['query'];
            $current = $this->find('first', array(
                                                  'conditions' => array(
                                                                        "Query.query" => $query,
                                                                        )));
            if (!empty($current)) {
                $data = $current;
                unset($data['Query']['created']);
                unset($data['Query']['modified']);
            }

            $result = $this->save($data);
            if ($result !== false) {
                $this->data = array_merge($data, $result);
                return true;
            } else {
                throw new OutOfBoundsException(__('Could not save, please check your inputs.', true));
            }
            return;
        }
    }
}
