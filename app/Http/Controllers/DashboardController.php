<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class DashboardController extends Controller
{
      public function chart()
      {
      

         $chart_option1 = [
               'chart_title' => 'عدد مبالغ فواتير حسب الحالة',
               'report_type' => 'group_by_string',
               'model' => 'App\Models\invoices',
               'group_by_field' => 'status',
               'chart_type' => 'bar',
               'colors' => ['#28a745', '#dc3545', '#ffc107'],
         ];
         $chart1 = new LaravelChart($chart_option1);


         $chart_option2= [
            'chart_title' => 'نسب المبالغ حسب الحالة',
            'report_type' => 'group_by_string',
            'model' => 'App\Models\invoices',
            'group_by_field' => 'status',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'total',
            'chart_type' => 'pie',
            'colors' => ['#28a745', '#dc3545', '#ffc107'],
      ];
      $chart2 = new LaravelChart($chart_option2);

      $chart_option3 = [
         'chart_title' => 'عددالفواتير لكل شهر',
         'report_type' => 'group_by_date',
         'model' => 'App\Models\invoices',
         'group_by_field' => 'created_at', 
         'group_by_period' => 'month',
         'chart_type' => 'line',
         'colors' => ['#6610f2'],
     ];
     $chart3 = new LaravelChart($chart_option3);

     $chart_option4 = [
      'chart_title' => 'إجمالي المبالغ لكل شهر',
      'report_type' => 'group_by_date',
      'model' => 'App\Models\invoices',
      'group_by_field' => 'created_at',
      'group_by_period' => 'month',
      'aggregate_function' => 'sum',
      'aggregate_field' => 'total',
      'chart_type' => 'line',
      'colors' => ['#6f42c1'],
  ];
  $chart4 = new LaravelChart($chart_option4);
  
      
         return view('dashboard', compact( 'chart1', 'chart2', 'chart3','chart4'));
      }
   }
