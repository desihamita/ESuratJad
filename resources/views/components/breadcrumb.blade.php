<div class="container-fluid">
    @props(['title', 'breadcrumbs'])
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ $title ?? 'Dashboard' }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                @if (isset($breadcrumbs))
                    @foreach ($breadcrumbs as $bc)
                        @if (!$loop->last)
                            <li class="breadcrumb-item"><a href="{{ $bc['url'] }}">{{ $bc['name'] }}</a></li>
                        @else
                            <li class="breadcrumb-item active">{{ $bc['name'] }}</li>
                        @endif
                    @endforeach
                @endif
            </ol>
        </div>
    </div>
</div>
