import zipfile
import xml.etree.ElementTree as ET

def extract_text_from_docx(docx_path):
    document_xml_content = None
    with zipfile.ZipFile(docx_path, 'r') as z:
        for filename in z.namelist():
            if filename == 'word/document.xml':
                document_xml_content = z.read(filename)
                break
    
    if not document_xml_content:
        return "Failed to read document.xml"

    root = ET.fromstring(document_xml_content)
    
    # namespaces
    ns = {'w': 'http://schemas.openxmlformats.org/wordprocessingml/2006/main'}
    
    text = []
    for paragraph in root.iter(f"{{{ns['w']}}}p"):
        para_text = []
        for run in paragraph.iter(f"{{{ns['w']}}}r"):
            for text_node in run.iter(f"{{{ns['w']}}}t"):
                if text_node.text:
                    para_text.append(text_node.text)
        if para_text:
            text.append("".join(para_text))
            
    return "\n".join(text)

with open('c:\\laragon\\www\\arsip desa v2\\desav2\\extracted_profil_python.txt', 'w', encoding='utf-8') as f:
    f.write(extract_text_from_docx('c:\\laragon\\www\\arsip desa v2\\desav2\\asset\\desa\\PROFIL DESA CARINGIN BARU PISAN 2025.docx'))
print("Extracted via python")
