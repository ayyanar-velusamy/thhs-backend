<?php

namespace Database\Seeders;

use App\Models\Position;
use App\Models\User;
use App\Models\UserAddresses;
use App\Models\UserEmailAdresses;
use App\Models\UserPhoneNumbers;


use DB;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (env('DB_MIGRATION', 0) == 1) {
            $this->add_admin();
            $this->staff_table_migration();
            $this->address_table_migration();
            $this->email_table_migration();
            $this->phone_table_migration();

        } else {
            $user = new User();
            $user->firstname = "Admin";
            $user->lastname = "";
            $user->language_id = 1;
            $user->name = "Adminstrator";
            $user->email = "admin@gmail.com";
            $user->password = bcrypt('Admin@123');
            $user->position = 1;
            $user->is_admin = 1;
            $user->status = 1;
            $user->staff_status = 1;
            $user->save();
        }

        // SELECT * FROM `staff` LEFT JOIN staffstatus ON staffstatus.StaffId = staff.StaffId LEFT JOIN person ON person.PersonId = staff.StaffId LEFT JOIN staffrole ON staffrole.StaffRoleId = staff.StaffRoleId LEFT JOIN personaddress ON personaddress.PersonId = person.PersonId LEFT JOIN personphone ON personphone.PersonId = person.PersonId WHERE staff.OrganizationId = 64822 AND personphone.PhoneNumber != '' GROUP BY staff.StaffId;
    }

    public function add_admin()
    {
        /*Admin Data */
        $user = new User();
        $user->firstname = "Admin";
        $user->lastname = "";
        $user->language_id = 1;
        $user->name = "Adminstrator";
        $user->email = "admin@gmail.com";
        $user->password = bcrypt('Admin@123');
        $user->position = 1;
        $user->is_admin = 1;
        $user->status = 1;
        $user->staff_status = 1;
        $user->save();
        /*Admin Data */
    }

    public function staff_table_migration()
    {
        $old_record = DB::connection('mysql_old')->table('staff')
            ->leftJoin('staffstatus', 'staffstatus.StaffId', '=', 'staff.StaffId')
            ->leftJoin('person', 'person.PersonId', '=', 'staff.StaffId')
            ->leftJoin('staffrole', 'staffrole.StaffRoleId', '=', 'staff.StaffRoleId')
            ->leftJoin('personaddress', 'personaddress.PersonId', '=', 'person.PersonId')
            ->leftJoin('personphone', 'personphone.PersonId', '=', 'person.PersonId')
            ->where('staffstatus.StatusId', '0b1c0351-0773-460a-8b83-28d4586c8641')
            ->where('staff.OrganizationId', 64822)
            ->where('personphone.PhoneNumber', '!=', '')
        // ->where('staff.StaffId', 2716)
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

        foreach ($users as $data) {
            $gender = 3;
            if ($data->Gender == "Female") {
                $gender = 2;
            } elseif ($data->Gender == "Male") {
                $gender = 1;
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
                $user->cellular = $data->PhoneNumber;
                $user->zip = $data->ZIP;
                $user->gender = $gender;
                $user->language_id = 1;
                $user->employment_type = 2;
                $user->old_id = $data->StaffId;
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
}
