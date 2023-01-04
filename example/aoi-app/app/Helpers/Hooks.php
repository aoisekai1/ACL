<?php
    use App\Models\Menu;

    if(!function_exists('ListMenu')){
        function ListMenu(){
            $menu = new menu;
            $results = $menu->get_list_menu();
            return $results;
        }
    }
    if(!function_exists('STATUS')){
        function STATUS($code=null){
            $data = array(
                '0' => 'Not Active',
                '1' => 'Active'
            );
            if(!is_null($code)){
                return $data[$code];
            }
            return $data;
        }
    }
    if(!function_exists('JSONRES')){
        function JSONRES($error, $msg="", $params=array()){
            $data = array(
                'error' => $error, 
                'message' => $msg
            );
            if (!empty($params)) {
                foreach ($params as $index => $value) {
                    $data[$index] = $value;
                }
            }
            $json = json_encode($data);
            return $json;
        }
    }
    if(!function_exists('FORMAT_DATE')){
        function FORMAT_DATE($date=null, $format="Y-m-d"){
            if(is_null($date)){
                 $date = date('Y-m-d');
            }
            if($date == 'first'){
                $date = date('Y-m-01');
            }
            if($date == 'last'){
                $date = date('Y-m-t');
            }
            $date = date($format, strtotime($date));
            return $date;
        }
    }
    if(!function_exists('SUB_STATUS')){
        function SUB_STATUS($code=null){
            $data = array(
                'L' => 'Label',
                'H' => 'Menu',
                'S' => 'Sub Menu' 
            );
            if(!is_null($code)){
                return $data[$code];
            }
            return $data;
        }
    }

    /**
     * @param [number] <integer>
     * @param [symbol] <string> <optional> //Default comma
     * @param [dec] <integer> <optional> //Default two digit after comma
     * @return <String>
     * Example:
     * FORMAT_CURRENCY($number); //Default comma(,) and two digits after the comma
     * FORMAT_CURRENCY($number, 3); // 3 mean three digits after the comma
     * 
     */
    if (!function_exists('FORMAT_CURRENCY')) {
        function FORMAT_CURRENCY($number = 0, $symbol = ',', $dec = 2)
        {
            $currency = 0;
            $symbol_arr = [',', '.'];
            $tmp_symbol = $symbol;
            $symbol = !in_array($tmp_symbol, $symbol_arr) ? "," : $symbol;
            $dec = !in_array($tmp_symbol, $symbol_arr) ? $tmp_symbol : $dec;
            if ($symbol == ".") {
                $currency = number_format($number, $dec, $symbol, ",");
            } else if ($symbol == ",") {
                $currency = number_format($number, $dec, $symbol, ".");
            }
            return $currency;
        }
    }
    /**
     * For data duplicate
     * @param $data [array]
     * @param $num [number] => start value change to null default 2
     * Example:
     * $data = array(
     *    array('name' => 'Anita', age=> 20), //Duplicate name
     *    array('name' => 'Anita', age=> 15), //Duplicate name
     *    array('name' => 'Dani', age=> 30)
     * );
     * if you use this function will be get output when foreach data:
     * Table
     * ===========
     * No | Name  | Age
     * ===========
     * 1  | Anita | 20
     * 2  |       | 15
     * 3  | Dani  | 30
     */
    if (!function_exists('GROUPING_DATA')) {
        function GROUPING_DATA($data = array(), $num = 2)
        {
            if (empty($data)) {
                return $data;
            }
            $last_row = end($data);
            $fname = GET_KEYS($last_row)[0];
            $prev_name = '';
            $data = (object)$data;
            foreach ($data as $i => &$r) {
                $curr_fname = $r->$fname;
                if ($r->$fname == $prev_name) {
                    foreach (GET_KEYS($last_row) as $i => $index) {
                        $r->$index = $i <= $num ? "" : $r->$index;
                    }
                }
                $prev_name = $curr_fname;
            }

            return $data;
        }
    }
    if (!function_exists('GET_KEYS')) {
        function GET_KEYS($row)
        {
            $row = (array)$row;
            $keys = array_keys($row);
            $columns = array();
            foreach ($keys as $r) {
                array_push($columns, $r);
            }

            return $columns;
        }
    }

    /**
     * This function use when you want to insert data using file csv
     * and limit data is 100
     * @param $data <Array>
     * How to use:
     * 1. create new variabel same like $files = $_FILES['upload_file'];
     * 2. use function PARSE_CSV example: PARSE_CSV($files);
     * 3. you will get return array();
     */
    if (!function_exists('PARSE_CSV')) {
        function PARSE_CSV($data)
        {
            $extension = explode('.', $data['name']);
            $extension = strtolower(end($extension));
            $results = array();
            $limit = 100;
            $file = fopen($data['tmp_name'], "r"); //open the file
            if ($extension == 'csv') {
                if (($open_file = fopen($data['tmp_name'], 'r')) !== FALSE) {
                    // Headrow
                    $key = fgetcsv($file, 4096, ',', '"');
                    while (($column = fgetcsv($open_file)) !== FALSE) {
                        $count = count($column);
                        $column = array_combine($key, $column);
                        array_push($results, $column);
                    }
                }

                fclose($open_file);
            }
            if (count($results) >= $limit) {
                return JSONRES(WARNING, 'Ops, data limit is more 100');
            }
            return $results;
        }
    }
?>