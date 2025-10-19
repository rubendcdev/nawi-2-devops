@echo off
echo Limpiando cache del sistema para PWA...

REM Limpiar cache de Chrome
echo Limpiando cache de Chrome...
taskkill /f /im chrome.exe 2>nul
timeout /t 2 /nobreak >nul
rmdir /s /q "%LOCALAPPDATA%\Google\Chrome\User Data\Default\Cache" 2>nul
rmdir /s /q "%LOCALAPPDATA%\Google\Chrome\User Data\Default\Code Cache" 2>nul

REM Limpiar cache de Edge
echo Limpiando cache de Edge...
taskkill /f /im msedge.exe 2>nul
timeout /t 2 /nobreak >nul
rmdir /s /q "%LOCALAPPDATA%\Microsoft\Edge\User Data\Default\Cache" 2>nul
rmdir /s /q "%LOCALAPPDATA%\Microsoft\Edge\User Data\Default\Code Cache" 2>nul

REM Limpiar cache de aplicaciones PWA
echo Limpiando cache de PWA...
rmdir /s /q "%LOCALAPPDATA%\Microsoft\Edge SxS\User Data\Default\Cache" 2>nul
rmdir /s /q "%LOCALAPPDATA%\Google\Chrome SxS\User Data\Default\Cache" 2>nul

echo Cache del sistema limpiado.
echo Ahora desinstala y reinstala la PWA.
pause
