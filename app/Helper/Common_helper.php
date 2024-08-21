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
		// echo $dir."/".$file."-----";
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
	$role_list = \App\Models\UserRole::where(['is_admin' => 1])->select('id')->get();
	 
	
	$role_ex = explode(",",Auth::user()->role);
	 
	$role_admin = false;
	foreach($role_list as $role){ 
		if (in_array($role->id, $role_ex)){ 
			$role_admin = true;
		}
	} 
	if( Auth::user()->is_admin === 1){
		return true;
	} else if($role_admin){
		return true;
	}
	return false;  
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
				"name" => "Attorney",
				"uid" => "8e1347e0-5d3c-443e-ae2c-c977de46605a"
			],
			[
				"id" => 2,
				"name" => "Business",
				"uid" => "3939292e-254e-4bb8-ada4-34fdee4510a1"
			], 
			[
				"id" => 4,
				"name" => "CPA",
				"uid" => "58f83945-5c46-4a28-92ea-ef3ca6ff2895"
			],
			[
				"id" => 5,
				"name" => "Employer",
				"uid" => "34a763fc-7e59-42a4-9c61-cf8a6c9019c5"
			],
			[
				"id" => 6,
				"name" => "Friend",
				"uid" => "76e8f83b-0f49-485c-9d1e-66d83c2d1071"
			],
			[
				"id" => 7,
				"name" => "Other",
				"uid" => "7c4f34a3-a904-400a-bd6c-3de258a0354c"
			],
			
		);
	}

	function get_emergency_contact_list(){
		return $emergency_contact = array(
			[
				"id" => 1,
				"name" => "Brother",
				"uid" => "a4debd1a-b32d-49a2-ac4b-8b05c03360b9"

			],
			[
				"id" => 2,
				"name" => "Daughter",
				"uid" => "0890fa24-b84c-4830-8166-a9bae38acc48"
			],
			[
				"id" => 3,
				"name" => "Father",
				"uid" => "fe4d0073-8b5c-4a75-a7c6-45e192e18206"
			],
			[
				"id" => 4,
				"name" => "Friend",
				"uid" => "11fb3eae-35a0-4337-9420-ed825857c6dc"
			],
			[
				"id" => 5,
				"name" => "Mother",
				"uid" => "1e110ad5-c30c-440c-8cb7-57679a1c35be"
			],
			[
				"id" => 6,
				"name" => "Other",
				"uid" => "b834ce7e-ae70-4bd2-99ec-592588dee6e5"
			],
			[
				"id" => 7,
				"name" => "Significant Other",
				"uid" => "47ac5c33-a129-482b-b1bb-153b8837a99e"
			],
			[
				"id" => 8,
				"name" => "Sister",
				"uid" => "a406f4ed-bedc-43b3-b8bf-b688def2cd07"
			],
			[
				"id" => 9,
				"name" => "Spouse",
				"uid" => "e849096b-725e-4ce1-b5b2-f3451bb5cc26"
			],
			[
				"id" => 10,
				"name" => "Son",
				"uid" => "5793dc2c-62d3-4610-a560-ec277f1d196d"
			],
			
		);
	}

	function get_education_type_list(){
		return $education_type = array(
			[
				"id" => 1,
				"name" => "College",
				"uid" => "50316f07-eb2d-4171-a11e-26d4b07d3b4e"
			],
			[
				"id" => 2,
				"name" => "High School",
				"uid" => "43ff7753-326b-4927-810c-1291113f14a4"
			],
			[
				"id" => 3,
				"name" => "Nursing School",
				"uid" => "20bd27eb-b9ef-4153-beda-247a456cb017"
			],
			[
				"id" => 4,
				"name" => "Professional School",
				"uid" => "7dc02875-3098-4f66-bfa0-4b254985d97b"
			],
			[
				"id" => 5,
				"name" => "School",
				"uid" => "ce1530ff-4267-418a-b5ab-fdf6bdc003a1"
			],
			[
				"id" => 6,
				"name" => "University",
				"uid" => "df4abc60-10b4-40f3-ab64-4d4eac2ccd7b"
			],
			[
				"id" => 7,
				"name" => "Vocational School",
				"uid" => "e2049103-d153-4142-aa9f-216110b39802"
			],
		);
	}

	
	function get_education_degree_list(){
		return $degree = array(
			[
				"id" => 1,
				"name" => "Associate",
				"uid" => "e248aec2-fc54-4801-a4a3-f8d50c8f0761"
			],
			[
				"id" => 2,
				"name" => "Bachelor of Science",
				"uid" => "26b8262b-2fb0-418f-a10e-595c45d7e2a0"
			],
			[
				"id" => 3,
				"name" => "Diploma",
				"uid" => "ab4ea587-bd73-46f8-aac9-19ef180fa455"
			],
			[
				"id" => 4,
				"name" => "Nursing Diploma",
				"uid" => "a18bc2d6-9739-4548-9c27-704268298f70"
			],
			[
				"id" => 5,
				"name" => "Other",
				"uid" => "ae310cba-bcb1-46a7-9ef7-58b018c82947"
			]
		);
	}


	function get_address_type_list(){
		return array(
			[
				"id" => 1,
				"name" => "Home Address"
			],
			[
				"id" => 2,
				"name" => "Work Place"
			],
			
		);
	}
	
	function get_phone_numbers_type_list(){
		return array(
			[
				"id" => 1,
				"name" => "Cell"
			],
			[
				"id" => 2,
				"name" => "Fax"
			],
			[
				"id" => 3,
				"name" => "Home"
			],			
			[
				"id" => 4,
				"name" => "Work Place"
			],
			
		);
	}
	
		
	function get_email_addresses_type_list(){
		return array(
			[
				"id" => 1,
				"name" => "Direct"
			],
			[
				"id" => 2,
				"name" => "Personal"
			],
			[
				"id" => 3,
				"name" => "Work Place"
			]
			
		);
	}


function remove_mask($input){
	if($input){
		
		$str = str_replace("-","",$input);
		$str = str_replace("(","",$str);
		$str = str_replace(")","",$str);
		$str = str_replace(" ","",$str);
		return $str;
	}
	return null;
	
}

function get_emergency_contact_details_by_id($id){
	$key = array_search($id, array_column(get_emergency_contact_list(), 'id'));
	return get_emergency_contact_list()[$key];
}

function get_address_by_id($id){
	$key = array_search($id, array_column(get_address_type_list(), 'id'));
	return get_address_type_list()[$key];
}


function get_phone_numbers_by_id($id){
	$key = array_search($id, array_column(get_phone_numbers_type_list(), 'id'));
	return get_phone_numbers_type_list()[$key];
}

function get_email_addresses_by_id($id){
	$key = array_search($id, array_column(get_email_addresses_type_list(), 'id'));
	return get_email_addresses_type_list()[$key];
}

function get_document_renewal_date($renewal_type, $renewal_number, $issue_date){
	
	switch ($renewal_type) {
		case "1":
			$renewal_date = get_renewal_date($issue_date,$renewal_number,"days");
			break;
		case "2":
			$days = (round($renewal_number/24) < 0) ? $renewal_number : round($renewal_number/24);
			$renewal_date = get_renewal_date($issue_date,$days,"days");
			break;
		case "3":
			//Manual
			$renewal_date = null;
			break;
		case "4":
			$renewal_date = get_renewal_date($issue_date,$renewal_number,"month");
			$renewal_date;
			break;
		case "5":
			$renewal_date = get_renewal_date($issue_date,$renewal_number,"week");
			$renewal_date;
			break;
		case "6":
			$renewal_date = get_renewal_date($issue_date,$renewal_number,"year");
			$renewal_date;
			break;
		default:
			$days = $renewal_number;
			$renewal_date = date("m/d/Y", strtotime($issue_date));
	  }
	  return $renewal_date;
}

function get_renewal_date($issue_date,$renewal_number,$type){
// 	$issue_date = date_create($issue_date);
	return date("m/d/Y", strtotime("+$renewal_number $type", strtotime($issue_date)));
}




//**********************************************//
