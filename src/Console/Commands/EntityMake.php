<?php

namespace BukanKalengKaleng\LaravelEntity\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class EntityMake extends Command
{
    protected $data;
    protected $entity;
    protected $namespace;
    protected $modelName;
    protected $modelFullPath;
    protected $modelNamespace;
    protected $controllerName;
    protected $pluralizedEntity;
    protected $requestStoreName;
    protected $requestUpdateName;
    protected $additionalSteps  = [];
    protected $tableContents    = [];
    protected $tableHeaders     = ['Artefact', 'Filename and/or Location'];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'entity:make
                            {name : Name of the entity, eg: Post, Product, Employee}
                            {--namespace=Both : eg: Both | None | [your-choice]}
                            {--a|all=true : Generate an entity\'s with its all artefacts}
                            {--c|controller : Generate an entity\'s Controller}
                            {--d|dummy : Generate an entity\'s Dummy Seeder}
                            {--f|factory : Generate an entity\'s Factory}
                            {--m|migration : Generate an entity\'s Migration}
                            {--p|policy : Generate an entity\'s Policy}
                            {--r|request : Generate an entity\'s Request}
                            {--s|seeder : Generate an entity\'s Table Seeder}
                            {--t|test : Generate an entity\'s Unit and Feature Test} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate an entity along with their artefacts';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line('');

        if ($this->option('all')) {
            $this->input->setOption('controller', true);
            $this->input->setOption('dummy', true);
            $this->input->setOption('factory', true);
            $this->input->setOption('migration', true);
            $this->input->setOption('policy', true);
            $this->input->setOption('request', true);
            $this->input->setOption('seeder', true);
            $this->input->setOption('test', true);
        }

        $this->comment('[START] Creating new entity.....');

        $this->entity    = $this->setEntityName($this->argument('name'));
        $this->namespace = $this->option('namespace');

        switch ($this->checkExistingModel()) {
            case 'Abort':
                $this->line('Aborted.');
                $this->info('');

                break;

            case 'Use existing model':
                $this->line('Model already exists: '.$this->modelNamespace.'/'.$this->modelName);

                $this->makeMigration();
                $this->makeRequest();
                $this->makeController();
                $this->makeFactory();
                $this->makePolicy();
                $this->makeSeeder();
                $this->makeTest();

                $this->printReport();
                $this->printAdditionalSteps();

                break;

            case 'Overwrite existing model':

            case 'No model':
            default:
                $this->makeModel();
                $this->makeMigration();
                $this->makeRequest();
                $this->makeController();
                $this->makeFactory();
                $this->makePolicy();
                $this->makeSeeder();
                $this->makeTest();

                $this->printReport();
                $this->printAdditionalSteps();

                break;
        }
    }

    /**
     * Set a proper entity name
     *
     * @param String $name
     * @return void
     */
    protected function setEntityName($name) {
        if ($this->argument('name') == strtolower($this->argument('name'))) {
            return ucfirst($this->argument('name'));
        }

        return $this->argument('name');
    }

    /**
     * Check for existing model
     *
     * @return void
     */
    protected function checkExistingModel()
    {
        $modelChoice = '';
        $this->modelName = $this->entity.'.php';
        $this->modelNamespace = 'App/'.config('entity.model.namespace');
        $this->modelFullPath  = app_path(config('entity.model.namespace').'/'.$this->modelName);

        if ($this->files->exists($this->modelFullPath)) {
            $this->error('Model already exists: '.$this->modelNamespace.'/'.$this->modelName);

            $modelChoice = $this->choice('What should we do?', [
                'Overwrite existing model',
                'Use existing model',
                'Abort'
            ]);
        }
        else {
            $this->makeDirectory($this->modelFullPath);

            $modelChoice = 'No model';

            return $modelChoice;
        }

        return $modelChoice;
    }

    /**
     * Run make:model command with defined entity name and/or namespace
     *
     * @return void
     */
    protected function makeModel()
    {
        if (config('entity.model.should_use_default_base') === true) {
            $this->compileModelStub($this->modelFullPath);
        }
        else {
            // TODO: Create custom base model, if not exists

            $this->compileCustomModelStub($this->modelFullPath);
        }

        $this->addToTable('Model', $this->modelNamespace.'/'.$this->modelName);

        $this->info($this->data['artefact'].' created.');
    }

    /**
     * Compile the Model stub
     *
     * @param String $path
     * @return void
     */
    protected function compileModelStub($path)
    {
        $stub = $this->files->get(__DIR__.'/stubs/model.stub');

        $stub = str_replace('{{className}}', $this->entity, $stub);
        $stub = str_replace('{{classNamespace}}', config('entity.model.namespace'), $stub);

        $this->files->put($path, $stub);

        return $this;
    }

    /**
     * Compile the Custom Model stub
     *
     * @param String $path
     * @return void
     */
    protected function compileCustomModelStub($path)
    {
        $stub = $this->files->get(__DIR__.'/stubs/model.custom.stub');

        $customBaseModelNamepace = '';

        if (! empty(config('entity.model.custom_base_directory'))) {
            $customBaseModelNamepace = config('entity.model.custom_base_directory').'\\';
        }

        $customBaseModelNamepace .= config('entity.model.custom_base_name');

        $stub = str_replace('{{classNamespace}}', config('entity.model.namespace'), $stub);

        $stub = str_replace('{{customBaseModelNamespace}}', $customBaseModelNamepace, $stub);

        $stub = str_replace('{{className}}', $this->entity, $stub);
        $stub = str_replace('{{customBaseName}}', config('entity.model.custom_base_name'), $stub);

        $this->files->put($path, $stub);

        return $this;
    }

    /**
     * Run make:migration command with defined entity name and/or namespace
     *
     * @return void
     */
    protected function makeMigration()
    {
        if ($this->option('migration')) {

            $this->pluralizedEntity = str_plural($this->entity);
            $migration = 'create_'.snake_case($this->pluralizedEntity).'_table';

            $this->callSilent('make:migration', [
                'name'      => $migration,
                '--create'  => snake_case($this->pluralizedEntity),
            ]);

            $this->addToTable('Migration', $migration.'.php');

            $this->info($this->data['artefact'].' created.');
        }
    }

    /**
     * Run make:request command with defined entity name and/or namespace
     *
     * @return void
     */
    protected function makeRequest()
    {
        if ($this->option('request')) {

            $this->requestStoreName  = $this->entity.'Store.php';
            $this->requestUpdateName = $this->entity.'Update.php';

            $formRequestPath = app_path('Http/Requests');
            $backendPath  = $formRequestPath.'/'.config('entity.namespace.backend');
            $frontendPath = $formRequestPath.'/'.config('entity.namespace.frontend');

            $fileExistsMessage = 'Form Request already exists:';

            switch (strtolower($this->namespace)) {
                case 'both':
                    /** Store Request on Backend namespace */

                    if ($this->files->exists(
                        $path = $backendPath.'/'.$this->requestStoreName
                    )) {
                        $this->input->setOption('request', false);

                        $this->line($fileExistsMessage.' '.config('entity.namespace.backend').'/'.$this->requestStoreName);
                    }
                    else {
                        $this->callSilent('make:request', [
                            'name' => config('entity.namespace.backend').'/'.$this->removeFileExtension($this->requestStoreName)
                        ]);

                        $this->addToTable('Form Request', config('entity.namespace.backend').'/'.$this->requestStoreName);
                    }

                    /** Update Request on Backend namespace */

                    if ($this->files->exists(
                        $path = $backendPath.'/'.$this->requestUpdateName
                    )) {
                        $this->input->setOption('request', false);

                        $this->line($fileExistsMessage.' '.config('entity.namespace.backend').'/'.$this->requestUpdateName);
                    }
                    else {
                        $this->callSilent('make:request', [
                            'name' => config('entity.namespace.backend').'/'.$this->removeFileExtension($this->requestUpdateName)
                        ]);

                        $this->addToTable('Form Request', config('entity.namespace.backend').'/'.$this->requestUpdateName);
                    }

                    /** Store Request on Frontend namespace */

                    if ($this->files->exists(
                        $path = $frontendPath.'/'.$this->requestStoreName
                    )) {
                        $this->input->setOption('request', false);

                        $this->line($fileExistsMessage.' '.config('entity.namespace.frontend').'/'.$this->requestStoreName);
                    }
                    else {
                        $this->callSilent('make:request', [
                            'name' => config('entity.namespace.frontend').'/'.$this->removeFileExtension($this->requestStoreName)
                        ]);

                        $this->addToTable('Form Request', config('entity.namespace.frontend').'/'.$this->requestStoreName);
                    }

                    /** Update Request on Frontend namespace */

                    if ($this->files->exists(
                        $path = $frontendPath.'/'.$this->requestUpdateName
                    )) {
                        $this->input->setOption('request', false);

                        $this->line($fileExistsMessage.' '.config('entity.namespace.frontend').'/'.$this->requestUpdateName);
                    }
                    else {
                        $this->callSilent('make:request', [
                            'name' => config('entity.namespace.frontend').'/'.$this->removeFileExtension($this->requestUpdateName)
                        ]);

                        $this->addToTable('Form Request', config('entity.namespace.frontend').'/'.$this->requestUpdateName);
                    }

                    break;

                case 'none':
                    /** Store Request */

                    if ($this->files->exists(
                        $path = $formRequestPath.'/'.$this->requestStoreName
                    )) {
                        $this->input->setOption('request', false);

                        $this->line($fileExistsMessage.' '.$this->requestStoreName);
                    }
                    else {
                        $this->callSilent('make:request', [
                            'name' => $this->removeFileExtension($this->requestStoreName)
                        ]);

                        $this->addToTable('Form Request', $this->requestStoreName);
                    }

                    /** Update Request */

                    if ($this->files->exists(
                        $path = $formRequestPath.'/'.$this->requestUpdateName
                    )) {
                        $this->input->setOption('request', false);

                        $this->line($fileExistsMessage.' '.$this->requestUpdateName);
                    }
                    else {
                        $this->callSilent('make:request', [
                            'name' => $this->removeFileExtension($this->requestUpdateName)
                        ]);

                        $this->addToTable('Form Request', $this->requestUpdateName);
                    }

                    break;

                default:
                    /** Store Request */

                    if ($this->files->exists(
                        $path = $formRequestPath.'/'.$this->namespace.'/'.$this->requestStoreName
                    )) {
                        $this->input->setOption('request', false);

                        $this->line($fileExistsMessage.' '.$this->namespace.'/'.$this->requestStoreName);
                    }
                    else {
                        $this->callSilent('make:request', [
                            'name' => $this->namespace.'/'.$this->removeFileExtension($this->requestStoreName)
                        ]);

                        $this->addToTable('Form Request', $this->namespace.'/'.$this->requestStoreName);
                    }

                    /** Frontend Request */

                    if ($this->files->exists(
                        $path = $formRequestPath.'/'.$this->namespace.'/'.$this->requestUpdateName
                    )) {
                        $this->input->setOption('request', false);

                        $this->line($fileExistsMessage.' '.$this->namespace.'/'.$this->requestUpdateName);
                    }
                    else {
                        $this->callSilent('make:request', [
                            'name' => $this->namespace.'/'.$this->removeFileExtension($this->requestUpdateName)
                        ]);

                        $this->addToTable('Form Request', $this->namespace.'/'.$this->requestUpdateName);
                    }

                    break;
            }

            if ($this->option('request')) {
                $this->info($this->data['artefact'].' created.');
            }
        }
    }

    /**
     * Run make:controller command with defined entity name and/or namespace
     *
     * @return void
     */
    protected function makeController()
    {
        if ($this->option('controller')) {

            $this->controllerName = $this->entity.'Controller.php';

            $controllerPath = app_path('Http/Controllers');
            $backendPath  = $controllerPath.'/'.config('entity.namespace.backend');
            $frontendPath = $controllerPath.'/'.config('entity.namespace.frontend');

            $fileExistsMessage = 'Controller already exists:';

            switch (strtolower($this->namespace)) {
                case 'both':
                    /** Backend's Controller */

                    if ($this->files->exists(
                        $path = $backendPath.'/'.$this->controllerName
                    )) {
                        $this->input->setOption('controller', false);

                        $this->line($fileExistsMessage.' '.config('entity.namespace.backend').'/'.$this->controllerName);
                    }
                    else {
                        $this->compileControllerStub($path, config('entity.namespace.backend'));

                        $this->addToTable('Controller', config('entity.namespace.backend').'/'.$this->controllerName);
                    }

                    /** Frontend's Controller */

                    if ($this->files->exists(
                        $path = $frontendPath.'/'.$this->controllerName
                    )) {
                        $this->input->setOption('controller', false);

                        $this->line($fileExistsMessage.' '.config('entity.namespace.frontend').'/'.$this->controllerName);
                    }
                    else {
                        $this->compileControllerStub($path, config('entity.namespace.frontend'));

                        $this->addToTable('Controller', config('entity.namespace.frontend').'/'.$this->controllerName);
                    }

                    break;

                case 'none':
                    if ($this->files->exists(
                        $path = $controllerPath.'/'.$this->controllerName
                    )) {
                        $this->input->setOption('controller', false);

                        $this->line($fileExistsMessage.' '.$this->controllerName);
                    }
                    else {
                        $this->compileControllerStub($path);

                        $this->addToTable('Controller', $this->controllerName);
                    }

                    break;

                default:
                    if ($this->files->exists(
                        $path = $controllerPath.'/'.$this->namespace.'/'.$this->controllerName
                    )) {
                        $this->input->setOption('controller', false);

                        $this->line($fileExistsMessage.' '.$this->namespace.'/'.$this->controllerName);
                    }
                    else {
                        $this->compileControllerStub($path, $this->namespace);

                        $this->addToTable('Controller', $this->namespace.'/'.$this->controllerName);
                    }

                    break;
            }

            if ($this->option('controller')) {
                $this->info($this->data['artefact'].' created.');
            }
        }
    }

    /**
     * Compile the Controller stub
     *
     * @param String $path
     * @return void
     */
    protected function compileControllerStub($path, $namespace = '')
    {
        if ($namespace) {
            $stub = $this->files->get(__DIR__.'/stubs/controller.stub');
        }
        else {
            $stub = $this->files->get(__DIR__.'/stubs/controller.none.stub');
        }

        $stub = str_replace('{{classNamespace}}', $namespace, $stub);

        $stub = str_replace('{{modelNamespace}}', config('entity.model.namespace'), $stub);
        $stub = str_replace('{{modelName}}', $this->removeFileExtension($this->modelName), $stub);

        $stub = str_replace('{{className}}', $this->removeFileExtension($this->controllerName), $stub);

        $stub = str_replace('{{requestStoreNamespace}}', $namespace, $stub);
        $stub = str_replace('{{requestStoreName}}', $this->removeFileExtension($this->requestStoreName), $stub);

        $stub = str_replace('{{requestUpdateNamespace}}', $namespace, $stub);
        $stub = str_replace('{{requestUpdateName}}', $this->removeFileExtension($this->requestUpdateName), $stub);

        $stub = str_replace('{{modelNameVariabel}}', camel_case($this->entity), $stub);

        $this->makeDirectory($path);

        $this->files->put($path, $stub);

        return $this;
    }

    /**
     * Run make:factory command with defined entity name and/or namespace
     *
     * @return void
     */
    protected function makeFactory()
    {
        if ($this->option('factory')) {

            $factory = $this->entity.'Factory';

            if ($this->files->exists(
                $path = database_path('factories/'.$factory.'.php'))
            ) {
                $this->input->setOption('factory', false);

                return $this->line('Factory already exists: '.$factory.'.php');
            }

            $this->compileFactoryStub($path);

            $this->addToTable('Factory', $factory.'.php');

            $this->info($this->data['artefact'].' created.');
        }
    }

    /**
     * Compile the Factory stub
     *
     * @param String $path
     * @return void
     */
    protected function compileFactoryStub($path)
    {
        $stub = $this->files->get(__DIR__.'/stubs/model.factory.stub');

        $stub = str_replace('{{modelNamespace}}', config('entity.model.namespace'), $stub);
        $stub = str_replace('{{modelName}}', $this->removeFileExtension($this->modelName), $stub);

        $this->files->put($path, $stub);

        return $this;
    }

    /**
     * Run make:policy command with defined entity name and/or namespace
     *
     * @return void
     */
    protected function makePolicy()
    {
        if ($this->option('policy')) {

            $policy = $this->entity.'Policy';

            if ($this->files->exists(
                $path = app_path('Policies/'.$policy.'.php'))
            ) {
                $this->input->setOption('policy', false);

                return $this->line('Policy already exists: '.$policy.'.php');
            }

            $this->callSilent('make:policy', [
                'name'    => $policy,
                '--model' => config('entity.model.namespace').'/'.$this->entity,
            ]);

            $this->addToTable('Policy', $policy.'.php');

            $this->info($this->data['artefact'].' created.');

            array_push($this->additionalSteps, 'Register the Policy');
        }
    }

    /**
     * Run make:seed command with defined entity name and/or namespace
     *
     * @return void
     */
    protected function makeSeeder()
    {
        /** Table seeder */

        if ($this->option('seeder')) {

            $seederTable = ($this->pluralizedEntity).'TableSeeder.php';

            if ($this->files->exists(
                $path = database_path('seeds/'.$seederTable))
            ) {
                $this->input->setOption('seeder', false);

                $this->line('Table Seeder already exists: '.$seederTable);
            }
            else {
                $this->callSilent('make:seeder', [
                    'name' => $this->removeFileExtension($seederTable)
                ]);

                $this->addToTable('Table Seeder', $seederTable);

                $this->info($this->data['artefact'].' created.');

                array_push($this->additionalSteps, 'Call the Table Seeder in DatabaseSeeder');
            }
        }

        /** Dummy data seeder */

        if (config('entity.dummy.should_create') === true) {
            if ($this->option('dummy')) {

                $seederDummy = $this->pluralizedEntity.'.php';

                $path = database_path('seeds/'.config('entity.dummy.directory').'/'.$seederDummy);

                if ($this->files->exists($path)) {
                    $this->input->setOption('dummy', false);

                    $this->line('Dummy Seeder already exists: '.config('entity.dummy.dummies').$seederDummy);
                }
                else {
                    $this->compileDummySeederStub($path);

                    $this->makeDummyDataSeeder();

                    $this->addToTable('Dummy Seeder', config('entity.dummy.dummies').$seederDummy);

                    $this->info($this->data['artefact'].' created.');

                    array_push($this->additionalSteps, 'Call the Dummy seeder in DummyDataSeeder');
                }
            }
        }
    }

    /**
     * Compile the dummy data Seeder stub
     *
     * @param String $path
     * @return void
     */
    protected function compileDummySeederStub($path)
    {
        $stub = $this->files->get(__DIR__.'/stubs/seeder.dummy.stub');

        $stub = str_replace('{{modelNamespace}}', config('entity.model.namespace'), $stub);
        $stub = str_replace('{{modelName}}', $this->removeFileExtension($this->modelName), $stub);

        $stub = str_replace('{{className}}', $this->pluralizedEntity, $stub);

        $this->makeDirectory($path);

        $this->files->put($path, $stub);

        return $this;
    }

    /**
     * Make DummyDataSeeder, if not exists
     *
     * @return void
     */
    protected function makeDummyDataSeeder()
    {
        if (! $this->files->exists(
            $path = database_path('seeds/DummyDataSeeder.php')
        )) {
            $stub = $this->files->get(__DIR__.'/stubs/dataseeder.dummy.stub');

            $this->files->put($path, $stub);
        }
    }

    /**
     * Run make:test command with defined entity name and/or namespace
     *
     * @return void
     */
    protected function makeTest()
    {
        if ($this->option('test')) {

            /** Feature test */

            $test = $this->entity.'Test';

            if ($this->files->exists(
                $path = base_path().'/tests/Feature/'.$test.'.php')
            ) {
                $this->input->setOption('test', false);

                $this->line('Test: Feature already exists: Feature/'.$test.'.php');
            }
            else {
                $this->callSilent('make:test', [
                    'name' => $test
                ]);

                $this->addToTable('Test: Feature', 'Feature/'.$test.'.php');

                $this->info($this->data['artefact'].' created.');
            }

            /** Unit test */

            if ($this->files->exists(
                $path = base_path().'/tests/Unit/'.$test.'.php')
            ) {
                $this->input->setOption('test', false);

                $this->line('Test: Unit already exists: Unit/'.$test.'.php');
            }
            else {
                $this->callSilent('make:test', [
                    'name' => $test,
                    '--unit' => true,
                ]);

                $this->addToTable('Test: Unit', 'Unit/'.$test.'.php');

                $this->info($this->data['artefact'].' created.');
            }
        }
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param  string $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (! $this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }
    }

    /**
     * Print the whole command result / report
     *
     * @return void
     */
    protected function printReport()
    {
        if ($this->option('controller') ||
           ($this->option('controller') && $this->option('request'))) {

            array_push($this->additionalSteps, 'Define a route for the generated Controller');
        }
        else if ($this->option('request')) {

            array_push($this->additionalSteps, 'Use generated Requests for the Controller');
        }

        if (in_array(true, $this->options(), true) === false) {

            $this->error('No files has been created.');
        }

        $this->comment('[DONE ] Creating new entity.');
        $this->line('');

        if (in_array(true, $this->options(), true) === true) {

            $this->table($this->tableHeaders, $this->tableContents);
            $this->line('');
        }
    }

    /**
     * Print additional steps, if any
     *
     * @return void
     */
    protected function printAdditionalSteps()
    {
        if ($this->additionalSteps) {

            $this->comment('ATTENTION: You may have to proceed these additional steps:');

            foreach ($this->additionalSteps as $key => $step) {
                $this->line('- '.$step);
            }

            $this->line('');
        }
    }

    /**
     * Add new row of data to output table
     *
     * @param String $artefact
     * @param String $location
     * @return void
     */
    protected function addToTable($artefact, $location)
    {
        $this->data['artefact'] = $artefact;
        $this->data['location'] = $location;

        array_push($this->tableContents, $this->data);
    }

    /**
     * Remove '.php' extension from file name
     */
    protected function removeFileExtension($filename)
    {
        return substr($filename, 0, -4);
    }
}
