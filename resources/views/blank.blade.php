<x-app-component>
    <x-page.page-title data="Page title" />
    <x-slot name="style"></x-slot>
    <x-slot name="content">
        <h4 class="fw-bold py-3 mb-2">Title</h4>
        <div class="card">
            <div class="card-body table-responsive">
               <!-- Content -->
            </div>
        </div>
    </x-slot>
    <x-slot name="script"></x-slot>
</x-app-component>
