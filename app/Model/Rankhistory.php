<?php

App::uses('AppModel', 'Model');

/**
 * Rankhistory Model
 *
 * @property Keyword $Keyword
 */
class Rankhistory extends AppModel {

        /**
         * Use table
         *
         * @var mixed False or table name
         */
        public $useTable = 'rankhistory';

        /**
         * Primary key field
         *
         * @var string
         */
        public $primaryKey = 'ID';

        /**
         * Display field
         *
         * @var string
         */
        public $displayField = 'ID';


        //The Associations below have been created with all possible keys, those that are not needed can be removed

        /**
         * belongsTo associations
         *
         * @var array
         */
        public $belongsTo = array(
            'Keyword' => array(
                'className' => 'Keyword',
                'foreignKey' => 'KeyID',
                'conditions' => '',
                'fields' => '',
                'order' => ''
            )
        );

        /**
         * CSV export
         *
         * @var array
         */
        public $actsAs = array(
            'CsvExport' => array(
                'delimiter' => ',', //The delimiter for the values, default is ;
                'enclosure' => '"', //The enclosure, default is "
                'max_execution_time' => 360, //Increase for Models with lots of data, has no effect is php safemode is enabled.
                'encoding' => 'utf8' //Prefixes the return file with a BOM and attempts to utf_encode() data
            )
        );

        public function header_csv_by_keyword($headers, $mapHeader) {
                $data_headers = array();
                foreach ($headers as $key => $header) {
                        if (isset($mapHeader[$header]) && !empty($mapHeader[$header])) {
                                if($header=='Rankhistory.Rank'){
                                        $engines = explode('/', $mapHeader[$header]);
                                        $data_headers[] = trim($engines[0]);
                                        $data_headers[] = trim($engines[1]);
                                }else{
                                        $data_headers[] = $mapHeader[$header];
                                }                                
                        } else {
                                $data_headers[$key] = $header;
                        }
                }
                return $data_headers;
        }

        public function row_csv_by_keyword($values) {
                $data_values = array();
                foreach ($values as $key => $value) {
                        if($key=='Rankhistory.Rank'){
                                $engines = explode('/', $value);
                                $data_values[$key.'.Google'] = trim($engines[0]);
                                $data_values[$key.'.Yahoo'] = trim($engines[1]);
                        }else if($key=='Rankhistory.RankDate'){
                                $data_values[$key] = date('Y-m-d',  strtotime($value));
                        }else{
                                $data_values[$key] = $value;
                        }                        
                }
                return $data_values;
        }

}

?>