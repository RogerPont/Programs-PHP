@echo off
setlocal EnableDelayedExpansion

set "PREFIX=html/B2/Tasca01/0613_B2_biblioteca_PontRoger"
set "REMOTE_NAME=biblioteca"
set "REMOTE_URL=https://github.com/RogerPont/0613_B2_biblioteca_PontRoger.git"

:: 1. Comprova si el remot 'biblioteca' existeix; si no, l'afegeix automaticament
git remote get-url %REMOTE_NAME% >nul 2>&1
if errorlevel 1 (
    echo Afegint el repositori remot %REMOTE_NAME%...
    git remote add %REMOTE_NAME% %REMOTE_URL%
)

:: 2. Sincronitza l'estat actual del repositori secundari
echo Comprovant l'estat del repositori %REMOTE_NAME%...
git fetch %REMOTE_NAME% >nul 2>&1

:: 3. Obte l'arbre (tree) de la carpeta biblioteca de l'ultim commit
set "SUBTREE_HASH="
for /f "delims=" %%i in ('git rev-parse "HEAD:%PREFIX%" 2^>nul') do set "SUBTREE_HASH=%%i"

if not defined SUBTREE_HASH (
    echo Error: No s'ha trobat la carpeta %PREFIX% a l'ultim commit.
    echo Assegura't d'haver fet 'git add .' i 'git commit' abans.
    exit /b 1
)

:: 4. Comprova si el repositori secundari ja te commits a la branca 'main'
set "PARENT_COMMIT="
for /f "delims=" %%i in ('git rev-parse --verify "refs/remotes/%REMOTE_NAME%/main" 2^>nul') do set "PARENT_COMMIT=%%i"

set "PARENT_ARG="
if defined PARENT_COMMIT (
    for /f "delims=" %%i in ('git rev-parse "refs/remotes/%REMOTE_NAME%/main^{tree}" 2^>nul') do set "REMOTE_TREE=%%i"
    if "!SUBTREE_HASH!"=="!REMOTE_TREE!" (
        echo El repositori %REMOTE_NAME% ja esta al dia ^(no hi ha canvis nous a la carpeta^).
        exit /b 0
    )
    set "PARENT_ARG=-p !PARENT_COMMIT!"
)

:: 5. Crea el commit nomes amb el contingut de la carpeta biblioteca (sense usar sh.exe)
set "NEW_COMMIT="
for /f "delims=" %%i in ('git log -1 --pretty^=%%B HEAD ^| git commit-tree %SUBTREE_HASH% %PARENT_ARG%') do set "NEW_COMMIT=%%i"

if not defined NEW_COMMIT (
    echo Error creant el commit per al repositori %REMOTE_NAME%.
    exit /b 1
)

:: 6. Envia el nou commit a la branca main del repositori secundari
echo Pujant els canvis a %REMOTE_NAME% (main)...
git push %REMOTE_NAME% %NEW_COMMIT%:refs/heads/main

if errorlevel 1 (
    echo Error pujant els canvis a %REMOTE_NAME%.
    exit /b 1
)

echo Fet! El repositori %REMOTE_NAME% s'ha actualitzat correctament.
