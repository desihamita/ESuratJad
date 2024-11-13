<x-Layouts.main.app :title="$title">
  <div class="content-header">
    <x-breadcrumb :title="$title" :breadcrumbs="$breadcrumbs" />
  </div>
  <section class="content">
    <div class="container-fluid">
      <div class="row mr-3 ml-3">
        <div class="col-md-12">
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <img class="profile-user-img img-fluid img-circle"
                    src="{{ Auth::user()->profile_picture ? asset('storage/profile_pictures/' . Auth::user()->profile_picture) : asset('assets/dist/img/default.png') }}"
                    alt="User profile picture">
              </div>

              <h1 class="profile-username text-center mt-3 mb-4">{{ Auth::user()->name }}</h1>
              <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                  <form class="form-horizontal mt-3" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                      <label for="inputName" class="col-sm-2 col-form-label">Nama</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputName" name="name" value="{{ Auth::user()->name }}" placeholder="Name">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                      <div class="col-sm-10">
                        <input type="email" class="form-control" id="inputEmail" name="email" value="{{ Auth::user()->email }}" placeholder="Email">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputPassword" class="col-sm-2 col-form-label">Ganti Password</label>
                      <div class="col-sm-10">
                        <input type="password" class="form-control" id="inputPassword" name="password" placeholder="New Password">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="profile_picture" class="col-sm-2 col-form-label">Photo Profil</label>
                      <div class="col-sm-10">
                        <input type="file" class="form-control" id="profile_picture" name="profile_picture">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Submit</button>
                      </div>
                    </div>
                  </form>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</x-Layouts.main.app>
