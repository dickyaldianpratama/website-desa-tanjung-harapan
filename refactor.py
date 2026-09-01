import os, re

pattern_move = re.compile(r'\$(\w+)->move\(public_path\(\'([^\']+)\'\), \$(\w+)\);')
pattern_file_exists = re.compile(r'File::exists\(public_path\(\'([^\']+)/\' \. \$([a-zA-Z0-9_]+)->([a-zA-Z0-9_]+)\)\)')
pattern_file_delete = re.compile(r'File::delete\(public_path\(\'([^\']+)/\' \. \$([a-zA-Z0-9_]+)->([a-zA-Z0-9_]+)\)\)')

for root, dirs, files in os.walk('app/Http/Controllers'):
    for f in files:
        if f.endswith('.php'):
            path = os.path.join(root, f)
            with open(path, 'r', encoding='utf-8') as file:
                content = file.read()
            
            orig = content
            if 'use Illuminate\Support\Facades\File;' in content and 'use Illuminate\Support\Facades\Storage;' not in content:
                content = content.replace('use Illuminate\Support\Facades\File;', 'use Illuminate\Support\Facades\File;\nuse Illuminate\Support\Facades\Storage;')
            elif 'use Illuminate\Support\Facades\Storage;' not in content and ('Storage::disk' in content or pattern_move.search(content)):
                content = content.replace('namespace App\Http\Controllers\Admin;\n', 'namespace App\Http\Controllers\Admin;\n\nuse Illuminate\Support\Facades\Storage;\n')
            
            content = pattern_move.sub(r"Storage::disk('s3')->putFileAs('\g<2>', $\g<1>, $\g<3>);", content)
            content = pattern_file_exists.sub(r"Storage::disk('s3')->exists('\g<1>/' . $\g<2>->\g<3>)", content)
            content = pattern_file_delete.sub(r"Storage::disk('s3')->delete('\g<1>/' . $\g<2>->\g<3>)", content)
            
            if orig != content:
                with open(path, 'w', encoding='utf-8') as file:
                    file.write(content)
                print(f'Updated {path}')
