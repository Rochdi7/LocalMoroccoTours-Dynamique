# rollback-tours-data-image-matching.ps1
# Restores tours-data.md from the verified pre-matching backup.
# Touches nothing else: no images, no Laravel code, no database.
$ErrorActionPreference = 'Stop'
$root    = 'C:\Users\ASUS\Desktop\Clients\LocalMoroccoTours\LocalMoroccoTours'
$data    = Join-Path $root 'tours-data.md'
$backup  = Join-Path $root 'tours-data.backup-before-image-matching.md'
$expectedBackupSha = 'bffd6ca43af8bb08ec6ff6ea385d1d98b9529bac5e475a61f0d49835d2fe1dd4'

if (-not (Test-Path -LiteralPath $backup)) { throw "Backup not found: $backup" }
$backupSha = (Get-FileHash -LiteralPath $backup -Algorithm SHA256).Hash.ToLower()
if ($backupSha -ne $expectedBackupSha) {
  throw "Backup SHA-256 mismatch. Expected $expectedBackupSha, got $backupSha. Aborting - backup may be corrupted."
}
Write-Host "Backup verified: $backupSha"
Write-Host "This will REPLACE the current tours-data.md (with image blocks) by the pre-matching version."

$stamp = Get-Date -Format 'yyyyMMdd-HHmmss'
$safety = Join-Path $root "tours-data.before-rollback-$stamp.md"

$answer = Read-Host 'Type YES to restore tours-data.md from the backup'
if ($answer -ne 'YES') { Write-Host 'Aborted. Nothing changed.'; exit 1 }

Copy-Item -LiteralPath $data -Destination $safety
Write-Host "Safety copy of current file: $safety"
Copy-Item -LiteralPath $backup -Destination $data -Force
$restoredSha = (Get-FileHash -LiteralPath $data -Algorithm SHA256).Hash.ToLower()
if ($restoredSha -ne $expectedBackupSha) { throw 'Restore verification failed!' }
Write-Host "tours-data.md restored and verified ($restoredSha)."
Write-Host 'Image files, Laravel code and database were not touched.'
