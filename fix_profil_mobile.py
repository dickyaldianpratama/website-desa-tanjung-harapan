import os

path = 'resources/views/pages/profil.blade.php'
with open(path, 'r', encoding='utf-8') as f:
    content = f.read()

mobile_css = """
    @media (max-width: 768px) {
        .google-visualization-orgchart-table {
            transform: scale(0.85);
            transform-origin: top center;
        }
    }
"""
if 'transform: scale(0.85);' not in content:
    content = content.replace('/* Styling khusus untuk Google Org Chart Node */', mobile_css + '\n    /* Styling khusus untuk Google Org Chart Node */')

with open(path, 'w', encoding='utf-8') as f:
    f.write(content)
print("Added mobile scaling to profil.blade.php")
