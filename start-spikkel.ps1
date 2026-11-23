$ErrorActionPreference = 'Stop'
$phpExecutable = (Get-Command php -CommandType Application).Source

function Test-LocalMySql {
    $client = [Net.Sockets.TcpClient]::new()
    try {
        return $client.ConnectAsync('127.0.0.1', 3306).Wait(250) -and $client.Connected
    } catch {
        return $false
    } finally {
        $client.Dispose()
    }
}

if (-not (Test-LocalMySql)) {
    $mysqlExecutable = 'C:\Program Files\MySQL\MySQL Server 8.4\bin\mysqld.exe'
    $optionsFile = Join-Path ([Environment]::GetFolderPath('LocalApplicationData')) 'CakeCms\my.ini'
    if (-not (Test-Path -LiteralPath $mysqlExecutable) -or -not (Test-Path -LiteralPath $optionsFile)) {
        throw 'Start de lokale MySQL-server op 127.0.0.1:3306 en probeer het opnieuw.'
    }
    Write-Output 'MySQL starten...'
    Start-Process -FilePath $mysqlExecutable -ArgumentList ('--defaults-file="' + $optionsFile + '"') -WindowStyle Hidden
    $deadline = (Get-Date).AddSeconds(55)
    do {
        Start-Sleep -Milliseconds 500
        $databaseReady = Test-LocalMySql
    } until ($databaseReady -or (Get-Date) -ge $deadline)
    if (-not $databaseReady) { throw 'MySQL reageert niet. Zie mysql-error.log in AppData\Local\CakeCms.' }
}

Set-Location -LiteralPath $PSScriptRoot
Write-Output 'Studio Spikkel draait op http://localhost:8766. Stoppen kan met Ctrl+C.'
& $phpExecutable -d upload_max_filesize=5M -d post_max_size=8M -S 127.0.0.1:8766 -t webroot webroot/index.php
exit $LASTEXITCODE
