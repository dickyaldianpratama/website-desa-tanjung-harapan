import os

path = 'resources/views/pages/profil.blade.php'
with open(path, 'r', encoding='utf-8') as f:
    content = f.read()

# Fix 1: Add Swiper padding
if '.swiper {' not in content:
    css_fix = """
    /* Fix Swiper Dots Overlap */
    .swiper {
        padding-bottom: 50px !important;
    }
    .swiper-pagination {
        bottom: 0 !important;
    }
    """
    content = content.replace('/* Styling khusus untuk Google Org Chart Node */', css_fix + '\n    /* Styling khusus untuk Google Org Chart Node */')

# Fix 2: Add hint for mobile scrolling on bagan
hint_html = '<p class="text-muted small text-center d-md-none mb-3"><i class="bi bi-arrows-expand me-1"></i> Geser ke kiri/kanan untuk melihat struktur penuh</p>'
if 'Geser ke kiri/kanan' not in content:
    content = content.replace('<div id="chart_perangkat"', hint_html + '\n                  <div id="chart_perangkat"')
    content = content.replace('<h5 class="font-serif text-coklat-tua text-center mb-3">Bagan BPD</h5>', '<h5 class="font-serif text-coklat-tua text-center mb-3">Bagan BPD</h5>\n                          ' + hint_html)
    content = content.replace('<h5 class="font-serif text-coklat-tua text-center mb-3">Bagan Tim Penggerak PKK</h5>', '<h5 class="font-serif text-coklat-tua text-center mb-3">Bagan Tim Penggerak PKK</h5>\n                          ' + hint_html)

with open(path, 'w', encoding='utf-8') as f:
    f.write(content)
print("Fixed profil.blade.php")
