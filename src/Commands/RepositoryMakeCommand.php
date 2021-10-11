<?php
namespace Qnv\Repository\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class RepositoryMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:repository';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create a new repository';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if(!in_array($this->option('database'),array_keys(Config::get('qnv-repository.database')))){
            $this->error('Database not exists');
            return false;
        }

        $this->call('make:model', ['name' => $this->getModelName()]);
        $this->call('make:repository-interface', ['name' => $this->getRepositoryInterfaceName()]);

        $this->call('make:repository-class', [
            'name' => $this->getRepositoryClassName(),
            '--model'=> $this->getModelName(),
            '--database'=> $this->option('database'),
        ]);
        $this->info('make repository success.');
    }

    public function getFileName(){
        $name = $this->argument('name');

        $name = ltrim($name, '\\/');

        $name = str_replace('/', '\\', $name);
        $names = explode('\\',$name);
        return end($names);
    }
    public function getRepositoryClassName(){
        return $this->argument('name').'\\'.$this->getFileName().'Repository'.$this->option('database');
    }

    public function getRepositoryInterfaceName(){
        return $this->argument('name').'\\'.$this->getFileName().'RepositoryInterface';
    }

    public function getModelName(){
        return $this->option('model') ? $this->option('model') : $this->argument('name');
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
            ['database', 'db', InputOption::VALUE_OPTIONAL, 'Database for repository', 'Eloquent'],
        ];
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the class']
        ];
    }
}
