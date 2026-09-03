import os
import re

path = 'resources/views/pages/profil.blade.php'
with open(path, 'r', encoding='utf-8') as f:
    content = f.read()

perangkat_chart_html = """
          <div class="text-center mt-5" data-aos="fade-up">
              <button class="btn btn-outline-primary rounded-pill px-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBaganPerangkat" aria-expanded="false" aria-controls="collapseBaganPerangkat" style="border-color: var(--c-gold); color: var(--coklat-tua); font-weight: 600;">
                  <i class="bi bi-diagram-3-fill me-2"></i>Lihat Bagan Struktur
              </button>
          </div>
          <div class="collapse mt-4" id="collapseBaganPerangkat">
              <div class="card card-body border-0 shadow-sm rounded-4 bg-light overflow-auto text-center">
                  @php $strukturPerangkat = \\App\\Models\\Setting::get('struktur_perangkat'); @endphp
                  @if($strukturPerangkat)
                      <img src="{{ Storage::disk('s3')->url('images/struktur/' . $strukturPerangkat) }}" alt="Bagan Struktur Perangkat" class="img-fluid rounded shadow-sm mx-auto d-block" style="max-width: 100%;">
                      <p class="text-muted small mt-3"><i class="bi bi-zoom-in me-1"></i> Cubit (pinch) atau klik kanan untuk melihat gambar dalam ukuran penuh.</p>
                  @else
                      <div class="py-5 text-muted">
                          <i class="bi bi-image text-secondary mb-3" style="font-size: 3rem;"></i>
                          <p>Gambar bagan struktur perangkat desa belum diunggah.</p>
                      </div>
                  @endif
              </div>
          </div>
"""

lembaga_charts_html = """
          <div class="text-center mt-5" data-aos="fade-up">
              <button class="btn btn-outline-primary rounded-pill px-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBaganLembaga" aria-expanded="false" aria-controls="collapseBaganLembaga" style="border-color: var(--c-gold); color: var(--coklat-tua); font-weight: 600;">
                  <i class="bi bi-diagram-3-fill me-2"></i>Lihat Bagan Struktur Lembaga
              </button>
          </div>
          <div class="collapse mt-4" id="collapseBaganLembaga">
              <div class="card card-body border-0 shadow-sm rounded-4 bg-white overflow-auto text-center">
                  <div class="row g-5">
                      <div class="col-12">
                          <h5 class="font-serif text-coklat-tua text-center mb-3">Bagan BPD</h5>
                          @php $strukturBpd = \\App\\Models\\Setting::get('struktur_bpd'); @endphp
                          @if($strukturBpd)
                              <img src="{{ Storage::disk('s3')->url('images/struktur/' . $strukturBpd) }}" alt="Bagan BPD" class="img-fluid rounded shadow-sm mx-auto d-block" style="max-width: 100%;">
                          @else
                              <div class="py-4 border border-dashed rounded bg-light text-muted">
                                  <p class="mb-0">Gambar bagan struktur BPD belum diunggah.</p>
                              </div>
                          @endif
                      </div>
                      
                      <div class="col-12 mt-5">
                          <h5 class="font-serif text-coklat-tua text-center mb-3">Bagan Tim Penggerak PKK</h5>
                          @php $strukturPkk = \\App\\Models\\Setting::get('struktur_pkk'); @endphp
                          @if($strukturPkk)
                              <img src="{{ Storage::disk('s3')->url('images/struktur/' . $strukturPkk) }}" alt="Bagan PKK" class="img-fluid rounded shadow-sm mx-auto d-block" style="max-width: 100%;">
                          @else
                              <div class="py-4 border border-dashed rounded bg-light text-muted">
                                  <p class="mb-0">Gambar bagan struktur PKK belum diunggah.</p>
                              </div>
                          @endif
                      </div>
                  </div>
              </div>
          </div>
"""

# Helper function to avoid escape character issues in re.sub replacement strings
def repl_perangkat(match): return perangkat_chart_html
def repl_lembaga(match): return lembaga_charts_html

content = re.sub(
    r'<div class="text-center mt-5"[^>]*>[\s\S]*?id="collapseBaganPerangkat"[^>]*>[\s\S]*?id="chart_perangkat"[^>]*></div>\s*</div>\s*</div>',
    repl_perangkat,
    content
)

content = re.sub(
    r'<div class="text-center mt-5"[^>]*>[\s\S]*?id="collapseBaganLembaga"[^>]*>[\s\S]*?id="chart_bpd"[^>]*></div>[\s\S]*?id="chart_pkk"[^>]*></div>\s*</div>\s*</div>\s*</div>\s*</div>',
    repl_lembaga,
    content
)

content = re.sub(r'<!-- GOOGLE ORG CHART JS -->[\s\S]*?</script>', '', content)
content = re.sub(r'/\* Styling khusus untuk Google Org Chart Node \*/[\s\S]*?}\n\s*\.org-card {', '.org-card {', content)
content = re.sub(r'@media \(max-width: 768px\) \{\s*\.google-visualization-orgchart-table \{[\s\S]*?\}\s*\}\s*', '', content)
content = re.sub(r'<p class="text-muted small text-center d-md-none mb-3"><i class="bi bi-arrows-expand me-1"></i> Geser ke kiri/kanan untuk melihat struktur penuh</p>', '', content)
content = re.sub(r'<h5 class="font-serif text-coklat-tua text-center mb-3">Bagan Tim Penggerak PKK</h5>\s*<h5 class="font-serif text-coklat-tua text-center mb-3">Bagan Tim Penggerak PKK</h5>', '<h5 class="font-serif text-coklat-tua text-center mb-3">Bagan Tim Penggerak PKK</h5>', content)

with open(path, 'w', encoding='utf-8') as f:
    f.write(content)
print("Updated profil.blade.php successfully")
