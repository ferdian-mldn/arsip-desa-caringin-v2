$word = New-Object -ComObject Word.Application
$doc = $word.Documents.Open("c:\laragon\www\arsip desa v2\desav2\storage\app\templates\form._ktp.docx")
$text = ""
foreach ($t in $doc.Tables) {
    foreach ($r in $t.Rows) {
        $rowText = ""
        foreach ($c in $r.Cells) {
            $val = $c.Range.Text.Trim()
            $val = $val -replace "[\a\b\r\n]", ""
            $rowText += $val + "|"
        }
        $text += $rowText + "`n"
    }
    $text += "---`n"
}
$text | Out-File "ktp_tables.txt"
$doc.Close($false)
$word.Quit()
[System.Runtime.Interopservices.Marshal]::ReleaseComObject($word) | Out-Null
