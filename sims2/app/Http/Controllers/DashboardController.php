<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        if ($response = $this->authorizeRole('Admin')) {
            return $response;
        }
        return view('admin.dashboard');
    }

    public function staffDashboard()
    {
        if ($response = $this->authorizeRole('Staff')) {
            return $response;
        }
        return view('staff.dashboard');
    }

    public function reports()
    {
        if ($response = $this->authorizeRole('Admin')) {
            return $response;
        }

        return view('admin.reports');
    }

    public function pos()
    {
        if ($response = $this->authorizeRole('Admin')) {
            return $response;
        }

        return view('admin.pos');
    }

    public function staffTasks()
    {
        if ($response = $this->authorizeRole('Staff')) {
            return $response;
        }

        return view('staff.tasks');
    }

    public function staffScan()
    {
        if ($response = $this->authorizeRole('Staff')) {
            return $response;
        }

        return view('staff.scan');
    }

    public function staffReport()
    {
        if ($response = $this->authorizeRole('Staff')) {
            return $response;
        }

        return view('staff.report');
    }

    private function authorizeRole($role)
    {
        if (!Auth::check()) {
            return redirect('/')->with('error', 'You must be logged in.');
        }

        $userRole = Auth::user()->role ?? 'Staff';

        if ($userRole !== $role) {
            $correctDashboard = $userRole === 'Admin' ? '/admin/dashboard' : '/staff/dashboard';
            return redirect($correctDashboard)->with('error', 'Access denied for this account.');
        }
    }
}
