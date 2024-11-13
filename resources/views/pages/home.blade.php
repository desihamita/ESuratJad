<x-Layouts.main.app :title="$title">
    <div class="content-header">
        <x-breadcrumb :title="$title" :breadcrumbs="$breadcrumbs" />
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-10">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h1 class="text-primary">{{ $greeting }}, {{ Auth::user()->name }}!</h1>
                                <h5>{{ $today }}</h5>
                                <p><small>Laporan hari ini</small></p>
                            </div>
                            <div>
                                <img src="{{ asset('assets/dist/img/freepik.png') }}" alt="Admin Image" style="width: 250px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </section>
</x-Layouts.main.app>
