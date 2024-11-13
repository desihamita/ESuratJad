<x-Layouts.main.app :title="$title">
  <div class="content-header">
    <x-breadcrumb :title="$title" :breadcrumbs="$breadcrumbs" />
  </div>
  <section class="content">
    <div class="container-fluid">
      <!-- Notifikasi -->
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
              <a class="btn btn-primary" data-toggle="modal" data-target="#modal-add">
                <i class="fas fa-solid fa-plus mr-2"></i>Add
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
                  <th>Nomor</th>
                  <th>Nama</th>
                  <th>Jabatan Akademik Sebelumnya</th>
                  <th>Jabatan Akademik Diusulkan</th>
                  <th>Tanggal Proses</th>
                  <th>Tanggal Selesai</th>
                  <th>Surat Pengantar Pimpinan</th>
                  <th>Berita Acara Senat</th>
                  <th>Aksi</th>
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
                      <td>
                        <button class="btn btn-sm btn-primary edit-btn mr-2 mb-2" data-id="{{ $d->id }}" data-toggle="modal" data-target="#modal-edit">
                          <i class="fas fa-edit"></i>
                        </button>

                        <button class="btn btn-sm btn-info detail-btn" data-id="{{ $d->id }}" data-toggle="modal" data-target="#modal-detail">
                          <i class="fas fa-eye"></i>
                        </button>
                      </td>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>

          <!-- modal tambah data -->
          <div class="modal fade" id="modal-add">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Tambah Surat Dosen</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="{{ route('dosen.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                      <div class="row">
                        <!-- Kolom pertama -->
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Nama Dosen</label>
                            <input type="text" name="nama_dosen" class="form-control" placeholder="Masukkan nama dosen">
                            @error('nama_dosen')
                              <small class="text-danger">{{ $message }}</small>
                            @enderror
                          </div>
                          <div class="form-group">
                            <label>Jabatan Akademik Sebelumnya</label>
                            <input type="text" name="jabatan_akademik_sebelumnya" class="form-control" placeholder="Masukkan jabatan akademik sebelumnya">
                            @error('jabatan_akademik_sebelumnya')
                              <small class="text-danger">{{ $message }}</small>
                            @enderror
                          </div>
                          <div class="form-group">
                            <label>Jabatan Akademik Diusulkan</label>
                            <input type="text" name="jabatan_akademik_di_usulkan" class="form-control" placeholder="Masukkan jabatan akademik diusulkan">
                            @error('jabatan_akademik_di_usulkan')
                              <small class="text-danger">{{ $message }}</small>
                            @enderror
                          </div>
                          <div class="form-group">
                            <label>Tanggal Proses</label>
                            <div class="input-group date" data-target-input="nearest">
                              <input type="date" name="tanggal_proses" class="form-control "  placeholder="Masukkan Tanggal proses"/>
                            </div>
                            @error('tanggal_proses')
                              <small class="text-danger">{{ $message }}</small>
                            @enderror
                          </div>
                          <div class="form-group">
                            <label>Tanggal Selesai</label>
                            <div class="input-group date" data-target-input="nearest">
                              <input type="date" name="tanggal_selesai" class="form-control"  placeholder="Masukkan Tanggal Selesai"/>
                            </div>
                            @error('tanggal_selesai')
                              <small class="text-danger">{{ $message }}</small>
                            @enderror
                          </div>
                        </div>
                        
                        <!-- Kolom kedua -->
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="berita_acara_senat">Berita Acara Senat</label>
                            <div class="custom-file">
                                <input type="file" name="berita_acara_senat" class="custom-file-input" id="berita_acara_senat" required>
                                <label class="custom-file-label" for="berita_acara_senat">Pilih file</label>
                            </div>
                            @error('berita_acara_senat')
                              <small class="text-danger">{{ $message }}</small>
                            @enderror
                          </div>
                          <div class="form-group mt-3">
                              <label>Preview Berita Acara Senat</label>
                              <div id="pdf-viewer-senat" style="border: 1px solid #ccc; height: 300px;">
                                  <!-- PDF Berita Acara Senat akan ditampilkan di sini -->
                              </div>
                          </div>

                          <div class="form-group">
                            <label for="surat_pengantar_pimpinan_pts">Surat Pengantar Pimpinan PTS</label>
                            <div class="custom-file">
                                <input type="file" name="surat_pengantar_pimpinan_pts" class="custom-file-input" id="surat_pengantar_pimpinan_pts" required>
                                <label class="custom-file-label" for="surat_pengantar_pimpinan_pts">Pilih file</label>
                            </div>
                            @error('surat_pengantar_pimpinan_pts')
                              <small class="text-danger">{{ $message }}</small>
                            @enderror
                          </div>
                          <div class="form-group mt-3">
                              <label>Preview Surat Pengantar Pimpinan PTS</label>
                              <div id="pdf-viewer-pts" style="border: 1px solid #ccc; height: 300px;">
                                  <!-- PDF Surat Pengantar PTS akan ditampilkan di sini -->
                              </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="mr-4 ml-4">
                      <button type="submit" class="btn btn-default float-right">Cancel</button>
                      <button type="submit" class="btn btn-info" id="btnSimpan">Simpan</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          
          <!-- modal Edit data -->
          <div class="modal fade" id="modal-edit">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Edit Surat Dosen</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form id="editForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                      <div class="row">
                        <!-- Kolom pertama -->
                        <div class="col-md-6">
                          <input type="hidden" id="edit_id" name="id">
                          <div class="form-group">
                            <label>Nama Dosen</label>
                            <input type="text" name="nama_dosen" id="edit_nama_dosen" class="form-control" placeholder="Masukkan nama dosen">
                            @error('nama_dosen')
                              <small class="text-danger">{{ $message }}</small>
                            @enderror
                          </div>
                          <div class="form-group">
                            <label>Jabatan Akademik Sebelumnya</label>
                            <input type="text" name="jabatan_akademik_sebelumnya" id="edit_jabatan_akademik_sebelumnya" class="form-control" placeholder="Masukkan jabatan akademik sebelumnya">
                            @error('jabatan_akademik_sebelumnya')
                              <small class="text-danger">{{ $message }}</small>
                            @enderror
                          </div>
                          <div class="form-group">
                            <label>Jabatan Akademik Diusulkan</label>
                            <input type="text" name="jabatan_akademik_di_usulkan" id="edit_jabatan_akademik_di_usulkan" class="form-control" placeholder="Masukkan jabatan akademik diusulkan">
                            @error('jabatan_akademik_di_usulkan')
                              <small class="text-danger">{{ $message }}</small>
                            @enderror
                          </div>
                          <div class="form-group">
                            <label>Tanggal Proses</label>
                            <input type="date" name="tanggal_proses" id="edit_tanggal_proses" class="form-control" placeholder="Masukkan Tanggal Proses"/>
                            @error('tanggal_proses')
                              <small class="text-danger">{{ $message }}</small>
                            @enderror
                          </div>
                          <div class="form-group">
                            <label>Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" id="edit_tanggal_selesai" class="form-control" placeholder="Masukkan Tanggal Selesai"/>
                            @error('tanggal_selesai')
                              <small class="text-danger">{{ $message }}</small>
                            @enderror
                          </div>
                        </div>

                        <!-- Kolom kedua -->
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="exampleInputFile">Berita Acara Senat</label>
                            <div class="custom-file">
                                <input type="file" name="berita_acara_senat" class="custom-file-input" id="edit_berita_acara_senat">
                                <label class="custom-file-label" for="edit_berita_acara_senat">Choose file</label>
                            </div>
                            @error('berita_acara_senat')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                            <div id="current-berita-file-name" class="mt-2 text-muted">
                              <!-- Display the current Berita Acara file name and a link to view it -->
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="exampleInputFile">Surat Pengantar Pimpinan PTS</label>
                            <div class="custom-file">
                                <input type="file" name="surat_pengantar_pimpinan_pts" class="custom-file-input" id="edit_surat_pengantar_pimpinan_pts">
                                <label class="custom-file-label" for="edit_surat_pengantar_pimpinan_pts">Choose file</label>
                            </div>
                            @error('surat_pengantar_pimpinan_pts')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                            <div id="current-surat-file-name" class="mt-2 text-muted">
                              <!-- Display the current Surat Pengantar file name and a link to view it -->
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="mr-4 ml-4">
                      <button type="submit" class="btn btn-default float-right">Cancel</button>
                      <button type="submit" class="btn btn-info">Simpan</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <!-- modal detail data -->
          <div class="modal fade" id="modal-detail">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Detail Surat Dosen</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <td><strong>Nama Dosen</strong></td>
                      <td id="detail_nama_dosen"></td>
                    </tr>
                    <tr>
                      <td><strong>Jabatan Akademik Sebelumnya</strong></td>
                      <td id="detail_jabatan_akademik_sebelumnya"></td>
                    </tr>
                    <tr>
                      <td><strong>Jabatan Akademik Diusulkan</strong></td>
                      <td id="detail_jabatan_akademik_di_usulkan"></td>
                    </tr>
                    <tr>
                      <td><strong>Tanggal Proses</strong></td>
                      <td id="detail_tanggal_proses"></td>
                    </tr>
                    <tr>
                      <td><strong>Tanggal Selesai</strong></td>
                      <td id="detail_tanggal_selesai"></td>
                    </tr>
                    <tr>
                      <td><strong>Berita Acara Senat</strong></td>
                      <td id="detail_berita_acara_senat"></td>
                    </tr>
                    <tr>
                      <td><strong>Surat Pengantar Pimpinan</strong></td>
                      <td id="detail_surat_pengantar_pimpinan_pts"></td>
                    </tr>
                  </tbody>
                </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</x-Layouts.main.app>

<script>
  $(document).ready(function() {
    setTimeout(function() {
      $(".alert").alert('close');
    }, 1000);
  });

  $(function () {
    $('#edit_tanggal_proses').datepicker({
        format: 'yyyy-mm-dd'
    });

    $('#edit_tanggal_selesai').datepicker({
        format: 'yyyy-mm-dd'
    });
  });

  document.getElementById('berita_acara_senat').addEventListener('change', function() {
    var file = this.files[0];
    var fileName = file ? file.name : 'Pilih file';
    var label = this.nextElementSibling;
    label.innerText = fileName;

    if (file) {
        var fileURL = URL.createObjectURL(file);
        document.getElementById('pdf-viewer-senat').innerHTML = `
            <iframe src="${fileURL}" width="100%" height="100%" frameborder="0">
                This browser does not support PDFs. Please download the PDF to view it: 
                <a href="${fileURL}">Download PDF</a>.
            </iframe>
        `;
    } else {
        document.getElementById('pdf-viewer-senat').innerHTML = '';
    }
  });

  document.getElementById('surat_pengantar_pimpinan_pts').addEventListener('change', function() {
      var file = this.files[0];
      var fileName = file ? file.name : 'Pilih file';
      var label = this.nextElementSibling;
      label.innerText = fileName;

      if (file) {
          var fileURL = URL.createObjectURL(file);
          document.getElementById('pdf-viewer-pts').innerHTML = `
              <iframe src="${fileURL}" width="100%" height="100%" frameborder="0">
                  This browser does not support PDFs. Please download the PDF to view it: 
                  <a href="${fileURL}">Download PDF</a>.
              </iframe>
          `;
      } else {
          document.getElementById('pdf-viewer-pts').innerHTML = '';
      }
  });

  $(document).on('click', '.edit-btn', function () {
    var id = $(this).data('id');

    $.ajax({
      url: '/dosen/' + id + '/edit',
      method: 'GET',
      success: function (data) {
        $('#edit_id').val(data.id);
        $('#edit_nama_dosen').val(data.nama_dosen);
        $('#edit_jabatan_akademik_sebelumnya').val(data.jabatan_akademik_sebelumnya);
        $('#edit_jabatan_akademik_di_usulkan').val(data.jabatan_akademik_di_usulkan);
        $('#edit_tanggal_proses').val(data.tanggal_proses);
        $('#edit_tanggal_selesai').val(data.tanggal_selesai);

        if (data.surat_pengantar_pimpinan_pts) {
            var suratFileName = data.surat_pengantar_pimpinan_pts.split('/').pop();
            $('#edit_surat_pengantar_pimpinan_pts').next('.custom-file-label').html(suratFileName);
            $('#current-surat-file-name').html(`
              <iframe src="{{ asset('storage/') }}/${data.surat_pengantar_pimpinan_pts}" width="100%" height="400px" frameborder="0">
                <a href="{{ asset('storage/') }}/${data.surat_pengantar_pimpinan_pts}" target="_blank">${suratFileName}</a>
              </iframe>
            `);
        } else {
            $('#edit_surat_pengantar_pimpinan_pts').next('.custom-file-label').html('Pilih file');
            $('#current-surat-file-name').html('Tidak ada file yang diupload');
        }

        if (data.berita_acara_senat) {
            var beritaFileName = data.berita_acara_senat.split('/').pop();
            $('#edit_berita_acara_senat').next('.custom-file-label').html(beritaFileName);
            $('#current-berita-file-name').html(`
              <iframe src="{{ asset('storage/') }}/${data.berita_acara_senat}" width="100%" height="400px" frameborder="0">
                <a href="{{ asset('storage/') }}/${data.berita_acara_senat}" target="_blank">${beritaFileName}</a>
              </iframe>
            `);
        } else {
            $('#edit_berita_acara_senat').next('.custom-file-label').html('Pilih file');
            $('#current-berita-file-name').html('Tidak ada file yang diupload');
        }

        $('#editForm').attr('action', '/dosen/' + id);
      }
    })
  });

  $(document).ready(function() {
    $('#filter').click(function () {
      var startDate = $('#start_date').val();
      var endDate = $('#end_date').val();

      if(!startDate || !endDate) {
        alert("Harap masukkan tanggal mulai dan tanggal selesai.");
        return;
      }

      $.ajax({
        url: '/dosen/filter', 
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
                    <td>${counter}</td> <!-- Use the counter for numbering -->
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
                    <td>
                      <button class="btn btn-sm btn-primary edit-btn mr-2 mb-2" data-id="${item.id}" data-toggle="modal" data-target="#modal-edit">
                        <i class="fas fa-edit"></i>
                      </button>
                      <button class="btn btn-sm btn-info edit-btn" data-id="${item.id}" data-toggle="modal" data-target="#modal-edit">
                        <i class="fas fa-eye"></i>
                      </button>
                    </td>
                  </tr>
                ` ;
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
      
    });
  });

  $(document).on('click', '.detail-btn', function() { 
    var id = $(this).data('id');

    $.ajax({
      url: '/dosen/detail/' + id,
      method: 'GET',
      success: function(data) {
        $('#detail_nama_dosen').text(data.nama_dosen);
        $('#detail_jabatan_akademik_sebelumnya').text(data.jabatan_akademik_sebelumnya);
        $('#detail_jabatan_akademik_di_usulkan').text(data.jabatan_akademik_di_usulkan);
        $('#detail_tanggal_proses').text(data.tanggal_proses);
        $('#detail_tanggal_selesai').text(data.tanggal_selesai);

        $('#detail_berita_acara_senat').html(data.berita_acara_senat 
          ? `<a href="/storage/${data.berita_acara_senat}" target="_blank">Lihat Berita Acara Senat</a>` 
          : 'No File');

        $('#detail_surat_pengantar_pimpinan_pts').html(data.surat_pengantar_pimpinan_pts 
          ? `<a href="/storage/${data.surat_pengantar_pimpinan_pts}" target="_blank">Lihat Surat Pengantar</a>` 
          : 'No File');
      }
    });
  });
  
</script>