import os

path = 'app/Http/Controllers/Admin/SettingController.php'
with open(path, 'r', encoding='utf-8') as f:
    content = f.read()

# Strip any whitespace/newlines or BOM before <?php
start_idx = content.find('<?php')
if start_idx != -1:
    content = content[start_idx:]

with open(path, 'w', encoding='utf-8', newline='\n') as f:
    f.write(content)

print("Cleaned SettingController.php")
