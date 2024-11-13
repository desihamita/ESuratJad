  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                <div class="dropdown-divider"></div>
                <a href="/profile" class="dropdown-item">
                    <i class="fas fa-user mr-2"></i> Profile
                </a>
                <div class="dropdown-divider"></div>
                <a onclick="confirmLogout()" class="dropdown-item text-danger">
                    <i class=" fa-solid fa-right-from-bracket mr-2"></i>Log Out</a>
            </div>
        </li>
    </ul>
</nav>
<script>
    function confirmLogout() {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, log out!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('logout') }}";
            }
        });
    }

    // Check for a session message
    @if($message = Session::get('failed'))
        Swal.fire({
            title: "Error!",
            text: '{{ $message }}',
            icon: "error"
        });
    @endif
</script>
