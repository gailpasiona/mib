<?php

namespace Financials\Controllers;

use Financials\Repos\RegisterRepositoryInterface;
// use Financials\Repos\PurchasesRepositoryInterface;

//for checking, need to check dependency injections
class APInvoiceController extends \BaseController{
	
	public function __construct(RegisterRepositoryInterface $register) {
		$this->beforeFilter('auth');
		$this->beforeFilter('action_permission', array('except' => array('list_aging','getRegisterInfo','generate')));
		$this->beforeFilter('session');

		$this->register = $register;
		//$this->purchases = $purchases;
	}

	public function index(){
		// echo "AP Index";
		//return \Response::json($this->rfp->selectAll());
		return \View::make('financials.apinvoice')->with('user', \Confide::user()->username);
	}

	public function create(){
		// return "hello";
	}

	public function store(){
		$repo = \App::make('Financials\Purchases');
		// return \Response::json(array($this->purchases->find(\Input::get('reference'))->po_number,
		// 	$this->purchases->find(\Input::get('reference'))->po_total_amount));
		$payable = $repo->findByPO(\Input::get('po_reference'));
		
		if($payable->openforinvoice->isEmpty()){
			$invoice = $this->register->create(array('amount'=>\Input::get('amount_request'), 
				'ref_id' =>$payable->id, 'refno' => \Input::get('register_refno')));

			if($invoice['saved']){
					// $sdd = $repo->updateById(\Input::get('reference'));
					return \Response::json(array('status' => 'success', 'message' => 'Invoice Created'));
			}
			else
				return \Response::json(array('status' => 'success_error', 'message' => $invoice['object']));;
		}
		else return \Response::json(array('status' => 'success_failed', 'message' => 'Unable to created invoice (record has unposted invoice)'));
	}

	public function show($ref){
		return \Response::json($this->register->getRecord($ref));
	}

	public function edit($record){
		//$repo = \App::make('Financials\Register');//need to verify if binding is necessary
		$data = $this->register->getOpenRecord($record);

		$register_info = array();

		$register_info['cost_dept'] = $data[0]['reference']['requestor'];
		$register_info['invoice_no'] = $data[0]['register_id'];
		$register_info['amount_request'] = $data[0]['account_value'];
		$register_info['payee_name'] = $data[0]['reference']['supplier']['supplier_name'];
		$register_info['register_refno'] = $data[0]['register_refno'];
		$register_info['title'] = "Modify Invoice " . $data[0]['register_id'];

		return \View::make('financials.modals.form_invoice')->with('data',$register_info);
	}

	public function update($record){

		$record = $this->register->modify($record,\Input::all());
		
		if($record['saved'] > 0)
			return \Response::json(array('status' => 'success', 'message' => 'Invoice Updated'));

		else if($record['saved'] == 0)
			return \Response::json(array('status' => 'success_error', 'message' => $record['object']));

		else return \Response::json(array('status' => 'success_failed', 'message' => $record['object']));
		
		// return \Response::json($record);
	}

	public function generate(){
		$repo = \App::make('Financials\Purchases');
		$payable = $repo->find(\Input::get('reference'));

		//return \Response::json($payable);

		$register_info = array();

		$register_info['cost_dept'] = $payable['requestor'];
		$register_info['amount_request'] = $payable['po_total_amount'];
		$register_info['payee_name'] = $payable['supplier']['supplier_name'];
		$register_info['po_reference'] = $payable['po_number'];
		$register_info['title'] = "Create Invoice";

		return \View::make('financials.modals.form_invoice')->with('data',$register_info);


	}

	public function old_generate(){
		$repo = \App::make('Financials\Purchases');
		// return \Response::json(array($this->purchases->find(\Input::get('reference'))->po_number,
		// 	$this->purchases->find(\Input::get('reference'))->po_total_amount));
		$payable = $repo->find(\Input::get('reference'));
		
		if($payable->openforinvoice->isEmpty()){
			$invoice = $this->register->create(array('ref'=>$payable->po_number,
			'amount'=>$payable->po_total_amount, 'ref_id' =>$payable->id));

			if($invoice->id){
					$sdd = $repo->updateById(\Input::get('reference'));
					return 'Invoice generated!';
			}
			else
				return 'Invoice Failed';
		}
		else return 'Has Open Invoice';
		// return 
		
	}

	public function post(){
		$posting = $this->register->post(\Input::get('invoice'));
		
		if($posting['saved'] > 0)
			return \Response::json(array('status' => 'success', 'message' => 'Invoice Posted'));

		else if($posting['saved'] == 0)
			return \Response::json(array('status' => 'success_error', 'message' => $posting['object']));

		else return \Response::json(array('status' => 'success_failed', 'message' => $posting['object']));
	}

	public function list_aging(){
		$type = \Input::get('type');
		$data = null;
		switch ($type) {
			case 'open':
				$data = $this->register->getOpen();
				break;
			case 'all':
				$data = $this->register->getAll();
				break;
			default:
				$data = $this->register->getAging();
				break;
		}
		return \Response::json($data);
	}

	public function getRegisterInfo($ref){
		return \Response::json($this->register->getRecord($ref));
	}
}