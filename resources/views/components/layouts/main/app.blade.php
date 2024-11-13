
<x-layouts.partials.header :title="$title"/>
<x-layouts.partials.navbar />
<x-layouts.partials.sidebar />     
<div class="content-wrapper">
    {{ $slot }} <!-- Isi konten di sini -->
</div>
<x-layouts.partials.footer />
