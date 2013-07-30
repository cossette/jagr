@ECHO OFF

:: :::::::::::::::::::::::::: ::
::        _____   __________  :: 
::       / /   | / ____/ __ \ :: 
::  __  / / /| |/ / __/ /_/ / :: 
:: / /_/ / ___ / /_/ / _, _/  :: 
:: \____/_/  |_\____/_/ |_|   :: 
::                            :: 
::    Stanley Cup winning     :: 
::  snapshot baking machine   ::
:: :::::::::::::::::::::::::: ::

:: Clean up files before regenerating them ::
CALL php -f "cleanup.php"

:: Return to root folder (assuming .bat file is in /app/Console/Templates/jagr) ::
CD ..\..\..\..\

:: Example calls to bake ALL THE THINGS ::
:: CALL app\Console\cake bake model all
:: CALL app\Console\cake bake controller all
:: CALL app\Console\cake bake view all

:: Example calls to bake SOME THINGS ::
CALL app\Console\cake bake model ModelName
CALL app\Console\cake bake controller ModelName --admin
CALL app\Console\cake bake view ModelName --admin

pause