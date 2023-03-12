<?php	
	function AutoremoteMessage($subject,$message,$key){

		$url = "https://autoremotejoaomgcd.appspot.com/sendmessage?key=" . $key . "&message=";
        $pStart = strpos($message, "[*");
        $pEnd = strrpos($message, "*]");
        if ($pStart !== false && $pEnd !== false){
            $message = substr($message,0,$pStart);
        }
		$url .= urlencode("notify=:=" . $subject . (!empty($message)?". ".$message:""));
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_PORT => "443",
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => array(
			"Cache-Control: no-cache",
			"Content-Type: application/x-www-form-urlencoded"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);

		if ($err) {
			echo "Error: " . $err . PHP_EOL;
		} else {
			echo "Sent via: AutoremoteMessage" . PHP_EOL;
		}
	}

	function AutoremoteNotification($subject,$message,$key){

		$url = "https://autoremotejoaomgcd.appspot.com/sendnotification?key=" . $key;
		$url .= "&title=" . urlencode($subject);
        $pStart = strpos($message, "[*");
        $pEnd = strrpos($message, "*]");
        $params = "";
        $paramsArr = null;
        if ($pStart !== false && $pEnd !== false){
            $params = substr($message,$pStart,($pEnd+2)-$pStart);
            $paramsArr = explode("*][*",$params);
            $message = substr($message,0,$pStart);
        }
		$url .= "&text=" . urlencode($message);
        if ($paramsArr != null){
            foreach ($paramsArr as $param){
                $param = str_replace("[*","",$param);
                $param = str_replace("*]","",$param);
                $action = substr($param,0,strpos($param, "="));
                $command = substr($param,strpos($param, "="),strpos($param, "=:="));
                $name = urlencode(substr($param,strrpos($param, "=")+1));
                $url .= "&" . $action . "=" . $command . "=:=" . $name;
                $url .= "&" . $action . "name=" . $name;
            }
        }
        $url .= "&action=arshow";
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_PORT => "443",
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => array(
			"Cache-Control: no-cache",
			"Content-Type: application/x-www-form-urlencoded"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);

		if ($err) {
			echo "Error: " . $err . PHP_EOL;
		} else {
			echo "Sent via: AutoremoteNotification" . PHP_EOL;
		}
	}

	function Pushbullet($subject,$message,$key){

		$url = "https://api.pushbullet.com:443/v2/pushes";
		$pStart = strpos($message, "[*");
        $pEnd = strrpos($message, "*]");
        if ($pStart !== false && $pEnd !== false){
            $message = substr($message,0,$pStart);
        }
        $postData = array(
			'type' => 'note',
			'title' => $subject,
			'body' => $message
		);
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_PORT => "443",
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => json_encode($postData),
		  CURLOPT_HTTPHEADER => array(
				"Access-Token: ". $key,
				"Cache-Control: no-cache",
				"Content-Type: application/json"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "Error: " . $err . PHP_EOL;
		} else {
			echo "Sent via: Pushbullet" . PHP_EOL;
		}
	}
	
	function NotifyMyEcho($subject,$message,$key){

		$url = "https://api.notifymyecho.com/v1/NotifyMe";
		$pStart = strpos($message, "[*");
        $pEnd = strrpos($message, "*]");
        if ($pStart !== false && $pEnd !== false){
            $message = substr($message,0,$pStart);
        }
        $postData = array(
			'accessCode' => $key,
			'title' => $subject,
			'notification' => $message
		);
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_PORT => "443",
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => json_encode($postData),
		  CURLOPT_HTTPHEADER => array(
				"Cache-Control: no-cache",
				"Content-Type: application/json"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "Error: " . $err . PHP_EOL;
		} else {
			echo "Sent via: NotifyMyEcho" . PHP_EOL;
		}
	}
	
	function IFTTT_WebHooks($subject,$message,$key,$webhook){

		$url = "https://maker.ifttt.com/trigger/".$webhook."/with/key/" . $key;
        $pStart = strpos($message, "[*");
        $pEnd = strrpos($message, "*]");
        if ($pStart !== false && $pEnd !== false){
            $message = substr($message,0,$pStart);
        }
		$postData = array(
			'value1' => $subject,
			'value2' => $message
		);
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_PORT => "443",
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => json_encode($postData),
		  CURLOPT_HTTPHEADER => array(
				"Content-Type: application/json"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);

		if ($err) {
			echo "Error: " . $err . PHP_EOL;
		} else {
			echo "Sent via: IFTTT-WebHooks" . PHP_EOL;
		}
	}
?>
