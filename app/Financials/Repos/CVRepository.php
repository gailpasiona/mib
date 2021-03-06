<?php

namespace Financials\Repos;

use Financials\Entities\CV;
use Financials\Entities\Rfp;

class CVRepository implements CVRepositoryInterface {
	
	public function selectAll(){
		return Rfp::company()->get();
	}

	public function find($id){
		return Rfp::find($id);
	}

	// public function getPending(){
	// 	$fields = array('register_id','module_id','account_id','register_refno','register_post','account_value', 'po_id' ,'created_at');
	// 	return Rfp::company()->aging()->with('reference.supplier')->get($fields);
	// }

	// public function getOpen(){
	// 	$fields = array('register_id','module_id','account_id','register_refno','register_post','account_value', 'po_id' ,'created_at');
	// 	return Rfp::company()->open()->with('reference.supplier')->get($fields);
	// }

	// public function getAllNoCV(){ //return only those wihout cv request
	// 	return Rfp::company()->has('cv','<',1)->with('register.reference.supplier')->get();
	// }

	// public function getAll(){
	// 	$fields = array('id','rfp_number','invoice_id','costing_department','created_at','date_needed','amount_requested',
	// 	 'request_description','approved');
	// 	return Rfp::company()->has('cv','<',1)->with('register.reference.supplier')->get($fields);
	// }

	// public function getOpenRecord($ref){
	// 	$fields = array('id','rfp_number','invoice_id','costing_department','created_at','date_needed','amount_requested',
	// 	 'request_description','approved');
	// 	return Rfp::where('rfp_number',$ref)->company()->open()->with('register.reference.supplier')->get($fields);
	// 	//return \DB::getQueryLog();
	// }

	// public function getApprovedRecord($ref){
	// 	// $fields = array('id','register_id','register_refno','account_value', 'po_id');
	// 	return Rfp::where('rfp_number',$ref)->company()->approved()->with('register.reference.supplier')->get();
	// 	//return \DB::getQueryLog();
	// }

	// public function getRecord($ref){
	// 	$fields = array('id','register_id','register_refno','account_value', 'po_id');
	// 	return Register::where('register_id',$ref)->company()->aging()->with('reference.supplier','rfp')->get($fields);
	// 	//return \DB::getQueryLog();
	// }

	private function entries_count(){
		return \DB::table('cheque_voucher')->count();
	}

	public function create($data){
		$return_data = array('status' => null, 'data' => null);
		$filter = CV::validate(\Input::all(), 'entry');

		if($filter->passes()){
			$cv = new CV;

			$cv->cv_number = 'CV ' . \Helpers::recordNumGen($this->entries_count() + 1);//array_get($data,'ref') . "-" . ($this->entries_count() + 1);
			$cv->amount = array_get($data,'amount_request');
			$cv->cheque_number = array_get($data, 'cheque_number');
			$cv->description = array_get($data,'description');
			
			$this->save($cv, array_get($data, 'rfp_number'));

			return array('status' => true, 'data' => $cv);

		}

		else{
			return array('status' => false, 'data' => $filter->messages());

		}
		

	}

	public function modify($ref,$data){
		$rfp = Rfp::where('rfp_number', $ref)->first();
		if($rfp->approved == 'N'){
			$rfp->date_needed = array_get($data,'date_needed');
			$rfp->request_description = array_get($data,'description');
			// $register->register_date_posted = date("Y-m-d H:i:s");
			return $this->update($rfp);
		}
		else return false;
	}

	public function approve($ref){
		$request = Rfp::where('rfp_number', $ref)->first();
		if($request->approved == 'N'){
			$request->approved = 'Y';
			// $request->register_date_posted = date("Y-m-d H:i:s");
			return $this->update($request);
		}
		else return false;
		

	}

	/**
     * Simply saves the given instance
     *
     * @param  User $instance
     *
     * @return  boolean Success
     */
    public function save(CV $instance, $ref)
    {
        $entity = \Company::where('alias', \Session::get('company'))->first();
        $reference = Rfp::where('rfp_number', $ref)->first();

        $instance->context()->associate($entity);

        $instance->rfp()->associate($reference);
         
        return $instance->save();

		// $comment = $post->comments()->save($comment);
  //       return $instance->save();
        //return $entity->invoices()->save($instance);
    }

    public function update(CV $instance)
    { 
         return $instance->save();
     }

}