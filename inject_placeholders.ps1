$word = New-Object -ComObject Word.Application
$word.Visible = $false
$folder = "c:\laragon\www\arsip desa v2\desav2\storage\app\templates\"
$files = Get-ChildItem -Path $folder -Filter "*.docx"

$replacements = @(
    @{"f"='MIMIN'; "r"='${NAMA_LENGKAP}'},
    @{"f"='3271015506620047'; "r"='${NIK}'},
    @{"f"='Sukabumi, 15-06-1962'; "r"='${TTL}'},
    @{"f"='FIRMAN'; "r"='${NAMA_LENGKAP}'},
    @{"f"='3202400702790003'; "r"='${NIK}'},
    @{"f"='Sukabumi, 07-02-1976'; "r"='${TTL}'},
    @{"f"='HANI FITRIANI'; "r"='${NAMA_LENGKAP}'},
    @{"f"='320240678010002'; "r"='${NIK}'},
    @{"f"='Sukabumi, 27-08-2001'; "r"='${TTL}'},
    @{"f"='AISAH'; "r"='${NAMA_LENGKAP}'},
    @{"f"='3320124101700005'; "r"='${NIK}'},
    @{"f"='Sukabumi, 01-01-1970'; "r"='${TTL}'},
    @{"f"='JAMALUDIN'; "r"='${NAMA_LENGKAP}'},
    @{"f"='3202400908072860'; "r"='${NO_KK}'},
    @{"f"='3202400206940001'; "r"='${NIK}'},
    @{"f"='Sukabumi, 02 – 06  - 1994'; "r"='${TTL}'},
    @{"f"='IMAS'; "r"='${NAMA_LENGKAP}'},
    @{"f"='3202404411730001'; "r"='${NIK}'},
    @{"f"='Sukabumi, 04-11-1973'; "r"='${TTL}'},
    @{"f"='RAYHAN KAHFI FADILLAH'; "r"='${NAMA_LENGKAP}'},
    @{"f"='3671072409090009'; "r"='${NIK}'},
    @{"f"='3202400908072605'; "r"='${NO_KK}'},
    @{"f"='Sukabumi, 24 September 2009'; "r"='${TTL}'},
    @{"f"='HASNA LUTFI FAUZIA'; "r"='${NAMA_LENGKAP}'},
    @{"f"='3202404911090001'; "r"='${NIK}'},
    @{"f"='Sukabumi,09-11-2009'; "r"='${TTL}'},
    @{"f"='MUHAMMAD DANI PASDAN'; "r"='${NAMA_LENGKAP}'},
    @{"f"='3202401410050001'; "r"='${NIK}'},
    @{"f"='Sukabumi, 14-10-2005'; "r"='${TTL}'},
    @{"f"='SURYANA'; "r"='${NAMA_LENGKAP}'},
    @{"f"='3202401906730003'; "r"='${NIK}'},
    @{"f"='Sukabumi, 19 Juni 1973'; "r"='${TTL}'},
    @{"f"='DADUN'; "r"='${NAMA_LENGKAP}'},
    @{"f"='3202402803730007'; "r"='${NIK}'},
    @{"f"='Cianjur, 28-03-1973'; "r"='${TTL}'},
    @{"f"='ACEP ABIDIN'; "r"='${NAMA_AYAH}'},
    @{"f"='3202401604080005'; "r"='${NO_KK}'},
    @{"f"='MOCH.DZIKRI LUTFI MUBAROK'; "r"='${NAMA_LENGKAP}'},
    @{"f"='3202401702970002'; "r"='${NIK}'},
    @{"f"='MUHAMAD DAFFA MUSYAFA'; "r"='${NAMA_LENGKAP}'},
    @{"f"='ERNA YUNITA'; "r"='${NAMA_LENGKAP}'}
)

foreach ($file in $files) {
    Write-Host "Processing $($file.Name)"
    $doc = $word.Documents.Open($file.FullName)
    
    foreach ($item in $replacements) {
        $findText = $item["f"]
        $replaceText = $item["r"]
        
        $find = $doc.Content.Find
        $find.ClearFormatting()
        $find.Replacement.ClearFormatting()
        
        # wdReplaceAll = 2
        $find.Execute($findText, $false, $false, $false, $false, $false, $true, 1, $false, $replaceText, 2) | Out-Null
    }
    
    $doc.Save()
    $doc.Close()
}

$word.Quit()
[System.Runtime.Interopservices.Marshal]::ReleaseComObject($word) | Out-Null
Write-Host "All done!"
