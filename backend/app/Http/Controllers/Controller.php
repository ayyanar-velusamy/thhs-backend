<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; 

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests; 
	
	public function response($type = "json"){
		
		if(isset($this->response['redirect'])){
            $this->response['action'] = 'redirect';
            $this->response['url']    = $this->response['redirect'];
        }
		
		if($type === "json"){
			return json_encode($this->response);
		}
		
		return $this->response;
	}
}
