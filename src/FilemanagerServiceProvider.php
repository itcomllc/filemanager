<?php

namespace LivewireFilemanager\Filemanager;

use Livewire\Livewire;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use LivewireFilemanager\Filemanager\Livewire\LivewireFilemanagerComponent;
use LivewireFilemanager\Filemanager\Http\Components\BladeFilemanagerComponent;

class FilemanagerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'livewire-filemanager');

        $this
            ->registerPublishables()
            ->registerBladeComponents()
            ->registerLivewireComponents();
    }

    public function register()
    {
        parent::register();
    }

    protected function registerPublishables(): self
    {
        if (!class_exists('CreateTemporaryUploadsTable')) {
            $this->publishes([
                __DIR__ . '/../database/migrations/create_folders_table.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_folders_table.php'),
            ], 'livewire-fileuploader-migrations');

            $this->publishes([
                __DIR__ . '/../resources/views' => base_path('resources/views/vendor/livewire-fileuploader'),
            ], 'livewire-fileuploader-views');

            $this->publishes([
                __DIR__ . '/../resources/lang' => "{$this->app['path.lang']}/vendor/livewire-fileuploader",
            ], 'livewire-fileuploader-lang');
        }

        return $this;
    }

    public function registerLivewireComponents(): self
    {
        Livewire::component('livewire-filemanager', LivewireFilemanagerComponent::class);

        return $this;
    }

    public function registerBladeComponents(): self
    {
        Blade::component('livewire-filemanager', BladeFilemanagerComponent::class);

        return $this;
    }
}
