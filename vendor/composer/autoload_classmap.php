<?php

// autoload_classmap.php @generated by Composer

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'AdminSeeder' => $baseDir . '/app/database/seeds/AdminSeeder.php',
    'BaseController' => $baseDir . '/app/controllers/BaseController.php',
    'Company' => $baseDir . '/app/models/Company.php',
    'CompanyTableSeeder' => $baseDir . '/app/database/seeds/CompanyTableSeeder.php',
    'ConfideSetupUsersTable' => $baseDir . '/app/database/migrations/2014_10_20_061931_confide_setup_users_table.php',
    'DatabaseSeeder' => $baseDir . '/app/database/seeds/DatabaseSeeder.php',
    'EntrustSetupTables' => $baseDir . '/app/database/migrations/2014_10_20_063011_entrust_setup_tables.php',
    'HomeController' => $baseDir . '/app/controllers/HomeController.php',
    'IlluminateQueueClosure' => $vendorDir . '/laravel/framework/src/Illuminate/Queue/IlluminateQueueClosure.php',
    'Permission' => $baseDir . '/app/models/Permission.php',
    'PermissionTableSeeder' => $baseDir . '/app/database/seeds/PermissionTableSeeder.php',
    'Role' => $baseDir . '/app/models/Role.php',
    'RoleController' => $baseDir . '/app/controllers/RoleController.php',
    'RoleTableSeeder' => $baseDir . '/app/database/seeds/RoleTableSeeder.php',
    'SessionHandlerInterface' => $vendorDir . '/symfony/http-foundation/Symfony/Component/HttpFoundation/Resources/stubs/SessionHandlerInterface.php',
    'Test' => $baseDir . '/app/models/Test.php',
    'TestCase' => $baseDir . '/app/tests/TestCase.php',
    'User' => $baseDir . '/app/models/User.php',
    'UserRepository' => $baseDir . '/app/models/UserRepository.php',
    'UsersController' => $baseDir . '/app/controllers/UsersController.php',
    'Whoops\\Module' => $vendorDir . '/filp/whoops/src/deprecated/Zend/Module.php',
    'Whoops\\Provider\\Zend\\ExceptionStrategy' => $vendorDir . '/filp/whoops/src/deprecated/Zend/ExceptionStrategy.php',
    'Whoops\\Provider\\Zend\\RouteNotFoundStrategy' => $vendorDir . '/filp/whoops/src/deprecated/Zend/RouteNotFoundStrategy.php',
    'Zizaco\\Confide\\ControllerCommand' => $vendorDir . '/zizaco/confide/src/commands/ControllerCommand.php',
    'Zizaco\\Confide\\MigrationCommand' => $vendorDir . '/zizaco/confide/src/commands/MigrationCommand.php',
    'Zizaco\\Confide\\RoutesCommand' => $vendorDir . '/zizaco/confide/src/commands/RoutesCommand.php',
    'Zizaco\\Entrust\\MigrationCommand' => $vendorDir . '/zizaco/entrust/src/commands/MigrationCommand.php',
);