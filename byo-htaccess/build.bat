REM Change directory to script directory
cd /D "%~dp0"

set tag="byo-htaccess"
set "ports=-p 8882:80"

docker build --tag %tag% .
if %errorlevel% neq 0 exit /b %errorlevel%
if defined no_run goto END
docker run -ti --init --rm %ports% %tag% 
:END