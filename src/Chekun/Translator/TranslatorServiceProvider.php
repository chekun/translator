<?php namespace Chekun\Translator;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

class TranslatorServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('chekun/translator');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app['MicroSoftTranslator'] = $this->app->share(function($app)
        {
            $config = Config::get('chekun/translator::api.microsoft');
            return new \Chekun\Translator\MicroSoft\Translator($config['id'], $config['secret']);
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('MicroSoftTranslator');
	}

}