<x-app-layout>
    <main>

        @include('clients.partials.clientsheader')

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="customcardm card my-4">
                        <div class="customcardm card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="custom-header-card border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Clientes registrados</h6>
                                <a href="{{ route('clients.create') }}" type="button" class="float-end btn btn-ncall w-auto">Nuevo cliente</a>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="row d-flex flex-wrap justify-content-start p-4 pt-0" id="resultsContainer">
                                @include('clients.partials.clientcards', ['clients' => $clients, 'phones' => $phones])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>
