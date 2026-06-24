$word = New-Object -ComObject Word.Application
$word.Visible = $false
$doc = $word.Documents.Open("c:\laragon\www\arsip desa v2\desav2\storage\app\templates\form._ktp.docx")

$i = 1
foreach ($table in $doc.Tables) {
    Write-Host "Table $i : Rows = $($table.Rows.Count), Cols = $($table.Columns.Count)"
    $i++
}

$doc.Close($false)
$word.Quit()
[System.Runtime.Interopservices.Marshal]::ReleaseComObject($word) | Out-Null
