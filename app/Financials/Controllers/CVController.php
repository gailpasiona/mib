<?php

namespace Financials\Controllers;

use Financials\Repos\CVRepositoryInterface;

class CVController extends \BaseController{
	
	public function __construct(CVRepositoryInterface $cv) {
		$this->beforeFilter('auth');
		// $this->beforeFilter('action_permission', array('except' => array('index')));
		$this->beforeFilter('session');

		$this->cv = $cv;
	}

	public function index(){
		
	}

	public function create(){
		$repo = \App::make('Financials\Rfp');
		$data = $repo->getApprovedRecord(\Input::get('rfp'));

		$data_needed = array('rfp_number' => null, 'amount_requested' => null, 'supplier' => null);

		$data_needed['rfp_number'] = $data[0]['rfp_number'];
		$data_needed['amount_requested'] = $data[0]['amount_requested'];
		$data_needed['supplier'] = $data[0]['register']['reference']['supplier']['supplier_name'];

		$data_needed['title'] = "Create Cheque Voucher for " . $data[0]['rfp_number'];

		return \View::make('financials.modals.form_cv')->with('data',$data_needed);

		//return \Response::json($data_needed);
	}

	public function store(){
		$rfp = $this->cv->create(\Input::all());

		if($rfp['status']) return 'Saved';
		else return $rfp['data'];
	}

	public function show(){

	}

	public function edit(){

	}

	public function update(){

	}
}