<?php

namespace App\Console\Commands;

use App\Services\BuildPhpFileService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ServiceMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {serviceName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */

    public function handle()
    {
        if ($this->argument('serviceName')) {
            $serviceName = $this->argument('serviceName');

            if (file_exists(env('SERVICE_ROUTE') . $serviceName . ".php")) {
                return $this->components->error('The service exists');
            } else {
                $directory_route = env('SERVICE_ROUTE');

                if (file_exists($directory_route)) {

                    $fileServiceResponse = BuildPhpFileService::createServiceFile($serviceName);

                    if ($fileServiceResponse) {
                        return $this->components->info('The service created SuccessFully');
                    }

                    return $this->components->error('The service errored');
                } else {
                    File::makeDirectory(env('SERVICE_ROUTE'));

                    $fileServiceResponse = BuildPhpFileService::createServieFile($serviceName);

                    if ($fileServiceResponse) {
                        return $this->components->info('The service created SuccessFully');
                    }

                    return $this->components->error('The service errored');
                }
            }
        }

        return $this->components->error('The service name is required');
    }
}
