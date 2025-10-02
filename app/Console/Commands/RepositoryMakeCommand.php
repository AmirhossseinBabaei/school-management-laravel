<?php

namespace App\Console\Commands;

use App\Services\BuildPhpFileService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class RepositoryMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {repositoryName}';

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
        if ($this->argument('repositoryName')) {
            $repositoryName = $this->argument('repositoryName');

            if (file_exists("app/Repositories/" . $repositoryName . ".php")) {
                return $this->components->error('The repository exists');
            } else {
                $directory_route = env('REPOSITORY_ROUTE');

                if (file_exists($directory_route)) {

                    $fileRepositoryServiceResponse = BuildPhpFileService::createRepositoryFile($repositoryName);

                    if ($fileRepositoryServiceResponse) {
                        return $this->components->info('The Repository created SuccessFully');
                    }

                    return $this->components->error('The repository errored');
                } else {
                    File::makeDirectory(env('REPOSITORY_ROUTE'));

                    $fileRepositoryServiceResponse = BuildPhpFileService::createRepositoryFile($repositoryName);

                    if ($fileRepositoryServiceResponse) {
                        return $this->components->info('The Repository created SuccessFully');
                    }

                    return $this->components->error('The repository errored');
                }
            }
        }

        return $this->components->error('The repository name is required');
    }
}
