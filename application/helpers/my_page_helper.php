<?php

/**
* This function is used to create an ajax request anywhere using jquery ajax
* 
* @param string $url
* @param array $onSuccess
* @param string $methodName
* @return string
*/
function createAjaxRequest($url = null, $onSuccess = array(), $methodName = null, $isData = array(), $myMethod = 'POST')
{
   $functions = null;
   if (!empty($onSuccess)) {
       foreach ($onSuccess as $row) {
           $functions .= $row.';';
       }  
   }
   $methodName = (empty($methodName)? 'process': $methodName);
   $data  = '<script>';
   $data .= 'function '.$methodName.'(){';  
   $data .= 'var formData = $("form").serialize();';
   $data .= '$.ajax({';
   $data .= 'url: "' . $url . '",';
   $data .= ' type: "'.$myMethod.'",'; 
   $data .= ' async: true,';
   $data .= ' cache: false,';
   $data .= ' data: formData,';
   $data .= 'success: function(data){' . $functions . '} });';
   $data .= '}</script>';       
   return $data;
}

/**
* Returns a format of data that ajax reads
* 
* @param array $data
* @return string
*/
function _serialize($data = array()) 
{   
   $lastKey = _lastKeyArray($data);
   $result  = '{ ';
   foreach ($data as $key => $values) {
       if (count($data) == 1 || $lastKey == $key) {
           $valuesPass  = (preg_match('/document/', $values) || preg_match('/\'#/', $values) ? $values:'"'.$values.'"');
           $result .= '"'.$key.'" : '.$valuesPass;
       }
       else {
           $valuesPass  = (preg_match('/document/', $values) || preg_match('/\'#/', $values) ? $values:'"'.$values.'", ');
           $result .= '"'.$key.'" : '.$valuesPass;
       }            
   }
   $result  .= '}';

   return $result;
}


function _lastKeyArray($args = array()) 
{
  $key = array_keys($args);
  return end($key);
}


/**
 * Gets all files in a directory
 * 
 * @param string $dir
 * @param boolean $recursive
 * @param string $basedir
 * @return array
 */
function scanAllFiles($dir, $recursive = true, $basedir = '') {
    if ($dir == '') {return array();} else {$results = array(); $subresults = array();}
    if (!is_dir($dir)) {$dir = dirname($dir);} // so a files path can be sent
    if ($basedir == '') {$basedir = realpath($dir).DIRECTORY_SEPARATOR;}

    $files = scandir($dir);
   
    foreach ($files as $key => $value){
        if ( ($value != '.') && ($value != '..') ) {
            $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
            if (is_dir($path)) { // do not combine with the next line or..
                if ($recursive) { // ..non-recursive list will include subdirs
                    $subdirresults = scanAllFiles($path,$recursive,$basedir);
                    $results = array_merge($results,$subdirresults);
                }
            } else { // strip basedir and add to subarray to separate file list
                $subresults[] = str_replace($basedir,'',$path);
            }
        }
    }
    // merge the subarray to give the list of files then subdirectory files
    if (count($subresults) > 0) {$results = array_merge($subresults,$results);}   
    return $results;
}

/**
 * Generates random image.
 * 
 * @return string
 */
function random_image($dir = null) {
    $images = scanAllFiles($dir);
    
    foreach ($images as $key => $value) {        
        $data[$key] = str_replace('page\\', '', $value);
    }
    
    foreach ($data as $key => $value) {
        if ($value == 'index.html') {
            unset($data[$key]);
        }
    }
    
    return $data[rand(0, count($data) -1)];
}

/**
 * Used for debugging.
 * 
 * @param array $data
 */
function hrd($data = array()) {
   echo '<pre>'; 
   print_r($data);
   echo '</pre>';
}

/**
 * Redirects you with time.
 * 
 * @param string $url
 * @param int $time
 */
function redirectWithTime($url = null, $time = 2000) {
    echo '<script>window.setTimeout(function(){ window.location = "'.base_url().$url.'"; },'.$time.')</script>';
}

/**
 * Prompt Success
 * 
 * @param string $message
 * @return string
 */
function promptSuccess($message = null) {
    return '<div class="alert alert-success">
                '.$message.'
            </div>';
}

/**
 * Prompt Info
 * 
 * @param string $message
 * @return string
 */
function promptInfo($message = null) {
    return '<div class="alert alert-info">
                '.$message.'
            </div>';
}

/**
 * Prompt Warning
 * 
 * @param string $message
 * @return string
 */
function promptWarning($message = null) {
    return '<div class="alert alert-warning">
            '.$message.'
        </div>';
}

/**
 * Prompt Danger
 * 
 * @param string $message
 * @return string
 */
function promptDanger($message = null) {
    return '<div class="alert alert-danber">
            '.$message.'
        </div>';
}


function showModal($title = null, $message = null, $dataTarget = null) {
    return '<div class="modal" tabindex="-1" role="dialog" id="'.$dataTarget.'">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">'.$title.'</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        '.$message.'
      </div>
      <div class="modal-footer">       
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>';    
}

/**
 * Select for form
 * 
 * @param array $arr
 * @return string
 */
function select($arr = array(), $post = null) {
    $data = null;
    if (!empty($arr)) {
        foreach ($arr as $value) {
            $data .= '<option '.($post == $value->id ? 'selected':'').' value="'.$value->id.'">'.$value->name.'</option>';
        }
    } 
    return $data;
}

/**
 * Select for form
 * 
 * @param array $arr
 * @return string
 */
function select2($arr = array(), $post = null) {
    $data = null;
    
    if (!empty($arr)) {
        foreach ($arr as $value) {
            $data .= '<option '.($post == $value['id'] ? 'selected':'').' value="'.$value['id'].'">'.$value['name'].'</option>';
        }
    } 
    return $data;
}