<?php
	function curl_get_contents($url,$request,$username=null,$password=null,$headers=array()) {
		$curl = curl_init();
		curl_setopt_array($curl, [
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => $request,
			CURLOPT_POSTFIELDS => "{\"username\":\"".$username."\", \"password\":\"".$password."\"}",
			CURLOPT_HTTPHEADER => $headers,
		]);
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		
		if($err) {
		  return "cURL Error #:" . $err;
		} else {
		  return $response;
		}
	}
	
	function highlight_match($str,$query) {
		$highlighted_str = '';
		$num_matches = substr_count(strtolower($str), strtolower($query));
		for($i=0; $i<$num_matches; $i++)
		{
			$query_begin = stripos($str,$query);
			$query_length = strlen($query);
			$match = substr($str,$query_begin,$query_length);
			$str_tmp = substr($str,$query_begin+$query_length);
			$highlighted_str_tmp = substr($str,0,$query_begin+$query_length);
			$str = $str_tmp;
			$highlighted_str_tmp = str_replace($match,'<span class="highlight">'.$match.'</span>',$highlighted_str_tmp);
			$highlighted_str .= $highlighted_str_tmp;
		}
		$highlighted_str .= $str;
		
		return $highlighted_str;
	}
	
	if(isset($_GET['query']) AND ($_GET['query'] != '')) $query = $_GET['query'];
	else $query = '';
	
	$response = curl_get_contents("https://api.baubuddy.de/index.php/login","POST","365","1",array("Authorization: Basic QVBJX0V4cGxvcmVyOjEyMzQ1NmlzQUxhbWVQYXNz","Content-Type: application/json"));
	$response = json_decode($response,TRUE);
	if(is_array($response))
	{
		$access_token = $response['oauth']['access_token'];
		$data = curl_get_contents("https://api.baubuddy.de/dev/index.php/v1/tasks/select","GET",null,null,array("Authorization: Bearer ".$access_token));
		$data = json_decode($data,TRUE);
		
		if(is_array($data))
		{
			$table = '<table>';
				$table .= '<tr>';
					$table .= '<th>Task</th>';
					$table .= '<th>Title</th>';
					$table .= '<th>Description</th>';
					$table .= '<th>Color code</th>';
				$table .= '</tr>';
				$match = FALSE;
				foreach($data AS $id => $element)
				{
					$color_code = $element['colorCode'];
					if(($query == '') OR stristr($element['task'],$query) OR stristr($element['title'],$query) OR stristr($element['description'],$query) OR stristr($element['colorCode'],$query))
					{	
						$match = TRUE;
						
						if($query != '')
						{
							$element['task'] = highlight_match($element['task'],$query);
							$element['title'] = highlight_match($element['title'],$query);
							$element['description'] = highlight_match($element['description'],$query);
							$element['colorCode'] = highlight_match($element['colorCode'],$query);
						}
						
						$table .= '<tr>';
							$table .= '<td>'.$element['task'].'</td>';
							$table .= '<td>'.$element['title'].'</td>';
							$table .= '<td>'.$element['description'].'</td>';
							$table .= '<td class="color_code" style="background-color:'.$color_code.';">'.$element['colorCode'].'</td>';
						$table .= '</tr>';
					}
				}
			$table .= '</table>';
			
			if($match) echo $table;
			else echo '<div class="no_results">Your search returned no results.</div>';
		}
		else echo '<div class="no_results">Error: '.$data.'</div>'; 
	}
	else echo '<div class="no_results">Error: '.$response.'</div>'; 
?>
