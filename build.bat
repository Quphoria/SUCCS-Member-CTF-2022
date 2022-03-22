@echo off

set "challs=welcome whats-htaccess byo-htaccess jwt_is_secure_right openvpn-gateway template"

cd /D "%~dp0"

@REM This is because we want to use errorlevel inside the for loop
@REM So we have to delay its expansion so it gets evaluated correctly
setlocal EnableDelayedExpansion

set no_run=1
for %%a in (%challs%) do ( 
    echo Building: %%a
    call "%%a/build.bat"
    if !errorlevel! neq 0 (
        echo Failed to build: %%a
        exit /b !errorlevel!
    )
    @REM Return to main script directory
    cd /D "%~dp0"
)

echo Saving images to ctf.tar
docker save --output ctf.tar %challs%