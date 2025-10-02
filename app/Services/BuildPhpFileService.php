<?php

namespace App\Services;

class BuildPhpFileService
{
    protected static function createFile(string $fileName, string $directory): bool
    {
        $file = $fileName . ".php";
        $path = 'app\\'.$directory.'\\' . $file;
        $code = "<?php";

        return file_put_contents($path, $code);
    }

    public static function createRepositoryFile(string $repositoryName): bool
    {
        $directory = "Repositories";
        return self::createFile($repositoryName, $directory);
    }

    public static function createServiceFile(string $serviceName): bool
    {
        $directory = "Services";
        return self::createFile($serviceName, $directory);
    }

}
