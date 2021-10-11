<?php
namespace Qnv\Repository\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Input\InputOption;

class RepositoryMakeClassCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:repository-class';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository class';

    protected $type = 'Repository class ';

    protected function getStub()
    {
        // TODO: Implement getStub() method.
        return  $this->resolveStubPath('/stubs/repository-class.stub');
    }

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

    protected function replaceNamespace(&$stub, $name)
    {
        parent::replaceNamespace($stub, $name);
        $DummyRepositoryClassUse = config('qnv-repository.database.'.trim($this->option('database')));
        $arr = explode('\\',$DummyRepositoryClassUse);
        $DummyRepositoryClass = end($arr);

        $stub = str_replace(
            [
                'DummyRepositoryClassUse',
                'DummyRepositoryClass',
                'DummyInterface',
                'DummyModelUse',
                'DummyModel',
            ],
            [
                $DummyRepositoryClassUse,
                $DummyRepositoryClass,
                trim($this->getInterfaceName()),
                trim($this->option('model')),
                trim($this->getModelName()),
            ],
            $stub
        );

        return $this;
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

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'Generate a model'],
            ['database', 'db', InputOption::VALUE_OPTIONAL, 'Database for repository', 'Eloquent']
        ];
    }

    public function getFileName(){
        $name = $this->argument('name');

        $name = ltrim($name, '\\/');

        $name = str_replace('/', '\\', $name);
        $names = explode('\\',$name);
        return end($names);
    }

    public function getInterfaceName(){
        $name = $this->argument('name');

        $name = ltrim($name, '\\/');

        $name = str_replace('/', '\\', $name);
        $names = explode('\\',$name);
        return $names[count($names)-2] . 'RepositoryInterface';
    }

    public function getModelName(){
        $name = $this->argument('name');

        $name = ltrim($name, '\\/');

        $name = str_replace('/', '\\', $name);
        $names = explode('\\',$name);
        return $names[count($names)-2];
    }
}
