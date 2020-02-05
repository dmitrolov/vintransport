<?php
require_once('config.php');
				
				
function vardump($var){
  echo '<pre>';
  print_r($var);
  echo '</pre>';
}

function db_custom_query($q){
	getDbConnect();
	$result = mysql_query($q) or die('db_custom_query'.mysql_error());
	return $result;	
}

// Источник - https://ru.stackoverflow.com/q/285465 (с личными вкраплениями)
// $page - массив страниц с базы (обязательные аттрибуты элементов - id, name, parent_id)
// $method - способ вывода (варианты - select [-|--], list [ul|li], link-list [ul|li+a] - где обязателен аттрибут элемента url)
// $parent_id - id элемента, который будет считаться корневым.
function make_page_tree($pages,$parent_id,$method){
	function form_tree($mess)
	{
	    if (!is_array($mess)) {
	        return false;
	    }
	    $tree = array();
	    foreach ($mess as $value) {
	        $tree[$value['parent_id']][] = $value;
	    }
	    return $tree;
	}
	if ($method == 'select'){
		function build_tree($cats, $parent_id = 0, $level = ''){
		    if (is_array($cats) && isset($cats[$parent_id])) {
        	$level.='&emsp;&emsp;';
		        foreach ($cats[$parent_id] as $cat) {
		            $tree .= '<option value="'.$cat['id'].'">'.$level.$cat['name'];
		            $tree .= build_tree($cats, $cat['id'], $level);
		        }
		    } else {
		    	$level = '';
		        return false;
		    }
		    return $tree;
		}
	}
	if ($method == 'list'){
		function build_tree($cats, $parent_id = 0){
		    if (is_array($cats) && isset($cats[$parent_id])) {
		        $tree = '<ul class="tree">';
		        foreach ($cats[$parent_id] as $cat) {
		            $tree .= '<li>' . $cat['name'];
		            $tree .= build_tree($cats, $cat['id']);
		            $tree .= '</li>';
		        }
		        $tree .= '</ul>';
		    } else {
		        return false;
		    }
		    return $tree;
		}
	}
	if ($method == 'link-list'){
		function build_tree($cats, $parent_id = 0){
		    if (is_array($cats) && isset($cats[$parent_id])) {
		        $tree = '<ul class="tree">';
		        foreach ($cats[$parent_id] as $cat) {
		            $tree .= '<li>'.'<a href="?p=pages&s=edit&pid='.$cat['id'].'">'. $cat['name'] .'</a>';
		            $tree .= build_tree($cats, $cat['id']);
		            $tree .= '</li>';
		        }
		        $tree .= '</ul>';
		    } else {
		        return false;
		    }
		    return $tree;
		}
	}
	return build_tree(form_tree($pages), $parent_id);
}


// Пример: function( 'table', array('key' => 'value', 'key' => 'value'), array('key' => 'value', 'key' => 'value'), 'ORDER', 'DIRECTION')
function db_select_data($table, $fields, $where = false, $order = false, $direction = false){
	getDbConnect();
	
	$q = 'SELECT ';
	$temp_arr = array();
	if($fields){
		if(is_array($fields)){
			$temp_arr = array();
			foreach($fields as $value){
				if($value == '*'){
					$temp_arr = array('*');
				}else{
					$value = '`'.$value.'`';
					$temp_arr[] = $value;					
				}
			}
		}else{
			$temp_arr[] = '*';
		}
	}else{die('expected \'fields\' parameter');}
	$q = $q.implode(',', $temp_arr);
	
	
	if($table){
		$q = $q.' FROM `'.$table.'`';
	}else{die('expected \'table\' parameter');}
	
	if($where){
		if(is_array($where)){
			$temp_arr = array();
			foreach($where as $key=>$value){
				if(is_int($value) || $key == 'id'){
					$temp_arr[] = '`'.$key.'`='.$value;
				} else {
					$temp_arr[] = '`'.$key.'`=\''.$value.'\'';
				}
			}
		}
		$q = $q.' WHERE '.implode(',', $temp_arr);
	}
	
	if($order){
		if(is_array($order)){
			$temp_arr = array();
			foreach($order as $value){
				$value = '`'.$value.'`';
				$temp_arr[] = $value;
			}
		}
		$q = $q.' ORDER BY '.implode(',', $temp_arr);
	}
	
	if(strtoupper($direction) == 'ASC' OR strtoupper($direction) == 'DESC'){
		$q = $q.' '.strtoupper($direction);
	}

	//vardump($q);
	
	$res = mysql_query($q) or die('db_select_data'.mysql_error());
	
	//vardump($res);

	$i=0;
	while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
		$result[$i] = $row;    
		$i++;    
	}
		
	//vardump($result);
	
	if(count($result) == 1){
		$result = $result[0];
		if(count($result) == 1){
			$result = current($result);
		}
	}
	
	return $result;
	

}

// Пример: function( 'table', array('key' => 'value', 'key' => 'value'))
function db_insert_data($table, $fields){ 									
	getDbConnect();
	
	$q = 'INSERT INTO';
	$temp_arr = array();
	
	if($table){
		$q = $q.' `'.$table.'`';
	}else{die('expected \'table\' parameter');}
	
	if($fields){
		if(is_array($fields)){
			$temp_arr = array();
			foreach($fields as $key=>$value){
				$temp_arr[] = '`'.$key.'`=\''.$value.'\'';
			}
		}
		$q = $q.' SET '.implode(',', $temp_arr);
	}else{die('expected \'fields\' parameter');}
	
	
	//vardump($q);
	mysql_query($q) or die('db_insert_data'.mysql_error());
	
}


// Пример: function( 'table', array('key' => 'value', 'key' => 'value'), array('key' => 'value', 'key' => 'value'))
function db_update_data($table, $fields, $where){                            
	getDbConnect();
	
	$q = 'UPDATE';
	$temp_arr = array();
	
	if($table){
		$q = $q.' `'.$table.'`';
	}else{die('expected \'table\' parameter');}
	
	if($fields){
		if(is_array($fields)){
			$temp_arr = array();
			foreach($fields as $key=>$value){
				if(is_int($value)){
					$temp_arr[] = '`'.$key.'`='.$value;
				} else {
					$temp_arr[] = '`'.$key.'`="'.$value.'"';
				}
			}
		}
		$q = $q.' SET '.implode(',', $temp_arr);
	}else{die('expected \'fields\' parameter');}
	
	if($where){
		if(is_array($where)){
			$temp_arr = array();
			foreach($where as $key=>$value){
				if(is_int($value)){
					$temp_arr[] = '`'.$key.'`='.$value;
				} else {
					$temp_arr[] = '`'.$key.'`="'.$value.'"';
				}
			}
		}
		$q = $q.' WHERE '.implode(' AND ', $temp_arr);
	}else{die('expected \'where\' parameter');}
	
	//vardump($q);
	
	mysql_query($q) or die('db_update_data'.mysql_error());
	
}

// Пример: function( 'table', array('key' => 'value', 'key' => 'value'))
function db_delete_data($table, $where){
	getDbConnect();
	
	$q = 'DELETE FROM';
	$temp_arr = array();
	
	if($table){
		$q = $q.' `'.$table.'`';
	}else{die('expected \'table\' parameter');}
	
	if($where){
		if(is_array($where)){
			$temp_arr = array();
			foreach($where as $key=>$value){
				if(is_int($value)){
					$temp_arr[] = '`'.$key.'`='.$value;
				} else {
					$temp_arr[] = '`'.$key.'`="'.$value.'"';
				}
			}
		}
		$q = $q.' WHERE '.implode(',', $temp_arr);
	}else{die('expected \'where\' parameter');}
	
	mysql_query($q) or die('db_insert_data'.mysql_error());
}

function remakeDate($date){
	$date = explode('-',$date);
	$date = $date[2].'-'.$date[1].'-'.$date[0];
	return $date;
}

?>