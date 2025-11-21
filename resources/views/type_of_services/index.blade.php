<x-layouts.app :page="'services'">
@if(session('success'))
  <x-partials.alert 
      type="success" 
      title="Berhasil!" 
      :message="session('success')" :timeout="5000" />
@endif

@if(session('error'))
  <x-partials.alert 
      type="error" 
      title="Gagal!" 
      :message="session('error')" :timeout="5000" />
@endif
   <x-partials.page-header title="Services Management" :breadcrumbs="[
       ['label' => 'Service']
   ]
   " />
    
   <div class=" py-2">
    <a
    href="{{ route('type_of_services.create') }}"
    class="inline-flex items-center gap-2 px-4 py-3 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600"
    >
    Tambah
    </a>
  </div>
   <x-table :rows="$services" :routeName="'type_of_services'" actionComponent="row-actions" with-numbering="true">
    
</x-table>

</x-layouts.app>