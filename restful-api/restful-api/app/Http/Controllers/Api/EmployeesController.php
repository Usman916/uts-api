<?php

namespace App\Http\Controllers\Api;

//import Model "Employees"
use App\Models\Employees;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//import Resource "PostResource"
use App\Http\Resources\EmployeesResource;
//import Facade "Validator"
use Illuminate\Support\Facades\Validator;


class EmployeesController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all posts
        $employeest = Employees::latest()->paginate(5);

        //return collection of posts as a resource
        return new EmployeesResource(true, 'List Data Employees', $employeest);
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'name'     => 'required|peg,png,jpg,gif,svg|max:2048',
            'gender'   => 'required',
            'phone'   => 'required',
            'addres'   => 'required',
            'email'   => 'required',
            'status'   => 'required',
            
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        $name = $request->file('name');
        $name->storeAs('public/employees', $name->hashName());

        //create post
        $employees = Employees::create([
            'image'     => $name->hashName(),
            'name'     => $request->name,
            'gender'     => $request->gender,
            'phone'   => $request->phone,
            'addres'   => $request->addres,
            'email'   => $request->email,
            'status'   => $request->status,
        ]);

        //return response
        return new EmployeesResource(true, 'Data Post Berhasil Ditambahkan!', $employees);
    }
}