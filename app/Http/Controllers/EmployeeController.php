<?php

namespace App\Http\Controllers;

use App\Helpers\PaginateCollection;
use App\Http\Requests\EmployeeRequest;
use App\Models\Certificate;
use App\Models\Education;
use App\Models\Employee;
use App\Models\Family;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EmployeeController extends Controller
{
    private $employee, $family, $education, $certificate;
    private $marital_status, $religion_status, $blood_type;
    public function __construct(Employee $employee = null, Family $family, Education $education, Certificate $certificate)
    {
        $this->employee = $employee;
        $this->family = $family;
        $this->education = $education;
        $this->certificate = $certificate;
        $this->marital_status = (object)config('employee.marital_status');
        $this->religion_status = (object)config('employee.religion_status');
        $this->blood_type = (object)config('employee.blood_type');
    }
    public function index()
    {
        $this->authorize('view', Employee::class);
        $employees = $this->employee->getEmployees();
        return view('employees.index', compact('employees'));
    }
    public function create()
    {
        $this->authorize('create', Employee::class);
        $religions = $this->religion_status;
        $maritals = $this->marital_status;
        $blood_type = $this->blood_type;
        return view('employees.create', compact('religions', 'maritals', 'blood_type'));
    }
    public function store(EmployeeRequest $req)
    {
        $this->authorize('create', Employee::class);
        $validated = $req->validated();
        try {
            Employee::create($validated);
            if (url()->current() == route('register.store')) {
                return redirect()->route('login')->with('system_success', 'Data successfully registered, wait for further information from PT Kawan Kerja Indonesia');
            } else {
                return redirect()->route('employees')->with('system_success', 'Successfully added a new employee');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->withErrors(['system_error' => systemMessage("Add employee data is failed!", $th->getMessage(),)]);
        }
    }
    public function edit($id)
    {
        $employee = $this->employee->showEmployee($id);
        $this->authorize('update', $employee);
        $family = $this->family->getFamily($employee->id);
        $educations = $this->education->getEducations($id);
        $certificates = $this->certificate->getCertificates($id);
        $religions = $this->religion_status;
        $maritals = $this->marital_status;
        $blood_type = $this->blood_type;

        session(['employee_id' => $id]); //using for manage relation data

        return view('employees.edit', compact('employee', 'educations', 'certificates', 'religions', 'maritals', 'blood_type', 'family'));
    }
    public function update(Employee $employee, EmployeeRequest $req)
    {
        $this->authorize('update', $employee);
        $validated = $req->validated();
        try {
            $employee->update($validated);
            return redirect()->route('employees.edit', ['employee' => $employee->id])->with('system_success', 'Employee profile has updated');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->withErrors(['system_error' => systemMessage($th->getMessage(), "Update employee data is failed!")]);
        }
    }
    public function destroy(Employee $employee)
    {
        $this->authorize('delete', Employee::class);
        try {
            $employee->update(['deleted_by' => auth()->user()->id]);
            $employee->delete();
            return redirect()->route('employees')->with('system_success', 'Employee data has deleted');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['system_error' => systemMessage($th->getMessage(), "Delete employee data is failed!")]);
        }
    }
}
