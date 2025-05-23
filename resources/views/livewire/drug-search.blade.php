<div class="max-w-5xl mx-auto bg-white p-6 rounded-2xl shadow-xl mt-10">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Kerkimi i Ilaçeve</h2>

    <div class="flex flex-col sm:flex-row gap-4">
        <input
            wire:model.defer="inputCodes"
            type="text"
            placeholder="Shkruaj kodet NDC me presje (p.sh. 12345-6789, 11111-2222)"
            class="flex-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
        >
        <button
            wire:click="search"
            class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2 rounded-lg transition duration-200"
        >
            Kerko
        </button>

        @if ($results && count($results) > 0)
            <button
                wire:click="exportCsv"
                class="text-blue-600 border border-blue-600 hover:bg-blue-50 px-4 py-2 rounded-lg transition text-sm"
            >
                Eksporto ne CSV
            </button>
        @endif
    </div>

    <div wire:loading class="mt-4 flex items-center gap-2 text-blue-600 font-medium">
        <svg class="w-5 h-5 animate-spin text-blue-600" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"/>
        </svg>
        Duke kerkuar...
    </div>

    @if ($results && count($results) > 0)
        <div class="overflow-x-auto mt-6 rounded-lg shadow-sm">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                <thead class="bg-gray-100 text-gray-700 text-sm font-semibold">
                    <tr>
                        <th class="px-4 py-2 text-left">KODI NDC</th>
                        <th class="px-4 py-2 text-left">EMRI</th>
                        <th class="px-4 py-2 text-left">PRODHUESI</th>
                        <th class="px-4 py-2 text-left">LLOJI</th>
                        <th class="px-4 py-2 text-left">BURIMI</th>
                        <th class="px-4 py-2 text-left">VEPRIM</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700">
                    @foreach ($results as $drug)
                        <tr class="hover:bg-gray-50 transition {{ $drug['source'] === 'Not Found' ? 'bg-red-50 text-red-600' : '' }}">
                            <td class="px-4 py-2 border-t">{{ $drug['ndc_code'] }}</td>
                            <td class="px-4 py-2 border-t">{{ $drug['brand_name'] }}</td>
                            <td class="px-4 py-2 border-t">{{ $drug['labeler_name'] }}</td>
                            <td class="px-4 py-2 border-t">{{ $drug['product_type'] }}</td>
                            <td class="px-4 py-2 border-t font-semibold">{{ $drug['source'] }}</td>
                            <td class="px-4 py-2 border-t">
                                @if ($drug['source'] !== 'Not Found')
                                    <button
                                        wire:click="delete('{{ $drug['ndc_code'] }}')"
                                        class="text-red-600 hover:underline text-sm"
                                    >Fshi</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @elseif ($paginatedDrugs && $paginatedDrugs->count())
        <div class="overflow-x-auto mt-6 rounded-lg shadow-sm">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                <thead class="bg-gray-100 text-gray-700 text-sm font-semibold">
                    <tr>
                        <th class="px-4 py-2 text-left">KODI NDC</th>
                        <th class="px-4 py-2 text-left">EMRI</th>
                        <th class="px-4 py-2 text-left">PRODHUESI</th>
                        <th class="px-4 py-2 text-left">LLOJI</th>
                        <th class="px-4 py-2 text-left">BURIMI</th>
                        <th class="px-4 py-2 text-left">VEPRIM</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700">
                    @foreach ($paginatedDrugs as $drug)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border-t">{{ $drug->ndc_code }}</td>
                            <td class="px-4 py-2 border-t">{{ $drug->brand_name }}</td>
                            <td class="px-4 py-2 border-t">{{ $drug->labeler_name }}</td>
                            <td class="px-4 py-2 border-t">{{ $drug->product_type }}</td>
                            <td class="px-4 py-2 border-t font-semibold">Database</td>
                            <td class="px-4 py-2 border-t">
                                <button wire:click="delete('{{ $drug->ndc_code }}')" class="text-red-600 hover:underline text-sm">
                                    Fshi
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $paginatedDrugs->links() }}
            </div>
        </div>
    @endif
</div>
