<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChartCategory;

class ChartCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createMultipleRole = [ 
           ["name"=> "ARCHIVE", "uid"=> "ce3d27d8-6de5-4e45-8d29-b26b4b27cc75"],
           ["name"=> "Background", "uid"=> "867d3509-b1be-4f18-a26c-5c96dde1bf0d"],
           ["name"=> "Certificates", "uid"=> "20f1291d-3545-474f-be75-3057afcb8a17" ],
           ["name"=> "Cliniqon test category", "uid"=> "97d72e66-4fdd-4d7a-adf7-9d574f4db418"],
           ["name"=> "Competencies", "uid"=> "1390d3ed-1d02-415e-bcf2-8308f887fa7b"],
           ["name"=> "Compliance certification", "uid"=> "509e2b99-7b1e-49f0-b58b-7d434938c50e"],
           ["name"=> "Disclosures", "uid"=> "a1217fc6-cd19-4f3c-ad73-5f2dd147dafe"],
           ["name"=> "Financial", "uid"=> "6c417b26-f3c8-4612-8e8b-aa8eaf0c16f1"],
           ["name"=> "General HR", "uid"=> "c2db11d2-f234-47a4-93d6-a4e2546c5b2d"],
           ["name"=> "Government Documents", "uid"=> "0e79b4f1-50e6-4077-a845-d921f6131e18"],
           ["name"=> "Health (Confidential Info)", "uid"=> "a933835a-5d1b-4ad2-827c-7b6c7d184985"],
           ["name"=> "Identification", "uid"=> "46caaacd-5807-48f3-8d65-bfcdacac2ede"],
           ["name"=> "In-Services", "uid"=> "c5a8ff5a-f6b9-422e-bb0e-e7789f4fdc1a"],
           ["name"=> "Insurances", "uid"=> "1ef33eee-fec9-4cea-b73c-9900258bea43"],
           ["name"=> "Licenses", "uid"=> "8f518f9c-30c9-421c-9a42-6a8a3c7b727f"],
           ["name"=> "Licenses/Certifications/Continue Education", "uid"=> "008bb9b5-2ec6-4e63-bfe5-27232163c2bd"],
           ["name"=> "Miscellaneous", "uid"=> "f3a960d3-5cde-4f2d-9d55-151021e281a6"],
           ["name"=> "PT License", "uid"=> "0a49c4ba-36a5-4244-a4a5-f23dffaee46f"],
           ["name"=> "Section One", "uid"=> "176fc010-9ac5-4b30-b764-1e9ac7e10bed"],
           ["name"=> "Yearly Performance Evaluation Non-Clinical", "uid"=> "1f7f77ab-536a-49d0-857e-7ad66a0daa11"]
        ];
        
        foreach ($createMultipleRole as $data) {
            $schema = new ChartCategory();
            $schema->name = $data['name']; 
            $schema->uid = $data['uid']; 
            $schema->status = 1;
            $schema->save();
        }
    }
}
