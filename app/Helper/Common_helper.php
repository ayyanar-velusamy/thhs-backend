<?php

if (! function_exists('pr')) {
    function pr($data, $exit = false)
    {
        echo "<pre>";
		print_r($data);
		echo "</pre>";
		
		if($exit){
			exit;
		}
    }
}

if(!function_exists('moduleJs')){

    function moduleJs($dir= "", $file = ""){
		
        if($dir != "" && $file != ""){
            echo includeJs($dir, $file);
        }else{
            list($controller, $method) = GetActionControllerAndMethodName();
			
			//Include contoller js 
            echo includeJs($controller, $controller);
    
            //Include method js 
            echo includeJs($controller, $method);
        }
    }
}

if(!function_exists('parseDateRange')){
    function parseDateRange($date, $db_format = true){
		$d = explode('-',$date);		
		if($db_format){
			return [get_db_date($d[0]).' 00:00:00',get_db_date($d[1]).' 23:59:59'];
		}  
		return [$d[0],$d[1]];	
    }
}

if(!function_exists('GetActionControllerAndMethodName')){
    function GetActionControllerAndMethodName(){
        $routeArray = request()->route()->getAction();
		$controllerAction = @class_basename($routeArray['controller']);
        @list($controller, $method) = explode('@', $controllerAction);
        $controller = strtolower(str_replace('Controller','',$controller));

        return [$controller,$method];
    }
}

if(!function_exists('GetActionMethodName')){
    function GetActionMethodName(){
        $routeArray = request()->route()->getAction();
        $controllerAction = class_basename($routeArray['controller']);
        list($controller, $method) = explode('@', $controllerAction);
        return $method;
    }
}

if(!function_exists('includeJs')){
    function includeJs($dir,$file){ 
		echo $dir."/".$file."-----";
        if (file_exists(public_path('js/'.$dir.'/'.$file.'.js'))){
            return "<script src=".asset('js/'.$dir.'/'.$file.'.js')."></script>";
        }
    }
}

// Appication response helper
if(!function_exists('res')){
    function res($data){

       if(isset($data['redirect'])){
             $data['action'] = 'redirect';
             $data['url']    = $data['redirect'];
       } 

       if(request()->ajax()){
           echo json_encode($data);
       }else{
           $status = ($data['status']) ? 'success' : 'error';
           return redirect(url($data['url']))->with($status, $data['message']);
       } 
    }
}

function encode_url($data){
	return Auth::user()->encode_url($data);  
}

function decode_url($data){
	return Auth::user()->decode_url($data);  
}

function user_id(){
	return (isset(Auth::user()->id)) ? Auth::user()->id : 0;  
}

function is_admin(){
	return (Auth::user()->hasRole('Admin')) ? true : false;  
}

function is_group_admin($group_id = "", $user_id = ""){
	$cond['user_id'] = ($user_id == "") ? user_id() : $user_id;
	if($group_id != ""){ $cond['group_id'] = $group_id; }
	$group = \App\Model\GroupUserList::where($cond)->where(['is_admin'=>1])->whereNull('deleted_at');
	return ($group->count() > 0) ? true : false;  
}

function is_group_member($group_id = "", $user_id = ""){
	$cond['user_id'] = ($user_id == "") ? user_id() : $user_id;
	if($group_id != ""){ $cond['group_id'] = $group_id; }
	$group = \App\Model\GroupUserList::where($cond)->whereNull('deleted_at');
	return ($group->count() > 0) ? true : false;  
}

function is_public_group($group_id, $user_id = ""){	
	$cond_user_id = ($user_id == "") ? user_id() : $user_id;
	
	$group = \App\Model\Group::join(DB::raw('(SELECT group_id, GROUP_CONCAT(DISTINCT user_id) as group_member_ids FROM group_user_lists WHERE deleted_at IS NULL GROUP BY group_id) as members'),'members.group_id','=','groups.id','left')->where('groups.id',$group_id)->whereRaw('(groups.visibility = "public" OR FIND_IN_SET('.$cond_user_id.',members.group_member_ids))');	
	return ($group->count() > 0) ? true : false; 
}

function group_name($group_id){
	$group = \App\Model\Group::findOrFail($group_id);
	if($group){
		return ucfirst($group->group_name);
	} 
	return "";
}

function date_differance($end_date, $start_date ="", $nagative = false){

	$diff = (strtotime($end_date) - strtotime($start_date));

	$years = floor($diff / (365*60*60*24));
	$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
	$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
	if($diff <= 0 && $nagative == false){
		return 0;
	}
	return ($years*365) + ($months*30) + $days; 
}

function get_date_time($datetime = ""){
	if($datetime == ""){
		return \Carbon\Carbon::now()->format('M d, Y, h:i A');
	}else{
		return \Carbon\Carbon::parse($datetime)->format('M d, Y, h:i A');
	}
}

function get_date($date = ""){
	if($date == ""){
		return \Carbon\Carbon::now()->format('M d, Y');
	}else{
		return \Carbon\Carbon::parse($date)->format('M d, Y');
	}
}

function get_db_date_time($datetime = ""){
	if($datetime == ""){
		return \Carbon\Carbon::now()->format('Y-m-d h:i:s');
	}else{
		return \Carbon\Carbon::parse($datetime)->format('Y-m-d h:i:s');
	}
}

function get_db_date($date = ""){
	if($date == ""){
		return \Carbon\Carbon::now()->format('Y-m-d');
	}else{
		return \Carbon\Carbon::parse($date)->format('Y-m-d');
	}
}

function back_url($url = ""){

	if($url == ""){
		return url('/');
	}
	
	if(url()->previous() == url()->current()){
		return $url;
	}else{
		
		$previous = url()->previous();		
		$current = url()->current();
		
		if(!str_contains($previous, url('/'))){
			return $url;
		}
		
		if(str_contains($previous, '/groups') && str_contains($previous, '/passport')){
			return $url;
		}
		
		if((str_contains(\Request::route()->getName(),'show') || str_contains($current, '/show')) && str_contains($previous, '/edit')){
			return $url;
		} 
		
		return url()->previous();
	}
}

//***********************************//
	
	function profile_image($file_name){
	  if($file_name != "" && file_exists( public_path().'/storage/user-uploads/avatar/'.$file_name)){
        return asset('storage/user-uploads/avatar/'.$file_name);
      }else{
         return asset('images/user_profile.png');
      }
	}
	
	function banner_image($file_name){
	  // if($file_name != "" && file_exists( public_path().'/storage/user-uploads/avatar/'.$file_name)){
	  if($file_name != ""){
        return url('storage/app/public/banner-uploads/'.$file_name);
      }else{
         return asset('images/user_profile.png');
      }
	}
	
	
	function file_get_contents_curl($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
	
	function get_url_meta_tags($url){
		$tags = $res =  array();
		$html = file_get_contents_curl($url);
		$title = "";
		//parsing begins here:
		$doc = new DOMDocument();
		@$doc->loadHTML($html);
		$nodes = $doc->getElementsByTagName('title');
		if($nodes->length > 0){
			$title = $nodes->item(0)->nodeValue;
		}
		$meta = $doc->getElementsByTagName('meta');
		if($meta){
			foreach ($meta as $element) {
				$tag = [];
				foreach ($element->attributes as $node) {
					$tag[$node->name] = $node->value;
				}
				$tags []= $tag;
			}
		}

		$des_keys 		= ['Description','description','og:description'];
		$keyword_keys   = ['keyword','keywords','Keyword','Keywords','og:keyword','og:keywords'];
		$provider_keys  = ['author','Author','provider','Provider','og:author','og:provider'];
		$length_keys    = ['length','Length','minutes','Minutes','minute','Minute','og:minute','og:minutes','og:length'];

		$res['url'] = $url;
		$res['title'] = $title;
		if(!empty($tags)){
			foreach ($tags as $tg_value) {
				$content = "";
				$content = (isset($tg_value['content']) && $tg_value['content'] != "") ? $tg_value['content'] : '';
				if(isset($tg_value['name']) && (in_array($tg_value['name'],$des_keys))){
					$res['description'] = $content;		
				}
				if(isset($tg_value['name']) && (in_array($tg_value['name'],$keyword_keys))){
					$res['keywords'] = $content;		
				}
				if(isset($tg_value['name']) && (in_array($tg_value['name'],$provider_keys))){
					$res['provider'] = $content;			
				}
				if(isset($tg_value['name']) && (in_array($tg_value['name'],$length_keys))){
					$res['length'] = $content;			
				}		
			}
		}

		return $res;
	}
	
	function lang_message($message_key ="", $oldTxt ="", $newTxt = ""){		
		if($oldTxt != "" && $newTxt != "" && $message_key != ""){
			return str_replace("{".$oldTxt."}",$newTxt,__('message.'.$message_key));
		}if($message_key != ""){
			return __('message.'.$message_key);
		}else{
			return "";
		}
	} 

	function update_date_format($date,$format="m/d/Y"){
		if($date){
			return date($format, strtotime($date));
		}else{
			return null;
		}
		
	}

	function get_professional_relationships_list(){
		return $relationships = array(
			[
				"id" => 1,
				"name" => "Attorney"
			],
			[
				"id" => 2,
				"name" => "Business"
			],
			[
				"id" => 3,
				"name" => "Associate"
			],
			[
				"id" => 4,
				"name" => "CPA"
			],
			[
				"id" => 5,
				"name" => "Employer"
			],
			[
				"id" => 6,
				"name" => "Friend"
			],
			[
				"id" => 7,
				"name" => "Other"
			],
			
		);
	}

	function get_emergency_contact_list(){
		return $emergency_contact = array(
			[
				"id" => 1,
				"name" => "Brother"
			],
			[
				"id" => 2,
				"name" => "Daughter"
			],
			[
				"id" => 3,
				"name" => "Father"
			],
			[
				"id" => 4,
				"name" => "Friend"
			],
			[
				"id" => 5,
				"name" => "Mother"
			],
			[
				"id" => 6,
				"name" => "Other"
			],
			[
				"id" => 7,
				"name" => "Significant Other"
			],
			[
				"id" => 8,
				"name" => "Sister"
			],
			[
				"id" => 9,
				"name" => "Spouse"
			],
			[
				"id" => 10,
				"name" => "Son"
			],
			
		);
	}

	function get_education_type_list(){
		return $education_type = array(
			[
				"id" => 1,
				"name" => "College"
			],
			[
				"id" => 2,
				"name" => "High School"
			],
			[
				"id" => 3,
				"name" => "Nursing School"
			],
			[
				"id" => 4,
				"name" => "Professional School"
			],
			[
				"id" => 5,
				"name" => "School"
			],
			[
				"id" => 6,
				"name" => "University"
			],
			[
				"id" => 7,
				"name" => "Vocational School"
			],
		);
	}

	
	function get_education_degree_list(){
		return $degree = array(
			[
				"id" => 1,
				"name" => "Associate"
			],
			[
				"id" => 2,
				"name" => "Bachelor of Science"
			],
			[
				"id" => 3,
				"name" => "Diploma"
			],
			[
				"id" => 4,
				"name" => "Nursing Diploma"
			],
			[
				"id" => 5,
				"name" => "Other"
			]
		);
	}

//**********************************************//
