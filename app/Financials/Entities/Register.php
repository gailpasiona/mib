<?php namespace Financials\Entities;


class Register extends FinancialModel {
	protected $table = 'accounting_register';

	public static $rules = array(
        'entry' => [
                     'po_id'  => 'required',
                     'account_value' => 'required|amount',
                     'register_refno'  =>  'alpha_num'
        ],
        'post' => [
                     'po_id'  => 'required',
                     'account_value' => 'required|amount',
                     'register_refno'  =>  'required|alpha_num'
        ]
    );

     public static function validate($input, $ruleset) {
        
        $validator = \Validator::make($input, static::$rules[$ruleset]);
        //$validator->setAttributeNames($att);
        
        return $validator;
    }

	public static function boot()
    {
        parent::boot();
 
        static::creating(function($record)
        {
            $record->created_by =\Auth::user()->id;
            $record->last_updated_by = \Auth::user()->id;
        });
 
        static::updating(function($record)
        {
            $record->last_updated_by = \Auth::user()->id;
        });
    }

	public function context(){
		return $this->belongsTo('\Company', 'company_id');
	}

	public function reference(){
		$showable_fields = array('id','requestor','po_number','po_remarks','po_total_amount','supplier_id');
		return $this->belongsTo('Financials\Entities\Purchases', 'po_id')->company()->select($showable_fields);
	}

	public function rfp(){
		$showable_fields = array('id','invoice_id');
		return $this->hasOne('Financials\Entities\Rfp', 'invoice_id')->select($showable_fields);
	}

    public function openforrfp(){
        return $this->hasOne('Financials\Entities\Rfp', 'invoice_id');
    }

	public function scopeAging($query){
		return $query->where('register_post', 'Y'); 
	}

	public function scopeOpen($query){
		return $query->where('register_post', 'N'); 
	}

	public function getTableName(){
		return $this->table;
	}
}