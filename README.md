# ACL
ACL (Access Control List) for Laravel

How to use:
1. Import sql from folder sql
2. Insert data in table setting
3. Create new folder "Helpers" in "project_name/app/"
4. Create file in folder "Helpers"
5. Copy file "Acl.php" to folder "Helpers"
6. Register Acl.php in "config/app.php" some like this:
    ```
    /*
        |
        | Class Aliases
        |
        |
        | This array of class aliases will be registered when this application
        | is started. However, feel free to register as many as you wish as
        | the aliases are "lazy" loaded so they don't hinder performance.
        |
    */

    'aliases' => Facade::defaultAliases()->merge([
        'Acl' => App\Helpers\Acl::class
    ])->toArray()
    ```
7. Call ACL on controller and use ACL, example:
    ```
    <?php

        namespace App\Http\Controllers;

        use App\Models\Dashboard;
        use Illuminate\Http\Request;
        use Acl; // call Acl class

        class DashboardController extends Controller
        {
            function __construct(){
                $this->acl = new Acl; //Init acl
            }
            function index(){
                //Use acl for check permission action read
                $this->acl->validateRead();
            }
        }
    ```
8.  Ejoy to use   

__Note__: If you 
1. use ajax for submit form  so acl will be return json
2. not use ajax pure use php so acl will be redirect to default page and you can show message with call variable session "msg_permission" some like "Session::has('msg_permission')" 
# Methods
| Function | Param | Description |
| --- | --- | --- |
| validateRead() | class_name, is_json, is_array | Check permission read |
| validateStore() | class_name, is_json, is_array | Check permission insert |
| validateUpdate() | class_name, is_json, is_array | Check permission update |
| validateDestroy() | class_name, is_json, is_array | Check permission destroy |
| validateApproved() | class_name, is_json, is_array | Check permission approved |
| checkMySession() |  | Check session |