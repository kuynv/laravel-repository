<?php
namespace Qnv\Repository\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Input\InputOption;

class RepositoryMakeInterfaceCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository-interface {name}';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected $description = 'Command make repository interface';

    protected function getStub()
    {
        // TODO: Implement getStub() method.
        return  $this->resolveStubPath('/stubs/repository-interface.stub');
    }

    protected $type = 'Repository interface ';
    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveStubPath($stub)
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__ . $stub;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\\Repositories';
    }

    protected function replaceNamespace(&$stub, $name)
    {
        parent::replaceNamespace($stub, $name);
        $stub = str_replace(
            [
                'DummyInterface'
            ],
            [
                $this->getFileName(),
            ],
            $stub
        );

        return $this;
    }

    public function getFileName(){
        $name = $this->argument('name');

        $name = ltrim($name, '\\/');

        $name = str_replace('/', '\\', $name);
        $names = explode('\\',$name);
        return end($names);
    }
}
