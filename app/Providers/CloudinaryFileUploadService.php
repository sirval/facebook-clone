<?php

namespace App\Providers;

use App\Services\FileUpload;
use Illuminate\Support\ServiceProvider;

class CloudinaryFileUploadService extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton(FileUpload::class, function ($app) {
            return new FileUpload();
        });
    }
}