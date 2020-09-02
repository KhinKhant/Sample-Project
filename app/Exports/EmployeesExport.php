<?php

namespace App\Exports;

use App\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Facades\DB;

/**
  * Description: store, __construct, collection, headings, title, afterSheet
  * @author Khin Yadanar Khant
  * @date 26/08/2020
  */
class EmployeesExport implements FromCollection,WithHeadings,WithTitle,WithEvents
{

    /**
    * @return \Illuminate\Support\Collection
    */

  	protected $data;
    public function __construct($data)
 	{
        $this->data = $data;
        //dd($this->data);
	}

    /**
     * To download excel
     * @author Khin Yadanar Khant
     * @date 28/08/2020
     */
    public function collection() 
    {
        /*
            original code (not include postion_name, department_name)
            $data=Employee::withTrashed()->where($this->data)->get();
            return $data;*/
       
       /* 
        only export department_id and position_id
        $data = DB::table('employees')
            ->join('emp__dep__positions', 'employees.id', '=', 'emp__dep__positions.employee_id')
            ->select('employees.*', 'emp__dep__positions.department_id', 'emp__dep__positions.position_id')
            ->get();
         return $data;
         */

          /* $data = DB::table('employees')
            ->join('emp__dep__positions', 'employees.id', '=', 'emp__dep__positions.employee_id')
            ->join('departments', 'departments.id', '=', 'emp__dep__positions.department_id')
            ->join('positions', 'positions.id', '=', 'emp__dep__positions.position_id')
            ->select('employees.*', 'departments.department_name', 'positions.position_name')
            ->get();
         return $data;
         */


         $sql = DB::table('employees')
            ->join('emp__dep__positions', 'employees.id', '=', 'emp__dep__positions.employee_id')
            ->join('departments', 'departments.id', '=', 'emp__dep__positions.department_id')
            ->join('positions', 'positions.id', '=', 'emp__dep__positions.position_id')
            ->where($this->data)
            ->select('employees.*', 'departments.department_name', 'positions.position_name')
            ->get();
         return $sql;

    }

     /**
     * To add excel heading
     * @author Khin Yadanar Khant
     * @date 28/08/2020
     */
    public function headings(): array 
    {
        return [

            'ID',

            'Name',

            'Email',

            'Date of Birth',

            'Password',

            'Gender',

            'Deleted_at',

            'Updated_at',

            'Created_at',
        ];

    }

    /**
     * To add excel title
     * @author Khin Yadanar Khant
     * @date 28/08/2020
     */
    public function title(): string 
	{
   		return 'Employees';
    }

    /**
     * To add heading color in excel
     * @author Khin Yadanar Khant
     * @date 31/08/2020
     */
    use RegistersEventListeners;
    public static function afterSheet(AfterSheet $event)
    {       
        $sheet = $event->sheet->getDelegate();
        $sheet->getStyle('A1:K1')->getFont()->setSize(12);
        $sheet->getStyle('A1:K1')->getFill()
              ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
              ->getStartColor()->setARGB('FA8072');
    }
}
