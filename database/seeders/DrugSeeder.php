<?php 

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Drug;

class DrugSeeder extends Seeder
{
    public function run(): void
    {
        Drug::create([
            'ndc_code' => '12345-6789',
            'brand_name' => 'Tylenol',
            'generic_name' => 'Acetaminophen',
            'labeler_name' => 'Johnson & Johnson',
            'product_type' => 'HUMAN OTC DRUG',
        ]);

        Drug::create([
            'ndc_code' => '11111-2222',
            'brand_name' => 'Ibuprofen',
            'generic_name' => 'Ibuprofen',
            'labeler_name' => 'ABC Pharma',
            'product_type' => 'HUMAN PRESCRIPTION DRUG',
        ]);

        Drug::create([
            'ndc_code' => '54321-1234',
            'brand_name' => 'Advil',
            'generic_name' => 'Ibuprofen',
            'labeler_name' => 'Pfizer Inc.',
            'product_type' => 'HUMAN OTC DRUG',
        ]);

        Drug::create([
            'ndc_code' => '22222-3333',
            'brand_name' => 'Claritin',
            'generic_name' => 'Loratadine',
            'labeler_name' => 'Bayer HealthCare',
            'product_type' => 'HUMAN OTC DRUG',
        ]);

        Drug::create([
            'ndc_code' => '33333-4444',
            'brand_name' => 'Zyrtec',
            'generic_name' => 'Cetirizine',
            'labeler_name' => 'Johnson & Johnson',
            'product_type' => 'HUMAN OTC DRUG',
        ]);

        Drug::create([
            'ndc_code' => '44444-5555',
            'brand_name' => 'Amoxicillin',
            'generic_name' => 'Amoxicillin',
            'labeler_name' => 'Generic Labs',
            'product_type' => 'HUMAN PRESCRIPTION DRUG',
        ]);

        Drug::create([
            'ndc_code' => '55555-6666',
            'brand_name' => 'Lipitor',
            'generic_name' => 'Atorvastatin',
            'labeler_name' => 'Pfizer Inc.',
            'product_type' => 'HUMAN PRESCRIPTION DRUG',
        ]);

        Drug::create([
            'ndc_code' => '66666-7777',
            'brand_name' => 'Metformin',
            'generic_name' => 'Metformin HCL',
            'labeler_name' => 'Sun Pharma',
            'product_type' => 'HUMAN PRESCRIPTION DRUG',
        ]);

        Drug::create([
            'ndc_code' => '77777-8888',
            'brand_name' => 'Aspirin',
            'generic_name' => 'Aspirin',
            'labeler_name' => 'Bayer HealthCare',
            'product_type' => 'HUMAN OTC DRUG',
        ]);

        Drug::create([
            'ndc_code' => '88888-9999',
            'brand_name' => 'Zoloft',
            'generic_name' => 'Sertraline',
            'labeler_name' => 'Pfizer Inc.',
            'product_type' => 'HUMAN PRESCRIPTION DRUG',
        ]);
    }
}
