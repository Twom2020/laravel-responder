<?php
/**
 * Created by AliGhaleyan - AlirezaSajedi
 */

namespace Twom\Responder;


use Illuminate\Support\ServiceProvider;

class ResponderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerTranslations();
    }


    public function register()
    {
        //
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/responder');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'responder');
        } else {
            $this->loadTranslationsFrom(realpath(__DIR__ . "/lang"), 'responder');
        }
    }
}
