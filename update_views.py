import os, re

pattern1 = re.compile(r"asset\(\s*'images/(berita|lembaga|perangkat|potensi|slider|pengaduan)/?'\s*\.\s*([^\)]+)\)")
pattern2 = re.compile(r'asset\(\s*"images/(berita|lembaga|perangkat|potensi|slider|pengaduan)/?"\s*\.\s*([^\)]+)\)')

for root, dirs, files in os.walk('resources/views'):
    for f in files:
        if f.endswith('.blade.php'):
            path = os.path.join(root, f)
            with open(path, 'r', encoding='utf-8') as file:
                content = file.read()
            
            orig = content
            content = pattern1.sub(r"Storage::disk('s3')->url('images/\g<1>/' . \g<2>)", content)
            content = pattern2.sub(r"Storage::disk('s3')->url('images/\g<1>/' . \g<2>)", content)
            
            if orig != content:
                with open(path, 'w', encoding='utf-8') as file:
                    file.write(content)
                print(f'Updated {path}')
