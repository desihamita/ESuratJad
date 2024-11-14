<x-Layouts.main.app :title="$title">
  <div class="content-header">
    <x-breadcrumb :title="$title" :breadcrumbs="$breadcrumbs" />
  </div>
  <section class="content">
    <div class="container-fluid">
      @if(session('success'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @endif

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header m-2">
              <a href="{{ route('laporan.export-excel') }}" class="btn btn-success" id="export-excel">
                <i class="fas fa-file-excel mr-2"></i>Export Excel
              </a>
              <a href="{{ route('laporan.export-pdf') }}" class="btn btn-primary" id="export-pdf">
                <i class="fas fa-file-pdf mr-2"></i>Export PDF
              </a>
              <div class="card-tools">
                <div class="d-flex align-items-center">
                  <input type="date" id="start_date" class="form-control mr-2" placeholder="Tanggal Mulai" />
                  <input type="date" id="end_date" class="form-control mr-2" placeholder="Tanggal Selesai" />
                  <button id="filter" class="btn btn-primary">
                    <i class="fas fa-sync-alt rotate-icon"></i>
                  </button>
                </div>
              </div>
            </div>
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jabatan Akademik Sebelumnya</th>
                    <th>Jabatan Akademik Diusulkan</th>
                    <th>Tanggal Proses</th>
                    <th>Tanggal Selesai</th>
                    <th>Surat Pengantar Pimpinan</th>
                    <th>Berita Acara Senat</th>
                  </tr>
                </thead>
                <tbody id="data-container">
                  @foreach ($data as $d)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $d->nama_dosen }}</td>
                      <td>{{ $d->jabatan_akademik_sebelumnya }}</td>
                      <td>{{ $d->jabatan_akademik_di_usulkan }}</td>
                      <td>{{ $d->tanggal_proses }}</td>
                      <td>{{ $d->tanggal_selesai }}</td>
                      <td>
                        @if ($d->surat_pengantar_pimpinan_pts)
                          <a href="{{ asset('storage/' . $d->surat_pengantar_pimpinan_pts) }}" target="_blank">Lihat Surat Pengantar</a>
                        @else
                          <span>No File</span>
                        @endif
                      </td>
                      <td>
                        @if ($d->berita_acara_senat)
                          <a href="{{ asset('storage/' . $d->berita_acara_senat) }}" target="_blank">Lihat Berita Acara</a>
                        @else
                          <span>No File</span>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</x-Layouts.main.app>
<script>
$(document).ready(function() {
  $('#filter').click(function () {
    var startDate = $('#start_date').val();
    var endDate = $('#end_date').val();

    if (!startDate || !endDate) {
      alert("Harap masukkan tanggal mulai dan tanggal selesai.");
      return;
    }

    $.ajax({
      url: '/laporan/filter', 
      data: {
        start_date: startDate,
        end_date: endDate
      },
      success: function(response) {
        var html = '';
        var counter = 1; 
        
        if (response.data.length === 0) {
          html = `
            <tr>
              <td colspan="9" class="text-center">No matching records found</td>
            </tr>
          `;
        } else {
          response.data.forEach(function(item) {
              html += `
                <tr>
                  <td>${counter}</td>
                  <td>${item.nama_dosen}</td>
                  <td>${item.jabatan_akademik_sebelumnya}</td>
                  <td>${item.jabatan_akademik_di_usulkan}</td>
                  <td>${item.tanggal_proses}</td>
                  <td>${item.tanggal_selesai}</td>
                  <td>
                    ${item.surat_pengantar_pimpinan_pts ? `<a href="/storage/${item.surat_pengantar_pimpinan_pts}" target="_blank">Lihat Surat Pengantar</a>` : 'No File'}
                  </td>
                  <td>
                    ${item.berita_acara_senat ? `<a href="/storage/${item.berita_acara_senat}" target="_blank">Lihat Berita Acara Senat</a>` : 'No File'}
                  </td>
                </tr>
              `;
              counter++;
          });
        }

        $('#data-container').html(html);
      },
      error: function(xhr, status, error) {
        console.error(error);
        alert("Terjadi kesalahan saat mengambil data.");
      }
    });

    // Update PDF export link
    $('#export-pdf').attr('href', `/laporan/export-pdf?start_date=${startDate}&end_date=${endDate}`);
    $('#export-excel').attr('href', `/laporan/export-excel?start_date=${startDate}&end_date=${endDate}`);
  });
});
</script>