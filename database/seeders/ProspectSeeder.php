<?php

namespace Database\Seeders;

use App\Models\Position;
use App\Models\User;
use App\Models\UserAddresses;
use App\Models\UserEmailAdresses;
use App\Models\UserPhoneNumbers;
use App\Models\UserEducation;
use App\Models\ProfessionalReferences;
use App\Models\WorkHistory;
use App\Models\EmergencyContacts;





use DB;
use Illuminate\Database\Seeder;

class ProspectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (env('DB_MIGRATION', 0) == 1) { 
            
            $this->prospect_table_migration();
            $this->address_table_migration();
            $this->email_table_migration();
            $this->phone_table_migration();
            $this->education_table_migration();
            $this->professional_table_migration(); 
            $this->work_history_table_migration(); 
            $this->emergency_contact_table_migration(); 

        } 

        // SELECT * FROM `staff` LEFT JOIN staffstatus ON staffstatus.StaffId = staff.StaffId LEFT JOIN person ON person.PersonId = staff.StaffId LEFT JOIN staffrole ON staffrole.StaffRoleId = staff.StaffRoleId LEFT JOIN personaddress ON personaddress.PersonId = person.PersonId LEFT JOIN personphone ON personphone.PersonId = person.PersonId WHERE staff.OrganizationId = 64822 AND personphone.PhoneNumber != '' GROUP BY staff.StaffId;
    }  
 
    public function prospect_table_migration()
    {
        $old_record = DB::connection('mysql_old')->table('staff')
            ->leftJoin('staffstatus', 'staffstatus.StaffId', '=', 'staff.StaffId')
            ->leftJoin('person', 'person.PersonId', '=', 'staff.StaffId')
            ->leftJoin('staffrole', 'staffrole.StaffRoleId', '=', 'staff.StaffRoleId')
            ->leftJoin('personaddress', 'personaddress.PersonId', '=', 'person.PersonId')
            ->leftJoin('personphone', 'personphone.PersonId', '=', 'person.PersonId')
            ->whereIn('staffstatus.StatusId', ['a651e513-11c8-4524-a8f6-42cf6544cb9d', '9419221f-9989-476a-940e-9310bb8b3258', '1d657b46-9db2-43eb-be37-46d2a2a4bcc4', "ba6122cd-b34f-4573-9ebf-b8a02abe53d0"])
            ->where('staff.OrganizationId', 64822)
            // ->where('personphone.PhoneNumber', '!=', '')
        // ->where('staff.StaffId', 2563)
        // ->groupBy('staff_id')
            ->get();
        
        $_tmp = array();
        foreach ($old_record as $key => $value) {
            if (!array_key_exists($value->Username, $_tmp)) {
                $_tmp[$value->Username] = $value;
            }
        }
        $users = array_values($_tmp);
        // print_r($users);
        // print_r(count($users));
        // exit;

        foreach ($users as $data) {
            $gender = 3;
            if ($data->Gender == "Female") {
                $gender = 2;
            } elseif ($data->Gender == "Male") {
                $gender = 1;
            }
            $prospect_status = 3;
            if (strtolower($data->StatusId) == "9419221f-9989-476a-940e-9310bb8b3258") {
                $prospect_status = 9;
            } elseif (strtolower($data->StatusId) == "1d657b46-9db2-43eb-be37-46d2a2a4bcc4") {
                $prospect_status = 12;
            } elseif (strtolower($data->StatusId) == "ba6122cd-b34f-4573-9ebf-b8a02abe53d0") {
                $prospect_status = 13;
            }
            
            $position_id = Position::where("old_id", $data->StaffRoleId)->first()->id;
            $user = new User();
            if ($data->Username != "admin@gmail.com") {
                $user->email = $data->Username;
                $user->firstname = $data->FirstName;
                $user->middlename = $data->MiddleName;
                $user->lastname = $data->LastName;
                $user->birth_date = update_date_format($data->BirthDate, "Y-m-d");
                $user->name = $data->LastName . " " . $data->MiddleName . " " . $data->FirstName;
                $user->position = $position_id;
                $user->staff_status = 1;
                $user->role = 2;
                $user->ssn = $data->SSN;
                $user->address = $data->Address . " - " . $data->Country;
                $user->state = $data->State;
                $user->city = $data->City;
                $user->cellular = remove_mask($data->PhoneNumber);
                $user->zip = $data->ZIP;
                $user->gender = $gender;
                $user->language_id = 1;
                $user->employment_type = 2;
                $user->old_id = $data->StaffId;
                $user->status = 1;  
                $user->user_type = 2; 
                $user->prospect_status = $prospect_status; 
                $user->save();
            }
        }
    }
    public function address_table_migration()
    {
        $old_record = DB::connection('mysql_old')->table('personaddress')->get();

        foreach ($old_record as $data) {
            $match_user = User::where("old_id", $data->PersonId)->first();
            if ($match_user) {
                $address = new UserAddresses;
                $address->user_id = $match_user['id'];
                $address->address_type = 1;
                $address->address = $data->Address;
                $address->country = $data->Country;
                $address->state = $data->State;
                $address->city = $data->City;
                $address->zip = $data->ZIP;
                $address->is_default = $data->IsDefault;
                $address->save();
            }
        }
    }

    public function email_table_migration()
    {
        $old_record = DB::connection('mysql_old')->table('personemail')->get();
        foreach ($old_record as $data) {
            $match_user = User::where("old_id", $data->PersonId)->first();
            if ($match_user) {
                $email = new UserEmailAdresses;
                $email->user_id = $match_user['id'];
                $email->email_type = 1;
                $email->email = $data->Email;
                $email->is_default = $data->IsDefault;
                $email->save();
            }
        }
    }
    public function phone_table_migration()
    {
        $old_record = DB::connection('mysql_old')->table('personphone')->get();
        foreach ($old_record as $data) {
            $match_user = User::where("old_id", $data->PersonId)->first();
            if ($match_user && $data->PhoneNumber) {
                $phone = new UserPhoneNumbers;  
                $phone->user_id = $match_user['id'];
                $phone->phone_type = 1;
                $phone->extension = $data->PhoneExt;
                $phone->phone_number =remove_mask($data->PhoneNumber);
                $phone->is_default = $data->IsDefault;
                $phone->save();
            }
        }
    }
    public function education_table_migration()
    { 
        $old_record = DB::connection('mysql_old')->table('staffeducation')->get();
        $education_types = get_education_type_list();
        $degrees = get_education_degree_list();  
        foreach ($old_record as $data) {
            $match_user = User::where("old_id", $data->StaffId)->first(); 
            if ($match_user && $data->Name) {
                $edu_type = $this->search_exit($education_types, "uid", strtolower($data->EducationTypeId));
                $degree = $this->search_exit($degrees, "uid", strtolower($data->EducationDegreeId)); 
                $completion_date = "1970-01-01";
                if($data->DateCompleted){
                    $completion_date = update_date_format($data->DateCompleted,"Y-m-d");
                }
                $edu = new UserEducation;  
                $edu->user_id = $match_user['id'];
                $edu->type_id = $edu_type['id'];
                $edu->name = $data->Name;
                $edu->date_completed = $completion_date;
                $edu->degree_id = $degree['id'];
                $edu->save();
            }
        }
    }
    
    public function professional_table_migration()
    { 
        $old_record = DB::connection('mysql_old')->table('staffpersonalreference')->get();
        $relationships = get_professional_relationships_list(); 
        foreach ($old_record as $data) {
            $match_user = User::where("old_id", $data->StaffId)->first(); 
         
          
            if ($match_user && $data->Name) {
                $relation = $this->search_exit($relationships, "uid", strtolower($data->RelationshipId));  
                $references = new ProfessionalReferences; 
                $references->user_id = $match_user['id'];
                $references->relationship_id = $relation['id'];
                $references->name = $data->Name;
                $references->email = $data->Email;
                $references->phone = remove_mask($data->Phone);
                $references->save(); 
            }
        }
    }

    public function work_history_table_migration()
    { 
        $old_record = DB::connection('mysql_old')->table('staffemploymenthistory')->get(); 
        foreach ($old_record as $data) {
            $match_user = User::where("old_id", $data->StaffId)->first();   
            if ($match_user && $data->Employer) { 
                $work_history = new WorkHistory; 
                $work_history->user_id = $match_user['id'];
                $work_history->employer_name = $data->Employer;
                $work_history->position =  $data->JobTitle;
                $work_history->supervisor_name = $data->ContactName;
                $work_history->employer_email = $data->Email;
                $work_history->employer_fax = $data->Fax;
                $work_history->employer_phone =  remove_mask($data->Phone);
                $work_history->save();
            }
        }
    }

    public function emergency_contact_table_migration()
    { 
        $old_record = DB::connection('mysql_old')->table('staffemergencycontacts')->get();
        $relationships = get_emergency_contact_list(); 
        foreach ($old_record as $data) {
            $match_user = User::where("old_id", $data->StaffId)->first(); 
         
          
            if ($match_user && $data->Name) {
                $relation = $this->search_exit($relationships, "uid", strtolower($data->RelationshipId));  
                $emergency_contact = new EmergencyContacts;
                $emergency_contact->user_id = $match_user['id'];
                $emergency_contact->relationship_id = $relation['id'];
                $emergency_contact->relationship_name = $data->Name;
                $emergency_contact->relationship_address = $data->Address;
                $emergency_contact->relationship_phone = remove_mask($data->Phone);
                $emergency_contact->relationship_email = $data->Email;
                $emergency_contact->relationship_notes = $data->Notes;
                $emergency_contact->save(); 
            }
        }
    }
    

    

    public function search_exit($exif, $field, $value){
        foreach ($exif as $data)
        { 
            if ($data[$field] == $value){
                return $data;
            }
               
        }
        return 0;
    }

}
