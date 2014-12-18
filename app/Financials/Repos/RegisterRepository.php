<?php

namespace Financials\Repos;

use Financials\Entities\Register;

class RegisterRepository implements RegisterRepositoryInterface {
	
	public function selectAll(){
		
	}

	public function find($id){
		
	}

	public function findByRef($reference){
		return Register::where('register_refno', $reference)->where('register_post', 'N')->get();
	}

	public function findByRegId($reg_id){
		return Register::company()->where('register_id', $reg_id)->first();
	}

	public function getRecord($ref){
		$fields = array('id','register_id','register_refno','account_value', 'po_id');
		return Register::where('register_id',$ref)->company()->aging()->with('reference.supplier','rfp')->get($fields);
		//return \DB::getQueryLog();
	}

	public function getOpenRecord($ref){
		$fields = array('id','register_id','register_refno','account_value', 'po_id');
		return Register::where('register_id',$ref)->company()->open()->with('reference.supplier','rfp')->get($fields);
		//return \DB::getQueryLog();
	}

	public function getAging(){
		$fields = array('id','register_id','module_id','account_id','register_refno','register_post','account_value', 'po_id' ,'created_at');
		return Register::company()->aging()->with('reference.supplier','rfp')->get($fields);
	}

	public function getOpen(){
		$fields = array('id','register_id','module_id','account_id','register_refno','register_post','account_value', 'po_id' ,'created_at');
		return Register::company()->open()->with('reference.supplier','rfp')->get($fields);
	}

	public function getAll(){
		$fields = array('id','register_id','module_id','account_id','register_refno','register_post','account_value', 'po_id' ,'created_at');
		return Register::company()->with('reference.supplier','rfp')->get($fields);
	}

	public function getAllNoRfp(){//has('register','<',1)
		return Register::company()->has('rfp','<',1)->get();
	}

	private function entries_count(){
		return \DB::table('accounting_register')->count();
	}

	public function create($data){

		$register = new Register;

		$register->register_id = 'REG' . \Helpers::recordNumGen($this->entries_count() + 1);//array_get($data,'ref') . "-" . ($this->entries_count() + 1);
		$register->module_id = 1;
		$register->account_id = 1;
		$register->po_id = array_get($data,'ref_id');
		$register->account_value = array_get($data,'amount');
		$register->register_refno = array_get($data, 'refno');

		$filter = Register::validate($register->toArray(),'entry');

		if($filter->passes()) {
        	
			$this->save($register);

			return array('saved' => true, 'object' => $register);

        }
        else return array('saved' => false , 'object' => $filter->messages());
            
		
	}


	public function modify($ref,$data){
		$register = Register::where('register_id', $ref)->first();

		if($register->register_post == 'N'){
			$register->account_value = array_get($data,'amount_request');
			$register->register_refno = array_get($data,'register_refno');

			$filter = Register::validate($register->toArray(),'entry');

			if($filter->passes()) {
	        	
				$this->update($register);

				return array('saved' => 1, 'object' => $register);

	        }
	        else return array('saved' => 0 , 'object' => $filter->messages());
		}
		else return array('saved' => -1, 'object' => array('message' => 'Failed to apply changes'));
	}

	public function post($ref){
		$register = Register::where('register_id', $ref)->first();

		if($register->register_post == 'N'){
			$register->register_post = 'Y';
			$register->register_date_posted = date("Y-m-d H:i:s");

			$filter = Register::validate($register->toArray(),'post');

			if($filter->passes()) {
				$this->update($register);
				return array('saved' => 1, 'object' => $register);
			}
			else return array('saved' => 0 , 'object' => $filter->messages());
		}
		else return array('saved' => -1, 'object' => array('message' => 'Posting not permitted'));
	}

	 /**
     * Simply saves the given instance
     *
     * @param  User $instance
     *
     * @return  boolean Success
     */
    public function save(Register $instance)
    {
        $entity = \Company::where('alias', \Session::get('company'))->first();

        $instance->context()->associate($entity);
         
         return $instance->save();

		// $comment = $post->comments()->save($comment);
  //       return $instance->save();
        //return $entity->invoices()->save($instance);
    }

     /**
     * Simply update the given instance
     *
     * @param  User $instance
     *
     * @return  boolean Success
     */
    public function update(Register $instance)
    { 
         return $instance->save();
     }
}