<?php namespace Financials\Providers;

use Illuminate\Support\Serviceprovider;

class FinancialsServiceProvider extends ServiceProvider {
	
	public function register() {
		$this->app->bind('Financials\Repos\RfpRepositoryInterface', 'Financials\Repos\RfpRepository');

		$this->app->bind('Financials\Repos\PurchasesRepositoryInterface', 'Financials\Repos\PurchasesRepository');

		$this->app->bind('Financials\Repos\RegisterRepositoryInterface', 'Financials\Repos\RegisterRepository');

		$this->app->bind('Financials\Repos\CVRepositoryInterface', 'Financials\Repos\CVRepository');

		$this->app->bind('Financials\Register', function(){
			return new \Financials\Repos\RegisterRepository;
		});

		$this->app->bind('Financials\Rfp', function(){
			return new \Financials\Repos\RfpRepository;
		});

		$this->app->bind('Financials\Coa', function(){
			return new \Financials\Repos\CoaRepository;
		});

		$this->app->bind('Financials\Purchases', function(){
			return new \Financials\Repos\PurchasesRepository;
		});
	}
}