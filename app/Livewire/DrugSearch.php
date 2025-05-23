<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Drug;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DrugSearch extends Component
{
    use WithPagination;

    public $inputCodes;
    public $results = null;
    public $loading = false;

    public function search()
    {
        $this->resetPage();
        $this->loading = true;

        $codes = array_filter(array_map('trim', explode(',', $this->inputCodes)));
        $localResults = Drug::whereIn('ndc_code', $codes)->get()->keyBy('ndc_code');

        $foundCodes = $localResults->keys()->toArray();
        $missingCodes = array_diff($codes, $foundCodes);

        $apiResults = collect();

        if (!empty($missingCodes)) {
            $normalizedMap = collect($missingCodes)->mapWithKeys(function ($code) {
                $parts = explode('-', $code);
                $normalized = count($parts) >= 2 ? "{$parts[0]}-{$parts[1]}" : $code;
                return [$code => $normalized];
            });

            $query = $normalizedMap->values()->map(fn($c) => 'product_ndc:"' . $c . '"')->implode('+OR+');
            $response = Http::get("https://api.fda.gov/drug/ndc.json?search={$query}");

            if ($response->ok() && isset($response['results'])) {
                foreach ($response['results'] as $item) {
                    $originalCode = array_search($item['product_ndc'], $normalizedMap->all()) ?: $item['product_ndc'];

                    $drug = Drug::updateOrCreate(
                        ['ndc_code' => $originalCode],
                        [
                            'brand_name' => $item['brand_name'] ?? '',
                            'generic_name' => $item['generic_name'] ?? '',
                            'labeler_name' => $item['labeler_name'] ?? '',
                            'product_type' => $item['product_type'] ?? '',
                        ]
                    );

                    $apiResults->push(array_merge($drug->toArray(), [
                        'ndc_code' => $originalCode,
                        'source' => 'OpenFDA',
                    ]));
                }
            }
        }

        $allFound = collect();

        foreach ($localResults as $drug) {
            $allFound[$drug->ndc_code] = array_merge($drug->toArray(), ['source' => 'Database']);
        }

        foreach ($apiResults as $item) {
            $allFound[$item['ndc_code']] = $item;
        }

        foreach ($codes as $originalCode) {
            if (!isset($allFound[$originalCode])) {
                $allFound[$originalCode] = [
                    'ndc_code' => $originalCode,
                    'brand_name' => '-',
                    'generic_name' => '-',
                    'labeler_name' => '-',
                    'product_type' => '-',
                    'source' => 'Not Found',
                ];
            }
        }

        $this->results = $allFound->values();
        $this->loading = false;
    }

   public function delete($ndc)
{
    $parts = explode('-', $ndc);
    $normalized = count($parts) >= 2 ? "{$parts[0]}-{$parts[1]}" : $ndc;

    Drug::where('ndc_code', $ndc)
        ->orWhere('ndc_code', $normalized)
        ->delete();

    if ($this->results !== null) {
        $this->search();
    } else {
        $this->resetPage();
    }
}


    public function exportCsv(): StreamedResponse
    {
        $filename = 'search_results.csv';
        $results = $this->results;

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        return response()->stream(function () use ($results) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['NDC Code', 'Brand Name', 'Generic Name', 'Labeler Name', 'Product Type', 'Source']);

            foreach ($results as $drug) {
                fputcsv($file, [
                    $drug['ndc_code'] ?? '',
                    $drug['brand_name'] ?? '',
                    $drug['generic_name'] ?? '',
                    $drug['labeler_name'] ?? '',
                    $drug['product_type'] ?? '',
                    $drug['source'] ?? '',
                ]);
            }

            fclose($file);
        }, 200, $headers);
    }

    public function render()
    {
        return view('livewire.drug-search', [
            'paginatedDrugs' => $this->results === null
                ? Drug::latest()->paginate(5)
                : null,
        ])->layout('layouts.app');
    }
}
