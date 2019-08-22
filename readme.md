- Copy file .env.example -> .env
- cmd: composer install 
- run: php artisan serve 
- vào vendor\unisharp\laravel-filemanager\src\Handlers\ConfigHandler.php
    + paste:
    ```
        $user = Auth::guard('admin')->user();
        if($user->permission == 'user'){

            return $user->hotelInfomation()->first()->name;
        }
    
    ```
    + import:
    ```use Illuminate\Support\Facades\Auth;```



- sửa lỗi [Failed to open stream: Permission denied](https://aleksey.co/blog/hotfix-laravel-failed-to-open-stream-permission-denied)  

- File Excel [Could not find package ~2.1.0 ](https://github.com/Maatwebsite/Laravel-Excel/issues/735)