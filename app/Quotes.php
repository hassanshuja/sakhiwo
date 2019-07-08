<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Quotes extends Model
{
  protected $table = 'quotes';
  
  protected $dates = [
	'quotation_date',
	'capturing_date',
	'approved_date',
	'reject_internal_date',
	'reject_vetting_date',
	'vetting_date',
	'corrected_date',
	'invoiced_date',
	'created_at',
	'updated_at'
  ];
  
  protected $fillable = [
  	'job_card_number',
  	'problem_type',
  	'sub_district',
  	'facility_name',
  	'description'
  ];  
}

