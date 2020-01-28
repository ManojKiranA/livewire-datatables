<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Laravel\Telescope\EntryType;
use Laravel\Telescope\IncomingEntry;
use Laravel\Telescope\Telescope;
use Laravel\Telescope\TelescopeApplicationServiceProvider;

class TelescopeServiceProvider extends TelescopeApplicationServiceProvider
{
    
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {        
        Telescope::night();

        $this->hideSensitiveRequestDetails();

        Telescope::filter(function (IncomingEntry $entry) {
            if (App::isLocal()) {
                return true;
            }

            return $entry->isReportableException() ||
                   $entry->isFailedRequest() ||
                   $entry->isFailedJob() ||
                   $entry->isScheduledTask() ||
                   $entry->hasMonitoredTag();
        });

        Telescope::tag(function (IncomingEntry $entry) {
            $entryContent = $entry->content;

            if ($entry->type === EntryType::CACHE) {
                $cacheTags = [
                    'Action:'.$entryContent['type'],
                    'Key:'.$entryContent['key'],
                    $entryContent['key'].':'.$entryContent['type'],
                ];

                return $cacheTags;
            }

            if ($entry->type === EntryType::VIEW) {
                $viewTags = [
                    'File:'.str_replace(['/', '\\'], [DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR], $entryContent['path']),
                    'FileRealPath:'.base_path().str_replace(['/', '\\'], [DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR], $entryContent['path']),
                ];

                return $viewTags;
            }

            if ($entry->type === EntryType::REQUEST) {
                $authUserTag = [];

                if (Auth::check()) {
                    $authorizedUser = Auth::user();
                    $authUserTag = [
                        'Email:'.$authorizedUser->email,
                        'Name:'.$authorizedUser->name,
                    ];
                }

                $requestTags = [
                    'Method:'.$entryContent['method'],
                    'Status:'.$entryContent['response_status'],
                    'IP:'.request()->ip(),
                ];

                return array_merge($requestTags, $authUserTag);
            }
            if ($entry->type === EntryType::MODEL) {
                $modelName = Str::before($entryContent['model'], ':');
                $modelAction = ucfirst($entryContent['action']);
                $modelTags = [
                    'ModelAction:'.$modelAction,
                    'ModelName:'.$modelName,
                    $modelName.':'.$modelAction,
                ];

                return $modelTags;
            }

            return [];
        });
    }

    /**
     * Prevent sensitive request details from being logged by Telescope.
     *
     * @return void
     */
    protected function hideSensitiveRequestDetails()
    {
        if (App::isLocal()) {
            return;
        }

        Telescope::hideRequestParameters(['_token']);

        Telescope::hideRequestHeaders([
            'cookie',
            'x-csrf-token',
            'x-xsrf-token',
        ]);
    }

    /**
     * Register the Telescope gate.
     *
     * This gate determines who can access Telescope in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewTelescope', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }
}
