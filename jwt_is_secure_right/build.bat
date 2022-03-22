REM Change directory to script directory
cd /D "%~dp0"

set tag="jwt_is_secure_right"
set "ports=-p 8883:80"

docker build --tag %tag% .
if %errorlevel% neq 0 exit /b %errorlevel%
if defined no_run goto END
docker run -ti --init --rm %ports% %tag% 
:END