<x-app-component>
    <x-page.page-title data="Access Denied" />
    <x-slot name="content">
        <h4 class="fw-bold py-3 mb-2">Oops 😖 </h4>
        <div class="card">
            <div class="card-body text-center">
                <h2 class="mb-2">You are not authorized!</h2>
                <p class="mb-4">You do not have permission to view this page using the credentials that you
                    have provided while login. <br> Please contact your site administrator.</p>
                <a href="{{ route('dashboard') }}" class="publish-post">Back to home</a>
            </div>
        </div>
    </x-slot>
</x-app-component>
