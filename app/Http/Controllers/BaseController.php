<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Hashids\Hashids;
use Illuminate\Support\Facades\Session;

class BaseController extends Controller
{
	public $data 	 = [];
	public $response = [];
	
	/**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->data[$name];
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->data[ $name ]);
    }
	
    public function __construct(){
		$this->middleware(function ($request, $next) {
			$this->user = auth()->user();
            //$this->notifications = $this->user->notifications;
			// if(@$this->user->status != 'active' || $this->user->deleted_at != ""){
			// 	auth()->logout();
			// 	if(!$request->ajax()){
			// 		if(@$this->user->status != 'active'){
			// 			return redirect()->route('login')->with('error_message',__('message.account_inactive'));
			// 		}else{
			// 			return redirect()->route('login');
			// 		}
			// 	}else{
			// 		if($this->user->status != 'active'){
			// 			Session::flash('error_message', __('message.account_inactive'));
			// 		}
			// 	}
			// }
			return $next($request);
		});
	}
	
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

	protected function encode_url($data){
		$hashids = new Hashids(config('app.name'));
		return $hashids->encode($data);  
    }


	protected function decode_url($ciphertext){
		$hashids = new Hashids(config('app.name'));
		return $hashids->encode($ciphertext);  
    }

}
