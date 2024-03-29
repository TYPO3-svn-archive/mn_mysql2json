<?php
require_once(PATH_tslib.'class.tslib_pibase.php'); 

class Table_eid extends tslib_pibase {
    var $extKey = 'tx_mnmysql2json';
    var $allowedTables = "";
    
    /**
     * Table_eid::main()
     * 
     * @return void
     */
    function main(){    
        tslib_eidtools::connectDB();

        $this->piVars = t3lib_div::_GET($this->extKey);
        if (is_array(t3lib_div::_POST($this->extKey))) {
            $this->piVars = array_merge($this->piVars, t3lib_div::_POST($this->extKey));
        }
        $result = array();
        
        $extConfig = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['mn_mysql2json']);
        
        $this->allowedTables = t3lib_div::trimExplode(",", $extConfig["allowedTables"]);
        
        switch ($this->piVars['action']) {
            case 'getTable' :
                if(!$this->checkForSqlCommands($this->piVars)) {
                    $result = $this->getTable(
                        $this->sanitizeInput($this->piVars['tableName']), 
                        $this->sanitizeInput($this->piVars['fields']), 
                        $this->sanitizeInput($this->piVars['where']), 
                        $this->sanitizeInput($this->piVars['groupBy']), 
                        $this->sanitizeInput($this->piVars['orderBy']), 
                        $this->sanitizeInput($this->piVars['limit'])
                    );    
                }
                else {
                    $result = array(
                        array(
                            'error' => 'Illegal action'
                        )
                    );
                }
            break; 
        }
        
        echo json_encode($result);
        
    }
    
    /**
     * Table_eid::getTable()
     * 
     * @param string $tableName the name of the mysql table
     * @param string $fields fields in the mysql table to select, separated by ,
     * @param string $where the where query, deleted != 1 and hidden != 1 is enabled by default
     * @param string $groupBy the group by query
     * @param string $orderBy the order query
     * @param integer $limit the limit query
     * @return array $result
     */
    private function getTable($tableName, $fields, $where = '', $groupBy = '', $orderBy = '', $limit = '') {
        
        if(in_array($tableName, $this->allowedTables)) {
            if($where) {
                $where = ' AND ' . $where;
            }
        
            $result = array();
            $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
                $fields, 
                $tableName, 
                'deleted != 1 AND hidden != 1' . $where,
                $groupBy, 
                $orderBy,
                $limit
            );
            
            while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
                if($row['bodytext']) {
                    $row['bodytext'] = $this->pi_RTEcssText($row['bodytext']);
                }
                $result[] = $row;
            }    
        }

        return $result;   
    }
    
    /**
     * A function to sanitize the input data from url
     * 
     * @param string $inputData the data to clean up
     * @return string $data the sanitized data
     */
    private function sanitizeInput($inputData) {
        $data = mysql_real_escape_string($inputData);
        $data = $GLOBALS['TYPO3_DB']->quoteStr($data);
        return $data;
    }
    
    /**
     * To prevent an SQL injection for any table or property in the database.
     * 
     * @param array $data the data to check for SQL injections
	 * @return boolean true or false depending on the outcome of parsing
     */
    private function checkForSqlCommands($data) {
        foreach($data as $key => $value) {
            if(preg_match('/(and|null|where|limit)/i', $value) || preg_match('/(union|select|from|having)/i', $value)) {
                return TRUE;
            }    
        } 
        return FALSE;
    }
    
}

$output = t3lib_div::makeInstance('Table_eid');
$output->main();

?>